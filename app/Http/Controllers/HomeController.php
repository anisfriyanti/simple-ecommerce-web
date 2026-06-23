<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProducts = Product::where('is_featured', true)
            ->latest()
            ->take(3)
            ->get();

        return view('pages.home', compact('featuredProducts'));
    }
}
