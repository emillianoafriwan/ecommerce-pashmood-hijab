<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('partials.theme-loader')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .paper { box-shadow: none !important; border: none !important; border-radius: 0 !important; max-width: none !important; }
        }
    </style>
</head>
<body class="p-6 md:p-8 bg-[#F8FAFC] text-slate-900">
    
    <div class="no-print mb-8 max-w-6xl mx-auto flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
        <a href="{{ route('admin.orders') }}" class="text-sm text-slate-500 hover:text-rose-600 font-bold transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Pre-Order
        </a>
        <button onclick="window.print()" class="inline-flex items-center justify-center bg-slate-900 text-white px-6 py-3 rounded-2xl text-sm font-bold hover:bg-rose-600 transition shadow-xl shadow-slate-200 gap-2 w-full sm:w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Laporan
        </button>
    </div>

    <div class="paper bg-white p-8 md:p-10 rounded-[2rem] shadow-sm border border-slate-100 w-full max-w-6xl mx-auto">
        <div class="mb-8 border-b-2 border-slate-900 pb-6 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div>
                <p class="text-xs font-black uppercase tracking-widest text-rose-500 mb-2">Admin Panel</p>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight uppercase">PASHMOOD</h1>
                <p class="text-lg text-slate-600 font-extrabold mt-2">Laporan Rekapitulasi Penjualan Pre-Order</p>
            </div>
            <div class="text-left md:text-right">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Tanggal Cetak</p>
                <p class="text-sm text-slate-700 font-bold mt-1">{{ date('d M Y, H:i') }} WIB</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-y border-slate-200 text-[10px] uppercase font-black text-slate-500 tracking-widest">
                        <th class="border border-slate-200 p-4 text-left">Tanggal Transaksi</th>
                        <th class="border border-slate-200 p-4 text-left">Nama Pembeli</th>
                        <th class="border border-slate-200 p-4 text-center">Status</th>
                        <th class="border border-slate-200 p-4 text-right">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="border border-slate-200 p-4 text-slate-600 font-medium">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                        <td class="border border-slate-200 p-4 font-bold text-slate-800">{{ $order->user->name }}</td>
                        <td class="border border-slate-200 p-4 text-center">
                            <span class="inline-flex px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full border
                                {{ $order->status == 'paid' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 
                                   ($order->status == 'waiting' ? 'bg-amber-50 text-amber-600 border-amber-200' : 
                                   ($order->status == 'shipped' ? 'bg-blue-50 text-blue-600 border-blue-200' :
                                   ($order->status == 'completed' ? 'bg-slate-100 text-slate-700 border-slate-200' :
                                   ($order->status == 'canceled' ? 'bg-rose-50 text-rose-600 border-rose-200' : 'bg-slate-50 text-slate-600 border-slate-200')))) }}">
                                {{ method_exists($order, 'statusIndo') ? $order->statusIndo() : $order->status }}
                            </span>
                        </td>
                        <td class="border border-slate-200 p-4 text-right font-extrabold text-slate-800">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="border border-slate-200 p-10 text-center text-slate-500 font-bold">
                            Belum ada data penjualan yang dikonfirmasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                
                <tfoot>
                    <tr class="bg-slate-900 text-white">
                        <td colspan="3" class="border border-slate-900 p-5 text-right font-black text-sm uppercase tracking-widest">
                            Total Pendapatan Bersih
                        </td>
                        <td class="border border-slate-900 p-5 text-right font-black text-xl text-rose-200">
                            Rp {{ number_format($totalRevenue ?? $orders->sum('total_price'), 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-16 flex justify-end">
            <div class="text-center w-52">
                <p class="text-slate-600 mb-16 font-medium">Mengetahui, Admin</p>
                <p class="font-bold text-slate-800 border-b border-slate-400 pb-1">{{ auth()->user()->name ?? 'Administrator' }}</p>
                <p class="text-xs text-slate-400 mt-1 font-black uppercase tracking-widest">PASHMOOD</p>
            </div>
        </div>
    </div>
    <script src="{{ asset('/js/smooth-navigation.js') }}"></script>
</body>
</html>
