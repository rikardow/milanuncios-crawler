<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdCategory;
use Illuminate\Http\Request;

class AdDetailsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(int $id)
    {
        $ad = Ad::findOrFail($id);
        $categories = AdCategory::all();
        return view('details', ['ad' => $ad, 'categories' => $categories]);
    }
}
