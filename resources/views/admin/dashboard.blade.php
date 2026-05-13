<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-[#FDFBF9] text-slate-900 min-h-screen pb-20">

    <!-- Top Navbar -->
    <nav class="glass-nav border-b border-rose-100/50 sticky top-0 z-50 p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-2">
            <h1 class="font-extrabold text-2xl tracking-tighter text-rose-800">PASHMOOD</h1>
            <div class="flex items-center gap-4 sm:gap-6">
                <div class="hidden sm:flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-700 font-bold text-xs">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="text-sm font-bold text-slate-700">{{ auth()->user()->name }}</span>
                </div>
                <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-rose-600 transition">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 mt-4">
        
        <!-- Welcome Section (Premium Card) -->
        <div class="bg-slate-900 rounded-[2.5rem] p-8 md:p-12 relative overflow-hidden mb-12 shadow-2xl shadow-slate-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
            <!-- Dekorasi Glow -->
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-rose-500 rounded-full opacity-20 blur-3xl"></div>
            
            <div class="relative z-10 text-white">
                <p class="text-xs font-bold uppercase tracking-widest text-rose-400 mb-2">Panel Kendali Akun</p>
                <h2 class="text-3xl md:text-4xl font-extrabold mb-3">Selamat Datang, {{ explode(' ', auth()->user()->name)[0] }}!</h2>
                <p class="text-slate-400 text-sm md:text-base max-w-lg leading-relaxed">Kelola pesanan, perbarui profil, dan nikmati pengalaman berbelanja koleksi pashmina eksklusif kami.</p>
            </div>
            <a href="{{ route('shop.index') }}" class="relative z-10 bg-rose-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-rose-500 transition shadow-lg shadow-rose-900/50 flex items-center gap-3 whitespace-nowrap w-full md:w-auto justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                Kunjungi Toko
            </a>
        </div>

        <!-- LOGIKA PEMISAH ADMIN & USER -->
        @if(auth()->user()->role == 'admin') 

            <!-- HANYA TAMPIL UNTUK ADMIN -->
            <div class="mb-14">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></div>
                    <h3 class="text-lg font-extrabold text-slate-800 uppercase tracking-widest">Analitik Toko</h3>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition group">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center mb-4 group-hover:scale-110 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Pendapatan</p>
                        <p class="text-2xl font-black text-slate-800 mt-1">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-amber-200 transition group">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center mb-4 group-hover:scale-110 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">PO Menunggu</p>
                        <p class="text-2xl font-black text-slate-800 mt-1">{{ $pendingOrders ?? 0 }} <span class="text-sm font-bold text-slate-300">Pesanan</span></p>
                    </div>
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition group">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center mb-4 group-hover:scale-110 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">PO Selesai</p>
                        <p class="text-2xl font-black text-slate-800 mt-1">{{ $completedOrders ?? 0 }} <span class="text-sm font-bold text-slate-300">Pesanan</span></p>
                    </div>
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-rose-200 transition group">
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center mb-4 group-hover:scale-110 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg></div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Produk</p>
                        <p class="text-2xl font-black text-slate-800 mt-1">{{ $totalProducts ?? 0 }} <span class="text-sm font-bold text-slate-300">Item</span></p>
                    </div>
                </div>
            </div>

            <div class="mb-14">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-700 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg></div>
                    <h3 class="text-lg font-extrabold text-slate-800 uppercase tracking-widest">Menu Admin</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="{{ route('products.index') }}" class="block bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 hover:border-rose-100 transition duration-300 group">
                        <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg></div>
                        <h4 class="font-extrabold text-slate-800 text-xl mb-2">Kelola Produk</h4>
                        <p class="text-sm text-slate-500 font-medium">Tambah, edit, atau hapus koleksi pashmina.</p>
                    </a>
                    <a href="{{ route('categories.index') }}" class="block bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 hover:border-rose-100 transition duration-300 group">
                        <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg></div>
                        <h4 class="font-extrabold text-slate-800 text-xl mb-2">Kelola Kategori</h4>
                        <p class="text-sm text-slate-500 font-medium">Buat pengelompokan bahan & jenis pashmina.</p>
                    </a>
                    <!-- Card Prioritas (Pesanan Masuk) -->
                    <a href="{{ route('admin.orders') }}" class="block bg-slate-900 p-8 rounded-[2.5rem] shadow-xl border border-slate-800 hover:bg-slate-800 hover:-translate-y-1 transition duration-300 group">
                        <div class="w-14 h-14 bg-white/10 text-white rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg></div>
                        <h4 class="font-extrabold text-white text-xl mb-2">Daftar Pesanan</h4>
                        <p class="text-sm text-slate-400 font-medium">Verifikasi pembayaran dan proses pengiriman PO.</p>
                    </a>
                </div>
            </div>

        @else

            <!-- HANYA TAMPIL UNTUK PEMBELI (USER BIASA) -->
            <div class="mb-14">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg></div>
                    <h3 class="text-lg font-extrabold text-slate-800 uppercase tracking-widest">Menu Pesanan</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a href="{{ route('cart.index') }}" class="block bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 hover:border-rose-100 transition duration-300 group">
                        <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                        <h4 class="font-extrabold text-slate-800 text-xl mb-2">Keranjang PO</h4>
                        <p class="text-sm text-slate-500 font-medium">Lanjutkan belanja dan cek barang di keranjangmu.</p>
                    </a>
                    <a href="{{ route('orders.history') }}" class="block bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 hover:border-rose-100 transition duration-300 group">
                        <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg></div>
                        <h4 class="font-extrabold text-slate-800 text-xl mb-2">Riwayat & Lacak</h4>
                        <p class="text-sm text-slate-500 font-medium">Pantau status pembayaran dan pengiriman pashminamu.</p>
                    </a>
                </div>
            </div>

        @endif

        <!-- Pengaturan Akun (Tampil untuk Admin & User) -->
        <div>
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-700 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                <h3 class="text-lg font-extrabold text-slate-800 uppercase tracking-widest">Pengaturan Akun</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('profile.edit') }}" class="block bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 hover:shadow-md hover:-translate-y-1 hover:border-slate-300 transition duration-300 group">
                    <div class="w-12 h-12 bg-slate-50 text-slate-500 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                    <h4 class="font-extrabold text-slate-800 text-lg mb-1">Informasi Profil</h4>
                    <p class="text-sm text-slate-500 font-medium">Perbarui data diri, nomor HP, dan alamat pengiriman.</p>
                </a>
            </div>
        </div>

    </div>
</body>
</html>