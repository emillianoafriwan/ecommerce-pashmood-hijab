<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pre-Order - PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('partials.theme-loader')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-[#FDFBF9] text-slate-900 min-h-screen pb-20">

    <nav class="glass-nav border-b border-rose-100/50 sticky top-0 z-50 p-4 shadow-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-2">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-slate-500 font-bold hover:text-rose-600 transition group text-sm">
                <span class="group-hover:-translate-x-1 transition-transform">←</span> <span class="hidden sm:inline">Kembali ke Dashboard</span>
            </a>
            <h1 class="font-extrabold text-xl tracking-tighter text-rose-800">PASHMOOD</h1>
            <div class="w-10 sm:w-32"></div> </div>
    </nav>

    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 mt-4">
        
        <div class="flex items-center gap-4 mb-8">
            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-rose-500 shadow-sm border border-rose-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            </div>
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Riwayat Pre-Order</h2>
                <p class="mt-1 text-sm text-slate-500 font-medium">Pantau status pembayaran dan pengiriman pesanan Anda di sini.</p>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-widest">
                            <th class="px-8 py-5">ID Pesanan</th>
                            <th class="px-8 py-5">Produk</th>
                            <th class="px-8 py-5">Tanggal Order</th>
                            <th class="px-8 py-5">Total Pembayaran</th>
                            <th class="px-8 py-5">Item</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($orders as $order)
                            <tr class="hover:bg-slate-50/50 transition-colors duration-300 group">
                                <td class="px-8 py-6">
                                    <span class="text-sm font-bold text-slate-800 group-hover:text-rose-600 transition">
                                        #{{ $order->id }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    @php $product = $order->orderItems->first()?->product; @endphp
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-2xl overflow-hidden bg-slate-100">
                                            <img src="{{ $product?->imageUrl() ?? asset('images/default.jpg') }}" alt="{{ $product?->name ?? 'Produk' }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">{{ \Illuminate\Support\Str::limit($product?->name ?? 'Produk PASHMOOD', 30) }}</p>
                                            <p class="text-[10px] uppercase tracking-widest text-slate-400">{{ $order->orderItems->count() }} item</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-sm text-slate-500">
                                    {{ $order->created_at->format('d M Y') }}
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-sm font-black text-slate-800">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-sm text-slate-500">
                                    {{ $order->orderItems->sum('quantity') }} produk
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full 
                                        {{ $order->status == 'paid' ? 'bg-emerald-100 text-emerald-700' : 
                                           ($order->status == 'waiting' ? 'bg-amber-100 text-amber-700' : 
                                           ($order->status == 'completed' ? 'bg-indigo-100 text-indigo-700' : 
                                           ($order->status == 'shipped' ? 'bg-blue-100 text-blue-700' : 'bg-rose-100 text-rose-700'))) }}">
                                        {{ $order->statusIndo() }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($order->status == 'completed')
                                            @php
                                                $productIds = $order->orderItems->pluck('product_id')->toArray();
                                                $reviewedCount = \App\Models\Review::where('user_id', auth()->id())
                                                    ->whereIn('product_id', $productIds)
                                                    ->count();
                                                $allReviewed = count($productIds) > 0 && $reviewedCount >= count($productIds);
                                            @endphp

                                            @if($allReviewed)
                                                @php
                                                    $targetUrl = count($productIds) === 1 
                                                        ? route('product.show', $productIds[0]) 
                                                        : route('order.detail', $order->id) . '#review-section';
                                                @endphp
                                                <a href="{{ $targetUrl }}" class="inline-flex items-center justify-center px-4 py-2 bg-slate-50 border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-200 transition duration-300 gap-1.5 whitespace-nowrap">
                                                    Lihat Ulasan
                                                </a>
                                            @else
                                                <a href="{{ route('order.detail', $order->id) }}#review-section" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-xl text-xs font-bold hover:bg-emerald-600 hover:text-white transition duration-300 gap-1.5 whitespace-nowrap">
                                                    Beri Ulasan
                                                </a>
                                            @endif
                                        @endif
                                        <button type="button" onclick="tagOrderForChat({{ $order->id }})" class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-rose-600 transition duration-300 gap-1.5 whitespace-nowrap">
                                            Hubungi
                                        </button>
                                        <a href="{{ route('order.detail', $order->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-rose-50 text-rose-600 rounded-xl text-xs font-bold hover:bg-rose-600 hover:text-white transition duration-300 gap-1.5 whitespace-nowrap">
                                            Lihat Detail
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-8 py-20 text-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                        <svg class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Pesanan</h4>
                                    <p class="text-sm text-slate-500 font-medium max-w-sm mx-auto mb-6">Anda belum pernah melakukan pre-order. Yuk lihat koleksi terbaru kami!</p>
                                    <a href="{{ route('shop.index') }}" class="inline-block bg-slate-900 text-white px-6 py-3 rounded-2xl font-bold hover:bg-rose-600 transition shadow-md text-sm">
                                        Belanja Sekarang
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    <!-- FLOATING CHAT WIDGET -->
    @include('partials.chat-widget')

    <script src="{{ asset('/js/smooth-navigation.js') }}"></script>
    @include('partials.theme-customizer')
</body>
</html>
