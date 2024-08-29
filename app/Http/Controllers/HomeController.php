<?php

namespace App\Http\Controllers;

use App\Models\Orders;
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getProducts()
    {
        $products = Product::all(); // Mengambil semua data produk

        return view('welcome', compact('products')); // Mengirim data produk ke view welcome
    }

    public function beli($id)
    {
        if (!Auth::user()) {

            return redirect()->route('login');
        }

        $product = Product::find($id);

        Orders::create([

            'user_id' => Auth::user()->id,
            'total_harga' => $product->harga,
            'produk_id' => $product->id,
            'status' => 0
        ]);
    }
}
