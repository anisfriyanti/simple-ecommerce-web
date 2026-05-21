<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->get();

        return view(
            'admin.products.index',
            compact('products')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view(
            'admin.products.create',
            compact('categories')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // VALIDATION
        $request->validate([

            'category_id' => 'required',

            'name' => 'required',

            'slug' => 'required|unique:products',

            'description' => 'required',

            'price' => 'required|numeric',

            'stock' => 'required|numeric',

            'image' => 'required|image',
        ]);

        // UPLOAD IMAGE
        $image = $request
            ->file('image')
            ->store(
                'products',
                'public'
            );

        // CREATE PRODUCT
        Product::create([

            'category_id' => $request->category_id,

            'name' => $request->name,

            'slug' => $request->slug,

            'description' => $request->description,

            'price' => $request->price,

            'stock' => $request->stock,

            'image' => $image,

            'is_featured' => $request->is_featured
                ? true
                : false,
        ]);

        return redirect(
            '/admin/products'
        )->with(
                'success',
                'Product created.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view(
            'admin.products.edit',
            compact(
                'product',
                'categories'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(
    Request $request,
    Product $product
)
{
    $request->validate([

        'category_id' => 'required',

        'name' => 'required',

        'slug' =>
            'required|unique:products,slug,' . $product->id,

        'description' => 'required',

        'price' => 'required|numeric',

        'stock' => 'required|numeric',
    ]);

    // DEFAULT IMAGE
    $image = $product->image;

    // IF NEW IMAGE
    if ($request->hasFile('image')) {

        $image = $request
            ->file('image')
            ->store(
                'products',
                'public'
            );
    }

    $product->update([

        'category_id' => $request->category_id,

        'name' => $request->name,

        'slug' => $request->slug,

        'description' => $request->description,

        'price' => $request->price,

        'stock' => $request->stock,

        'image' => $image,

        'is_featured' =>
            $request->is_featured
                ? true
                : false,
    ]);

    return redirect(
        '/admin/products'
    )->with(
        'success',
        'Product updated.'
    );
}

    /**
     * Remove the specified resource from storage.
     */
 public function destroy(Product $product)
{
    $product->delete();

    return redirect(
        '/admin/products'
    )->with(
        'success',
        'Product deleted.'
    );
}
}
