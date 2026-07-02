<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang & Checkout - PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('partials.theme-loader')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        /* Sembunyikan scrollbar untuk tabel horizontal di HP */
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }

        /* PREMIUM ANIMATION & TRANSITIONS */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleUp {
            from {
                opacity: 0;
                transform: scale(0.96);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .animate-scale-up {
            animation: scaleUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }

        /* Button micro-interactions */
        .btn-interact {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-interact:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(225, 29, 72, 0.3);
        }
        .btn-interact:active {
            transform: translateY(0);
        }

        /* Hover lift animation */
        .hover-lift {
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 25px -10px rgba(225, 29, 72, 0.1);
        }
    </style>
</head>
<body class="bg-[#FDFBF9] text-slate-900 min-h-screen pb-20">

    <nav class="glass-nav border-b border-rose-100/50 sticky top-0 z-50 p-4 shadow-sm">
        <div class="max-w-5xl mx-auto flex justify-between items-center px-2">
            <h1 class="font-extrabold text-2xl tracking-tighter text-rose-800">PASHMOOD</h1>
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-500 hover:text-rose-600 transition">Dashboard Saya</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline flex items-center">
                        @csrf
                        <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 transition" title="Keluar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 mt-4 overflow-hidden">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-10 animate-fade-in-up">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-rose-500 shadow-sm border border-rose-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Keranjang & Checkout</h1>
                    <p class="mt-1 text-sm text-slate-500 font-medium">Periksa keranjang belanja Anda dan selesaikan data pengiriman.</p>
                </div>
            </div>
            
            <a href="/" class="inline-flex items-center justify-center px-6 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-600 hover:border-rose-300 hover:text-rose-600 transition w-full sm:w-auto gap-2 btn-interact">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Lanjut Belanja
            </a>
        </div>

        @if(session('cart') && count(session('cart')) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start animate-scale-up delay-200">
                
                <!-- Kolom Kiri: Daftar Produk -->
                <div class="lg:col-span-7 bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="overflow-x-auto hide-scroll">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-widest">
                                    <th class="px-4 py-5 text-center w-12">
                                        <input type="checkbox" id="select-all-checkbox" class="w-5 h-5 text-rose-600 border-slate-300 rounded focus:ring-rose-500 cursor-pointer" checked title="Pilih/Batalkan Semua">
                                    </th>
                                    <th class="px-4 py-5">Produk Pashmina</th>
                                    <th class="px-4 py-5 text-right">Harga</th>
                                    <th class="px-4 py-5 text-center">Qty</th>
                                    <th class="px-4 py-5 text-right">Subtotal</th>
                                    <th class="px-4 py-5 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach(session('cart') as $id => $details)
                                <tr class="hover:bg-slate-50/50 transition-colors duration-300 group">
                                    <td class="px-4 py-6 text-center">
                                        <input type="checkbox" value="{{ $id }}" class="item-checkbox w-5 h-5 text-rose-600 border-slate-300 rounded focus:ring-rose-500 cursor-pointer" checked data-price="{{ $details['price'] }}" data-quantity="{{ $details['quantity'] }}">
                                    </td>
                                    <td class="px-4 py-6 flex items-center gap-3">
                                        @php
                                            $cartImage = $details['image'] ?? '';
                                            $cartImageUrl = \Illuminate\Support\Str::startsWith($cartImage, ['http://', 'https://'])
                                                ? $cartImage
                                                : (\Illuminate\Support\Str::startsWith($cartImage, 'images/') ? asset($cartImage) : asset('storage/' . $cartImage));
                                        @endphp
                                        <div class="w-16 h-16 rounded-xl bg-slate-50 border border-slate-100 overflow-hidden shrink-0">
                                            <img src="{{ $cartImageUrl }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                        </div>
                                        <span class="font-extrabold text-slate-800 text-sm group-hover:text-rose-600 transition">{{ $details['name'] }}</span>
                                    </td>
                                    <td class="px-4 py-6 text-sm font-bold text-slate-500 text-right whitespace-nowrap">
                                        Rp {{ number_format($details['price'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-6 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-slate-100 rounded-lg text-xs font-black text-slate-800">
                                            {{ $details['quantity'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-6 text-right text-sm font-black text-rose-600 whitespace-nowrap">
                                        Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-6 text-center">
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Produk">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="p-6 md:p-8 bg-slate-50 border-t border-slate-100">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs font-bold text-slate-400">Pashmina impian Anda sudah di depan mata!</p>
                                <p class="text-sm font-medium text-slate-500 mt-1">Lengkapi form di sebelah kanan untuk melanjutkan.</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Terpilih</p>
                                <p class="text-2xl sm:text-3xl font-black text-rose-600" id="total-price-display">Rp 0</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Form Pengiriman -->
                <div class="lg:col-span-5 bg-white p-6 md:p-8 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-rose-50 rounded-bl-full -z-10"></div>
                    
                    <h3 class="text-lg font-extrabold text-slate-800 mb-6 flex items-center gap-2">
                        📍 Informasi Pengiriman
                    </h3>

                    <form action="{{ route('checkout.store') }}" id="checkout-form" method="POST">
                        @csrf
                        
                        {{-- Pilih Sumber Alamat --}}
                        <div class="mb-5">
                            <label class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-widest">Pilih Alamat Pengiriman</label>
                            <div class="relative">
                                <select id="data_source" class="w-full px-4 py-3.5 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 outline-none cursor-pointer text-slate-700 font-bold bg-white appearance-none text-sm" onchange="autoFillData()">
                                    @if(Auth::user()->detail_address && Auth::user()->province)
                                        <option value="profile">Gunakan Alamat dari Profil Saya</option>
                                    @else
                                        <option value="profile" disabled>Data Profil Alamat Kosong (Silakan atur di Pengaturan Profil)</option>
                                    @endif
                                    <option value="manual" {{ (!Auth::user()->detail_address || !Auth::user()->province) ? 'selected' : '' }}>Ketik Manual / Kirim ke Alamat Lain</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            {{-- Grid Row 1: Provinsi & Kota --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-widest">Provinsi <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <select id="input_province" name="province" required
                                                class="w-full px-4 py-3.5 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-medium placeholder-slate-300 appearance-none bg-white text-sm">
                                            <option value="">-- Pilih Provinsi --</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        </div>
                                    </div>
                                    @error('province')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-widest">Kabupaten / Kota <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <select id="input_city" name="city" required disabled
                                                class="w-full px-4 py-3.5 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-medium appearance-none bg-white disabled:opacity-50 text-sm">
                                            <option value="">-- Pilih Provinsi dulu --</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        </div>
                                    </div>
                                    @error('city')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            {{-- Grid Row 2: Kecamatan & Desa --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-widest">Kecamatan <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <select id="input_district" name="district" required disabled
                                                class="w-full px-4 py-3.5 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-medium appearance-none bg-white disabled:opacity-50 text-sm">
                                            <option value="">-- Pilih Kab/Kota dulu --</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        </div>
                                    </div>
                                    @error('district')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-widest">Desa / Kelurahan <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <select id="input_village" name="village" required disabled
                                                class="w-full px-4 py-3.5 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-medium appearance-none bg-white disabled:opacity-50 text-sm">
                                            <option value="">-- Pilih Kecamatan dulu --</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        </div>
                                    </div>
                                    @error('village')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            {{-- Alamat Detail (Full Width) --}}
                            <div>
                                <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-widest">Alamat Detail <span class="text-rose-500">*</span></label>
                                <textarea id="input_detail_address" name="detail_address" rows="2" required
                                          class="w-full px-4 py-3.5 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-medium placeholder-slate-300 resize-none text-sm"
                                          placeholder="Contoh: Jl. Merdeka No. 45, RT 01/RW 02...">{{ old('detail_address') }}</textarea>
                                @error('detail_address')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Grid Row 3: No. WhatsApp & Kurir --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-widest">No. WhatsApp / HP <span class="text-rose-500">*</span></label>
                                    <input type="text" id="input_phone" name="phone" required
                                           value="{{ old('phone') }}"
                                           class="w-full px-4 py-3.5 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold placeholder-slate-300 text-sm"
                                           placeholder="Contoh: 0812xxxxxx">
                                    @error('phone')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-widest">Pilih Jasa Pengiriman <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <select name="courier" required class="w-full px-4 py-3.5 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 outline-none cursor-pointer text-slate-700 font-bold bg-white appearance-none text-sm">
                                            <option value="" disabled {{ old('courier') ? '' : 'selected' }}>Pilih kurir</option>
                                            <option value="JNE Express" {{ old('courier') == 'JNE Express' ? 'selected' : '' }}>JNE Express</option>
                                            <option value="J&T Express" {{ old('courier') == 'J&T Express' ? 'selected' : '' }}>J&T Express</option>
                                            <option value="Sicepat" {{ old('courier') == 'Sicepat' ? 'selected' : '' }}>Sicepat</option>
                                            <option value="Anteraja" {{ old('courier') == 'Anteraja' ? 'selected' : '' }}>Anteraja</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                        </div>
                                    </div>
                                    @error('courier')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="checkout-btn" class="w-full mt-6 bg-[#0F172A] text-white font-bold py-4 rounded-2xl hover:bg-rose-600 transition duration-300 shadow-xl shadow-slate-200/50 flex justify-center items-center gap-2 btn-interact group">
                            Lanjutkan Pembayaran
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:translate-x-1 transition duration-300" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="text-center py-24 bg-white rounded-[3rem] shadow-sm border border-slate-100 animate-scale-up">
                <div class="w-24 h-24 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-rose-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-rose-300 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <h3 class="text-2xl font-extrabold text-slate-800 mb-2">Keranjang Masih Kosong</h3>
                <p class="text-slate-500 font-medium mb-8 max-w-sm mx-auto">Anda belum memilih pashmina apapun. Yuk, temukan warna favoritmu dan amankan slotnya sekarang!</p>
                <a href="/" class="inline-block bg-slate-900 text-white px-8 py-4 rounded-2xl font-bold hover:bg-rose-600 transition shadow-lg shadow-slate-200 btn-interact">
                    Mulai Belanja
                </a>
            </div>
        @endif

    </main>

    <script>
        (() => {
            const WILAYAH_BASE = '{{ url('') }}';

            const PROV_URL  = `${WILAYAH_BASE}/api/wilayah/provinsi`;
            const KOTA_URL  = (id) => `${WILAYAH_BASE}/api/wilayah/kota/${id}`;
            const KEC_URL   = (id) => `${WILAYAH_BASE}/api/wilayah/kecamatan/${id}`;
            const DESA_URL  = (id) => `${WILAYAH_BASE}/api/wilayah/desa/${id}`;

            // Data profil user (kode wilayah untuk auto-fill)
            const profileProvCode  = `{!! addslashes(Auth::user()->province_code  ?? '') !!}`;
            const profileProvName  = `{!! addslashes(Auth::user()->province       ?? '') !!}`;
            const profileCityCode  = `{!! addslashes(Auth::user()->city_code      ?? '') !!}`;
            const profileCityName  = `{!! addslashes(Auth::user()->city           ?? '') !!}`;
            const profileDistCode  = `{!! addslashes(Auth::user()->district_code  ?? '') !!}`;
            const profileDistName  = `{!! addslashes(Auth::user()->district       ?? '') !!}`;
            const profileVillCode  = `{!! addslashes(Auth::user()->village_code   ?? '') !!}`;
            const profileVillName  = `{!! addslashes(Auth::user()->village        ?? '') !!}`;
            const profileDetailAddr = `{!! addslashes(Auth::user()->detail_address ?? '') !!}`;
            const profilePhone     = `{!! addslashes(Auth::user()->phone          ?? '') !!}`;

            const selProvince = document.getElementById('input_province');
            const selCity     = document.getElementById('input_city');
            const selDistrict = document.getElementById('input_district');
            const selVillage  = document.getElementById('input_village');

            function populateSelect(sel, items, valueKey, nameKey, placeholder, selectedCode, selectedName) {
                if (!sel) return '';
                sel.innerHTML = `<option value="">${placeholder}</option>`;
                let selectedOpt = null;
                items.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item[nameKey];
                    opt.dataset.code = item[valueKey];
                    opt.textContent = item[nameKey];
                    if (selectedCode && String(item[valueKey]) === String(selectedCode)) {
                        opt.selected = true;
                        selectedOpt = opt;
                    } else if (!selectedCode && selectedName && item[nameKey].toUpperCase() === selectedName.toUpperCase()) {
                        opt.selected = true;
                        selectedOpt = opt;
                    }
                    sel.appendChild(opt);
                });
                sel.disabled = false;
                return selectedOpt ? selectedOpt.dataset.code : '';
            }

            function getCode(sel) {
                if (!sel) return '';
                const opt = sel.options[sel.selectedIndex];
                return opt ? (opt.dataset.code || '') : '';
            }

            function resetFrom(level) {
                if (level <= 1 && selCity) {
                    selCity.innerHTML     = '<option value="">-- Pilih Provinsi dulu --</option>';
                    selCity.disabled      = true;
                }
                if (level <= 2 && selDistrict) {
                    selDistrict.innerHTML = '<option value="">-- Pilih Kab/Kota dulu --</option>';
                    selDistrict.disabled  = true;
                }
                if (level <= 3 && selVillage) {
                    selVillage.innerHTML  = '<option value="">-- Pilih Kecamatan dulu --</option>';
                    selVillage.disabled   = true;
                }
            }

            async function loadProvinces(selectedCode = '', selectedName = '') {
                try {
                    const res  = await fetch(PROV_URL);
                    const data = await res.json();
                    return populateSelect(selProvince, data, 'id', 'name', '-- Pilih Provinsi --', selectedCode, selectedName);
                } catch(e) { console.error('Gagal load provinsi', e); }
            }

            async function loadCities(provCode, selectedCode = '', selectedName = '') {
                if (!selCity) return;
                selCity.innerHTML = '<option value="">Memuat...</option>';
                selCity.disabled  = true;
                try {
                    const res  = await fetch(KOTA_URL(provCode));
                    const data = await res.json();
                    return populateSelect(selCity, data, 'id', 'name', '-- Pilih Kabupaten/Kota --', selectedCode, selectedName);
                } catch(e) { console.error('Gagal load kab/kota', e); }
            }

            async function loadDistricts(cityCode, selectedCode = '', selectedName = '') {
                if (!selDistrict) return;
                selDistrict.innerHTML = '<option value="">Memuat...</option>';
                selDistrict.disabled  = true;
                try {
                    const res  = await fetch(KEC_URL(cityCode));
                    const data = await res.json();
                    return populateSelect(selDistrict, data, 'id', 'name', '-- Pilih Kecamatan --', selectedCode, selectedName);
                } catch(e) { console.error('Gagal load kecamatan', e); }
            }

            async function loadVillages(distCode, selectedCode = '', selectedName = '') {
                if (!selVillage) return;
                selVillage.innerHTML = '<option value="">Memuat...</option>';
                selVillage.disabled  = true;
                try {
                    const res  = await fetch(DESA_URL(distCode));
                    const data = await res.json();
                    return populateSelect(selVillage, data, 'id', 'name', '-- Pilih Desa/Kelurahan --', selectedCode, selectedName);
                } catch(e) { console.error('Gagal load desa', e); }
            }

            // Cascade saat user memilih manual
            if (selProvince) {
                selProvince.addEventListener('change', async function() {
                    resetFrom(1);
                    const code = getCode(this);
                    if (code) await loadCities(code);
                });
            }
            if (selCity) {
                selCity.addEventListener('change', async function() {
                    resetFrom(2);
                    const code = getCode(this);
                    if (code) await loadDistricts(code);
                });
            }
            if (selDistrict) {
                selDistrict.addEventListener('change', async function() {
                    resetFrom(3);
                    const code = getCode(this);
                    if (code) await loadVillages(code);
                });
            }

            // ── Auto-fill dari pilihan dropdown sumber alamat ──
            async function autoFillData() {
                const dataSourceEl = document.getElementById('data_source');
                if (!dataSourceEl) return;
                const dataSource = dataSourceEl.value;
                const detailInput = document.getElementById('input_detail_address');
                const phoneInput  = document.getElementById('input_phone');

                const activeProvCode = profileProvCode;
                const activeProvName = profileProvName;

                if (dataSource === 'profile' && (activeProvCode || activeProvName)) {
                    const resolvedProvCode = await loadProvinces(activeProvCode, activeProvName);
                    const provCode = resolvedProvCode || activeProvCode;
                    if (provCode) {
                        const resolvedCityCode = await loadCities(provCode, profileCityCode, profileCityName);
                        const cityCode = resolvedCityCode || profileCityCode;
                        if (cityCode) {
                            const resolvedDistCode = await loadDistricts(cityCode, profileDistCode, profileDistName);
                            const distCode = resolvedDistCode || profileDistCode;
                            if (distCode) {
                                await loadVillages(distCode, profileVillCode, profileVillName);
                            }
                        }
                    }
                    if (detailInput) detailInput.value = profileDetailAddr;
                    if (phoneInput) phoneInput.value  = profilePhone;
                    [selProvince, selCity, selDistrict, selVillage, detailInput, phoneInput].forEach(el => {
                        if (el) el.classList.add('bg-slate-50', 'text-slate-500');
                    });
                } else {
                    await loadProvinces();
                    resetFrom(1);
                    if (detailInput) detailInput.value = '';
                    if (phoneInput) phoneInput.value  = '';
                    [selProvince, selCity, selDistrict, selVillage, detailInput, phoneInput].forEach(el => {
                        if (el) el.classList.remove('bg-slate-50', 'text-slate-500');
                    });
                    if (selProvince) selProvince.focus();
                }
            }

            const initCart = () => {
                const checkboxes = document.querySelectorAll('.item-checkbox');
                const selectAllCheckbox = document.getElementById('select-all-checkbox');
                const totalDisplay = document.getElementById('total-price-display');
                const checkoutBtn = document.getElementById('checkout-btn');
                const checkoutForm = document.getElementById('checkout-form');
                if (!totalDisplay || !checkoutBtn || !checkoutForm) return;

                function formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(number).replace("Rp", "Rp ");
                }

                function updateSummary() {
                    let total = 0;
                    let selectedItems = [];

                    // Hapus input hidden item lama
                    const existingHiddenInputs = checkoutForm.querySelectorAll('.hidden-item-input');
                    existingHiddenInputs.forEach(el => el.remove());

                    checkboxes.forEach(cb => {
                        if (cb.checked) {
                            const price = parseFloat(cb.getAttribute('data-price'));
                            const quantity = parseInt(cb.getAttribute('data-quantity'));
                            total += price * quantity;
                            selectedItems.push(cb.value);

                            // Buat input hidden untuk item terpilih
                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = 'items[]';
                            hiddenInput.value = cb.value;
                            hiddenInput.className = 'hidden-item-input';
                            checkoutForm.appendChild(hiddenInput);
                        }
                    });

                    totalDisplay.textContent = formatRupiah(total);

                    if (selectedItems.length === 0) {
                        checkoutBtn.disabled = true;
                        checkoutBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        checkoutBtn.classList.remove('hover:bg-rose-600');
                        checkoutBtn.style.pointerEvents = 'none';
                    } else {
                        checkoutBtn.disabled = false;
                        checkoutBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        checkoutBtn.classList.add('hover:bg-rose-600');
                        checkoutBtn.style.pointerEvents = 'auto';
                    }
                }

                if (selectAllCheckbox) {
                    selectAllCheckbox.addEventListener('change', function() {
                        const checked = selectAllCheckbox.checked;
                        checkboxes.forEach(cb => {
                            cb.checked = checked;
                        });
                        updateSummary();
                    });
                }

                checkboxes.forEach(cb => {
                    cb.addEventListener('change', function() {
                        if (selectAllCheckbox) {
                            const allChecked = Array.from(checkboxes).every(item => item.checked);
                            const noneChecked = Array.from(checkboxes).every(item => !item.checked);
                            
                            if (allChecked) {
                                selectAllCheckbox.checked = true;
                                selectAllCheckbox.indeterminate = false;
                            } else if (noneChecked) {
                                selectAllCheckbox.checked = false;
                                selectAllCheckbox.indeterminate = false;
                            } else {
                                selectAllCheckbox.checked = false;
                                selectAllCheckbox.indeterminate = true;
                            }
                        }
                        updateSummary();
                    });
                });

                updateSummary();
            };

            // Run immediately
            initCart();
            autoFillData();

            // Run on DOMContentLoaded (for non-AJAX direct page loads)
            document.addEventListener('DOMContentLoaded', () => {
                initCart();
                autoFillData();
            });

            // Expose needed functions to window
            window.autoFillData = autoFillData;
        })();
    </script>
    <script src="{{ asset('/js/smooth-navigation.js') }}"></script>
    @include('partials.theme-customizer')
</body>
</html>
