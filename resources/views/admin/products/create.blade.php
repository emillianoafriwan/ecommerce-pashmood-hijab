<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Admin PASHMOOD</title>
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
            <span class="text-rose-500">Tambah</span>
        </div>

        <div class="bg-white p-6 md:p-10 rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="mb-10 flex items-start gap-4">
                <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center border border-rose-100 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Tambah Produk Baru</h1>
                    <p class="text-slate-500 mt-2 font-medium text-sm">Masukkan detail produk, harga, kuota stok, dan variasi warna untuk koleksi pre-order.</p>
                </div>
            </div>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf 
                
                <div class="mb-6">
                    <label for="category_id" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Kategori</label>
                    <select name="category_id" id="category_id" required class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-700 font-bold bg-slate-50 focus:bg-white cursor-pointer">
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Nama Produk</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required oninput="generateSlug()"
                            class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white placeholder-slate-300"
                            placeholder="Contoh: Pashmina Voal Dusty Rose">
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
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required 
                            class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-500 font-medium bg-slate-100 placeholder-slate-300"
                            placeholder="pashmina-voal-dusty-rose">
                        @error('slug')
                            <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="price" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Harga (Rp)</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0"
                            class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white">
                        @error('price')
                            <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="stock" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Stok Total</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required min="0"
                            class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white">
                        @error('stock')
                            <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-8 p-5 md:p-6 bg-rose-50/60 border border-rose-100 rounded-[2rem]">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">
                        <div>
                            <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest">Variasi Warna & Stok</h2>
                            <p class="text-xs text-slate-500 font-medium mt-1">Tambahkan stok untuk setiap warna produk.</p>
                        </div>
                        <button type="button" onclick="addRow()" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-slate-900 hover:bg-rose-600 transition gap-2 w-full sm:w-auto">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Warna
                        </button>
                    </div>

                    <div id="variation-container" class="space-y-3">
                        <div class="variation-row grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 bg-white p-4 rounded-2xl border border-rose-100 shadow-sm">
                            <input type="text" name="variations[0][color]" placeholder="Warna" class="w-full px-4 py-3 rounded-xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 outline-none text-sm font-bold text-slate-700 bg-slate-50 focus:bg-white" required>
                            <input type="number" name="variations[0][stock]" placeholder="Stok Warna Ini" min="0" class="w-full px-4 py-3 rounded-xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 outline-none text-sm font-bold text-slate-700 bg-slate-50 focus:bg-white" required>
                            <button type="button" class="h-12 w-12 inline-flex items-center justify-center text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition" onclick="removeRow(this)" title="Hapus Warna">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('variations')
                        <p class="text-rose-500 text-xs mt-3 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-10 p-5 md:p-6 bg-slate-50 border border-slate-100 rounded-[2rem]">
                    <label for="image" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Gambar Produk</label>
                    <input type="file" name="image" id="image" accept="image/*" required class="w-full rounded-2xl bg-white px-4 py-3 text-sm font-bold text-slate-500 ring-1 ring-slate-200 file:mr-4 file:rounded-xl file:border-0 file:bg-rose-600 file:px-5 file:py-2.5 file:text-sm file:font-bold file:text-white hover:file:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 cursor-pointer">
                    @error('image')
                        <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-4 border-t border-slate-100 pt-8">
                    <button type="submit" class="w-full sm:w-auto bg-slate-900 text-white font-bold px-10 py-4 rounded-2xl hover:bg-rose-600 transition shadow-xl shadow-slate-200 flex-1 text-center">
                        Simpan Produk
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
            const nameValue = document.getElementById('name').value;
            const slugOutput = nameValue.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/[\s-]+/g, '-').replace(/^-+|-+$/g, '');
            document.getElementById('slug').value = slugOutput;
        }

        let rowCount = 1;
        function addRow() {
            const container = document.getElementById('variation-container');
            const newRow = document.createElement('div');
            newRow.className = 'variation-row grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 bg-white p-4 rounded-2xl border border-rose-100 shadow-sm';
            newRow.innerHTML = `
                <input type="text" name="variations[${rowCount}][color]" placeholder="Warna" class="w-full px-4 py-3 rounded-xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 outline-none text-sm font-bold text-slate-700 bg-slate-50 focus:bg-white" required>
                <input type="number" name="variations[${rowCount}][stock]" placeholder="Stok Warna Ini" min="0" class="w-full px-4 py-3 rounded-xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 outline-none text-sm font-bold text-slate-700 bg-slate-50 focus:bg-white" required>
                <button type="button" class="h-12 w-12 inline-flex items-center justify-center text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition" onclick="removeRow(this)" title="Hapus Warna">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;
            container.appendChild(newRow);
            rowCount++;
        }

        function removeRow(btn) {
            const rows = document.querySelectorAll('.variation-row');
            if (rows.length > 1) {
                btn.closest('.variation-row').remove();
            }
        }
    </script>
</body>
</html>
