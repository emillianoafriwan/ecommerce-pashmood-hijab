<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Detail Pesanan #{{ $order->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Admin: Detail Pesanan #{{ $order->id }}</h2>
            <span class="px-4 py-1 text-sm font-bold uppercase rounded-full 
                {{ $order->status == 'paid' ? 'bg-green-100 text-green-800' : 
                   ($order->status == 'waiting' ? 'bg-blue-100 text-blue-800' : 
                   ($order->status == 'completed' ? 'bg-purple-100 text-purple-800' : 'bg-yellow-100 text-yellow-800')) }}">
                Status: {{ strtoupper($order->statusIndo()) }}
            </span>
        </div>

        <table class="w-full text-left mb-8">
            <thead class="border-b">
                <tr>
                    <th class="py-2">Produk</th>
                    <th class="py-2 text-center">Jumlah</th>
                    <th class="py-2 text-right">Harga</th>
                    <th class="py-2 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr class="border-b">
                    <td class="py-4">{{ $item->product->name ?? 'Produk Tidak Ditemukan' }}</td>
                    <td class="py-4 text-center">{{ $item->quantity }}</td>
                    <td class="py-4 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="py-4 text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="p-6 bg-gray-50 rounded-xl border">
                <h3 class="font-bold text-gray-800 mb-2">Info Pembeli</h3>
                <p>Nama: {{ $order->user->name }}</p>
                <p>Email: {{ $order->user->email }}</p>
            </div>
            <div class="p-6 bg-gray-50 rounded-xl border">
                <h3 class="font-bold text-gray-800 mb-2">Info Pengiriman</h3>
                <p>Alamat: {{ $order->address }}</p>
                <p>No HP: {{ $order->phone }}</p>
            </div>
        </div>

        <!-- KOTAK ALUR PENGIRIMAN (3 TAHAP) -->
        <div class="bg-indigo-50 border border-indigo-200 p-6 rounded-xl mt-6 shadow-sm">
            <h3 class="text-lg font-bold text-indigo-800 mb-4 flex items-center gap-2">
                🚚 Kelola Pengiriman Pesanan
            </h3>
            
            @php
                $hasResi = !empty($order->resi_number);
                $isShippedOrCompleted = in_array($order->status, ['shipped', 'completed']);
            @endphp
            
            @if(!$hasResi)
                <!-- TAHAP 1: MINTA ADMIN PILIH KURIR & BUAT RESI -->
                <form action="{{ route('admin.order.generate_resi', $order->id) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">1. Pilih Kurir</label>
                            <select name="courier" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                                <option value="" disabled selected>-- Pilih Kurir Pengiriman --</option>
                                <option value="JNE">JNE</option>
                                <option value="J&T Express">J&T Express</option>
                                <option value="Sicepat">Sicepat</option>
                                <option value="Anteraja">Anteraja</option>
                                <option value="Pos Indonesia">Pos Indonesia</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Resi</label>
                            <div class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-100 text-gray-500 italic text-sm cursor-not-allowed flex items-center h-[50px]">
                                ⚡ Nomor resi otomatis dibuat sistem.
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-3 border-t border-indigo-200 pt-4 mt-4">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-md w-full md:w-auto">
                            Buat Resi
                        </button>
                        <button type="button" disabled class="bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-bold cursor-not-allowed w-full md:w-auto">
                            Cetak Label
                        </button>
                        <button type="button" disabled class="bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-bold cursor-not-allowed w-full md:w-auto">
                            Kirim Pesanan
                        </button>
                    </div>
                </form>
            @else
                <!-- TAHAP 2 & 3: RESI SUDAH ADA, TINGGAL CETAK & KIRIM -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kurir Pengiriman</label>
                        <input type="text" value="{{ $order->courier }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 font-bold text-gray-700 cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Resi</label>
                        <input type="text" value="{{ $order->resi_number }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-indigo-700 font-black tracking-widest cursor-not-allowed uppercase" disabled>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 border-t border-indigo-200 pt-4 mt-4 items-center">
                    <button type="button" disabled class="bg-gray-200 text-gray-600 px-6 py-3 rounded-lg font-bold cursor-not-allowed w-full md:w-auto">
                        ✅ Resi Dibuat
                    </button>

                    <!-- Tombol Cetak Resi (Klik ini akan membuka gembok tombol Kirim) -->
                    <a href="{{ route('admin.order.print_resi', $order->id) }}" target="_blank" onclick="bukaGembokKirim()" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-md text-center flex items-center justify-center gap-2 w-full md:w-auto">
                        🖨️ Cetak Label
                    </a>

                    <!-- Tombol Kirim Pesanan -->
                    @if($isShippedOrCompleted)
                        <!-- Jika sudah dikirim -->
                        <button type="button" disabled class="bg-green-600 text-white px-6 py-3 rounded-lg font-bold cursor-not-allowed w-full md:w-auto shadow-md">
                            📦 Pesanan Telah Dikirim / Selesai
                        </button>
                    @else
                        <!-- Form Kirim Pesanan (Awalnya tergembok warna abu-abu) -->
                        <form action="{{ route('admin.order.ship', $order->id) }}" method="POST" class="w-full md:w-auto">
                            @csrf
                            <button type="submit" id="btnKirimPesanan" disabled class="bg-gray-400 text-gray-200 px-6 py-3 rounded-lg font-bold cursor-not-allowed w-full transition shadow-md flex items-center justify-center gap-2" title="Cetak resi terlebih dahulu untuk membuka tombol ini!">
                                📩  Kirim Pesanan
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Javascript Sakti untuk Buka Gembok -->
                <script>
                    function bukaGembokKirim() {
                        const btn = document.getElementById('btnKirimPesanan');
                        if(btn) {
                            btn.disabled = false;
                            // Ubah tombol dari abu-abu gembok menjadi hijau terbuka
                            btn.className = "bg-green-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-green-700 transition shadow-md w-full flex items-center justify-center gap-2 animate-pulse";
                            btn.innerHTML = "🚀 Tahap 3: Kirim Pesanan";
                        }
                    }
                </script>
            @endif
        </div>

        <div class="mb-8 mt-8">
            <h3 class="font-bold text-lg mb-4">Bukti Transfer</h3>
            @if($order->payment_proof)
                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-64 border rounded shadow-lg hover:opacity-90 transition">
                </a>
            @else
                <p class="text-red-500 italic">Belum ada bukti transfer.</p>
            @endif
        </div>

        @if($order->status == 'waiting')
            <div class="space-y-6 border-t pt-6">
                
                <form action="{{ route('admin.order.approve', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition shadow-lg">
                        ✅ Setujui Pembayaran & Konfirmasi
                    </button>
                </form>

                <form action="{{ route('admin.order.reject', $order->id) }}" method="POST" class="bg-red-50 p-6 rounded-lg border border-red-200">
                    @csrf
                    <label class="block text-red-800 font-bold mb-2">Tolak Pembayaran</label>
                    <textarea name="reason" class="w-full border border-red-300 rounded-lg p-3 mb-4 focus:ring-2 focus:ring-red-500 outline-none" placeholder="Tulis alasan penolakan (misal: Foto buram, nominal tidak sesuai)..." rows="3" required></textarea>
                    <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-lg hover:bg-red-700 transition shadow-md">
                        ❌ Tolak & Minta Upload Ulang
                    </button>
                </form>

            </div>
        @elseif(in_array($order->status, ['paid', 'shipped', 'completed']))
            <!-- Menyembunyikan tombol approve/reject jika sudah dibayar ke atas -->
            <div class="bg-green-100 text-green-700 p-4 rounded-lg text-center font-bold">
                Pembayaran Sudah Dikonfirmasi.
            </div>
        @endif

        <a href="{{ route('admin.orders') }}" class="block text-center mt-6 text-gray-500 hover:text-gray-800 hover:underline transition">
            ← Kembali ke Daftar Pesanan
        </a>
    </div>
</body>
</html>