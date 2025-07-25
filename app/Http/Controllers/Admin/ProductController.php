<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feature;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(){
        $products = Product::with('category', 'feature')->get();
        return view('admin.products.index', compact('products'));
    }
    
     public function create()
    {
        $categories = Category::all();
        $features = Feature::all(); 
        return view('admin.products.create', compact('categories', 'features'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'feature_id' => 'nullable|exists:features,id', 
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'foto_product' => 'required|array|min:1',
            'foto_product.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'available_sizes' => 'required|array',
            'available_sizes.*' => 'in:XS,S,XM,M,L,XL,2XL'
        ]);

        $data = $request->only(['category_id', 'name', 'description', 'price', 'stock']);

        $photos = [];
        foreach ($request->file('foto_product') as $photo) {
            $photos[] = $photo->store('products', 'public');
        }
        $data['foto_product'] = json_encode($photos);

        $data['available_sizes'] = $request->has('available_sizes') ?  json_encode($request->available_sizes) : null;

        if (empty($data['feature_id'])) {
            $data['feature_id'] = null;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $features = Feature::all();
        $product->load('category');
        $product->load('feature');
        return view('admin.products.edit', compact('product', 'categories', 'features'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'feature_id' => 'nullable|exists:features,id', 
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'foto_product' => 'required|array',
            'foto_product.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'available_sizes' => 'required|array',
            'available_sizes.*' => 'in:XS,S,XM,M,L,XL,2XL'
        ]);

        $data = $request->only(['category_id', 'name', 'description', 'price', 'stock']);

        if ($request->hasFile('foto_product')) {
            $photos = [];
            foreach ($request->file('foto_product') as $photo) {
                $photos[] = $photo->store('products', 'public');
            }
            $data['foto_product'] = json_encode($photos);
        }

        $data['available_sizes'] = $request->has('available_sizes') ? json_encode($request->available_sizes) : null;

        if (empty($data['feature_id'])) {
            $data['feature_id'] = null;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }
}
