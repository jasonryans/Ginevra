<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Add Product
        </h2>
    </x-slot>
<div class="max-w-xl mx-auto py-8">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block font-medium dark:text-gray-200">Name</label>
            <input type="text" name="name" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div>
            <label class="block font-medium dark:text-gray-200">Description</label>
            <textarea name="description" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></textarea>
        </div>
        <div>
            <label class="block font-medium dark:text-gray-200">Price</label>
            <input type="number" name="price" step="0.01" min="0" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div>
            <label class="block font-medium dark:text-gray-200">Stock</label>
            <input type="number" name="stock" min="0" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div>
            <label class="block font-medium dark:text-gray-200">Picture</label>
            <input type="file" name="foto_product[]" multiple class="file-input file-input-bordered w-full dark:text-gray-200" required>
            <p class="text-sm text-gray-500 mt-1">Choose one or more than one (JPG, JPEG, PNG, max 2MB)</p>
        </div>
        <div>
            <label class="block font-medium dark:text-gray-200">Category</label>
            <select name="category_id" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                <option value="">Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>        
        <div>
            <label class="block font-medium dark:text-gray-200 mb-3">Available Sizes</label>
            <div class="grid grid-cols-4 gap-3">
                @php
                    $availableSizes = ['XS', 'S', 'XM', 'M', 'L', 'XL', '2XL'];
                @endphp
                @foreach($availableSizes as $size)
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="available_sizes[]" value="{{ $size }}" 
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">{{ $size }}</span>
                    </label>
                @endforeach
            </div>
            <p class="text-sm text-gray-500 mt-2">Select all sizes that are available for this product</p>
        </div>

        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded ml-2">Kembali</a>
    </form>
</div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#d33',
        });
    </script>
    @endif
</x-app-layout>