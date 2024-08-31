<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class shopController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori
        $categories = Category::all();

        // Filter produk berdasarkan kategori yang dipilih
        $products = Product::when($request->category, function ($query) use ($request) {
            $query->whereIn('category_id', $request->category);
        })->latest()->paginate(12);
    
        return view('shop', compact('products', 'categories'));
    }
}
