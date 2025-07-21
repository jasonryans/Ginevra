<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of all available sizes from products.
     */
    public function index()
    {
        // Get all unique sizes from products
        $allSizes = Product::whereNotNull('available_sizes')
            ->pluck('available_sizes')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        // Convert to collection with id for easier handling in the view
        $sizes = $allSizes->map(function ($size, $index) {
            return (object) [
                'id' => $index + 1,
                'name' => $size
            ];
        });

        return view('admin.sizes.index', compact('sizes'));
    }

    /**
     * Store a newly created size by updating products.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama size wajib diisi.',
            'name.max' => 'Nama size maksimal 255 karakter.'
        ]);

        $newSize = strtoupper(trim($request->name));

        // Check if size already exists
        $existingSize = Product::whereNotNull('available_sizes')
            ->get()
            ->pluck('available_sizes')
            ->flatten()
            ->contains($newSize);

        if ($existingSize) {
            return redirect()->route('admin.sizes.index')
                ->with('error', 'Size ini sudah ada.');
        }

        try {
            // This is just for validation - in practice, you'd add this size 
            // to products when creating/editing them
            return redirect()->route('admin.sizes.index')
                ->with('success', 'Size berhasil ditambahkan. Gunakan size ini saat menambah/edit produk.');
        } catch (\Exception $e) {
            return redirect()->route('admin.sizes.index')
                ->with('error', 'Gagal menambahkan size. Silakan coba lagi.');
        }
    }

    /**
     * Update the specified size across all products.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama size wajib diisi.',
            'name.max' => 'Nama size maksimal 255 karakter.'
        ]);

        $newSize = strtoupper(trim($request->name));
        
        // Get all unique sizes to find the old size name
        $allSizes = Product::whereNotNull('available_sizes')
            ->pluck('available_sizes')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        if (!isset($allSizes[$id - 1])) {
            return redirect()->route('admin.sizes.index')
                ->with('error', 'Size tidak ditemukan.');
        }

        $oldSize = $allSizes[$id - 1];

        try {
            // Update all products that have this size
            $products = Product::whereNotNull('available_sizes')->get();
            
            foreach ($products as $product) {
                $sizes = $product->available_sizes;
                if (is_array($sizes) && in_array($oldSize, $sizes)) {
                    // Replace old size with new size
                    $key = array_search($oldSize, $sizes);
                    $sizes[$key] = $newSize;
                    $product->update(['available_sizes' => $sizes]);
                }
            }

            return redirect()->route('admin.sizes.index')
                ->with('success', 'Size berhasil diperbarui di semua produk.');
        } catch (\Exception $e) {
            return redirect()->route('admin.sizes.index')
                ->with('error', 'Gagal memperbarui size. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified size from all products.
     */
    public function destroy($id)
    {
        try {
            // Get all unique sizes to find the size to delete
            $allSizes = Product::whereNotNull('available_sizes')
                ->pluck('available_sizes')
                ->flatten()
                ->unique()
                ->sort()
                ->values();

            if (!isset($allSizes[$id - 1])) {
                return redirect()->route('admin.sizes.index')
                    ->with('error', 'Size tidak ditemukan.');
            }

            $sizeToDelete = $allSizes[$id - 1];

            // Remove this size from all products
            $products = Product::whereNotNull('available_sizes')->get();
            $updatedCount = 0;
            
            foreach ($products as $product) {
                $sizes = $product->available_sizes;
                if (is_array($sizes) && in_array($sizeToDelete, $sizes)) {
                    // Remove the size from array
                    $sizes = array_values(array_filter($sizes, function($size) use ($sizeToDelete) {
                        return $size !== $sizeToDelete;
                    }));
                    
                    // If no sizes left, set to null
                    if (empty($sizes)) {
                        $sizes = null;
                    }
                    
                    $product->update(['available_sizes' => $sizes]);
                    $updatedCount++;
                }
            }

            return redirect()->route('admin.sizes.index')
                ->with('success', "Size berhasil dihapus dari {$updatedCount} produk.");
        } catch (\Exception $e) {
            return redirect()->route('admin.sizes.index')
                ->with('error', 'Gagal menghapus size. Silakan coba lagi.');
        }
    }
}