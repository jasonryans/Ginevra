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

    <style>
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
        }

        @media (max-width: 576px) {
            .product-image-container {
                height: 320px;
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