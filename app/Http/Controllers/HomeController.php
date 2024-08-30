<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::all(); // Mengambil semua data produk

        return view('home', compact('products')); // Mengirim data produk ke view home
    }

    public function getProducts()
    {
        $products = Product::all(); // Mengambil semua data produk

        return view('welcome', compact('products')); // Mengirim data produk ke view welcome
    }

    public function beli($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        Order::create([
            'user_id' => Auth::user()->id,
            'total_harga' => $product->price,
            'produk_id' => $product->id,
            'status' => 0
        ]);

        return redirect()->back()->with('success', 'Product purchased successfully!');
    }
}
