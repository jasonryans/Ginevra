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
                <label class="dark:text-gray-200">Price</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            </div>
            
            <div>
                <label class="dark:text-gray-200">Stock</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
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