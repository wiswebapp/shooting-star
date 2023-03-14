<?php

namespace App\Http\Controllers\Admin;

use App\Models\OpenCall;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOpenCall;
use App\Repositories\UploadFileRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OpenCallController extends Controller
{

    public function __construct(public UploadFileRepository $uploadFileRepository)
    {
        $this->uploadFileRepository = $uploadFileRepository;
    }

    public function index(): View
    {
        $data = OpenCall::orderBy('id', 'DESC')->paginate(10);
        return view('admin.opencall.index', compact('data'));
    }

    public function create(): View
    {
        $data['action'] = "Add";
        $data['method'] = "POST";
        $data['formUrl'] = route('admin.opencall.store');

        return view('admin.opencall.create', compact('data'));
    }

    public function store(CreateOpenCall $request): RedirectResponse
    {
        $data = $request->validated();
        if ($file = $request->file('cover_image')) {
            $data['cover_image'] = $this->uploadFileRepository->uploadFile('opencall', $file);
        }
        OpenCall::create($data);

        return to_route('admin.opencall.index')->with('success', 'Data Added Successfully !');
    }

    public function show(OpenCall $opencall): View
    {
        return view('admin.opencall.show', compact('opencall'));
    }

    public function edit(OpenCall $opencall): View
    {
        $data['action'] = "Edit";
        $data['method'] = "PUT";
        $data['opencall'] = $opencall;
        $data['formUrl'] = route('admin.opencall.update', $opencall['id']);

        return view('admin.opencall.create', compact('data'));
    }

    public function update(CreateOpenCall $request, OpenCall $opencall): RedirectResponse
    {
        $data = $request->validated();
        if ($file = $request->file('cover_image')) {
            $this->uploadFileRepository->removeFile(Opencall::UPLOAD_PATH, $opencall->cover_image);
            $data['cover_image'] = $this->uploadFileRepository->uploadFile('opencall', $file);
        }
        $opencall->update($data);

        return to_route('admin.opencall.index')->with('success', 'Data Updated Successfully !');
    }

    public function destroy(OpenCall $opencall): RedirectResponse
    {
        $path = public_path(OpenCall::UPLOAD_PATH);
        $this->uploadFileRepository->removeFile($path, $opencall->cover_image, true);
        $opencall->delete();

        return to_route('admin.opencall.index')->with('success', 'Data Updated Successfully !');
    }
}
