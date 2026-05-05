<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8 font-sans">

    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-sm">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Checkout Pesanan</h2>

        <div class="mb-8">
            <h3 class="font-bold text-gray-700 mb-4">Produk yang dibeli:</h3>
            <div class="space-y-4">
                @php $total = 0; @endphp
                @if(session('cart'))
                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity']; @endphp
                        <div class="flex justify-between items-center border-b pb-3">
                            <span class="text-gray-700">{{ $details['name'] ?? 'Nama Produk' }} <span class="text-gray-400">(x{{ $details['quantity'] }})</span></span>
                            <span class="font-bold text-gray-800">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="flex justify-between items-center mt-4 pt-4 border-t-2 border-gray-100">
                <span class="text-lg font-bold text-indigo-600">Total Pembayaran:</span>
                <span class="text-xl font-bold text-indigo-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            
            <div class="bg-indigo-50 border border-indigo-100 p-6 rounded-xl mb-8">
                <h3 class="font-bold text-indigo-900 mb-4 flex items-center gap-2">
                    <span>📦</span> Informasi Pengiriman
                </h3>

                <div class="mb-5 bg-white p-4 rounded-lg border border-indigo-200 shadow-sm">
                    <label class="block text-sm font-bold text-indigo-800 mb-2">Pilih Alamat Pengiriman</label>
                    <select id="data_source" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 outline-none cursor-pointer" onchange="autoFillData()">
                        @if(Auth::user()->address && Auth::user()->phone)
                            <option value="profile">Gunakan Alamat & No HP dari Profil Saya</option>
                        @else
                            <option value="profile" disabled>Data Profil Kosong (Silakan atur di menu profil)</option>
                        @endif
                        <option value="manual" {{ (!Auth::user()->address || !Auth::user()->phone) ? 'selected' : '' }}>Ketik Manual / Kirim ke Alamat Lain</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea id="input_address" name="address" rows="3" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 outline-none transition-colors" placeholder="Contoh: Jl. Merdeka No. 45, Kuantan Singingi..." required></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">No. WhatsApp/HP</label>
                    <input type="text" id="input_phone" name="phone" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 outline-none transition-colors" placeholder="Contoh: 0812xxxxxx" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition-all shadow-md hover:shadow-lg text-lg">
                Bayar Sekarang
            </button>
        </form>
        
        <div class="text-center mt-6">
            <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-indigo-600 hover:underline text-sm transition">
                &larr; Kembali ke Keranjang
            </a>
        </div>
    </div>

    <script>
        // Mengambil data dari database profil user yang sedang login
        const profileAddress = `{!! addslashes(Auth::user()->address ?? '') !!}`;
        const profilePhone = `{!! addslashes(Auth::user()->phone ?? '') !!}`;

        function autoFillData() {
            const dataSource = document.getElementById('data_source').value;
            const addressInput = document.getElementById('input_address');
            const phoneInput = document.getElementById('input_phone');

            if (dataSource === 'profile') {
                // Isi form dengan data profil dan berikan efek visual (bg-gray-100)
                addressInput.value = profileAddress;
                phoneInput.value = profilePhone;
                addressInput.classList.add('bg-gray-50');
                phoneInput.classList.add('bg-gray-50');
            } else {
                // Kosongkan form agar pembeli bisa mengetik manual
                addressInput.value = '';
                phoneInput.value = '';
                addressInput.classList.remove('bg-gray-50');
                phoneInput.classList.remove('bg-gray-50');
                addressInput.focus(); // Arahkan kursor ke kolom alamat
            }
        }

        // Jalankan fungsi otomatis saat halaman pertama kali dimuat
        window.onload = function() {
            autoFillData();
        };
    </script>
</body>
</html>