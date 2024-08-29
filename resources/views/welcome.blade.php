@extends('layouts.app')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
            </div>
        </div>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-img-wrapper">
                            @if ($product->image)
                                <img src="{{ asset('images/' . $product->image) }}" class="card-img-top"
                                    alt="{{ $product->name }}">
                            @else
                                <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="No Image">
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">Price: {{ $product->price }}</p>
                            <p class="card-text">{{ $product->description }}</p>
                            <button class="btn btn-primary" wire:click="beli({{ $product->id }})">
                                beli
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
