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
                    <img id="product-image" src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
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
                    @if(!$product->is_active)
                        <div class="bg-rose-50 border border-rose-200 p-6 rounded-[2rem] text-rose-700 font-bold flex items-center gap-3 shadow-sm">
                            <span class="text-xl">⚠️</span>
                            <span>Produk ini sedang dinonaktifkan dan tidak tersedia untuk dipesan.</span>
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
                                            <input type="radio" name="variation_id" value="{{ $variation->id }}" data-image="{{ $variation->imageUrl() }}" class="peer hidden" {{ $variation->id == $firstAvailableVariationId ? 'checked' : '' }} required>
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
                @endif

                <div class="mt-8 flex items-center gap-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-t border-rose-50 pt-8">
                    <div class="flex items-center gap-2">✨ Premium Material</div>
                    <div class="flex items-center gap-2">🕒 Est. Ready 14 Days</div>
                </div>
            </div>
        </div>

        <!-- BAGIAN 2: ULASAN (Desain Modern) -->
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-2xl font-extrabold text-slate-800">Ulasan <span class="text-rose-500">Komunitas</span></h2>
                <div class="h-px flex-1 bg-rose-100 mx-6 hidden md:block"></div>
                @auth
                    @if($hasBought && !$alreadyReviewed)
                    <button onclick="document.getElementById('review-form').scrollIntoView({behavior: 'smooth'})" class="text-sm font-bold text-rose-600">Tulis Review</button>
                    @endif
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
                        <div class="flex text-xs mb-3">
                            @for($i = 0; $i < 5; $i++)
                                @if($i < $review->rating)
                                    <span class="text-yellow-400">★</span>
                                @else
                                    <span class="text-slate-300">☆</span>
                                @endif
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
                @if($hasBought)
                    @if($alreadyReviewed)
                        @php
                            $myReview = $product->reviews->where('user_id', auth()->id())->first();
                        @endphp
                        <div class="bg-emerald-50 border border-emerald-100 p-8 rounded-[3rem] shadow-sm text-slate-800">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center font-black shadow-md shadow-emerald-100">
                                    ✓
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-emerald-950">Anda Sudah Memberikan Ulasan</h3>
                                    <p class="text-xs text-emerald-700/80">Terima kasih telah membagikan pengalaman Anda!</p>
                                </div>
                            </div>
                            @if($myReview)
                                <div class="bg-white/80 backdrop-blur p-6 rounded-2xl border border-emerald-100/50 mt-4">
                                    <div class="flex justify-between items-center mb-3">
                                        <div class="flex text-xs gap-0.5">
                                            @for($i = 0; $i < 5; $i++)
                                                @if($i < $myReview->rating)
                                                    <span class="text-yellow-400">★</span>
                                                @else
                                                    <span class="text-slate-300">☆</span>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $myReview->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-slate-600 text-sm leading-relaxed mb-4 italic">"{{ $myReview->comment }}"</p>
                                    @if($myReview->media_path)
                                        <div class="rounded-xl overflow-hidden w-20 h-20 border border-emerald-100 shadow-sm">
                                            <img src="{{ asset('storage/' . $myReview->media_path) }}" class="w-full h-full object-cover">
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @else
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
                    @endif
                @endif
            @endauth
        </div>
    </div>

    <!-- FLOATING CHAT WIDGET -->
    @include('partials.chat-widget', ['productId' => $product->id])

    <script>
        (function () {
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

            // JS to handle color variation image swapping
            const productImage = document.getElementById('product-image');
            const colorRadios = document.querySelectorAll('input[name="variation_id"]');

            function updateProductImage() {
                const checkedRadio = document.querySelector('input[name="variation_id"]:checked');
                if (checkedRadio && productImage) {
                    const imageUrl = checkedRadio.getAttribute('data-image');
                    if (imageUrl) {
                        productImage.src = imageUrl;
                    }
                }
            }

            if (colorRadios.length > 0) {
                colorRadios.forEach(radio => {
                    radio.addEventListener('change', updateProductImage);
                });
                // Run on initial load to match the default checked variation
                updateProductImage();
            }
        })();
    </script>
    <script src="{{ asset('/js/smooth-navigation.js') }}"></script>
</body>
</html>
