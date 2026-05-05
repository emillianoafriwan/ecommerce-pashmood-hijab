<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-xl shadow">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Semua Pesanan</h2>
            <a href="{{ route('admin.orders.report') }}" target="_blank" 
               class="bg-green-600 text-white px-5 py-2.5 rounded-lg font-bold hover:bg-green-700 transition flex items-center gap-2">
                🖨️ Cetak Laporan
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="p-3">ID</th>
                        <th class="p-3">Customer</th>
                        <th class="p-3">Total</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-3 font-medium text-gray-800">#{{ $order->id }}</td>
                        <td class="p-3">{{ $order->user->name ?? 'User Unknown' }}</td>
                        <td class="p-3">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="p-3">
                            <span class="px-3 py-1 text-xs font-bold rounded-full 
                                {{ $order->status == 'paid' ? 'bg-green-100 text-green-800' : 
                                   ($order->status == 'waiting' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ strtoupper($order->statusIndo()) }}
                            </span>
                        </td>
                        <td class="p-3">
                            <a href="{{ route('admin.order.detail', $order->id) }}" 
                               class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 transition">
                                Detail & Verifikasi
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-500">Belum ada pesanan yang masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="/admin/dashboard" class="inline-block mt-6 text-gray-500 hover:text-indigo-600 transition underline">
            ← Kembali ke Dashboard Admin
        </a>
    </div>
</body>
</html>