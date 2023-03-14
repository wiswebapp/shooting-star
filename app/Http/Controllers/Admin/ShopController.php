<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateShopItems;
use App\Models\Artist;
use App\Models\Shop;
use App\Repositories\UploadFileRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function __construct(public UploadFileRepository $uploadFileRepository)
    {
        $this->uploadFileRepository = $uploadFileRepository;
    }

    public function index(): View
    {
        return view('admin.shop_item.index', [
            'shop_items' => Shop::orderBy('id', 'DESC')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.shop_item.create', [
            'action' => "Add",
            'method' => "POST",
            'artistList' => Artist::where('status', 'Active')->get(),
            'formUrl' => route('admin.shop.store'),
        ]);
    }

    public function store(CreateShopItems $request): RedirectResponse
    {
        $data = $request->validated();
        if ($file = $request->file('item_filename')) {
            $data['item_filename'] = $this->uploadFileRepository->uploadFile('shop', $file);
        }
        Shop::create($data);

        return to_route('admin.shop.index')->with('success', 'Data Added Successfully !');
    }

    public function edit(Shop $shop): View
    {
        return view('admin.shop_item.create', [
            'action' => "Edit",
            'method' => "PUT",
            'shop' => $shop,
            'artistList' => Artist::where('status', 'Active')->get(),
            'formUrl' => route('admin.shop.update', $shop['id'])
        ]);
    }

    public function update(CreateShopItems $request, Shop $shop): RedirectResponse
    {
        $data = $request->validated();
        if ($file = $request->file('item_filename')) {
            $this->uploadFileRepository->removeFile(Shop::UPLOAD_PATH, $shop->item_filename);
            $data['item_filename'] = $this->uploadFileRepository->uploadFile('shop', $file);
        }
        $shop->update($data);

        return to_route('admin.shop.index')->with('success', 'Data Updated Successfully !');
    }

    public function destroy(Shop $shop): RedirectResponse
    {
        $path = public_path(Shop::UPLOAD_PATH);
        $this->uploadFileRepository->removeFile($path, $shop->item_filename, true);
        $shop->delete();

        return to_route('admin.shop.index')->with('success', 'Data Updated Successfully !');
    }
}
