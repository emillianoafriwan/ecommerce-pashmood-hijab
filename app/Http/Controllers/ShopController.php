<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category; // Pastikan Model Kategori dipanggil

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // 1. Siapkan Query Dasar
        $query = Product::query();

        // 2. Jika ada kata kunci pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // 3. Jika ada filter kategori yang dipilih
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 4. Ambil datanya (yang terbaru di atas)
        $products = $query->latest()->get();

        // 5. Ambil data semua kategori untuk ditampilkan di Dropdown
        $categories = Category::all();

        return view('welcome', compact('products', 'categories'));
    }
}