<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Resi #{{ $order->id }} - PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('partials.theme-loader')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            body { background: white !important; padding: 0 !important; }
            .no-print { display: none !important; }
            .label-paper { box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-[#F8FAFC] p-6 md:p-8 flex flex-col items-center text-black">
    
    <div class="no-print w-full max-w-md mb-6 flex items-center justify-between gap-3">
        <a href="{{ route('admin.order.detail', $order->id) }}" class="inline-flex items-center justify-center px-5 py-3 rounded-2xl text-sm font-bold text-slate-500 bg-white border border-slate-200 hover:border-slate-400 hover:text-slate-800 transition">
            Kembali
        </a>
        <button onclick="window.print()" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl text-sm font-bold text-white bg-slate-900 hover:bg-rose-600 transition shadow-xl shadow-slate-200 gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Label
        </button>
    </div>

    <div class="label-paper bg-white w-[100mm] min-h-[150mm] p-4 border-2 border-black shadow-xl">
        <div class="text-center border-b-2 border-black pb-3 mb-3">
            <p class="text-[9px] uppercase font-black tracking-[0.25em] mb-1">Pre-Order Pashmina</p>
            <h1 class="font-black text-3xl tracking-tight uppercase">PASHMOOD</h1>
            <p class="text-[10px] uppercase font-bold">Packing Label</p>
        </div>
        
        <div class="text-center border-2 border-black py-3 mb-4">
            <p class="text-[10px] font-black uppercase bg-black text-white inline-block px-3 py-1 mb-2">{{ $order->courier }}</p>
            <p class="font-black text-2xl tracking-widest break-all">{{ $order->resi_number }}</p>
        </div>

        <div class="border-2 border-black p-3 mb-3 text-sm">
            <p class="font-black border-b border-black mb-2 pb-1 text-[10px] uppercase tracking-widest">Penerima</p>
            <p class="font-black text-lg leading-tight">{{ $order->user->name }}</p>
            <p class="font-bold mt-1">{{ $order->phone }}</p>
            <p class="text-[11px] leading-snug mt-2 font-medium">{{ $order->address }}</p>
        </div>

        <div class="border-2 border-black p-3 mb-4 text-sm">
            <p class="font-black border-b border-black mb-2 pb-1 text-[10px] uppercase tracking-widest">Pengirim</p>
            <p class="font-black">PASHMOOD</p>
            <p class="text-[11px] font-medium">Admin PASHMOOD</p>
        </div>

        <div class="text-[10px] border-2 border-black p-3">
            <p class="font-black border-b border-black mb-2 pb-1 uppercase tracking-widest">Daftar Barang</p>
            <ul class="list-disc pl-4 pt-1 space-y-1">
                @foreach($order->orderItems as $item)
                    <li><strong>{{ $item->quantity }}x</strong> - {{ $item->product->name ?? 'Produk' }}</li>
                @endforeach
            </ul>
        </div>

        <div class="mt-4 grid grid-cols-3 gap-2 text-center text-[9px] font-black uppercase">
            <div class="border border-black py-2">QC</div>
            <div class="border border-black py-2">Packed</div>
            <div class="border border-black py-2">Sent</div>
        </div>
    </div>
    <script src="{{ asset('/js/smooth-navigation.js') }}"></script>
</body>
</html>
