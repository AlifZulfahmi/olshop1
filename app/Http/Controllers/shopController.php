<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class shopController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['products', 'subCategories as sub_products_count' => function ($query) {
            $query->withCount('products');
        }])
        ->with(['subCategories' => function ($query) {
            $query->withCount('products');
        }])
        ->get();
    
        $products = Product::with('category')->paginate(12);
    
        return view('shop', compact('products', 'categories'));
    }
}
