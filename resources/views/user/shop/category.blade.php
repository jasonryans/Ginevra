@extends('user.base')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">{{ $categoryModel->name }}</h1>
        </div>
    </div>
    
    <div class="row">
        @if($products->count() > 0)
            @foreach($products as $product)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card h-100">
                         @if($product->foto_product)
                            @php
                                $photos = json_decode($product->foto_product, true);
                            @endphp
                            @if(is_array($photos) && count($photos) > 0)
                                <img src="{{ asset('storage/' . $photos[0]) }}" 
                                class="w-32 h-32 object-cover rounded shadow" 
                                alt="{{ $product->name }}">
                            @else
                                <span class="italic text-gray-400 dark:text-gray-500">No Image</span>
                            @endif
                        @else
                            <span class="italic text-gray-400 dark:text-gray-500">No Image</span>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <div class="mt-auto">
                                <p class="card-text"><strong>${{ number_format($product->price, 2) }}</strong></p>
                                <a href="{{ route('user.products.show', $product->id) }}" class="btn btn-primary">View Details</a>
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
    
    <!-- Pagination -->
    <div class="row">
        <div class="col-12">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection