<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori - Panel Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body class="bg-gray-50 p-10 font-sans antialiased min-h-screen">
    
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        
        <div class="mb-8 border-b pb-4">
            <h1 class="text-2xl font-extrabold text-gray-800">Tambah Kategori Baru</h1>
            <p class="text-gray-500 mt-1">Kelompokkan produk pashmina Anda agar lebih rapi.</p>
        </div>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf 
            
            <div class="mb-5">
                <label for="name" class="block text-gray-700 font-bold mb-2">Nama Kategori</label>
                <input type="text" name="name" id="name" required 
                    class="w-full border-gray-300 rounded-lg shadow-sm p-3 border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                    placeholder="Contoh: Pashmina Plisket, Inner Hijab, dll" autofocus>
                @error('name') 
                    <span class="text-red-500 text-sm mt-1 block font-medium">{{ $message }}</span> 
                @enderror
            </div>

            <div class="mb-8">
                <label for="slug" class="block text-gray-700 font-bold mb-2">Slug URL</label>
                <input type="text" name="slug" id="slug" required 
                    class="w-full bg-gray-50 border-gray-300 rounded-lg shadow-sm p-3 border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-gray-600" 
                    placeholder="Contoh: pashmina-plisket">
                <p class="text-xs text-gray-400 mt-2">💡 Slug akan terisi otomatis. Ini digunakan untuk alamat link (URL).</p>
                @error('slug') 
                    <span class="text-red-500 text-sm mt-1 block font-medium">{{ $message }}</span> 
                @enderror
            </div>

            <div class="flex items-center justify-between border-t border-gray-100 pt-6">
                <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-800 font-medium transition underline">
                    &larr; Batal & Kembali
                </a>
                <button type="submit" class="bg-indigo-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-indigo-700 transition shadow-md hover:shadow-lg">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>

    <script>
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        nameInput.addEventListener('keyup', function() {
            let preslug = nameInput.value;
            let slug = preslug.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // Hapus karakter selain huruf, angka, spasi, dan strip
                .replace(/[\s-]+/g, '-')      // Ubah spasi menjadi strip
                .replace(/^-+|-+$/g, '');     // Hapus strip di awal dan akhir kata
            
            slugInput.value = slug;
        });
    </script>
</body>
</html>