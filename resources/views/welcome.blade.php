<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Pashmina Eksklusif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('partials.theme-loader')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        .glass-morphism {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

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

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(-24px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
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

        .animate-fade-in-right {
            animation: fadeInRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .animate-scale-up {
            animation: scaleUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
        .delay-500 { animation-delay: 500ms; }
        .delay-600 { animation-delay: 600ms; }
        .delay-700 { animation-delay: 700ms; }

        /* Hover lift animation */
        .hover-lift {
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .hover-lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 30px -10px rgba(225, 29, 72, 0.15);
        }
        @if(auth()->check() && auth()->user()->role === 'admin')
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <style>
                /* Crop Modal Styles */
                #crop-modal {
                    display: none;
                    position: fixed; inset: 0; z-index: 9999;
                    background: rgba(15, 23, 42, 0.75);
                    backdrop-filter: blur(6px);
                    align-items: center; justify-content: center;
                }
                #crop-modal.open { display: flex; animation: fadeIn .2s ease; }
                @keyframes fadeIn { from { opacity: 0; transform: scale(.97); } to { opacity: 1; transform: scale(1); } }

                #crop-wrapper {
                    background: #fff;
                    border-radius: 1.25rem;
                    box-shadow: 0 20px 50px rgba(0,0,0,.35);
                    width: min(540px, 95vw);
                    overflow: hidden;
                    display: flex; flex-direction: column;
                }

                #crop-header {
                    background: #0f172a;
                    padding: .75rem 1.15rem;
                    display: flex; align-items: center; justify-content: space-between;
                    color: #fff;
                }
                #crop-header h4 { margin: 0; font-weight: 700; font-size: 14px; }
                #crop-header p { margin: 2px 0 0 0; font-size: 11px; color: #94a3b8; }

                #crop-canvas-area {
                    width: 100%;
                    height: 320px;
                    background: #1e293b;
                    overflow: hidden;
                    position: relative;
                }
                #crop-canvas-area img { display: block; max-width: 100%; }

                #crop-footer {
                    padding: 1rem 1.25rem;
                    background: #f8fafc;
                    border-top: 1px solid #e2e8f0;
                    display: flex; flex-direction: column; gap: 0.75rem;
                }

                .ratio-btn {
                    padding: .4rem .8rem;
                    border-radius: .5rem;
                    font-size: .75rem;
                    font-weight: 700;
                    border: 1.5px solid #e2e8f0;
                    background: #fff;
                    cursor: pointer;
                    transition: all .15s;
                    color: #475569;
                }
                .ratio-btn:hover, .ratio-btn.active {
                    border-color: #4361ee;
                    background: #4361ee;
                    color: #fff;
                }

                #zoom-slider {
                    -webkit-appearance: none;
                    width: 140px; height: 5px;
                    border-radius: 99px;
                    background: #e2e8f0;
                    outline: none; cursor: pointer;
                }
                #zoom-slider::-webkit-slider-thumb {
                    -webkit-appearance: none;
                    width: 18px; height: 18px;
                    border-radius: 50%;
                    background: #4361ee;
                    cursor: pointer;
                }
                
                .crop-controls-row {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 1rem;
                    width: 100%;
                }
                #crop-hint {
                    font-size: 13px;
                    font-weight: 600;
                    margin-top: 8px;
                }
            </style>
        @endif
    </style>
