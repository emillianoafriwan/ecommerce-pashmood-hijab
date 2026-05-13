<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Pre-Order - PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        /* Sembunyikan scrollbar untuk tabel horizontal di HP */
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#FDFBF9] text-slate-900 min-h-screen pb-20">

    <nav class="glass-nav border-b border-rose-100/50 sticky top-0 z-50 p-4 shadow-sm">
        <div class="max-w-5xl mx-auto flex justify-between items-center px-2">
            <h1 class="font-extrabold text-2xl tracking-tighter text-rose-800">PASHMOOD</h1>
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-500 hover:text-rose-600 transition">Dashboard Saya</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto py-10 px-4 sm:px-6 mt-4">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-10">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-rose-500 shadow-sm border border-rose-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Keranjang PO</h1>
                    <p class="mt-1 text-sm text-slate-500 font-medium">Periksa kembali pashmina pilihan Anda sebelum checkout.</p>
                </div>
            </div>
            
            <a href="/" class="inline-flex items-center justify-center px-6 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-600 hover:border-rose-300 hover:text-rose-600 transition w-full sm:w-auto gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Lanjut Belanja
            </a>
        </div>

        @if(session('cart'))
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto hide-scroll">
                    <table class="w-full text-left border-collapse min-w-[700px]">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-widest">
                                <th class="px-8 py-5">Produk Pashmina</th>
                                <th class="px-8 py-5">Harga Satuan</th>
                                <th class="px-8 py-5 text-center">Kuantitas</th>
                                <th class="px-8 py-5 text-right">Subtotal</th>
                                <th class="px-8 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach(session('cart') as $id => $details)
                            <tr class="hover:bg-slate-50/50 transition-colors duration-300 group">
                                <td class="px-8 py-6 flex items-center gap-5">
                                    @php
                                        $cartImage = $details['image'] ?? '';
                                        $cartImageUrl = \Illuminate\Support\Str::startsWith($cartImage, ['http://', 'https://'])
                                            ? $cartImage
                                            : (\Illuminate\Support\Str::startsWith($cartImage, 'images/') ? asset($cartImage) : asset('storage/' . $cartImage));
                                    @endphp
                                    <div class="w-20 h-20 rounded-2xl bg-slate-50 border border-slate-100 overflow-hidden shrink-0">
                                        <img src="{{ $cartImageUrl }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    </div>
                                    <span class="font-extrabold text-slate-800 text-base group-hover:text-rose-600 transition">{{ $details['name'] }}</span>
                                </td>
                                <td class="px-8 py-6 text-sm font-bold text-slate-500">
                                    Rp {{ number_format($details['price'], 0, ',', '.') }}
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="inline-flex items-center justify-center w-10 h-10 bg-slate-100 rounded-xl text-sm font-black text-slate-800">
                                        {{ $details['quantity'] }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right text-base font-black text-rose-600">
                                    Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-3 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition" title="Hapus Produk">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="p-6 md:p-8 bg-slate-50 flex flex-col sm:flex-row justify-between items-center border-t border-slate-100 gap-6">
                    <div class="text-center sm:text-left">
                        <p class="text-xs font-bold text-slate-400">Pashmina impian Anda sudah di depan mata!</p>
                        <p class="text-sm font-medium text-slate-500 mt-1">Lanjutkan ke pembayaran untuk mengamankan slot.</p>
                    </div>
                    <a href="{{ route('checkout.create') }}" class="w-full sm:w-auto bg-slate-900 text-white px-10 py-4 rounded-2xl font-bold hover:bg-rose-600 transition shadow-xl shadow-slate-200/50 flex items-center justify-center gap-3">
                        Checkout Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-24 bg-white rounded-[3rem] shadow-sm border border-slate-100">
                <div class="w-24 h-24 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-rose-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-rose-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <h3 class="text-2xl font-extrabold text-slate-800 mb-2">Keranjang Masih Kosong</h3>
                <p class="text-slate-500 font-medium mb-8 max-w-sm mx-auto">Anda belum memilih pashmina apapun. Yuk, temukan warna favoritmu dan amankan slotnya sekarang!</p>
                <a href="/" class="inline-block bg-slate-900 text-white px-8 py-4 rounded-2xl font-bold hover:bg-rose-600 transition shadow-lg shadow-slate-200">
                    Mulai Belanja
                </a>
            </div>
        @endif

    </main>

</body>
</html>