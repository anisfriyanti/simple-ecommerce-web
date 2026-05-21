<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Product::query();

    // FILTER CATEGORY
    if ($request->category) {

        $query->whereHas(
            'category',
            function ($q) use ($request) {

                $q->where(
                    'slug',
                    $request->category
                );
            }
        );
    }

    $products = $query
        ->latest()
        ->get();

    $categories = Category::all();

    return view(
        'pages.products',
        compact(
            'products',
            'categories'
        )
    );
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
   public function show($slug)
{
    $product = Product::with('category')
        ->where('slug', $slug)
        ->firstOrFail();

    return view(
        'pages.product-detail',
        compact('product')
    );
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
