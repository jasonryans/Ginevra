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
                </a>

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
    </div>
@endforeach
