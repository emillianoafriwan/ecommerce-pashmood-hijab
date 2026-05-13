<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori - Admin PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 min-h-screen flex flex-col items-center justify-center p-6">

    <!-- Top Admin Breadcrumb -->
    <div class="w-full max-w-2xl mb-6 flex justify-between items-center">
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
            <span>Admin Panel</span>
            <span>/</span>
            <span>Kategori</span>
            <span>/</span>
            <span class="text-rose-500">Tambah</span>
        </div>
        <a href="{{ route('categories.index') }}" class="text-sm font-extrabold text-slate-400 hover:text-rose-600 transition flex items-center gap-2">
            ← Kembali
        </a>
    </div>

    <!-- Main Card -->
    <div class="w-full max-w-2xl bg-white p-8 md:p-12 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden">
        
        <!-- Dekorasi Background -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-rose-50 rounded-bl-full -z-10"></div>

        <div class="mb-10">
            <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mb-5 border border-rose-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Tambah Kategori</h1>
            <p class="text-slate-500 mt-2 font-medium text-sm">Kelompokkan varian pashmina Anda agar lebih rapi dan mudah dicari oleh pembeli.</p>
        </div>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf 
            
            <!-- Input Nama Kategori -->
            <div class="mb-6">
                <label for="name" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Nama Kategori</label>
                <input type="text" name="name" id="name" required autofocus
                    class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white placeholder-slate-300" 
                    placeholder="Contoh: Pashmina Plisket, Inner Hijab...">
                @error('name') 
                    <p class="text-rose-500 text-xs mt-2 font-bold flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ $message }}
                    </p> 
                @enderror
            </div>

            <!-- Input Slug URL -->
            <div class="mb-10">
                <label for="slug" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Slug URL</label>
                <div class="relative">
                    <input type="text" name="slug" id="slug" required 
                        class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-500 font-medium bg-slate-100 placeholder-slate-300" 
                        placeholder="contoh: pashmina-plisket">
                    
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-3 font-medium flex items-center gap-1.5">
                    <span class="text-amber-500 text-sm">💡</span> Slug terisi otomatis berdasarkan nama kategori.
                </p>
                @error('slug') 
                    <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Tombol Action -->
            <div class="flex flex-col sm:flex-row items-center gap-4 border-t border-slate-100 pt-8 mt-4">
                <button type="submit" class="w-full sm:w-auto bg-slate-900 text-white font-bold px-10 py-4 rounded-2xl hover:bg-rose-600 transition shadow-xl shadow-slate-200 flex-1 text-center">
                    Simpan Kategori
                </button>
                <a href="{{ route('categories.index') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl font-bold text-slate-500 bg-white border border-slate-200 hover:border-slate-400 hover:text-slate-800 transition text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Script Pembuat Slug Otomatis -->
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