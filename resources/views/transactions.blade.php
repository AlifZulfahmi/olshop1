@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Transaksi</h1>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td>
                                            {{-- Check if the product exists --}}
                                            {{ $transaction->product ? $transaction->product->name : 'Produk Tidak Ditemukan' }}
                                        </td>
                                        <td>
                                            {{-- Check if the product exists before accessing its price --}}
                                            {{ $transaction->product ? 'Rp' . number_format($transaction->product->price, 0, ',', '.') : '-' }}
                                        </td>
                                        <td>
                                            @if ($transaction->status == 'pending')
                                                <span
                                                    class="badge bg-warning text-dark">{{ ucfirst($transaction->status) }}</span>
                                            @elseif ($transaction->status == 'success')
                                                <span class="badge bg-success">{{ ucfirst($transaction->status) }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ ucfirst($transaction->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if ($transaction->status == 'pending')
                                                <form action="{{ route('checkout-process') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="transaction_id"
                                                        value="{{ $transaction->id }}">
                                                    <button type="submit" class="btn btn-primary">Bayar</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada transaksi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
