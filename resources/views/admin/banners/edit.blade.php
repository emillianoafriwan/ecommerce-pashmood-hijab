<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Banner — PASHMOOD Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary:       #4361ee;
            --primary-dark:  #3451db;
            --primary-light: #6b82f5;
            --primary-pale:  #eef1fd;
            --green:         #06d6a0;
            --green-dark:    #04b386;
            --green-pale:    #e0faf3;
            --amber:         #ff9f1c;
            --amber-pale:    #fff3e0;
            --red:           #ef233c;
            --red-pale:      #fee2e6;
            --sidebar-w:     260px;
            --sidebar-bg:    #ffffff;
            --topbar-h:      68px;
            --text:          #1a1a2e;
            --text-soft:     #4a4a6a;
            --muted:         #9898b0;
            --border:        #ebebf5;
            --card-bg:       #ffffff;
            --body-bg:       #f4f5fb;
            --radius:        16px;
            --radius-sm:     10px;
            --shadow:        0 2px 8px rgba(67,97,238,.06), 0 0 0 1px rgba(0,0,0,.04);
        }
        html, body { height: 100%; font-family: 'Inter', sans-serif; background: var(--body-bg); color: var(--text); }
        a { text-decoration: none; color: inherit; }
        button { font-family: inherit; cursor: pointer; border: none; background: none; }

        .layout { display: flex; min-height: 100vh; }
        .sidebar {
            width: var(--sidebar-w); background: var(--sidebar-bg);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0;
            z-index: 100; overflow-y: auto; scrollbar-width: none;
            border-right: 1px solid var(--border);
        }
        .sidebar::-webkit-scrollbar { display: none; }
        .sidebar-logo { padding: 24px 20px; border-bottom: 1px solid var(--border); }
        .sidebar-logo h1 { font-size: 20px; font-weight: 800; color: var(--primary); }
        .sidebar-logo span { font-size: 11px; color: var(--muted); font-weight: 500; display: block; margin-top: 2px; }
        .sidebar-nav { padding: 12px 10px; flex: 1; }
        .nav-label { font-size: 10px; font-weight: 700; color: var(--muted); letter-spacing: 1px; text-transform: uppercase; padding: 8px 10px 4px; }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: var(--radius-sm);
            font-size: 14px; font-weight: 500; color: var(--text-soft);
            transition: all .2s; margin-bottom: 2px;
        }
        .nav-item:hover { background: var(--primary-pale); color: var(--primary); }
        .nav-item.active { background: var(--primary-pale); color: var(--primary); font-weight: 600; }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; }
        .topbar {
            height: var(--topbar-h); background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px; position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 18px; font-weight: 700; }
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 20px; border-radius: var(--radius-sm);
            font-size: 14px; font-weight: 600; cursor: pointer;
            transition: all .2s; text-decoration: none; border: none; font-family: inherit;
        }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(67,97,238,.3); }
        .btn-ghost { background: transparent; color: var(--text-soft); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--body-bg); }
        .content { padding: 28px; }

        .form-card {
            background: var(--card-bg); border-radius: var(--radius);
            box-shadow: var(--shadow); padding: 32px; max-width: 780px;
        }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group.full { grid-column: 1 / -1; }
        label { display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 7px; }
        label span.req { color: var(--red); margin-left: 2px; }
        input[type="text"], input[type="url"], input[type="number"], select, textarea {
            width: 100%; padding: 11px 14px;
            border: 1.5px solid var(--border); border-radius: var(--radius-sm);
            font-size: 14px; font-family: inherit; color: var(--text);
            background: var(--body-bg); transition: border-color .2s, box-shadow .2s; outline: none;
        }
        input:focus, textarea:focus {
            border-color: var(--primary); background: #fff;
            box-shadow: 0 0 0 3px rgba(67,97,238,.1);
        }
        .hint { font-size: 11px; color: var(--muted); margin-top: 5px; }
        .error-msg { font-size: 12px; color: var(--red); margin-top: 5px; }

        /* Current image */
        .current-image-box {
            border: 1.5px solid var(--border); border-radius: var(--radius);
            overflow: hidden; margin-bottom: 12px;
        }
        .current-image-box img {
            width: 100%; max-height: 220px; object-fit: cover; display: block;
        }
        .current-image-label {
            padding: 8px 12px; background: var(--body-bg);
            font-size: 12px; color: var(--muted); border-top: 1px solid var(--border);
        }

        /* Upload area */
        .upload-area {
            border: 2px dashed var(--border); border-radius: var(--radius);
            padding: 24px; text-align: center; cursor: pointer;
            transition: border-color .2s, background .2s;
            position: relative; background: var(--body-bg);
        }
        .upload-area:hover, .upload-area.drag-over { border-color: var(--primary); background: var(--primary-pale); }
        .upload-area input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
        .upload-area p { font-size: 13px; color: var(--text-soft); }
        #imagePreviewWrapper { margin-top: 12px; display: none; }
        #imagePreview { max-width: 100%; max-height: 240px; object-fit: cover; border-radius: var(--radius-sm); width: 100%; }
        #previewLabel { font-size: 12px; color: var(--muted); margin-top: 6px; }

        /* Toggle */
        .toggle-row { display: flex; align-items: center; gap: 12px; }
        .toggle-switch { position: relative; display: inline-block; width: 48px; height: 26px; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider {
            position: absolute; cursor: pointer; inset: 0;
            background: var(--border); border-radius: 26px; transition: background .2s;
        }
        .toggle-slider:before {
            content: ''; position: absolute;
            height: 20px; width: 20px; left: 3px; bottom: 3px;
            background: white; border-radius: 50%; transition: transform .2s;
            box-shadow: 0 1px 4px rgba(0,0,0,.15);
        }
        .toggle-switch input:checked + .toggle-slider { background: var(--green); }
        .toggle-switch input:checked + .toggle-slider:before { transform: translateX(22px); }
        .toggle-label { font-size: 14px; font-weight: 500; }

        .divider { height: 1px; background: var(--border); margin: 24px 0; }
        .form-actions { display: flex; gap: 12px; justify-content: flex-end; }
        .section-title { font-size: 13px; font-weight: 700; color: var(--text-soft); margin-bottom: 12px; text-transform: uppercase; letter-spacing: .5px; }

        /* ── Crop Modal ── */
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
            background: var(--text);
            padding: .75rem 1.15rem;
            display: flex; align-items: center; justify-content: space-between;
            color: #fff;
        }
        #crop-header p {
            margin: 0;
        }

        #crop-canvas-area {
            width: 100%;
            height: 320px;
            background: #1e293b;
            overflow: hidden;
            position: relative;
        }

        #crop-canvas-area img {
            display: block;
            max-width: 100%;
        }

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
            border-color: var(--primary);
            background: var(--primary);
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
            background: var(--primary);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    @include('partials.theme-loader')
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="sidebar-logo">
            <h1>PASHMOOD</h1>
            <span>Admin Panel</span>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('shop.index') }}" class="nav-item">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Lihat Toko
            </a>
            <a href="{{ route('shop.index', ['edit_banners' => 'true']) }}" class="nav-item">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Tambah Banner
            </a>
            <a href="{{ route('products.index') }}" class="nav-item">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Produk
            </a>
            <a href="{{ route('categories.index') }}" class="nav-item">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Kategori
            </a>
            <a href="{{ route('admin.orders') }}" class="nav-item">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Pesanan
            </a>
            <a href="{{ route('admin.chats') }}" class="nav-item">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 18px; height: 18px; color: var(--muted);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Chat Pelanggan
                @php
                    $unreadChats = \App\Models\ChatMessage::where('is_read', false)
                        ->whereHas('sender', function($q) { $q->where('role', 'user'); })
                        ->count();
                @endphp
                @if($unreadChats > 0)
                    <span class="nav-badge" style="background-color: #e11d48; color: white; border-radius: 9999px; padding: 2px 8px; font-size: 10px; font-weight: bold; margin-left: auto;">{{ $unreadChats }}</span>
                @endif
            </a>
            <a href="{{ route('admin.banners.index') }}" class="nav-item active">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Banner
            </a>
        </nav>
    </aside>

    <div class="main">
        <header class="topbar">
            <div class="topbar-title">✏️ Edit Banner</div>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-ghost">← Kembali</a>
        </header>
        <div class="content">
            <div class="form-card">
                <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    {{-- Gambar Saat Ini --}}
                    <div class="form-group">
                        <label>Gambar Banner</label>
                        <div class="current-image-box">
                            <img src="{{ $banner->imageUrl() }}" alt="{{ $banner->title }}" id="currentImg">
                            <div class="current-image-label">Gambar saat ini · Unggah file baru untuk menggantinya</div>
                        </div>
                        <div class="section-title">Ganti Gambar (Opsional)</div>
                        <div class="upload-area" id="uploadArea">
                            <input type="file" id="imageInput" accept="image/jpg,image/jpeg,image/png,image/webp">
                            <p>🖼️ Klik atau seret gambar baru ke sini · JPG, PNG, WEBP · Maks. 10MB</p>
                        </div>

                        {{-- Hidden input containing the cropped version that will be sent to the server --}}
                        <input type="file" name="image" id="image-cropped" style="display:none">

                        <div id="crop-hint"></div>

                        <div id="imagePreviewWrapper">
                            <img id="imagePreview" src="" alt="Preview baru">
                            <div id="previewLabel"></div>
                            <button type="button" class="btn btn-ghost btn-sm" id="recrop-btn" style="margin-top: 10px; display: none;">✂️ Crop Ulang</button>
                        </div>
                        @error('image')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="title">Judul Banner <span class="req">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $banner->title) }}" maxlength="100" required>
                            @error('title')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="sort_order">Urutan Tampil <span class="req">*</span></label>
                            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" min="0" max="99" required>
                            <div class="hint">Angka lebih kecil tampil lebih dulu</div>
                            @error('sort_order')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group full">
                            <label for="subtitle">Subjudul / Deskripsi Singkat</label>
                            <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $banner->subtitle) }}" maxlength="200">
                            @error('subtitle')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group full">
                            <label for="link_url">Link URL (opsional)</label>
                            <input type="url" name="link_url" id="link_url" value="{{ old('link_url', $banner->link_url) }}" placeholder="https://..." maxlength="255">
                            <div class="hint">URL tujuan saat banner diklik.</div>
                            @error('link_url')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>

                        {{-- Posisi Banner --}}
                        <div class="form-group">
                            <label for="placement">Posisi / Tempat Banner <span class="req">*</span></label>
                            <select name="placement" id="placement" required>
                                <option value="below_recommendations" {{ old('placement', $banner->placement) == 'below_recommendations' ? 'selected' : '' }}>Di bawah Rekomendasi (Tengah - Default)</option>
                                <option value="above_recommendations" {{ old('placement', $banner->placement) == 'above_recommendations' ? 'selected' : '' }}>Di atas Rekomendasi</option>
                                <option value="below_catalog" {{ old('placement', $banner->placement) == 'below_catalog' ? 'selected' : '' }}>Di bawah Katalog Utama</option>
                            </select>
                            @error('placement')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>

                        {{-- Lebar Banner --}}
                        <div class="form-group">
                            <label for="width">Lebar Banner <span class="req">*</span></label>
                            <select name="width" id="width" required>
                                <option value="half" {{ old('width', $banner->width) == 'half' ? 'selected' : '' }}>Setengah Lebar (2 Kolom)</option>
                                <option value="full" {{ old('width', $banner->width) == 'full' ? 'selected' : '' }}>Lebar Penuh (1 Kolom)</option>
                            </select>
                            @error('width')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>

                        {{-- Tinggi Banner --}}
                        <div class="form-group">
                            <label for="height">Tinggi Banner <span class="req">*</span></label>
                            <select name="height" id="height" required>
                                <option value="medium" {{ old('height', $banner->height) == 'medium' ? 'selected' : '' }}>Sedang (Default)</option>
                                <option value="small" {{ old('height', $banner->height) == 'small' ? 'selected' : '' }}>Pendek</option>
                                <option value="large" {{ old('height', $banner->height) == 'large' ? 'selected' : '' }}>Tinggi</option>
                            </select>
                            @error('height')<div class="error-msg">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="form-group">
                        <label>Status Banner</label>
                        <div class="toggle-row">
                            <label class="toggle-switch">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label">Tampilkan banner di halaman utama</span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-ghost">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════ CROP MODAL ══════════════ --}}
