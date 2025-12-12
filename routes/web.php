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
use App\Http\Controllers\Member\HomeController;
use App\Http\Controllers\Member\ProductController as MemberProductController;
use App\Http\Controllers\Member\CheckoutController;
use App\Http\Controllers\Member\MemberTransactionController;
use App\Http\Controllers\Member\MemberProfileController;
use App\Http\Controllers\Member\TopupController;


// SELLER
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\SellerProfileController;
use App\Http\Controllers\Seller\SellerCategoryController;
use App\Http\Controllers\Seller\SellerRegisterController;
//use App\Http\Controllers\Seller\SellerProductCategoryController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\SellerBalanceController;
use App\Http\Controllers\Seller\SellerWithdrawalController; // Pastikan ini diimpor!

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
require __DIR__ . '/auth.php';

// =================================================
// PROTECTED ROUTES
// =================================================

Route::middleware('auth')->group(function () {

    // ================= GLOBAL USER PROFILE =================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    // ================= ADMIN =================
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard');

            Route::resource('users', AdminUserController::class);

            // Menggunakan CategoryController dan ProductController dari namespace App\Http\Controllers (Admin)
            Route::resource('kategori', CategoryController::class); // Contoh: admin.kategori.index
            Route::resource('produk', ProductController::class);    // Contoh: admin.produk.index
            Route::resource('shipping-types', ShippingTypeController::class);

            // Rute Verifikasi Toko
            Route::get('/stores', [AdminStoreVerificationController::class, 'index'])
                ->name('store.index');
            Route::get('/stores/{store}/approve', [AdminStoreVerificationController::class, 'approve'])
                ->name('store.approve');
            Route::get('/stores/{store}/reject', [AdminStoreVerificationController::class, 'reject'])
                ->name('store.reject');
        });


    // ================= MEMBER PANEL =================
    Route::middleware('role:member')
        ->prefix('member')
        ->name('member.')
        ->group(function () {

            // Dashboard & Home
            Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
            Route::get('/home', [HomeController::class, 'index'])->name('home');

            // Product & Store Display
            Route::get('/product/{slug}', [MemberProductController::class, 'show'])
                ->name('product.show');
            Route::get('/store/{category?}', [HomeController::class, 'index'])
                ->name('store');

            // Checkout & Transaction
            // ... di dalam group 'member.' ...
            // Checkout & Transaction
            Route::get('/checkout/{product}', [CheckoutController::class, 'start'])
                ->name('checkout.start');
            Route::post('/checkout/{product}', [MemberTransactionController::class, 'store'])
                ->name('checkout.store');


            // History Transaksi (Telah Diperbaiki: Dihapus Duplikasi Grup Rute)
            Route::get('/history', [MemberTransactionController::class, 'history'])
                ->name('history');

            // Topup
            Route::get('/member/topup', [TopupController::class, 'index'])->name('topup');
        Route::post('/member/topup', [TopupController::class, 'store'])->name('topup.store');


            // Member Profile (Telah Diperbaiki: Menggunakan MemberProfileController)
            Route::get('/profile/edit', [MemberProfileController::class, 'edit'])
                ->name('profile.edit');
            Route::post('/profile/update', [MemberProfileController::class, 'update'])
                ->name('profile.update');
        });


    // ================= SELLER REGISTRATION =================
    // Rute ini dapat diakses oleh SEMUA user yang sudah login (middleware('auth'))
    // untuk mendaftar sebagai seller/membuat toko.
    Route::get('/seller/store/register', [SellerRegisterController::class, 'index'])
        ->name('seller.store.register');
    Route::post('/seller/store/register', [SellerRegisterController::class, 'store'])
        ->name('seller.store.store');


    // ================= SELLER PANEL ================= 
    Route::middleware('role:seller')
        ->prefix('seller')
        ->name('seller.')
        ->group(function () {

            // DASHBOARD
            Route::get('/dashboard', [SellerDashboardController::class, 'index'])
                ->name('dashboard');

            // PROFILE TOKO
            // Jika SellerProfileController adalah untuk mengelola toko (Store), 
            // sebaiknya gunakan Route Resource untuk Store jika memungkinkan
            Route::get('/profile', [SellerProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [SellerProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [SellerProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [SellerProfileController::class, 'destroy'])->name('profile.delete');


            // KELOLA KATEGORI PRODUK
            // Menggunakan Route Resource, tapi custom nama karena di Controller 
            // menggunakan action names yang spesifik.
            Route::controller(SellerCategoryController::class)->group(function () {
                Route::get('/categories', 'index')->name('categories.index');
                Route::get('/categories/create', 'create')->name('categories.create');
                Route::post('/categories', 'store')->name('categories.store');
                Route::get('/categories/{category}/edit', 'edit')->name('categories.edit');
                Route::put('/categories/{category}', 'update')->name('categories.update');
                Route::delete('/categories/{category}', 'destroy')->name('categories.destroy');
            });

            // KELOLA PRODUK
            // Route::resource('products', SellerProductController::class); // Contoh
            // Kelola produk (FIX)
            Route::controller(SellerProductController::class)->group(function () {
                Route::get('/products', 'index')->name('products.index');
                Route::get('/products/create', 'create')->name('products.create');
                Route::post('/products', 'store')->name('products.store');
                Route::get('/products/{product}/edit', 'edit')->name('products.edit');
                Route::put('/products/{product}', 'update')->name('products.update');
                Route::delete('/products/{product}', 'destroy')->name('products.destroy');
            });

            // KELOLA PESANAN
            Route::controller(SellerOrderController::class)->group(function () {
                Route::get('/orders', 'index')->name('orders.index');
                Route::put('/orders/{transaction}', 'update')->name('orders.update');
            });

        // ✅ KELOLA SALDO TOKO (seller.balance.index)
        // URL yang dihasilkan: /seller/balance
        Route::get('/seller/balance', [SellerBalanceController::class, 'index'])->name('balance.index');
        
        // ⭐ Rute Pengelolaan Penarikan Saldo (Withdrawal)
        Route::controller(SellerWithdrawalController::class)->prefix('withdrawals')->name('withdrawals.')->group(function () {
        // Ini akan menghasilkan route name: seller.withdrawals.index
        Route::get('/', 'index')->name('index'); 

        Route::get('/create', 'create')->name('create'); 
        Route::post('/', 'store')->name('store'); 
    });
    });
});
