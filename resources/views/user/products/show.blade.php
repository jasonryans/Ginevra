@extends('user.base')

@php
    $hideNewsletter = true;
@endphp

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Product Images Section -->
        <div class="col-lg-7 col-md-6">
            <div class="product-gallery">
                <!-- Main Image Display -->
                <div class="main-image-container mb-4">
                    @if ($product->foto_product)
                        @php
                            $photos = json_decode($product->foto_product, true);
                        @endphp
                        @if (is_array($photos) && count($photos) > 0)
                            <img id="mainImage" 
                                 src="{{ Str::startsWith($photos[0], 'http') ? $photos[0] : asset('storage/' . $photos[0]) }}" 
                                 alt="{{ $product->name }}" 
                                 class="main-product-image">
                            <button class="zoom-btn" onclick="openImageModal()">
                                <i class="fas fa-expand"></i>
                            </button>
                        @else
                            <div class="no-image-placeholder-main">
                                <i class="fas fa-image"></i>
                                <span>No Image Available</span>
                            </div>
                        @endif
                    @else
                        <div class="no-image-placeholder-main">
                            <i class="fas fa-image"></i>
                            <span>No Image Available</span>
                        </div>
                    @endif
                </div>

                <!-- Thumbnail Images -->
                @if ($product->foto_product)
                    @php
                        $photos = json_decode($product->foto_product, true);
                    @endphp
                    @if (is_array($photos) && count($photos) > 1)
                        <div class="thumbnail-container">
                            <div class="thumbnail-scroll">
                                @foreach ($photos as $index => $photo)
                                    <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}" 
                                         onclick="changeMainImage('{{ Str::startsWith($photo, 'http') ? $photo : asset('storage/' . $photo) }}', {{ $index }})">
                                        <img src="{{ Str::startsWith($photo, 'http') ? $photo : asset('storage/' . $photo) }}" 
                                             alt="{{ $product->name }} - Image {{ $index + 1 }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Product Information Section -->
        <div class="col-lg-5 col-md-6">
            <div class="product-details">
                <!-- Product Title -->
                <h1 class="product-title">{{ $product->name }}</h1>

                <!-- Product Description -->
                @if ($product->description)
                    <div class="product-description">
                        <div class="description-content">
                            @php
                                $paragraphs = explode("\n", $product->description);
                                $paragraphs = array_filter(array_map('trim', $paragraphs));
                            @endphp
                            @foreach ($paragraphs as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Price -->
                <div class="product-price-section">
                    <div class="price-content">
                        <span class="current-price">IDR {{ number_format($product->price, 0, ',', '.') }}</span>
                        @if (isset($product->sale_price) && $product->sale_price < $product->price)
                            <span class="original-price">IDR {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                        @endif
                    </div>
                </div>

                <!-- Size Selection (if applicable) -->
                @if (isset($product->available_sizes))
                    <div class="size-selection">
                        <h6>Size</h6>
                        <div class="size-options">
                            @php
                                $sizes = is_string($product->available_sizes) ? json_decode($product->available_sizes, true) : $product->available_sizes;
                            @endphp
                            @if (is_array($sizes))
                                @foreach ($sizes as $size)
                                    <button type="button" class="size-btn" data-size="{{ $size }}">{{ $size }}</button>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Quantity Selection -->
                <div class="quantity-section">
                    <h6>Quantity</h6>
                    <div class="quantity-controls">
                        <button type="button" class="qty-btn" onclick="decreaseQuantity()">-</button>
                        <input type="number" id="quantity" value="1" min="1" readonly>
                        <button type="button" class="qty-btn" onclick="increaseQuantity()">+</button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button type="button" class="btn btn-outline-primary add-to-wishlist">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                    <button type="button" class="btn btn-primary add-to-cart">
                        Add to Cart
                    </button>
                </div>

                <!-- Product Navigation -->
                <div class="product-navigation mt-4">
                    @if (isset($previousProduct))
                        <a href="{{ route('user.products.show', $previousProduct->id) }}" class="nav-link prev-product">
                            <i class="fas fa-chevron-left"></i> Previous Product
                        </a>
                    @endif
                    
                    @if (isset($nextProduct))
                        <a href="{{ route('user.products.show', $nextProduct->id) }}" class="nav-link next-product">
                            Next Product <i class="fas fa-chevron-right"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal for Zoom -->
<div id="imageModal" class="image-modal" onclick="closeImageModal()">
    <span class="modal-close">&times;</span>
    <img id="modalImage" class="modal-image">
    <div class="modal-navigation">
        <button class="modal-nav-btn prev-btn" onclick="prevModalImage(event)">&lt;</button>
        <button class="modal-nav-btn next-btn" onclick="nextModalImage(event)">&gt;</button>
    </div>
</div>

<style>
/* Product Gallery Styles */
.product-gallery {
    position: relative;
}

.main-image-container {
    position: relative;
    background: #f8f9fa; /* This will show as background when image doesn't fill the container */
    border-radius: 8px;
    overflow: hidden;
    display: flex; /* Add this to center the image */
    align-items: center; 
    justify-content: center; 
}

.main-product-image {
    width: 100%;
    height: 600px;
    object-fit: contain;
    display: block;
    transition: transform 0.3s ease;
}

.main-product-image:hover {
    transform: scale(1.02);
}

.zoom-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
}

.zoom-btn:hover {
    background: var(--accent-pink);
    color: white;
    transform: scale(1.1);
}

.no-image-placeholder-main {
    width: 100%;
    height: 600px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    color: #6c757d;
    font-size: 18px;
}

.no-image-placeholder-main i {
    font-size: 48px;
    margin-bottom: 16px;
}

/* Thumbnail Styles */
.thumbnail-container {
    margin-top: 20px;
}

.thumbnail-scroll {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    padding-bottom: 8px;
}

.thumbnail-scroll::-webkit-scrollbar {
    height: 6px;
}

.thumbnail-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.thumbnail-scroll::-webkit-scrollbar-thumb {
    background: var(--accent-pink);
    border-radius: 3px;
}

.thumbnail-item {
    flex-shrink: 0;
    width: 80px;
    height: 80px;
    border: 2px solid transparent;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
}

.thumbnail-item:hover,
.thumbnail-item.active {
    border-color: var(--accent-pink);
    transform: scale(1.05);
}

.thumbnail-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Product Details Styles */
.product-details {
    padding-left: 40px;
}

.product-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.7rem;
    font-weight: 400;
    color: var(--primary-black);
    margin-bottom: 24px;
    line-height: 1.2;
}

