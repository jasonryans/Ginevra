@extends('user.base')

@php
    $hideNewsletter = true;
@endphp

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">{{ $categoryModel->name }}</h1>
            </div>
        </div>

        <div class="row">
            @if ($products->count() > 0)
                @foreach ($products as $product)
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                        <div class="product-wrapper" data-product-id="{{ $product->id }}">
                            <div class="product-card">
                                <a href="{{ route('user.products.show', $product->id) }}" class="product-image-link">
                                    <div class="product-image-container">
                                        @if ($product->foto_product)
                                            @php
                                                $photos = json_decode($product->foto_product, true);
                                            @endphp
                                            @if (is_array($photos) && count($photos) > 0)
                                                <img src="{{ Str::startsWith($photos[0], 'http') ? $photos[0] : asset('storage/' . $photos[0]) }}" 
                                                    alt="{{ $product->name }}" class="product-image-primary">
                                                @if (count($photos) > 1)
                                                    <img src="{{ Str::startsWith($photos[1], 'http') ? $photos[1] : asset('storage/' . $photos[1]) }}" 
                                                        alt="{{ $product->name }}" class="product-image-hover">
                                                @endif
                                            @else
                                                <div class="no-image-placeholder">
                                                    <span>No Image</span>
                                                </div>
                                            @endif
                                        @else
                                            <div class="no-image-placeholder">
                                                <span>No Image</span>
                                            </div>
                                        @endif
                                    </div>
                            </div>

                            <div class="product-info">
                                <h3 class="product-title">
                                    <a href="{{ route('user.products.show', $product->id) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="product-brand">{{ strtoupper(config('app.name', 'GINEVRA')) }}</p>
                                <div class="product-price">
                                    <span class="price">IDR {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @if (isset($product->sale_price) && $product->sale_price < $product->price)
                                        <span class="original-price">IDR
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <h4>No products found in {{ $categoryModel->name }}</h4>
                        <p>Check back later for new arrivals!</p>
                        <a href="{{ route('user.home') }}" class="btn btn-primary">View All Products</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .product-wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-card {
            background: white;
            border-radius: 2px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 16px;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .product-image-container {
            position: relative;
            width: 100%;
            height: 500px;
            overflow: hidden;
            background-color: #f8f9fa;
        }

        .product-image-link {
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .product-image-link:hover {
            text-decoration: none;
            color: inherit;
        }

        .product-image-primary,
        .product-image-hover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.4s ease-in-out;
        }

        .product-image-hover {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        /* Hover effects for image container */
        .product-wrapper:hover .product-image-primary {
            opacity: 0;
        }

        .product-wrapper:hover .product-image-hover {
            opacity: 1;
        }

        .no-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            color: #6c757d;
            font-size: 14px;
        }

        .product-info {
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .product-title {
            margin: 0;
            font-size: 16px;
            font-weight: 400;
            color: #333;
            line-height: 1.3;
            margin-bottom: 4px;
        }

        .product-title a {
            text-decoration: none;
            color: inherit;
            transition: color 0.3s ease;
            position: relative;
            display: inline-block;
        }

        /* Underline animation for product title */
        .product-title a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #000000;
            transition: width 0.3s ease;
        }

        .product-wrapper:hover .product-title a::after {
            width: 100%;
        }

        .product-wrapper:hover .product-title a {
            color: #000000;
        }

        .product-brand {
            margin: 0;
            font-size: 12px;
            color: #888;
            font-weight: 500;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .product-price {
            margin: 0;
        }

        .price {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .original-price {
            font-size: 14px;
            color: #888;
            text-decoration: line-through;
            margin-left: 8px;
        }

        /* Responsive adjustments */
         @media (max-width: 768px) {
            .product-image-container {
                height: 400px; /* Keep it proportionally tall on tablets */
            }

            .product-title {
                font-size: 15px;
            }

            .price {
                font-size: 15px;
            }
        }

        @media (max-width: 576px) {
            .product-image-container {
                height: 320px; /* Keep it proportionally tall on mobile */
            }
        }

        /* Grid adjustments for better spacing */
        .row>[class*="col-"] {
            padding-left: 12px;
            padding-right: 12px;
            margin-bottom: 32px;
        }

        .container {
            max-width: 1200px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productWrappers = document.querySelectorAll('.product-wrapper');

            productWrappers.forEach(wrapper => {
                const imageContainer = wrapper.querySelector('.product-image-container');
                const productTitle = wrapper.querySelector('.product-title a');

                // Add hover effect to image container
                imageContainer.addEventListener('mouseenter', function() {
                    wrapper.classList.add('hovered');
                });

                imageContainer.addEventListener('mouseleave', function() {
                    wrapper.classList.remove('hovered');
                });

                // Add hover effect to product title
                productTitle.addEventListener('mouseenter', function() {
                    wrapper.classList.add('hovered');
                });

                productTitle.addEventListener('mouseleave', function() {
                    wrapper.classList.remove('hovered');
                });
            });
        });
    </script>
@endsection
