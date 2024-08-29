@extends('layouts.adminApp')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Product Details</h3>
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
                        <a href="#">Product Details</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-product text-center" style="width: 100%; max-width: 500px;">
                    <div class="card-header">
                        <div class="product-picture">
                            @if ($product->image)
                                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="product-img rounded" style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <img src="{{ asset('assets/img/default-product.jpg') }}" alt="Default Product"
                                    class="product-img rounded" style="width: 150px; height: 150px; object-fit: cover;">
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="product-profile">
                            <div class="name font-weight-bold" style="font-size: 1.25rem;">{{ $product->name }}</div>
                            <div class="detail mt-2">{{ $product->detail }}</div>
                            <div class="price mt-2">
                                <strong>Price:</strong> ${{ number_format($product->price, 2) }}
                            </div>
                            <div class="view-product mt-3">
                                <a href="{{ route('products.index') }}" class="btn btn-secondary w-100">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
