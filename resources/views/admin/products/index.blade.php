<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    
    <nav class="bg-indigo-600 shadow-md mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">SPORT CENTER-Shop
                <span class="font-bold text-white text-xl tracking-wider"></span>
                <a href="/dashboard" class="text-indigo-100 hover:text-white text-sm font-medium">← Kembali ke Dashboard</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
        
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 shadow-sm flex items-center justify-between" role="alert">
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Manajemen Produk</h1>
                <p class="text-gray-500 mt-1">Kelola stok, harga, dan variasi warna produk Anda.</p>
            </div>
            <a href="{{ route('products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-bold shadow-lg shadow-indigo-200 transition">
                + Tambah Produk Baru
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left text-gray-500 uppercase tracking-wider font-bold">
                        <th class="px-6 py-4">Gambar</th>
                        <th class="px-6 py-4">Nama Produk</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Variasi Warna</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="h-14 w-14 object-cover rounded-lg shadow-sm">
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded-md text-xs font-bold">{{ $product->category->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 font-mono">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($product->variations as $var)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-[10px] font-bold">
                                            {{ $var->color }} ({{ $var->stock }})
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('products.edit', $product->id) }}" class="text-indigo-600 font-bold hover:underline">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 font-bold hover:underline" onclick="return confirm('Yakin ingin hapus produk?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <p class="mb-4">Belum ada produk yang ditambahkan.</p>
                                    <a href="{{ route('products.create') }}" class="text-indigo-600 font-bold underline">Tambah produk pertama Anda</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>