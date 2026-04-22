<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    CatalogController,
    CartController,
    OrderController,
    ReviewController,
    ProfileController
};
use App\Http\Controllers\Admin\{
    ProductController as AdminProductController,
    OrderController as AdminOrderController,
    DashboardController
};

// ─── Routes publiques ─────────────────────────────
Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/products/{product:slug}', [CatalogController::class, 'show'])->name('products.show');

// ─── Auth ─────────────────────────────────────────
Auth::routes();

// ─── Panier ───────────────────────────────────────
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',               [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{id}',  [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear',       [CartController::class, 'clear'])->name('clear');
});

// ─── Routes authentifiées ─────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/profile',          [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/checkout',                    [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders',                     [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders',                      [OrderController::class, 'history'])->name('orders.history');
    Route::get('/orders/{order}',              [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/cancel',     [OrderController::class, 'cancel'])->name('orders.cancel');

    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}',         [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// ─── Routes Admin ─────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('orders',   AdminOrderController::class)->only(['index', 'show', 'update']);
});