.product-brand {
    font-size: 14px;
    color: #888;
    font-weight: 500;
    letter-spacing: 1px;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.product-price-section {
    margin-bottom: 24px;
}

.price-content {
    display: flex;
    align-items: baseline;
    gap: 12px;
}

.current-price {
    color: var(--text-gray);
    line-height: 1.7;
    font-size: 18px;
    font-weight: normal;
}

.original-price {
    color: var(--text-gray);
    line-height: 1.7;
    font-size: 18px;
    text-decoration: line-through;
}

.product-description {
    margin-bottom: 24px;
}

.product-description p {
    color: var(--text-gray);
    line-height: 1.7;
    margin-bottom: 0;
}

.description-content {
    color: var(--text-gray);
    line-height: 1.7;
    margin-bottom: 0;
}

.description-content p {
    margin-bottom: 0;
}

.description-content p:last-child {
    margin-bottom: 0;
}

/* Product Specifications */
.product-specifications {
    margin-bottom: 24px;
    padding: 20px;
    background: var(--off-white);
    border-radius: 8px;
}

.spec-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    padding-bottom: 8px;
    border-bottom: 1px solid #eee;
}

.spec-item:last-child {
    margin-bottom: 0;
    border-bottom: none;
}

.spec-label {
    font-weight: 600;
    color: var(--primary-black);
    font-size: 14px;
}

.spec-value {
    color: var(--text-gray);
    font-size: 14px;
}

/* Size Selection */
.size-selection {
    margin-bottom: 24px;
}

.size-selection h6 {
    font-weight: 600;
    margin-bottom: 12px;
    color: var(--primary-black);
    text-transform: uppercase;
    font-size: 14px;
    letter-spacing: 0.5px;
}

.size-options {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.size-btn {
    background: transparent;
    border: 2px solid var(--light-gray);
    color: var(--text-gray);
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    min-width: 50px;
}

.size-btn:hover,
.size-btn.active {
    border-color: var(--accent-pink);
    color: var(--accent-pink);
}

/* Quantity Controls */
.quantity-section {
    margin-bottom: 32px;
}

.quantity-section h6 {
    font-weight: 600;
    margin-bottom: 12px;
    color: var(--primary-black);
    text-transform: uppercase;
    font-size: 14px;
    letter-spacing: 0.5px;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 0;
    width: fit-content;
    border: 2px solid var(--light-gray);
    border-radius: 4px;
    overflow: hidden;
}

.qty-btn {
    background: var(--off-white);
    border: none;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-weight: 600;
    font-size: 18px;
    transition: all 0.3s ease;
    color: var(--text-gray);
}

.qty-btn:hover {
    background: var(--accent-pink);
    color: white;
}

#quantity {
    border: none;
    width: 60px;
    height: 40px;
    text-align: center;
    font-weight: 600;
    background: white;
    color: var(--primary-black);
    outline: none;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 16px;
    margin-bottom: 32px;
    flex-wrap: wrap;
}

.add-to-wishlist {
    flex: 1;
    min-width: 160px;
}

.add-to-cart {
    flex: 2;
    min-width: 200px;
}

/* Product Navigation */
.product-navigation {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 24px;
    border-top: 1px solid var(--border-light);
}

.nav-link {
    color: var(--text-gray);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.nav-link:hover {
    color: var(--accent-pink);
}

/* Image Modal Styles */
.image-modal {
    display: none;
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.95);
    cursor: zoom-out;
}

.modal-close {
    position: absolute;
    top: 20px;
    right: 30px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    z-index: 10001;
}

