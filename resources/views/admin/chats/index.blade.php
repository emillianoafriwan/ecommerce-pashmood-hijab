<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Chat Pelanggan - Admin PASHMOOD</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    @include('partials.theme-loader')

    <style>
        :root {
            --primary:        #e11d48; /* rose-600 */
            --primary-dark:   #be123c; /* rose-700 */
            --primary-light:  #f43f5e; /* rose-500 */
            --primary-pale:   #fff1f2; /* rose-50 */
            --sidebar-w:      260px;
            --sidebar-bg:     #ffffff;
            --topbar-h:       68px;
            --text:           #1e293b; /* slate-800 */
            --text-soft:      #475569; /* slate-600 */
            --muted:          #94a3b8; /* slate-400 */
            --border:         #f1f5f9; /* slate-100 */
            --card-bg:        #ffffff;
            --body-bg:        #f8fafc; /* slate-50 */
            --radius:         16px;
            --shadow:         0 2px 8px rgba(225,29,72,.06), 0 0 0 1px rgba(0,0,0,.02);
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--body-bg);
            color: var(--text);
            margin: 0; padding: 0;
        }

        a { text-decoration: none; color: inherit; }
        button { font-family: inherit; cursor: pointer; border: none; background: none; }

        /* Layout */
        .layout { display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            border-right: 1px solid var(--border);
        }

        .sidebar-brand {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--border);
        }

        .brand-logo {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--primary), #be123c);
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

        .sidebar-nav { padding: 18px 14px; flex: 1; overflow-y: auto; }
        .nav-group-label {
            font-size: 9px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 18px 10px 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-soft);
            transition: all .2s ease;
            margin-bottom: 4px;
        }

        .nav-item svg { width: 18px; height: 18px; color: var(--muted); transition: color .2s; }
        .nav-item:hover {
            background: var(--border);
            color: var(--text);
        }
        .nav-item:hover svg { color: var(--text-soft); }

        .nav-item.active {
            background: var(--primary-pale);
            color: var(--primary);
        }
        .nav-item.active svg { color: var(--primary); }

        .nav-badge {
            margin-left: auto;
            background: var(--primary);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
        }

        /* Topbar */
        .topbar {
            height: var(--topbar-h);
            background: #ffffff;
            border-bottom: 1px solid var(--border);
            position: fixed;
            top: 0; left: var(--sidebar-w); right: 0;
            z-index: 90;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        /* Main Container */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            padding-top: var(--topbar-h);
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .chat-container {
            display: flex;
            flex: 1;
            background: #fff;
            overflow: hidden;
        }

        /* Message Scroll Styling */
        .custom-scroll::-webkit-scrollbar { width: 5px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body>

    <div class="layout">
        
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="brand-logo">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 3l14 9-14 9V3z"/>
                    </svg>
                </div>
                <div class="brand-text">
                    <div class="brand-name">PASHMOOD</div>
                    <div class="brand-sub">Admin Panel</div>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-group-label">Menu Utama</div>
                
                <a href="{{ route('admin.dashboard') }}" id="nav-dashboard" class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Overview
                </a>

                <a href="{{ route('shop.index') }}" class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Lihat Toko
                </a>

                <a href="{{ route('shop.index', ['edit_banners' => 'true']) }}" class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Tambah Banner
                </a>

                <div class="nav-group-label">Manajemen Toko</div>
                
                <a href="{{ route('products.index') }}" id="nav-products" class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Produk
                </a>

                <a href="{{ route('categories.index') }}" id="nav-categories" class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Kategori
                </a>

                <a href="{{ route('admin.orders') }}" id="nav-orders" class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Pesanan
                </a>

                <a href="{{ route('admin.chats') }}" id="nav-chats" class="nav-item active">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Chat Pelanggan
                    @php
                        $unreadChats = \App\Models\ChatMessage::where('is_read', false)
                            ->whereHas('sender', function($q) { $q->where('role', 'user'); })
                            ->count();
                    @endphp
                    @if($unreadChats > 0)
                        <span id="unread-chats-sidebar-badge" class="nav-badge">{{ $unreadChats }}</span>
                    @endif
                </a>

                <div class="nav-group-label">Laporan</div>
                <a href="{{ route('admin.orders.report') }}" id="nav-report" class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Laporan Penjualan
                </a>

                <a href="{{ route('admin.banners.index') }}" id="nav-banners" class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Manajemen Banner
                </a>
            </nav>
        </aside>

        <!-- MAIN WRAPPER -->
        <div class="main-wrapper">
            
            <!-- TOPBAR -->
            <header class="topbar">
                <div class="text-sm font-bold text-slate-400">Dashboard / <span class="text-slate-800 font-extrabold">Chat Pelanggan</span></div>
                
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3 bg-slate-50 px-4 py-2 rounded-full border border-slate-100">
                        @if(auth()->user()->avatar)
                            <img class="w-8 h-8 rounded-full object-cover border border-white" src="{{ asset('storage/' . auth()->user()->avatar) }}">
                        @else
                            <div class="w-8 h-8 rounded-full bg-rose-600 text-white flex items-center justify-center font-bold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        @endif
                        <div class="text-left leading-none">
                            <p class="text-xs font-black text-slate-800">{{ auth()->user()->name }}</p>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Admin</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- CHAT AREA -->
            <div class="chat-container">
                
                <!-- Users list panel (Left) -->
                <div class="w-[320px] border-r border-slate-100 flex flex-col bg-white">
                    <div class="p-5 border-b border-slate-100">
                        <h4 class="text-sm font-extrabold text-slate-800 tracking-tight mb-1">Daftar Obrolan</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Pelanggan Aktif</p>
                    </div>
                    <div id="users-list" class="flex-1 overflow-y-auto custom-scroll p-3 space-y-2">
                        <!-- User items populated dynamically -->
                        <div class="text-center py-10 text-slate-400 text-xs font-medium">Memuat obrolan...</div>
                    </div>
                </div>

                <!-- Chat room details (Right) -->
                <div id="chat-room" class="flex-1 flex flex-col bg-slate-50/50">
                    <!-- Default state (No active user selected) -->
                    <div id="chat-empty-state" class="flex-grow flex flex-col items-center justify-center text-center p-8 space-y-4">
                        <div class="w-16 h-16 bg-white rounded-3xl flex items-center justify-center text-rose-500 shadow-sm border border-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-800 mb-1">Pilih Pelanggan</h3>
                            <p class="text-xs text-slate-400 max-w-xs font-medium leading-relaxed">Pilih salah satu obrolan pelanggan di sebelah kiri untuk melihat pesan dan membalas keluhan.</p>
                        </div>
                    </div>

                    <!-- Active chat screen (Hidden by default) -->
                    <div id="chat-active-state" class="hidden flex-grow flex flex-col h-full overflow-hidden">
                        
                        <!-- Header -->
                        <div class="px-6 py-4 bg-white border-b border-slate-100 flex items-center gap-3 shadow-sm shrink-0">
                            <div id="active-user-avatar" class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center font-black text-base shrink-0"></div>
                            <div>
                                <h4 id="active-user-name" class="font-extrabold text-sm text-slate-800 leading-none mb-1"></h4>
                                <p class="text-[9px] text-emerald-500 font-bold uppercase tracking-wider flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                    Terhubung
                                </p>
                            </div>
                        </div>

                        <!-- Messages timeline -->
                        <div id="messages-container" class="flex-grow p-6 overflow-y-auto custom-scroll space-y-4">
                            <!-- Messages populated dynamically -->
                        </div>

                        <!-- Footer Input -->
                        <form id="message-form" data-no-ajax="true" class="p-4 bg-white border-t border-slate-100 flex items-center gap-3 shrink-0">
                            <input type="text" id="message-input" autocomplete="off" placeholder="Tulis balasan pesan untuk pelanggan..." class="flex-grow px-5 py-3.5 bg-slate-50 focus:bg-white border border-transparent focus:border-rose-300 rounded-2xl text-xs font-semibold focus:outline-none transition duration-300">
                            <button type="submit" class="px-6 py-3.5 bg-slate-900 hover:bg-rose-600 text-white rounded-2xl text-xs font-black uppercase tracking-wider shadow-lg hover:shadow-rose-100 transition duration-300 flex items-center gap-2">
                                Kirim
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </button>
                        </form>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Scripts -->
    <script>
        (function () {
            const usersContainer = document.getElementById('users-list');
            const chatEmptyState = document.getElementById('chat-empty-state');
            const chatActiveState = document.getElementById('chat-active-state');
            
            const activeUserAvatar = document.getElementById('active-user-avatar');
            const activeUserName = document.getElementById('active-user-name');
            const messagesContainer = document.getElementById('messages-container');
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');
            const sidebarBadge = document.getElementById('unread-chats-sidebar-badge');

            let activeUserId = null;
            let lastMessageId = 0;
            let pollingActiveChat = null;
            let pollingUsersList = null;

            // Load user lists on start
            loadUsersList();
            
            // Poll user list every 4 seconds to get updates, unread count and snippets
            pollingUsersList = setInterval(loadUsersList, 4000);

            // Handle user click
            usersContainer.addEventListener('click', (e) => {
                const item = e.target.closest('.user-item');
                if (!item) return;

                const userId = item.dataset.userId;
                const userName = item.dataset.userName;
                const userInitial = item.dataset.userInitial;
                const userAvatar = item.dataset.userAvatar;

                selectUser(userId, userName, userInitial, userAvatar);
            });

            // Handle form send
            messageForm.addEventListener('submit', (e) => {
                e.preventDefault();
                if (!activeUserId) return;

                const text = messageInput.value.trim();
                if (!text) return;

                messageInput.value = '';

                fetch(`/admin/api/admin/chats/${activeUserId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: text })
                })
                .then(res => res.json())
                .then(message => {
                    if (message.id > lastMessageId) {
                        lastMessageId = message.id;
                    }
                    appendMessage(message);
                    scrollToBottom();
                    loadUsersList(); // Update snippet instantly
                })
                .catch(err => console.error('Gagal mengirim pesan:', err));
            });

            function loadUsersList() {
                fetch('{{ route("admin.chats.users") }}')
                    .then(res => res.json())
                    .then(users => {
                        if (users.length === 0) {
                            usersContainer.innerHTML = `
                                <div class="text-center py-10 text-slate-400 text-xs font-semibold">Tidak ada chat masuk</div>
                            `;
                            if (sidebarBadge) sidebarBadge.style.display = 'none';
                            return;
                        }

                        let html = '';
                        let totalUnread = 0;

                        users.forEach(u => {
                            totalUnread += u.unread_count;
                            const isActive = activeUserId == u.id ? 'bg-rose-50/60 border-rose-100/50' : 'hover:bg-slate-50 border-transparent';
                            const activeBorder = activeUserId == u.id ? 'border-rose-100' : '';
                            const unreadHtml = u.unread_count > 0 
                                ? `<span class="bg-rose-600 text-white font-extrabold text-[10px] px-2 py-0.5 rounded-full shrink-0">${u.unread_count}</span>` 
                                : '';
                            
                            const avatarHtml = u.avatar 
                                ? `<img src="${u.avatar}" class="w-10 h-10 object-cover rounded-xl shrink-0">`
                                : `<div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm shrink-0">${u.avatar_initial}</div>`;

                            html += `
                                <div class="user-item p-4 rounded-2xl border ${isActive} transition cursor-pointer flex gap-3.5 items-center" 
                                     data-user-id="${u.id}" 
                                     data-user-name="${u.name}"
                                     data-user-initial="${u.avatar_initial}"
                                     data-user-avatar="${u.avatar || ''}">
                                    ${avatarHtml}
                                    <div class="flex-grow min-w-0 text-left">
                                        <div class="flex justify-between items-center gap-2 mb-1">
                                            <h5 class="text-xs font-black text-slate-800 truncate">${u.name}</h5>
                                            <span class="text-[9px] font-bold text-slate-400 whitespace-nowrap">${u.latest_message_time}</span>
                                        </div>
                                        <p class="text-[10px] font-semibold text-slate-500 truncate leading-normal">${u.latest_message || 'Lampiran kartu'}</p>
                                    </div>
                                    ${unreadHtml}
                                </div>
                            `;
                        });

                        usersContainer.innerHTML = html;

                        // Sync sidebar badge
                        if (sidebarBadge) {
                            if (totalUnread > 0) {
                                sidebarBadge.innerText = totalUnread;
                                sidebarBadge.style.display = 'inline-block';
                            } else {
                                sidebarBadge.style.display = 'none';
                            }
                        }
                    })
                    .catch(err => console.error('Gagal memuat list user:', err));
            }

            function selectUser(userId, userName, userInitial, userAvatar) {
                // Switch states
                activeUserId = userId;
                chatEmptyState.classList.add('hidden');
                chatActiveState.classList.remove('hidden');

                // Header info
                if (userAvatar) {
                    activeUserAvatar.innerHTML = `<img src="${userAvatar}" class="w-full h-full object-cover rounded-2xl">`;
                } else {
                    activeUserAvatar.innerHTML = userInitial;
                }
                activeUserName.innerText = userName;

                // Load messages
                messagesContainer.innerHTML = '<div class="text-center py-10 text-slate-400 text-xs font-semibold">Memuat riwayat chat...</div>';
                
                // Clear any running active chat polling
                if (pollingActiveChat) {
                    clearInterval(pollingActiveChat);
                }

                // Fetch history
                fetchMessages();

                // Setup polling for the selected chat room
                pollingActiveChat = setInterval(pollMessages, 2500);

                // Mark messages as read on click
                markAsRead(userId);

                // Highlight item in sidebar
                document.querySelectorAll('.user-item').forEach(el => {
                    if (el.dataset.userId == userId) {
                        el.className = 'user-item p-4 rounded-2xl border bg-rose-50/60 border-rose-100/50 transition cursor-pointer flex gap-3.5 items-center';
                        // Remove unread bubble instantly
                        const badge = el.querySelector('.bg-rose-600');
                        if (badge) badge.remove();
                    } else {
                        el.className = 'user-item p-4 rounded-2xl border hover:bg-slate-50 border-transparent transition cursor-pointer flex gap-3.5 items-center';
                    }
                });
            }

            function fetchMessages() {
                fetch(`/admin/api/admin/chats/${activeUserId}`)
                    .then(res => res.json())
                    .then(messages => {
                        messagesContainer.innerHTML = '';
                        lastMessageId = 0;
                        
                        if (messages.length === 0) {
                            messagesContainer.innerHTML = '<div id="chat-empty-placeholder" class="text-center py-20 text-slate-400 text-xs font-semibold">Belum ada obrolan</div>';
                        } else {
                            messages.forEach(msg => {
                                appendMessage(msg);
                                if (msg.id > lastMessageId) {
                                    lastMessageId = msg.id;
                                }
                            });
                            scrollToBottom();
                        }
                    })
                    .catch(err => console.error('Gagal memuat detail chat:', err));
            }

            function pollMessages() {
                if (!activeUserId) return;
                fetch(`/admin/api/admin/chats/${activeUserId}`)
                    .then(res => res.json())
                    .then(messages => {
                        let hasNew = false;
                        messages.forEach(msg => {
                            if (msg.id > lastMessageId) {
                                appendMessage(msg);
                                lastMessageId = msg.id;
                                hasNew = true;
                            }
                        });

                        if (hasNew) {
                            scrollToBottom();
                            markAsRead(activeUserId);
                        }
                    })
                    .catch(err => console.error('Gagal polling chat room:', err));
            }

            function markAsRead(userId) {
                fetch(`/admin/api/admin/chats/${userId}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.json())
                .then(() => {
                    loadUsersList(); // Reload lists to refresh unread count
                })
                .catch(err => console.error('Gagal read status:', err));
            }

            function appendMessage(msg) {
                // Clear initial placeholder
                const placeholder = messagesContainer.querySelector('#chat-empty-placeholder');
                if (placeholder) {
                    messagesContainer.innerHTML = '';
                }

                const rowDiv = document.createElement('div');
                rowDiv.className = `flex ${msg.is_from_admin ? 'justify-end' : 'justify-start'}`;

                // Reference attachment card (Product/Order)
                let attachmentHtml = '';
                if (msg.product) {
                    attachmentHtml = `
                        <div class="mb-2.5 p-3 bg-rose-50 rounded-2xl border border-rose-100 flex gap-3 items-center">
                            <img src="${msg.product.image_url}" class="w-12 h-12 object-cover rounded-xl border border-white shrink-0">
                            <div class="min-w-0 text-left">
                                <p class="text-[9px] font-extrabold text-rose-600 uppercase tracking-widest mb-0.5">Produk Terkait</p>
                                <h5 class="text-xs font-black text-slate-800 truncate mb-0.5">${msg.product.name}</h5>
                                <p class="text-[10px] font-extrabold text-slate-900">${msg.product.price}</p>
                                <a href="${msg.product.url}" target="_blank" class="text-[9px] font-bold text-rose-600 hover:underline flex items-center gap-1 mt-1">
                                    Lihat Detail →
                                </a>
                            </div>
                        </div>
                    `;
                } else if (msg.order) {
                    attachmentHtml = `
                        <div class="mb-2.5 p-3 bg-rose-50 rounded-2xl border border-rose-100 text-left">
                            <div class="flex justify-between items-start gap-4 mb-2">
                                <div>
                                    <p class="text-[9px] font-extrabold text-rose-600 uppercase tracking-widest mb-0.5">Pesanan Terkait</p>
                                    <h5 class="text-xs font-black text-slate-800">#${msg.order.id}</h5>
                                </div>
                                <span class="px-2 py-0.5 text-[8px] font-bold uppercase tracking-wider rounded-full bg-slate-900 text-white">${msg.order.status}</span>
                            </div>
                            <div class="text-[10px] font-semibold text-slate-500 mb-2">
                                Total: <span class="font-extrabold text-slate-900">${msg.order.total_price}</span>
                            </div>
                            <a href="${msg.order.url}" target="_blank" class="text-[9px] font-bold text-rose-600 hover:underline">
                                Detail Transaksi →
                            </a>
                        </div>
                    `;
                }

                const bubbleBg = msg.is_from_admin 
                    ? 'bg-rose-600 text-white rounded-3xl rounded-tr-sm' 
                    : 'bg-white text-slate-800 rounded-3xl rounded-tl-sm border border-slate-100 shadow-sm';
                
                let messageText = '';
                if (msg.message) {
                    if (msg.is_from_admin) {
                        messageText = `<p class="text-xs font-semibold leading-relaxed"><span class="font-black text-rose-200 mr-1.5">Anda:</span>${msg.message}</p>`;
                    } else {
                        messageText = `<p class="text-xs font-semibold leading-relaxed">${msg.message}</p>`;
                    }
                }

                rowDiv.innerHTML = `
                    <div class="max-w-[70%] flex flex-col ${msg.is_from_admin ? 'items-end' : 'items-start'}">
                        <div class="p-4 ${bubbleBg}">
                            ${attachmentHtml}
                            ${messageText}
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 mt-1.5 px-1">${msg.time}</span>
                    </div>
                `;

                messagesContainer.appendChild(rowDiv);
            }

            function scrollToBottom() {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            // Cleanup intervals when page is navigated away from (if smooth navigation is ever enabled)
            window.addEventListener('beforeunload', () => {
                if (pollingUsersList) clearInterval(pollingUsersList);
                if (pollingActiveChat) clearInterval(pollingActiveChat);
            });
        })();
    </script>

    @include('partials.theme-customizer')
</body>
</html>
