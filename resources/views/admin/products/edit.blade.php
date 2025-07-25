<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Product
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="dark:text-gray-200">Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            </div>
            
            <div>
                <label class="dark:text-gray-200">Description</label>
                <textarea name="description" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>{{ old('description', $product->description) }}</textarea>
            </div>

            <div>
                <label class="dark:text-gray-200">Price</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            </div>
            
            <div>
                <label class="dark:text-gray-200">Stock</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            </div>

            <div>
                <label class="dark:text-gray-200">Product Photos</label>
                <input type="file" name="foto_product[]" multiple class="w-full dark:text-gray-200" accept="image/*">
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">You can select multiple images for this product.</p>
                
                @if($product->foto_product)
                    <div class="mt-3">
                        <label class="block text-sm font-medium dark:text-gray-200 mb-2">Current Photos:</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach(json_decode($product->foto_product) as $photo)
                                <img src="{{ asset('storage/' . $photo) }}" alt="Product Photo" class="w-full h-20 object-cover rounded border">
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div>
                <label class="block mb-2 font-medium dark:text-gray-200">Category</label>
                <select name="category_id" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 font-medium dark:text-gray-200">Feature <span class="text-sm text-gray-500">(Optional)</span></label>
                <select name="feature_id" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Select Feature (Optional)</option>
                    @foreach ($features as $feature)
                        <option value="{{ $feature->id }}" {{ old('feature_id', $product->feature_id) == $feature->id ? 'selected' : '' }}>
                            {{ $feature->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-1">You can optionally assign this product to a feature for special promotion or highlighting</p>
                @if($product->feature)
                    <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">Currently assigned to: <strong>{{ $product->feature->name }}</strong></p>
                @endif
            </div>

            <div>
                <label class="block font-medium dark:text-gray-200 mb-3">Available Sizes</label>
                <div class="grid grid-cols-4 gap-3">
                    @php
                        $availableSizes = ['XS', 'S', 'XM', 'M', 'L', 'XL', '2XL'];
                        
                        // Handle both JSON string and array cases
                        $productSizes = [];
                        if ($product->available_sizes) {
                            if (is_string($product->available_sizes)) {
                                $productSizes = json_decode($product->available_sizes, true) ?? [];
                            } elseif (is_array($product->available_sizes)) {
                                $productSizes = $product->available_sizes;
                            }
                        }
                        
                        $oldSizes = old('available_sizes', $productSizes);
                    @endphp
                    @foreach($availableSizes as $size)
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="available_sizes[]" value="{{ $size }}" 
                                   {{ in_array($size, $oldSizes) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-300">{{ $size }}</span>
                        </label>
                    @endforeach
                </div>                
                @if($product->available_sizes)
                    <div class="mt-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Current sizes: </span>
                        <span class="text-sm font-medium text-blue-600 dark:text-blue-400">
                            @if(is_array($product->available_sizes))
                                {{ implode(', ', $product->available_sizes) }}
                            @else
                                {{ implode(', ', json_decode($product->available_sizes, true) ?? []) }}
                            @endif
                        </span>
                    </div>
                @endif
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Update</button>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Back</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validation Failed',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#d33',
        });
    </script>
    @endif
</x-app-layout>