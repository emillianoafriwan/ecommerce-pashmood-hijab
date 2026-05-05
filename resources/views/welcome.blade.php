<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPORT CENTER-Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Sembunyikan scrollbar tapi tetap bisa di-scroll */
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-indigo-50 font-sans antialiased">

    <nav class="bg-gradient-to-r from-slate-900 to-indigo-800 p-4 text-white shadow-xl sticky top-0 z-50">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="font-black text-2xl tracking-widest italic text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-300">SPORT CENTER</h1>
            
            <div class="flex items-center gap-6">
                <a href="{{ route('cart.index') }}" class="font-bold flex items-center gap-2 hover:text-indigo-300 transition duration-300">
                    <span class="text-xl">🛒</span> Keranjang
                </a>
                
                @auth
                    <div class="flex items-center gap-4 border-l border-slate-600 pl-6">
                        <span class="text-sm font-medium text-slate-200">Halo, {{ auth()->user()->name }}</span>
                        <a href="{{ route('dashboard') }}" class="text-xs bg-white text-slate-900 px-4 py-1.5 rounded-full font-bold hover:bg-slate-200 transition shadow-sm">Profil</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs text-red-400 hover:text-red-300 font-bold transition">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold bg-white text-indigo-800 px-5 py-2 rounded-full hover:bg-gray-100 transition shadow-md">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="bg-white pb-6 shadow-sm border-b border-gray-100 relative z-40">
        <div class="max-w-6xl mx-auto px-4 pt-6">
            <form action="{{ route('shop.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 bg-slate-50 p-2 rounded-2xl md:rounded-full border border-gray-200 shadow-inner">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari sepatu, raket, atau perlengkapan lainnya..." 
                       class="w-full md:flex-1 px-6 py-3 bg-transparent focus:outline-none text-gray-700 placeholder-gray-400 font-medium">
                
                <div class="w-px bg-gray-300 hidden md:block my-2"></div>
                
                <select name="category" class="px-4 py-3 bg-transparent focus:outline-none text-gray-600 font-medium cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl md:rounded-full font-bold hover:bg-indigo-700 hover:shadow-lg transition duration-300">
                    Cari
                </button>

                @if(request('search') || request('category'))
                    <a href="{{ route('shop.index') }}" class="bg-gray-200 text-gray-600 px-6 py-3 rounded-xl md:rounded-full font-bold hover:bg-gray-300 transition flex justify-center items-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 pb-12 mt-8">
        
        <div class="mb-10">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-black text-slate-800 border-l-4 border-indigo-600 pl-3 uppercase tracking-wider">Rekomendasi Pilihan</h2>
            </div>

            <div class="flex overflow-x-auto gap-5 pb-6 hide-scroll snap-x">
                @foreach($products->take(5) as $product)
                    <a href="{{ route('product.show', $product->id) }}" class="group min-w-[200px] w-[200px] bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 relative snap-start block overflow-hidden border border-gray-100">
                        <div class="overflow-hidden">
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">
                        </div>
                        <div class="p-4 bg-white relative z-10">
                            <h3 class="text-sm font-semibold text-gray-700 line-clamp-2 leading-snug mb-2 group-hover:text-indigo-600 transition">{{ $product->name }}</h3>
                            <p class="text-lg text-slate-900 font-black">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mb-10 grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="#" class="block overflow-hidden rounded-2xl shadow-md group">
                <img src="{{ asset('images/banner6.webp') }}" alt="Banner Promo" class="w-full h-auto object-cover group-hover:scale-105 transition duration-500">
            </a>
            <a href="#" class="block overflow-hidden rounded-2xl shadow-md group">
                <img src="{{ asset('images/banner5.jpg') }}" alt="Banner Event" class="w-full h-auto object-cover group-hover:scale-105 transition duration-500">
            </a>
        </div>

        <div class="bg-white p-6 shadow-sm rounded-3xl border border-gray-100">
            <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                <h2 class="text-lg font-black text-slate-800 border-l-4 border-indigo-600 pl-3 uppercase tracking-wider">Katalog Produk</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @forelse($products as $product)
                    <a href="{{ route('product.show', $product->id) }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 relative block overflow-hidden border border-gray-100">
                        <div class="overflow-hidden">
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">
                        </div>
                        <div class="p-4 bg-white relative z-10">
                            <h3 class="text-sm font-semibold text-gray-700 line-clamp-2 leading-snug mb-2 group-hover:text-indigo-600 transition">{{ $product->name }}</h3>
                            <p class="text-lg text-slate-900 font-black">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-16 bg-slate-50 rounded-2xl border-2 border-dashed border-gray-200">
                        <div class="text-4xl mb-3">🛒</div>
                        <p class="text-lg font-bold text-gray-500">Waduh, produk belum tersedia.</p>
                        <p class="text-sm text-gray-400 mt-1">Coba ubah kata kunci pencarian atau kategori.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- ========================================== -->
    <!-- FLOATING WHATSAPP BUTTON -->
    <!-- ========================================== -->
    <!-- Ingat Bos, ganti '6281234567890' dengan nomor WA Admin yang asli -->
    <a href="https://wa.me/6283895426815" 
       target="_blank" 
       class="fixed bottom-6 right-6 bg-[#25D366] text-white p-4 rounded-full shadow-2xl hover:bg-green-600 hover:-translate-y-1 transition-all duration-300 z-50 flex items-center justify-center group border-2 border-white">
        
        <!-- Icon WhatsApp (SVG) -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.124.551 4.195 1.597 6.012L.152 24l6.104-1.558c1.76.974 3.742 1.488 5.775 1.488 6.645 0 12.031-5.385 12.031-12.031C24 5.385 18.676 0 12.031 0zm3.834 17.151c-.167.472-.962.91-1.341.97-.379.059-.877.108-2.617-.584-2.127-.845-3.486-3.031-3.593-3.176-.108-.145-.857-1.144-.857-2.181 0-1.037.541-1.548.736-1.761.196-.214.428-.267.57-.267.142 0 .285 0 .408.006.13.007.303-.051.472.355.178.428.608 1.486.662 1.593.053.107.089.232.018.375-.071.143-.107.232-.214.357-.107.125-.226.268-.321.375-.107.125-.226.258-.101.472.125.214.555.916 1.189 1.485.819.734 1.517.962 1.731 1.069.214.107.339.089.464-.054.125-.143.535-.624.678-.838.143-.214.285-.178.481-.107.196.071 1.248.589 1.462.696.214.107.357.16.409.25.054.089.054.517-.113.989z"/>
        </svg>

        <!-- Teks Muncul Saat Di-hover (Tooltip) -->
        <span class="absolute right-16 bg-white text-gray-800 text-sm font-bold py-2 px-4 rounded-xl shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
            Butuh Bantuan? Chat Kami!
        </span>
    </a>

</body>
</html>