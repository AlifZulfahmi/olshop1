<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UserProductController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori
        $categories = Category::all();

        // Filter produk berdasarkan kategori yang dipilih
        $products = Product::when($request->category, function ($query) use ($request) {
            $query->whereIn('category_id', $request->category);
        })->get();

        return view('shop', compact('products', 'categories'));
    }

    public function detail($id)
    {
        $product = Product::with('category')->findOrFail($id);

        $randomProducts = Product::where('id', '!=', $id)
            ->inRandomOrder()
            ->limit(4) // Sesuaikan jumlah produk yang ingin ditampilkan
            ->get();

        // Mengirim data ke view
        return view('detail', compact('product', 'randomProducts'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Logika untuk menambahkan produk ke session cart
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
        ]);
    }

    public function show()
    {
        $cart = session()->get('cart', []);
        $products = \App\Models\Product::whereIn('id', array_keys($cart))->get();

        return view('cart', compact('products', 'cart'));
    }
    
    public function remove($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }
}
