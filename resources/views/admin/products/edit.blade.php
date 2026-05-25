<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Admin PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 min-h-screen pb-20">
    
    <header class="bg-slate-900 text-white py-6 mb-10 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Admin Panel</p>
                <h1 class="text-2xl font-extrabold tracking-tighter">PASHMOOD</h1>
            </div>
            <a href="{{ route('products.index') }}" class="bg-slate-800 hover:bg-slate-700 text-sm font-bold px-5 py-2.5 rounded-xl transition border border-slate-700 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="hidden sm:inline">Kembali ke Produk</span>
            </a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="mb-6 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
            <span>Admin Panel</span>
            <span>/</span>
            <span>Produk</span>
            <span>/</span>
            <span class="text-rose-500">Edit</span>
        </div>

        <div class="bg-white p-6 md:p-10 rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="mb-10 flex items-start gap-4">
                <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center border border-rose-100 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Edit Produk</h1>
                    <p class="text-slate-500 mt-2 font-medium text-sm">Perbarui detail produk, harga, stok warna, dan gambar koleksi pre-order.</p>
                </div>
            </div>

            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf 
                @method('PUT')
                
                <div class="mb-6">
                    <label for="category_id" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Kategori</label>
                    <select name="category_id" id="category_id" class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-700 font-bold bg-slate-50 focus:bg-white cursor-pointer">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Nama Produk</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required 
                            class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white placeholder-slate-300"
                            oninput="generateSlug()">
                        @error('name')
                            <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-end mb-3">
                            <label for="slug" class="block text-xs font-black text-slate-700 uppercase tracking-widest">Slug URL</label>
                            <button type="button" onclick="generateSlug()" class="text-[10px] font-bold uppercase tracking-widest text-rose-500 hover:text-rose-700 transition flex items-center gap-1 bg-rose-50 px-3 py-1.5 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Generate
                            </button>
                        </div>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" required 
                            class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-500 font-medium bg-slate-100 placeholder-slate-300">
                        @error('slug')
                            <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-8">
                    <label for="price" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Harga (Rp)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required min="0"
                        class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white">
                    @error('price')
                        <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8 p-5 md:p-6 bg-rose-50/60 border border-rose-100 rounded-[2rem]">
                    <div class="mb-5">
                        <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest">Stok Per Warna</h2>
                        <p class="text-xs text-slate-500 font-medium mt-1">Total stok utama akan dihitung otomatis dari stok variasi saat produk diperbarui.</p>
                    </div>
                    
                    <div class="space-y-3">
                        @foreach($product->variations as $index => $variation)
                            <div class="grid grid-cols-1 md:grid-cols-[1fr_160px] gap-3 bg-white p-4 rounded-2xl border border-rose-100 shadow-sm">
                                <input type="hidden" name="variations[{{ $index }}][id]" value="{{ $variation->id }}">
                                
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Warna</label>
                                    <input type="text" name="variations[{{ $index }}][color]" value="{{ $variation->color }}" 
                                        class="w-full px-4 py-3 rounded-xl border-none ring-1 ring-slate-200 outline-none text-sm font-bold text-slate-500 bg-slate-100" readonly>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Stok</label>
                                    <input type="number" name="variations[{{ $index }}][stock]" value="{{ $variation->stock }}" 
                                        class="w-full px-4 py-3 rounded-xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 outline-none text-sm font-black text-slate-800 bg-slate-50 focus:bg-white text-center" required min="0">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('variations')
                        <p class="text-rose-500 text-xs mt-3 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-10 p-5 md:p-6 bg-slate-50 border border-slate-100 rounded-[2rem]">
                    <label for="image" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Gambar Baru</label>
                    <input type="file" name="image" id="image" accept="image/*" class="w-full rounded-2xl bg-white px-4 py-3 text-sm font-bold text-slate-500 ring-1 ring-slate-200 file:mr-4 file:rounded-xl file:border-0 file:bg-rose-600 file:px-5 file:py-2.5 file:text-sm file:font-bold file:text-white hover:file:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 cursor-pointer">
                    @if($product->image_path)
                        <p class="text-xs text-slate-400 mt-3 font-medium">Gambar saat ini tersimpan di storage. Unggah file baru hanya jika ingin menggantinya.</p>
                    @endif
                    @error('image')
                        <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-4 border-t border-slate-100 pt-8">
                    <button type="submit" class="w-full sm:w-auto bg-slate-900 text-white font-bold px-10 py-4 rounded-2xl hover:bg-rose-600 transition shadow-xl shadow-slate-200 flex-1 text-center">
                        Update Produk
                    </button>
                    <a href="{{ route('products.index') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl font-bold text-slate-500 bg-white border border-slate-200 hover:border-slate-400 hover:text-slate-800 transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>

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