<div id="crop-modal" role="dialog" aria-modal="true" aria-label="Crop Gambar Banner">
    <div id="crop-wrapper">
        <div id="crop-header">
            <div style="display:flex; align-items:center; gap:10px">
                <span style="font-size:1.25rem">✂️</span>
                <div>
                    <h4 style="font-weight:700; font-size:14px; margin:0">Crop Gambar Banner</h4>
                    <p style="font-size:11px; color:#94a3b8; margin:2px 0 0 0">Sesuaikan area untuk banner PASHMOOD</p>
                </div>
            </div>
            <button type="button" onclick="closeCropModal()" style="color:#fff; font-size:1.25rem; background:none; border:none; cursor:pointer;">✕</button>
        </div>

        <div id="crop-canvas-area">
            <img id="crop-image" src="" alt="">
        </div>

        <div id="crop-footer">
            <div class="crop-controls-row">
                <div style="display:flex; gap:6px; flex-wrap:wrap; align-items:center">
                    <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px">Rasio:</span>
                    <button type="button" class="ratio-btn active" data-ratio="1.777" onclick="setRatio(16/9, this)">16:9</button>
                    <button type="button" class="ratio-btn" data-ratio="2.333" onclick="setRatio(21/9, this)">21:9</button>
                    <button type="button" class="ratio-btn" data-ratio="1.333" onclick="setRatio(4/3, this)">4:3</button>
                    <button type="button" class="ratio-btn" data-ratio="NaN" onclick="setRatio(NaN, this)">Bebas</button>
                </div>
                <div style="display:flex; align-items:center; gap:8px">
                    <button type="button" onclick="cropperInstance.zoom(-0.1)" class="btn btn-ghost" style="padding:4px 8px; font-size:12px">−</button>
                    <input id="zoom-slider" type="range" min="0" max="3" step="0.01" value="0">
                    <button type="button" onclick="cropperInstance.zoom(0.1)" class="btn btn-ghost" style="padding:4px 8px; font-size:12px">+</button>
                </div>
            </div>
            <div style="display:flex; gap:10px; width:100%">
                <button type="button" onclick="cropperInstance.reset()" class="btn btn-ghost" style="flex:1; justify-content:center">Reset</button>
                <button type="button" onclick="applyCrop()" class="btn btn-primary" style="flex:1; justify-content:center">✓ Gunakan Gambar Ini</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
