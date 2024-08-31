<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;

class shopController extends Controller
{
    public function index(Request $request)
    {

        $categories = Category::all();

        // Filter produk berdasarkan kategori yang dipilih
        // $products = Product::when($request->category, function ($query) use ($request) {
        //     $query->whereIn('category_id', $request->category);
        // })->latest()->paginate(12);

        $products = Product::filter(request(['search', 'category']))->latest()->paginate(12);

        // $filter = Product::filter()->latest()->get();
    
        return view('shop', compact('products', 'categories'));
    }
}
