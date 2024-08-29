@extends('layouts.adminApp')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Products</h3>
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
                        <a href="#">Products</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title mb-0">Products Management</h4>
                                @if (session('success'))
                                    <div class="alert alert-success ms-auto" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @can('product-create')
                                    <a class="btn btn-primary ms-auto" href="{{ route('products.create') }}">
                                        <i class="fa fa-plus"></i> Create New Product
                                    </a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Image</th>
                                            <th width="280px">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Image</th>
                                            <th width="280px">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>
                                                    @if ($product->image)
                                                        <img src="{{ asset('images/' . $product->image) }}" width="50"
                                                            height="50" alt="{{ $product->name }}" class="img-thumbnail">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ route('products.show', $product->id) }}">
                                                        <i class="far fa-eye"></i> Show
                                                    </a>
                                                    @can('product-edit')
                                                        <a class="btn btn-primary btn-sm"
                                                            href="{{ route('products.edit', $product->id) }}">
                                                            <i class="far fa-edit"></i> Edit
                                                        </a>
                                                    @endcan

                                                    @can('product-delete')
                                                        <form action="{{ route('products.destroy', $product->id) }}"
                                                            method="POST" style="display:inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {!! $products->links() !!}
        </div>
    </div>
@endsection
