<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — PASHMOOD</title>
    <meta name="description" content="Panel admin PASHMOOD — kelola produk, pesanan, kategori, dan laporan toko pashmina eksklusif.">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Theme Engine (loaded here for admin dashboard which doesn't use theme-loader partial) --}}
    <script>if(!window.ThemeEngine){document.write('<scr'+'ipt src="{{ asset('js/theme-engine.js') }}"><\/scr'+'ipt>');}</script>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

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
            transition: all .2s;
            margin-bottom: 2px;
            position: relative;
            cursor: pointer;
        }
        .nav-item:hover {
            color: var(--primary);
            background: var(--primary-pale);
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
        .nav-badge {
            margin-left: auto;
            background: var(--red);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .65; }
        }

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
        .search-wrap {
            display: flex;
            align-items: center;
            background: var(--body-bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 8px 14px;
            gap: 8px;
            min-width: 230px;
            transition: border-color .2s;
        }
        .search-wrap:focus-within {
            border-color: var(--primary);
            background: #fff;
        }
        .search-wrap input {
            border: none; background: none;
            font-family: inherit; font-size: 13px;
            color: var(--text); width: 100%; outline: none;
        }
        .search-wrap svg { color: var(--muted); flex-shrink: 0; }
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
        .topbar-btn .notif-dot {
            width: 8px; height: 8px;
            background: var(--red);
            border-radius: 50%;
            position: absolute; top: 6px; right: 6px;
            border: 2px solid #fff;
        }
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

        /* ══════════════════════════════════════════════════════════
           STAT CARDS (4 across)
        ══════════════════════════════════════════════════════════ */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 24px;
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
        .ic-blue  { background: var(--primary-pale); color: var(--primary); }
        .ic-green { background: var(--green-pale);   color: var(--green-dark); }
        .ic-amber { background: var(--amber-pale);   color: var(--amber); }
        .ic-pink  { background: var(--accent-pale);  color: var(--accent); }
        .ic-cyan  { background: var(--cyan-pale);    color: var(--cyan); }

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
            font-size: 11px; font-weight: 600;
            padding: 2px 8px; border-radius: 20px;
        }
        .pill-green  { background: var(--green-pale); color: var(--green-dark); }
        .pill-amber  { background: var(--amber-pale); color: var(--amber); }
        .pill-blue   { background: var(--primary-pale); color: var(--primary); }
        .pill-pink   { background: var(--accent-pale); color: var(--accent); }
        .stat-footer-text { font-size: 11px; color: var(--muted); font-weight: 500; }

        /* ══════════════════════════════════════════════════════════
           CHART ROW (2/3 + 1/3)
        ══════════════════════════════════════════════════════════ */
        .charts-row {
            display: grid;
            grid-template-columns: 1.75fr 1fr;
            gap: 18px;
            margin-bottom: 20px;
        }
        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 22px 24px;
            box-shadow: var(--shadow);
        }
        .card-header {
            display: flex; align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 15px; font-weight: 700;
            color: var(--text); letter-spacing: -0.2px;
        }
        .card-sub {
            font-size: 12px; color: var(--muted);
            font-weight: 400; margin-top: 2px;
        }
        .card-action {
            font-size: 12px; font-weight: 600;
            color: var(--primary);
            background: var(--primary-pale);
            padding: 6px 14px; border-radius: 8px;
            transition: opacity .2s; white-space: nowrap;
            display: flex; align-items: center; gap: 4px;
        }
        .card-action:hover { opacity: .75; }

        /* Revenue chart big number */
        .chart-hero-number {
            font-size: 26px; font-weight: 800;
            color: var(--text); letter-spacing: -0.5px;
            margin-bottom: 4px;
        }
        .chart-canvas-wrap { position: relative; height: 200px; }

        /* Order status doughnut */
        .doughnut-wrap { position: relative; height: 160px; margin: 0 auto; max-width: 200px; }
        .doughnut-center {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            pointer-events: none;
        }
        .doughnut-center-num {
            font-size: 22px; font-weight: 800; color: var(--text);
            line-height: 1;
        }
        .doughnut-center-label {
            font-size: 10px; font-weight: 600;
            color: var(--muted); margin-top: 2px;
        }
        .status-legend { margin-top: 16px; display: flex; flex-direction: column; gap: 0; }
        .legend-item {
            display: flex; align-items: center;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
            font-size: 12.5px;
        }
        .legend-item:last-child { border-bottom: none; }
        .legend-left { display: flex; align-items: center; gap: 8px; }
        .legend-dot {
            width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0;
        }
        .legend-label { font-weight: 500; color: var(--text-soft); }
        .legend-count { font-weight: 700; color: var(--text); font-size: 13px; }

        /* ══════════════════════════════════════════════════════════
           BOTTOM ROW (top products + right col)
        ══════════════════════════════════════════════════════════ */
        .bottom-row {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 18px;
        }
        .right-col { display: flex; flex-direction: column; gap: 18px; }

        /* Table */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            font-size: 10.5px; font-weight: 700;
            color: var(--muted); text-transform: uppercase;
            letter-spacing: .8px; padding: 0 0 12px;
            text-align: left; border-bottom: 1px solid var(--border);
        }
        .data-table td {
            padding: 12px 0; font-size: 13px;
            color: var(--text); border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tbody tr { transition: background .15s; }
        .data-table tbody tr:hover td { background: var(--primary-pale); }
        .prod-info { display: flex; align-items: center; gap: 10px; }
        .prod-thumb {
            width: 38px; height: 38px; border-radius: 10px;
            background: var(--primary-pale); overflow: hidden;
            flex-shrink: 0; display: flex; align-items: center; justify-content: center;
            color: var(--primary);
        }
        .prod-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .prod-name { font-weight: 600; font-size: 13px; }
        .prod-cat  { font-size: 11px; color: var(--muted); font-weight: 400; }
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 11px; font-weight: 600;
            padding: 3px 10px; border-radius: 20px;
        }
        .badge-green  { background: var(--green-pale);   color: var(--green-dark); }
        .badge-amber  { background: var(--amber-pale);   color: var(--amber); }
        .badge-red    { background: var(--red-pale);     color: var(--red); }
        .badge-blue   { background: var(--primary-pale); color: var(--primary); }
        .badge-cyan   { background: var(--cyan-pale);    color: var(--cyan); }
        .badge-pink   { background: var(--accent-pale);  color: var(--accent); }
        .badge-gray   { background: #f1f5f9;             color: var(--muted); }

        /* Recent Orders list */
        .order-list { list-style: none; }
        .order-item {
            display: flex; align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
            gap: 10px;
        }
        .order-item:last-child { border-bottom: none; }
        .order-avatar {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-pale), var(--cyan-pale));
            display: flex; align-items: center; justify-content: center;
            color: var(--primary); font-weight: 700; font-size: 13px;
            flex-shrink: 0;
        }
        .order-info { flex: 1; min-width: 0; }
        .order-name { font-size: 13px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .order-meta { font-size: 11px; color: var(--muted); margin-top: 1px; }

        /* ── Quick Actions ────────────────────────────────────────────────── */
        .quick-actions-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .qa-btn {
            display: flex; flex-direction: column;
            align-items: flex-start; gap: 8px;
            padding: 16px 14px;
            border-radius: 12px;
            background: var(--body-bg);
            border: 1.5px solid var(--border);
            font-family: inherit; cursor: pointer;
            transition: all .2s; text-align: left;
            text-decoration: none;
        }
        .qa-btn:hover {
            border-color: var(--primary);
            background: var(--primary-pale);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(67,97,238,.12);
        }
        .qa-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .qa-icon svg { width: 17px; height: 17px; }
        .qa-label { font-size: 12.5px; font-weight: 600; color: var(--text); line-height: 1.2; }
        .qa-sub { font-size: 10.5px; color: var(--muted); font-weight: 400; }

        /* ══════════════════════════════════════════════════════════
           ANIMATIONS
        ══════════════════════════════════════════════════════════ */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim-1 { animation: fadeUp .45s .00s ease both; }
        .anim-2 { animation: fadeUp .45s .07s ease both; }
        .anim-3 { animation: fadeUp .45s .14s ease both; }
        .anim-4 { animation: fadeUp .45s .21s ease both; }
        .anim-5 { animation: fadeUp .45s .28s ease both; }
        .anim-6 { animation: fadeUp .45s .35s ease both; }

        /* ── Responsive ───────────────────────────────────────────────────── */
        @media (max-width: 1280px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .charts-row { grid-template-columns: 1fr; }
        }
        @media (max-width: 960px) {
            .bottom-row { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; }
            .stat-grid { grid-template-columns: 1fr 1fr; }
            .main-content { padding: 20px 16px; }
        }

        /* Dropdown Notifikasi */
        .notif-dropdown-menu {
            position: absolute;
            top: 48px;
            right: 0;
            width: 320px;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            z-index: 1000;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            animation: slideDown 0.25s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .notif-dropdown-header {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            background: #f8fafc;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }
        .notif-dropdown-header .mark-all-btn {
            background: none;
            border: none;
            color: var(--primary);
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            padding: 2px 6px;
            border-radius: 4px;
            transition: background 0.2s;
        }
        .notif-dropdown-header .mark-all-btn:hover {
            background: var(--primary-pale);
        }
        .notif-dropdown-body {
            max-height: 280px;
            overflow-y: auto;
        }
        .notif-item {
            display: flex;
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            text-decoration: none;
            color: var(--text);
            transition: background 0.2s;
        }
        .notif-item:hover {
            background: #f8fafc;
        }
        .notif-item:last-child {
            border-bottom: none;
        }
        .notif-item-icon {
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .icon-badge {
            font-size: 16px;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            border-radius: 8px;
        }
        .notif-item-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .notif-text {
            font-size: 12px;
            font-weight: 500;
            line-height: 1.4;
            margin: 0;
            color: #334155;
            text-align: left;
        }
        .notif-time {
            font-size: 10px;
            color: var(--muted);
            text-align: left;
        }
        .notif-empty {
            padding: 24px;
            text-align: center;
            color: var(--muted);
            font-size: 13px;
        }
    </style>

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
                <div class="brand-sub">Admin Panel</div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">

            <div class="nav-group-label">Menu Utama</div>

            <a href="{{ route('admin.dashboard') }}" id="nav-dashboard" class="nav-item active">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Overview
            </a>

            <a href="{{ route('shop.index') }}" class="nav-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Lihat Toko
            </a>

            <a href="{{ route('shop.index', ['edit_banners' => 'true']) }}" class="nav-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Tambah Banner
            </a>

            <div class="nav-group-label">Manajemen Toko</div>

            <a href="{{ route('products.index') }}" id="nav-products" class="nav-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Produk
            </a>

            <a href="{{ route('categories.index') }}" id="nav-categories" class="nav-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Kategori
            </a>

            <a href="{{ route('admin.orders') }}" id="nav-orders" class="nav-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Pesanan
                @if($pendingOrders > 0)
                    <span class="nav-badge">{{ $pendingOrders }}</span>
                @endif
            </a>

            <a href="{{ route('admin.chats') }}" id="nav-chats" class="nav-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Chat Pelanggan
                @php
                    $unreadChats = \App\Models\ChatMessage::where('is_read', false)
                        ->whereHas('sender', function($q) { $q->where('role', 'user'); })
                        ->count();
                @endphp
                @if($unreadChats > 0)
                    <span class="nav-badge">{{ $unreadChats }}</span>
                @endif
            </a>

            <div class="nav-group-label">Laporan</div>

            <a href="{{ route('admin.orders.report') }}" id="nav-report" class="nav-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Laporan Penjualan
            </a>

            <a href="{{ route('admin.banners.index') }}" id="nav-banners" class="nav-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Manajemen Banner
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
                <button type="submit" class="nav-item" style="width:100%;">
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
                    <div class="sidebar-user-role">Administrator</div>
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
                <div class="topbar-sub">Informasi detail tentang toko kamu</div>
            </div>
            <div class="topbar-right">
                <div class="search-wrap">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                    <input type="text" placeholder="Cari produk, pesanan…" id="topbar-search">
                </div>

                <div class="notif-dropdown-wrapper" style="position: relative; z-index: 1001;">
                    <button class="topbar-btn" id="notif-bell-btn" title="Notifikasi" style="cursor: pointer; position: relative;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if($pendingOrders > 0) <span class="notif-dot"></span> @endif
                    </button>
                    
                    <div class="notif-dropdown-menu" id="notif-dropdown-menu" style="display: none;">
                        <div class="notif-dropdown-header">
                            <span>Notifikasi ({{ $pendingOrders }})</span>
                            @if($pendingOrders > 0)
                                <form action="{{ route('admin.orders.mark_all_read') }}" method="POST" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="mark-all-btn">Tandai semua dibaca</button>
                                </form>
                            @endif
                        </div>
                        <div class="notif-dropdown-body">
                            @forelse($unreadNotifications as $notif)
                                <a href="{{ route('admin.order.read', $notif->id) }}" class="notif-item">
                                    <div class="notif-item-icon">
                                        @if($notif->status == 'canceled')
                                            <span class="icon-badge badge-red">❌</span>
                                        @elseif($notif->status == 'waiting')
                                            <span class="icon-badge badge-amber">💳</span>
                                        @else
                                            <span class="icon-badge badge-blue">📦</span>
                                        @endif
                                    </div>
                                    <div class="notif-item-content">
                                        <p class="notif-text">
                                            @if($notif->status == 'canceled')
                                                Pesanan #{{ $notif->id }} dibatalkan oleh pembeli ({{ $notif->user->name ?? 'User' }})
                                            @elseif($notif->status == 'waiting')
                                                Pembayaran pesanan #{{ $notif->id }} menunggu verifikasi ({{ $notif->user->name ?? 'User' }})
                                            @else
                                                Pesanan baru #{{ $notif->id }} dibuat oleh {{ $notif->user->name ?? 'User' }}
                                            @endif
                                        </p>
                                        <span class="notif-time">{{ $notif->updated_at->diffForHumans() }}</span>
                                    </div>
                                </a>
                            @empty
                                <div class="notif-empty">
                                    <p>Tidak ada notifikasi baru</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="topbar-user-pill">
                    @if(auth()->user()->avatar)
                        <img class="topbar-avatar-sm" src="{{ asset('storage/' . auth()->user()->avatar) }}" style="object-fit: cover;">
                    @else
                        <div class="topbar-avatar-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    @endif
                    <div class="topbar-user-info">
                        <div class="u-name">{{ auth()->user()->name }}</div>
                        <div class="u-role">Admin</div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="main-content">

            {{-- ══ STAT CARDS ══ --}}
            <div class="stat-grid">

                {{-- Total Pendapatan --}}
                <div class="stat-card c-blue anim-1">
                    <div class="stat-icon-wrap ic-blue">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="stat-body">
                        <div class="stat-label">Total Pendapatan</div>
                        <div class="stat-value" style="font-size:18px;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                        <div class="stat-footer">
                            <span class="stat-pill pill-green">
                                <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                </svg>
                                Kumulatif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Pesanan Menunggu --}}
                <div class="stat-card c-amber anim-2">
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
                            <a href="{{ route('admin.orders') }}" class="stat-pill pill-amber" style="text-decoration:none;">
                                Lihat Semua →
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Pesanan Selesai --}}
                <div class="stat-card c-green anim-3">
                    <div class="stat-icon-wrap ic-green">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="stat-body">
                        <div class="stat-label">PO Selesai</div>
                        <div class="stat-value">{{ $completedOrders }}</div>
                        <div class="stat-footer">
                            <span class="stat-pill pill-green">Completed</span>
                        </div>
                    </div>
                </div>

                {{-- Total Produk + Pelanggan --}}
                <div class="stat-card c-pink anim-4">
                    <div class="stat-icon-wrap ic-pink">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="stat-body">
                        <div class="stat-label">Total Pelanggan</div>
                        <div class="stat-value">{{ $totalCustomers }}</div>
                        <div class="stat-footer">
                            <span class="stat-pill pill-pink">{{ $totalProducts }} Produk</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ══ CHARTS ROW ══ --}}
            <div class="charts-row">

                {{-- Revenue Line Chart --}}
                <div class="card anim-5">
                    <div class="card-header">
                        <div>
                            <div class="chart-hero-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                            <div class="card-title" style="font-size:13px;font-weight:500;color:var(--muted);">Pendapatan bulan ini</div>
                        </div>
                        <a href="{{ route('admin.orders.report') }}" class="card-action">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Lihat Laporan
                        </a>
                    </div>
                    <div style="font-size:11px;color:var(--muted);margin-bottom:14px;font-weight:500;">
                        📈 Grafik pendapatan 6 bulan terakhir (Pesanan Paid / Shipped / Completed)
                    </div>
                    <div class="chart-canvas-wrap">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                {{-- Order Status Doughnut --}}
                <div class="card anim-5">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Status Pesanan</div>
                            <div class="card-sub">Distribusi semua pesanan</div>
                        </div>
                    </div>

                    <div class="doughnut-wrap">
                        <canvas id="statusChart"></canvas>
                        <div class="doughnut-center">
                            @php $totalOrders = array_sum($orderStatuses); @endphp
                            <div class="doughnut-center-num">{{ $totalOrders }}</div>
                            <div class="doughnut-center-label">Total</div>
                        </div>
                    </div>

                    <div class="status-legend">
                        @php
                            $statusColors = [
                                'pending'   => ['label' => 'Menunggu Bayar',         'color' => '#ff9f1c'],
                                'pre_order' => ['label' => 'Pre-Order',              'color' => '#7b2ff7'],
                                'waiting'   => ['label' => 'Verif. Pembayaran',      'color' => '#4361ee'],
                                'paid'      => ['label' => 'Dikonfirmasi',           'color' => '#06d6a0'],
                                'shipped'   => ['label' => 'Dalam Pengiriman',       'color' => '#4cc9f0'],
                                'completed' => ['label' => 'Selesai',               'color' => '#06d6a0'],
                                'canceled'  => ['label' => 'Dibatalkan',            'color' => '#ef233c'],
                            ];
                        @endphp
                        @foreach($orderStatuses as $status => $count)
                            @php $cfg = $statusColors[$status] ?? ['label' => ucfirst($status), 'color' => '#9898b0']; @endphp
                            <div class="legend-item">
                                <div class="legend-left">
                                    <div class="legend-dot" style="background:{{ $cfg['color'] }}"></div>
                                    <span class="legend-label">{{ $cfg['label'] }}</span>
                                </div>
                                <span class="legend-count">{{ $count }}</span>
                            </div>
                        @endforeach
                        @if(empty($orderStatuses))
                            <div class="legend-item" style="color:var(--muted);">Belum ada pesanan.</div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- ══ BOTTOM ROW ══ --}}
            <div class="bottom-row">

                {{-- Top Products Table --}}
                <div class="card anim-6">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Produk Terlaris</div>
                            <div class="card-sub">Berdasarkan total terjual di pesanan selesai</div>
                        </div>
                        <a href="{{ route('products.index') }}" class="card-action">Kelola Produk</a>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Terjual</th>
                                <th>Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $item)
                                <tr>
                                    <td>
                                        <div class="prod-info">
                                            <div class="prod-thumb">
                                                @if($item->product && $item->product->image_path)
                                                    <img src="{{ $item->product->imageUrl() }}" alt="{{ $item->product->name }}">
                                                @else
                                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="prod-name">{{ $item->product->name ?? 'Produk dihapus' }}</div>
                                                <div class="prod-cat">{{ $item->product->category->name ?? '—' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><strong>{{ $item->total_qty }}</strong> <span style="color:var(--muted);font-size:11px;">pcs</span></td>
                                    <td style="font-weight:600;">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align:center;color:var(--muted);padding:30px 0;">
                                        Belum ada data penjualan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Right Column --}}
                <div class="right-col">

                    {{-- Pesanan Terbaru --}}
                    <div class="card anim-6">
                        <div class="card-header">
                            <div>
                                <div class="card-title">Pesanan Terbaru</div>
                                <div class="card-sub">5 pesanan terakhir masuk</div>
                            </div>
                            <a href="{{ route('admin.orders') }}" class="card-action">Semua →</a>
                        </div>
                        <ul class="order-list">
                            @forelse($recentOrders as $order)
                                @php
                                    $badgeClass = match($order->status) {
                                        'completed'              => 'badge-green',
                                        'shipped'                => 'badge-cyan',
                                        'paid'                   => 'badge-blue',
                                        'waiting'                => 'badge-blue',
                                        'pending', 'pre_order'   => 'badge-amber',
                                        'canceled'               => 'badge-red',
                                        default                  => 'badge-gray',
                                    };
                                @endphp
                                <li class="order-item">
                                    <div class="order-avatar">
                                        {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="order-info">
                                        <div class="order-name">{{ $order->user->name ?? 'Pengguna' }}</div>
                                        <div class="order-meta">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                            · {{ $order->created_at->format('d M') }}
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.order.detail', $order->id) }}">
                                        <span class="badge {{ $badgeClass }}">{{ $order->statusIndo() }}</span>
                                    </a>
                                </li>
                            @empty
                                <li style="text-align:center;color:var(--muted);padding:20px 0;font-size:13px;">
                                    Belum ada pesanan.
                                </li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="card anim-6">
                        <div class="card-title" style="margin-bottom:4px;">Aksi Cepat</div>
                        <div class="card-sub" style="margin-bottom:16px;">Shortcut fitur admin</div>
                        <div class="quick-actions-grid">

                            <a href="{{ route('products.create') }}" class="qa-btn">
                                <div class="qa-icon ic-blue">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div class="qa-label">Tambah Produk</div>
                                <div class="qa-sub">Upload koleksi baru</div>
                            </a>

                            <a href="{{ route('admin.orders') }}" class="qa-btn">
                                <div class="qa-icon ic-amber">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <div class="qa-label">Kelola Pesanan</div>
                                <div class="qa-sub">Verifikasi pembayaran</div>
                            </a>

                            <a href="{{ route('categories.create') }}" class="qa-btn">
                                <div class="qa-icon ic-green">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <div class="qa-label">Tambah Kategori</div>
                                <div class="qa-sub">Buat kategori baru</div>
                            </a>

                            <a href="{{ route('admin.orders.report') }}" class="qa-btn">
                                <div class="qa-icon ic-pink">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="qa-label">Cetak Laporan</div>
                                <div class="qa-sub">Export data pesanan</div>
                            </a>

                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════
     CHART.JS SCRIPTS
════════════════════════════════════════════════════════ --}}
@php
    $statusCfg = [
        'pending'   => ['label' => 'Menunggu Bayar',       'color' => '#ff9f1c'],
        'pre_order' => ['label' => 'Pre-Order',            'color' => '#7b2ff7'],
        'waiting'   => ['label' => 'Verif. Pembayaran',    'color' => '#4361ee'],
        'paid'      => ['label' => 'Dikonfirmasi',         'color' => '#06d6a0'],
        'shipped'   => ['label' => 'Pengiriman',           'color' => '#4cc9f0'],
        'completed' => ['label' => 'Selesai',              'color' => '#06d6a0'],
        'canceled'  => ['label' => 'Dibatalkan',           'color' => '#ef233c'],
    ];
    $chartLabels = [];
    $chartValues = [];
    $chartColors = [];
    foreach($orderStatuses as $s => $c) {
        $chartLabels[] = $statusCfg[$s]['label'] ?? ucfirst($s);
        $chartValues[] = $c;
        $chartColors[] = $statusCfg[$s]['color'] ?? '#9898b0';
    }
    if(empty($orderStatuses)) {
        $chartLabels = ['Belum ada data'];
        $chartValues = [1];
        $chartColors = ['#ebebf5'];
    }
