<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::with(['category', 'variations']);

        if (request()->filled('search')) {
            $query->where(function ($productQuery) {
                $productQuery->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        }

        if (request()->filled('category')) {
            $query->where('category_id', request('category'));
        }

        $products = $query->latest()->get();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'variations' => 'required|array',
            'variations.*.color' => 'required',
            'variations.*.stock' => 'required|integer|min:0',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        // Hitung total stok dari semua variasi agar data sinkron
        $totalStock = collect($request->variations)->sum('stock');

        $product = Product::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => $request->slug,
            'price'       => $request->price,
            'stock'       => $totalStock, // Gunakan total dari variasi
            'image_path'  => $imagePath,
        ]);

        foreach ($request->variations as $var) {
            $product->variations()->create([
                'color' => $var['color'],
                'stock' => $var['stock'],
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('variations'); 
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $product->id,
            'price' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'variations' => 'required|array',
            'variations.*.stock' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::delete('public/' . $product->image_path);
            }
            $product->image_path = $request->file('image')->store('products', 'public');
        }

        // TAHAP 1: Update Variasi (Gunakan updateOrCreate agar ID tidak berubah-ubah)
        $keepIds = [];
        foreach ($request->variations as $var) {
            $updatedVar = $product->variations()->updateOrCreate(
                ['id' => $var['id'] ?? null], // Cari berdasarkan ID jika ada
                [
                    'color' => $var['color'],
                    'stock' => $var['stock']
                ]
            );
            $keepIds[] = $updatedVar->id;
        }

        // Hapus variasi yang tidak ada di form (jika Bos menghapus baris warna di form edit)
        $product->variations()->whereNotIn('id', $keepIds)->delete();

        // TAHAP 2: Hitung ulang total stok produk utama
        $totalStock = $product->variations()->sum('stock');

        // TAHAP 3: Update Data Produk Utama
        $product->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => $request->slug,
            'price'       => $request->price,
            'stock'       => $totalStock, // Stok produk utama otomatis ngikut total variasi
        ]);

        return redirect()->route('products.index')->with('success', 'Produk dan Stok Variasi berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->orderItems()->exists()) {
            return redirect()->route('products.index')
                ->with('error', 'Produk tidak bisa dihapus karena sudah pernah masuk transaksi.');
        }

        if ($product->image_path) {
            Storage::delete('public/' . $product->image_path);
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function show(Product $product)
    {
        $product->load('variations'); 
        return view('admin.products.show', compact('product'));
    }
}
