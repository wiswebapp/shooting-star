<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Exhibition;
use App\Models\OpenCall;
use App\Models\Page;
use App\Models\Shop;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('index', [
            'pageName' => 'Home',
            'pageData' => Page::findOrFail(3),
            'artistData' => Artist::where('status', 'active')->limit(12)->get(),
        ]);
    }

    public function about(): View
    {
        return view('about', [
            'pageName' => 'About us',
            'pageData' => Page::findOrFail(1),
        ]);
    }

    public function artist(): View
    {
        return view('artists', [
            'pageName' => 'Artists',
            'pageData' => Artist::where('status', 'Active')->get(),
        ]);
    }

    public function artist_detail(Artist $artist): View
    {
        return view('artists_detail', [
            'pageName' => $artist->artist_name,
            'pageData' => Artist::with('shop')->where('id', $artist->id)->first(),
        ]);
    }

    public function exhibition(): View
    {
        $pageData = Exhibition::where('status', 'Active')->orderBy('start_date', 'desc')->get();

        $pageData->reject(function ($data) {
            if ($data->start_date <= date('Y-m-d') && $data->end_date >= date('Y-m-d'))
                return true;
        })->map(function ($data) {
            $data->isExpired = false;
            if ($data->end_date < date('Y-m-d')) {
                $data->isExpired = true;
            }
        });

        return view('exhibition', [
            'pageName' => 'Exhibitions',
            'pageData' => $pageData,
            'activeExhibition' => Exhibition::where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->where('status', 'Active')->first(),
        ]);
    }

    public function exhibition_detail(Exhibition $exhibition): View
    {
        return view('exhibition_detail', [
            'pageName' => $exhibition->title,
            'exhibition' => $exhibition,
        ]);
    }

    public function shop(Request $request): View
    {
        $shopData = Shop::with('artist')->where('status', 'Active');

        if ($request->search) {
            $shopData->where('item_title', 'LIKE', '%'. $request->search .'%');
        }
        if ($request->artist) {
            $shopData->where('artist_id', $request->artist);
        }

        return view('shop', [
            'pageName' => 'Shop',
            'artistData' => Artist::where('status', 'Active')->get(),
            'pageData' => $shopData->get(),
            'search' => [
                'keyword' => $request->search,
                'artistId' => $request->artist,
            ],
        ]);
    }

    public function opencall(): View
    {
        return view('opencall', [
            'pageName' => 'Open Call',
            'pageData' => OpenCall::where('end_date', '>=', date('Y-m-d'))->where('status', 'Active')->get(),
        ]);
    }

    public function contact(): View
    {
        return view('contact', [
            'pageName' => 'Contact',
            'pageData' => Page::findOrFail(2),
        ]);
    }

    public function subscribe(Request $request)
    {
        Subscription::updateOrCreate([
                'email' => $request->email,
            ],
            [
            'email' => $request->email,
            'ip_address' => $request->ip(),
        ]);

        return Redirect::back()->with('success', 'Successfully subscribed');
    }

}
