@extends('user.base')

@section('content')
    <style>
        .hero-background {
            background-image: url('{{ asset('storage/logo/background-hero.jpg') }}');
            background-size: cover;
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
            background: rgba(255, 255, 255, 0.5);
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
            color: #eee2e8; /* Accent pink color */
        }

        .hero-subtitle {
            text-shadow: 1px 1px 2px rgba(10, 4, 4, 0.5);
            font-family: 'Playfair Display', serif;
            font-weight: 100;
            color: #080808;
            font-size: clamp(1.25rem, 2.5vw, 1.75rem);
        }

        /* Product Carousel Styles */
        .product-carousel-container {
            position: relative;
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .product-carousel {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
        }

        .product-carousel .carousel-inner {
            border-radius: 15px;
        }

        /* New single product slide styles */
        .single-product-slide {
            position: relative;
            height: 400px;
            border-radius: 15px;
            overflow: hidden;
        }

        .carousel-main-image {
            width: 100%;
            height: 100%;
            object-fit: fill;
            border-radius: 15px;
            transition: transform 0.3s ease;
        }

        .single-product-slide:hover .carousel-main-image {
            transform: scale(1.05);
        }

        .slide-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            padding: 30px 20px 20px;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .single-product-slide:hover .slide-overlay {
            transform: translateY(0);
        }

        .slide-content {
            color: white;
            text-align: center;
        }

        .slide-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 8px;
            color: #eee2e8;
        }

        .slide-description {
            font-size: 0.9rem;
            margin-bottom: 0;
            opacity: 0.9;
        }

        /* Custom Indicators */
        .custom-indicators {
            bottom: 15px;
            margin-bottom: 0;
        }

        .custom-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.5);
            background: transparent;
            margin: 0 4px;
            transition: all 0.3s ease;
        }

        .custom-indicators button.active {
            background: #eee2e8;
            border-color: #eee2e8;
        }

        .custom-indicators button:hover {
            border-color: #eee2e8;
        }

        /* Enhanced Carousel Controls */
        .product-carousel .carousel-control-prev,
        .product-carousel .carousel-control-next {
            width: 45px;
            height: 45px;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .product-carousel:hover .carousel-control-prev,
        .product-carousel:hover .carousel-control-next {
            opacity: 1;
        }

        .product-carousel .carousel-control-prev {
            left: 15px;
        }

        .product-carousel .carousel-control-next {
            right: 15px;
        }

        .product-carousel .carousel-control-prev:hover,
        .product-carousel .carousel-control-next:hover {
            background: rgba(238, 226, 232, 0.9);
        }

        .product-carousel .carousel-control-prev-icon,
        .product-carousel .carousel-control-next-icon {
            background-size: 60%;
            filter: invert(1);
        }

        .hero-badge {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        @media (max-width: 768px) {
            .single-product-slide {
                height: 300px;
            }
            
            .slide-overlay {
                transform: translateY(0);
                background: linear-gradient(transparent, rgba(0, 0, 0, 0.6));
            }
            
            .slide-title {
                font-size: 1.2rem;
            }
            
            .slide-description {
                font-size: 0.8rem;
            }
            
            .product-carousel-container {
                margin-top: 30px;
                padding: 20px;
            }
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
                
                <!-- Product Carousel -->
                <div class="col-lg-6">
                    <div class="product-carousel-container">
                        <div id="productCarousel" class="carousel slide product-carousel" data-bs-ride="carousel" data-bs-interval="4000">
                            <div class="carousel-inner">
                                <!-- Slide 1 -->
                                <div class="carousel-item active">
                                    <div class="single-product-slide">
                                        <img src="{{ asset('storage/carousel/young-japanese-woman-portrait-sitting-chair.jpg') }}" alt="Elegant Fashion" class="carousel-main-image">
                                        <div class="slide-overlay">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Slide 2 -->
                                <div class="carousel-item">
                                    <div class="single-product-slide">
                                        <img src="{{ asset('storage/carousel/young-woman-wearing-colorful-winter-clothes.jpg') }}" alt="Winter Fashion" class="carousel-main-image">
                                        <div class="slide-overlay">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Slide 3 -->
                                <div class="carousel-item">
                                    <div class="single-product-slide">
                                        <img src="{{ asset('storage/carousel/young-japanese-woman-portrait-with-copy-space.jpg') }}" alt="Classic Style" class="carousel-main-image">
                                        <div class="slide-overlay">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Carousel Indicators -->
                            <div class="carousel-indicators custom-indicators">
                                <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            
                            <!-- Controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
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
                            <img src="{{ asset('storage\carousel\young-beautiful-smiling-female-trendy-summer-yellow-hipster-sweater-jeans.jpg') }}" class="card-img-top" alt="Product 1">
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
                            <img src="{{ asset('storage\carousel\young-beautiful-smiling-female-trendy-summer-yellow-hipster-sweater-jeans.jpg') }}" class="card-img-top" alt="Product 2">
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
                            <img src="{{ asset('storage\carousel\young-woman-wearing-colorful-winter-clothes.jpg') }}" class="card-img-top" alt="Product 3">
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
                            <img src="{{ asset('storage\carousel\young-japanese-woman-portrait-sitting-chair.jpg') }}" class="card-img-top" alt="Product 4">
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