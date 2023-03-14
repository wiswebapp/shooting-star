<?php

namespace App\Http\Controllers;

use App\Models\OpenCall;
use Illuminate\View\View;
use App\Http\Requests\CreateOpenCallUserForm;
use App\Services\OpenCallFormService;
use Illuminate\Http\RedirectResponse;

class OpenCallUserFormController extends Controller
{

    public function __construct(private OpenCallFormService $openCallUserFormService) {
        $this->openCallUserFormService = $openCallUserFormService;
    }

    public function index(OpenCall $opencall): View
    {
        return view('opencall_form', [
            'pageName' => $opencall->title,
            'opencall' => $opencall,
            'opencallList' => OpenCall::where('end_date', '>=', date('Y-m-d'))->where('status', 'Active')->get(),
            'customField' => $opencall->formfield->where('status', 'Active'),
        ]);
    }

    public function store(CreateOpenCallUserForm $request): RedirectResponse
    {
        $this->openCallUserFormService->store($request->validated(), $request->file('art_work_image'));
        return redirect(route('opencall.thanks'));
    }

    public function show(): View
    {
        return view('opencall_form_thank_you');
    }

}
