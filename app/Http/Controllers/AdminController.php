<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // ── Stat Cards ─────────────────────────────────────────────────────────
        $totalRevenue     = Order::whereIn('status', ['paid', 'shipped', 'completed'])->sum('total_price');
        $pendingOrders    = Order::where('admin_read', false)
            ->where(function ($query) {
                $query->whereIn('status', ['pre_order', 'pending', 'waiting'])
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('status', 'canceled')
                            ->where(function ($subSub) {
                                $subSub->whereNull('cancellation_reason')
                                    ->orWhere('cancellation_reason', 'not like', '[Admin]%');
                            });
                    });
            })
            ->count();
        $unreadNotifications = Order::with('user')
            ->where('admin_read', false)
            ->where(function ($query) {
                $query->whereIn('status', ['pre_order', 'pending', 'waiting'])
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('status', 'canceled')
                            ->where(function ($subSub) {
                                $subSub->whereNull('cancellation_reason')
                                    ->orWhere('cancellation_reason', 'not like', '[Admin]%');
                            });
                    });
            })
            ->latest()
            ->get();
        $completedOrders  = Order::where('status', 'completed')->count();
        $totalProducts    = Product::count();
        $totalCustomers   = User::where('role', 'user')->count();
        $shippedOrders    = Order::where('status', 'shipped')->count();

        // ── Monthly Revenue Chart (last 6 months) ──────────────────────────────
        $revenueData  = [];
        $revenueLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $revenueLabels[] = $month->translatedFormat('M Y');
            $revenueData[]   = (float) Order::whereIn('status', ['paid', 'shipped', 'completed'])
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_price');
        }

        // ── Top Products (by quantity sold in paid/shipped/completed orders) ───
        $topProducts = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_qty'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue')
            )
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.status', ['paid', 'shipped', 'completed'])
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->with('product')
            ->get();

        // ── Order Status Breakdown for doughnut chart ──────────────────────────
        $orderStatuses = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // ── Recent Orders ──────────────────────────────────────────────────────
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'pendingOrders',
            'unreadNotifications',
            'completedOrders',
            'totalProducts',
            'totalCustomers',
            'shippedOrders',
            'revenueData',
            'revenueLabels',
            'topProducts',
            'orderStatuses',
            'recentOrders'
        ));
    }
}