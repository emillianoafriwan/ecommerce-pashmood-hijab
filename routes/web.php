<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\RegionController;
// ==========================================
// 1. RUTE PUBLIK
// ==========================================
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

// ==========================================
// 2. RUTE USER (Wajib Login)
// ==========================================
Route::middleware(['auth'])->group(function () {

    Route::post('/product/{product}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');
    
    // Fitur Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    
    // PERBAIKAN: Gunakan {cartKey} agar cocok dengan method Controller Bos
    Route::delete('/cart/remove/{cartKey}', [CartController::class, 'remove'])->name('cart.remove');
    
    // Fitur Checkout
    Route::get('/checkout', function() {
        return redirect()->route('cart.index');
    })->name('checkout.create');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    // Rute Pesanan
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.detail');
    Route::post('/order/confirm/{id}', [OrderController::class, 'confirm'])->name('order.confirm');
    Route::post('/order/cancel/{id}', [OrderController::class, 'cancel'])->name('order.cancel');
    Route::get('/my-orders', [OrderController::class, 'history'])->name('orders.history');
    
    // Konfirmasi pesanan diterima oleh pembeli
    Route::post('/order/complete/{id}', [OrderController::class, 'markAsCompleted'])->name('order.complete');

   // ==========================================
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['verified'])->name('dashboard');
    
    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/theme', [ProfileController::class, 'updateTheme'])->name('profile.theme.update');
    Route::patch('/profile/theme-settings', [ProfileController::class, 'updateThemeSettings'])->name('profile.theme.settings');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rekening Bank (Multiple)
    Route::post('/bank-accounts', [\App\Http\Controllers\BankAccountController::class, 'store'])->name('bank.store');
    Route::delete('/bank-accounts/{bankAccount}', [\App\Http\Controllers\BankAccountController::class, 'destroy'])->name('bank.destroy');
    Route::patch('/bank-accounts/{bankAccount}/toggle', [\App\Http\Controllers\BankAccountController::class, 'toggle'])->name('bank.toggle');


    // ==========================================
    // API Wilayah Indonesia (Proxy + Cache)
    // ==========================================
    Route::prefix('api/wilayah')->group(function () {
        Route::get('/provinsi',          [RegionController::class, 'provinces']);
        Route::get('/kota/{id}',         [RegionController::class, 'cities']);
        Route::get('/kecamatan/{id}',    [RegionController::class, 'districts']);
        Route::get('/desa/{id}',         [RegionController::class, 'villages']);
    });

    // Fitur Chat Pelanggan
    Route::get('/api/chats', [\App\Http\Controllers\ChatMessageController::class, 'index'])->name('api.chats.index');
    Route::post('/api/chats', [\App\Http\Controllers\ChatMessageController::class, 'store'])->name('api.chats.store');
    Route::post('/api/chats/read', [\App\Http\Controllers\ChatMessageController::class, 'markAsRead'])->name('api.chats.read');
});


// ==========================================
// 3. RUTE KHUSUS ADMIN
// ==========================================
// Pastikan middleware 'is_admin' sudah terdaftar di Kernel.php/bootstrap/app.php
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
    
    // Manajemen Toko
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('products', ProductController::class);
    
    // Daftar Pesanan Admin
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::get('/order/read/{id}', [OrderController::class, 'readAndRedirect'])->name('admin.order.read');
    Route::post('/orders/mark-all-read', [OrderController::class, 'markAllRead'])->name('admin.orders.mark_all_read');
    
    // cetak laporan
    Route::get('/orders/report', [OrderController::class, 'report'])->name('admin.orders.report');
    
    // Detail & Approve Pesanan
    Route::get('/orders/{id}', [OrderController::class, 'showAdmin'])->name('admin.order.detail');
    Route::post('/order/approve/{id}', [OrderController::class, 'approve'])->name('admin.order.approve');
    Route::post('/order/reject/{id}', [OrderController::class, 'reject'])->name('admin.order.reject');
    Route::post('/order/cancel/{id}', [OrderController::class, 'cancelAdmin'])->name('admin.order.cancel');

    // ==========================================
    // ALUR 3 TAHAP PENGIRIMAN PESANAN (BARU)
    // ==========================================
    Route::post('/order/generate-resi/{id}', [OrderController::class, 'generateResi'])->name('admin.order.generate_resi');
    Route::get('/order/print-resi/{id}', [OrderController::class, 'printResi'])->name('admin.order.print_resi');
    Route::post('/order/ship/{id}', [OrderController::class, 'shipOrder'])->name('admin.order.ship');

    // ==========================================
    // Manajemen Banner
    // ==========================================
    Route::resource('banners', BannerController::class)->except(['show'])->names([
        'index'   => 'admin.banners.index',
        'create'  => 'admin.banners.create',
        'store'   => 'admin.banners.store',
        'edit'    => 'admin.banners.edit',
        'update'  => 'admin.banners.update',
        'destroy' => 'admin.banners.destroy',
    ]);
    Route::patch('banners/{banner}/toggle', [BannerController::class, 'toggleActive'])->name('admin.banners.toggle');
    Route::post('banners/{banner}/crop-ajax', [BannerController::class, 'cropAjax'])->name('admin.banners.crop_ajax');

    // Fitur Manajemen Chat Admin
    Route::get('/chats', [\App\Http\Controllers\ChatMessageController::class, 'adminIndex'])->name('admin.chats');
    Route::get('/api/admin/chats/users', [\App\Http\Controllers\ChatMessageController::class, 'adminUsers'])->name('admin.chats.users');
    Route::get('/api/admin/chats/{userId}', [\App\Http\Controllers\ChatMessageController::class, 'adminMessages'])->name('admin.chats.messages');
    Route::post('/api/admin/chats/{userId}', [\App\Http\Controllers\ChatMessageController::class, 'adminStore'])->name('admin.chats.store');
    Route::post('/api/admin/chats/{userId}/read', [\App\Http\Controllers\ChatMessageController::class, 'adminMarkAsRead'])->name('admin.chats.read');
});

require __DIR__.'/auth.php';
