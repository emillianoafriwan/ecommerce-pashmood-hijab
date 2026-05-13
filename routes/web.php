<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Models\Order;
use App\Models\Product;

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
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    // Rute Pesanan
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.detail');
    Route::post('/order/confirm/{id}', [OrderController::class, 'confirm'])->name('order.confirm');
    Route::get('/my-orders', [OrderController::class, 'history'])->name('orders.history');
    
    // Konfirmasi pesanan diterima oleh pembeli
    Route::post('/order/complete/{id}', [OrderController::class, 'markAsCompleted'])->name('order.complete');

   // ==========================================
    // Dashboard Utama (SUDAH DIPERBAIKI ANALITIKNYA)
    // ==========================================
    Route::get('/dashboard', function () {
        
        // KEMBALIKAN KE LOGIKA INI BOS (Karena nama kolom di database adalah 'role')
        if (auth()->user()->role == 'admin') { 
            // PERBAIKAN: Hitung pendapatan dari pesanan yang sudah dibayar, dikirim, ATAU selesai
            $totalRevenue = Order::whereIn('status', ['paid', 'shipped', 'completed'])->sum('total_price');
            
            // Pre-order yang masih menunggu pembayaran atau verifikasi
            $pendingOrders = Order::whereIn('status', ['pre_order', 'pending', 'waiting'])->count();
            
            // PERBAIKAN: Hitung pesanan yang statusnya benar-benar 'completed'
            $completedOrders = Order::where('status', 'completed')->count();
            
            $totalProducts = Product::count();

            return view('dashboard', compact('totalRevenue', 'pendingOrders', 'completedOrders', 'totalProducts'));
        }

        return view('dashboard');
        
    })->middleware(['verified'])->name('dashboard');
    
    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ==========================================
// 3. RUTE KHUSUS ADMIN
// ==========================================
// Pastikan middleware 'is_admin' sudah terdaftar di Kernel.php/bootstrap/app.php
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Manajemen Toko
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('products', ProductController::class);
    
    // Daftar Pesanan Admin
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
    
    // cetak laporan
    Route::get('/orders/report', [OrderController::class, 'report'])->name('admin.orders.report');
    
    // Detail & Approve Pesanan
    Route::get('/orders/{id}', [OrderController::class, 'showAdmin'])->name('admin.order.detail');
    Route::post('/order/approve/{id}', [OrderController::class, 'approve'])->name('admin.order.approve');
    Route::post('/order/reject/{id}', [OrderController::class, 'reject'])->name('admin.order.reject');

    // ==========================================
    // ALUR 3 TAHAP PENGIRIMAN PESANAN (BARU)
    // ==========================================
    Route::post('/order/generate-resi/{id}', [OrderController::class, 'generateResi'])->name('admin.order.generate_resi');
    Route::get('/order/print-resi/{id}', [OrderController::class, 'printResi'])->name('admin.order.print_resi');
    Route::post('/order/ship/{id}', [OrderController::class, 'shipOrder'])->name('admin.order.ship');

});

require __DIR__.'/auth.php';
