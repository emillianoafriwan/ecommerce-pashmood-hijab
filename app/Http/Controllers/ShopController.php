<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
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

        $products = $query->orderBy('name')->get();

        $categories = Category::all();

        return view('welcome', compact('products', 'categories'));
    }
}
