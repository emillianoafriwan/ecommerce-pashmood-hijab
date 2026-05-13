<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Resi #{{ $order->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS Khusus Printer: Menyembunyikan tombol saat diprint */
        @media print {
            body { background: white !important; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-200 p-8 flex justify-center text-black font-sans">
    
    <!-- Ukuran Kertas Standard Resi / Kertas Label -->
    <div class="bg-white w-[100mm] min-h-[150mm] p-4 border border-gray-400 shadow-xl relative">
        
        <!-- Header / Logo Toko -->
        <div class="text-center border-b-2 border-black pb-2 mb-2">
            <h1 class="font-black text-2xl tracking-widest uppercase">PASHMINA PO</h1>
            <p class="text-[10px] uppercase font-bold">Toko Pre-Order Pashmina</p>
        </div>
        
        <!-- Kotak Resi & Barcode Palsu -->
        <div class="text-center border-2 border-black py-2 mb-4">
            <p class="text-[10px] font-bold uppercase bg-black text-white inline-block px-2 py-1 mb-1">{{ $order->courier }}</p>
            <p class="font-black text-2xl tracking-widest">{{ $order->resi_number }}</p>
        </div>

        <!-- Alamat Penerima -->
        <div class="border border-black p-2 mb-2 text-sm">
            <p class="font-bold border-b border-black mb-1 text-[10px]">PENERIMA:</p>
            <p class="font-bold text-lg leading-tight">{{ $order->user->name }}</p>
            <p class="font-bold">{{ $order->phone }}</p>
            <p class="text-[11px] leading-tight mt-1">{{ $order->address }}</p>
        </div>

        <!-- Alamat Pengirim -->
        <div class="border border-black p-2 mb-4 text-sm">
            <p class="font-bold border-b border-black mb-1 text-[10px]">PENGIRIM:</p>
            <p class="font-bold">PASHMINA PO</p>
            <p>0812-3456-7890 (CS)</p>
        </div>

        <!-- Daftar Barang -->
        <div class="text-[10px]">
            <p class="font-bold border-b border-black mb-1">DAFTAR BARANG:</p>
            <ul class="list-disc pl-4 pt-1">
                @foreach($order->orderItems as $item)
                    <li class="mb-1"><strong>{{ $item->quantity }}x</strong> - {{ $item->product->name ?? 'Produk' }}</li>
                @endforeach
            </ul>
        </div>
        
        <!-- Tombol Cetak (Hanya tampil di layar monitor) -->
        <button onclick="window.print()" class="no-print mt-8 w-full bg-blue-600 text-white font-bold py-3 rounded hover:bg-blue-700 transition">
            🖨️ KLIK UNTUK MENCETAK (PRINT)
        </button>
    </div>

</body>
</html>
