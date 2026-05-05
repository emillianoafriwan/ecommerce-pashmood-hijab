<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - Panel Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body class="bg-gray-50 p-10 font-sans antialiased min-h-screen">
    
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        
        <div class="mb-8 border-b pb-4">
            <h1 class="text-2xl font-extrabold text-gray-800">Edit Kategori</h1>
            <p class="text-gray-500 mt-1">Perbarui informasi kategori produk pashmina Anda.</p>
        </div>

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf 
            @method('PUT') 
            
            <div class="mb-5">
                <label for="name" class="block text-gray-700 font-bold mb-2">Nama Kategori</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required 
                    class="w-full border-gray-300 rounded-lg shadow-sm p-3 border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                    placeholder="Contoh: Pashmina Plisket"
                    oninput="generateSlug()">
                @error('name') 
                    <span class="text-red-500 text-sm mt-1 block font-medium">{{ $message }}</span> 
                @enderror
            </div>

            <div class="mb-8">
                <div class="flex justify-between mb-2">
                    <label for="slug" class="block text-gray-700 font-bold">Slug URL</label>
                    <button type="button" onclick="generateSlug()" class="text-xs text-indigo-600 font-bold hover:underline">🔄 Generate Ulang</button>
                </div>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}" required 
                    class="w-full bg-gray-50 border-gray-300 rounded-lg shadow-sm p-3 border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-gray-600">
                <p class="text-xs text-gray-400 mt-2">💡 Slug akan ikut berubah jika Anda mengubah nama kategori.</p>
                @error('slug') 
                    <span class="text-red-500 text-sm mt-1 block font-medium">{{ $message }}</span> 
                @enderror
            </div>

            <div class="flex items-center justify-between border-t border-gray-100 pt-6">
                <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-800 font-medium transition underline">
                    &larr; Batal & Kembali
                </a>
                <button type="submit" class="bg-indigo-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-indigo-700 transition shadow-md hover:shadow-lg">
                    Update Kategori
                </button>
            </div>
        </form>
    </div>

    <script>
        function generateSlug() {
            const nameStr = document.getElementById('name').value;
            const slugStr = nameStr.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // Hapus karakter selain huruf, angka, spasi, dan strip
                .replace(/[\s-]+/g, '-')      // Ubah spasi menjadi strip
                .replace(/^-+|-+$/g, '');     // Hapus strip di awal dan akhir kata
            
            document.getElementById('slug').value = slugStr;
        }
    </script>
</body>
</html>