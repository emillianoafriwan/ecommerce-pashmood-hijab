<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-10 font-sans antialiased min-h-screen">
    
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <h1 class="text-2xl font-extrabold text-gray-800 mb-8 border-b pb-4">Edit Produk</h1>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf 
            @method('PUT')
            
            <div class="mb-5">
                <label class="block text-gray-700 font-bold mb-2">Kategori</label>
                <select name="category_id" class="w-full border-gray-300 rounded-lg p-3 border outline-none">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Nama Produk</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required 
                        class="w-full border-gray-300 rounded-lg p-3 border outline-none"
                        oninput="generateSlug()">
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <label class="block text-gray-700 font-bold">Slug URL</label>
                        <button type="button" onclick="generateSlug()" class="text-xs text-indigo-600 font-bold hover:underline">🔄 Generate Ulang</button>
                    </div>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" required 
                        class="w-full bg-gray-50 border-gray-300 rounded-lg p-3 border outline-none text-gray-600">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-bold mb-2">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" required class="w-full border-gray-300 rounded-lg p-3 border outline-none">
            </div>

            <!-- BAGIAN KRUSIAL: MANAJEMEN STOK PER WARNA -->
            <div class="mb-8 p-6 bg-indigo-50 border border-indigo-100 rounded-2xl">
                <h3 class="text-lg font-bold text-indigo-800 mb-4 flex items-center gap-2">
                    🎨 Stok Per Warna
                </h3>
                
                <div class="grid grid-cols-1 gap-4">
                    @foreach($product->variations as $index => $variation)
                        <div class="flex items-center gap-4 bg-white p-4 rounded-xl border border-indigo-100 shadow-sm">
                            <!-- ID Variasi Wajib Ada -->
                            <input type="hidden" name="variations[{{ $index }}][id]" value="{{ $variation->id }}">
                            
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Warna</label>
                                <input type="text" name="variations[{{ $index }}][color]" value="{{ $variation->color }}" 
                                    class="w-full border-none p-0 font-bold text-gray-700 focus:ring-0 bg-transparent" readonly>
                            </div>

                            <div class="w-32">
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Stok</label>
                                <input type="number" name="variations[{{ $index }}][stock]" value="{{ $variation->stock }}" 
                                    class="w-full border border-gray-200 rounded-lg p-2 focus:ring-2 focus:ring-indigo-500 outline-none text-center font-black" required min="0">
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-[10px] text-indigo-400 mt-3 italic">*Total stok produk utama akan otomatis terhitung saat Bos klik Update.</p>
            </div>

            <div class="mb-8 p-5 bg-gray-50 border rounded-lg">
                <label class="block text-gray-700 font-bold mb-2">Gambar Baru</label>
                <input type="file" name="image" accept="image/*" class="w-full border-gray-300 bg-white rounded-lg p-2 border outline-none">
                @if($product->image_path)
                    <p class="text-sm text-gray-500 mt-2">Gambar saat ini ada di folder storage.</p>
                @endif
            </div>

            <div class="flex items-center justify-between border-t pt-6">
                <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-800 underline font-bold">Batal</a>
                <button type="submit" class="bg-indigo-600 text-white font-black px-10 py-3 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                    Update Produk
                </button>
            </div>
        </form>
    </div>

    <script>
        function generateSlug() {
            const nameStr = document.getElementById('name').value;
            const slugStr = nameStr.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') 
                .replace(/[\s-]+/g, '-')      
                .replace(/^-+|-+$/g, '');     
            
            document.getElementById('slug').value = slugStr;
        }
    </script>
</body>
</html>