let cropperInstance = null;
let originalFile = null;

const imageInput = document.getElementById('imageInput');
const croppedInput = document.getElementById('image-cropped');
const cropModal = document.getElementById('crop-modal');
const cropImage = document.getElementById('crop-image');
const zoomSlider = document.getElementById('zoom-slider');
const previewWrapper = document.getElementById('imagePreviewWrapper');
const previewImg = document.getElementById('imagePreview');
const previewLabel = document.getElementById('previewLabel');
const currentImg = document.getElementById('currentImg');
const uploadArea = document.getElementById('uploadArea');
const recropBtn = document.getElementById('recrop-btn');
const cropHint = document.getElementById('crop-hint');
const bannerForm = document.querySelector('form');

imageInput.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;

    if (!file.type.startsWith('image/')) {
        cropHint.textContent = 'Format file harus berupa gambar.';
        cropHint.style.color = '#ef233c';
        this.value = '';
        return;
    }

    originalFile = file;
    openCropModal(file);
});

function openCropModal(file) {
    const reader = new FileReader();
    reader.onload = function (e) {
        cropModal.classList.add('open');
        if (cropperInstance) {
            cropperInstance.destroy();
        }

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
        cropImage.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function closeCropModal() {
    cropModal.classList.remove('open');
    if (cropperInstance) {
        cropperInstance.destroy();
        cropperInstance = null;
    }
    imageInput.value = '';
}

function setRatio(ratio, btn) {
    if (!cropperInstance) return;
    document.querySelectorAll('.ratio-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    cropperInstance.setAspectRatio(ratio);
}

zoomSlider.addEventListener('input', function () {
    if (cropperInstance) {
        cropperInstance.zoomTo(parseFloat(this.value));
    }
});

function applyCrop() {
    if (!cropperInstance) return;
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
            cropHint.textContent = 'Gagal menyimpan hasil crop.';
            cropHint.style.color = '#ef233c';
            return;
        }

        const ext = originalFile.type === 'image/png' ? 'png' : 'jpg';
        const mimeType = originalFile.type === 'image/png' ? 'image/png' : 'image/jpeg';
        const croppedFile = new File([blob], 'banner-cropped.' + ext, { type: mimeType });

        const dt = new DataTransfer();
        dt.items.add(croppedFile);
        croppedInput.files = dt.files;

        // Show Preview
        const url = URL.createObjectURL(blob);
        previewImg.src = url;
        currentImg.src = url;
        
        const mb = croppedFile.size / 1048576;
        const sizeStr = mb < 0.1 ? Math.round(croppedFile.size / 1024) + ' KB' : mb.toFixed(2) + ' MB';
        previewLabel.textContent = `Gambar baru cropped: ${sizeStr}`;
        
        previewWrapper.style.display = 'block';
        recropBtn.style.display = 'inline-block';
        
        cropHint.textContent = '✓ Gambar baru siap diunggah.';
        cropHint.style.color = '#06d6a0';

        cropModal.classList.remove('open');
        if (cropperInstance) {
            cropperInstance.destroy();
            cropperInstance = null;
        }
    }, originalFile.type === 'image/png' ? 'image/png' : 'image/jpeg', 0.9);
}

recropBtn.addEventListener('click', function () {
    if (originalFile) {
        openCropModal(originalFile);
    }
});

uploadArea.addEventListener('dragover', e => {
    e.preventDefault();
    uploadArea.classList.add('drag-over');
});
uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('drag-over'));
uploadArea.addEventListener('drop', e => {
    e.preventDefault();
    uploadArea.classList.remove('drag-over');
    if (e.dataTransfer.files[0]) {
        imageInput.files = e.dataTransfer.files;
        imageInput.dispatchEvent(new Event('change'));
    }
});

// Close modal when clicking backdrop
cropModal.addEventListener('click', function (e) {
    if (e.target === cropModal) closeCropModal();
});

// Validate on submit
bannerForm.addEventListener('submit', function (e) {
    if (imageInput.files.length && !croppedInput.files.length) {
        e.preventDefault();
        cropHint.textContent = 'Klik "Crop Ulang" atau crop terlebih dahulu gambar baru Anda.';
        cropHint.style.color = '#ef233c';
        imageInput.focus();
    }
});
</script>
    @include('partials.theme-customizer')
</body>
</html>
