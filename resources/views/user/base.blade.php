<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ginevra - Fashion & Style</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-black: #000000;
            --soft-black: #1a1a1a;
            --warm-white: #fefefe;
            --off-white: #f8f8f8;
            --accent-pink: #ff6b9d;
            --accent-gold: #c9a96e;
            --text-gray: #666666;
            --light-gray: #e8e8e8;
            --border-light: #f0f0f0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--soft-black);
            background-color: var(--warm-white);
            font-weight: 400;
        }
        
        .font-playfair {
            font-family: 'Playfair Display', serif;
        }
        
        /* Navigation Styles */
        .navbar {
            background-color: var(--warm-white) !important;
            padding: 1rem 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            border-bottom: 1px solid var(--border-light);
            z-index: 1000;
        }
        
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--primary-black) !important;
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        
        .navbar-nav .nav-link {
            color: var(--soft-black) !important;
            font-weight: 500;
            font-size: 0.95rem;
            margin: 0 0.8rem;
            padding: 0.5rem 0 !important;
            position: relative;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--accent-pink) !important;
        }
        
        .navbar-nav .nav-link.active {
            color: var(--accent-pink) !important;
        }
        
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: var(--accent-pink);
            transition: width 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
        }
        
        /* Buttons */
        .btn-primary {
            background-color: var(--primary-black);
            border: 2px solid var(--primary-black);
            color: var(--warm-white);
            padding: 0.8rem 2rem;
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 0;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--accent-pink);
            border-color: var(--accent-pink);
            color: var(--warm-white);
        }
        
        .btn-outline-primary {
            background-color: transparent;
            border: 2px solid var(--primary-black);
            color: var(--primary-black);
            padding: 0.8rem 2rem;
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 0;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-black);
            border-color: var(--primary-black);
            color: var(--warm-white);
        }
        
        .btn-shop {
            background-color: var(--accent-pink);
            border: 2px solid var(--accent-pink);
            color: var(--warm-white);
            padding: 0.8rem 2rem;
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 0;
            transition: all 0.3s ease;
        }
        
        .btn-shop:hover {
            background-color: var(--primary-black);
            border-color: var(--primary-black);
            color: var(--warm-white);
        }
        
        /* Cards */
        .product-card {
            border: none;
            background: var(--warm-white);
            transition: all 0.3s ease;
            border-radius: 0;
            overflow: hidden;
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .product-image {
            position: relative;
            overflow: hidden;
            aspect-ratio: 3/4;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .product-card:hover .product-image img {
            transform: scale(1.05);
        }
        
        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .product-card:hover .product-overlay {
            opacity: 1;
        }
        
        .product-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: var(--accent-pink);
            color: var(--warm-white);
            padding: 0.3rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 2;
        }
        
        .product-wishlist {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--warm-white);
            color: var(--soft-black);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 2;
        }
        
        .product-wishlist:hover {
            background: var(--accent-pink);
            color: var(--warm-white);
        }
        
        .product-info {
            padding: 1.5rem;
            text-align: center;
        }
        
        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--soft-black);
            margin-bottom: 0.5rem;
        }
        
        .product-price {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--accent-pink);
            margin-bottom: 1rem;
        }
        
        .product-price .original-price {
            text-decoration: line-through;
            color: var(--text-gray);
            font-size: 1rem;
            margin-left: 0.5rem;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--off-white) 0%, var(--warm-white) 100%);
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--primary-black);
            line-height: 1.1;
            margin-bottom: 1rem;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--text-gray);
            font-weight: 400;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .hero-image {
            border-radius: 0;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }
        
        /* Section Titles */
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--primary-black);
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--accent-pink);
        }
        
        /* Categories */
        .category-card {
            position: relative;
            overflow: hidden;
            border-radius: 0;
            height: 300px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .category-card:hover {
            transform: scale(1.02);
        }
        
        .category-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.3) 0%, rgba(255,107,157,0.3) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .category-card:hover .category-overlay {
            background: linear-gradient(135deg, rgba(0,0,0,0.5) 0%, rgba(255,107,157,0.5) 100%);
        }
        
        .category-title {
            color: var(--warm-white);
            font-size: 1.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
        }
        
        /* Newsletter */
        .newsletter-section {
            background: var(--primary-black);
            color: var(--warm-white);
            padding: 4rem 0;
        }
        
        .newsletter-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .newsletter-form .form-control {
            border: 2px solid var(--warm-white);
            background: transparent;
            color: var(--warm-white);
            padding: 1rem;
            border-radius: 0;
            font-size: 1rem;
        }
        
        .newsletter-form .form-control::placeholder {
            color: rgba(255,255,255,0.7);
        }
        
        .newsletter-form .form-control:focus {
            border-color: var(--accent-pink);
            box-shadow: none;
            background: transparent;
            color: var(--warm-white);
        }
        
        /* Footer */
        footer {
            background-color: var(--soft-black) !important;
            color: var(--warm-white);
            padding: 3rem 0 1rem;
        }
        
        .footer-link {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-link:hover {
            color: var(--accent-pink);
        }
        
        .social-icon {
            color: var(--warm-white);
            font-size: 1.2rem;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }
        
        .social-icon:hover {
            color: var(--accent-pink);
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .navbar-nav .nav-link {
                margin: 0.5rem 0;
                text-align: center;
            }
            
            .hero-section {
                padding: 2rem 0;
            }
            
            .product-info {
                padding: 1rem;
            }
        }
        
        /* Utility Classes */
        .text-accent-pink {
            color: var(--accent-pink);
        }
        
        .text-accent-gold {
            color: var(--accent-gold);
        }
        
        .bg-off-white {
            background-color: var(--off-white);
        }
        
        /* Loading Animation */
        .loading-spinner {
            border: 3px solid var(--light-gray);
            border-top: 3px solid var(--accent-pink);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Include Navbar -->
    @include('user.navbar')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h3 class="newsletter-title">Stay In Style</h3>
                    <p class="mb-4">Get the latest trends, exclusive offers, and style tips delivered to your inbox.</p>
                    <form class="newsletter-form row g-3 justify-content-center">
                        <div class="col-md-6">
                            <input type="email" class="form-control" placeholder="Enter your email address" required>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-shop">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="font-playfair mb-3">Ginevra</h5>
                    <p class="small">Discover the latest fashion trends and elevate your style with our curated collections.</p>
                    <div class="d-flex">
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-pinterest"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="mb-3">Shop</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">New Arrivals</a></li>
                        <li><a href="#" class="footer-link">Women</a></li>
                        <li><a href="#" class="footer-link">Men</a></li>
                        <li><a href="#" class="footer-link">Sale</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Size Guide</a></li>
                        <li><a href="#" class="footer-link">Shipping</a></li>
                        <li><a href="#" class="footer-link">Returns</a></li>
                        <li><a href="#" class="footer-link">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="mb-3">Company</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/about') }}" class="footer-link">About</a></li>
                        <li><a href="{{ url('/contact') }}" class="footer-link">Contact</a></li>
                        <li><a href="#" class="footer-link">Careers</a></li>
                        <li><a href="#" class="footer-link">Press</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="mb-3">Legal</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Privacy</a></li>
                        <li><a href="#" class="footer-link">Terms</a></li>
                        <li><a href="#" class="footer-link">Cookies</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 small">&copy; {{ date('Y') }} Ginevra. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    @stack('scripts')
</body>
</html>