<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $recentAds = Ad::getRecent();
        $categories = AdCategory::all();
        return view('home', ['recentAds' => $recentAds, 'categories' => $categories]);
    }
}