.modal-close:hover {
    color: var(--accent-pink);
}

.modal-image {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    cursor: default;
}

.modal-navigation {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding: 0 20px;
    pointer-events: none;
}

.modal-nav-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    padding: 10px 15px;
    font-size: 20px;
    cursor: pointer;
    border-radius: 50%;
    transition: all 0.3s ease;
    pointer-events: all;
}

.modal-nav-btn:hover {
    background: var(--accent-pink);
}

/* Responsive Design */
@media (max-width: 992px) {
    .product-details {
        padding-left: 0;
        margin-top: 40px;
    }
    
    .main-product-image {
        height: 500px;
        object-fit: contain;
    }
    
    .product-title {
        font-size: 1.8rem;
    }
}

@media (max-width: 768px) {
    .main-product-image {
        height: 400px;
        object-fit: contain;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .action-buttons .btn {
        flex: none;
        width: 100%;
    }
    
    .product-navigation {
        flex-direction: column;
        gap: 16px;
        text-align: center;
    }
    
    .current-price {
        font-size: 1.5rem;
    }
    
    .original-price {
        font-size: 1.2rem;
    }
}

@media (max-width: 576px) {
    .thumbnail-item {
        width: 60px;
        height: 60px;
    }
    
    .product-title {
        font-size: 1.6rem;
    }
}
</style>

<script>
let currentImageIndex = 0;
let allImages = [];

// Initialize images array
document.addEventListener('DOMContentLoaded', function() {
    @if ($product->foto_product)
        @php
            $photos = json_decode($product->foto_product, true);
        @endphp
        @if (is_array($photos))
            allImages = [
                @foreach ($photos as $photo)
                    "{{ Str::startsWith($photo, 'http') ? $photo : asset('storage/' . $photo) }}",
                @endforeach
            ];
        @endif
    @endif
    
    // Initialize size selection
    const sizeBtns = document.querySelectorAll('.size-btn');
    sizeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            sizeBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
});

// Change main image function
function changeMainImage(imageSrc, index) {
    const mainImage = document.getElementById('mainImage');
    mainImage.src = imageSrc;
    currentImageIndex = index;
    
    // Update thumbnail active state
    const thumbnails = document.querySelectorAll('.thumbnail-item');
    thumbnails.forEach((thumb, i) => {
        thumb.classList.toggle('active', i === index);
    });
}

// Quantity controls
function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    quantityInput.value = parseInt(quantityInput.value) + 1;
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    if (parseInt(quantityInput.value) > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
    }
}

// Image modal functions
function openImageModal() {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const mainImg = document.getElementById('mainImage');
    
    modal.style.display = 'block';
    modalImg.src = mainImg.src;
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

function nextModalImage(event) {
    event.stopPropagation();
    if (allImages.length > 1) {
        currentImageIndex = (currentImageIndex + 1) % allImages.length;
        document.getElementById('modalImage').src = allImages[currentImageIndex];
        changeMainImage(allImages[currentImageIndex], currentImageIndex);
    }
}

function prevModalImage(event) {
    event.stopPropagation();
    if (allImages.length > 1) {
        currentImageIndex = currentImageIndex === 0 ? allImages.length - 1 : currentImageIndex - 1;
        document.getElementById('modalImage').src = allImages[currentImageIndex];
        changeMainImage(allImages[currentImageIndex], currentImageIndex);
    }
}

// Close modal with escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    } else if (event.key === 'ArrowRight') {
        nextModalImage(event);
    } else if (event.key === 'ArrowLeft') {
        prevModalImage(event);
    }
});

// Add to cart functionality
document.querySelector('.add-to-cart').addEventListener('click', function() {
    const quantity = document.getElementById('quantity').value;
    const selectedSize = document.querySelector('.size-btn.active')?.dataset.size || null;
    
    // Check if size selection is required
    const hasSizes = document.querySelector('.size-selection');
    if (hasSizes && !selectedSize) {
        alert('Please select a size before adding to cart.');
        return;
    }
    
    // Here you would typically send an AJAX request to add the item to cart
    console.log('Adding to cart:', {
        productId: '{{ $product->id }}',
        quantity: quantity,
        size: selectedSize
    });
    
    // Show success message (you can implement a toast notification)
    alert('Product added to cart!');
});

// Add to wishlist functionality
document.querySelector('.add-to-wishlist').addEventListener('click', function() {
    const heartIcon = this.querySelector('i');
    
    // Toggle heart icon
    if (heartIcon.classList.contains('far')) {
        heartIcon.classList.remove('far');
        heartIcon.classList.add('fas');
        this.innerHTML = '<i class="fas fa-heart"></i> Added to Wishlist';
    } else {
        heartIcon.classList.remove('fas');
        heartIcon.classList.add('far');
        this.innerHTML = '<i class="far fa-heart"></i> Add to Wishlist';
    }
    
    // Here you would typically send an AJAX request
    console.log('Toggling wishlist for product:', '{{ $product->id }}');
});
</script>
@endsection