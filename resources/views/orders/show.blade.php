<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $order->id }} - PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#FDFBF9] min-h-screen text-slate-900 pb-20">

    <nav class="bg-white border-b border-rose-100/50 sticky top-0 z-50 shadow-sm">
        <div class="max-w-4xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-slate-500 font-bold hover:text-rose-600 transition group text-sm">
                <span class="group-hover:-translate-x-1 transition-transform">←</span> Kembali
            </a>
            <h1 class="font-extrabold text-xl tracking-tighter text-rose-800">PASHMOOD</h1>
            <div class="w-20"></div> </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 mt-10 space-y-8">
        
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Nomor Pesanan</p>
                <h2 class="text-2xl font-extrabold text-slate-800">#{{ $order->id }}</h2>
            </div>
            
            <span class="px-5 py-2 text-xs font-black uppercase tracking-widest rounded-full 
                {{ $order->status == 'paid' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 
                   ($order->status == 'waiting' ? 'bg-amber-100 text-amber-700 border border-amber-200' : 
                   ($order->status == 'completed' ? 'bg-indigo-100 text-indigo-700 border border-indigo-200' : 
                   ($order->status == 'shipped' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 
                   ($order->status == 'canceled' ? 'bg-slate-100 text-slate-600 border border-slate-200' : 'bg-rose-100 text-rose-700 border border-rose-200')))) }}">
                {{ $order->statusIndo() }}
            </span>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl text-sm font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-6 py-4 rounded-2xl text-sm font-bold">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <h3 class="font-extrabold text-slate-800 text-sm uppercase tracking-widest">Ringkasan Pesanan</h3>
            </div>
            <div class="p-8">
                <div class="space-y-6">
                    @foreach($order->orderItems as $item)
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-100 overflow-hidden shrink-0">
                                <img src="{{ $item->product->imageUrl() ?? asset('images/default.jpg') }}" alt="Produk" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">{{ $item->product->name ?? 'Produk PASHMOOD' }}</p>
                                <p class="text-xs text-slate-400 mt-1">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-extrabold text-slate-800">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-slate-50 p-8 flex justify-between items-center border-t border-slate-100">
                <p class="font-bold text-slate-500 uppercase tracking-widest text-xs">Total Pembayaran</p>
                <p class="text-2xl font-black text-rose-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
            <h3 class="font-extrabold text-slate-800 text-sm uppercase tracking-widest mb-6 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                Alamat Pengiriman
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Penerima & Kontak</p>
                    <p class="font-bold text-slate-800">{{ $order->user->name }}</p>
                    <p class="text-sm text-slate-500">{{ $order->phone }}</p>
                </div>
                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Alamat Lengkap</p>
                    <p class="text-sm font-medium text-slate-600 leading-relaxed">{{ $order->address }}</p>
                </div>
                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Jasa Pengiriman</p>
                    <p class="font-bold text-slate-800">{{ $order->courier ?? 'Belum dipilih' }}</p>
                </div>
            </div>
        </div>

        @if(in_array($order->status, ['pre_order', 'pending']))
            
            @php
                $admin = \App\Models\User::where('role', 'admin')->first();
            @endphp

            @if($admin && $admin->bank_account)
            <div class="bg-white border-2 border-rose-100 p-8 rounded-[2.5rem] shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-rose-50 rounded-bl-full -z-10"></div>
                
                <h3 class="font-extrabold text-slate-800 text-sm uppercase tracking-widest mb-2 flex items-center gap-2">
                    💳 Instruksi Pembayaran
                </h3>
                <p class="text-slate-500 text-sm mb-6 leading-relaxed">
                    Agar pre-order Anda segera kami proses, silakan lakukan pembayaran sebesar <strong class="text-rose-600 text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> ke rekening berikut:
                </p>
                
                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6 mb-8">
                    <div class="text-center md:text-left">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Bank Tujuan</p>
                        <p class="text-lg font-black text-slate-800">{{ $admin->bank_name }}</p>
                    </div>
                    <div class="text-center md:text-left border-t md:border-t-0 md:border-l border-slate-200 pt-4 md:pt-0 md:pl-6">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nomor Rekening</p>
                        <p class="text-2xl font-black text-rose-600 tracking-wider">{{ $admin->bank_account }}</p>
                    </div>
                    <div class="text-center md:text-left border-t md:border-t-0 md:border-l border-slate-200 pt-4 md:pt-0 md:pl-6">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Atas Nama</p>
                        <p class="text-lg font-bold text-slate-800">{{ $admin->bank_owner }}</p>
                    </div>
                </div>

                @if($order->rejection_reason)
                    <div class="bg-rose-50 border border-rose-200 p-5 rounded-2xl mb-6">
                        <p class="text-rose-700 font-bold text-sm mb-1">⚠️ Pembayaran Ditolak</p>
                        <p class="text-rose-600 text-sm mb-2">Alasan: {{ $order->rejection_reason }}</p>
                        <p class="text-xs text-rose-500 font-medium">Silakan unggah ulang bukti transfer yang valid.</p>
                    </div>
                @endif

                <form action="{{ route('order.confirm', $order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Upload Bukti Transfer</label>
                        <input type="file" name="payment_proof" class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100 transition cursor-pointer border border-slate-200 rounded-2xl p-2" required>
                    </div>
                    <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-2xl hover:bg-rose-600 transition shadow-xl shadow-slate-200">
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>
            @else
            <div class="bg-amber-50 p-6 rounded-[2rem] border border-amber-200 text-amber-700 text-sm font-bold text-center">
                Mohon maaf, sistem pembayaran sedang dalam pemeliharaan. Silakan hubungi admin.
            </div>
            @endif

        @elseif($order->status == 'waiting')
            <div class="bg-amber-50 p-8 rounded-[2.5rem] text-center border border-amber-100 flex flex-col items-center">
                <div class="w-16 h-16 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-amber-800 font-extrabold text-lg mb-2">Menunggu Verifikasi Admin</h3>
                <p class="text-amber-700 text-sm mb-6 max-w-md">Bukti transfer Anda telah kami terima. Tim kami akan segera melakukan pengecekan dalam waktu 1x24 jam.</p>
                <div class="w-48 h-64 rounded-2xl overflow-hidden border-4 border-white shadow-lg">
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full h-full object-cover">
                </div>
            </div>

        @elseif($order->status == 'canceled')
            <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-start gap-5">
                    <div class="w-12 h-12 bg-white text-slate-500 rounded-full flex items-center justify-center shrink-0 border border-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </div>
                    <div>
                        <h3 class="text-slate-800 font-extrabold text-lg mb-2">Pesanan Dibatalkan</h3>
                        <p class="text-slate-500 text-sm mb-4">Pre-order ini sudah dibatalkan dan tidak akan diproses ke tahap pembayaran atau pengiriman.</p>
                        @if($order->cancellation_reason)
                            <div class="bg-white border border-slate-200 rounded-2xl p-5">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Alasan Pembatalan</p>
                                <p class="text-sm font-semibold text-slate-700 leading-relaxed">{{ $order->cancellation_reason }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        @else
            <div class="bg-emerald-50 p-6 rounded-[2rem] text-center border border-emerald-100 flex items-center justify-center gap-4">
                <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
                <p class="text-emerald-800 font-bold text-sm md:text-base">Pembayaran Terverifikasi. Pre-Order Anda sedang diproses!</p>
            </div>
        @endif

        @if(in_array($order->status, ['pre_order', 'pending', 'waiting']))
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-rose-100 p-8">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-6">
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-sm uppercase tracking-widest mb-2">Batalkan Pesanan</h3>
                        <p class="text-sm text-slate-500 leading-relaxed max-w-xl">Jika Anda tidak ingin melanjutkan pre-order ini, isi alasan pembatalan terlebih dahulu. Stok produk akan otomatis dikembalikan.</p>
                    </div>
                </div>

                <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="cancellation_reason" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Alasan Pembatalan</label>
                        <textarea id="cancellation_reason" name="cancellation_reason" rows="4" class="w-full border border-slate-200 rounded-2xl p-4 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-rose-200 focus:border-rose-300" placeholder="Contoh: Saya ingin mengubah warna / belum bisa melakukan pembayaran." required>{{ old('cancellation_reason') }}</textarea>
                        @error('cancellation_reason')
                            <p class="text-rose-600 text-xs font-bold mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')" class="w-full md:w-auto bg-rose-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-rose-700 transition shadow-lg shadow-rose-100 text-sm uppercase tracking-wider">
                        Batalkan Pesanan
                    </button>
                </form>
            </div>
        @endif

        @if($order->resi_number)
            @php
                $trackingUrl = match($order->courier) {
                    'JNE Express' => 'https://www.jne.co.id/id/tracking/trace',
                    'J&T Express' => 'https://jet.co.id/track',
                    'Sicepat' => 'https://www.sicepat.com/checkAwb',
                    'Anteraja' => 'https://anteraja.id/tracking',
                    default => null,
                };
            @endphp
            <div class="bg-slate-900 text-white p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden">
                <div class="absolute -right-6 -top-6 text-slate-800 opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-40 w-40" viewBox="0 0 20 20" fill="currentColor"><path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" /><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5h-3V7h-1z" /></svg>
                </div>
                
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-widest text-rose-400 mb-1">Status Logistik</p>
                    <h3 class="text-xl font-extrabold mb-6">Paket Telah Dikirim!</h3>
                    
                    <div class="flex flex-col md:flex-row md:items-center gap-6">
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-widest font-bold mb-1">Kurir</p>
                            <p class="font-bold text-lg">{{ $order->courier }}</p>
                        </div>
                        <div class="md:border-l md:border-slate-700 pl-0 md:pl-6">
                            <p class="text-xs text-slate-400 uppercase tracking-widest font-bold mb-1">Nomor Resi</p>
                            <p class="font-black text-2xl tracking-wider text-rose-300">{{ $order->resi_number }}</p>
                        </div>
                    </div>

                    @if($trackingUrl)
                        <a href="{{ $trackingUrl }}" target="_blank" class="mt-6 inline-flex items-center justify-center rounded-2xl bg-white text-slate-900 px-6 py-3 text-xs font-black uppercase tracking-widest hover:bg-rose-100 transition">
                            Lacak Paket
                        </a>
                    @endif
                </div>
            </div>
        @endif

        @if($order->status == 'shipped')
            <div class="bg-indigo-50 border border-indigo-100 p-8 rounded-[2.5rem] text-center shadow-sm">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl shadow-sm">📦</div>
                <h3 class="text-xl font-extrabold text-indigo-900 mb-2">Paket Sudah Sampai?</h3>
                <p class="text-sm text-indigo-700 mb-6 max-w-md mx-auto">Pastikan Anda telah menerima produk dalam kondisi baik sebelum mengonfirmasi pesanan selesai.</p>
                
                <form action="{{ route('order.complete', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Yakin pesanan sudah diterima dengan aman?')" class="bg-indigo-600 text-white px-10 py-4 rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 w-full md:w-auto text-sm uppercase tracking-wider">
                        Ya, Pesanan Diterima
                    </button>
                </form>
            </div>
        @endif

        @if($order->status == 'completed')
            <div class="bg-rose-50 border border-rose-100 p-8 rounded-[2.5rem] text-center shadow-sm">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl shadow-sm">✨</div>
                <h3 class="text-xl font-extrabold text-rose-900 mb-2">Terima Kasih, Pashmood Sisters!</h3>
                <p class="text-sm text-rose-700 mb-6 max-w-md mx-auto">Bagikan pengalamanmu berbelanja di PASHMOOD. Ulasanmu sangat berarti bagi kami.</p>
                
                <div class="flex flex-col gap-3 max-w-sm mx-auto">
                    @foreach($order->orderItems as $item)
                        <a href="{{ route('product.show', $item->product_id) }}#review-form" class="bg-rose-600 text-white px-6 py-3.5 rounded-xl font-bold hover:bg-rose-700 transition shadow-md w-full text-sm flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                            Ulas {{ Str::limit($item->product->name ?? 'Produk', 20) }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </main>

</body>
</html>
