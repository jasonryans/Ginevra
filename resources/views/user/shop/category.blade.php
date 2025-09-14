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
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="sidebar">
                    <div class="sidebar-section">
                        <h5 class="sidebar-title">Featured Products</h5>
                        <div class="featured-products">
                            @if(isset($featuredProducts) && $featuredProducts->count() > 0)
                                @foreach($featuredProducts as $product)
                                    <div class="featured-product-card">
                                        <a href="{{ route('user.products.show', $product->id) }}" class="featured-product-link">
                                            <div class="featured-product-image">
                                                @if($product->foto_product)
                                                    @php
                                                        $photos = json_decode($product->foto_product, true);
                                                    @endphp
                                                    @if(is_array($photos) && count($photos) > 0)
                                                        <img src="{{ Str::startsWith($photos[0], 'http') ? $photos[0] : asset('storage/' . $photos[0]) }}" 
                                                            alt="{{ $product->name }}" class="featured-image-primary">
                                                        @if(count($photos) > 1)
                                                            <img src="{{ Str::startsWith($photos[1], 'http') ? $photos[1] : asset('storage/' . $photos[1]) }}" 
                                                                alt="{{ $product->name }}" class="featured-image-hover">
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
                                            <div class="featured-product-info">
                                                <h6 class="featured-product-name">{{ Str::limit($product->name, 40) }}</h6>
                                                <p class="featured-product-brand">{{ strtoupper(config('app.name', 'GINEVRA')) }}</p>
                                                <!-- Rating stars -->
                                                <div class="featured-product-rating">
                                                    @php
                                                        $rating = $product->average_rating ?? 4.5;
                                                        $fullStars = floor($rating);
                                                        $halfStar = ($rating - $fullStars) >= 0.5;
                                                    @endphp
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $fullStars)
                                                            <i class="fas fa-star"></i>
                                                        @elseif($i == $fullStars + 1 && $halfStar)
                                                            <i class="fas fa-star-half-alt"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <div class="featured-product-price">
                                                    <span class="current-price">IDR {{ number_format($product->price, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <div class="no-featured-products">
                                    <p class="text-muted">No featured products available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-md-8">
                <div class="row" id="products-container">
                    @if ($products->count() > 0)
                        @include('user.shop.partials.product-grid', ['products' => $products])
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

                <!-- Loading Animation -->
                <div id="loading-animation" class="text-center my-4" style="display: none;">
                    <div class="loading-spinner">
                        <div class="custom-spinner"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Sidebar Styles */
        .sidebar {
            background: #fff;
            padding: 0;
        }

        .sidebar-section {
            margin-bottom: 2rem;
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f8f9fa;
        }

        .featured-products {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .featured-product-card {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .featured-product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .featured-product-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .featured-product-link:hover {
            text-decoration: none;
            color: inherit;
        }

        .featured-product-image {
            width: 100%;
            height: 300px;
            overflow: hidden;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .featured-product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease-in-out, 0.4s ease-in-out;
        }

        .featured-product-image .featured-image-primary,
        .featured-product-image .featured-image-hover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4 ease-in-out, opacity 0.4s ease-in-out;
        }

        .featured-product-image .featured-image-hover {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        /* Hover effects for featured products */
        .featured-product-card:hover .featured-image-primary {
            opacity: 0;
            transform: scale(1.05);
        }

        .featured-product-card:hover .featured-image-hover {
            opacity: 1;
            transform: scale(1.05);
            /* transition: transform 0.4s ease-in-out; */
        }

        /* Enhanced hover effect for single image */
        /* .featured-product-card:hover .featured-product-image img:not(.featured-image-hover) {
            opacity: 1;
            transform: scale(1.05);
        } */

        .featured-product-name {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 0.25rem;
            line-height: 1.3;
            transition: color 0.3s ease; /* Added transition */
            position: relative; /* Added for underline effect */
        }

        /* Add underline animation like main products */
        .featured-product-name::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #000000;
            transition: width 0.3s ease;
        }

        .featured-product-card:hover .featured-product-name::after {
            width: 100%;
        }

        .featured-product-card:hover .featured-product-name {
            color: #000000;
        }

        .featured-product-card:hover .featured-product-image img {
            transform: scale(1.05);
        }

        .featured-product-image .no-image-placeholder {
            color: #6c757d;
            font-size: 12px;
        }

        .featured-product-info {
            padding: 1rem;
        }

        .featured-product-name {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 0.25rem;
            line-height: 1.3;
        }

        .featured-product-brand {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
            margin: 0;
        }

        .featured-product-rating {
            margin-bottom: 0.5rem;
        }

        .featured-product-rating i {
            font-size: 12px;
            color: #ffd700;
            margin-right: 1px;
        }

        .featured-product-rating i.far {
            color: #e0e0e0;
        }

        .featured-product-price {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .featured-product-price .current-price {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .featured-product-price .original-price {
            font-size: 12px;
            color: #888;
            text-decoration: line-through;
        }

        .no-featured-products {
            padding: 1rem;
            text-align: center;
        }

        /* Existing styles... */
        .product-wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-card {
            background: transparent;
            border-radius: 0;
            overflow: hidden;
            box-shadow: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 16px;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: none;
        }

        .product-image-container {
            position: relative;
            width: 100%;
            height: 400px;
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

        /* Loading Animation Styles */
        #loading-animation {
            padding: 60px 0;
        }

        .loading-spinner {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .custom-spinner {
            width: 24px;
            height: 24px;
            border: 2px solid #e5e5e5;
            border-top: 2px solid #333;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Fade in animation for new products */
        .product-wrapper.fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Stagger animation for multiple products */
        .product-wrapper.fade-in:nth-child(1) { animation-delay: 0.1s; }
        .product-wrapper.fade-in:nth-child(2) { animation-delay: 0.2s; }
        .product-wrapper.fade-in:nth-child(3) { animation-delay: 0.3s; }
        .product-wrapper.fade-in:nth-child(4) { animation-delay: 0.4s; }
        .product-wrapper.fade-in:nth-child(5) { animation-delay: 0.5s; }
        .product-wrapper.fade-in:nth-child(6) { animation-delay: 0.6s; }
        .product-wrapper.fade-in:nth-child(7) { animation-delay: 0.7s; }
        .product-wrapper.fade-in:nth-child(8) { animation-delay: 0.8s; }
        .product-wrapper.fade-in:nth-child(9) { animation-delay: 0.9s; }
        .product-wrapper.fade-in:nth-child(10) { animation-delay: 1.0s; }
        .product-wrapper.fade-in:nth-child(11) { animation-delay: 1.1s; }
        .product-wrapper.fade-in:nth-child(12) { animation-delay: 1.2s; }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .sidebar {
                margin-bottom: 2rem;
            }
            
            .featured-products {
                flex-direction: row;
                overflow-x: auto;
                padding-bottom: 0.5rem;
                gap: 1rem;
            }
            
            .featured-product-card {
                flex: 0 0 200px;
            }
        }

        @media (max-width: 768px) {
            .product-image-container {
                height: 400px;
            }

            .product-title {
                font-size: 15px;
            }

            .price {
                font-size: 15px;
            }
            
            .featured-product-card {
                flex: 0 0 180px;
            }
        }

        @media (max-width: 576px) {
            .product-image-container {
                height: 320px;
            }
            
            .featured-products {
                flex-direction: column;
            }
            
            .featured-product-card {
                flex: 1 1 auto;
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
            let currentPage = 1;
            let loading = false;
            let hasMore = true;
            const categorySlug = '{{ request()->route("category") }}';

            // Initialize hover effects for existing products
            initializeProductHover();

            // Infinite scroll functionality
            window.addEventListener('scroll', function() {
                if (loading || !hasMore) return;

                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const windowHeight = window.innerHeight;
                const documentHeight = document.documentElement.scrollHeight;

                // Trigger loading when user is 200px from bottom
                if (scrollTop + windowHeight >= documentHeight - 200) {
                    loadMoreProducts();
                }
            });

            function loadMoreProducts() {
                if (loading || !hasMore) return;

                loading = true;
                currentPage++;
                
                // Show loading animation
                document.getElementById('loading-animation').style.display = 'block';

                // Make AJAX request
                fetch(`/shop/category/${categorySlug}/paginate?page=${currentPage}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.html) {
                        // Create a temporary container to parse the HTML
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = data.html;
                        
                        // Add fade-in animation to new products
                        const newProducts = tempDiv.querySelectorAll('.product-wrapper');
                        newProducts.forEach(product => {
                            product.classList.add('fade-in');
                        });
                        
                        // Append new products to container
                        const container = document.getElementById('products-container');
                        while (tempDiv.firstChild) {
                            container.appendChild(tempDiv.firstChild);
                        }
                        
                        // Initialize hover effects for new products
                        initializeProductHover();
                        
                        // Update hasMore flag
                        hasMore = data.hasMore;
                        
                        // Show end message if no more products
                        if (!hasMore) {
                            document.getElementById('end-of-products').style.display = 'block';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading more products:', error);
                    hasMore = false;
                })
                .finally(() => {
                    // Hide loading animation
                    document.getElementById('loading-animation').style.display = 'none';
                    loading = false;
                });
            }

            function initializeProductHover() {
                const productWrappers = document.querySelectorAll('.product-wrapper:not(.hover-initialized)');

                productWrappers.forEach(wrapper => {
                    const imageContainer = wrapper.querySelector('.product-image-container');
                    const productTitle = wrapper.querySelector('.product-title a');

                    if (imageContainer && productTitle) {
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
                        
                        // Mark as initialized
                        wrapper.classList.add('hover-initialized');
                    }
                });
            }
        });
    </script>
@endsection