<x-app-layout>
    <div class="max-w-2xl mx-auto py-8">
        <div class="flex items-start gap-6">
            @if ($product->foto_product)
                @php
                    $photos = is_array($product->foto_product) ? $product->foto_product : json_decode($product->foto_product, true);
                @endphp
                <img src="{{ asset('storage/' . $photos[0]) }}" 
                    class="w-32 h-44 object-cover rounded shadow"
                    alt="{{ $product->name }}">
            @endif
            <div>
                <h1 class="text-3xl font-bold mb-2 dark:text-gray-200">{{ $product->name }}
                </h1>
                <div class="mb-1">
                    <span class="font-semibold dark:text-gray-200">Category: </span>
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1">{{ $product->category->name }}</span>
                </div>
                <div class="mb-1 dark:text-gray-500 mt-2">
                    <span class="font-bold mb-2 dark:text-gray-200">Price: </span>Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
                <div class="mb-1 dark:text-gray-500 mt-2">
                    <span class="font-bold mb-2 dark:text-gray-200">Stock: </span>{{ $product->stock }} items
                </div>
            </div>
        </div>

        <div class="mt-6">
            <span class="font-bold mb-2 dark:text-gray-200">Description:</span>
            <p class="dark:text-gray-500 mt-2">{{ $product->description }}</p>
        </div>

        @if ($product->foto_product && count($photos) > 1)
        <div class="mt-6">
            <span class="font-bold mb-2 dark:text-gray-200">Product Images:</span>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-2">
                @foreach ($photos as $photo)
                    <img src="{{ asset('storage/' . $photo) }}" 
                        class="w-full h-32 object-cover rounded shadow"
                        alt="{{ $product->name }}">
                @endforeach
            </div>
        </div>
        @endif

        @if ($product->reviews && $product->reviews->count() > 0)
        <div class="mt-6">
            <span class="font-bold mb-2 dark:text-gray-200">Reviews:</span>
            <div class="space-y-4 mt-2">
                @foreach ($product->reviews->take(5) as $review)
                    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-medium dark:text-gray-200">{{ $review->user->name ?? 'Anonymous' }}</span>
                            <span class="text-yellow-500">{{ str_repeat('★', $review->rating) }}</span>
                        </div>
                        <p class="dark:text-gray-500">{{ $review->review }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-app-layout>