<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariation; // Wajib import ini!
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        // 1. Cek Login
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login terlebih dahulu untuk belanja!');
        }

        // 2. Validasi input warna & jumlah pembelian
        $request->validate([
            'variation_id' => 'required|exists:product_variations,id',
            'quantity'     => 'required|integer|min:1' // Wajib berupa angka minimal 1
        ]);

        $product = Product::findOrFail($id);
        $variation = ProductVariation::findOrFail($request->variation_id);
        
        // Menangkap jumlah yang diketik pembeli dari form HTML
        $quantity = $request->input('quantity', 1);

        // Validasi Keamanan: Cek apakah jumlah pembelian melebihi stok variasi yang dipilih
        if ($quantity > $variation->stock) {
            return back()->with('error', 'Maaf, jumlah pembelian melebihi sisa stok warna yang tersedia!');
        }

        $cart = session()->get('cart', []);

        // 3. Kunci Unik (ID Produk + ID Variasi) agar beda warna tidak bertumpuk
        $cartKey = $id . '_' . $variation->id;

        // 4. Logika Keranjang dengan Quantity Dinamis
        if(isset($cart[$cartKey])) {
            // Jika sudah ada di keranjang, jumlahkan yang lama dengan yang baru
            $newQuantity = $cart[$cartKey]['quantity'] + $quantity;
            
            // Validasi Keamanan Lapis 2: Cek total tumpukan di keranjang vs sisa stok asli
            if ($newQuantity > $variation->stock) {
                return back()->with('error', 'Total barang ini di keranjang Anda melebihi sisa stok warna!');
            }
            
            $cart[$cartKey]['quantity'] = $newQuantity;
        } else {
            // Jika belum ada, buat entri baru dengan jumlah sesuai inputan
            $cart[$cartKey] = [
                "name"         => $product->name,
                "color"        => $variation->color, // Menyimpan warna yang dipilih
                "variation_id" => $variation->id,    // Menyimpan ID variasi
                "quantity"     => $quantity,         // Menggunakan quantity dari input form
                "price"        => $product->price,
                "image"        => $product->image_path
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Sip! ' . $quantity . ' ' . $product->name . ' (' . $variation->color . ') berhasil masuk keranjang!');
    }

    public function remove($cartKey) // Terima $cartKey, bukan $id
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$cartKey])) {
            unset($cart[$cartKey]); 
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}