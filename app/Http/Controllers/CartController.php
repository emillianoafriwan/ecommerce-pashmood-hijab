<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::user()?->role === 'admin') {
            return redirect()->route('products.index')->with('info', 'Admin tidak perlu checkout. Silakan kelola produk dari halaman ini.');
        }

        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        // 1. Cek Login
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login terlebih dahulu untuk pre-order!');
        }

        if (Auth::user()->role === 'admin') {
            return redirect()->route('products.index')->with('info', 'Admin tidak perlu menambahkan produk ke keranjang. Silakan kelola produk dari halaman ini.');
        }

        // 2. Validasi input warna & jumlah pembelian
        $request->validate([
            'variation_id' => 'required|exists:product_variations,id',
            'quantity'     => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($id);
        if (!$product->is_active) {
            return redirect()->route('shop.index')->with('error', 'Produk ini sudah tidak aktif/dijual.');
        }
        $variation = ProductVariation::findOrFail($request->variation_id);
        
        $quantity = $request->input('quantity', 1);

        // Simpan ke database
        $cartItem = \App\Models\CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->where('product_variation_id', $variation->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            \App\Models\CartItem::create([
                'user_id'              => Auth::id(),
                'product_id'          => $product->id,
                'product_variation_id' => $variation->id,
                'quantity'             => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Sip! ' . $quantity . ' ' . $product->name . ' (' . $variation->color . ') berhasil masuk keranjang pre-order!');
    }

    public function remove($cartKey) // Terima $cartKey, bukan $id
    {
        $parts = explode('_', $cartKey);
        if (count($parts) === 2) {
            $productId = $parts[0];
            $variationId = $parts[1];

            \App\Models\CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->where('product_variation_id', $variationId)
                ->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}
