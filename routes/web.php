<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\StoreVerificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminStoreVerificationController;


// ⬇ ADMIN ONLY ROUTES
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('categories', \App\Http\Controllers\ProductCategoryController::class);
    Route::resource('admin/products', \App\Http\Controllers\AdminProductController::class);
    Route::resource('/admin/users', App\Http\Controllers\UserController::class);
    
    Route::get('/admin/store-verification', [AdminStoreVerificationController::class, 'index'])->name('admin.store.index');
    Route::get('/admin/store/{store}/approve', [AdminStoreVerificationController::class, 'approve'])->name('admin.store.approve');
    Route::get('/admin/store/{store}/reject', [AdminStoreVerificationController::class, 'reject'])->name('admin.store.reject');
});

// ⬇ SELLER ONLY ROUTES
Route::middleware(['auth', 'role:seller'])->group(function () {
    Route::get('/seller/store/register', [SellerStoreController::class, 'index'])->name('seller.store.register');
    Route::post('/seller/store/register', [SellerStoreController::class, 'store'])->name('seller.store.save');
});

// ⬇ MEMBER ONLY ROUTES
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('checkout/{product}', [TransactionController::class, 'store'])->name('checkout.store');
});

// PUBLIC ROUTES
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::resource('products', ProductController::class);

// PROFILE ROUTE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