</head>
<body class="bg-[#FDFBF9] text-slate-900">

    <!-- NAVIGATION -->
    <nav class="glass-morphism border-b border-rose-100/50 p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-8">
                <h1 class="font-extrabold text-2xl tracking-tighter text-rose-800">PASHMOOD<span class="font-light text-slate-400 text-sm ml-1 tracking-widest uppercase">Pashmina</span></h1>
            </div>
            
            @php
                $cartCount = count(session('cart', []));
            @endphp
            <div class="flex items-center gap-4 md:gap-8">
                <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('products.index') : route('cart.index') }}" class="relative group p-2" title="{{ auth()->check() && auth()->user()->role === 'admin' ? 'Kelola Produk' : 'Keranjang' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-700 group-hover:text-rose-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    @if($cartCount > 0 && (!auth()->check() || auth()->user()->role !== 'admin'))
                        <span class="absolute top-0 right-0 bg-rose-500 text-white text-[10px] font-bold px-1.5 rounded-full">{{ $cartCount }}</span>
                    @endif
                </a>
                
                @auth
                    <div class="flex items-center gap-2 md:gap-4">
                        <div class="hidden sm:block h-8 w-px bg-slate-200"></div>
                        <div class="relative">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                                <div class="w-8 h-8 rounded-full transition relative flex items-center justify-center">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-8 h-8 rounded-full object-cover border border-rose-100 group-hover:border-rose-600 transition">
                                    @else
                                        <div class="w-full h-full rounded-full bg-rose-100 flex items-center justify-center text-rose-700 font-bold text-xs group-hover:bg-rose-600 group-hover:text-white transition">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                    @if(auth()->user()->role !== 'admin' && !auth()->user()->isProfileComplete())
                                        <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white bg-rose-500 animate-pulse"></span>
                                    @endif
                                </div>
                            </a>

                            @if(auth()->user()->role !== 'admin' && !auth()->user()->isProfileComplete())
                                <div id="profileWarningPopup" class="hidden absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.15)] border border-rose-100 p-4 z-50 animate-fade-in-up">
                                    <div class="absolute -top-2 right-3 w-4 h-4 rotate-45 bg-white border-t border-l border-rose-100"></div>
                                    <div class="relative z-10 flex gap-3">
                                        <div class="w-8 h-8 rounded-full bg-rose-50 flex items-center justify-center text-rose-500 shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 text-left">
                                            <h4 class="text-xs font-extrabold text-slate-800 mb-1">Lengkapi Profil Anda</h4>
                                            <p class="text-[11px] text-slate-500 leading-normal">Silakan lengkapi alamat pengiriman dan nomor telepon Anda untuk kemudahan berbelanja.</p>
                                            <div class="mt-3 flex gap-2">
                                                <a href="{{ route('profile.edit') }}" class="text-[10px] font-bold bg-rose-600 text-white px-3 py-1.5 rounded-full hover:bg-rose-700 transition">
                                                    Lengkapi Sekarang
                                                </a>
                                                <button type="button" id="dismissProfilePopup" class="text-[10px] font-bold text-slate-400 hover:text-slate-600 px-2 py-1.5 transition">
                                                    Nanti
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    (function () {
                                        const popup = document.getElementById('profileWarningPopup');
                                        const dismissBtn = document.getElementById('dismissProfilePopup');
                                        if (popup && !localStorage.getItem('profile_warning_dismissed')) {
                                            setTimeout(() => {
                                                popup.classList.remove('hidden');
                                            }, 800);
                                        }
                                        if (dismissBtn && popup) {
                                            dismissBtn.addEventListener('click', function () {
                                                popup.classList.add('hidden');
                                                localStorage.setItem('profile_warning_dismissed', 'true');
                                            });
                                        }
                                    })();
                                </script>
                            @endif
                        </div>

                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST" class="inline flex items-center">
                            @csrf
                            <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 transition" title="Keluar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-rose-600 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-bold bg-rose-600 text-white px-5 py-2.5 rounded-full hover:bg-rose-700 transition shadow-lg shadow-rose-200">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO SEARCH -->
    <section class="bg-gradient-to-b from-rose-50 to-[#FDFBF9] pt-12 pb-20 overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6 leading-tight animate-fade-in-up">Temukan Sentuhan <span class="text-rose-600">Kelembutan</span> Sempurna</h2>
            <p class="text-slate-500 mb-10 text-lg animate-fade-in-up delay-200">Koleksi Pashmina dengan bahan kualitas premium pilihan.</p>
            
            <form id="heroSearchForm" action="{{ route('shop.index') }}" method="GET" class="flex flex-col md:flex-row gap-2 bg-white p-2 rounded-3xl shadow-2xl shadow-rose-100 border border-rose-50 animate-scale-up delay-300">
                <input id="heroSearchInput" type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search" 
                       class="flex-1 px-6 py-4 rounded-2xl focus:outline-none text-slate-700 font-medium bg-white">
                
                <select id="heroCategorySelect" name="category" class="px-6 py-4 text-slate-500 font-medium cursor-pointer border-t md:border-t-0 md:border-l border-slate-100 bg-white focus:outline-none">
                    <option value="">Semua Bahan</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                
                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-bold hover:bg-rose-600 transition duration-300">
                    Cari Koleksi
                </button>
            </form>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 -mt-10">
        @php
            $bannersAboveRec = $banners->where('placement', 'above_recommendations');
            $bannersBelowRec = $banners->where('placement', 'below_recommendations');
            $bannersBelowCat = $banners->where('placement', 'below_catalog');
        @endphp

        <!-- BANNERS ABOVE RECOMMENDATIONS -->
        @if($bannersAboveRec->isNotEmpty() || (auth()->check() && auth()->user()->role === 'admin' && request('edit_banners') === 'true'))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16 animate-fade-in-up">
                @foreach($bannersAboveRec as $banner)
                    @php
                        $bannerTag  = $banner->link_url ? 'a' : 'div';
                        $widthClass = $banner->width === 'full' ? 'col-span-1 md:col-span-2' : 'col-span-1';
                        $heightClass = [
                            'small'  => 'h-48 md:h-56',
                            'medium' => 'h-64 md:h-80',
                            'large'  => 'h-80 md:h-96',
                        ][$banner->height] ?? 'h-64 md:h-80';
                    @endphp
                    <div class="relative {{ $widthClass }} {{ $heightClass }} rounded-[2.5rem] overflow-hidden group cursor-pointer block hover-lift shadow-xl shadow-rose-100/30">
                        @if($banner->link_url)
                            <a href="{{ $banner->link_url }}" class="absolute inset-0 z-0"></a>
                        @endif
                        <img src="{{ $banner->imageUrl() }}"
                             alt="{{ $banner->title }}"
                             id="banner-img-{{ $banner->id }}"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/60 to-transparent flex flex-col justify-center px-10 pointer-events-none">
                            <h3 class="text-white text-2xl md:text-3xl font-black mb-2 transform group-hover:translate-x-2 transition duration-300">
                                {{ $banner->title }}
                            </h3>
                            @if($banner->subtitle)
                                <p class="text-slate-100 mb-6 transform group-hover:translate-x-2 transition duration-300 delay-75">
                                    {{ $banner->subtitle }}
                                </p>
                            @endif
                            @if($banner->link_url)
                                <span class="text-white font-bold border-b-2 border-white w-fit pb-1 transform group-hover:translate-x-2 transition duration-300 delay-100">
                                    Jelajahi →
                                </span>
                            @endif
                        </div>
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <button type="button" 
                                    class="absolute top-6 right-6 bg-white/90 backdrop-blur hover:bg-white text-slate-800 hover:text-rose-600 p-3 rounded-full shadow-lg z-20 transition duration-200 crop-trigger"
                                    data-id="{{ $banner->id }}"
                                    data-image="{{ $banner->imageUrl() }}"
                                    data-title="{{ $banner->title }}"
                                    title="Crop Gambar Banner Ini">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 11-4.243 4.243 3 3 0 014.243-4.243zm0-5.758a3 3 0 11-4.243-4.243 3 3 0 014.243 4.243z" />
                                </svg>
                            </button>
                        @endif
                    </div>
                @endforeach

                @if(auth()->check() && auth()->user()->role === 'admin' && request('edit_banners') === 'true')
                    <a href="{{ route('admin.banners.create', ['placement' => 'above_recommendations']) }}" 
                       class="relative flex flex-col items-center justify-center border-2 border-dashed border-rose-200 hover:border-rose-500 hover:bg-rose-50/30 rounded-[2.5rem] p-8 text-center transition duration-300 h-64 md:h-80 group col-span-1">
                        <div class="w-12 h-12 rounded-full bg-rose-50 flex items-center justify-center text-rose-500 group-hover:scale-110 group-hover:bg-rose-100 transition duration-300 mb-3 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <span class="text-slate-800 font-extrabold text-sm tracking-tight">Tambah Banner Baru</span>
                        <span class="text-slate-400 text-xs font-semibold mt-1">Posisi: Di atas Rekomendasi</span>
                    </a>
                @endif
            </div>
        @endif

        <!-- TRENDING / RECOMMENDED -->
        <div class="mb-16 animate-fade-in-up delay-400">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="text-rose-600 font-bold tracking-widest text-xs uppercase">Paling Dicari</span>
                    <h3 class="text-2xl font-extrabold text-slate-800">Rekomendasi</h3>
                </div>
                <div class="flex gap-2">
                    <button type="button" data-recommendation-prev aria-label="Geser rekomendasi ke kiri" class="p-2 border border-slate-200 rounded-full hover:bg-white hover:shadow-md transition">&larr;</button>
                    <button type="button" data-recommendation-next aria-label="Geser rekomendasi ke kanan" class="p-2 border border-slate-200 rounded-full hover:bg-white hover:shadow-md transition">&rarr;</button>
                </div>
            </div>

            <div data-recommendation-slider class="flex overflow-x-auto gap-6 pb-6 hide-scroll snap-x scroll-smooth">
                @foreach($products->take(5) as $product)
                <a href="{{ route('product.show', $product->id) }}" class="flex-none w-[220px] sm:w-[240px] md:w-[260px] lg:w-[280px] snap-start group block cursor-pointer hover-lift bg-white p-3 rounded-[2rem] border border-rose-100/30">
                    <div class="relative rounded-3xl overflow-hidden bg-rose-50 aspect-[4/5] mb-4">
                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter text-rose-600 shadow-sm">Pre-Order</span>
                        </div>
                        <div class="absolute bottom-4 right-4 bg-white p-3 rounded-2xl shadow-xl opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition duration-300">
                            <!-- Premium animated hover icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-600 transform group-hover:rotate-90 transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                    </div>
                    <div class="px-2">
                        <p class="text-rose-500 text-[10px] font-bold uppercase tracking-widest mb-1">{{ $product->category->name ?? 'Pashmina' }}</p>
                        <h3 class="font-bold text-slate-800 line-clamp-1 mb-1 group-hover:text-rose-600 transition">{{ $product->name }}</h3>
                        <p class="text-slate-900 font-extrabold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- BANNERS (Dinamis dari database) -->
        @if($banners->isNotEmpty())
            @if($bannersBelowRec->isNotEmpty() || (auth()->check() && auth()->user()->role === 'admin' && request('edit_banners') === 'true'))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20 animate-fade-in-up delay-500">
                    @foreach($bannersBelowRec as $banner)
                        @php
                            $bannerTag  = $banner->link_url ? 'a' : 'div';
                            $widthClass = $banner->width === 'full' ? 'col-span-1 md:col-span-2' : 'col-span-1';
                            $heightClass = [
                                'small'  => 'h-48 md:h-56',
                                'medium' => 'h-64 md:h-80',
                                'large'  => 'h-80 md:h-96',
                            ][$banner->height] ?? 'h-64 md:h-80';
                        @endphp
                        <div class="relative {{ $widthClass }} {{ $heightClass }} rounded-[2.5rem] overflow-hidden group cursor-pointer block hover-lift shadow-xl shadow-rose-100/30">
                            @if($banner->link_url)
                                <a href="{{ $banner->link_url }}" class="absolute inset-0 z-0"></a>
                            @endif
                            <img src="{{ $banner->imageUrl() }}"
                                 alt="{{ $banner->title }}"
                                 id="banner-img-{{ $banner->id }}"
                                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/60 to-transparent flex flex-col justify-center px-10 pointer-events-none">
                                <h3 class="text-white text-2xl md:text-3xl font-black mb-2 transform group-hover:translate-x-2 transition duration-300">
                                    {{ $banner->title }}
                                </h3>
                                @if($banner->subtitle)
                                    <p class="text-slate-100 mb-6 transform group-hover:translate-x-2 transition duration-300 delay-75">
                                        {{ $banner->subtitle }}
                                    </p>
                                @endif
                                @if($banner->link_url)
                                    <span class="text-white font-bold border-b-2 border-white w-fit pb-1 transform group-hover:translate-x-2 transition duration-300 delay-100">
                                        Jelajahi →
                                    </span>
                                @endif
                            </div>
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <button type="button" 
                                        class="absolute top-6 right-6 bg-white/90 backdrop-blur hover:bg-white text-slate-800 hover:text-rose-600 p-3 rounded-full shadow-lg z-20 transition duration-200 crop-trigger"
                                        data-id="{{ $banner->id }}"
                                        data-image="{{ $banner->imageUrl() }}"
                                        data-title="{{ $banner->title }}"
                                        title="Crop Gambar Banner Ini">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 11-4.243 4.243 3 3 0 014.243-4.243zm0-5.758a3 3 0 11-4.243-4.243 3 3 0 014.243 4.243z" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    @endforeach

                    @if(auth()->check() && auth()->user()->role === 'admin' && request('edit_banners') === 'true')
                        <a href="{{ route('admin.banners.create', ['placement' => 'below_recommendations']) }}" 
                           class="relative flex flex-col items-center justify-center border-2 border-dashed border-rose-200 hover:border-rose-500 hover:bg-rose-50/30 rounded-[2.5rem] p-8 text-center transition duration-300 h-64 md:h-80 group col-span-1">
                            <div class="w-12 h-12 rounded-full bg-rose-50 flex items-center justify-center text-rose-500 group-hover:scale-110 group-hover:bg-rose-100 transition duration-300 mb-3 shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <span class="text-slate-800 font-extrabold text-sm tracking-tight">Tambah Banner Baru</span>
                            <span class="text-slate-400 text-xs font-semibold mt-1">Posisi: Di bawah Rekomendasi (Tengah)</span>
                        </a>
                    @endif
                </div>
            @endif
        @else
            {{-- Fallback: banner statis jika belum ada banner di database --}}
            @php
                $voalCategory   = $categories->first(fn ($category) => str_contains(strtolower($category->name), 'voal'));
                $cerutyCategory = $categories->first(fn ($category) => str_contains(strtolower($category->name), 'ceruty'));
                $voalBannerUrl  = route('shop.index', $voalCategory  ? ['category' => $voalCategory->id]  : ['search' => 'Voal Premium']);
                $cerutyBannerUrl= route('shop.index', $cerutyCategory? ['category' => $cerutyCategory->id]: ['search' => 'Ceruty Babydoll']);
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20 animate-fade-in-up delay-500">
                <a href="{{ $voalBannerUrl }}" class="relative h-64 md:h-80 rounded-[2.5rem] overflow-hidden group cursor-pointer block hover-lift">
                    <img src="{{ asset('images/banner1.jpg') }}" alt="Voal Premium" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                    <div class="absolute inset-0 bg-gradient-to-r from-rose-900/60 to-transparent flex flex-col justify-center px-10">
                        <h3 class="text-white text-3xl font-black mb-2 transform group-hover:translate-x-2 transition duration-300">Voal Premium</h3>
                        <p class="text-rose-100 mb-6 transform group-hover:translate-x-2 transition duration-300 delay-75">Tekstur lembut, tegak di dahi.</p>
                        <span class="text-white font-bold border-b-2 border-white w-fit pb-1 transform group-hover:translate-x-2 transition duration-300 delay-100">Jelajahi →</span>
                    </div>
                </a>
                <a href="{{ $cerutyBannerUrl }}" class="relative h-64 md:h-80 rounded-[2.5rem] overflow-hidden group cursor-pointer shadow-xl shadow-rose-100/30 block hover-lift">
                    <img src="{{ asset('images/banner2.jpg') }}" alt="Ceruty Babydoll" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/60 to-transparent flex flex-col justify-center px-10">
                        <h3 class="text-white text-3xl font-black mb-2 transform group-hover:translate-x-2 transition duration-300">Ceruty Babydoll</h3>
                        <p class="text-slate-100 mb-6 transform group-hover:translate-x-2 transition duration-300 delay-75">Flowy dan elegan untuk acara formal.</p>
                        <span class="text-white font-bold border-b-2 border-white w-fit pb-1 transform group-hover:translate-x-2 transition duration-300 delay-100">Jelajahi →</span>
                    </div>
                </a>
                @if(auth()->check() && auth()->user()->role === 'admin' && request('edit_banners') === 'true')
                    <a href="{{ route('admin.banners.create', ['placement' => 'below_recommendations']) }}" 
                       class="relative flex flex-col items-center justify-center border-2 border-dashed border-rose-200 hover:border-rose-500 hover:bg-rose-50/30 rounded-[2.5rem] p-8 text-center transition duration-300 h-64 md:h-80 group col-span-1">
                        <div class="w-12 h-12 rounded-full bg-rose-50 flex items-center justify-center text-rose-500 group-hover:scale-110 group-hover:bg-rose-100 transition duration-300 mb-3 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <span class="text-slate-800 font-extrabold text-sm tracking-tight">Tambah Banner Baru</span>
                        <span class="text-slate-400 text-xs font-semibold mt-1">Posisi: Di bawah Rekomendasi (Tengah)</span>
                    </a>
                @endif
            </div>
        @endif

        <!-- MAIN CATALOG -->
        <div class="mb-20 animate-fade-in-up delay-700">
            @php
                $activeSortClass = 'bg-slate-900 text-white shadow-lg shadow-slate-900/10';
                $inactiveSortClass = 'bg-white text-slate-500 border border-slate-200 hover:border-rose-300 hover:text-rose-600 hover:-translate-y-0.5';
            @endphp
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                <h2 class="text-3xl font-extrabold text-slate-800">Katalog Utama</h2>
                <div class="flex gap-4 overflow-x-auto pb-2 hide-scroll">
                    <button type="button" data-sort-button="all" class="{{ request('sort', 'all') === 'all' ? $activeSortClass : $inactiveSortClass }} px-6 py-2 rounded-full text-sm font-bold whitespace-nowrap transition-all duration-300">Semua</button>
                    <button type="button" data-sort-button="latest" class="{{ request('sort') === 'latest' ? $activeSortClass : $inactiveSortClass }} px-6 py-2 rounded-full text-sm font-bold whitespace-nowrap transition-all duration-300">Terbaru</button>
                    <button type="button" data-sort-button="best_seller" class="{{ request('sort') === 'best_seller' ? $activeSortClass : $inactiveSortClass }} px-6 py-2 rounded-full text-sm font-bold whitespace-nowrap transition-all duration-300">Best Seller</button>
                </div>
            </div>

            <div id="productCatalog" class="grid grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-10">
                @forelse($products as $product)
                <a href="{{ route('product.show', $product->id) }}" class="group block cursor-pointer hover-lift bg-white p-3 rounded-[2rem] border border-rose-100/30" data-product-card data-name="{{ strtolower($product->name) }}" data-created-at="{{ $product->created_at?->timestamp ?? 0 }}" data-sold-count="{{ $product->sold_count ?? 0 }}">
                    <div class="relative rounded-3xl overflow-hidden bg-rose-50 aspect-[4/5] mb-4">
                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute bottom-4 right-4 bg-white p-3 rounded-2xl shadow-xl opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition duration-300">
                            <!-- Premium animated hover icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-600 transform group-hover:rotate-90 transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                    </div>
                    <div class="px-2">
                        <p class="text-rose-500 text-[10px] font-bold uppercase tracking-widest mb-1">{{ $product->category->name ?? 'Pashmina' }}</p>
                        <!-- Tambahan efek hover pada judul agar semakin interaktif -->
                        <h3 class="font-bold text-slate-800 line-clamp-1 mb-1 group-hover:text-rose-600 transition">{{ $product->name }}</h3>
                        <p class="text-slate-900 font-extrabold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-24 bg-white rounded-[3rem] border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-4 text-4xl">✨</div>
                    <h3 class="text-xl font-bold text-slate-800">Koleksi Sedang Disiapkan</h3>
                    <p class="text-slate-400">Nantikan update terbaru dari koleksi kami segera.</p>
                </div>
                @endforelse
        <!-- BANNERS BELOW CATALOG -->
        @if($bannersBelowCat->isNotEmpty() || (auth()->check() && auth()->user()->role === 'admin' && request('edit_banners') === 'true'))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20 animate-fade-in-up">
                @foreach($bannersBelowCat as $banner)
                    @php
                        $bannerTag  = $banner->link_url ? 'a' : 'div';
                        $widthClass = $banner->width === 'full' ? 'col-span-1 md:col-span-2' : 'col-span-1';
                        $heightClass = [
                            'small'  => 'h-48 md:h-56',
                            'medium' => 'h-64 md:h-80',
                            'large'  => 'h-80 md:h-96',
                        ][$banner->height] ?? 'h-64 md:h-80';
                    @endphp
                    <div class="relative {{ $widthClass }} {{ $heightClass }} rounded-[2.5rem] overflow-hidden group cursor-pointer block hover-lift shadow-xl shadow-rose-100/30">
                        @if($banner->link_url)
                            <a href="{{ $banner->link_url }}" class="absolute inset-0 z-0"></a>
                        @endif
                        <img src="{{ $banner->imageUrl() }}"
                             alt="{{ $banner->title }}"
                             id="banner-img-{{ $banner->id }}"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/60 to-transparent flex flex-col justify-center px-10 pointer-events-none">
                            <h3 class="text-white text-2xl md:text-3xl font-black mb-2 transform group-hover:translate-x-2 transition duration-300">
                                {{ $banner->title }}
                            </h3>
                            @if($banner->subtitle)
                                <p class="text-slate-100 mb-6 transform group-hover:translate-x-2 transition duration-300 delay-75">
                                    {{ $banner->subtitle }}
                                </p>
                            @endif
                            @if($banner->link_url)
                                <span class="text-white font-bold border-b-2 border-white w-fit pb-1 transform group-hover:translate-x-2 transition duration-300 delay-100">
                                    Jelajahi →
                                </span>
                            @endif
                        </div>
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <button type="button" 
                                    class="absolute top-6 right-6 bg-white/90 backdrop-blur hover:bg-white text-slate-800 hover:text-rose-600 p-3 rounded-full shadow-lg z-20 transition duration-200 crop-trigger"
                                    data-id="{{ $banner->id }}"
                                    data-image="{{ $banner->imageUrl() }}"
                                    data-title="{{ $banner->title }}"
                                    title="Crop Gambar Banner Ini">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 11-4.243 4.243 3 3 0 014.243-4.243zm0-5.758a3 3 0 11-4.243-4.243 3 3 0 014.243 4.243z" />
                                </svg>
                            </button>
                        @endif
                    </div>
                @endforeach

                @if(auth()->check() && auth()->user()->role === 'admin' && request('edit_banners') === 'true')
                    <a href="{{ route('admin.banners.create', ['placement' => 'below_catalog']) }}" 
                       class="relative flex flex-col items-center justify-center border-2 border-dashed border-rose-200 hover:border-rose-500 hover:bg-rose-50/30 rounded-[2.5rem] p-8 text-center transition duration-300 h-64 md:h-80 group col-span-1">
                        <div class="w-12 h-12 rounded-full bg-rose-50 flex items-center justify-center text-rose-500 group-hover:scale-110 group-hover:bg-rose-100 transition duration-300 mb-3 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <span class="text-slate-800 font-extrabold text-sm tracking-tight">Tambah Banner Baru</span>
                        <span class="text-slate-400 text-xs font-semibold mt-1">Posisi: Di bawah Katalog Utama</span>
                    </a>
                @endif
            </div>
        @endif
    </main>

    <!-- FOOTER INFO -->
    <footer class="bg-white border-t border-slate-100 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-slate-400 text-sm">© 2026 PASHMOOD Pashmina. Dibuat dengan penuh cinta untuk wanita muslimah.</p>
        </div>
    </footer>

    <!-- FLOATING CHAT WIDGET -->
    @include('partials.chat-widget')

    <script>
        (() => {
            const recommendationSlider = document.querySelector('[data-recommendation-slider]');
            const recommendationPrev = document.querySelector('[data-recommendation-prev]');
            const recommendationNext = document.querySelector('[data-recommendation-next]');
            const catalog = document.getElementById('productCatalog');
            const sortButtons = document.querySelectorAll('[data-sort-button]');
            const activeSortClass = ['bg-slate-900', 'text-white'];
            const inactiveSortClass = ['bg-white', 'text-slate-500', 'border', 'border-slate-200', 'hover:border-rose-300'];

            function scrollRecommendations(direction) {
                if (!recommendationSlider) return;

                const firstCard = recommendationSlider.querySelector('.snap-start');
                const gap = parseFloat(getComputedStyle(recommendationSlider).columnGap) || 24;
                const scrollAmount = firstCard ? firstCard.getBoundingClientRect().width + gap : recommendationSlider.clientWidth;

                recommendationSlider.scrollBy({
                    left: direction * scrollAmount,
                    behavior: 'smooth',
                });
            }

            function setActiveSort(activeButton) {
                sortButtons.forEach((button) => {
                    button.classList.remove(...activeSortClass, ...inactiveSortClass);
                    button.classList.add(...(button === activeButton ? activeSortClass : inactiveSortClass));
                });
            }

            function sortCatalog(sortType) {
                if (!catalog) return;

                const cards = Array.from(catalog.querySelectorAll('[data-product-card]'));

                cards.sort((firstCard, secondCard) => {
                    if (sortType === 'latest') {
                        return Number(secondCard.dataset.createdAt) - Number(firstCard.dataset.createdAt);
                    }

                    if (sortType === 'best_seller') {
                        const soldDiff = Number(secondCard.dataset.soldCount) - Number(firstCard.dataset.soldCount);
                        return soldDiff || Number(secondCard.dataset.createdAt) - Number(firstCard.dataset.createdAt);
                    }

                    return firstCard.dataset.name.localeCompare(secondCard.dataset.name);
                });

                cards.forEach((card) => catalog.appendChild(card));
            }

            recommendationPrev?.addEventListener('click', () => scrollRecommendations(-1));
            recommendationNext?.addEventListener('click', () => scrollRecommendations(1));

            const heroSearchForm = document.getElementById('heroSearchForm');
            const heroSearchInput = document.getElementById('heroSearchInput');
            const heroCategorySelect = document.getElementById('heroCategorySelect');

            heroCategorySelect?.addEventListener('change', () => {
                if (!heroSearchInput?.value.trim()) {
                    heroSearchForm?.submit();
                }
            });

            sortButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    setActiveSort(button);
                    sortCatalog(button.dataset.sortButton);
                });
            });
        })();
    </script>

    @if(auth()->check() && auth()->user()->role === 'admin')
        {{-- ══════════════ CROP MODAL ══════════════ --}}
        <div id="crop-modal" role="dialog" aria-modal="true" aria-label="Crop Gambar Banner">
            <div id="crop-wrapper">
                <div id="crop-header">
                    <div style="display:flex; align-items:center; gap:10px">
                        <span style="font-size:1.25rem">✂️</span>
                        <div>
                            <h4 id="crop-title" style="margin:0; font-weight:700; font-size:14px;">Crop Gambar Banner</h4>
                            <p style="margin:2px 0 0 0; font-size:11px; color:#94a3b8;">Potong gambar langsung di halaman utama</p>
                        </div>
                    </div>
                    <button type="button" id="close-crop-modal" style="color:#fff; font-size:1.25rem; background:none; border:none; cursor:pointer;">✕</button>
                </div>

                <div id="crop-canvas-area">
                    <img id="crop-image" src="" alt="">
                </div>

                <div id="crop-footer">
                    <div class="crop-controls-row">
                        <div style="display:flex; gap:6px; flex-wrap:wrap; align-items:center">
                            <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px">Rasio:</span>
                            <button type="button" class="ratio-btn active" data-ratio="1.777">16:9</button>
                            <button type="button" class="ratio-btn" data-ratio="2.333">21:9</button>
                            <button type="button" class="ratio-btn" data-ratio="1.333">4:3</button>
                            <button type="button" class="ratio-btn" data-ratio="NaN">Bebas</button>
                        </div>
                        <div style="display:flex; align-items:center; gap:8px">
                            <button type="button" id="zoom-out-btn" class="ratio-btn" style="padding:4px 8px; font-size:12px">−</button>
                            <input id="zoom-slider" type="range" min="0" max="3" step="0.01" value="0">
                            <button type="button" id="zoom-in-btn" class="ratio-btn" style="padding:4px 8px; font-size:12px">+</button>
                        </div>
                    </div>
                    <div style="display:flex; gap:10px; width:100%">
                        <button type="button" id="reset-crop-btn" class="ratio-btn" style="flex:1; justify-content:center; text-align:center; padding: 10px 0;">Reset</button>
                        <button type="button" id="apply-crop-btn" class="bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-sm font-bold" style="flex:1; justify-content:center; text-align:center; padding: 10px 0; border:none; cursor:pointer; transition:background .2s;">✓ Simpan Potongan</button>
                    </div>
                    <div id="crop-hint" style="text-align:center; font-size:13px; font-weight:600; margin-top:8px;"></div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
        <script>
            (() => {
                let cropperInstance = null;
                let activeBannerId = null;

                const cropModal = document.getElementById('crop-modal');
                const cropImage = document.getElementById('crop-image');
                const cropTitle = document.getElementById('crop-title');
                const zoomSlider = document.getElementById('zoom-slider');
                const zoomInBtn = document.getElementById('zoom-in-btn');
                const zoomOutBtn = document.getElementById('zoom-out-btn');
                const resetBtn = document.getElementById('reset-crop-btn');
                const applyBtn = document.getElementById('apply-crop-btn');
                const closeBtn = document.getElementById('close-crop-modal');
                const cropHint = document.getElementById('crop-hint');

                // Attach click event to all floating scissors buttons
                document.querySelectorAll('.crop-trigger').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        activeBannerId = btn.dataset.id;
                        const originalImageSrc = btn.dataset.image;
                        const bannerTitle = btn.dataset.title;

                        cropTitle.textContent = `Crop Banner: ${bannerTitle}`;
                        openCropModal(originalImageSrc);
                    });
                });

                function openCropModal(imageSrc) {
                    cropModal.classList.add('open');
                    cropHint.textContent = '';
                    
                    if (cropperInstance) {
                        cropperInstance.destroy();
                    }

                    // Preload image to avoid cropper canvas loading issue
                    cropImage.onload = function () {
                        cropperInstance = new Cropper(cropImage, {
                            aspectRatio: 16/9,
                            viewMode: 1,
                            autoCropArea: 0.9,
                            movable: true,
                            zoomable: true,
                            guides: true,
                            ready() {
                                zoomSlider.value = 0;
                            },
                            zoom(e) {
                                zoomSlider.value = Math.max(0, Math.min(3, e.detail.ratio));
                            }
                        });
                        cropImage.onload = null;
                    };
                    cropImage.src = imageSrc;
                }

                function closeCropModal() {
                    cropModal.classList.remove('open');
                    if (cropperInstance) {
                        cropperInstance.destroy();
                        cropperInstance = null;
                    }
                }

                closeBtn?.addEventListener('click', closeCropModal);
                cropModal?.addEventListener('click', (e) => {
                    if (e.target === cropModal) closeCropModal();
                });

                // Ratio buttons switching
                document.querySelectorAll('.ratio-btn[data-ratio]').forEach(btn => {
                    btn.addEventListener('click', () => {
                        if (!cropperInstance) return;
                        document.querySelectorAll('.ratio-btn[data-ratio]').forEach(b => b.classList.remove('active'));
                        btn.classList.add('active');
                        
                        const ratio = btn.dataset.ratio === 'NaN' ? NaN : parseFloat(btn.dataset.ratio);
                        cropperInstance.setAspectRatio(ratio);
                    });
                });

                zoomSlider?.addEventListener('input', function () {
                    if (cropperInstance) {
                        cropperInstance.zoomTo(parseFloat(this.value));
                    }
                });

                zoomInBtn?.addEventListener('click', () => {
                    if (cropperInstance) cropperInstance.zoom(0.1);
                });

                zoomOutBtn?.addEventListener('click', () => {
                    if (cropperInstance) cropperInstance.zoom(-0.1);
                });

                resetBtn?.addEventListener('click', () => {
                    if (cropperInstance) cropperInstance.reset();
                });

                applyBtn?.addEventListener('click', () => {
                    if (!cropperInstance || !activeBannerId) return;

                    cropHint.textContent = 'Memproses potongan...';
                    cropHint.style.color = '#4361ee';

                    const canvas = cropperInstance.getCroppedCanvas({
                        maxWidth: 2400,
                        maxHeight: 1200,
                        imageSmoothingEnabled: true,
                        imageSmoothingQuality: 'high'
                    });

                    if (!canvas) {
                        cropHint.textContent = 'Gagal memproses gambar.';
                        cropHint.style.color = '#ef233c';
                        return;
                    }

                    canvas.toBlob(function (blob) {
                        if (!blob) {
                            cropHint.textContent = 'Gagal memproses file potongan.';
                            cropHint.style.color = '#ef233c';
                            return;
                        }

                        // Create form data and send AJAX request
                        const formData = new FormData();
                        formData.append('image', blob, 'banner-cropped.jpg');
                        
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        fetch(`/admin/banners/${activeBannerId}/crop-ajax`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Instantly update the banner image on the homepage
                                const imgElement = document.getElementById(`banner-img-${activeBannerId}`);
                                if (imgElement) {
                                    // Append a random query string to break cache and force redraw
                                    imgElement.src = `${data.imageUrl}?t=${new Date().getTime()}`;
                                }
                                closeCropModal();
                            } else {
                                cropHint.textContent = data.message || 'Gagal menyimpan potongan.';
                                cropHint.style.color = '#ef233c';
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            cropHint.textContent = 'Terjadi kesalahan saat menghubungi server.';
                            cropHint.style.color = '#ef233c';
                        });
                    }, 'image/jpeg', 0.9);
                });
            })();
        </script>
    @endif

    <script src="{{ asset('/js/smooth-navigation.js') }}"></script>
    @include('partials.theme-customizer')
</body>
</html>