@endphp

<script>
function initDashboardCharts() {
    // ── Revenue Line Chart ─────────────────────────────────────────────────────
    const revenueLabels = @json($revenueLabels);
    const revenueData   = @json($revenueData);

    const revenueCanvas = document.getElementById('revenueChart');
    if (!revenueCanvas) return;
    const revenueCtx = revenueCanvas.getContext('2d');

    const gradRevenue = revenueCtx.createLinearGradient(0, 0, 0, 200);
    gradRevenue.addColorStop(0,   'rgba(67,97,238,.28)');
    gradRevenue.addColorStop(0.6, 'rgba(67,97,238,.06)');
    gradRevenue.addColorStop(1,   'rgba(67,97,238,0)');

    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: revenueData,
                borderColor: '#4361ee',
                borderWidth: 2.5,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4361ee',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#4361ee',
                backgroundColor: gradRevenue,
                fill: true,
                tension: 0.42,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1a2e',
                    titleFont: { family: 'Inter', size: 12, weight: '600' },
                    bodyFont: { family: 'Inter', size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: ctx => ' Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        font: { family: 'Inter', size: 11 },
                        color: '#9898b0',
                        padding: 8,
                    }
                },
                y: {
                    grid: { color: '#ebebf5', drawTicks: false },
                    border: { display: false, dash: [4, 4] },
                    ticks: {
                        font: { family: 'Inter', size: 11 },
                        color: '#9898b0',
                        padding: 12,
                        callback: v => v >= 1000000 ? 'Rp ' + (v/1000000).toFixed(1) + 'jt' : (v === 0 ? '0' : 'Rp ' + v.toLocaleString('id-ID'))
                    }
                }
            }
        }
    });

    // ── Status Doughnut Chart ──────────────────────────────────────────────────
    const statusCanvas = document.getElementById('statusChart');
    if (!statusCanvas) return;
    const statusCtx = statusCanvas.getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                data: @json($chartValues),
                backgroundColor: @json($chartColors),
                borderWidth: 3,
                borderColor: '#ffffff',
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '74%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1a2e',
                    titleFont: { family: 'Inter', size: 12, weight: '600' },
                    bodyFont: { family: 'Inter', size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: ctx => ' ' + ctx.label + ': ' + ctx.parsed + ' pesanan'
                    }
                }
            }
        }
    });
}

// Ensure Chart.js is loaded before running initialization logic
if (typeof Chart === 'undefined') {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js';
    script.onload = initDashboardCharts;
    document.body.appendChild(script);
} else {
    initDashboardCharts();
}
</script>

<script src="{{ asset('/js/smooth-navigation.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bellBtn = document.getElementById('notif-bell-btn');
    const dropdownMenu = document.getElementById('notif-dropdown-menu');

    if (bellBtn && dropdownMenu) {
        bellBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (dropdownMenu.style.display === 'none') {
                dropdownMenu.style.display = 'flex';
            } else {
                dropdownMenu.style.display = 'none';
            }
        });

        document.addEventListener('click', function(e) {
            if (!dropdownMenu.contains(e.target) && e.target !== bellBtn && !bellBtn.contains(e.target)) {
                dropdownMenu.style.display = 'none';
            }
        });
    }
});
</script>


</body>
</html>
