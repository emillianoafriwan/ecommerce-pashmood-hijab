<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Pashmina Eksklusif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        .glass-morphism {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-[#FDFBF9] text-slate-900">

    <!-- NAVIGATION -->
    <nav class="glass-morphism border-b border-rose-100/50 p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-8">
                <h1 class="font-extrabold text-2xl tracking-tighter text-rose-800">PASHMOOD<span class="font-light text-slate-400 text-sm ml-1 tracking-widest uppercase">Pashmina</span></h1>
            </div>
            
            <div class="flex items-center gap-4 md:gap-8">
                <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('products.index') : route('cart.index') }}" class="relative group p-2" title="{{ auth()->check() && auth()->user()->role === 'admin' ? 'Kelola Produk' : 'Keranjang' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-700 group-hover:text-rose-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    @guest
                        <span class="absolute top-0 right-0 bg-rose-500 text-white text-[10px] font-bold px-1.5 rounded-full">3</span>
                    @else
                        @if(auth()->user()->role !== 'admin')
                            <span class="absolute top-0 right-0 bg-rose-500 text-white text-[10px] font-bold px-1.5 rounded-full">3</span>
                        @endif
                    @endguest
                </a>
                
                @auth
                    <div class="hidden md:flex items-center gap-4">
                        <div class="h-8 w-px bg-slate-200"></div>
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                            <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-700 font-bold text-xs group-hover:bg-rose-600 group-hover:text-white transition">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </a>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-rose-600 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-bold bg-rose-600 text-white px-5 py-2.5 rounded-full hover:bg-rose-700 transition shadow-lg shadow-rose-200">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO SEARCH -->
    <section class="bg-gradient-to-b from-rose-50 to-[#FDFBF9] pt-12 pb-20">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6 leading-tight">Temukan Sentuhan <span class="text-rose-600">Kelembutan</span> Sempurna</h2>
            <p class="text-slate-500 mb-10 text-lg">Koleksi Pashmina Pre-Order dengan bahan kualitas premium pilihan.</p>
            
            <form action="{{ route('shop.index') }}" method="GET" class="flex flex-col md:flex-row gap-2 bg-white p-2 rounded-3xl shadow-2xl shadow-rose-100 border border-rose-50">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari warna atau bahan (ex: Silk, Ceruty...)" 
                       class="flex-1 px-6 py-4 rounded-2xl focus:outline-none text-slate-700 font-medium bg-white">
                
                <select name="category" class="hidden md:block px-6 py-4 text-slate-500 font-medium cursor-pointer border-l border-slate-100">
                    <option value="">Semua Bahan</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                
                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-bold hover:bg-rose-600 transition duration-300">
                    Cari Koleksi
                </button>
            </form>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 -mt-10">
        <!-- TRENDING / RECOMMENDED -->
        <div class="mb-16">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="text-rose-600 font-bold tracking-widest text-xs uppercase">Paling Dicari</span>
                    <h3 class="text-2xl font-extrabold text-slate-800">Rekomendasi Minggu Ini</h3>
                </div>
                <div class="flex gap-2">
                    <button class="p-2 border border-slate-200 rounded-full hover:bg-white hover:shadow-md transition">←</button>
                    <button class="p-2 border border-slate-200 rounded-full hover:bg-white hover:shadow-md transition">→</button>
                </div>
            </div>

            <div class="flex overflow-x-auto gap-6 pb-6 hide-scroll snap-x">
                @foreach($products->take(5) as $product)
                <div class="min-w-[280px] md:min-w-[320px] snap-start group">
                    <div class="relative overflow-hidden rounded-[2rem] bg-slate-100 aspect-[3/4] mb-4">
                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter text-rose-600 shadow-sm">Pre-Order</span>
                        </div>
                        <a href="{{ route('product.show', $product->id) }}" class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="bg-white text-slate-900 px-6 py-3 rounded-full font-bold transform translate-y-4 group-hover:translate-y-0 transition duration-300">Lihat Detail</span>
                        </a>
                    </div>
                    <h4 class="font-bold text-slate-800 group-hover:text-rose-600 transition">{{ $product->name }}</h4>
                    <p class="text-slate-500 font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- BANNERS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
            <div class="relative h-64 md:h-80 rounded-[2.5rem] overflow-hidden group cursor-pointer">
                <img src="{{ asset('images/banner1.jpg') }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                <div class="absolute inset-0 bg-gradient-to-r from-rose-900/60 to-transparent flex flex-col justify-center px-10">
                    <h3 class="text-white text-3xl font-black mb-2">Voal Premium</h3>
                    <p class="text-rose-100 mb-6">Tekstur lembut, tegak di dahi.</p>
                    <span class="text-white font-bold border-b-2 border-white w-fit pb-1">Jelajahi →</span>
                </div>
            </div>
            <div class="relative h-64 md:h-80 rounded-[2.5rem] overflow-hidden group cursor-pointer shadow-xl shadow-indigo-100">
                <img src="{{ asset('images/banner2.jpg') }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/60 to-transparent flex flex-col justify-center px-10">
                    <h3 class="text-white text-3xl font-black mb-2">Ceruty Babydoll</h3>
                    <p class="text-slate-100 mb-6">Flowy dan elegan untuk acara formal.</p>
                    <span class="text-white font-bold border-b-2 border-white w-fit pb-1">Jelajahi →</span>
                </div>
            </div>
        </div>

        <!-- MAIN CATALOG -->
        <div class="mb-20">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                <h2 class="text-3xl font-extrabold text-slate-800">Katalog Utama</h2>
                <div class="flex gap-4 overflow-x-auto pb-2 hide-scroll">
                    <button class="bg-slate-900 text-white px-6 py-2 rounded-full text-sm font-bold whitespace-nowrap">Semua</button>
                    <button class="bg-white text-slate-500 border border-slate-200 px-6 py-2 rounded-full text-sm font-bold hover:border-rose-300 whitespace-nowrap transition">Terbaru</button>
                    <button class="bg-white text-slate-500 border border-slate-200 px-6 py-2 rounded-full text-sm font-bold hover:border-rose-300 whitespace-nowrap transition">Best Seller</button>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-10">
                @forelse($products as $product)
                <!-- PERBAIKAN DI SINI: Mengganti <div> menjadi <a> tag -->
                <a href="{{ route('product.show', $product->id) }}" class="group block cursor-pointer">
                    <div class="relative rounded-3xl overflow-hidden bg-rose-50 aspect-[4/5] mb-4">
                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute bottom-4 right-4 bg-white p-3 rounded-2xl shadow-xl opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                    </div>
                    <div class="px-2">
                        <p class="text-rose-500 text-[10px] font-bold uppercase tracking-widest mb-1">{{ $product->category->name ?? 'Pashmina' }}</p>
                        <!-- Tambahan efek hover pada judul agar semakin interaktif -->
                        <h3 class="font-bold text-slate-800 line-clamp-1 mb-1 group-hover:text-rose-600 transition">{{ $product->name }}</h3>
                        <p class="text-slate-900 font-extrabold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-24 bg-white rounded-[3rem] border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-4 text-4xl">✨</div>
                    <h3 class="text-xl font-bold text-slate-800">Koleksi Sedang Disiapkan</h3>
                    <p class="text-slate-400">Nantikan update terbaru dari koleksi kami segera.</p>
                </div>
                @endforelse
            </div>
        </div>
    </main>

    <!-- FOOTER INFO -->
    <footer class="bg-white border-t border-slate-100 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-slate-400 text-sm">© 2026 PASHMOOD Pashmina. Dibuat dengan penuh cinta untuk wanita muslimah.</p>
        </div>
    </footer>

    <!-- FLOATING WHATSAPP -->
    <a href="https://wa.me/6283895426815" target="_blank" 
       class="fixed bottom-8 right-8 z-50 flex items-center gap-3 bg-white text-slate-800 p-2 pr-6 rounded-full shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-slate-50 group hover:-translate-y-1 transition duration-300">
        <div class="w-12 h-12 bg-[#25D366] rounded-full flex items-center justify-center text-white shadow-lg shadow-green-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.124.551 4.195 1.597 6.012L.152 24l6.104-1.558c1.76.974 3.742 1.488 5.775 1.488 6.645 0 12.031-5.385 12.031-12.031C24 5.385 18.676 0 12.031 0zm3.834 17.151c-.167.472-.962.91-1.341.97-.379.059-.877.108-2.617-.584-2.127-.845-3.486-3.031-3.593-3.176-.108-.145-.857-1.144-.857-2.181 0-1.037.541-1.548.736-1.761.196-.214.428-.267.57-.267.142 0 .285 0 .408.006.13.007.303-.051.472.355.178.428.608 1.486.662 1.593.053.107.089.232.018.375-.071.143-.107.232-.214.357-.107.125-.226.268-.321.375-.107.125-.226.258-.101.472.125.214.555.916 1.189 1.485.819.734 1.517.962 1.731 1.069.214.107.339.089.464-.054.125-.143.535-.624.678-.838.143-.214.285-.178.481-.107.196.071 1.248.589 1.462.696.214.107.357.16.409.25.054.089.054.517-.113.989z"/>
            </svg>
        </div>
        <div class="flex flex-col">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Bantuan Chat</span>
            <span class="text-sm font-bold text-slate-700">Hubungi Admin</span>
        </div>
    </a>

</body>
</html>
