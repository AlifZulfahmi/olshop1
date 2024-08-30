@extends('layouts.app')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Shopping Cart</h3>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table id="cart-table" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Date Ordered</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Total Price</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        @php
                            $product = App\Models\Product::find($order->produk_id);
                            $statusText = '';
                            $actionButton = '';
                            $totalPrice = $order->total_harga;

                            switch ($order->status) {
                                case 0:
                                    $statusText = 'Belum melakukan pembayaran';
                                    $actionButton =
                                        '<a href="' .
                                        route('shopping-cart.select-payment', $order->id) .
                                        '" class="btn btn-primary btn-sm">Pilih Metode Pembayaran</a>';
                                    break;
                                case 1:
                                    $statusText = 'Lihat Status';
                                    $actionButton =
                                        '<a href="' .
                                        route('shopping-cart.view-status', $order->id) .
                                        '" class="btn btn-secondary btn-sm">Lihat Status</a>';
                                    break;
                                default:
                                    $statusText = 'Status Tidak Dikenal';
                                    break;
                            }
                        @endphp
                        <tr data-product-id="{{ $product->id }}" data-price="{{ $product->price }}">
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>{{ $product->name ?? 'Product Not Found' }}</td>
                            <td>
                                @if ($product && $product->image)
                                    <img src="{{ asset('images/' . $product->image) }}" width="100" height="100"
                                        alt="{{ $product->name }}">
                                @else
                                    <img src="https://via.placeholder.com/100" alt="No Image">
                                @endif
                            </td>
                            <td class="total-price">{{ $totalPrice }}</td>
                            <td>
                                <form action="{{ route('shopping-cart.update-quantity', $order->id) }}" method="POST"
                                    style="display:inline;" class="quantity-form">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $order->quantity }}" min="1"
                                        class="form-control quantity-input" style="width: 80px; display: inline;">
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </form>
                            </td>
                            <td>
                                <span class="order-status">{{ $statusText }}</span>
                            </td>
                            <td>
                                {!! $actionButton !!}
                                <form action="{{ route('shopping-cart.remove', $order->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No items in your cart.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($orders->count())
            <div class="d-flex justify-content-end mb-4">
                <h4>Total Price: <span id="total-price">{{ $orders->sum('total_harga') }}</span></h4>
            </div>

            <!-- Tombol untuk Pembayaran -->
            <div class="d-flex justify-content-end">
                <a href="{{ route('shopping-cart.select-payment', $orders->first()->id) }}" class="btn btn-primary">
                    Pilih Metode Pembayaran
                </a>
            </div>
        @endif
    </div>

    @push('scripts')
        <!-- DataTables JavaScript -->
        <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#cart-table').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true
                });

                // AJAX for updating quantity
                $('.quantity-form').on('submit', function(e) {
                    e.preventDefault();
                    var $form = $(this);
                    var $row = $form.closest('tr');
                    var productId = $row.data('product-id');
                    var quantity = $form.find('.quantity-input').val();
                    var price = $row.data('price');
                    var url = $form.attr('action');

                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {
                            _token: $form.find('input[name="_token"]').val(),
                            quantity: quantity
                        },
                        success: function(response) {
                            var totalPrice = price * quantity;
                            $row.find('.total-price').text(totalPrice.toFixed(2));
                            updateTotalPrice();
                        },
                        error: function(xhr) {
                            console.error('Failed to update quantity.');
                        }
                    });
                });

                function updateTotalPrice() {
                    var total = 0;
                    $('#cart-table .total-price').each(function() {
                        total += parseFloat($(this).text()) || 0;
                    });
                    $('#total-price').text(total.toFixed(2));
                }
            });
        </script>
    @endpush
@endsection
