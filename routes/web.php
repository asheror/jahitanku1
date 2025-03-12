<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/1', function () {
    return view('users.index');
});

use App\Http\Controllers\BlogUsersController;

// Rute untuk menampilkan semua blog
Route::get('/blog', [BlogUsersController::class, 'index'])->name('blog.index');

// Rute untuk menampilkan detail blog
Route::get('/blog-detail/{id}', [BlogUsersController::class, 'detail'])->name('blog.detail');


Route::get('/dashboard' , function () {
    return view('admin.dashboard');
});

Route::get('/detailblog' , function () {
    return view('users.blog-detail');
});

Route::get('/faq' , function () {
    return view('users.faq-1');
});

Route::get('/cart' , function () {
    return view('users.view-cart');
});

Route::get('/brands' , function () {
    return view('users.brands');
});

Route::get('/checkout' , function () {
    return view('users.checkout');
});

Route::get('/searcH' , function () {
    return view('users.home-search');
});

Route::get('/address' , function () {
    return view('users.my-account-address');
});

Route::get('/editAddress' , function () {
    return view('users.my-account-edit-address');
});

Route::get('/editAccount' , function () {
    return view('users.my-account-edit');
});

Route::get('/order' , function () {
    return view('users.my-account-orders');
});

Route::get('/wishlist' , function () {
    return view('users.my-account-wishlist');
});

Route::get('/account' , function () {
    return view('users.my-account-edit');
});

Route::get('/payment' , function () {
    return view('users.payment-confirmation');
});

Route::get('/PP' , function () {
    return view('users.privacy-policy');
});



use App\Http\Controllers\WishlistController;

Route::middleware('auth')->group(function () {
    Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
    Route::get('/wishlist', [WishlistController::class, 'viewWishlist'])->name('wishlist.view');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
});



//usermanagement
use App\Http\Controllers\UserManagementController;

//Rute Usermanagement
Route::get('/usermanagement', [UserManagementController::class, 'index'])->name('usermanagement.index');
Route::resource('users', UserManagementController::class);

Route::middleware('auth')->group(function () {
    // Rute Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Logout route
    Route::post('/logout', function (): RedirectResponse {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});


use App\Http\Controllers\RegisterController;

Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');


use App\Http\Controllers\LoginController;

Route::get('/login', [LoginController::class, 'create'])->name('login.create');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');



Route::get('/shop1' , function () {
    return view('users.shop-collection-sub');
});

Route::get('/shopd' , function () {
    return view('users.product-detail');
});

Route::get('/shop-men' , function () {
    return view('users.shop-men');
});

//Rute ShopGaming Notebook
use App\Http\Controllers\ShopController;

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

use App\Http\Controllers\CategoryController;

Route::resource('categories', CategoryController::class);

//Rute ProductManagement
use App\Http\Controllers\ProductController;

Route::resource('products', ProductController::class);

//Rute Home
use App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'index'])->name('Home.index');


Route::get('/profile-edit' , function () {
    return view('users.my-account-edit');
});


use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


//Rute keranjang
use App\Http\Controllers\CartController;

Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/remove-from-cart/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/update-cart/{id}', [CartController::class, 'updateCart'])->name('cart.update');

use App\Http\Controllers\CheckoutController;

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/payment-success/{orderId}', [CheckoutController::class, 'success'])->name('payment.success');
Route::get('/payment-pending', function () {
    return view('payment-pending');
});
Route::get('/payment-failed', function () {
    return view('payment-failed');
});

Route::post('/payment/notification', [CheckoutController::class, 'handlePaymentNotification']);
Route::get('/payment/notification', [CheckoutController::class, 'handlePaymentNotification']);

use App\Http\Controllers\OrdersayaController;

Route::resource('orders', OrdersayaController::class);

use App\Http\Controllers\PesananManagementController;

Route::resource('PesananManagement', PesananManagementController::class);



use App\Http\Controllers\BlogController;

Route::resource('blogs', BlogController::class);

//detail-product
use App\Http\Controllers\ProductDetailsController;

Route::get('/beli/{id_produk}', [ProductDetailsController::class, 'show'])->name('product.details');