<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;

class ShoppingCartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $orders = Order::where('user_id', Auth::id())->get();
        return view('shopping_cart.index', compact('orders'));
    }

    public function addToCart($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        // Periksa apakah produk sudah ada di keranjang
        $order = Order::where('user_id', Auth::id())->where('produk_id', $id)->first();

        if ($order) {
            // Update quantity jika produk sudah ada di keranjang
            $order->quantity += 1;
            $order->total_harga = $order->quantity * $product->price;
            $order->save();
        } else {
            // Tambahkan produk baru jika belum ada di keranjang
            Order::create([
                'user_id' => Auth::id(),
                'total_harga' => $product->price,
                'produk_id' => $product->id,
                'status' => 0,
                'quantity' => 1 // Tambahkan default quantity
            ]);
        }

        return redirect()->route('shopping-cart.index')->with('success', 'Product added to cart successfully!');
    }

    public function removeFromCart($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Order::where('user_id', Auth::id())->where('produk_id', $id)->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Product not found in cart');
        }

        $order->delete();

        return redirect()->route('shopping-cart.index')->with('success', 'Product removed from cart successfully!');
    }

    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $order = Order::findOrFail($id);
        $product = Product::findOrFail($order->produk_id);

        $order->quantity = $request->input('quantity');
        $order->total_harga = $order->quantity * $product->price;
        $order->save();

        return redirect()->route('shopping-cart.index')->with('success', 'Quantity updated successfully');
    }

    public function selectPayment($id)
    {
        // Inisialisasi konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Temukan pesanan berdasarkan ID
        $order = Order::find($id);

        // Cek apakah pesanan ditemukan
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        // Cek apakah user terkait dengan pesanan ditemukan
        if (!$order->user) {
            return redirect()->back()->with('error', 'User associated with the order not found.');
        }

        // Siapkan parameter untuk Snap Token
        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $order->total_harga,
            ],
            'customer_details' => [
                'first_name' => $order->user->name ?? 'Guest',
                'email' => $order->user->email ?? 'guest@example.com',
            ],
        ];

        // Buat Snap Token
        $snapToken = Snap::getSnapToken($params);

        // Kirim token ke view
        return view('shopping-cart.select-payment', compact('snapToken', 'id'));
    }


    public function processPayment(Request $request, $id)
    {
        // Logika untuk memproses pembayaran
        // Implementasi untuk menangani notifikasi webhook dari Midtrans
    }
}
