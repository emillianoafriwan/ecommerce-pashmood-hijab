<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SPORT CENTER</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Top Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-100 p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="font-bold text-xl text-indigo-600 tracking-wider">SPORT CENTER-Shop</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium text-gray-700">👤 {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <!-- Welcome Section -->
        <div class="flex flex-col md:flex-row justify-between items-center bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-gray-500 mt-2">Ini adalah panel kendali utama akun Anda.</p>
            </div>
            <a href="{{ route('shop.index') }}" class="mt-4 md:mt-0 border border-indigo-200 text-indigo-600 px-6 py-3 rounded-xl font-bold hover:bg-indigo-50 transition flex items-center gap-2">
                🏪 Kunjungi Toko
            </a>
        </div>

        <!-- LOGIKA PEMISAH ADMIN & USER -->
        @if(auth()->user()->role == 'admin') 

            <!-- HANYA TAMPIL UNTUK ADMIN -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-indigo-800 mb-4 flex items-center gap-2">
                    📊 Analitik Toko
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-l-4 border-l-green-500 hover:shadow-md transition">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Total Pendapatan</p>
                        <p class="text-2xl font-black text-gray-800 mt-2">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-l-4 border-l-yellow-500 hover:shadow-md transition">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Pesanan Pending</p>
                        <p class="text-2xl font-black text-gray-800 mt-2">{{ $pendingOrders ?? 0 }} <span class="text-sm font-normal text-gray-400">pesanan</span></p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-l-4 border-l-blue-500 hover:shadow-md transition">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Pesanan Selesai</p>
                        <p class="text-2xl font-black text-gray-800 mt-2">{{ $completedOrders ?? 0 }} <span class="text-sm font-normal text-gray-400">pesanan</span></p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-l-4 border-l-indigo-500 hover:shadow-md transition">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Total Produk</p>
                        <p class="text-2xl font-black text-gray-800 mt-2">{{ $totalProducts ?? 0 }} <span class="text-sm font-normal text-gray-400">item</span></p>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-lg font-bold text-indigo-800 mb-4 flex items-center gap-2">
                    🛠️ Menu Admin Panel
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="{{ route('products.index') }}" class="block bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition transform duration-200">
                        <div class="text-3xl mb-3">📦</div>
                        <h4 class="font-bold text-gray-900 text-lg mb-1">Manajemen Produk</h4>
                        <p class="text-sm text-gray-500">Tambah, edit, atau hapus produk.</p>
                    </a>
                    <a href="{{ route('categories.index') }}" class="block bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition transform duration-200">
                        <div class="text-3xl mb-3">🏷️</div>
                        <h4 class="font-bold text-gray-900 text-lg mb-1">Manajemen Kategori</h4>
                        <p class="text-sm text-gray-500">Kelola kategori produk toko.</p>
                    </a>
                    <a href="{{ route('admin.orders') }}" class="block bg-indigo-600 p-6 rounded-2xl shadow-md border border-indigo-700 hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-1 transition transform duration-200">
                        <div class="text-3xl mb-3">🛒</div>
                        <h4 class="font-bold text-white text-lg mb-1">Daftar Pesanan</h4>
                        <p class="text-indigo-100 text-sm">Verifikasi pembayaran dan kelola pesanan masuk.</p>
                    </a>
                </div>
            </div>

        @else

            <!-- HANYA TAMPIL UNTUK PEMBELI (USER BIASA) -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-indigo-800 mb-4 flex items-center gap-2">
                    🛍️ Menu Pembeli
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a href="{{ route('cart.index') }}" class="block bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition transform duration-200">
                        <div class="text-3xl mb-3">🛒</div>
                        <h4 class="font-bold text-gray-900 text-lg mb-1">Keranjang Saya</h4>
                        <p class="text-sm text-gray-500">Lihat barang yang sudah Anda masukkan keranjang.</p>
                    </a>
                    
                    <!-- PERBAIKAN: Href Pesanan Saya sudah diisi rute orders.history -->
                    <a href="{{ route('orders.index') }}" class="block bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition transform duration-200">
                        <div class="text-3xl mb-3">📦</div>
                        <h4 class="font-bold text-gray-900 text-lg mb-1">Pesanan Saya</h4>
                        <p class="text-sm text-gray-500">Lacak dan lihat status pesanan Anda.</p>
                    </a>
                </div>
            </div>

        @endif

        <!-- Pengaturan Akun (Tampil untuk Admin & User) -->
        <div>
            <h3 class="text-lg font-bold text-indigo-800 mb-4 flex items-center gap-2">
                ⚙️ Pengaturan Akun
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('profile.edit') }}" class="block bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition transform duration-200">
                    <div class="text-3xl mb-3">👤</div>
                    <h4 class="font-bold text-gray-900 text-lg mb-1">Pengaturan Profil</h4>
                    <p class="text-sm text-gray-500">Atur data pribadi dan password Anda.</p>
                </a>
            </div>
        </div>

    </div>
</body>
</html>