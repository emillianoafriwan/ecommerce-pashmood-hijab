<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — PASHMOOD</title>
    <meta name="description" content="Panel pembeli PASHMOOD — kelola profil, keranjang, dan pesanan pashmina Anda.">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Theme Engine (loaded here for custom-CSS dashboards that don't use theme-loader partial) --}}
    <script>if(!window.ThemeEngine){document.write('<scr'+'ipt src="{{ asset('js/theme-engine.js') }}"><\/scr'+'ipt>');}</script>

    <style>
        /* ── Reset & Base ─────────────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary:        #4361ee;
            --primary-dark:   #3451db;
            --primary-light:  #6b82f5;
            --primary-pale:   #eef1fd;
            --accent:         #f72585;
            --accent-pale:    #fde8f3;
            --green:          #06d6a0;
            --green-dark:     #04b386;
            --green-pale:     #e0faf3;
            --amber:          #ff9f1c;
            --amber-pale:     #fff3e0;
            --red:            #ef233c;
            --red-pale:       #fee2e6;
            --cyan:           #4cc9f0;
            --cyan-pale:      #e3f7fd;
            --sidebar-w:      260px;
            --sidebar-bg:     #ffffff;
            --topbar-h:       68px;
            --text:           #1a1a2e;
            --text-soft:      #4a4a6a;
            --muted:          #9898b0;
            --border:         #ebebf5;
            --card-bg:        #ffffff;
            --body-bg:        #f4f5fb;
            --radius:         16px;
            --radius-sm:      10px;
            --shadow:         0 2px 8px rgba(67,97,238,.06), 0 0 0 1px rgba(0,0,0,.04);
            --shadow-md:      0 8px 30px rgba(67,97,238,.12);
            --shadow-hover:   0 12px 40px rgba(67,97,238,.18);
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--body-bg);
            color: var(--text);
        }
        a { text-decoration: none; color: inherit; }
        button { font-family: inherit; cursor: pointer; border: none; background: none; }

        /* ── Layout ───────────────────────────────────────────────────────── */
        .layout { display: flex; min-height: 100vh; }

        /* ══════════════════════════════════════════════════════════
           SIDEBAR — Clean white with accent indicators
        ══════════════════════════════════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            overflow-y: auto;
            scrollbar-width: none;
            border-right: 1px solid var(--border);
            transition: transform .3s ease;
        }
        .sidebar::-webkit-scrollbar { display: none; }

        /* Brand */
        .sidebar-brand {
            padding: 26px 24px 22px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--border);
        }
        .brand-logo {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--primary), #7b2ff7);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .brand-logo svg { color: #fff; width: 20px; height: 20px; }
        .brand-text .brand-name {
            font-size: 18px;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.5px;
        }
        .brand-text .brand-sub {
            font-size: 10px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 1px;
        }

        /* Navigation */
        .sidebar-nav { padding: 18px 14px; flex: 1; }
        .nav-group-label {
            font-size: 9px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 0 10px;
            margin: 16px 0 6px;
        }
        .nav-group-label:first-child { margin-top: 0; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            color: var(--muted);
            font-size: 13.5px;
            font-weight: 500;
            transition: all .3s cubic-bezier(0.16, 1, 0.3, 1);
            margin-bottom: 2px;
            position: relative;
            cursor: pointer;
        }
        .nav-item:hover {
            color: var(--primary);
            background: var(--primary-pale);
            padding-left: 16px;
        }
        .nav-item.active {
            background: var(--primary-pale);
            color: var(--primary);
            font-weight: 600;
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 6px; bottom: 6px;
            width: 3px;
            background: var(--primary);
            border-radius: 0 3px 3px 0;
        }
        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 16px 14px;
            border-top: 1px solid var(--border);
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            background: var(--body-bg);
            cursor: default;
        }
        .sidebar-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #7b2ff7);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sidebar-user-name {
            font-size: 13px; font-weight: 600; color: var(--text);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .sidebar-user-role {
            font-size: 10px; color: var(--muted); font-weight: 400;
        }

        /* ══════════════════════════════════════════════════════════
           MAIN WRAPPER
        ══════════════════════════════════════════════════════════ */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── Topbar ───────────────────────────────────────────────────────── */
        .topbar {
            height: var(--topbar-h);
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.3px;
        }
        .topbar-sub {
            font-size: 12px;
            color: var(--muted);
            font-weight: 400;
            margin-top: 2px;
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .topbar-btn {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: var(--body-bg);
            border: 1.5px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: var(--muted);
            transition: all .2s;
            position: relative;
        }
        .topbar-btn:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-pale); }
        .topbar-user-pill {
            display: flex; align-items: center; gap: 8px;
            background: var(--body-bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 5px 12px 5px 5px;
        }
        .topbar-avatar-sm {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--primary), #7b2ff7);
            color: #fff; font-size: 13px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .topbar-user-info .u-name { font-size: 13px; font-weight: 600; }
        .topbar-user-info .u-role { font-size: 10px; color: var(--muted); }

        /* ── Main Content ─────────────────────────────────────────────────── */
        .main-content { flex: 1; padding: 26px 30px; }

        /* Welcome Banner Card */
        .welcome-banner {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border-radius: 24px;
            padding: 40px 48px;
            position: relative;
            overflow: hidden;
            margin-bottom: 28px;
            box-shadow: var(--shadow-md);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
        }
        .welcome-banner::after {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(67, 97, 238, 0.15) 0%, rgba(247, 37, 133, 0.05) 70%, transparent 100%);
            border-radius: 50%;
            pointer-events: none;
        }
        .welcome-text { position: relative; z-index: 10; max-width: 600px; }
        .welcome-tag {
            font-size: 11px;
            font-weight: 700;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 8px;
            display: inline-block;
        }
        .welcome-title {
            font-size: 28px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin-bottom: 10px;
        }
        .welcome-desc {
            font-size: 14px;
            color: #94a3b8;
            line-height: 1.6;
        }
        .welcome-action {
            position: relative;
            z-index: 10;
            flex-shrink: 0;
        }
        .btn-banner {
            background: var(--primary);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            padding: 14px 28px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(67, 97, 238, 0.4);
            transition: all .2s;
        }
        .btn-banner:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.6);
        }

        /* Buyer Features Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }
        .feature-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
            border: 1px solid transparent;
            transition: all .3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }
        .feature-card::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 120px; height: 120px;
            border-radius: 50%;
            opacity: .05;
            transform: translate(30%, -30%);
            transition: all .3s ease;
        }
        .feature-card.c-blue::after   { background: var(--primary); }
        .feature-card.c-amber::after  { background: var(--amber); }
        .feature-card.c-green::after  { background: var(--green); }
        .feature-card.c-pink::after   { background: var(--accent); }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            border-color: var(--border);
        }
        .feature-card:hover::after {
            transform: translate(20%, -20%) scale(1.1);
            opacity: .08;
        }

        .feature-icon {
            width: 54px; height: 54px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 22px;
            transition: transform .3s ease;
        }
        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }
        .ic-blue  { background: var(--primary-pale); color: var(--primary); }
        .ic-amber { background: var(--amber-pale);   color: var(--amber); }
        .ic-green { background: var(--green-pale);   color: var(--green-dark); }
        .ic-pink  { background: var(--accent-pale);  color: var(--accent); }

        .feature-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
            letter-spacing: -0.2px;
        }
        .feature-desc {
            font-size: 13px;
            color: var(--text-soft);
            line-height: 1.5;
            margin-bottom: 24px;
            flex-grow: 1;
        }
        .feature-btn {
            font-size: 12.5px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            width: fit-content;
            transition: opacity .2s;
        }
        .btn-blue  { background: var(--primary-pale); color: var(--primary); }
        .btn-amber { background: var(--amber-pale);   color: var(--amber); }
        .btn-green { background: var(--green-pale);   color: var(--green-dark); }
        .btn-pink  { background: var(--accent-pale);  color: var(--accent); }
        .feature-card:hover .feature-btn {
            opacity: 0.85;
        }

        /* ══════════════════════════════════════════════════════════
           ANIMATIONS
        ══════════════════════════════════════════════════════════ */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim-1 { animation: fadeUp .45s .00s ease both; }
        .anim-2 { animation: fadeUp .45s .08s ease both; }
        .anim-3 { animation: fadeUp .45s .16s ease both; }
        .anim-4 { animation: fadeUp .45s .24s ease both; }

        /* ══════════════════════════════════════════════════════════
           STAT CARDS
        ══════════════════════════════════════════════════════════ */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 20px 22px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: transform .25s, box-shadow .25s;
            position: relative;
            overflow: hidden;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 100px; height: 100px;
            border-radius: 50%;
            opacity: .06;
            transform: translate(30%, -30%);
        }
        .stat-card.c-blue::after   { background: var(--primary); }
        .stat-card.c-green::after  { background: var(--green); }
        .stat-card.c-amber::after  { background: var(--amber); }
        .stat-card.c-pink::after   { background: var(--accent); }

        .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-hover); }

        .stat-icon-wrap {
            width: 50px; height: 50px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .stat-icon-wrap svg { width: 22px; height: 22px; }

        .stat-body { flex: 1; min-width: 0; }
        .stat-label {
            font-size: 11px; font-weight: 600;
            color: var(--muted); text-transform: uppercase;
            letter-spacing: .8px; margin-bottom: 6px;
        }
        .stat-value {
            font-size: 22px; font-weight: 800;
            color: var(--text); line-height: 1; letter-spacing: -0.5px;
        }
        .stat-footer { margin-top: 8px; display: flex; align-items: center; gap: 6px; }
        .stat-pill {
            display: inline-flex; align-items: center; gap: 3px;
            font-size: 10px; font-weight: 600;
            padding: 2px 8px; border-radius: 20px;
        }
        .pill-green  { background: var(--green-pale); color: var(--green-dark); }
        .pill-amber  { background: var(--amber-pale); color: var(--amber); }
        .pill-blue   { background: var(--primary-pale); color: var(--primary); }
        .pill-pink   { background: var(--accent-pale); color: var(--accent); }
        .pill-gray   { background: var(--body-bg); color: var(--muted); }

        /* ── Responsive ───────────────────────────────────────────────────── */
        @media (max-width: 960px) {
            .cards-grid { grid-template-columns: 1fr; }
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 576px) {
            .stat-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; }
            .main-content { padding: 20px 16px; }
            .welcome-banner { padding: 30px; flex-direction: column; align-items: flex-start; }
            .welcome-action { width: 100%; }
            .btn-banner { width: 100%; justify-content: center; }
        }
    </style>

    {{-- Tailwind CDN — required for chat-widget and other Tailwind-based partials --}}
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>

