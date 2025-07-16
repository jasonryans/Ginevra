<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Product List
        </h2>
    </x-slot>
<div class="max-w-6xl mx-auto py-8">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 dark:bg-green-800 dark:border-green-600 dark:text-green-100">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="overflow-x-auto rounded-xl shadow">
    <table class="table w-full text-left text-gray-600 dark:text-gray-300">
        <thead class="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
            <tr>
                <th class="py-3 px-4 dark:text-gray-200">Foto Produk</th>
                <th class="py-3 px-4 dark:text-gray-200">Nama</th>
                <th class="py-3 px-4 dark:text-gray-200">Kategori</th>
                <th class="py-3 px-4 dark:text-gray-200">Harga</th>
                <th class="py-3 px-4 dark:text-gray-200">Stok</th>
                <th class="py-3 px-4 dark:text-gray-200">Aksi</th>
            </tr>
        </thead>
        <tbody class="dark:bg-gray-800">
            @foreach($products as $product)
                <tr class="border-b hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700">
                    <td class="py-2 px-4">
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
                    </td>
                    <td class="py-2 px-4 font-medium dark:text-gray-200">{{ $product->name }}</td>
                    <td class="py-2 px-4">
                        @if($product->category)
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $product->category->name }}</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 dark:text-gray-200">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 dark:text-gray-200">{{ $product->stock }}</td>
                    <td class="py-2 px-4 flex gap-1">
                        <a href="{{ route('admin.products.edit', $product) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline delete-form">
                            @csrf @method('DELETE')
                            <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm delete-btn" data-product-name="{{ $product->name }}">Hapus</button>
                        </form>
                        <a href="{{ route('admin.products.show', $product) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productName = this.getAttribute('data-product-name');
            const form = this.closest('.delete-form');
            
            Swal.fire({
                title: 'Yakin hapus produk?',
                text: `Produk "${productName}" akan dihapus permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#3085d6',
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops!',
        text: '{{ session('error') }}',
        confirmButtonColor: '#d33',
    });
</script>
@endif

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        confirmButtonColor: '#d33',
    });
</script>
@endif
</x-app-layout>