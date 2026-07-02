<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Admin PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('partials.theme-loader')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Crop Modal ── */
        #crop-modal {
            display: none;
            position: fixed; inset: 0; z-index: 9999;
            background: rgba(15,23,42,0.75);
            backdrop-filter: blur(6px);
            align-items: center; justify-content: center;
        }
        #crop-modal.open { display: flex; animation: fadeIn .2s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: scale(.97); } to { opacity: 1; transform: scale(1); } }

        #crop-wrapper {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 20px 50px rgba(0,0,0,.35);
            width: min(420px, 92vw);
            overflow: hidden;
            display: flex; flex-direction: column;
        }

        #crop-header {
            background: #0f172a;
            padding: .75rem 1.15rem;
            display: flex; align-items: center; justify-content: space-between;
        }

        #crop-canvas-area {
            width: 100%;
            height: 240px;
            background: #1e293b;
            overflow: hidden;
            position: relative;
        }

        #crop-canvas-area img {
            display: block;
            max-width: 100%;
        }

        #crop-footer {
            padding: .75rem 1.15rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            display: flex; flex-wrap: wrap; gap: .5rem; align-items: center;
        }

        .ratio-btn {
            padding: .25rem .6rem;
            border-radius: .5rem;
            font-size: .6rem;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            border: 1.5px solid #e2e8f0;
            background: #fff;
            cursor: pointer;
            transition: all .15s;
            color: #475569;
        }
        .ratio-btn:hover, .ratio-btn.active {
            border-color: #e11d48;
            background: #e11d48;
            color: #fff;
        }

        #zoom-slider {
            -webkit-appearance: none;
            width: 120px; height: 4px;
            border-radius: 99px;
            background: #e2e8f0;
            outline: none; cursor: pointer;
        }
        #zoom-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 16px; height: 16px;
            border-radius: 50%;
            background: #e11d48;
            cursor: pointer;
        }

        /* Image preview after crop */
        #img-preview-box {
            display: none;
            margin-top: .75rem;
            border-radius: 1.25rem;
            overflow: hidden;
            border: 2px solid #fda4af;
            background: #fff1f2;
            padding: .5rem;
            position: relative;
        }
        #img-preview-box img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: .85rem;
            display: block;
        }
        #img-preview-box .recrop-btn {
            position: absolute;
            top: .9rem; right: .9rem;
            background: #0f172a;
            color: #fff;
            font-size: .65rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: .35rem .8rem;
            border-radius: .6rem;
            border: none;
            cursor: pointer;
            transition: background .15s;
        }
        #img-preview-box .recrop-btn:hover { background: #e11d48; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 min-h-screen pb-20">
    
    <header class="bg-slate-900 text-white py-6 mb-10 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Admin Panel</p>
                <h1 class="text-2xl font-extrabold tracking-tighter">PASHMOOD</h1>
            </div>
            <a href="{{ route('products.index') }}" class="bg-slate-800 hover:bg-slate-700 text-sm font-bold px-5 py-2.5 rounded-xl transition border border-slate-700 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="hidden sm:inline">Kembali ke Produk</span>
            </a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="mb-6 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
            <span>Admin Panel</span>
            <span>/</span>
            <span>Produk</span>
            <span>/</span>
            <span class="text-rose-500">Tambah</span>
        </div>

        <div class="bg-white p-6 md:p-10 rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="mb-10 flex items-start gap-4">
                <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center border border-rose-100 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Tambah Produk Baru</h1>
                    <p class="text-slate-500 mt-2 font-medium text-sm">Masukkan detail produk, harga, dan variasi warna untuk koleksi pre-order.</p>
                </div>
            </div>

            <form id="product-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" data-no-ajax="true">
                @csrf 
                
                <div class="mb-6">
                    <label for="category_id" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Kategori</label>
                    <select name="category_id" id="category_id" required class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-700 font-bold bg-slate-50 focus:bg-white cursor-pointer">
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Nama Produk</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required oninput="generateSlug()"
                            class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white placeholder-slate-300"
                            placeholder="Contoh: Pashmina Voal Dusty Rose">
                        @error('name')
                            <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-end mb-3">
                            <label for="slug" class="block text-xs font-black text-slate-700 uppercase tracking-widest">Slug URL</label>
                            <button type="button" onclick="generateSlug()" class="text-[10px] font-bold uppercase tracking-widest text-rose-500 hover:text-rose-700 transition flex items-center gap-1 bg-rose-50 px-3 py-1.5 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Generate
                            </button>
                        </div>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required 
                            class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-500 font-medium bg-slate-100 placeholder-slate-300"
                            placeholder="pashmina-voal-dusty-rose">
                        @error('slug')
                            <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-8">
                    <label for="price" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Harga (Rp)</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0"
                        class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white">
                    @error('price')
                        <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="description" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Deskripsi Produk</label>
                    <textarea name="description" id="description" rows="4" 
                        class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white placeholder-slate-300"
                        placeholder="Pashmina premium dengan material pilihan yang memberikan kenyamanan maksimal. Tekstur lembut, mudah dibentuk, dan memberikan kesan mewah pada penampilan Anda.">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8 flex items-center justify-between p-5 md:p-6 bg-slate-50 border border-slate-200/60 rounded-[2rem]">
                    <div>
                        <label class="block text-xs font-black text-slate-800 uppercase tracking-widest">Status Keaktifan</label>
                        <p class="text-xs text-slate-500 font-medium mt-1">Aktifkan agar produk muncul di katalog toko dan dapat dipesan.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-600"></div>
                    </label>
                </div>

                <div class="mb-8 p-5 md:p-6 bg-rose-50/60 border border-rose-100 rounded-[2rem]">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">
                        <div>
                            <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest">Variasi Warna</h2>
                            <p class="text-xs text-slate-500 font-medium mt-1">Tambahkan pilihan warna yang tersedia untuk pre-order.</p>
                        </div>
                        <button type="button" onclick="addRow()" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-slate-900 hover:bg-rose-600 transition gap-2 w-full sm:w-auto">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Warna
                        </button>
                    </div>

                    <div id="variation-container" class="space-y-3">
                        <div class="variation-row grid grid-cols-1 md:grid-cols-[2fr_3fr_auto] gap-3 bg-white p-4 rounded-2xl border border-rose-100 shadow-sm items-center">
                            <input type="text" name="variations[0][color]" placeholder="Warna (contoh: Mocca)" class="w-full px-4 py-3 rounded-xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 outline-none text-sm font-bold text-slate-700 bg-slate-50 focus:bg-white" required>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-500 shrink-0">Foto Warna:</span>
                                <input type="file" name="variations[0][image]" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 cursor-pointer">
                            </div>
                            <button type="button" class="h-12 w-12 inline-flex items-center justify-center text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition" onclick="removeRow(this)" title="Hapus Warna">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('variations')
                        <p class="text-rose-500 text-xs mt-3 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-10 p-5 md:p-6 bg-slate-50 border border-slate-100 rounded-[2rem]">
                    <label class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Gambar Produk</label>

                    {{-- File picker (hidden real input) --}}
                    <input type="file" id="image-picker" accept="image/*" class="w-full rounded-2xl bg-white px-4 py-3 text-sm font-bold text-slate-500 ring-1 ring-slate-200 file:mr-4 file:rounded-xl file:border-0 file:bg-rose-600 file:px-5 file:py-2.5 file:text-sm file:font-bold file:text-white hover:file:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 cursor-pointer">

                    {{-- Hidden input that holds the cropped image blob --}}
                    <input type="file" name="image" id="image-cropped" accept="image/*" class="hidden">

                    {{-- Preview box after crop --}}
                    <div id="img-preview-box" style="display:none">
                        <img id="img-preview" src="" alt="Preview Gambar">
                        <button type="button" id="recrop-btn" class="recrop-btn" style="display:none" onclick="reopenCrop()">
                            ✂ Crop Ulang
                        </button>
                    </div>

                    <p id="crop-hint" class="text-xs text-slate-400 mt-2 font-medium">Pilih gambar lalu crop sesuai kebutuhan.</p>

                    @error('image')
                        <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-4 border-t border-slate-100 pt-8">
                    <button type="submit" class="w-full sm:w-auto bg-slate-900 text-white font-bold px-10 py-4 rounded-2xl hover:bg-rose-600 transition shadow-xl shadow-slate-200 flex-1 text-center">
                        Simpan Produk
                    </button>
                    <a href="{{ route('products.index') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl font-bold text-slate-500 bg-white border border-slate-200 hover:border-slate-400 hover:text-slate-800 transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>

    {{-- ══════════════ CROP MODAL ══════════════ --}}
    <div id="crop-modal" role="dialog" aria-modal="true" aria-label="Crop Gambar">
        <div id="crop-wrapper">
            {{-- Header --}}
            <div id="crop-header">
                <div class="flex items-center gap-3">
                    <span style="font-size:1.3rem">✂️</span>
                    <div>
                        <p class="text-white font-extrabold text-sm tracking-tight">Crop Gambar Produk</p>
                        <p class="text-slate-400 text-xs font-medium mt-0.5">Geser & zoom untuk mengatur area yang akan disimpan</p>
                    </div>
                </div>
                <button type="button" onclick="closeCropModal()" style="color:#94a3b8;font-size:1.4rem;background:none;border:none;cursor:pointer;line-height:1" title="Tutup">✕</button>
            </div>

            {{-- Canvas --}}
            <div id="crop-canvas-area">
                <img id="crop-image" src="" alt="">
            </div>

            {{-- Footer controls --}}
            <div id="crop-footer">
                {{-- Aspect ratio --}}
                <div class="flex gap-2 flex-wrap">
                    <span class="text-xs font-black uppercase tracking-widest text-slate-500 self-center">Rasio:</span>
                    <button type="button" class="ratio-btn active" data-ratio="1" onclick="setRatio(1,this)">1 : 1</button>
                    <button type="button" class="ratio-btn" data-ratio="1.333" onclick="setRatio(4/3,this)">4 : 3</button>
                    <button type="button" class="ratio-btn" data-ratio="1.777" onclick="setRatio(16/9,this)">16 : 9</button>
                    <button type="button" class="ratio-btn" data-ratio="NaN" onclick="setRatio(NaN,this)">Bebas</button>
                </div>

                {{-- Zoom --}}
                <div class="flex items-center gap-2 ml-auto">
                    <span class="text-xs font-black uppercase tracking-widest text-slate-500">Zoom</span>
                    <button type="button" onclick="cropperInstance.zoom(-0.1)" style="width:28px;height:28px;border-radius:8px;border:1.5px solid #e2e8f0;background:#fff;font-size:1rem;cursor:pointer;display:flex;align-items:center;justify-content:center">−</button>
                    <input id="zoom-slider" type="range" min="0" max="3" step="0.01" value="0">
                    <button type="button" onclick="cropperInstance.zoom(0.1)" style="width:28px;height:28px;border-radius:8px;border:1.5px solid #e2e8f0;background:#fff;font-size:1rem;cursor:pointer;display:flex;align-items:center;justify-content:center">+</button>
                </div>

                {{-- Action buttons --}}
                <div class="w-full flex gap-3 pt-2 border-t border-slate-100">
                    <button type="button" onclick="cropperInstance.reset()" class="flex-1 py-3 rounded-xl border-2 border-slate-200 text-sm font-bold text-slate-600 hover:border-slate-400 transition">Reset</button>
                    <button type="button" onclick="applyCrop()" class="flex-1 py-3 rounded-xl bg-slate-900 text-white text-sm font-bold hover:bg-rose-600 transition">✓ Gunakan Gambar Ini</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    <script>
        /* ── Slug generator ── */
        function generateSlug() {
            const nameValue = document.getElementById('name').value;
            const slugOutput = nameValue.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/[\s-]+/g, '-').replace(/^-+|-+$/g, '');
            document.getElementById('slug').value = slugOutput;
        }

        /* ── Variation rows ── */
        var rowCount = 1;
        function addRow() {
            const container = document.getElementById('variation-container');
            const newRow = document.createElement('div');
            newRow.className = 'variation-row grid grid-cols-1 md:grid-cols-[2fr_3fr_auto] gap-3 bg-white p-4 rounded-2xl border border-rose-100 shadow-sm items-center';
            newRow.innerHTML = `
                <input type="text" name="variations[${rowCount}][color]" placeholder="Warna (contoh: Mocca)" class="w-full px-4 py-3 rounded-xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 outline-none text-sm font-bold text-slate-700 bg-slate-50 focus:bg-white" required>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-500 shrink-0">Foto Warna:</span>
                    <input type="file" name="variations[${rowCount}][image]" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 cursor-pointer">
                </div>
                <button type="button" class="h-12 w-12 inline-flex items-center justify-center text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition" onclick="removeRow(this)" title="Hapus Warna">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;
            container.appendChild(newRow);
            rowCount++;
        }

        function removeRow(btn) {
            const rows = document.querySelectorAll('.variation-row');
            if (rows.length > 1) {
                btn.closest('.variation-row').remove();
            }
        }

        /* ══════════════ CROP LOGIC ══════════════ */
        var cropperInstance = null;
        var originalFile = null;

        var picker       = document.getElementById('image-picker');
        var cropModal    = document.getElementById('crop-modal');
        var cropImage    = document.getElementById('crop-image');
        var zoomSlider   = document.getElementById('zoom-slider');
        var previewBox   = document.getElementById('img-preview-box');
        var previewImg   = document.getElementById('img-preview');
        var croppedInput = document.getElementById('image-cropped');
        var cropHint     = document.getElementById('crop-hint');
        var recropBtn    = document.getElementById('recrop-btn');
        var productForm  = document.getElementById('product-form');
        var cropperCssUrl = 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css';
        var cropperJsUrl  = 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js';

        function ensureCropperLoaded() {
            if (window.Cropper) return Promise.resolve();

            if (!document.querySelector(`link[href="${cropperCssUrl}"]`)) {
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = cropperCssUrl;
                document.head.appendChild(link);
            }

            if (window.__cropperLoadPromise) return window.__cropperLoadPromise;

            window.__cropperLoadPromise = new Promise((resolve, reject) => {
                const existingScript = document.querySelector(`script[src="${cropperJsUrl}"]`);
                if (existingScript) {
                    existingScript.addEventListener('load', resolve, { once: true });
                    existingScript.addEventListener('error', reject, { once: true });
                    return;
                }

                const script = document.createElement('script');
                script.src = cropperJsUrl;
                script.onload = resolve;
                script.onerror = reject;
                document.head.appendChild(script);
            }).then(() => {
                if (!window.Cropper) throw new Error('Cropper gagal dimuat.');
            });

            return window.__cropperLoadPromise;
        }

        picker.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                cropHint.textContent = 'File harus berupa gambar.';
                cropHint.style.color = '#e11d48';
                this.value = '';
                return;
            }

            originalFile = file;
            openCropModal(file);
        });

        function openCropModal(file) {
            if (!file) {
                picker.click();
                return;
            }

            if (typeof Cropper === 'undefined') {
                cropHint.textContent = 'Memuat fitur crop...';
                cropHint.style.color = '#64748b';
                ensureCropperLoaded()
                    .then(() => openCropModal(file))
                    .catch(() => {
                        cropHint.textContent = 'Cropper gagal dimuat. Periksa koneksi internet lalu coba lagi.';
                        cropHint.style.color = '#e11d48';
                    });
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                cropModal.classList.add('open');
                // Destroy previous instance
                if (cropperInstance) { cropperInstance.destroy(); cropperInstance = null; }

                cropImage.onload = function () {
                    cropperInstance = new Cropper(cropImage, {
                        aspectRatio: 1,
                        viewMode: 1,
                        autoCropArea: 0.85,
                        movable: true,
                        zoomable: true,
                        rotatable: false,
                        scalable: false,
                        guides: true,
                        highlight: true,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        ready() { zoomSlider.value = 0; },
                        zoom(e) {
                            zoomSlider.value = Math.max(0, Math.min(3, e.detail.ratio));
                        }
                    });
                    cropImage.onload = null;
                };
                cropImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        function reopenCrop() { openCropModal(originalFile); }

        function closeCropModal() {
            cropModal.classList.remove('open');
            if (cropperInstance) { cropperInstance.destroy(); cropperInstance = null; }
            // Reset picker so re-choosing same file triggers change event
            picker.value = '';
        }

        function setRatio(ratio, btn) {
            if (!cropperInstance) return;
            document.querySelectorAll('.ratio-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            cropperInstance.setAspectRatio(ratio);
        }

        zoomSlider.addEventListener('input', function () {
            if (cropperInstance) cropperInstance.zoomTo(parseFloat(this.value));
        });

        function applyCrop() {
            if (!cropperInstance) return;
            const canvas = cropperInstance.getCroppedCanvas({ maxWidth: 1600, maxHeight: 1600, imageSmoothingEnabled: true, imageSmoothingQuality: 'high' });
            if (!canvas) {
                cropHint.textContent = 'Gagal memproses gambar. Silakan pilih gambar lain.';
                cropHint.style.color = '#e11d48';
                return;
            }

            canvas.toBlob(function (blob) {
                if (!blob) {
                    cropHint.textContent = 'Gagal menyimpan hasil crop. Silakan coba lagi.';
                    cropHint.style.color = '#e11d48';
                    return;
                }

                // Transfer blob into the hidden file input
                const ext = originalFile.type === 'image/png' ? 'png' : 'jpg';
                const mimeType = originalFile.type === 'image/png' ? 'image/png' : 'image/jpeg';
                const croppedFile = new File([blob], 'product-image.' + ext, { type: mimeType });
                const dt = new DataTransfer();
                dt.items.add(croppedFile);
                croppedInput.files = dt.files;

                // Show preview
                const url = URL.createObjectURL(blob);
                previewImg.src = url;
                previewBox.style.display = 'block';
                recropBtn.style.display = 'block';
                cropHint.textContent = '✓ Gambar siap diunggah. Klik "Crop Ulang" jika ingin mengubah.';
                cropHint.style.color = '#16a34a';

                closeCropModal();
            }, originalFile.type === 'image/png' ? 'image/png' : 'image/jpeg', 0.92);
        }

        // Close modal when clicking backdrop
        cropModal.addEventListener('click', function (e) {
            if (e.target === cropModal) closeCropModal();
        });

        productForm.addEventListener('submit', function (e) {
            if (!croppedInput.files.length) {
                e.preventDefault();
                cropHint.textContent = 'Pilih gambar produk lalu klik "Gunakan Gambar Ini" setelah crop.';
                cropHint.style.color = '#e11d48';
                picker.focus();
            }
        });
    </script>
    <script src="{{ asset('/js/smooth-navigation.js') }}"></script>
    @include('partials.theme-customizer')
</body>
</html>
