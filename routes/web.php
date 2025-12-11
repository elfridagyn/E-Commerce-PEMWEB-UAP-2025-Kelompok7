<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ================= CONTROLLERS =================

// AUTH & PROFILE
use App\Http\Controllers\ProfileController;

// ADMIN
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminStoreVerificationController;
use App\Http\Controllers\ShippingTypeController;

// MEMBER
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\Member\HomeController;
use App\Http\Controllers\Member\ProductController as MemberProductController;
use App\Http\Controllers\Member\CheckoutController;
use App\Http\Controllers\TransactionController;

// SELLER
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\StoreController as SellerStoreController;
use App\Http\Controllers\Seller\SellerProfileController;
use App\Http\Controllers\Seller\SellerCategoryController;

// =================================================
// HOME REDIRECT
// =================================================

Route::get('/', function () {
    if (Auth::check()) {
        return match (Auth::user()->role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'seller' => redirect()->route('seller.dashboard'),
            default  => redirect()->route('member.dashboard'),
        };
    }
    return redirect()->route('login');
})->name('home');

// =================================================
// AUTH
// =================================================
require __DIR__.'/auth.php';

// =================================================
// PROTECTED ROUTES
// =================================================

Route::middleware('auth')->group(function () {

    // ================= ADMIN =================
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard');

            Route::resource('users', AdminUserController::class);
            Route::resource('kategori', CategoryController::class);
            Route::resource('produk', ProductController::class);
            Route::resource('shipping-types', ShippingTypeController::class);

            Route::get('/stores', [AdminStoreVerificationController::class, 'index'])
                ->name('store.index');

            Route::get('/stores/{store}/approve', [AdminStoreVerificationController::class, 'approve'])
                ->name('store.approve');

            Route::get('/stores/{store}/reject', [AdminStoreVerificationController::class, 'reject'])
                ->name('store.reject');
        });

    // ================= MEMBER =================
    Route::middleware('role:member')
        ->prefix('member')
        ->name('member.')
        ->group(function () {

            Route::get('/dashboard', [HomeController::class, 'index'])
                ->name('dashboard');

            Route::get('/home', [HomeController::class, 'index'])
                ->name('home');

            Route::get('/product/{slug}', [MemberProductController::class, 'show'])
                ->name('product.show');

            Route::get('/checkout/{product}', [CheckoutController::class, 'start'])
                ->name('checkout.start');

            Route::post('/checkout/{product}', [TransactionController::class, 'store'])
                ->name('checkout.store');

            Route::get('/transactions', [TransactionController::class, 'index'])
                ->name('transactions.index');

            Route::get('/topup', function () {
                return view('member.topup');
            })->name('topup');

            Route::get('/history', function () {
                return view('member.history');
            })->name('history');

            // REGISTER TOKO
            Route::get('/store/register', [SellerStoreController::class, 'index'])
                ->name('store.register');

            Route::post('/store/register', [SellerStoreController::class, 'store'])
                ->name('store.save');
        });

    // ================= SELLER =================
    Route::middleware('role:seller')
        ->prefix('seller')
        ->name('seller.')
        ->group(function () {

            Route::get('/dashboard', [SellerDashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('/profile', [SellerProfileController::class, 'edit'])
                ->name('profile.edit');

            Route::put('/profile', [SellerProfileController::class, 'update'])
                ->name('profile.update');

            Route::delete('/profile', [SellerProfileController::class, 'destroy'])
                ->name('profile.delete');

            // REGISTER TOKO
            Route::get('/store/register', [SellerStoreController::class, 'index'])
                ->name('store.register');

            Route::post('/store/register', [SellerStoreController::class, 'store'])
                ->name('store.save');

            // SELLER CATEGORY
            Route::resource('categories', SellerCategoryController::class);
        });

    // ================= USER PROFILE GLOBAL =================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});
