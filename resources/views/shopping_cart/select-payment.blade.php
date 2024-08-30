<!-- resources/views/shopping-cart/select-payment.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Pilih Metode Pembayaran</h2>
        <form action="{{ route('shopping-cart.process-payment', $orderId) }}" method="POST">
            @csrf
            <!-- Midtrans payment button -->
            <button type="button" id="pay-button" class="btn btn-primary">Lakukan Pembayaran</button>
        </form>
    </div>
    @push('scripts')
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function() {
                window.snap.pay('{{ $snapToken }}'); // Ini harus berasal dari server
            };
        </script>
    @endpush
@endsection
