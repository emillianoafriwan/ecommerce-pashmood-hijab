<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pre-Order - PASHMOOD</title>
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
<body class="bg-[#FDFBF9] min-h-screen text-slate-900 pb-20">

    <nav class="glass-nav border-b border-rose-100/50 sticky top-0 z-50 p-4 shadow-sm">
        <div class="max-w-4xl mx-auto flex justify-between items-center px-2">
            <a href="{{ route('cart.index') }}" class="flex items-center gap-2 text-slate-500 font-bold hover:text-rose-600 transition group text-sm">
                <span class="group-hover:-translate-x-1 transition-transform">←</span> <span class="hidden sm:inline">Kembali ke Keranjang</span>
            </a>
            <h1 class="font-extrabold text-xl tracking-tighter text-rose-800">PASHMOOD</h1>
            <div class="w-10 sm:w-40"></div> </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 mt-10">
        
        <div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-rose-50 rounded-bl-full -z-10"></div>

            <div class="mb-10">
                <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mb-5 border border-rose-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Checkout Pre-Order</h2>
                <p class="text-slate-500 mt-2 font-medium text-sm">Lengkapi data pengiriman untuk menyelesaikan pesanan Anda.</p>
            </div>

            <div class="bg-slate-50 p-6 md:p-8 rounded-[2rem] border border-slate-100 mb-10">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Ringkasan Pesanan</h3>
                
                <div class="space-y-4">
                    @php $total = 0; @endphp
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <div class="flex justify-between items-center border-b border-slate-200/60 pb-4 last:border-0 last:pb-0">
                                <div class="flex-1 pr-4">
                                    <h4 class="font-bold text-slate-800 line-clamp-1">{{ $details['name'] ?? 'Nama Produk' }}</h4>
                                    <p class="text-xs font-bold text-slate-400 mt-1">Kuantitas: {{ $details['quantity'] }} pcs</p>
                                </div>
                                <div class="text-right whitespace-nowrap">
                                    <p class="font-extrabold text-slate-800">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="flex justify-between items-center mt-6 pt-6 border-t border-slate-200">
                    <span class="text-[10px] sm:text-xs font-black uppercase tracking-widest text-slate-500">Total Pembayaran</span>
                    <span class="text-2xl sm:text-3xl font-black text-rose-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                
                <div class="mb-10">
                    <h3 class="text-lg font-extrabold text-slate-800 mb-6 flex items-center gap-2">
                        📍 Informasi Pengiriman
                    </h3>

                    <div class="mb-6">
                        <label class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Pilih Alamat Pengiriman</label>
                        <div class="relative">
                            <select id="data_source" class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 outline-none cursor-pointer text-slate-700 font-bold bg-white appearance-none" onchange="autoFillData()">
                                @if(Auth::user()->address && Auth::user()->phone)
                                    <option value="profile">Gunakan Alamat & No HP dari Profil Saya</option>
                                @else
                                    <option value="profile" disabled>Data Profil Kosong (Silakan atur di Pengaturan Profil)</option>
                                @endif
                                <option value="manual" {{ (!Auth::user()->address || !Auth::user()->phone) ? 'selected' : '' }}>Ketik Manual / Kirim ke Alamat Lain</option>
                            </select>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Alamat Lengkap</label>
                            <textarea id="input_address" name="address" rows="3" required
                                      class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-medium placeholder-slate-300 resize-none" 
                                      placeholder="Contoh: Jl. Merdeka No. 45, RT 01/RW 02, Kuantan Singingi..."></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">No. WhatsApp / HP</label>
                            <input type="text" id="input_phone" name="phone" required
                                   class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold placeholder-slate-300" 
                                   placeholder="Contoh: 0812xxxxxx">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-2xl hover:bg-rose-600 transition duration-300 shadow-xl shadow-slate-200/50 flex justify-center items-center gap-2">
                    Lanjutkan Pembayaran
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>
            </form>
        </div>
    </main>

    <script>
        // Mengambil data dari database profil user yang sedang login
        const profileAddress = `{!! addslashes(Auth::user()->address ?? '') !!}`;
        const profilePhone = `{!! addslashes(Auth::user()->phone ?? '') !!}`;

        function autoFillData() {
            const dataSource = document.getElementById('data_source').value;
            const addressInput = document.getElementById('input_address');
            const phoneInput = document.getElementById('input_phone');

            if (dataSource === 'profile') {
                // Isi form dengan data profil dan berikan efek visual (bg-slate-50 menandakan otomatis terisi)
                addressInput.value = profileAddress;
                phoneInput.value = profilePhone;
                addressInput.classList.add('bg-slate-50', 'text-slate-500');
                phoneInput.classList.add('bg-slate-50', 'text-slate-500');
            } else {
                // Kosongkan form agar pembeli bisa mengetik manual
                addressInput.value = '';
                phoneInput.value = '';
                addressInput.classList.remove('bg-slate-50', 'text-slate-500');
                phoneInput.classList.remove('bg-slate-50', 'text-slate-500');
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