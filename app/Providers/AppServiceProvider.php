<?php

namespace App\Providers;

use App\Models\Feature;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('user.navbar', function ($view) {
            $categories = Category::all(); 
            $features = Feature::all();
            
            $view->with('features', $features);
            $view->with('categories', $categories);
        });
    }
}
