@extends('layouts.LandingApp')
@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shop Category page</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="/shop">Shop</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<div class="container pb-5">
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-5">
            <div class="sidebar-categories">
                <div class="head">Browse Categories</div>
                <ul class="main-categories">
                    @foreach($categories as $category)
                    @if(is_null($category->parent_id))
                    <li class="main-nav-list">
                        <a data-toggle="collapse" href="#category{{ $category->id }}" aria-expanded="false" aria-controls="category{{ $category->id }}">
                            <span class="lnr lnr-arrow-right"></span>
                            {{ $category->name }}
                            <span class="number">({{ $category->products_count + $category->sub_products_count }})</span>
                        </a>
                        <ul class="collapse" id="category{{ $category->id }}" data-toggle="collapse" aria-expanded="false" aria-controls="category{{ $category->id }}">
                            @foreach($category->subCategories as $subCategory)
                            <li class="main-nav-list child">
                                <a href="#">
                                    {{ $subCategory->name }}
                                    <span class="number">({{ $subCategory->products_count }})</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-7">
            <!-- Start Filter Bar -->
            <div class="filter-bar d-flex flex-wrap align-items-center">
                <div class="sorting">
                    <select>
                        <option value="1">Default sorting</option>
                        <option value="2">Sort by price</option>
                        <option value="3">Sort by popularity</option>
                    </select>
                </div>
            </div>
            <!-- End Filter Bar -->

            <!-- Start Product Listing -->
            <section class="lattest-product-area pb-40 category-list">
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-product">
                            <img class="object-fit-cover rounded" src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                            <div class="product-details">
                                <h6>{{ $product->name }}</h6>
                                <div class="price">
                                    <h6>Rp. {{ number_format($product->price, 0, ',', '.') }}</h6>
                                </div>
                                <div class="prd-bottom">
                                    <a href="#" class="social-info">
                                        <span class="ti-bag"></span>
                                        <p class="hover-text">add to bag</p>
                                    </a>
                                    <a href="#" class="social-info">
                                        <span class="lnr lnr-heart"></span>
                                        <p class="hover-text">Wishlist</p>
                                    </a>
                                    <a href="#" class="social-info">
                                        <span class="lnr lnr-move"></span>
                                        <p class="hover-text">view more</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            <!-- End Product Listing -->

            <!-- Pagination -->
            {{ $products->links() }}
            
        </div>
    </div>
</div>

@endsection