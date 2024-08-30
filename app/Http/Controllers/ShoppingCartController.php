<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Transaction;
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
        return view('shopping-cart.index', compact('orders'));
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

        // Cek ID produk yang diterima
        \Log::info('Attempting to remove product from cart', ['product_id' => $id]);

        // Temukan order berdasarkan user_id dan produk_id
        $order = Order::where('user_id', Auth::id())->where('produk_id', $id)->first();

        if (!$order) {
            // Log error jika produk tidak ditemukan
            \Log::warning('Product not found in cart', ['user_id' => Auth::id(), 'product_id' => $id]);
            return redirect()->back()->with('error', 'Product not found in cart');
        }

        // Hapus order
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

        return redirect()->route('shopping-cart.select_payment')->with('success', 'Quantity updated successfully');
    }



    public function selectPayment($id)
    {
        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION') === 'true';
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

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
                'order_id' => $order->id, // ID order
                'gross_amount' => $order->total_harga,
            ],
            'customer_details' => [
                'first_name' => 'Saudara...',
                'last_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        // Buat Snap Token
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate Snap Token: ' . $e->getMessage());
        }

        // Kirim token dan orderId ke view
        return view('shopping-cart.select_payment', [
            'snapToken' => $snapToken,
            'orderId' => $order->id // Mengirimkan orderId ke view
        ]);
    }



    public function processPayment(Request $request, $id)
    {
        // Temukan pesanan berdasarkan ID
        $order = Order::find($id);

        // Cek apakah pesanan ditemukan
        if (!$order) {
            return redirect()->route('shopping-cart.index')->with('error', 'Order not found.');
        }

        // Ambil Snap Token dari query string
        $snapToken = $request->input('snap_token');

        // Cek apakah Snap Token ditemukan
        if (!$snapToken) {
            return redirect()->back()->with('error', 'Snap Token not found.');
        }

        // Verifikasi transaksi di Midtrans
        try {
            $transactionStatus = \Midtrans\Transaction::status($order->id);

            // Cek status transaksi
            if ($transactionStatus->transaction_status === 'settlement') {
                // Pembayaran telah berhasil
                $order->status = 1; // Atur status pesanan sesuai kebutuhan
                $order->save();
                return redirect()->route('shopping-cart.index')->with('success', 'Payment successful.');
            } else {
                return redirect()->route('shopping-cart.index')->with('error', 'Payment status: ' . $transactionStatus->transaction_status);
            }
        } catch (\Exception $e) {
            \Log::error('Payment verification failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }
}
