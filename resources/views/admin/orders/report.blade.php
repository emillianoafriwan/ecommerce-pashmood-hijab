<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - Pashmina Pre-Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS ini memastikan tombol tidak ikut tercetak di kertas */
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="p-8 bg-gray-50 font-sans text-gray-800">
    
    <!-- Tombol Aksi (Akan hilang saat diprint) -->
    <div class="no-print mb-8 flex items-center justify-between bg-white p-4 rounded-xl shadow-sm border border-gray-200">
        <a href="{{ route('admin.orders') }}" class="text-gray-500 hover:text-gray-800 font-bold transition flex items-center gap-2">
            &larr; Kembali ke Daftar Pre-Order
        </a>
        <button onclick="window.print()" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-md flex items-center gap-2">
            🖨️ Cetak Laporan Sekarang
        </button>
    </div>

    <!-- Area Kertas Laporan -->
    <div class="bg-white p-10 rounded-xl shadow-sm border border-gray-200 w-full max-w-5xl mx-auto">
        
        <!-- Header Kop Laporan -->
        <div class="mb-8 border-b-2 border-gray-800 pb-6 text-center">
            <h1 class="text-4xl font-black text-gray-900 tracking-widest uppercase">PASHMINA PO</h1>
            <p class="text-xl text-gray-600 font-bold mt-2">Laporan Rekapitulasi Penjualan Pre-Order</p>
            <p class="text-sm text-gray-500 mt-1">Dicetak pada: {{ date('d M Y, H:i') }} WIB</p>
        </div>

        <!-- Tabel Data Penjualan -->
        <table class="w-full border-collapse border border-gray-300 text-sm md:text-base">
            <thead class="bg-indigo-50 border-b-2 border-indigo-200">
                <tr>
                    <th class="border border-gray-300 p-3 text-left font-bold text-indigo-900">Tanggal Transaksi</th>
                    <th class="border border-gray-300 p-3 text-left font-bold text-indigo-900">Nama Pembeli</th>
                    <th class="border border-gray-300 p-3 text-center font-bold text-indigo-900">Status</th>
                    <th class="border border-gray-300 p-3 text-right font-bold text-indigo-900">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition">
                    <td class="border border-gray-300 p-3">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                    <td class="border border-gray-300 p-3 font-bold">{{ $order->user->name }}</td>
                    <td class="border border-gray-300 p-3 text-center">
                        <!-- Tampilan badge status yang rapi -->
                        <span class="px-3 py-1 text-[10px] font-black uppercase rounded-full 
                            {{ $order->status == 'paid' ? 'bg-blue-100 text-blue-800' : 
                               ($order->status == 'shipped' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="border border-gray-300 p-3 text-right font-medium text-gray-700">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="border border-gray-300 p-8 text-center text-gray-500 font-bold text-lg">
                        Belum ada data penjualan yang dikonfirmasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
            
            <!-- Footer Total Pendapatan -->
            <tfoot class="bg-gray-100">
                <tr>
                    <td colspan="3" class="border border-gray-300 p-4 text-right font-black text-lg text-gray-800 uppercase tracking-wider">
                        Total Pendapatan Bersih:
                    </td>
                    <td class="border border-gray-300 p-4 text-right font-black text-xl text-indigo-700">
                        <!-- Otomatis menghitung total dari controller yang sudah kita perbaiki -->
                        Rp {{ number_format($totalRevenue ?? $orders->sum('total_price'), 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Tanda Tangan Admin (Opsional untuk Print) -->
        <div class="mt-16 flex justify-end">
            <div class="text-center w-48">
                <p class="text-gray-600 mb-16">Mengetahui, Admin</p>
                <p class="font-bold text-gray-800 border-b border-gray-400 pb-1">{{ auth()->user()->name ?? 'Administrator' }}</p>
                <p class="text-xs text-gray-500 mt-1">PASHMINA PO</p>
            </div>
        </div>

    </div>
</body>
</html>
