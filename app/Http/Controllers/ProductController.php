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
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => $request->slug,
            'price'       => $request->price,
            'image_path'  => $imagePath,
        ]);

        foreach ($request->variations as $var) {
            $product->variations()->create([
                'color' => $var['color'],
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
            'variations.*.color' => 'required',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::delete('public/' . $product->image_path);
            }
            $product->image_path = $request->file('image')->store('products', 'public');
        }

        // Update variasi warna PO.
        $keepIds = [];
        foreach ($request->variations as $var) {
            $updatedVar = $product->variations()->updateOrCreate(
                ['id' => $var['id'] ?? null],
                [
                    'color' => $var['color'],
                ]
            );
            $keepIds[] = $updatedVar->id;
        }

        $product->variations()->whereNotIn('id', $keepIds)->delete();

        $product->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => $request->slug,
            'price'       => $request->price,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk dan variasi berhasil diperbarui!');
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
