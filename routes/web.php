<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ================= CONTROLLERS =================

// AUTH & PROFILE
use App\Http\Controllers\ProfileController;

// ADMIN
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProductController as ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminStoreVerificationController;

// MEMBER
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\Member\HomeController;
use App\Http\Controllers\Member\ProductController as MemberProductController;
use App\Http\Controllers\Member\CheckoutController;
use App\Http\Controllers\TransactionController;

// SELLER
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Seller\SellerProfileController;

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

    // ================= ADMIN ================= ✅
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard');

            Route::resource('users', AdminUserController::class);
            Route::resource('kategori', CategoryController::class);
            Route::resource('produk', ProductController::class);

            Route::get('/stores', [AdminStoreVerificationController::class, 'index'])
                ->name('store.index');

            Route::get('/stores/{store}/approve', [AdminStoreVerificationController::class, 'approve'])
                ->name('store.approve');

            Route::get('/stores/{store}/reject', [AdminStoreVerificationController::class, 'reject'])
                ->name('store.reject');
            Route::get('/seller/profile', [SellerProfileController::class, 'show'])
    ->name('seller.profile');

Route::get('/seller/profile', [SellerProfileController::class, 'edit'])
    ->name('seller.profile');


        });

    // ================= MEMBER ================= ✅
    Route::middleware('role:member')
        ->prefix('member')
        ->name('member.')
        ->group(function () {

            Route::get('/dashboard', [MemberDashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('/home', [HomeController::class, 'index'])
                ->name('home');

            Route::get('/product/{slug}', [MemberProductController::class, 'show'])
                ->name('product.show');

            Route::get('/checkout/{product}', [CheckoutController::class, 'start'])
                ->name('checkout.start');

            Route::post('/checkout/{product}', [TransactionController::class, 'store'])
                ->name('checkout.store');

            // REGISTER TOKO
            Route::get('/store/register', [StoreController::class, 'create'])
                ->name('store.register');

            Route::post('/store/register', [StoreController::class, 'store'])
                ->name('store.store');
        });

    // ================= SELLER ================= ✅✅
    Route::middleware(['auth', 'role:seller'])->group(function () {
    // SELLER DASHBOARD
Route::get('/seller/dashboard', [SellerDashboardController::class, 'index'])
    ->name('seller.dashboard')
    ->middleware(['auth', 'role:seller']);

    Route::get('/seller/profile', [SellerProfileController::class, 'show'])
        ->name('seller.profile.show');

    Route::get('/seller/profile/edit', [SellerProfileController::class, 'edit'])
        ->name('seller.profile.edit');

    Route::post('/seller/profile/update', [SellerProfileController::class, 'update'])
        ->name('seller.profile.update');

    Route::delete('/seller/profile/delete', [SellerProfileController::class, 'destroy'])
        ->name('seller.profile.delete');
});
    //CATEGORY
    Route::middleware(['auth', 'role:seller'])->group(function () {
    Route::prefix('/seller')->name('seller.')->group(function () {
        Route::resource('categories', \App\Http\Controllers\Seller\SellerCategoryController::class);
    });
});



    // ================= USER PROFILE GLOBAL =================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});
