@extends('layouts.LandingApp')

@section('title', 'Checkout')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card">
            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                @if ($product)
                    <p>Anda akan melakukan pembelian produk <strong>{{ $product->name }}</strong> dengan harga
                        <strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong>
                    </p>
                @else
                    <p>Produk tidak ditemukan.</p>
                @endif
                <button type="button" class="btn btn-primary mt-3" id="pay-button">
                    Bayar Sekarang
                </button>
                <pre id="result-json"></pre>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            var snapToken = '{{ $transaction->snap_token ?? '' }}';
            if (snapToken) {
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        document.getElementById('result-json').innerHTML = JSON.stringify(result, null, 2);
                    },
                    onPending: function(result) {
                        document.getElementById('result-json').innerHTML = JSON.stringify(result, null, 2);
                    },
                    onError: function(result) {
                        document.getElementById('result-json').innerHTML = JSON.stringify(result, null, 2);
                    }
                });
            } else {
                console.error('Snap Token tidak ditemukan');
            }
        };
    </script>
@endsection
