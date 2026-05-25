<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - PASHMOOD Pashmina</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#FDFBF9] text-slate-900 min-h-screen flex">

    <!-- BAGIAN KIRI: Gambar Estetik (Sembunyi di Mobile) -->
    <div class="hidden lg:block lg:w-1/2 relative overflow-hidden bg-rose-100">
        <!-- Ganti src dengan gambar banner pashmina Anda -->
        <img src="{{ asset('images/bannerforget.jpg') }}" alt="Koleksi Pashmood" class="absolute inset-0 w-full h-full object-cover">
        
        <!-- Overlay Gradasi Gelap -->
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/30 to-transparent"></div>
        
        <!-- Teks Promosi di atas gambar -->
        <div class="absolute bottom-16 left-16 text-white pr-16">
            <span class="bg-rose-600 text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-4 inline-block shadow-lg shadow-rose-900/30">Keamanan Akun</span>
            <h2 class="text-4xl lg:text-5xl font-black mb-4 leading-tight">Kami Siap<br><span class="text-rose-300">Membantu.</span></h2>
            <p class="text-slate-200 text-lg max-w-md">Akses kembali akun PASHMOOD Anda dengan aman dan cepat untuk melihat status pesanan terbaru.</p>
        </div>
    </div>

    <!-- BAGIAN KANAN: Form Forgot Password -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative">
        
        <!-- Tombol Kembali Kiri Atas (Tampil di Desktop) -->
        <a href="{{ route('login') }}" class="absolute top-8 left-8 flex items-center gap-2 text-slate-400 font-bold hover:text-rose-600 transition group text-sm hidden sm:flex">
            <span class="group-hover:-translate-x-1 transition-transform">←</span> Kembali ke Login
        </a>

        <!-- Card Form -->
        <div class="w-full max-w-md bg-white p-8 sm:p-10 rounded-[2.5rem] shadow-sm border border-rose-50">
            
            <div class="text-center mb-8">
                <!-- Ikon Kunci / Keamanan -->
                <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-5 shadow-sm border border-rose-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1 class="font-extrabold text-2xl tracking-tighter text-slate-800 mb-3">Lupa Password?</h1>
                <p class="text-slate-500 text-sm font-medium leading-relaxed">
                    Jangan khawatir! Masukkan alamat email Anda yang terdaftar, dan kami akan mengirimkan tautan untuk membuat password baru.
                </p>
            </div>

            <!-- Session Status (Notifikasi Jika Link Berhasil Dikirim) -->
            @if (session('status'))
                <div class="mb-6 font-bold text-sm text-emerald-600 bg-emerald-50 p-4 rounded-2xl border border-emerald-100 flex gap-3 items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Input Email -->
                <div class="mb-8">
                    <label for="email" class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-widest">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                           class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-medium bg-slate-50 focus:bg-white placeholder-slate-300"
                           placeholder="Masukkan alamat email Anda">
                    @error('email')
                        <p class="mt-2 text-rose-500 text-xs font-bold flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-2xl hover:bg-rose-600 transition duration-300 shadow-xl shadow-slate-200/50 flex justify-center items-center gap-2">
                    Kirim Link Reset Password
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </button>

                <!-- Tombol Kembali (Tampil hanya di HP) -->
                <div class="mt-6 text-center sm:hidden">
                    <a href="{{ route('login') }}" class="text-sm font-extrabold text-slate-400 hover:text-rose-600 transition">
                        ← Kembali ke Login
                    </a>
                </div>
            </form>
        </div>

    </div>
    <script src="{{ asset('/js/smooth-navigation.js') }}"></script>
</body>
</html>