<div class="layout">

    {{-- ════════════════════════════════════════════════════════
         SIDEBAR
    ════════════════════════════════════════════════════════ --}}
    <aside class="sidebar">

        {{-- Brand --}}
        <div class="sidebar-brand">
            <div class="brand-logo">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M5 3l14 9-14 9V3z"/>
                </svg>
            </div>
            <div class="brand-text">
                <div class="brand-name">PASHMOOD</div>
                <div class="brand-sub">Buyer Panel</div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">

            <div class="nav-group-label">Menu Utama</div>

            <a href="{{ route('dashboard') }}" id="nav-dashboard" class="nav-item active">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('shop.index') }}" id="nav-shop" class="nav-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Kunjungi Toko
            </a>

            <div class="nav-group-label">Transaksi</div>

            <a href="{{ route('cart.index') }}" id="nav-cart" class="nav-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Keranjang Belanja
            </a>

            <a href="{{ route('orders.history') }}" id="nav-orders" class="nav-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Pre-Order Saya
            </a>

            <div class="nav-group-label">Akun</div>

            <a href="{{ route('profile.edit') }}" id="nav-profile" class="nav-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profil Saya
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-item" style="width: 100%;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>

        </nav>

        {{-- ── Theme Picker Panel ── --}}
        @include('partials.sidebar-theme-panel')

        {{-- User Footer --}}
        <div class="sidebar-footer">
            <div class="sidebar-user">
                @if(auth()->user()->avatar)
                    <img class="sidebar-avatar" src="{{ asset('storage/' . auth()->user()->avatar) }}" style="object-fit: cover;">
                @else
                    <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                @endif
                <div>
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-role">Pembeli</div>
                </div>
            </div>
        </div>

    </aside>

    {{-- ════════════════════════════════════════════════════════
         MAIN WRAPPER
    ════════════════════════════════════════════════════════ --}}
    <div class="main-wrapper">

        {{-- Topbar --}}
        <header class="topbar">
            <div>
                <div class="topbar-title">Dashboard</div>
                <div class="topbar-sub">Selamat datang kembali di PASHMOOD</div>
            </div>
            <div class="topbar-right">
                
                <a href="{{ route('cart.index') }}" class="topbar-btn" title="Keranjang belanja">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </a>

                <div class="topbar-user-pill">
                    @if(auth()->user()->avatar)
                        <img class="topbar-avatar-sm" src="{{ asset('storage/' . auth()->user()->avatar) }}" style="object-fit: cover;">
                    @else
                        <div class="topbar-avatar-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    @endif
                    <div class="topbar-user-info">
                        <div class="u-name">{{ auth()->user()->name }}</div>
                        <div class="u-role">Pembeli</div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="main-content">

            {{-- ══ WELCOME HERO BANNER ══ --}}
            <div class="welcome-banner anim-1">
                <div class="welcome-text">
                    <span class="welcome-tag">Panel Kendali Akun</span>
                    <h1 class="welcome-title">Selamat Datang, {{ explode(' ', auth()->user()->name)[0] }}!</h1>
                    <p class="welcome-desc">Kelola pesanan, perbarui profil, dan nikmati pengalaman berbelanja koleksi pashmina eksklusif kami secara pre-order dengan mudah.</p>
                </div>
                <div class="welcome-action">
                    <a href="{{ route('shop.index') }}" class="btn-banner">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Kunjungi Toko
                    </a>
                </div>
            </div>

            {{-- ══ STAT CARDS ══ --}}
            <div class="stat-grid anim-2">
                {{-- Total Spend --}}
                <a href="{{ route('orders.history', ['status' => 'paid_shipped_completed']) }}" class="stat-card c-blue" style="text-decoration: none;">
                    <div class="stat-icon-wrap ic-blue">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="stat-body">
                        <div class="stat-label">Total Belanja</div>
                        <div class="stat-value" style="font-size:18px;">Rp {{ number_format($totalSpend, 0, ',', '.') }}</div>
                        <div class="stat-footer">
                            <span class="stat-pill pill-green">Terverifikasi</span>
                        </div>
                    </div>
                </a>

                {{-- Total Orders --}}
                <a href="{{ route('orders.history', ['status' => 'paid_shipped_completed']) }}" class="stat-card c-pink" style="text-decoration: none;">
                    <div class="stat-icon-wrap ic-pink">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div class="stat-body">
                        <div class="stat-label">Semua Pesanan</div>
                        <div class="stat-value">{{ $totalOrders }}</div>
                        <div class="stat-footer">
                            <span class="stat-pill pill-pink">Transaksi</span>
                        </div>
                    </div>
                </a>

                {{-- Pending Orders --}}
                <a href="{{ route('orders.history', ['status' => 'pending']) }}" class="stat-card c-amber" style="text-decoration: none;">
                    <div class="stat-icon-wrap ic-amber">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="stat-body">
                        <div class="stat-label">Menunggu Tindakan</div>
                        <div class="stat-value">{{ $pendingOrders }}</div>
                        <div class="stat-footer">
                            <span class="stat-pill pill-amber">Belum Selesai</span>
                        </div>
                    </div>
                </a>

                {{-- Completed Orders --}}
                <a href="{{ route('orders.history', ['status' => 'completed']) }}" class="stat-card c-green" style="text-decoration: none;">
                    <div class="stat-icon-wrap ic-green">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="stat-body">
                        <div class="stat-label">Pesanan Selesai</div>
                        <div class="stat-value">{{ $completedOrders }}</div>
                        <div class="stat-footer">
                            <span class="stat-pill pill-green">Selesai</span>
                        </div>
                    </div>
                </a>
            </div>

            {{-- ══ FEATURE CARDS GRID ══ --}}
            <div class="cards-grid">

                {{-- Kunjungi Toko --}}
                <a href="{{ route('shop.index') }}" class="feature-card c-blue anim-2">
                    <div>
                        <div class="feature-icon ic-blue">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <h2 class="feature-title">Jelajahi Toko</h2>
                        <p class="feature-desc">Lihat katalog pashmina terlengkap dan temukan berbagai warna serta bahan premium favorit Anda.</p>
                    </div>
                    <span class="feature-btn btn-blue">
                        Belanja Sekarang
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </a>

                {{-- Keranjang Belanja --}}
                <a href="{{ route('cart.index') }}" class="feature-card c-amber anim-2">
                    <div>
                        <div class="feature-icon ic-amber">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h2 class="feature-title">Keranjang Belanja</h2>
                        <p class="feature-desc">Lihat produk pashmina pilihan yang telah dimasukkan ke dalam daftar keranjang dan lakukan checkout.</p>
                    </div>
                    <span class="feature-btn btn-amber">
                        Buka Keranjang
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </a>

                {{-- Pre-Order Saya --}}
                <a href="{{ route('orders.history') }}" class="feature-card c-green anim-3">
                    <div>
                        <div class="feature-icon ic-green">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h2 class="feature-title">Pre-Order Saya</h2>
                        <p class="feature-desc">Pantau status pembayaran, proses produksi pashmina, hingga pengiriman pesanan Anda secara real-time.</p>
                    </div>
                    <span class="feature-btn btn-green">
                        Pantau Status PO
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </a>

                {{-- Pengaturan Profil --}}
                <a href="{{ route('profile.edit') }}" class="feature-card c-pink anim-3">
                    <div>
                        <div class="feature-icon ic-pink">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h2 class="feature-title">Profil Saya</h2>
                        <p class="feature-desc">Perbarui data diri, kata sandi akun, alamat pengiriman utama untuk pengiriman pre-order pashmina.</p>
                    </div>
                    <span class="feature-btn btn-pink">
                        Kelola Profil
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </a>

            </div>

            {{-- ══ PESANAN TERBARU ══ --}}
            <div class="card anim-4" style="background: var(--card-bg); border-radius: var(--radius); padding: 24px; box-shadow: var(--shadow); margin-top: 28px;">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <div>
                        <h2 class="card-title" style="font-size: 16px; font-weight: 700; color: var(--text); letter-spacing: -0.2px;">Pre-Order Terbaru Anda</h2>
                        <p class="card-sub" style="font-size: 11px; color: var(--muted); margin-top: 2px;">5 transaksi pre-order terakhir</p>
                    </div>
                    <a href="{{ route('orders.history') }}" class="card-action" style="font-size: 12px; font-weight: 600; color: var(--primary); hover:underline">Semua PO →</a>
                </div>

                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="data-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px;">No. Pesanan</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px;">Tanggal</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px;">Metode Pengiriman</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px;">Total Harga</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                @php
                                    $badgeClass = match($order->status) {
                                        'completed'              => 'pill-green',
                                        'shipped'                => 'pill-blue',
                                        'paid'                   => 'pill-green',
                                        'waiting'                => 'pill-blue',
                                        'pending', 'pre_order'   => 'pill-amber',
                                        'canceled'               => 'pill-pink',
                                        default                  => 'pill-gray',
                                    };
                                @endphp
                                <tr style="border-bottom: 1px solid var(--border); transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='var(--body-bg)'" onmouseout="this.style.backgroundColor='transparent'">
                                    <td style="padding: 16px; font-size: 13.5px; font-weight: 700; color: var(--text);">#{{ $order->id }}</td>
                                    <td style="padding: 16px; font-size: 13px; color: var(--text-soft);">{{ $order->created_at->format('d M Y H:i') }}</td>
                                    <td style="padding: 16px; font-size: 13px; color: var(--text-soft);">{{ $order->courier }}</td>
                                    <td style="padding: 16px; font-size: 13.5px; font-weight: 700; color: var(--text);">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td style="padding: 16px;">
                                        <span class="stat-pill {{ $badgeClass }}">{{ $order->statusIndo() }}</span>
                                    </td>
                                    <td style="padding: 16px;">
                                        <a href="{{ route('order.detail', $order->id) }}" class="btn-blue" style="padding: 6px 12px; border-radius: 8px; font-size: 11.5px; font-weight: 700; text-decoration: none; display: inline-block;">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="padding: 40px 16px; text-align: center; color: var(--muted); font-size: 13px;">
                                        Anda belum memiliki transaksi pre-order.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>

    <!-- FLOATING CHAT WIDGET -->
    @include('partials.chat-widget')

    <script src="{{ asset('/js/smooth-navigation.js') }}"></script>

</body>
</html>
