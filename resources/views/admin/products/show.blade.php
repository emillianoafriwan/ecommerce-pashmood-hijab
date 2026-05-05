<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - SPORT CENTER</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-indigo-600 p-4 text-white shadow-lg">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="{{ route('shop.index') }}" class="font-bold text-xl tracking-wider">SPORT CENTER</a>
            <div class="flex items-center gap-6">
                <a href="{{ route('cart.index') }}" class="font-bold hover:text-indigo-100 transition">🛒 Keranjang</a>
                @auth
                    <div class="flex items-center gap-4 border-l border-indigo-500 pl-6">
                        <span class="text-sm">Halo, {{ auth()->user()->name }}</span>
                        <a href="{{ route('dashboard') }}" class="text-xs bg-indigo-700 px-3 py-1 rounded hover:bg-indigo-800 transition">Profil</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
    
    <div class="max-w-4xl mx-auto py-10 px-4">
        <a href="{{ route('shop.index') }}" class="text-indigo-600 font-bold mb-4 inline-block hover:underline transition">
            &larr; kembali ke Toko
        </a>

        <!-- BAGIAN 1: DETAIL PRODUK -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-10 mb-10">
            <div>
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-2xl shadow-md">
            </div>

            <div>
                <h1 class="text-3xl font-extrabold text-gray-800">{{ $product->name }}</h1>
                <p class="text-2xl font-bold text-indigo-600 mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-gray-500 mt-4 leading-relaxed">{{ $product->description ?? 'Lightspeed Reborn Meta XR melanjutkan warisan kecepatan dengan pembaruan modern pada siluet ikonisnya. Dengan upper PU Synthetic Microfiber satu bagian, sepatu ini menawarkan fleksibilitas ringan, kenyamanan luar biasa, dan proses break-in yang mudah untuk langsung siap bermain.' }}</p>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-8">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Warna:</label>
                        <div class="flex flex-wrap gap-3">
                            @forelse($product->variations as $variation)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="variation_id" value="{{ $variation->id }}" class="peer hidden" {{ $variation->stock <= 0 ? 'disabled' : '' }} required>
                                    <div class="px-4 py-2 border-2 border-gray-200 rounded-lg text-sm font-bold peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 transition-all {{ $variation->stock <= 0 ? 'opacity-50 cursor-not-allowed bg-gray-100' : '' }}">
                                        {{ $variation->color }}
                                        <span class="block text-[10px] font-normal text-gray-500">
                                            {{ $variation->stock > 0 ? 'Stok: ' . $variation->stock : 'Habis' }}
                                        </span>
                                    </div>
                                </label>
                            @empty
                                <p class="text-sm text-red-500">Stok variasi belum tersedia.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- KOTAK INPUT JUMLAH PEMBELIAN -->
                    <div class="mb-8">
                        <label for="quantity" class="block text-sm font-bold text-gray-700 mb-3">Jumlah Pembelian:</label>
                        <div class="flex items-center gap-4">
                            <input type="number" name="quantity" id="quantity" value="1" min="1" class="w-24 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-center font-bold text-lg shadow-sm" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        🛒 + Masukkan ke Keranjang
                    </button>
                </form>

                <!-- ========================================== -->
                <!-- TOMBOL TANYA PRODUK VIA WA (UPGRADE LINK PREVIEW) -->
                <!-- ========================================== -->
                @php
                    $waNumber = "6282281112033"; 
                    
                    // Mengambil URL lengkap halaman produk ini
                    $productUrl = route('product.show', $product->id); 
                    
                    // Menyusun pesan dengan menambahkan link produk
                    $waMessage = "Halo Admin SPORT CENTER, saya tertarik dengan produk *" . $product->name . "*.\n\n"
                               . "Link Produk: " . $productUrl . "\n\n"
                               . "Apakah stok ukurannya masih lengkap?";
                               
                    $waLink = "https://wa.me/" . $waNumber . "?text=" . rawurlencode($waMessage);
                @endphp
                
                <div class="mt-4 text-center border-t border-gray-100 pt-5">
                    <p class="text-sm text-gray-500 mb-3 font-medium">Masih ragu atau ingin tanya detail?</p>
                    <a href="{{ $waLink }}" target="_blank" class="w-full bg-white border-2 border-[#25D366] text-[#25D366] py-3.5 rounded-xl font-extrabold hover:bg-[#25D366] hover:text-white transition shadow-sm flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.124.551 4.195 1.597 6.012L.152 24l6.104-1.558c1.76.974 3.742 1.488 5.775 1.488 6.645 0 12.031-5.385 12.031-12.031C24 5.385 18.676 0 12.031 0zm3.834 17.151c-.167.472-.962.91-1.341.97-.379.059-.877.108-2.617-.584-2.127-.845-3.486-3.031-3.593-3.176-.108-.145-.857-1.144-.857-2.181 0-1.037.541-1.548.736-1.761.196-.214.428-.267.57-.267.142 0 .285 0 .408.006.13.007.303-.051.472.355.178.428.608 1.486.662 1.593.053.107.089.232.018.375-.071.143-.107.232-.214.357-.107.125-.226.268-.321.375-.107.125-.226.258-.101.472.125.214.555.916 1.189 1.485.819.734 1.517.962 1.731 1.069.214.107.339.089.464-.054.125-.143.535-.624.678-.838.143-.214.285-.178.481-.107.196.071 1.248.589 1.462.696.214.107.357.16.409.25.054.089.054.517-.113.989z"/>
                        </svg>
                        Tanya Admin via WhatsApp
                    </a>
                </div>

            </div>
        </div>

        <!-- BAGIAN 2: FITUR RATING & ULASAN BARU -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-2xl font-extrabold text-gray-800 mb-6">Ulasan Pembeli</h2>

            <!-- Pesan Sukses / Error -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 font-bold">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                    <ul class="list-disc pl-5 text-sm font-bold">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Tulis Ulasan -->
            @auth
                <form action="{{ route('review.store', $product->id) }}" method="POST" enctype="multipart/form-data" class="mb-10 border-b border-gray-200 pb-10">
                    @csrf
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Tulis Ulasan Anda</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Penilaian Bintang</label>
                        <select name="rating" class="w-full md:w-1/2 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                            <option value="5">⭐⭐⭐⭐⭐ (5/5) Sangat Bagus</option>
                            <option value="4">⭐⭐⭐⭐ (4/5) Bagus</option>
                            <option value="3">⭐⭐⭐ (3/5) Cukup</option>
                            <option value="2">⭐⭐ (2/5) Kurang</option>
                            <option value="1">⭐ (1/5) Sangat Kurang</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Komentar & Pengalaman</label>
                        <textarea name="comment" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Bagaimana kualitas sepatunya? Apakah ukurannya pas?" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Upload Foto / Video (Opsional)</label>
                        <input type="file" name="media" accept="image/*,video/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer border border-gray-200 rounded-lg">
                        <p class="text-xs text-gray-500 mt-2">Format didukung: JPG, PNG, MP4. Maksimal ukuran file: 20MB.</p>
                    </div>

                    <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-md">
                        Kirim Ulasan
                    </button>
                </form>
            @else
                <!-- Jika belum login -->
                <div class="bg-gray-50 p-6 rounded-xl mb-10 border border-gray-200 text-center">
                    <p class="text-gray-600 font-medium">Ingin memberikan ulasan untuk produk ini?</p>
                    <a href="{{ route('login') }}" class="mt-3 inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700 transition">Login Sekarang</a>
                </div>
            @endauth

            <!-- Daftar Ulasan Pembeli Lain -->
            <div class="space-y-6">
                @forelse($product->reviews as $review)
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="font-extrabold text-gray-800">{{ $review->user->name }}</span>
                                <div class="text-yellow-400 text-sm mt-1 tracking-widest">
                                    @for($i = 0; $i < $review->rating; $i++)
                                        ★
                                    @endfor
                                    @for($i = $review->rating; $i < 5; $i++)
                                        <span class="text-gray-300">★</span>
                                    @endfor
                                </div>
                            </div>
                            <span class="text-xs font-bold text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <p class="text-gray-700 mt-3 mb-4 leading-relaxed">{{ $review->comment }}</p>
                        
                        @if($review->media_path)
                            <div class="mt-4">
                                @if($review->media_type == 'image')
                                    <a href="{{ asset('storage/' . $review->media_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $review->media_path) }}" alt="Foto Ulasan" class="h-32 w-32 object-cover rounded-xl border border-gray-200 hover:opacity-80 transition cursor-pointer shadow-sm">
                                    </a>
                                @elseif($review->media_type == 'video')
                                    <video src="{{ asset('storage/' . $review->media_path) }}" controls class="h-48 rounded-xl border border-gray-200 shadow-sm"></video>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-10 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                        <div class="text-4xl mb-3 text-gray-300">⭐</div>
                        <p class="text-lg font-bold text-gray-500">Belum ada ulasan</p>
                        <p class="text-sm text-gray-400 mt-1">Jadilah yang pertama memberikan ulasan untuk produk ini!</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- ========================================== -->
    <!-- FLOATING WHATSAPP BUTTON -->
    <!-- ========================================== -->
    <a href="https://wa.me/6282281112033" 
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