<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        $productIds = $request->input('product_ids', []);
        $quantities = $request->input('quantities', []);

        // Validasi jumlah produk dan kuantitas
        if (!is_array($productIds) || !is_array($quantities) || count($productIds) !== count($quantities)) {
            return redirect()->back()->with('error', 'Jumlah produk dan kuantitas tidak sesuai.');
        }


        $totalPrice = 0;
        $transactions = [];

        foreach ($productIds as $index => $productId) {
            $quantity = $quantities[$index];

            // Temukan pesanan berdasarkan produk_id dan user_id
            $order = Order::where('produk_id', $productId)
                ->where('user_id', Auth::user()->id)
                ->first();

            if (!$order) {
                return redirect()->back()->with('error', 'Order dengan produk_id ' . $productId . ' tidak ditemukan.');
            }

            // Hitung total harga untuk produk ini
            $totalPrice += $order->total_harga * $quantity;

            // Buat transaksi baru untuk setiap produk
            $transaction = Transaction::create([
                'user_id' => Auth::user()->id,
                'product_id' => $productId,
                'price' => $order->total_harga * $quantity,
                'status' => 'pending',
            ]);

            $transactions[] = $transaction;
        }

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        // Siapkan parameter untuk Snap Token
        $params = [
            'transaction_details' => [
                'order_id' => uniqid(), // Menggunakan ID unik
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat Snap Token: ' . $e->getMessage());
        }

        // Simpan Snap Token untuk setiap transaksi
        foreach ($transactions as $transaction) {
            $transaction->snap_token = $snapToken;
            $transaction->save();
        }

        return redirect()->route('checkout.show', ['transactionId' => $transactions[0]->id]);
    }

    public function showCheckout($transactionId)
    {
        $transaction = Transaction::find($transactionId);

        if (!$transaction) {
            return redirect()->route('home')->with('error', 'Transaction not found.');
        }

        $product = $transaction->product;

        if (!$product) {
            return redirect()->route('home')->with('error', 'Product not found for this transaction.');
        }

        return view('checkout', [
            'transaction' => $transaction,
            'product' => $product
        ]);
    }
}
