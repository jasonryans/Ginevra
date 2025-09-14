@extends('user.base')

@section('content')
    <style>
        .hero-background {
            background-image: url('{{ asset('storage/logo/GINEVRA LOGO-02.png') }}');
            background-size: fill;
            background-repeat: no-repeat;
            background-position: center center;
            position: relative;
            min-height: 550px;
        }
        
        .hero-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.7);
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }

        /* Ensure text is readable over the logo */
        .hero-title {
            text-shadow: 2px 2px 4px rgba(5, 4, 4, 0.5);
            color: #0e0d0d;
        }

        .hero-addition-text {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #d63384; /* Accent pink color */
        }

        .hero-subtitle {
            text-shadow: 1px 1px 2px rgba(10, 4, 4, 0.5);
            font-family: 'Playfair Display', serif;
            font-weight: 100;
            color: #d63384;
            font-size: clamp(1.25rem, 2.5vw, 1.75rem);
        }
    </style>

    <!-- Hero Section -->
    <section class="hero-section hero-background">
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h1 class="hero-title">Discover <span class="hero-addition-text"> Your </span><span class="text-accent-pink">Style</span></h1>
                    <h4 class="hero-subtitle">Explore our curated collection of contemporary fashion pieces designed to elevate your everyday wardrobe.</h4>
                    <div class="d-flex gap-3">
                        <a href="{{ url('/shop') }}" class="btn btn-primary">Shop Now</a>
                        <a href="{{ url('/collections') }}" class="btn btn-outline-primary">View Collections</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Featured Products</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card product-card h-100">
                        <div class="product-image">
                            <img src="{{ asset('images/product1.jpg') }}" class="card-img-top" alt="Product 1">
                            <div class="product-overlay">
                                <a href="{{ url('/product/1') }}" class="btn btn-shop">Quick View</a>
                            </div>
                            <div class="product-badge">New</div>
                            <div class="product-wishlist">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">Elegant Dress</h5>
                            <div class="product-price">$89.99 <span class="original-price">$129.99</span></div>
                            <a href="{{ url('/product/1') }}" class="btn btn-primary btn-sm">Add to Cart</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card product-card h-100">
                        <div class="product-image">
                            <img src="{{ asset('images/product2.jpg') }}" class="card-img-top" alt="Product 2">
                            <div class="product-overlay">
                                <a href="{{ url('/product/2') }}" class="btn btn-shop">Quick View</a>
                            </div>
                            <div class="product-badge">Sale</div>
                            <div class="product-wishlist">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">Casual Blazer</h5>
                            <div class="product-price">$159.99</div>
                            <a href="{{ url('/product/2') }}" class="btn btn-primary btn-sm">Add to Cart</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card product-card h-100">
                        <div class="product-image">
                            <img src="{{ asset('images/product3.jpg') }}" class="card-img-top" alt="Product 3">
                            <div class="product-overlay">
                                <a href="{{ url('/product/3') }}" class="btn btn-shop">Quick View</a>
                            </div>
                            <div class="product-wishlist">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">Designer Handbag</h5>
                            <div class="product-price">$299.99</div>
                            <a href="{{ url('/product/3') }}" class="btn btn-primary btn-sm">Add to Cart</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card product-card h-100">
                        <div class="product-image">
                            <img src="{{ asset('images/product4.jpg') }}" class="card-img-top" alt="Product 4">
                            <div class="product-overlay">
                                <a href="{{ url('/product/4') }}" class="btn btn-shop">Quick View</a>
                            </div>
                            <div class="product-badge">Trending</div>
                            <div class="product-wishlist">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">Luxury Shoes</h5>
                            <div class="product-price">$199.99</div>
                            <a href="{{ url('/product/4') }}" class="btn btn-primary btn-sm">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5 bg-off-white">
        <div class="container">
            <h2 class="section-title">Shop by Category</h2>
            <div class="row">
                @foreach($categories as $category)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="category-card" style="background-image: url('{{ asset('images/category-' . strtolower(str_replace(' ', '-', $category->name)) . '.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="category-overlay">
                            <h3 class="category-title">{{ $category->name }}</h3>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h3 class="font-playfair mb-3">Why Choose Ginevra?</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="text-accent-pink me-3">
                                    <i class="fas fa-crown fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Premium Quality</h6>
                                    <p class="text-muted small">Only the finest materials and craftsmanship</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="text-accent-pink me-3">
                                    <i class="fas fa-user-tie fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Expert Service</h6>
                                    <p class="text-muted small">Professional consultation and support</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="text-accent-pink me-3">
                                    <i class="fas fa-shipping-fast fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Fast Delivery</h6>
                                    <p class="text-muted small">Quick and secure worldwide shipping</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="text-accent-pink me-3">
                                    <i class="fas fa-shield-alt fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Secure & Safe</h6>
                                    <p class="text-muted small">Protected transactions and privacy</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/features-image.jpg') }}" alt="Features" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>
@endsection