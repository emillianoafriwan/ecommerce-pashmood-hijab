<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - PASHMOOD Pashmina</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('partials.theme-loader')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-morphism {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-[#FDFBF9] text-slate-900">

    <!-- NAVIGATION (Sama dengan Landing Page) -->
    <nav class="glass-morphism border-b border-rose-100/50 p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('shop.index') }}" class="font-extrabold text-2xl tracking-tighter text-rose-800">PASHMOOD<span class="font-light text-slate-400 text-sm ml-1 tracking-widest uppercase">Pashmina</span></a>
            <div class="flex items-center gap-6">
                <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('products.index') : route('cart.index') }}" class="relative group p-2" title="{{ auth()->check() && auth()->user()->role === 'admin' ? 'Kelola Produk' : 'Keranjang' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-700 group-hover:text-rose-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto py-10 px-4">
        <!-- Breadcrumb -->
        <a href="{{ route('shop.index') }}" class="flex items-center gap-2 text-slate-400 font-semibold mb-8 hover:text-rose-600 transition group">
            <span class="group-hover:-translate-x-1 transition-transform">←</span> Kembali ke Koleksi
        </a>

        <!-- BAGIAN 1: DETAIL PRODUK -->
        <div class="bg-white p-6 md:p-10 rounded-[3rem] shadow-sm border border-rose-100/50 grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">
            
            <!-- Gambar Produk -->
            <div class="relative group">
                <div class="aspect-[4/5] overflow-hidden rounded-[2.5rem] bg-rose-50">
                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
                <!-- Badge PO -->
                <div class="absolute top-6 left-6">
                    <span class="bg-rose-600 text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg shadow-rose-200">Pre-Order Only</span>
                </div>
            </div>

            <!-- Info Produk -->
            <div class="flex flex-col">
                <div class="mb-6">
                    <span class="text-rose-500 font-bold tracking-widest text-xs uppercase">{{ $product->category->name ?? 'Koleksi Eksklusif' }}</span>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mt-2">{{ $product->name }}</h1>
                    <div class="flex items-center gap-4 mt-3">
                        <p class="text-3xl font-black text-rose-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <div class="flex text-yellow-400 text-sm">
                            ★ ★ ★ ★ <span class="text-slate-200">★</span>
                            <span class="ml-2 text-slate-400 font-medium">(Ulasan)</span>
                        </div>
                    </div>
                </div>

                <p class="text-slate-500 leading-relaxed mb-8">
                    {{ $product->description ?? 'Pashmina premium dengan material pilihan yang memberikan kenyamanan maksimal. Tekstur lembut, mudah dibentuk, dan memberikan kesan mewah pada penampilan Anda.' }}
                </p>

                @php
                    $firstAvailableVariationId = optional($product->variations->first())->id;
                @endphp

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="bg-slate-50 border border-slate-100 rounded-[2rem] p-6">
                        <p class="text-sm text-slate-500 font-medium mb-5">Akun admin tidak melakukan checkout dari katalog. Gunakan panel produk untuk mengubah detail, harga, gambar, dan variasi.</p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('products.edit', $product->id) }}" class="flex-1 bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-rose-600 transition shadow-xl shadow-rose-100 flex justify-center items-center gap-3">
                                Edit Produk Ini
                            </a>
                            <a href="{{ route('products.index') }}" class="flex-1 bg-white text-slate-700 py-4 rounded-2xl font-bold hover:text-rose-600 transition border border-slate-200 flex justify-center items-center gap-3">
                                Kelola Produk
                            </a>
                        </div>
                    </div>
                @else
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        
                        <!-- Pilih Warna -->
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-slate-700 mb-4 uppercase tracking-wider">Pilih Warna</label>
                            <div class="flex flex-wrap gap-3">
                                @forelse($product->variations as $variation)
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="variation_id" value="{{ $variation->id }}" class="peer hidden" {{ $variation->id == $firstAvailableVariationId ? 'checked' : '' }} required>
                                        <div class="px-5 py-3 border border-slate-200 rounded-2xl text-sm font-bold text-slate-600 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-600 transition-all group-hover:border-rose-200">
                                            {{ $variation->color }}
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-sm text-rose-500">Variasi warna sedang diproses.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Jumlah & CTA -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex items-center bg-slate-100 rounded-2xl p-1 w-fit">
                                <button type="button" id="decreaseQty" class="w-12 h-12 rounded-xl flex items-center justify-center font-black text-slate-600 hover:bg-white transition">-</button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" class="w-16 bg-transparent text-center font-bold text-slate-800 outline-none">
                                <button type="button" id="increaseQty" class="w-12 h-12 rounded-xl flex items-center justify-center font-black text-slate-600 hover:bg-white transition">+</button>
                            </div>
                            
                            <button type="submit" class="flex-1 bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-rose-600 transition shadow-xl shadow-rose-100 flex justify-center items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                Amankan Slot Pre-Order
                            </button>
                        </div>
                    </form>
                @endif

                <div class="mt-8 flex items-center gap-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-t border-rose-50 pt-8">
                    <div class="flex items-center gap-2">✨ Premium Material</div>
                    {{-- <div class="flex items-center gap-2">🕒 Est. Ready 7 Days</div> --}}
                </div>
            </div>
        </div>

        <!-- BAGIAN 2: ULASAN (Desain Modern) -->
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-2xl font-extrabold text-slate-800">Ulasan <span class="text-rose-500">Komunitas</span></h2>
                <div class="h-px flex-1 bg-rose-100 mx-6 hidden md:block"></div>
                @auth
                <button onclick="document.getElementById('review-form').scrollIntoView({behavior: 'smooth'})" class="text-sm font-bold text-rose-600">Tulis Review</button>
                @endauth
            </div>

            <!-- Review Card List -->
            <div class="space-y-6 mb-12">
                @forelse($product->reviews as $review)
                <div class="bg-white p-6 rounded-[2rem] border border-rose-50 shadow-sm flex gap-6">
                    <div class="hidden sm:block">
                        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center font-black">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold text-slate-800">{{ $review->user->name }}</h4>
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-tighter">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex text-yellow-400 text-xs mb-3">
                            @for($i = 0; $i < 5; $i++)
                                <span>{{ $i < $review->rating ? '★' : '☆' }}</span>
                            @endfor
                        </div>
                        <p class="text-slate-500 text-sm leading-relaxed mb-4">{{ $review->comment }}</p>
                        
                        @if($review->media_path)
                            <div class="rounded-2xl overflow-hidden w-24 h-24 border border-rose-50">
                                <img src="{{ asset('storage/' . $review->media_path) }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-16 bg-white rounded-[3rem] border border-dashed border-rose-200">
                    <p class="text-slate-400 font-medium">Belum ada ulasan untuk koleksi ini.</p>
                </div>
                @endforelse
            </div>

            <!-- Form Review -->
            @auth
            <div id="review-form" class="bg-slate-900 rounded-[3rem] p-8 md:p-12 text-white">
                <h3 class="text-2xl font-extrabold mb-2">Bagikan Pengalamanmu</h3>
                <p class="text-slate-400 text-sm mb-8">Ulasanmu sangat berharga bagi pelanggan PASHMOOD lainnya.</p>
                
                <form action="{{ route('review.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">Rating Kamu</label>
                            <select name="rating" class="w-full bg-slate-800 border-none rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-rose-500 outline-none">
                                <option value="5">Sempurna (5/5)</option>
                                <option value="4">Sangat Puas (4/5)</option>
                                <option value="3">Cukup (3/5)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">Foto/Video</label>
                            <input type="file" name="media" class="w-full text-xs text-slate-400 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:bg-rose-600 file:text-white file:font-bold hover:file:bg-rose-700 cursor-pointer">
                        </div>
                    </div>
                    <div class="mb-8">
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">Pesan</label>
                        <textarea name="comment" rows="4" class="w-full bg-slate-800 border-none rounded-[2rem] px-6 py-4 text-white focus:ring-2 focus:ring-rose-500 outline-none" placeholder="Tuliskan pendapatmu tentang produk ini..."></textarea>
                    </div>
                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white px-10 py-4 rounded-2xl font-bold transition shadow-lg shadow-rose-900/20">
                        Kirim Ulasan Sekarang
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </div>

    <!-- WHATSAPP (Sama dengan Landing Page) -->
    <a href="https://wa.me/6282281112033" target="_blank" class="fixed bottom-8 right-8 z-50 flex items-center gap-3 bg-white text-slate-800 p-2 pr-6 rounded-full shadow-2xl border border-rose-50 group hover:-translate-y-1 transition duration-300">
        <div class="w-12 h-12 bg-[#25D366] rounded-full flex items-center justify-center text-white shadow-lg shadow-green-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.124.551 4.195 1.597 6.012L.152 24l6.104-1.558c1.76.974 3.742 1.488 5.775 1.488 6.645 0 12.031-5.385 12.031-12.031C24 5.385 18.676 0 12.031 0zm3.834 17.151c-.167.472-.962.91-1.341.97-.379.059-.877.108-2.617-.584-2.127-.845-3.486-3.031-3.593-3.176-.108-.145-.857-1.144-.857-2.181 0-1.037.541-1.548.736-1.761.196-.214.428-.267.57-.267.142 0 .285 0 .408.006.13.007.303-.051.472.355.178.428.608 1.486.662 1.593.053.107.089.232.018.375-.071.143-.107.232-.214.357-.107.125-.226.268-.321.375-.107.125-.226.258-.101.472.125.214.555.916 1.189 1.485.819.734 1.517.962 1.731 1.069.214.107.339.089.464-.054.125-.143.535-.624.678-.838.143-.214.285-.178.481-.107.196.071 1.248.589 1.462.696.214.107.357.16.409.25.054.089.054.517-.113.989z"/></svg>
        </div>
        <div class="flex flex-col">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Bantuan Chat</span>
            <span class="text-sm font-bold text-slate-700">Tanya Produk</span>
        </div>
    </a>

    <script>
        const quantityInput = document.getElementById('quantity');
        const decreaseQty = document.getElementById('decreaseQty');
        const increaseQty = document.getElementById('increaseQty');

        if (quantityInput) {
            decreaseQty?.addEventListener('click', () => {
                if(Number(quantityInput.value) > 1) quantityInput.value = Number(quantityInput.value) - 1;
            });

            increaseQty?.addEventListener('click', () => {
                quantityInput.value = Number(quantityInput.value) + 1;
            });
        }
    </script>
    <script src="{{ asset('/js/smooth-navigation.js') }}"></script>
</body>
</html>
