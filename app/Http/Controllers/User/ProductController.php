<?php

namespace App\Http\Controllers\User;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all(); 
        return view('user.catalog.homepage', compact('categories'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $id)
                                  ->take(4)
                                  ->get();  
        $categories = Category::all();
        return view('user.products.show', compact('product', 'relatedProducts', 'categories'));
    }

    public function category($category)
    {
        // Convert URL parameter to title case for database lookup
        $categoryName = ucfirst(strtolower($category));
        
        $categoryModel = Category::where('name', $categoryName)->first();
        
        if (!$categoryModel) {
            abort(404);
        }
        
        // Get initial 12 products for this category
        $products = Product::where('category_id', $categoryModel->id)
                          ->with('category')
                          ->take(12)
                          ->get();
        
        $categories = Category::all();
        
        return view('user.shop.category', compact('products', 'categories', 'categoryModel'));
    }

    // New method for AJAX pagination
    public function categoryPaginate(Request $request, $category)
    {
        // Convert URL parameter to title case for database lookup
        $categoryName = ucfirst(strtolower($category));
        
        $categoryModel = Category::where('name', $categoryName)->first();
        
        if (!$categoryModel) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        
        $page = $request->get('page', 1);
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        
        // Get products for this page
        $products = Product::where('category_id', $categoryModel->id)
                          ->with('category')
                          ->skip($offset)
                          ->take($perPage)
                          ->get();
        
        // Check if there are more products
        $totalProducts = Product::where('category_id', $categoryModel->id)->count();
        $hasMore = ($offset + $perPage) < $totalProducts;
        
        // Return JSON response with product HTML
        $html = view('user.shop.partials.product-grid', compact('products'))->render();
        
        return response()->json([
            'html' => $html,
            'hasMore' => $hasMore,
            'currentPage' => $page
        ]);
    }

    public function featured()
    {
        $featuredProducts = Product::where('feature_id', true)
                                   ->with('category')
                                   ->take(12)
                                   ->get();
        $categories = Category::all();
        return view('user.collection.featured', compact('featuredProducts', 'categories'));
    }
}