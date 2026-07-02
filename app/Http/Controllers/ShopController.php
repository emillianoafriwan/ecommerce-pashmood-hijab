<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->where('is_active', true)
            ->withSum([
                'orderItems as sold_count' => function ($orderItemQuery) {
                    $orderItemQuery->whereHas('order', function ($orderQuery) {
                        $orderQuery->whereIn('status', ['paid', 'shipped', 'completed']);
                    });
                },
            ], 'quantity');

        if ($request->filled('search')) {
            $query->where(function ($productQuery) use ($request) {
                $productQuery->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $sort = $request->get('sort', 'all');

        if ($sort === 'latest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'best_seller') {
            $query->orderByDesc('sold_count')->orderByDesc('created_at');
        } else {
            $query->orderBy('name');
        }

        $products = $query->get();

        $categories = Category::all();

        // Ambil banner aktif, urutkan berdasarkan sort_order
        $banners = Banner::active()->get();

        return view('welcome', compact('products', 'categories', 'banners'));
    }
}

