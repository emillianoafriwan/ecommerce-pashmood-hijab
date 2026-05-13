<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Pre-Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="max-w-5xl mx-auto py-10 px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Keranjang Pre-Order Anda</h1>
        <a href="/" class="text-indigo-600 hover:underline font-medium">← Lanjut Pilih Pashmina</a>
    </div>

    @if(session('cart'))
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-indigo-50 border-b border-indigo-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-700">Produk</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Harga</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Jumlah</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Subtotal</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach(session('cart') as $id => $details)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 flex items-center">
                            @php
                                $cartImage = $details['image'] ?? '';
                                $cartImageUrl = \Illuminate\Support\Str::startsWith($cartImage, ['http://', 'https://'])
                                    ? $cartImage
                                    : (\Illuminate\Support\Str::startsWith($cartImage, 'images/') ? asset($cartImage) : asset('storage/' . $cartImage));
                            @endphp
                            <img src="{{ $cartImageUrl }}" class="h-16 w-16 object-cover rounded shadow-sm mr-4">
                            <span class="font-bold text-gray-800">{{ $details['name'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $details['quantity'] }}</td>
                        <td class="px-6 py-4 text-indigo-600 font-bold">
                            Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-sm bg-red-50 px-3 py-1 rounded hover:bg-red-100 transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="p-6 bg-gray-50 flex justify-end items-center border-t border-gray-200">
                <a href="{{ route('checkout.create') }}" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition shadow-md font-bold text-lg">
                    Lanjut Pre-Order
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-24 bg-white rounded-lg shadow-sm border border-gray-100">
            <p class="text-gray-500 mb-6 text-xl">Keranjang pre-order Anda masih kosong.</p>
            <a href="/" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition font-bold shadow-md">Mulai Pilih Pashmina</a>
        </div>
    @endif
</div>

</body>
</html>
