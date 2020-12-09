<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    /**
     * List banners
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $banners = Banner::all();
        return view('admin.pages.banners.index', compact('banners'));
    }
}
