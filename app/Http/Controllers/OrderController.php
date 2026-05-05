<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentRejectedMail;

class OrderController extends Controller
{
    // 1. Menampilkan daftar pesanan untuk Admin
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // 2. Menampilkan form Checkout
    public function create()
    {
        if (!session()->has('cart') || empty(session('cart'))) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }
        return view('orders.checkout');
    }

    // 3. Proses Checkout (Simpan ke DB)
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $cart = session()->get('cart');
        $total = array_reduce($cart, fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 0);

        $order = null;
        DB::transaction(function () use ($cart, $request, $total, &$order) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $total,
                'status' => 'pending',
                'address' => $request->address,
                'phone' => $request->phone,
            ]);

            foreach ($cart as $id => $details) {
                // PEMECAHAN STRING "5_1"
                $parts = explode('_', $id);
                $productId = $parts[0];
                $variationId = $parts[1];

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $productId,   // Sekarang murni angka
                    'variation_id' => $variationId, // ID Variasi warna
                    'quantity'     => $details['quantity'],
                    'price'        => $details['price'],
                ]);
                
                // Opsional: Kurangi stok produk
                \App\Models\ProductVariation::where('id', $variationId)->decrement('stock', $details['quantity']);
            }
        });

        session()->forget('cart');
        return redirect()->route('order.detail', $order->id)->with('success', 'Pesanan berhasil dibuat!');
    }

    // 4. Menampilkan detail pesanan (Sisi User)
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.show', compact('order'));
    }

    // 5. Menampilkan detail pesanan (Sisi Admin)
    public function showAdmin($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // 6. Upload Bukti TF oleh Pembeli (Status menjadi 'waiting')
    public function confirm(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('proofs', 'public');

        $order = Order::findOrFail($id);
        $order->update([
            'status' => 'waiting', 
            'payment_proof' => $path,
            'rejection_reason' => null // Hapus alasan penolakan jika sebelumnya pernah ditolak
        ]);

        return redirect()->route('order.detail', $id)->with('success', 'Bukti dikirim, menunggu verifikasi Admin!');
    }

    // 7. Approve oleh Admin (Status menjadi 'paid')
    public function approve($id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'status' => 'paid',
            'rejection_reason' => null // Pastikan bersih
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    // 8. Tolak Pembayaran oleh Admin (Status kembali 'pending')
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string'
        ]);
        
        $order = Order::findOrFail($id);

        // Hapus file foto lama di server agar tidak menuh-menuhin storage
        if ($order->payment_proof) {
            Storage::delete('public/' . $order->payment_proof);
        }

        $order->update([
            'status' => 'pending', 
            'payment_proof' => null, // Kosongkan foto
            'rejection_reason' => $request->reason // Simpan alasan penolakan
        ]);

        Mail::to($order->user->email)->send(new PaymentRejectedMail($order));

        return redirect()->route('admin.orders')->with('success', 'Pesanan ditolak. Catatan telah dikirim ke pembeli.');
    }

    // 9. Riwayat Pesanan User
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

    // 10. Cetak laporan
    // Fungsi untuk Cetak Laporan Penjualan
    public function report()
    {
        // PERBAIKAN: Tarik semua pesanan yang sudah masuk uangnya (paid, shipped, completed)
        $orders = Order::with('user')
                       ->whereIn('status', ['paid', 'shipped', 'completed'])
                       ->orderBy('created_at', 'desc')
                       ->get();

        // Hitung total keseluruhan pendapatan
        $totalRevenue = $orders->sum('total_price');

        return view('admin.orders.report', compact('orders', 'totalRevenue'));
    }
// TAHAP 1: Buat Nomor Resi Otomatis
    public function generateResi(Request $request, $id)
    {
        $request->validate(['courier' => 'required|string|max:50']);
        $order = Order::findOrFail($id);

        if (!$order->resi_number) {
            $resi_number = 'SC' . date('ymd') . str_pad($order->id, 4, '0', STR_PAD_LEFT) . mt_rand(100, 999);
            $order->update([
                'courier' => $request->courier,
                'resi_number' => $resi_number,
                // PERHATIAN: Status sengaja TIDAK diubah jadi shipped di sini
            ]);
        }
        return back()->with('success', 'Nomor resi berhasil dibuat! Silakan Cetak Resi untuk menempelkannya di paket.');
    }

    // TAHAP 2: Buka Halaman Cetak Label
    public function printResi($id)
    {
        // Ambil data order sekaligus relasi user dan produknya
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        
        // Kita akan buat file blade khusus untuk kertas cetak
        return view('admin.orders.print', compact('order'));
    }

    // TAHAP 3: Ubah Status Jadi Dikirim (Kunci Pesanan)
    public function shipOrder($id)
    {
        $order = Order::findOrFail($id);
        
        // Pastikan resi sudah ada sebelum bisa dikirim
        if ($order->resi_number) {
            $order->update(['status' => 'shipped']);
            return back()->with('success', 'Mantap! Pesanan resmi berstatus "Dikirim".');
        }
        
        return back()->with('error', 'Buat resi terlebih dahulu.');
    }

    // Fungsi untuk Pembeli mengkonfirmasi barang sudah diterima
    public function markAsCompleted($id)
    {
        $order = Order::with('orderItems')->where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        if ($order->status == 'shipped') {
            $order->update([
                'status' => 'completed'
            ]);

            // OTOMATIS REDIRECT: Cari produk pertama dari pesanan ini
            $firstItem = $order->orderItems->first();
            
            if ($firstItem) {
                // Arahkan langsung ke halaman produk tersebut dengan pesan khusus
                return redirect()->route('product.show', $firstItem->product_id)
                                 ->with('success', 'Pesanan selesai! 🎉 Yuk, bagikan pengalaman Anda dengan memberikan ulasan di bawah ini.');
            }

            return back()->with('success', 'Hore! Terima kasih telah berbelanja. Pesanan Anda telah selesai.');
        }

        return back()->with('error', 'Status pesanan tidak dapat diubah.');
    }

    
}