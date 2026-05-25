<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Admin PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        .glass-morphism {
            background: rgba(255, 255, 255, 0.84);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-[#FDFBF9] text-slate-900 min-h-screen pb-20">

    <nav class="glass-morphism border-b border-rose-100/50 p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="font-extrabold text-2xl tracking-tighter text-rose-800">
                PASHMOOD<span class="font-light text-slate-400 text-sm ml-1 tracking-widest uppercase">Admin</span>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex items-center justify-center px-5 py-2.5 rounded-full text-sm font-bold text-slate-600 bg-white border border-slate-200 hover:border-rose-300 hover:text-rose-600 transition">
                    Dashboard
                </a>
                <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-full text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 transition shadow-lg shadow-rose-200">
                    Tambah Produk
                </a>
            </div>
        </div>
    </nav>

    <section class="bg-gradient-to-b from-rose-50 to-[#FDFBF9] pt-12 pb-20">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <p class="text-rose-600 font-bold tracking-widest text-xs uppercase mb-4">Kelola Katalog</p>
            <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6 leading-tight">Koleksi Pashmina <span class="text-rose-600">PASHMOOD</span></h1>
            <p class="text-slate-500 mb-10 text-lg">Atur tampilan produk, harga, kategori, dan kuota pre-order dengan nuansa katalog pembeli.</p>

            <form action="{{ route('products.index') }}" method="GET" class="flex flex-col md:flex-row gap-2 bg-white p-2 rounded-3xl shadow-2xl shadow-rose-100 border border-rose-50">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari produk atau deskripsi..."
                       class="flex-1 px-6 py-4 rounded-2xl focus:outline-none text-slate-700 font-medium bg-white">

                <select name="category" class="md:w-56 px-6 py-4 rounded-2xl md:rounded-none text-slate-500 font-medium cursor-pointer md:border-l border-slate-100 bg-white focus:outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>

                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-bold hover:bg-rose-600 transition duration-300">
                    Cari
                </button>
            </form>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 -mt-10">
        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-100 p-4 rounded-2xl shadow-sm flex items-start gap-4">
                <div class="bg-emerald-100 text-emerald-500 rounded-full p-1.5 shrink-0">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
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
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-rose-800 font-bold text-sm">Terjadi Kesalahan!</h4>
                    <p class="text-rose-600 text-sm font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-12">
            <div class="bg-white p-6 rounded-3xl border border-rose-50 shadow-sm">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Total Produk</p>
                <p class="text-3xl font-black text-slate-900">{{ $products->count() }}</p>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-rose-50 shadow-sm">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Total Kuota</p>
                <p class="text-3xl font-black text-slate-900">{{ $products->sum(fn($product) => $product->variations->sum('stock')) }}</p>
            </div>
            <a href="{{ route('products.create') }}" class="bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl hover:bg-slate-800 transition group">
                <p class="text-[10px] font-black uppercase tracking-widest text-rose-300 mb-2">Aksi Cepat</p>
                <p class="text-2xl font-black text-white flex items-center justify-between">
                    Tambah Produk
                    <span class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-rose-600 transition">+</span>
                </p>
            </a>
        </div>

        @if($products->count())
            <div class="mb-16">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                    <div>
                        <span class="text-rose-600 font-bold tracking-widest text-xs uppercase">Preview Admin</span>
                        <h2 class="text-3xl font-extrabold text-slate-800">Katalog Produk</h2>
                    </div>
                    <div class="flex gap-3 overflow-x-auto pb-2 hide-scroll">
                        <a href="{{ route('products.index') }}" class="bg-slate-900 text-white px-6 py-2 rounded-full text-sm font-bold whitespace-nowrap">Semua</a>
                        <a href="{{ route('categories.index') }}" class="bg-white text-slate-500 border border-slate-200 px-6 py-2 rounded-full text-sm font-bold hover:border-rose-300 whitespace-nowrap transition">Kategori</a>
                        <a href="{{ route('shop.index') }}" target="_blank" class="bg-white text-slate-500 border border-slate-200 px-6 py-2 rounded-full text-sm font-bold hover:border-rose-300 whitespace-nowrap transition">Lihat Toko</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-10">
                    @foreach($products as $product)
                        @php
                            $totalStock = $product->variations->sum('stock');
                            $isOutOfStock = $totalStock <= 0;
                        @endphp
                        <article class="group">
                            <div class="relative rounded-3xl overflow-hidden bg-rose-50 aspect-[4/5] mb-4 shadow-sm border border-rose-50">
                                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                                    <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter text-rose-600 shadow-sm">Pre-Order</span>
                                    <span class="{{ $isOutOfStock ? 'bg-rose-600 text-white' : 'bg-slate-900/90 text-white' }} backdrop-blur px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter shadow-sm">
                                        {{ $isOutOfStock ? 'Habis' : $totalStock . ' Kuota' }}
                                    </span>
                                </div>

                                <div class="absolute inset-x-4 bottom-4 flex gap-2 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition duration-300">
                                    <a href="{{ route('products.edit', $product->id) }}" class="flex-1 bg-white text-slate-900 px-4 py-3 rounded-2xl font-bold text-sm text-center shadow-xl hover:text-rose-600 transition">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="shrink-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin hapus produk?')" class="w-12 h-12 bg-white text-rose-500 rounded-2xl font-black shadow-xl hover:bg-rose-600 hover:text-white transition" title="Hapus Produk">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="px-2">
                                <p class="text-rose-500 text-[10px] font-bold uppercase tracking-widest mb-1">{{ $product->category->name ?? 'Pashmina' }}</p>
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <h3 class="font-bold text-slate-800 line-clamp-1 group-hover:text-rose-600 transition">{{ $product->name }}</h3>
                                        <p class="text-slate-900 font-extrabold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </div>
                                    <a href="{{ route('product.show', $product->id) }}" target="_blank" class="shrink-0 w-10 h-10 rounded-2xl bg-white border border-slate-100 text-rose-600 flex items-center justify-center shadow-sm hover:bg-rose-600 hover:text-white transition" title="Preview">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </div>

                                <div class="mt-4 flex gap-2 overflow-x-auto hide-scroll pb-1">
                                    @forelse($product->variations as $variation)
                                        <span class="shrink-0 bg-white border border-slate-100 px-3 py-2 rounded-2xl text-[10px] font-black text-slate-500">
                                            {{ $variation->color }} <span class="text-rose-500">{{ $variation->stock }}</span>
                                        </span>
                                    @empty
                                        <span class="text-xs font-bold text-rose-500">Belum ada variasi</span>
                                    @endforelse
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @else
            <div class="col-span-full text-center py-24 bg-white rounded-[3rem] border border-dashed border-slate-200">
                <div class="w-20 h-20 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-4 text-4xl">+</div>
                <h3 class="text-xl font-bold text-slate-800">Belum Ada Produk</h3>
                <p class="text-slate-400 mb-8">Tambahkan koleksi pertama untuk mulai membuka pre-order.</p>
                <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 transition shadow-lg shadow-rose-200">
                    Tambah Produk Pertama
                </a>
            </div>
        @endif
    </main>
</body>
</html>
