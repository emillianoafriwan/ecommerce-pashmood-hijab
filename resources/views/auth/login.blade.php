<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - PASHMOOD Pashmina</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#FDFBF9] text-slate-900 min-h-screen flex">

    <!-- BAGIAN KIRI: Gambar Estetik (Sembunyi di Mobile) -->
    <div class="hidden lg:block lg:w-1/2 relative overflow-hidden bg-rose-100">
        <!-- Ganti src di bawah dengan gambar pashmina Anda -->
        <img src="{{ asset('images/bannerlogin.jpg') }}" alt="Koleksi Pashmood" class="absolute inset-0 w-full h-full object-cover">
        
        <!-- Overlay Gradasi Gelap -->
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
        
        <!-- Teks Promosi di atas gambar -->
        <div class="absolute bottom-16 left-16 text-white pr-16">
            <span class="bg-rose-600 text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-4 inline-block shadow-lg shadow-rose-900/30">Premium Collection</span>
            <h2 class="text-4xl lg:text-5xl font-black mb-4 leading-tight">Pancarkan<br><span class="text-rose-300">Pesonamu.</span></h2>
            <p class="text-slate-200 text-lg max-w-md">Masuk ke akun Anda untuk melihat koleksi pre-order terbaru, akses promo eksklusif, dan pantau pesanan dengan mudah.</p>
        </div>
    </div>

    <!-- BAGIAN KANAN: Form Login -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative">
        
        <!-- Tombol Kembali Kiri Atas -->
        <a href="{{ route('shop.index') }}" class="absolute top-8 left-8 flex items-center gap-2 text-slate-400 font-bold hover:text-rose-600 transition group text-sm hidden sm:flex">
            <span class="group-hover:-translate-x-1 transition-transform">←</span> Kembali ke Toko
        </a>

        <!-- Card Form Login -->
        <div class="w-full max-w-md bg-white p-8 sm:p-10 rounded-[2.5rem] shadow-sm border border-rose-50">
            
            <div class="text-center mb-10">
                <h1 class="font-extrabold text-3xl tracking-tighter text-rose-800 mb-2">PASHMOOD</h1>
                <p class="text-slate-500 text-sm font-medium">Selamat datang kembali, Sister!</p>
            </div>

            <!-- Session Status Laravel -->
            @if (session('status'))
                <div class="mb-6 font-bold text-sm text-emerald-600 bg-emerald-50 p-4 rounded-2xl border border-emerald-100 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Input Email -->
                <div class="mb-5">
                    <label for="email" class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-widest">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                           class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-medium bg-slate-50 focus:bg-white placeholder-slate-300"
                           placeholder="">
                    @error('email')
                        <p class="mt-2 text-rose-500 text-xs font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Password -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-xs font-black text-slate-700 uppercase tracking-widest">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-bold text-rose-600 hover:text-rose-700 transition">Lupa Password?</a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password" 
                           class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white placeholder-slate-300"
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-2 text-rose-500 text-xs font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-8">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                        <input id="remember_me" type="checkbox" name="remember" 
                               class="rounded-lg border-slate-300 text-rose-600 shadow-sm focus:ring-rose-500 w-5 h-5 cursor-pointer transition">
                        <span class="ms-3 text-sm text-slate-500 font-medium group-hover:text-slate-800 transition">Ingat Saya</span>
                    </label>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-2xl hover:bg-rose-600 transition duration-300 shadow-xl shadow-slate-200/50 flex justify-center items-center gap-2">
                    Masuk Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Link Daftar -->
                <div class="mt-8 text-center border-t border-slate-100 pt-6">
                    <p class="text-sm text-slate-500 font-medium">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="font-extrabold text-rose-600 hover:text-rose-800 transition ml-1 border-b border-transparent hover:border-rose-800 pb-0.5">Daftar di sini</a>
                    </p>
                </div>
            </form>
        </div>

    </div>
</body>
</html>