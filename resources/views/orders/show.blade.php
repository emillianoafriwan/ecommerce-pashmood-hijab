<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $order->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Detail Pesanan #{{ $order->id }}</h2>
            <span class="px-4 py-1 text-sm font-bold uppercase rounded-full 
                {{ $order->status == 'paid' ? 'bg-green-100 text-green-800' : 
                   ($order->status == 'waiting' ? 'bg-blue-100 text-blue-800' : 
                   ($order->status == 'completed' ? 'bg-purple-100 text-purple-800' : 'bg-yellow-100 text-yellow-800')) }}">
                Status: {{ strtoupper($order->statusIndo()) }}</span>
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
            <tfoot>
                <tr>
                    <td colspan="3" class="py-4 font-bold text-right text-lg">Total Pembayaran:</td>
                    <td class="py-4 font-bold text-right text-lg text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="mb-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
            <h3 class="font-bold text-lg mb-4 text-gray-800">📦 Informasi Pengiriman</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase">Alamat</p>
                    <p class="text-gray-800">{{ $order->address }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase">Nomor HP</p>
                    <p class="text-gray-800">{{ $order->phone }}</p>
                </div>
            </div>
        </div>

        @if($order->status == 'pending')
            
           @php
                $admin = \App\Models\User::where('role', 'admin')->first();
            @endphp

            @if($admin && $admin->bank_account)
            <div class="bg-indigo-50 border border-indigo-200 p-6 rounded-xl mb-6 shadow-sm">
                <h3 class="font-bold text-indigo-800 mb-2">💳 Instruksi Pembayaran</h3>
                <p class="text-indigo-700 mb-4">Silakan transfer sesuai nominal <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> ke rekening berikut:</p>
                
                <div class="bg-white p-4 rounded-lg border border-indigo-100 flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="text-center md:text-left">
                        <p class="text-xs text-gray-500 font-bold uppercase">Bank Tujuan</p>
                        <p class="text-lg font-bold text-gray-800">{{ $admin->bank_name }}</p>
                    </div>
                    <div class="text-center border-t md:border-t-0 md:border-l border-gray-200 pt-2 md:pt-0 md:pl-4">
                        <p class="text-xs text-gray-500 font-bold uppercase">Nomor Rekening</p>
                        <p class="text-xl font-bold text-indigo-600 tracking-wider">{{ $admin->bank_account }}</p>
                    </div>
                    <div class="text-center md:text-right border-t md:border-t-0 md:border-l border-gray-200 pt-2 md:pt-0 md:pl-4">
                        <p class="text-xs text-gray-500 font-bold uppercase">Atas Nama</p>
                        <p class="text-lg font-bold text-gray-800">{{ $admin->bank_owner }}</p>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-yellow-50 p-4 rounded-lg mb-6 border border-yellow-200 text-yellow-700 text-sm">
                ⚠️ [Peringatan Sistem]: Admin belum mengatur Nomor Rekening di halaman Profil Admin.
            </div>
            @endif

            @if($order->rejection_reason)
                <div class="bg-red-50 border border-red-200 p-4 rounded-lg mb-6">
                    <p class="text-red-700 font-bold mb-1">⚠️ Pembayaran Ditolak</p>
                    <p class="text-red-600 mb-2">Alasan: {{ $order->rejection_reason }}</p>
                    <p class="text-sm text-red-500 italic">Silakan unggah ulang bukti transfer yang sesuai.</p>
                </div>
            @endif

            <form action="{{ route('order.confirm', $order->id) }}" method="POST" enctype="multipart/form-data" class="bg-white border p-6 rounded-xl shadow-sm">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Upload Bukti Transfer Baru:</label>
                    <input type="file" name="payment_proof" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-500" required>
                    <p class="text-xs text-gray-500 mt-2">Format yang didukung: JPG, JPEG, PNG (Maksimal 2MB)</p>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition shadow-md">
                    Konfirmasi & Kirim Bukti
                </button>
            </form>

        @elseif($order->status == 'waiting')
            <div class="bg-blue-50 p-6 rounded-lg text-center border border-blue-200">
                <p class="text-blue-700 font-bold mb-4">Bukti transfer terkirim! Menunggu verifikasi Admin...</p>
                <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-48 mx-auto border rounded shadow-sm">
            </div>

        @else
            <!-- MUNCUL JIKA STATUS PAID, SHIPPED, ATAU COMPLETED -->
            <div class="bg-green-50 p-6 rounded-lg text-center border border-green-200">
                <p class="text-green-700 font-bold mb-4">✅ Pesanan sudah dibayar dan diverifikasi!</p>
                <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-48 mx-auto border rounded shadow-sm opacity-90">
            </div>
        @endif

        <!-- INFO PENGIRIMAN UNTUK PEMBELI -->
        @if($order->resi_number)
            <div class="bg-green-50 border border-green-200 p-6 rounded-xl mt-6 shadow-sm flex flex-col md:flex-row items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-green-800 flex items-center gap-2">
                        📦 Paket Anda Sedang Dikirim!
                    </h3>
                    <p class="text-sm text-green-700 mt-1">Pesanan Anda dikirim menggunakan kurir <strong>{{ $order->courier }}</strong>.</p>
                </div>
                <div class="mt-4 md:mt-0 bg-white px-6 py-3 rounded-lg border border-green-300 text-center shadow-sm">
                    <span class="block text-xs font-bold text-gray-500 uppercase">Nomor Resi</span>
                    <span class="block text-xl font-black text-gray-800 tracking-wider">{{ $order->resi_number }}</span>
                </div>
            </div>
        @endif

        <!-- TOMBOL KONFIRMASI PESANAN DITERIMA (HANYA MUNCUL JIKA STATUS DIKIRIM) -->
        @if($order->status == 'shipped')
            <div class="mt-8 bg-blue-50 border border-blue-200 p-6 rounded-xl text-center shadow-sm">
                <h3 class="text-lg font-bold text-blue-800 mb-2">Apakah paket sudah Anda terima?</h3>
                <p class="text-sm text-blue-600 mb-4">Pastikan paket dalam kondisi baik sebelum menekan tombol di bawah ini. Jika ditekan, dana akan diteruskan ke penjual.</p>
                
                <form action="{{ route('order.complete', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Yakin pesanan sudah diterima dengan aman?')" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-md w-full md:w-auto">
                        ✅ Ya, Pesanan Sudah Diterima
                    </button>
                </form>
            </div>
        @endif

        <!-- JIKA PESANAN SUDAH SELESAI, MUNCULKAN TOMBOL BERI ULASAN -->
        @if($order->status == 'completed')
            <div class="mt-8 bg-yellow-50 border border-yellow-200 p-6 rounded-xl text-center shadow-sm">
                <h3 class="text-lg font-bold text-yellow-800 mb-2">⭐ Jangan Lupa Beri Ulasan!</h3>
                <p class="text-sm text-yellow-700 mb-4">Bantu pembeli lain dengan membagikan pengalaman Anda terhadap produk yang Anda beli.</p>
                
                <div class="flex flex-col gap-3">
                    @foreach($order->orderItems as $item)
                        <!-- Tombol ini akan mengarahkan ke halaman produk masing-masing untuk diberi ulasan -->
                        <a href="{{ route('product.show', $item->product_id) }}" class="bg-yellow-500 text-white px-6 py-3 rounded-lg font-bold hover:bg-yellow-600 transition shadow-md inline-block w-full md:w-auto">
                            📝 Nilai Produk: {{ $item->product->name ?? 'Produk' }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <a href="{{ route('dashboard') }}" class="block text-center mt-6 text-gray-500 hover:text-gray-800 transition underline">
            Kembali ke Dashboard
        </a>
    </div>
</body>
</html>