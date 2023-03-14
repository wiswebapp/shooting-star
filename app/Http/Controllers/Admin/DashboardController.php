<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\Exhibition;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{

    public function index(): View
    {
        $data['active_exhibition'] = Exhibition::where('status', 'Active')->count();
        $data['inactive_exhibition'] = Exhibition::where('status', 'InActive')->count();
        $data['content_page'] = Page::where('status', 'Active')->count();
        $data['exhibition_list'] = Exhibition::where('status', 'Active')->limit(10)->get();

        return view("admin.dashboard", compact('data'));
    }

}
