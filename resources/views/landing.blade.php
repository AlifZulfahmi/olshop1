@extends('layouts.LandingApp')

@section('title', 'Home')

@section('content')
    <section id="hero">
        <div class="relative w-full mx-auto overflow-hidden h-[28.125rem]">
            <!-- Slider container -->
            <div id="slider" class="flex transition-transform duration-700 h-full">
                <!-- Slide 1 -->
                <div class="flex-none w-full h-full relative">
                    <img src="images/banner1.jpg" alt="Image 1" class="w-full h-full object-cover">
                </div>
                <!-- Slide 2 -->
                <div class="flex-none w-full h-full relative">
                    <img src="images/banner2.jpg" alt="Image 2" class="w-full h-full object-cover">
                </div>
                <!-- Slide 3 -->
                <div class="flex-none w-full h-full relative">
                    <img src="images/banner3.jpg" alt="Image 3" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Navigation dots -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-3">
                <button class="w-2.5 h-2.5 bg-gray-400 rounded-full focus:outline-none" data-slide="0"></button>
                <button class="w-2.5 h-2.5 bg-gray-400 rounded-full focus:outline-none" data-slide="1"></button>
                <button class="w-2.5 h-2.5 bg-gray-400 rounded-full focus:outline-none" data-slide="2"></button>
            </div>
        </div>
    </section>

    <section id="category" class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mb-4 flex items-center justify-between gap-4 md:mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Shop by category</h2>

                <a href="#" title=""
                    class="flex items-center text-base font-medium text-primary-700 hover:underline dark:text-primary-500">
                    See more categories
                    <svg class="ms-1 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 12H5m14 0-4 4m4-4-4-4" />
                    </svg>
                </a>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($subCategories as $subCategory)
                    <a href="/shop?category={{ $subCategory->name }}"
                        class="flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 16H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v1M9 12H4m8 8V9h8v11h-8Zm0 0H9m8-4a1 1 0 1 0-2 0 1 1 0 0 0 2 0Z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $subCategory->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section id="listminuman" class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <!-- Heading & Filters -->
            <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
                <div>
                    <h2 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Produk Terbaru</h2>
                </div>
            </div>
            <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $product)
                    <div
                        class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div class="h-56 w-full">
                            <a href="#">
                                <img class="w-full h-full object-cover mx-auto rounded-md"
                                    src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" />
                            </a>
                        </div>
                        <div class="pt-6">
                            <div class="mb-4 flex items-center justify-between gap-4">
                                <a href="/shop?category={{ $product->category->name }}">
                                    <span
                                        class="me-2 rounded bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-primary-800 dark:bg-primary-900 dark:text-primary-300">{{ $product->category->name }}</span>
                                </a>
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('detail', $product->id) }}">
                                        <button type="button" data-tooltip-target="tooltip-quick-look"
                                            class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                            <span class="sr-only"> Lihat Detail </span>
                                            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2"
                                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                                <path stroke="currentColor" stroke-width="2"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </button>
                                    </a>
                                    <div id="tooltip-quick-look" role="tooltip"
                                        class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700"
                                        data-popper-placement="top">
                                        Lihat Detail
                                        <div class="tooltip-arrow" data-popper-arrow=""></div>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('detail', $product->id) }}"
                                class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white">{{ $product->name }}
                            </a>

                            <div class="mt-4 flex items-center justify-between gap-4">
                                <p class="text-xl font-bold leading-tight text-gray-900 dark:text-white">Rp.
                                    {{ number_format($product->price, 0, ',', '.') }}</p>
                                <input type="number" id="quantity" name="quantity" min="1" value="1"
                                    class="border rounded-lg w-16 text-center me-4 hidden" />

                                <button data-product-id="{{ $product->id }}" type="button"
                                    class="addToCartButton text-white mt-4 sm:mt-0 bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 flex items-center justify-center">
                                    <svg class="w-5 h-5 -ms-2 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                                    </svg>
                                    Add to cart
                                </button>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-8 antialiased dark:bg-gray-900 md:py-16">
        <div
            class="mx-auto grid max-w-screen-xl rounded-lg bg-gray-50 p-4 dark:bg-gray-800 md:p-8 lg:grid-cols-12 lg:gap-8 lg:p-16 xl:gap-16">
            <div class="lg:col-span-5 lg:mt-0">
                <a href="#">
                    <img class="mb-4 h-56 w-56 dark:hidden sm:h-96 sm:w-96 md:h-full md:w-full" src="images/buah.png"
                        alt="peripherals" />
                </a>
            </div>
            <div class="me-auto place-self-center lg:col-span-7">
                <h1 class="mb-3 text-2xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white md:text-4xl">
                    Save $500 today on your purchase <br />
                    of a new Food item.
                </h1>
                <p class="mb-6 text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                    Asperiores nisi temporibus pariatur! Esse recusandae blanditiis illo nam delectus, eveniet minus!
                    Commodi praesentium ducimus officia eos inventore voluptate similique, sint laborum odio ut tenetur quia
                    labore sed! Dicta impedit vero quidem?</p>
                <a href="#"
                    class="inline-flex items-center justify-center rounded-lg bg-primary-700 px-5 py-3 text-center text-base font-medium text-white hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                    Pre-order now </a>
            </div>
        </div>
    </section>
@endsection
