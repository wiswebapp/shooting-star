<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOpenCallForm;
use App\Models\OpenCall;
use App\Models\OpenCallFormField;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OpenCallFormController extends Controller
{
    protected $fieldType = ['text', 'number', 'email', 'password', 'textarea', 'select', 'multiselect', 'image', 'file'];

    public function index(Request $request, $openCallId): View
    {
        $data = [
            'openCall' => OpenCall::findOrFail($openCallId),
            'openCallId' => $openCallId,
            'fields' => OpenCallFormField::where('open_call_id', $openCallId)->paginate(),
        ];

        return view('admin.opencall.form.index', compact('data'));
    }

    public function create($openCallId): View
    {
        $data = [
            'action' => "Add",
            'method' => "POST",
            'openCallId' => $openCallId,
            'field_type' => $this->fieldType,
            'formUrl' => route('admin.opencall.opencall-form.store', $openCallId),
        ];

        return view('admin.opencall.form.create', compact('data'));
    }

    public function store(CreateOpenCallForm $request, $openCallId): RedirectResponse
    {
        $data = array_merge(['open_call_id' => $openCallId], $request->validated());
        $data['field_name'] = Str::slug($data['field_name']);
        OpenCallFormField::create($data);

        return to_route('admin.opencall.opencall-form.index', $openCallId)->with('success', 'Data Added Successfully !');
    }

    public function edit($id, $openCallFormId): View
    {
        $opencallFormField = OpenCallFormField::findOrFail($openCallFormId);
        $data = [
            'action' => "Edit",
            'method' => "PUT",
            'openCallId' => $id,
            'field_type' => $this->fieldType,
            'opencallForm' => $opencallFormField,
            'formUrl' => route('admin.opencall.opencall-form.update', [
                $id,
                $opencallFormField['id']
            ]),
        ];

        return view('admin.opencall.form.create', compact('data'));
    }

    public function update(CreateOpenCallForm $request, $id, $openCallFormId): RedirectResponse
    {
        $opencallFormField = OpenCallFormField::findOrFail($openCallFormId);
        $data = [...['open_call_id' => $id], ...$request->validated()];
        $data['field_name'] = Str::slug($data['field_name']);
        $opencallFormField->update($data);

        return to_route('admin.opencall.opencall-form.index', $id)->with('success', 'Data Updated Successfully !');
    }

    public function destroy($id, $openCallFormId): RedirectResponse
    {
        $opencallFormField = OpenCallFormField::findOrFail($openCallFormId);
        $opencallFormField->delete();

        return to_route('admin.opencall.opencall-form.index', $id)->with('success', 'Data Updated Successfully !');
    }
}
