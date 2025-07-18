<?php

namespace App\Http\Controllers\User;
use Carbon\Carbon;
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
}
