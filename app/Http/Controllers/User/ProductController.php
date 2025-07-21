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
        // Map URL slugs to category names from your seeder
        $categoryMap = [
            'tops' => 'Tops',
            'bottoms' => 'Bottoms', 
            'outerwear' => 'Outerwear',
            'dresses' => 'Dresses',
            'accessories' => 'Accessories'
        ];
        
        if (!isset($categoryMap[$category])) {
            abort(404);
        }
        
        $categoryName = $categoryMap[$category];
        $categoryModel = Category::where('name', $categoryName)->first();
        
        if (!$categoryModel) {
            abort(404);
        }
        
        // Get products for this category
        $products = Product::where('category_id', $categoryModel->id)
                          ->with('category')
                          ->get();
        
        $categories = Category::all();
        
        return view('user.shop.category', compact('products', 'categories', 'categoryModel'));
    }
}
