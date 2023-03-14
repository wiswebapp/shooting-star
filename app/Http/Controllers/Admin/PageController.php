<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Http\Requests\CreatePage;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{

    public function index(): View
    {
        $data = Page::orderBy('title', 'ASC')->paginate(10);
        return view('admin.pages.index', compact('data'));
    }

    public function create(): View
    {
        $data['action'] = "Add";
        $data['method'] = "POST";
        $data['formUrl'] = route('admin.pages.store');

        return view('admin.pages.create', compact('data'));
    }

    public function store(CreatePage $request): RedirectResponse
    {
        Page::create($request->validated());
        return to_route('admin.pages.index')->with('success', 'Data Added Successfully !');
    }

    public function show(Page $page): View
    {
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page): View
    {
        $data['action'] = "Edit";
        $data['method'] = "PUT";
        $data['formUrl'] = route('admin.pages.update', $page['id']);
        $data['page'] = $page;

        return view('admin.pages.create', compact('data'));
    }

    public function update(CreatePage $request, Page $page): RedirectResponse
    {
        $page->update($request->validated());
        return to_route('admin.pages.index')->with('success', 'Data Updated Successfully !');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();
        return to_route('admin.pages.index')->with('success', 'Data Updated Successfully !');
    }
}
