@extends('user.base')

@php
    $hideNewsletter = true;
@endphp

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Shopping Cart</h1>
            </div>
        </div>

        @if ($carts->count() > 0)
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            @foreach ($carts as $cart)
                                <div class="row align-items-center cart-item mb-3 pb-3 border-bottom"
                                    data-product-id="{{ $cart->product_id }}">
                                    <div class="col-md-2">
                                        @if ($cart->product->foto_product)
                                            @php
                                                $photos = is_array($cart->product->foto_product)
                                                    ? $cart->product->foto_product
                                                    : json_decode($cart->product->foto_product, true);
                                            @endphp
                                            @if (is_array($photos) && count($photos) > 0)
                                                <img src="{{ Str::startsWith($photos[0], 'http') ? $photos[0] : asset('storage/' . $photos[0]) }}"
                                                    alt="{{ $cart->product->name }}" class="img-fluid rounded">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                    style="height: 80px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                style="height: 80px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="mb-1">{{ $cart->product->name }}</h6>
                                        <p class="text-muted small mb-0">{{ $cart->product->category->name ?? '' }}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary btn-sm qty-btn" type="button"
                                                onclick="updateQuantity({{ $cart->product_id }}, {{ $cart->quantity - 1 }})">-</button>
                                            <input type="number" class="form-control form-control-sm text-center"
                                                value="{{ $cart->quantity }}" min="1" readonly>
                                            <button class="btn btn-outline-secondary btn-sm qty-btn" type="button"
                                                onclick="updateQuantity({{ $cart->product_id }}, {{ $cart->quantity + 1 }})">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <strong>IDR {{ number_format($cart->product->price, 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <button class="btn btn-outline-danger btn-sm"
                                            onclick="removeFromCart({{ $cart->product_id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Order Summary</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span class="subtotal">IDR
                                    {{ number_format($carts->sum(function ($cart) {return $cart->product->price * $cart->quantity;}),0,',','.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span>Free</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total:</strong>
                                <strong class="total">IDR
                                    {{ number_format($carts->sum(function ($cart) {return $cart->product->price * $cart->quantity;}),0,',','.') }}</strong>
                            </div>
                            <button class="btn btn-primary w-100">Proceed to Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12 text-center">
                    <div class="card">
                        <div class="card-body py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h4>Your cart is empty</h4>
                            <p class="text-muted">Add some products to your cart to see them here.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        function updateQuantity(productId, quantity) {
            if (quantity < 1) {
                removeFromCart(productId);
                return;
            }

            fetch('{{ route('user.carts.update') }}', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Reload to update totals
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to update quantity. Please try again.',
                            confirmButtonColor: '#d63384'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while updating quantity.',
                        confirmButtonColor: '#d63384'
                    });
                });
        }

        function removeFromCart(productId) {
            Swal.fire({
                title: 'Remove Item?',
                text: "Are you sure you want to remove this item from your cart?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d63384',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Removing...',
                        text: 'Please wait while we remove the item from your cart.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch('{{ route('user.carts.remove') }}', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: productId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update cart count in navbar
                                const cartCountElements = document.querySelectorAll('.cart-count');
                                const cartBadges = document.querySelectorAll('.position-absolute.badge');

                                cartCountElements.forEach(element => {
                                    element.textContent = data.cartCount;
                                });

                                // Show/hide badge based on cart count
                                cartBadges.forEach(badge => {
                                    if (data.cartCount > 0) {
                                        badge.classList.remove('d-none');
                                    } else {
                                        badge.classList.add('d-none');
                                    }
                                });

                                // Show success message and reload page
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Removed!',
                                    text: 'Item has been removed from your cart.',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: data.message || 'Failed to remove item from cart.',
                                    confirmButtonColor: '#d63384'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'An error occurred while removing the item.',
                                confirmButtonColor: '#d63384'
                            });
                        });
                }
            });
        }
    </script>
@endsection
