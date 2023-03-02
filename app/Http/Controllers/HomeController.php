<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Exhibition;
use App\Models\OpenCall;
use App\Models\Page;
use App\Models\Shop;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return view('index', [
            'pageName' => 'Home',
        ]);
    }

    public function about() {
        return view('about', [
            'pageName' => 'About us',
            'pageData' => Page::findOrFail(1),
        ]);
    }

    public function artist() {
        return view('artists', [
            'pageName' => 'Artists',
            'pageData' => Artist::where('status', 'Active')->get(),
        ]);
    }

    public function exhibition() {
        return view('exhibition', [
            'pageName' => 'Exhibitions',
            'pageData' => Exhibition::where('status', 'Active')->get(),
        ]);
    }

    public function shop(Request $request) {
        $shopData = Shop::where('status', 'Active');
        if ($request->search) {
            $shopData->where('item_title', 'LIKE', '%'. $request->search .'%');
        }
        $shopData = $shopData->get();

        return view('shop', [
            'pageName' => 'Shop',
            'pageData' => $shopData,
            'search' => $request->search,
        ]);
    }

    public function opencall() {
        $data = OpenCall::where('status', 'Active');
        $data = $data->whereDate('start_date', '>=', date('Y-m-d'))->get();

        return view('opencall', [
            'pageName' => 'Open Call',
            'pageData' => $data,
        ]);
    }

    public function contact() {
        return view('contact', [
            'pageName' => 'Contact',
            'pageData' => Page::findOrFail(2),
        ]);
    }

}
