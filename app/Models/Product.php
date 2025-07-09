<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description', 'price', 'stock'];

    protected $casts = [
        'foto_product' => 'array', 
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'reviews', 'product_id', 'user_id')
            ->withPivot('review', 'rating')
            ->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items', 'product_id', 'order_id')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    } 
}
