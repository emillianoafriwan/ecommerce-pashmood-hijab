<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - Admin PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 min-h-screen pb-20">
    
    <!-- Header Dashboard Admin -->
    <header class="bg-slate-900 text-white py-6 mb-10 shadow-lg">
        <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Admin Panel</p>
                <h1 class="text-2xl font-extrabold tracking-tighter">PASHMOOD</h1>
            </div>
            <a href="/dashboard" class="bg-slate-800 hover:bg-slate-700 text-sm font-bold px-5 py-2.5 rounded-xl transition border border-slate-700 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali ke Dashboard
            </a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6">
        
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-100 p-4 rounded-2xl shadow-sm flex items-start gap-4">
                <div class="bg-emerald-100 text-emerald-500 rounded-full p-1.5 shrink-0">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <h4 class="text-emerald-800 font-bold text-sm">Berhasil!</h4>
                    <p class="text-emerald-600 text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 bg-rose-50 border border-rose-100 p-4 rounded-2xl shadow-sm flex items-start gap-4">
                <div class="bg-rose-100 text-rose-500 rounded-full p-1.5 shrink-0">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div>
                    <h4 class="text-rose-800 font-bold text-sm">Terjadi Kesalahan!</h4>
                    <p class="text-rose-600 text-sm font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Title & Action Button -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-800 shadow-sm border border-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                </div>
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Manajemen Kategori</h2>
                    <p class="mt-1 text-sm text-slate-500 font-medium">Kelola label kategori untuk produk pashmina Anda.</p>
                </div>
            </div>
            
            <a href="{{ route('categories.create') }}" class="inline-flex items-center justify-center px-6 py-3.5 rounded-2xl text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-xl shadow-rose-200 transition gap-2 w-full sm:w-auto">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Kategori
            </a>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-widest">
                            <th class="px-8 py-5">No</th>
                            <th class="px-8 py-5">Nama Kategori</th>
                            <th class="px-8 py-5">Slug URL</th>
                            <th class="px-8 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($categories as $index => $category)
                            <tr class="hover:bg-slate-50/50 transition-colors duration-300 group">
                                <td class="px-8 py-6 text-sm font-bold text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-8 py-6 text-sm font-bold text-slate-800 group-hover:text-rose-600 transition">{{ $category->name }}</td>
                                <td class="px-8 py-6">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                        /{{ $category->slug }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <!-- Edit Button -->
                                        <a href="{{ route('categories.edit', $category->id) }}" class="p-2 text-slate-400 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition" title="Edit Kategori">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        
                                        <!-- Delete Button -->
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition" title="Hapus Kategori" onclick="return confirm('Yakin ingin menghapus kategori ini? Produk yang terkait mungkin akan terpengaruh.')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                        <svg class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Kategori</h4>
                                    <p class="text-sm text-slate-500 font-medium max-w-sm mx-auto">Anda belum menambahkan kategori produk apapun. Klik tombol "Tambah Kategori" untuk memulai.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
    <script src="{{ asset('/js/smooth-navigation.js') }}"></script>
</body>
</html>