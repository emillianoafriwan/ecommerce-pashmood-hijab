<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the buyer dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Redirect admin to admin dashboard
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Basic buyer metrics
        $totalOrders = Order::where('user_id', $user->id)->whereIn('status', ['paid', 'shipped', 'completed'])->count();
        $pendingOrders = Order::where('user_id', $user->id)->whereIn('status', ['paid', 'shipped'])->count();
        $completedOrders = Order::where('user_id', $user->id)->where('status', 'completed')->count();
        $totalSpend = Order::where('user_id', $user->id)->whereIn('status', ['paid', 'shipped', 'completed'])->sum('total_price');

        // Recent orders (latest 5)
        $recentOrders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('totalOrders', 'pendingOrders', 'completedOrders', 'totalSpend', 'recentOrders'));
    }
}
