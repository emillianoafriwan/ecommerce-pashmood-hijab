<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pre-Order - Admin PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('partials.theme-loader')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 min-h-screen pb-20">

    <header class="bg-slate-900 text-white py-6 mb-10 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Admin Panel</p>
                <h1 class="text-2xl font-extrabold tracking-tighter">PASHMOOD</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="/dashboard" class="flex items-center justify-center w-10 h-10 rounded-full border border-slate-700 hover:border-rose-500 bg-slate-800 overflow-hidden transition" title="Dashboard">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-rose-100 flex items-center justify-center text-rose-700 font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-slate-800 shadow-sm border border-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                </div>
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Daftar Pre-Order</h2>
                    <p class="mt-1 text-sm text-slate-500 font-medium">Pantau, verifikasi, dan kelola semua pesanan masuk.</p>
                </div>
            </div>
            
            <a href="{{ route('admin.orders.report') }}" target="_blank" class="inline-flex items-center justify-center px-6 py-3.5 rounded-2xl text-sm font-bold text-white bg-slate-900 hover:bg-rose-600 shadow-xl shadow-slate-200 transition gap-2 w-full sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak Laporan
            </a>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto hide-scroll">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-widest">
                            <th class="px-8 py-5">ID Pesanan</th>
                            <th class="px-8 py-5">Produk</th>
                            <th class="px-8 py-5">Nama Pembeli</th>
                            <th class="px-8 py-5">Total Bayar</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/50 transition-colors duration-300 group">
                            <td class="px-8 py-6">
                                <span class="text-sm font-bold text-slate-500 group-hover:text-slate-800 transition">#{{ $order->id }}</span>
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
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ substr($order->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-slate-800">{{ $order->user->name ?? 'User Unknown' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-sm font-black text-slate-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full border
                                    {{ $order->status == 'paid' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 
                                       ($order->status == 'waiting' ? 'bg-amber-50 text-amber-600 border-amber-200' : 
                                       ($order->status == 'shipped' ? 'bg-blue-50 text-blue-600 border-blue-200' :
                                       ($order->status == 'completed' ? 'bg-indigo-50 text-indigo-600 border-indigo-200' :
                                       ($order->status == 'canceled' ? 'bg-rose-50 text-rose-600 border-rose-200' : 'bg-slate-50 text-slate-600 border-slate-200')))) }}">
                                    {{ strtoupper($order->statusIndo()) }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <a href="{{ route('admin.order.detail', $order->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold hover:bg-rose-600 hover:text-white transition duration-300 gap-1.5">
                                    Kelola
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                    <svg class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Pesanan</h4>
                                <p class="text-sm text-slate-500 font-medium max-w-sm mx-auto">Saat ini belum ada pre-order yang masuk dari pelanggan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script src="{{ asset('/js/smooth-navigation.js') }}"></script>
    @include('partials.theme-customizer')
</body>
</html>
