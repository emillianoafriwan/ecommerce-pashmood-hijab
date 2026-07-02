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

        if (request()->filled('status')) {
            if (request('status') === 'active') {
                $query->where('is_active', true);
            } elseif (request('status') === 'inactive') {
                $query->where('is_active', false);
            }
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
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'variations' => 'required|array',
            'variations.*.color' => 'required',
            'variations.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => $request->slug,
            'description' => $request->description,
            'price'       => $request->price,
            'image_path'  => $imagePath,
            'is_active'   => $request->has('is_active') ? (bool) $request->is_active : true,
        ]);

        foreach ($request->variations as $index => $var) {
            $varImagePath = null;
            if ($request->hasFile("variations.{$index}.image")) {
                $varImagePath = $request->file("variations.{$index}.image")->store('variations', 'public');
            }

            $product->variations()->create([
                'color' => $var['color'],
                'image_path' => $varImagePath,
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
        $validated = $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $product->id,
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'variations' => 'nullable|array',
            'variations.*.id' => 'nullable|exists:product_variations,id',
            'variations.*.color' => 'nullable|string',
            'variations.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Filter variasi yang warnanya kosong (baris yang dikosongkan user)
        // Tetap pertahankan key index asli agar bisa memetakan upload file variations.*.image dengan benar
        $validVariations = collect($validated['variations'] ?? [])
            ->filter(fn($var) => !empty(trim($var['color'] ?? '')))
            ->toArray();

        if (empty($validVariations)) {
            return back()->withErrors(['variations' => 'Produk harus memiliki minimal 1 variasi warna.'])->withInput();
        }

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::delete('public/' . $product->image_path);
            }
            $product->image_path = $request->file('image')->store('products', 'public');
        }

        // Update variasi warna PO.
        $keepIds = [];
        foreach ($validVariations as $index => $var) {
            $variationId = $var['id'] ?? null;
            $existingVar = null;
            if ($variationId) {
                $existingVar = $product->variations()->find($variationId);
            }

            $varImagePath = $existingVar ? $existingVar->image_path : null;
            if ($request->hasFile("variations.{$index}.image")) {
                if ($existingVar && $existingVar->image_path) {
                    Storage::delete('public/' . $existingVar->image_path);
                }
                $varImagePath = $request->file("variations.{$index}.image")->store('variations', 'public');
            }

            $updatedVar = $product->variations()->updateOrCreate(
                ['id' => $variationId],
                [
                    'color' => $var['color'],
                    'image_path' => $varImagePath,
                ]
            );
            $keepIds[] = $updatedVar->id;
        }

        // Delete removed variations and their images
        $removedVariations = $product->variations()->whereNotIn('id', $keepIds)->get();
        foreach ($removedVariations as $removedVar) {
            // Only delete the image if this variation has never been ordered
            $hasBeenOrdered = \App\Models\OrderItem::where('variation_id', $removedVar->id)->exists();
            if ($removedVar->image_path && !$hasBeenOrdered) {
                Storage::delete('public/' . $removedVar->image_path);
            }
            $removedVar->delete();
        }

        $product->update([
            'category_id'  => $validated['category_id'],
            'name'         => $validated['name'],
            'slug'         => $validated['slug'],
            'description'  => $validated['description'],
            'price'        => $validated['price'],
            'is_active'    => $request->has('is_active') ? (bool) $request->is_active : false,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk dan variasi berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->orderItems()->exists()) {
            return redirect()->route('products.index')
                ->with('error', 'Produk tidak bisa dihapus karena sudah pernah masuk transaksi.');
        }

        foreach ($product->variations as $var) {
            if ($var->image_path) {
                Storage::delete('public/' . $var->image_path);
            }
        }

        if ($product->image_path) {
            Storage::delete('public/' . $product->image_path);
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function show(Product $product)
    {
        $product->load(['variations', 'reviews.user']); 
        
        $hasBought = false;
        $alreadyReviewed = false;

        if (auth()->check()) {
            $hasBought = \App\Models\Order::where('user_id', auth()->id())
                ->where('status', 'completed')
                ->whereHas('orderItems', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })
                ->exists();

            if ($hasBought) {
                $alreadyReviewed = \App\Models\Review::where('user_id', auth()->id())
                    ->where('product_id', $product->id)
                    ->exists();
            }
        }

        return view('admin.products.show', compact('product', 'hasBought', 'alreadyReviewed'));
    }
}
