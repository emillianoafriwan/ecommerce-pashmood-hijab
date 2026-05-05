<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Panel Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 p-10 font-sans antialiased min-h-screen">
    
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        
        <div class="mb-8 border-b pb-4">
            <h1 class="text-2xl font-extrabold text-gray-800">Tambah Produk Baru</h1>
            <p class="text-gray-500 mt-1">Masukkan detail produk untuk menambah koleksi toko.</p>
        </div>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf 
            
            <div class="mb-5">
                <label for="category_id" class="block text-gray-700 font-bold mb-2">Kategori</label>
                <select name="category_id" id="category_id" required class="w-full border-gray-300 rounded-lg shadow-sm p-3 border focus:ring-2 focus:ring-indigo-500 outline-none cursor-pointer">
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                <div>
                    <label for="name" class="block text-gray-700 font-bold mb-2">Nama Produk</label>
                    <input type="text" name="name" id="name" required oninput="generateSlug()"
                        class="w-full border-gray-300 rounded-lg shadow-sm p-3 border focus:ring-2 focus:ring-indigo-500 outline-none transition"
                        placeholder="">
                </div>
                <div>
                    <div class="flex justify-between mb-2">
                        <label for="slug" class="block text-gray-700 font-bold">Slug URL</label>
                        <button type="button" onclick="generateSlug()" class="text-xs text-indigo-600 font-bold hover:underline">🔄 Generate Ulang</button>
                    </div>
                    <input type="text" name="slug" id="slug" required 
                        class="w-full bg-gray-50 border-gray-300 rounded-lg shadow-sm p-3 border focus:ring-2 focus:ring-indigo-500 outline-none text-gray-600 transition"
                        placeholder="">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                <div>
                    <label for="price" class="block text-gray-700 font-bold mb-2">Harga (Rp)</label>
                    <input type="number" name="price" id="price" required class="w-full border-gray-300 rounded-lg shadow-sm p-3 border focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label for="stock" class="block text-gray-700 font-bold mb-2">Stok Total</label>
                    <input type="number" name="stock" id="stock" required class="w-full border-gray-300 rounded-lg shadow-sm p-3 border focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
            </div>

            <div class="mb-8 p-5 bg-indigo-50 border border-indigo-100 rounded-xl">
                <label class="block text-gray-800 font-bold mb-4">Variasi Warna & Stok</label>
                <div id="variation-container">
                    <div class="flex gap-4 mb-3">
                        <input type="text" name="variations[0][color]" placeholder="Warna" class="w-1/2 p-3 border rounded-lg" required>
                        <input type="number" name="variations[0][stock]" placeholder="Stok Warna Ini" class="w-1/2 p-3 border rounded-lg" required>
                        <button type="button" class="text-red-500 font-bold px-3" onclick="removeRow(this)">X</button>
                    </div>
                </div>
                <button type="button" onclick="addRow()" class="mt-2 text-indigo-600 font-bold hover:underline">+ Tambah Warna Lain</button>
            </div>

            <div class="mb-8 p-5 bg-gray-50 border border-gray-200 rounded-lg">
                <label for="image" class="block text-gray-700 font-bold mb-2">Gambar Produk</label>
                <input type="file" name="image" id="image" accept="image/*" required class="w-full border-gray-300 bg-white rounded-lg shadow-sm p-2 border focus:ring-2 focus:ring-indigo-500 outline-none cursor-pointer">
            </div>

            <div class="flex items-center justify-between border-t border-gray-100 pt-6">
                <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-800 font-medium transition underline">&larr; Batal & Kembali</a>
                <button type="submit" class="bg-indigo-600 text-white font-bold px-10 py-3 rounded-xl hover:bg-indigo-700 transition shadow-md hover:shadow-lg">Simpan Produk</button>
            </div>
        </form>
    </div>

    <script>
        // Fungsi Slug
        function generateSlug() {
            const nameValue = document.getElementById('name').value;
            const slugOutput = nameValue.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/[\s-]+/g, '-').replace(/^-+|-+$/g, '');
            document.getElementById('slug').value = slugOutput;
        }

        // Fungsi Tambah Baris Variasi
        let rowCount = 1;
        function addRow() {
            const container = document.getElementById('variation-container');
            const newRow = document.createElement('div');
            newRow.className = 'flex gap-4 mb-3';
            newRow.innerHTML = `
                <input type="text" name="variations[${rowCount}][color]" placeholder="Warna" class="w-1/2 p-3 border rounded-lg" required>
                <input type="number" name="variations[${rowCount}][stock]" placeholder="Stok Warna Ini" class="w-1/2 p-3 border rounded-lg" required>
                <button type="button" class="text-red-500 font-bold px-3" onclick="removeRow(this)">X</button>
            `;
            container.appendChild(newRow);
            rowCount++;
        }

        function removeRow(btn) {
            btn.parentElement.remove();
        }
    </script>
</body>
</html>