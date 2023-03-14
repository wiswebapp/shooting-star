<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArtist;
use App\Models\Artist;
use App\Models\ArtistImage;
use App\Repositories\UploadFileRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArtistController extends Controller
{

    public function __construct(public UploadFileRepository $uploadFileRepository)
    {
        $this->uploadFileRepository = $uploadFileRepository;
    }

    public function index(): View
    {
        return view('admin.artist.index', [
            'artist' => Artist::orderBy('id', 'desc')->paginate(10)
        ]);
    }

    public function create(): View
    {
        return view('admin.artist.create', [
            'action' => "Add",
            'method' => "POST",
            'formUrl' => route('admin.artist.store'),
        ]);
    }

    public function store(CreateArtist $request): RedirectResponse
    {
        $data = $request->validated();
        if ($file = $request->file('cover_image')) {
            $data['artist_cover_image'] = $this->uploadFileRepository->uploadFile('artist_cover', $file, );
        }
        Artist::create($data);

        return to_route('admin.artist.index')->with('success', 'Data Added Successfully !');
    }

    public function edit(Artist $artist): View
    {
        return view('admin.artist.create', [
            'action' => 'Edit',
            'method' => 'PUT',
            'artist' => $artist,
            'formUrl' => route('admin.artist.update', $artist['id']),
        ]);
    }

    public function update(CreateArtist $request, Artist $artist): RedirectResponse
    {
        $data = $request->validated();
        if ($file = $request->file('cover_image')) {
            $this->uploadFileRepository->removeFile(Artist::UPLOAD_COVER_PATH, $artist->artist_cover_image);
            $data['artist_cover_image'] = $this->uploadFileRepository->uploadFile('artist_cover', $file);
        }
        $artist->update($data);

        return to_route('admin.artist.index')->with('success', 'Data Updated Successfully !');
    }

    public function destroy(Artist $artist): RedirectResponse
    {
        $path = public_path(Artist::UPLOAD_COVER_PATH);
        $this->uploadFileRepository->removeFile($path, $artist->artist_cover_image, true);
        $artist->delete();

        return to_route('admin.artist.index')->with('success', 'Data Updated Successfully !');
    }

    public function gallery(Artist $artist): View
    {
        return view('admin.artist.gallery.index', [
            'artist' => $artist
        ]);
    }

    public function upload(Request $request, Artist $artist): JsonResponse
    {
        $imageSize = $request->file('file')->getSize();
        $imageName = $this->uploadFileRepository->uploadFile(
            'artist',
            $request->file('file'),
            $artist->id
        );

        $imageUpload = new ArtistImage();
        $imageUpload->artist_id = $artist->id;
        $imageUpload->title = $imageName;
        $imageUpload->filename = $imageName;
        $imageUpload->file_size = $imageSize;
        $imageUpload->save();

        return response()->json([
            'success'=>$imageName
        ]);
    }

    public function removeUpload(Request $request, Artist $artist): JsonResponse
    {
        $path = public_path(Artist::UPLOAD_PATH.$artist->id);
        $this->uploadFileRepository->removeFile($path, $request->file_name, true);
        $data = ArtistImage::where('filename', $request->file_name);
        $data->delete();

        return response()->json([
            'success' => $request->file_name
        ]);
    }
}
