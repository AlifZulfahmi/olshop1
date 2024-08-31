@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card">
            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                <p>Anda akan melakukan pembelian produk <strong>{{ $product->name }}</strong> dengan harga
                    <strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong>
                </p>
                <button type="button" class="btn btn-primary mt-3" id="pay-button">
                    Bayar Sekarang
                </button>
                <pre id="result-json"></pre> <!-- Optional: Display payment result -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            var snapToken = '{{ $transaction->snap_token }}'; // Pastikan token benar
            if (!snapToken) {
                console.error('Snap Token not found.');
                return;
            }

            snap.pay(snapToken, {
                onSuccess: function(result) {
                    // Handle successful payment
                    console.log('Payment Success:', result);
                    document.getElementById('result-json').innerHTML = JSON.stringify(result, null, 2);
                    // Optionally send a request to your server to update transaction status
                },
                onPending: function(result) {
                    // Handle payment pending
                    console.log('Payment Pending:', result);
                    document.getElementById('result-json').innerHTML = JSON.stringify(result, null, 2);
                    // Optionally send a request to your server to update transaction status
                },
                onError: function(result) {
                    // Handle payment error
                    console.log('Payment Error:', result);
                    document.getElementById('result-json').innerHTML = JSON.stringify(result, null, 2);
                    // Optionally send a request to your server to update transaction status
                }
            });
        };
    </script>
@endsection
