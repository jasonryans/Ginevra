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
            $featuredCollections = Feature::all(); 
            $categories = Category::all(); 
            
            $view->with('featuredCollections', $featuredCollections);
            $view->with('categories', $categories);
        });
    }
}
