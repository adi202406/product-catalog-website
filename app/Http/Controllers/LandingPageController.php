<?php

namespace App\Http\Controllers;

use App\Models\ShopInfo;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $shop = ShopInfo::first();
        return view('welcome', compact('shop'));
    }
}
