<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Banner — PASHMOOD Admin</title>
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
            --accent:        #f72585;
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
            --shadow-md:     0 8px 30px rgba(67,97,238,.12);
        }
        html, body { height: 100%; font-family: 'Inter', sans-serif; background: var(--body-bg); color: var(--text); }
        a { text-decoration: none; color: inherit; }
        button { font-family: inherit; cursor: pointer; border: none; background: none; }

        /* Layout */
        .layout { display: flex; min-height: 100vh; }
        .sidebar {
            width: var(--sidebar-w); background: var(--sidebar-bg);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0;
            z-index: 100; overflow-y: auto; scrollbar-width: none;
            border-right: 1px solid var(--border); transition: transform .3s ease;
        }
        .sidebar::-webkit-scrollbar { display: none; }
        .sidebar-logo { padding: 24px 20px; border-bottom: 1px solid var(--border); }
        .sidebar-logo h1 { font-size: 20px; font-weight: 800; color: var(--primary); letter-spacing: -0.5px; }
        .sidebar-logo span { font-size: 11px; color: var(--muted); font-weight: 500; display: block; margin-top: 2px; }
        .sidebar-nav { padding: 12px 10px; flex: 1; }
        .nav-label { font-size: 10px; font-weight: 700; color: var(--muted); letter-spacing: 1px; text-transform: uppercase; padding: 8px 10px 4px; }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: var(--radius-sm);
            font-size: 14px; font-weight: 500; color: var(--text-soft);
            transition: all .2s; cursor: pointer; margin-bottom: 2px;
        }
        .nav-item:hover { background: var(--primary-pale); color: var(--primary); }
        .nav-item.active { background: var(--primary-pale); color: var(--primary); font-weight: 600; }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .nav-item .nav-badge { margin-left: auto; background: var(--accent); color: #fff; font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 20px; }
        .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar {
            height: var(--topbar-h); background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px; position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 18px; font-weight: 700; }
        .topbar-actions { display: flex; gap: 10px; align-items: center; }
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
        .btn-danger { background: var(--red-pale); color: var(--red); border: none; }
        .btn-danger:hover { background: var(--red); color: #fff; }
        .btn-sm { padding: 7px 14px; font-size: 12px; }
        .content { padding: 28px; flex: 1; }

        /* Alert */
        .alert { padding: 12px 18px; border-radius: var(--radius-sm); margin-bottom: 20px; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: var(--green-pale); color: var(--green-dark); }

        /* Banner Grid */
        .banner-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }
        .banner-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: box-shadow .2s, transform .2s;
        }
        .banner-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
        .banner-img {
            width: 100%; height: 180px; object-fit: cover;
            display: block; background: var(--body-bg);
        }
        .banner-img-placeholder {
            width: 100%; height: 180px;
            background: linear-gradient(135deg, #eef1fd 0%, #e0e7ff 100%);
            display: flex; align-items: center; justify-content: center;
            color: var(--muted);
        }
        .banner-body { padding: 16px; }
        .banner-meta { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; }
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 700;
        }
        .badge-active { background: var(--green-pale); color: var(--green-dark); }
        .badge-inactive { background: var(--red-pale); color: var(--red); }
        .badge-order { background: var(--primary-pale); color: var(--primary); }
        .banner-title { font-size: 15px; font-weight: 700; margin-bottom: 3px; }
        .banner-subtitle { font-size: 13px; color: var(--text-soft); margin-bottom: 8px; }
        .banner-link { font-size: 12px; color: var(--muted); word-break: break-all; }
        .file-info {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11px; font-weight: 600;
            color: var(--text-soft);
            background: var(--body-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2px 9px;
            margin-top: 6px;
        }
        .banner-actions { display: flex; gap: 8px; padding: 12px 16px; border-top: 1px solid var(--border); background: var(--body-bg); }

        /* Empty state */
        .empty-state {
            text-align: center; padding: 60px 20px;
            background: var(--card-bg); border-radius: var(--radius);
            box-shadow: var(--shadow);
        }
        .empty-state svg { width: 60px; height: 60px; color: var(--muted); margin: 0 auto 16px; }
        .empty-state h3 { font-size: 18px; font-weight: 700; margin-bottom: 8px; }
        .empty-state p { color: var(--text-soft); font-size: 14px; margin-bottom: 24px; }

        /* Modal */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,.45);
            display: flex; align-items: center; justify-content: center;
            z-index: 999; opacity: 0; pointer-events: none;
            transition: opacity .2s;
        }
        .modal-overlay.active { opacity: 1; pointer-events: all; }
        .modal {
            background: var(--card-bg); border-radius: var(--radius);
            padding: 28px; max-width: 420px; width: 100%; margin: 0 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
            transform: scale(.95); transition: transform .2s;
        }
        .modal-overlay.active .modal { transform: scale(1); }
        .modal h3 { font-size: 18px; font-weight: 700; margin-bottom: 8px; }
        .modal p { color: var(--text-soft); font-size: 14px; margin-bottom: 24px; }
        .modal-actions { display: flex; gap: 10px; justify-content: flex-end; }
    </style>
    @include('partials.theme-loader')
