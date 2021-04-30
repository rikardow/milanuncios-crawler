<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdCategory;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('text');
        $category = $request->query('category');
        $freeShipping = $request->boolean('freeShipping');

        $results = Ad::query();

        if (!empty($search)) {
            $results = $results->where('title', 'like', "%$search%")->orWhere('description');
        }

        if ($category != 'all') {
            $results = $results->where('category_id', '=', $category);
        }

        if ($freeShipping) {
            $results = $results->where('free_shipping', '=', $freeShipping);
        }

        $results = $results
            ->orderBy('id', 'desc')
            ->take(30)
            ->get();

        $categories = AdCategory::all();

        return view('search', [
            'results' => $results,
            'categories' => $categories,
            'search' => ['text' => $search, 'category' => $category, 'freeShipping', $freeShipping]
        ]);
    }
}
