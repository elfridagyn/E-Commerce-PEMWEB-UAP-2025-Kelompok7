<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerStoreController;
use App\Http\Controllers\AdminStoreVerificationController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Member\MemberDashboardController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;

use App\Models\Product;
use App\Models\ProductCategory;

use App\Http\Controllers\Member\HomeController;
use App\Http\Controllers\Member\ProductController as MemberProductController;
use App\Http\Controllers\Member\CheckoutController;
use App\Http\Controllers\Member\TransactionController;
use App\Http\Controllers\Member\MemberTransactionController;

// -------------------------------------------------
// HOME → Redirect sesuai role
// -------------------------------------------------
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::user()->role === 'seller') {
            return redirect()->route('seller.dashboard');
        }
        return redirect()->route('member.dashboard');
    }
    return redirect()->route('login');
})->name('home');

// -------------------------------------------------
// AUTH
// -------------------------------------------------
require __DIR__ . '/auth.php';

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// -------------------------------------------------
// PROTECTED ROUTES
// -------------------------------------------------
Route::middleware(['auth'])->group(function () {

    // -------------------------------------------------
    // ADMIN PANEL
    // -------------------------------------------------
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard');

            Route::resource('kategori', CategoryController::class);

            Route::resource('produk', ProductController::class)->except([
                'create', 'store', 'edit', 'update', 'destroy'
            ]);

            Route::resource('users', AdminUserController::class);

            Route::get('/stores', [AdminStoreVerificationController::class, 'index'])
                ->name('store.index');

            Route::get('/stores/{store}/approve', [AdminStoreVerificationController::class, 'approve'])
                ->name('store.approve');

            Route::get('/stores/{store}/reject', [AdminStoreVerificationController::class, 'reject'])
                ->name('store.reject');
            
            Route::resource('shipping-types', App\Http\Controllers\ShippingTypeController::class);

        });

        // MEMBER PANEL
Route::middleware(['auth', 'role:member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {

        // Dashboard member
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

        // Halaman Home alternatif
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        // Detail produk
        Route::get('/product/{slug}', [MemberProductController::class, 'show'])
            ->name('product.show');

        // Checkout (form)
        Route::get('/checkout/{product}', [CheckoutController::class, 'start'])
            ->name('checkout.start');

        // Checkout (store)
        Route::post('/checkout/{product}', [MemberTransactionController::class, 'store'])
            ->name('checkout.store');

        // History transaksi
        Route::middleware(['auth', 'role:member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {

        Route::get('/history', [MemberTransactionController::class, 'history'])
            ->name('history'); // member.history

        Route::post('/checkout/{product}', [MemberTransactionController::class, 'store'])
            ->name('checkout.store'); // member.checkout.store
});
        // Topup saldo
        Route::get('/topup', function () {
            return view('member.topup');
        })->name('topup');

        // Store filter
        Route::get('/store/{category?}', [HomeController::class, 'index'])
            ->name('store');
    });

    // -------------------------------------------------
    // SELLER PANEL
    // -------------------------------------------------
    Route::middleware(['role:seller'])
        ->prefix('seller')
        ->name('seller.')
        ->group(function () {

            Route::get('/dashboard', [SellerDashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('/store/register', [SellerStoreController::class, 'index'])
                ->name('store.register');

            Route::post('/store/register', [SellerStoreController::class, 'store'])
                ->name('store.save');
        });

    // -------------------------------------------------
    // PROFILE
    // -------------------------------------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