</head>
<body>
<div class="layout">
    <!-- Sidebar -->
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
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
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
                @php
                    $unreadOrdersNotif = \App\Models\Order::where('admin_read', false)
                        ->where(function ($query) {
                            $query->whereIn('status', ['pre_order', 'pending', 'waiting'])
                                ->orWhere(function ($subQuery) {
                                    $subQuery->where('status', 'canceled')
                                        ->where(function ($subSub) {
                                            $subSub->whereNull('cancellation_reason')
                                                ->orWhere('cancellation_reason', 'not like', '[Admin]%');
                                        });
                                });
                        })
                        ->count();
                @endphp
                @if($unreadOrdersNotif > 0)
                    <span class="nav-badge" style="background-color: #e11d48; color: white; border-radius: 9999px; padding: 2px 8px; font-size: 10px; font-weight: bold; margin-left: auto;">{{ $unreadOrdersNotif }}</span>
                @endif
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

    <!-- Main Content -->
    <div class="main">
        <header class="topbar">
            <div class="topbar-title">🖼️ Manajemen Banner</div>
            <div class="topbar-actions">
                <a href="{{ route('shop.index', ['edit_banners' => 'true']) }}" class="btn btn-primary">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Banner
                </a>
            </div>
        </header>

        <div class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($banners->isEmpty())
                <div class="empty-state">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <h3>Belum ada banner</h3>
                    <p>Tambahkan banner promosi untuk ditampilkan di halaman utama toko.</p>
                    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Banner Pertama
                    </a>
                </div>
            @else
                <div class="banner-grid">
                    @foreach($banners as $banner)
                    <div class="banner-card">
                        @if($banner->image_path)
                            <img src="{{ $banner->imageUrl() }}" alt="{{ $banner->title }}" class="banner-img">
                        @else
                            <div class="banner-img-placeholder">
                                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div class="banner-body">
                            <div class="banner-meta">
                                @if($banner->is_active)
                                    <span class="badge badge-active">● Aktif</span>
                                @else
                                    <span class="badge badge-inactive">● Nonaktif</span>
                                @endif
                                <span class="badge badge-order">#{{ $banner->sort_order }}</span>
                            </div>
                            <div class="banner-title">{{ $banner->title }}</div>
                            @if($banner->subtitle)
                                <div class="banner-subtitle">{{ $banner->subtitle }}</div>
                            @endif
                            @if($banner->link_url)
                                <div class="banner-link">🔗 {{ $banner->link_url }}</div>
                            @endif
                            <div style="display: flex; flex-wrap: wrap; gap: 4px; margin-top: 8px;">
                                <span class="badge" style="background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 12px; font-size: 10px;">📍 {{ $banner->placementLabel() }}</span>
                                <span class="badge" style="background: #f3e8ff; color: #6b21a8; padding: 2px 8px; border-radius: 12px; font-size: 10px;">📐 {{ $banner->widthLabel() }}</span>
                                <span class="badge" style="background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 12px; font-size: 10px;">📏 {{ $banner->heightLabel() }}</span>
                            </div>
                            <div>
                                <span class="file-info">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $banner->fileSizeMb() }}
                                </span>
                            </div>
                        </div>
                        <div class="banner-actions">
                            <!-- Toggle Aktif -->
                            <form action="{{ route('admin.banners.toggle', $banner) }}" method="POST" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-ghost btn-sm" title="{{ $banner->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    @if($banner->is_active)
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                        Nonaktifkan
                                    @else
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Aktifkan
                                    @endif
                                </button>
                            </form>
                            <!-- Edit -->
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-ghost btn-sm">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <!-- Hapus -->
                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="openDeleteModal({{ $banner->id }}, '{{ addslashes($banner->title) }}')">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <h3>Hapus Banner</h3>
        <p id="deleteModalText">Apakah Anda yakin ingin menghapus banner ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="modal-actions">
            <button type="button" class="btn btn-ghost" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal(id, title) {
    document.getElementById('deleteModalText').textContent = `Apakah Anda yakin ingin menghapus banner "${title}"? Gambar juga akan dihapus.`;
    document.getElementById('deleteForm').action = `/admin/banners/${id}`;
    document.getElementById('deleteModal').classList.add('active');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
    @include('partials.theme-customizer')
</body>
</html>
