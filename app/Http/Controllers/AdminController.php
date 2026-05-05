<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;   // Wajib dipanggil
use App\Models\Product; // Wajib dipanggil

class AdminController extends Controller
{
    public function index()
    {
        // PERBAIKAN: Hitung pendapatan dari pesanan yang sudah dibayar, dikirim, ATAU selesai
        $totalRevenue = Order::whereIn('status', ['paid', 'shipped', 'completed'])->sum('total_price');
        
        // Pesanan yang masih tertunda atau menunggu verifikasi
        $pendingOrders = Order::whereIn('status', ['pending', 'waiting'])->count();
        
        // PERBAIKAN: Hitung pesanan yang statusnya sudah 'completed'
        $completedOrders = Order::where('status', 'completed')->count();
        
        // Total seluruh produk di toko
        $totalProducts = Product::count();

        // Melempar data ke tampilan dashboard
        return view('dashboard', compact('totalRevenue', 'pendingOrders', 'completedOrders', 'totalProducts'));
    }
}