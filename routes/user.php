<?php

use App\Http\Controllers\User\FooterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ProfilePictureController;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/shop/category/{category}', [ProductController::class, 'category'])->name('user.shop.category');
Route::get('/shop/category/{category}/paginate', [ProductController::class, 'categoryPaginate'])->name('user.category.paginate'); // Add this line for AJAX pagination
Route::get('/products/{id}', [ProductController::class, 'show'])->name('user.products.show');

Route::get('/featured/{type}', [ProductController::class, 'featured'])->name('user.collection.featured');
Route::get('/featured', [ProductController::class, 'featured'])->name('user.collection.featured.all');
Route::get('/featured/paginate', [ProductController::class, 'featuredPaginate'])->name('user.featured.paginate');
Route::get('/featured/{type}/paginate', [ProductController::class, 'featuredPaginate'])->name('user.featured.type.paginate');

Route::get('/cart', [ProductController::class, 'carts'])->name('user.carts.index');

Route::get('/term-and-condition', [FooterController::class, 'term'])->name('user.footer.term');
Route::get('/shipping-information', [FooterController::class, 'shippingInformation'])->name('user.footer.shipping-information');
Route::get('/payment-confirmation', [FooterController::class, 'paymentConfirmation'])->name('user.footer.payment-confirmation');
Route::get('/faq', [FooterController::class, 'faq'])->name('user.footer.faq');
Route::get('/return-policy', [FooterController::class, 'returnPolicy'])->name('user.footer.return-policy');
Route::get('/condition-of-use', [FooterController::class, 'conditionOfUse'])->name('user.footer.condition-of-use');
Route::get('/about', [FooterController::class, 'about'])->name('user.footer.about');
Route::get('/contact-customer-care', [FooterController::class, 'contactCustomerCare'])->name('user.footer.contact-customer-care');


Route::middleware('auth')->group(function () {
    Route::get('/home', [ProductController::class, 'index'])->name('user.home');

    // Uncomment and add other user routes as needed
    // Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    // Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
    // Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    // Route::get('/shop/category/{category}', [ProductController::class, 'category'])->name('user.shop.category');

    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('user.profile.destroy');
    Route::get('/profile/picture/edit', [ProfilePictureController::class, 'edit'])->name('user.profile.picture.edit');
    Route::post('/profile/picture', [ProfilePictureController::class, 'update'])->name('user.profile.picture.update');

    // Cart routes
    Route::post('/cart/add', [ProductController::class, 'addToCart'])->name('user.carts.add');
    Route::delete('/cart/remove', [ProductController::class, 'removeFromCart'])->name('user.carts.remove');
    Route::patch('/cart/update', [ProductController::class, 'updateCartQuantity'])->name('user.carts.update');
    Route::get('/cart/count', [ProductController::class, 'getCartCount'])->name('user.carts.count');

    // Checkout routes
    Route::get('/checkout', [ProductController::class, 'checkoutForm'])->name('user.checkout.checkout_form');
});
