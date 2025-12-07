<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminStoreVerificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\SellerStoreController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


// ---------------- PUBLIC ROUTES ----------------
Route::get('/', function () {
    if (Auth::check()) {
        // Sudah login → redirect ke dashboard sesuai role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role === 'user') {
            return redirect()->route('user.dashboard');
        } elseif (Auth::user()->role === 'seller') {
            return redirect()->route('seller.dashboard');
        }
    }

    // Belum login → tampilkan halaman login
    return redirect()->route('login');
})->name('home');
Route::resource('products', ProductController::class);

// ---------------- AUTH ROUTES ----------------
require __DIR__.'/auth.php';

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
// ---------------- DASHBOARD & PROTECTED ROUTES ----------------
Route::middleware(['auth'])->group(function () {

    // ---------------- ADMIN ----------------
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::resource('categories', \App\Http\Controllers\ProductCategoryController::class);
        Route::resource('admin/products', \App\Http\Controllers\AdminProductController::class);
        Route::resource('admin/users', UserController::class);

        Route::get('/admin/store-verification', [AdminStoreVerificationController::class, 'index'])->name('admin.store.index');
        Route::get('/admin/store/{store}/approve', [AdminStoreVerificationController::class, 'approve'])->name('admin.store.approve');
        Route::get('/admin/store/{store}/reject', [AdminStoreVerificationController::class, 'reject'])->name('admin.store.reject');
    });

    // ---------------- SELLER ----------------
    Route::middleware('role:seller')->group(function () {
        Route::get('/seller/dashboard', function () {
            return view('seller.dashboard');
        })->name('seller.dashboard');

        Route::get('/seller/store/register', [SellerStoreController::class, 'index'])->name('seller.store.register');
        Route::post('/seller/store/register', [SellerStoreController::class, 'store'])->name('seller.store.save');
    });

    // ---------------- MEMBER ----------------
    Route::middleware('role:member')->group(function () {
        Route::get('/user/dashboard', function () {
            return view('user.dashboard');
        })->name('user.dashboard');

        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::post('checkout/{product}', [TransactionController::class, 'store'])->name('checkout.store');
    });

    // ---------------- PROFILE ----------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ---------------- LOGOUT ----------------
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});
