@extends('layouts.adminApp')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Laporan</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="#">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Riwayat Transaksi</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title mb-0">Riwayat Transaksi</h4>
                                @if (session('success'))
                                    <div class="alert alert-success ms-auto" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                {{-- Ganti tombol 'Tambah' dengan 'Cetak PDF' --}}
                                <a class="btn btn-outline-danger ms-auto" href="{{ route('laporan.cetakPDF') }}">
                                    <i class="far fa-file-pdf"></i> Cetak PDF
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
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
                                                    {{-- Display the quantity --}}
                                                    {{ $transaction->quantity }}
                                                </td>
                                                <td>
                                                    @if ($transaction->status == 'pending')
                                                        <span
                                                            class="badge bg-warning text-dark">{{ ucfirst($transaction->status) }}</span>
                                                    @elseif ($transaction->status == 'success')
                                                        <span
                                                            class="badge bg-success">{{ ucfirst($transaction->status) }}</span>
                                                    @else
                                                        <span
                                                            class="badge bg-danger">{{ ucfirst($transaction->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                                <td>
                                                    {{-- Ganti tombol 'Bayar' dengan 'Invoice' --}}
                                                    <form action="{{ route('invoice.generate') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="transaction_id"
                                                            value="{{ $transaction->id }}">
                                                        <button class="btn btn-outline-primary" type="submit">Download
                                                            Invoice</button>
                                                    </form>

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada transaksi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
