<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function products(Request $request)
    {
        $section = null;
        $rows = 20;
        $cols = 5;
        $per_page = $request->get('per_page', $rows * $cols);
        $products = Product::when($request->search, function ($query) use ($request) {
            $query->search($request->search, null, true);
        })
            ->latest('id')
            ->paginate($per_page)
            ->onEachSide(1)
            ->appends(request()->query());

        return view('products.index', compact('products', 'per_page', 'rows', 'cols', 'section'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug, ?Category $category)
    {
        $products = Product::latest();
        if ($request->has('s')) {
            $products = $products->where('name', 'like', '%'.$request->s.'%');
        } elseif ($category->getKey()) {
            $products = $category->products()->latest();
        }
        // if($category->getKey()) {
        //     $products = $category->products();
        // } else {
        //     $products = Product::latest();
        // }
        // $products = $request->has('s') ? $products->where('name', 'like', '%' . $request->s . '%') : $products;
        // $products_count = $products->count();
        $products = $products->paginate(24)->appends($request->query());

        return view('reseller.products.index', compact('products'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('reseller.products.product', compact('product'));
    }
}
