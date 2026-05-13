<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pre-Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow">
        <h2 class="text-2xl font-bold mb-6">Riwayat Pre-Order Saya</h2>
        
        <table class="w-full text-left">
            <thead>
                <tr class="border-b">
                    <th class="p-3">ID Pre-Order</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="border-b">
                    <td class="p-3">#{{ $order->id }}</td>
                    <td class="p-3">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 text-xs font-bold rounded {{ $order->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                           {{ strtoupper($order->statusIndo()) }}
                        </span>
                    </td>
                    <td class="p-3">
                        <a href="{{ route('order.detail', $order->id) }}" class="text-indigo-600 hover:underline">Lihat Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('dashboard') }}" class="block mt-6 text-gray-500 hover:underline">← Kembali ke Dashboard</a>
    </div>
</body>
</html>
