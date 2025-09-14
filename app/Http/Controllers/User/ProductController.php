<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $features = Feature::all();
        return view('user.catalog.homepage', compact('categories', 'features'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->take(4)
            ->get();
        $categories = Category::all();
        $features = Feature::all();

        // Get previous product within the same category
        $previousProduct = Product::where('category_id', $product->category_id)
            ->where('id', '<', $id)
            ->orderBy('id', 'desc')
            ->first();

        // Get next product within the same category
        $nextProduct = Product::where('category_id', $product->category_id)
            ->where('id', '>', $id)
            ->orderBy('id', 'asc')
            ->first();

        return view('user.products.show', compact('product', 'relatedProducts', 'categories', 'features', 'previousProduct', 'nextProduct'));
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

        $featuredProducts = Product::whereNotNull('feature_id')
            ->whereHas('feature')
            ->with(['feature'])
            ->take(5) // Limit to 5 featured products for sidebar
            ->get();

        $categories = Category::all();
        $features = Feature::all();


        return view('user.shop.category', compact('products', 'categories', 'categoryModel', 'features', 'featuredProducts'));
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

    public function featured($type = null)
    {
        $categories = Category::all();
        $features = Feature::all();

        if ($type) {
            // Convert URL parameter to title case for database lookup
            $featureName = ucwords(str_replace('-', ' ', $type));

            $featureModel = Feature::where('name', $featureName)->first();

            if (!$featureModel) {
                abort(404);
            }

            // Get initial 12 products for this feature
            $products = Product::where('feature_id', $featureModel->id)
                ->with(['feature'])
                ->take(12)
                ->get();

            $pageTitle = $featureName;
        } else {
            // Show all products that have any features (feature_id is not null)
            $products = Product::whereNotNull('feature_id')
                ->whereHas('feature')
                ->with(['feature'])
                ->take(12)
                ->get();

            $pageTitle = 'Featured Products';
            $featureModel = null;
        }

        return view('user.collection.featured', compact('products', 'categories', 'features', 'pageTitle', 'type', 'featureModel'));
    }

    // New method for AJAX pagination of featured products
    public function featuredPaginate(Request $request, $type = null)
    {
        if ($type) {
            // Convert URL parameter to title case for database lookup
            $featureName = ucwords(str_replace('-', ' ', $type));

            $featureModel = Feature::where('name', $featureName)->first();

            if (!$featureModel) {
                return response()->json(['error' => 'Feature not found'], 404);
            }
        }

        $page = $request->get('page', 1);
        $perPage = 12;
        $offset = ($page - 1) * $perPage;

        if ($type && isset($featureModel)) {
            // Get products for this specific feature
            $products = Product::where('feature_id', $featureModel->id)
                ->whereNotNull('feature_id')
                ->whereHas('feature')
                ->with(['feature'])
                ->skip($offset)
                ->take($perPage)
                ->get();

            // Check if there are more products
            $totalProducts = Product::where('feature_id', $featureModel->id)
                ->whereNotNull('feature_id')
                ->whereHas('feature')
                ->count();
        } else {
            // Get all featured products
            $products = Product::whereNotNull('feature_id')
                ->whereHas('feature')
                ->with(['feature'])
                ->skip($offset)
                ->take($perPage)
                ->get();

            // Check if there are more products
            $totalProducts = Product::whereNotNull('feature_id')
                ->whereHas('feature')
                ->count();
        }

        $hasMore = ($offset + $perPage) < $totalProducts;

        // Return JSON response with product HTML
        $html = view('user.collection.partials.product-grid', compact('products'))->render();

        return response()->json([
            'html' => $html,
            'hasMore' => $hasMore,
            'currentPage' => $page
        ]);
    }

    public function carts()
    {
        $user = Auth::user();
        $carts = $user->carts()->with('product')->get();

        return view('user.carts.index', compact('carts'));
    }

    public function addToCart(Request $request)
    {
        try {
            $user = Auth::user();
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity', 1);
            $size = $request->input('size');

            // Check if product exists
            $product = Product::findOrFail($productId);

            // Check if already in cart (including size if applicable)
            $existingCart = $user->carts()->where('product_id', $productId);

            // If size is provided, also check for size match
            if ($size) {
                $existingCart = $existingCart->where('size', $size);
            }

            $existingCart = $existingCart->first();

            if ($existingCart) {
                // Update quantity
                $existingCart->quantity += $quantity;
                $existingCart->save();
            } else {
                // Add new cart item
                $cartData = [
                    'product_id' => $productId,
                    'quantity' => $quantity
                ];

                // Add size if provided
                if ($size) {
                    $cartData['size'] = $size;
                }

                $user->carts()->create($cartData);
            }

            // Get updated cart count (number of distinct products, not total quantity)
            $cartCount = $user->carts()->count();

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cartCount' => $cartCount
            ]);
        } catch (\Exception $e) {
            \Log::error('Add to cart error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeFromCart(Request $request)
    {
        $user = Auth::user();
        $productId = $request->input('product_id');

        $cart = $user->carts()->where('product_id', $productId)->first();

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart'
            ]);
        }

        $cart->delete();

        // Get updated cart count (number of distinct products)
        $cartCount = $user->carts()->count();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
            'cartCount' => $cartCount
        ]);
    }

    public function updateCartQuantity(Request $request)
    {
        $user = Auth::user();
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        if ($quantity <= 0) {
            return $this->removeFromCart($request);
        }

        $cart = $user->carts()->where('product_id', $productId)->first();

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart'
            ]);
        }

        $cart->quantity = $quantity;
        $cart->save();

        // Get updated cart count (number of distinct products)
        $cartCount = $user->carts()->count();

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'cartCount' => $cartCount
        ]);
    }

    public function getCartCount()
    {
        $user = Auth::user();
        $cartCount = $user ? $user->carts()->count() : 0;

        return response()->json([
            'cartCount' => $cartCount
        ]);
    }

    public function checkoutForm()
    {
        $user = Auth::user();
        $carts = $user->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('user.carts.index')->with('error', 'Your cart is empty.');
        }

        return view('user.checkout.checkout_form', compact('carts'));
    }
}
