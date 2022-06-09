<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StyleController;
use App\Http\Controllers\OderController;


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('welcome');

//==================================CLIENT==================================================
Route::prefix('/')->group(function () {
    Route::get('logout', [LoginController::class, 'logout']);
    Route::resource('/', HomeController::class);
    Route::get('/product', 'HomeController@product');
    Route::get('/productDetail/{id}', 'HomeController@productDetail');
    Route::get('/category-page/{id}', [HomeController::class, 'category_page']);
    Route::get('/blog', 'HomeController@blog');
    Route::get('/contact', 'HomeController@contact')->name('contact');
    Route::resource('profile', ClientController::class)->middleware('checkProfile');
});

//===============================Cart Checkout=============================================
Route::prefix('/')->middleware('checkAddCart')->group(function () {
    Route::post('/save-cart', [ClientController::class, 'save_cart']);
    Route::get('/show-cart', [ClientController::class, 'show_cart'])->name('show.cart');
    Route::post('/update-cart-quantity', [ClientController::class, 'update_cart_quantity']);
    Route::get('/delete-to-cart/{rowId}', [ClientController::class, 'delete_to_cart']);
    Route::get('/checkout', [ClientController::class, 'checkout']);
});


//================================LOGIN======================================================
Route::prefix('/')->group(function () {
    Route::get('login', [LoginController::class, 'login'])
        ->name('admin.auth.login');
    Route::post('login', [LoginController::class, 'checkLogin'])
        ->name('admin.auth.check-login');

    Route::get('/quen-mat-khau', [MailController::class, 'forgotPass']);
    Route::get('/update-new-pass', [MailController::class, 'updatePass']);
    Route::post('/recover-pass', [MailController::class, 'recoverPass']);
    Route::post('/update-new-pass', [MailController::class, 'update_new_pass']);
});


//--------------------------Login Facebook--------------------------------
Route::controller(SocialController::class)->group(function () {
    Route::get('facebook', 'redirectToFacebook')->name('auth.facebook');
    Route::any('facebook/callback', 'handleFacebookCallback');
});

//---------------------------Login google-----------------------------

Route::get('/login-google', [SocialController::class, 'login_google']);
Route::get('/google/callbackGG', [SocialController::class, 'callback_google']);


//================================ADMIN======================================================

Route::prefix('admin')->middleware('admin.login')->group(function () {
    Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout']);

    Route::get('/home', [AdminController::class, 'index'])->name('admin.index');
    Route::resource('user', UserController::class);
    Route::resource('accountadmin', AdminController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
    // Route::get('/product/edit/{id}', [App\Http\Controllers\ProductController::class, 'showw']);
    Route::get('/unactive-product/{id}', [ProductController::class, 'unactive']);
    Route::get('/active-product/{id}', [ProductController::class, 'active']);
    // ->middleware('auth.admin.products');
    Route::resource('style', StyleController::class);
    Route::resource('oder', OderController::class);
});









//=======================================TEST================================================

Route::get('/templateadmin', function () {
    return view('admin.app');
});

Route::get('/accountadmin', function () {
    return view('admin.account.index');
});

Route::get('/product', function () {
    return view('admin.product.index');
});

Route::get('/product/new', function () {
    return view('admin.product.new');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
