<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Exhibition;
use Illuminate\Http\Request;
use App\Models\ExhibitionImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateExhibition;
use App\Repositories\UploadFileRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExhibitionController extends Controller
{

    public function __construct(public UploadFileRepository $uploadFileRepository)
    {
        $this->uploadFileRepository = $uploadFileRepository;
    }

    public function index(): View
    {
        $data = Exhibition::orderBy('id', 'DESC')->paginate(10);
        return view('admin.exhibition.index', compact('data'));
    }

    public function create(): View
    {
        $data['action'] = "Add";
        $data['method'] = "POST";
        $data['category'] = Category::where('status', 'Active')->get();
        $data['formUrl'] = route('admin.exhibition.store');

        return view('admin.exhibition.create', compact('data'));
    }


    public function store(CreateExhibition $request): RedirectResponse
    {
        $data = $request->validated();
        if ($file = $request->file('cover_image')) {
            $data['cover_image'] = $this->uploadFileRepository->uploadFile('exhibition_cover', $file, );
        }
        Exhibition::create($data);

        return to_route('admin.exhibition.index')->with('success', 'Data Added Successfully !');
    }

    public function show(Exhibition $exhibition): View
    {
        return view('admin.exhibition.show', compact('exhibition'));
    }

    public function edit(Exhibition $exhibition): View
    {
        $data['action'] = "Edit";
        $data['method'] = "PUT";
        $data['exhibition'] = $exhibition;
        $data['category'] = Category::where('status', 'Active')->get();
        $data['formUrl'] = route('admin.exhibition.update', $exhibition['id']);

        return view('admin.exhibition.create', compact('data'));
    }

    public function update(CreateExhibition $request, Exhibition $exhibition): RedirectResponse
    {
        $data = $request->validated();
        if ($file = $request->file('cover_image')) {
            $this->uploadFileRepository->removeFile(Exhibition::UPLOAD_COVER_PATH, $exhibition->cover_image);
            $data['cover_image'] = $this->uploadFileRepository->uploadFile('exhibition_cover', $file);
        }
        $exhibition->update($data);

        return to_route('admin.exhibition.index')
            ->with('success', 'Data Updated Successfully !');
    }

    public function destroy(Exhibition $exhibition): RedirectResponse
    {
        $path = public_path(Exhibition::UPLOAD_COVER_PATH);
        $this->uploadFileRepository->removeFile($path, $exhibition->cover_image, true);
        $exhibition->delete();

        return to_route('admin.exhibition.index')->with('success', 'Data Updated Successfully !');
    }

    public function gallery(Exhibition $exhibition): View
    {
        $data['exhibition'] = $exhibition;
        return view('admin.exhibition.gallery.index', compact('data'));
    }

    public function upload(Request $request, Exhibition $exhibition): JsonResponse
    {
        $imageSize = $request->file('file')->getSize();
        $imageName = $this->uploadFileRepository->uploadFile(
            'exhibition',
            $request->file('file'),
            $exhibition->id
        );

        $imageUpload = new ExhibitionImage();
        $imageUpload->exhibition_id = $exhibition->id;
        $imageUpload->filename = $imageName;
        $imageUpload->file_size = $imageSize;
        $imageUpload->save();

        return response()->json([
            'success'=>$imageName
        ]);
    }

    /**
     * Delete Upload images.
     *
     * @param App\Models\Exhibition $exhibition
     * @return json
     */
    public function removeUpload(Request $request, Exhibition $exhibition): JsonResponse
    {
        $path = public_path(Exhibition::UPLOAD_PATH.$exhibition->id);
        $this->uploadFileRepository->removeFile($path, $request->file_name, true);
        $data = ExhibitionImage::where('filename', $request->file_name);
        $data->delete();

        return response()->json([
            'success' => $request->file_name
        ]);
    }
}
