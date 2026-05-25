<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Detail Order #{{ $order->id }} | PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen pb-20">

    <!-- Header Dashboard Admin -->
    <header class="bg-slate-900 text-white py-6 mb-8 shadow-lg">
        <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Manajemen Pesanan</p>
                <h1 class="text-2xl font-extrabold tracking-tighter">ORDER <span class="text-rose-400">#{{ $order->id }}</span></h1>
            </div>
            <a href="{{ route('admin.orders') }}" class="bg-slate-800 hover:bg-slate-700 text-sm font-bold px-5 py-2.5 rounded-xl transition border border-slate-700">
                 Kembali ke Daftar
            </a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI: Detail Produk & Status -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Card Ringkasan Produk -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                    <h2 class="font-extrabold text-slate-800 text-lg uppercase tracking-tight">Item Pashmina</h2>
                    <span class="px-5 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full 
                        {{ $order->status == 'paid' ? 'bg-emerald-100 text-emerald-700' : 
                           ($order->status == 'waiting' ? 'bg-amber-100 text-amber-700' : 
                           ($order->status == 'completed' ? 'bg-slate-100 text-slate-700' : 
                           ($order->status == 'shipped' ? 'bg-blue-100 text-blue-700' :
                           ($order->status == 'canceled' ? 'bg-slate-100 text-slate-600' : 'bg-rose-100 text-rose-700')))) }}">
                        {{ $order->statusIndo() }}
                    </span>
                </div>
                <div class="p-8">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-slate-400 text-[10px] uppercase font-black tracking-widest border-b border-slate-50">
                                <th class="pb-4">Produk</th>
                                <th class="pb-4 text-center">Qty</th>
                                <th class="pb-4 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td class="py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden">
                                            <img src="{{ $item->product->imageUrl() }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 text-sm">{{ $item->product->name }}</p>
                                            <p class="text-xs text-slate-400">Variasi: Premium Silk</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-5 text-center font-bold text-slate-600 text-sm">{{ $item->quantity }}</td>
                                <td class="py-5 text-right font-extrabold text-slate-800">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="bg-slate-50 px-8 py-6 border-t border-slate-100 flex justify-between items-center">
                    <p class="text-xs font-black uppercase tracking-widest text-slate-400">Total Pembayaran</p>
                    <p class="text-xl font-black text-rose-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- AKSI ADMIN BERDASARKAN STATUS -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-lg">Aksi Admin</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kontrol pesanan sesuai status saat ini</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-5 bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-4 rounded-2xl text-sm font-bold">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-5 bg-rose-50 border border-rose-100 text-rose-700 px-5 py-4 rounded-2xl text-sm font-bold">
                        {{ session('error') }}
                    </div>
                @endif

                @if(in_array($order->status, ['pre_order', 'pending']))
                    <div class="bg-amber-50 border border-amber-100 rounded-3xl p-6">
                        <p class="font-extrabold text-amber-800 mb-2">Menunggu pembayaran dari pembeli</p>
                        <p class="text-sm text-amber-700 leading-relaxed">Admin belum bisa memverifikasi karena pembeli belum mengunggah bukti pembayaran. Setelah bukti masuk, tombol terima atau tolak pembayaran akan muncul otomatis.</p>
                    </div>
                @elseif($order->status == 'waiting')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <form action="{{ route('admin.order.approve', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-emerald-500 text-white font-bold py-4 rounded-2xl hover:bg-emerald-600 transition shadow-lg shadow-emerald-100 text-sm uppercase tracking-wider">
                                Terima Pembayaran
                            </button>
                        </form>
                        <button type="button" onclick="document.getElementById('reject-form-main').classList.toggle('hidden')" class="w-full bg-white text-rose-600 border border-rose-200 font-bold py-4 rounded-2xl hover:bg-rose-50 transition text-sm uppercase tracking-wider">
                            Tolak Pembayaran
                        </button>
                    </div>

                    <div id="reject-form-main" class="hidden mt-5 p-5 bg-rose-50 rounded-2xl border border-rose-100">
                        <form action="{{ route('admin.order.reject', $order->id) }}" method="POST">
                            @csrf
                            <label class="block text-xs font-black uppercase tracking-widest text-rose-500 mb-2">Alasan Penolakan</label>
                            <textarea name="reason" class="w-full bg-white border-none rounded-xl p-4 text-sm mb-3 ring-1 ring-rose-100 focus:ring-2 focus:ring-rose-500 outline-none" placeholder="Contoh: nominal transfer tidak sesuai atau foto bukti kurang jelas." required></textarea>
                            <button type="submit" class="w-full bg-rose-600 text-white font-bold py-3 rounded-xl text-xs uppercase tracking-widest">Kirim Penolakan</button>
                        </form>
                    </div>
                @elseif($order->status == 'paid')
                    <div class="bg-emerald-50 border border-emerald-100 rounded-3xl p-6">
                        <p class="font-extrabold text-emerald-800 mb-2">Pembayaran sudah diterima</p>
                        <p class="text-sm text-emerald-700 leading-relaxed">Lanjutkan ke modul pengiriman untuk membuat nomor resi dan label packing.</p>
                    </div>
                @elseif($order->status == 'shipped')
                    <div class="bg-blue-50 border border-blue-100 rounded-3xl p-6">
                        <p class="font-extrabold text-blue-800 mb-2">Pesanan sedang dikirim</p>
                        <p class="text-sm text-blue-700 leading-relaxed">Menunggu pembeli mengonfirmasi bahwa paket sudah diterima.</p>
                    </div>
                @elseif($order->status == 'completed')
                    <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6">
                        <p class="font-extrabold text-slate-800 mb-2">Pesanan selesai</p>
                        <p class="text-sm text-slate-600 leading-relaxed">Tidak ada aksi lanjutan yang diperlukan untuk pesanan ini.</p>
                    </div>
                @elseif($order->status == 'canceled')
                    <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6">
                        <p class="font-extrabold text-slate-800 mb-2">Pesanan dibatalkan pembeli</p>
                        <p class="text-sm text-slate-600 leading-relaxed mb-4">Pesanan ini tidak akan masuk proses pembayaran dan pengiriman.</p>
                        @if($order->cancellation_reason)
                            <div class="bg-white border border-slate-200 rounded-2xl p-4">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Alasan Pembatalan</p>
                                <p class="text-sm font-semibold text-slate-700 leading-relaxed">{{ $order->cancellation_reason }}</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- KOTAK LOGISTIK & PENGIRIMAN -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <h3 class="font-extrabold text-slate-800 text-lg">Manajemen Pengiriman</h3>
                </div>

                @if(in_array($order->status, ['paid', 'shipped', 'completed']))
                    @if(empty($order->resi_number))
                        <!-- Step 1: Input Logistik -->
                        <form action="{{ route('admin.order.generate_resi', $order->id) }}" method="POST" class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Jasa Kurir Pilihan Pembeli</label>
                                    <div class="w-full px-5 py-3.5 rounded-2xl bg-white ring-1 ring-slate-200 text-slate-700 font-extrabold">
                                        {{ $order->courier ?? 'Belum dipilih' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Nomor Resi</label>
                                    <div class="w-full px-5 py-3.5 rounded-2xl bg-slate-200 text-slate-500 text-xs font-bold flex items-center italic">
                                        Otomatis dibuat oleh sistem PASHMOOD
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-2xl hover:bg-rose-600 transition shadow-lg shadow-slate-200 uppercase tracking-widest text-xs disabled:opacity-50 disabled:cursor-not-allowed" {{ $order->courier ? '' : 'disabled' }}>
                                Generate Resi & Label
                            </button>
                        </form>
                    @else
                        <!-- Step 2: Cetak & Konfirmasi Pengiriman -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-6 rounded-3xl bg-emerald-50 border border-emerald-100">
                                <p class="text-[10px] font-black text-emerald-600 uppercase mb-1">Kurir & Resi</p>
                                <p class="font-extrabold text-slate-800">{{ $order->courier }} - <span class="text-rose-600">{{ $order->resi_number }}</span></p>
                            </div>
                            <a href="{{ route('admin.order.print_resi', $order->id) }}" target="_blank" class="p-6 rounded-3xl bg-white border border-slate-200 hover:border-rose-500 transition flex items-center justify-center gap-3 font-bold text-slate-700">
                                Cetak Label Packing
                            </a>
                        </div>

                        @if(!in_array($order->status, ['shipped', 'completed']))
                        <form action="{{ route('admin.order.ship', $order->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-2xl hover:bg-rose-600 transition shadow-xl shadow-slate-200">
                                Tandai Pesanan Telah Dikirim
                            </button>
                        </form>
                        @endif
                    @endif
                @else
                    <div class="text-center py-8 bg-slate-50 rounded-3xl border border-dashed border-slate-200 text-slate-400 text-sm font-medium">
                        Modul pengiriman aktif setelah pembayaran diverifikasi.
                    </div>
                @endif
            </div>
        </div>

        <!-- KOLOM KANAN: Detail Pelanggan & Pembayaran -->
        <div class="space-y-8">
            
            <!-- Detail Pelanggan -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
                <h3 class="font-extrabold text-slate-800 text-sm uppercase tracking-widest mb-6 border-b border-slate-50 pb-4">Info Pengiriman</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-black text-slate-300 uppercase leading-none">Nama Penerima</p>
                        <p class="font-bold text-slate-800">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-300 uppercase leading-none">No. WhatsApp</p>
                        <p class="font-bold text-slate-800">{{ $order->phone }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-300 uppercase leading-none">Jasa Pengiriman</p>
                        <p class="font-bold text-slate-800">{{ $order->courier ?? 'Belum dipilih' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-300 uppercase leading-none">Alamat Lengkap</p>
                        <p class="font-medium text-slate-600 text-sm leading-relaxed">{{ $order->address }}</p>
                    </div>
                </div>
            </div>

            <!-- Bukti Transfer -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
                <h3 class="font-extrabold text-slate-800 text-sm uppercase tracking-widest mb-6 border-b border-slate-50 pb-4">Bukti Pembayaran</h3>
                
                @if($order->payment_proof)
                    <div class="relative group cursor-pointer">
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full aspect-square object-cover rounded-3xl border border-slate-100 group-hover:opacity-75 transition">
                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition font-bold text-xs text-slate-800 bg-white/20 backdrop-blur-sm rounded-3xl">
                            Klik untuk Perbesar
                        </a>
                    </div>
                @else
                    <div class="py-12 bg-slate-50 rounded-3xl text-center border border-dashed border-slate-200">
                        <p class="text-xs font-bold text-slate-400">Belum ada lampiran</p>
                    </div>
                @endif

                @if($order->status == 'waiting')
                    <div class="mt-6 space-y-3">
                        <form action="{{ route('admin.order.approve', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-emerald-500 text-white font-bold py-3.5 rounded-2xl hover:bg-emerald-600 transition shadow-lg shadow-emerald-100 text-sm uppercase tracking-wider">
                                Terima Pembayaran
                            </button>
                        </form>
                        <button onclick="document.getElementById('reject-form').classList.toggle('hidden')" class="w-full bg-white text-rose-500 border border-rose-100 font-bold py-3.5 rounded-2xl hover:bg-rose-50 transition text-sm uppercase tracking-wider">
                            Tolak Pembayaran
                        </button>
                    </div>

                    <!-- Hidden Reject Form -->
                    <div id="reject-form" class="hidden mt-4 p-4 bg-rose-50 rounded-2xl border border-rose-100 animate-pulse">
                        <form action="{{ route('admin.order.reject', $order->id) }}" method="POST">
                            @csrf
                            <textarea name="reason" class="w-full bg-white border-none rounded-xl p-3 text-xs mb-3 ring-1 ring-rose-100 focus:ring-2 focus:ring-rose-500 outline-none" placeholder="Alasan penolakan..." required></textarea>
                            <button type="submit" class="w-full bg-rose-600 text-white font-bold py-2 rounded-xl text-[10px] uppercase tracking-widest">Kirim & Minta Re-upload</button>
                        </form>
                    </div>
                @endif
            </div>

        </div>
    </main>

</body>
</html>
