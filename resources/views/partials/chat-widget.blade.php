<!-- FLOATING CHAT WIDGET — Hanya untuk pembeli, bukan admin -->
@if(!auth()->check() || auth()->user()->role !== 'admin')
<div id="pashmood-chat-widget" class="fixed bottom-8 right-8 z-50 font-sans">
    <!-- Chat Toggle Button -->
    <button id="chat-toggle-btn" class="w-14 h-14 bg-rose-600 hover:bg-rose-700 text-white rounded-full flex items-center justify-center shadow-[0_10px_30px_rgba(225,29,72,0.3)] hover:-translate-y-1 transition-all duration-300 relative group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform group-hover:scale-110 transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <!-- Unread badge -->
        <span id="chat-unread-badge" class="absolute -top-1 -right-1 bg-slate-950 text-white font-bold text-[10px] w-5 h-5 rounded-full flex items-center justify-center border border-white opacity-0 transition-opacity duration-300">0</span>
    </button>

    <!-- Chat Window (Hidden by default) -->
    <div id="chat-window" class="absolute bottom-[72px] right-0 w-[350px] sm:w-[380px] h-[500px] bg-white/90 backdrop-blur-md rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-rose-100/50 flex flex-col overflow-hidden opacity-0 translate-y-8 pointer-events-none transition-all duration-300">
        
        <!-- Chat Header -->
        <div class="p-6 bg-gradient-to-r from-rose-500 to-rose-600 text-white flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-2xl flex items-center justify-center font-black tracking-tighter">PM</div>
                <div>
                    <h3 class="font-extrabold text-sm tracking-tight leading-none mb-1">PASHMOOD Support</h3>
                    <span class="flex items-center gap-1.5 text-[10px] font-medium text-rose-100">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Admin Online
                    </span>
                </div>
            </div>
            <button id="close-chat-btn" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Attachment Panel (Product or Order Context) -->
        <div id="chat-attachment-bar" class="hidden bg-rose-50/80 border-b border-rose-100 px-4 py-2.5 flex items-center justify-between gap-3 transition-all">
            <div class="flex-1 min-w-0 flex items-center gap-2">
                <span class="text-rose-600">
                    <!-- Icon Attachment -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                </span>
                <p id="chat-attachment-label" class="text-xs font-bold text-slate-700 truncate leading-normal"></p>
            </div>
            <button id="clear-attachment-btn" class="text-slate-400 hover:text-rose-600 transition p-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Chat Messages Container -->
        <div id="chat-messages" class="flex-1 p-5 overflow-y-auto space-y-4 scroll-smooth">
            <!-- Messages will load here dynamically -->
        </div>

        <!-- Chat Input Form -->
        <form id="chat-form" data-no-ajax="true" class="p-4 border-t border-slate-100 bg-white flex items-center gap-2">
            <input type="text" id="chat-input" placeholder="Tulis keluhan atau pertanyaan Anda..." class="flex-1 px-4 py-3 rounded-2xl bg-slate-50 border border-transparent focus:border-rose-300 focus:bg-white text-xs font-semibold focus:outline-none transition duration-300">
            <button type="submit" class="w-10 h-10 bg-slate-900 hover:bg-rose-600 text-white rounded-xl flex items-center justify-center shadow-lg transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </form>
    </div>
</div>

<script>
    (function () {
        if (window.pashmoodChatPollInterval) {
            clearInterval(window.pashmoodChatPollInterval);
            window.pashmoodChatPollInterval = null;
        }

        const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
        
        // Context IDs passed from view template
        let attachedProductId = {{ isset($productId) ? $productId : 'null' }};
        let attachedOrderId = {{ isset($orderId) ? $orderId : 'null' }};
        let productContextData = null;
        let orderContextData = null;

        const widget = document.getElementById('pashmood-chat-widget');
        const toggleBtn = document.getElementById('chat-toggle-btn');
        const chatWindow = document.getElementById('chat-window');
        const closeBtn = document.getElementById('close-chat-btn');
        const messageContainer = document.getElementById('chat-messages');
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const unreadBadge = document.getElementById('chat-unread-badge');
        const attachmentBar = document.getElementById('chat-attachment-bar');
        const attachmentLabel = document.getElementById('chat-attachment-label');
        const clearAttachmentBtn = document.getElementById('clear-attachment-btn');

        // Fetch context info if attached initially
        if (attachedProductId) {
            fetchProductContext(attachedProductId);
        } else if (attachedOrderId) {
            fetchOrderContext(attachedOrderId);
        }

        let isChatOpen = false;
        let lastMessageId = 0;

        // Sound effect on new message
        const audioNotification = new Audio('https://assets.mixkit.co/active_storage/sfx/2357/2357-84.wav');
        audioNotification.volume = 0.3;

        // Toggle chat window visibility
        toggleBtn.addEventListener('click', () => {
            if (isChatOpen) {
                closeChat();
            } else {
                openChat();
            }
        });

        closeBtn.addEventListener('click', closeChat);

        // Clear context attachment manually
        clearAttachmentBtn.addEventListener('click', () => {
            attachedProductId = null;
            attachedOrderId = null;
            attachmentBar.classList.add('hidden');
        });

        // Submit form
        chatForm.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!isLoggedIn) return;

            const text = chatInput.value.trim();
            if (!text && !attachedProductId && !attachedOrderId) return;

            const data = {
                message: text,
                product_id: attachedProductId,
                order_id: attachedOrderId
            };

            // Reset input and clear attachment preview instantly
            chatInput.value = '';
            attachmentBar.classList.add('hidden');

            fetch('{{ route("api.chats.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(message => {
                // Clear active context on successful send
                attachedProductId = null;
                attachedOrderId = null;
                
                if (message.id > lastMessageId) {
                    lastMessageId = message.id;
                }
                appendMessage(message);
                scrollToBottom();
            })
            .catch(err => console.error('Gagal mengirim chat:', err));
        });

        function openChat() {
            isChatOpen = true;
            chatWindow.classList.remove('opacity-0', 'translate-y-8', 'pointer-events-none');
            chatWindow.classList.add('opacity-100', 'translate-y-0');
            
            if (!isLoggedIn) {
                renderLoginPrompt();
                return;
            }

            // Mark incoming admin messages as read
            markMessagesAsRead();
            
            // Load messages and start polling
            loadMessages();
            window.pashmoodChatPollInterval = setInterval(pollMessages, 3000);
        }

        function closeChat() {
            isChatOpen = false;
            chatWindow.classList.remove('opacity-100', 'translate-y-0');
            chatWindow.classList.add('opacity-0', 'translate-y-8', 'pointer-events-none');
            
            if (window.pashmoodChatPollInterval) {
                clearInterval(window.pashmoodChatPollInterval);
                window.pashmoodChatPollInterval = null;
            }
        }

        function renderLoginPrompt() {
            messageContainer.innerHTML = `
                <div class="flex flex-col items-center justify-center text-center h-full space-y-6 px-4">
                    <div class="w-16 h-16 bg-rose-50 rounded-3xl flex items-center justify-center text-rose-500 shadow-sm border border-rose-100/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold text-slate-800 mb-2">Yuk, Masuk Akun Dulu!</h4>
                        <p class="text-slate-500 text-xs font-semibold leading-relaxed">Silakan masuk (login) untuk dapat memulai obrolan langsung dengan Customer Service kami.</p>
                    </div>
                    <a href="{{ route('login') }}" class="w-full py-3 bg-slate-900 hover:bg-rose-600 text-white rounded-2xl text-xs font-black uppercase tracking-wider shadow-lg hover:shadow-rose-100 transition duration-300">Masuk Akun</a>
                </div>
            `;
            chatForm.style.display = 'none';
        }

        function loadMessages() {
            fetch('{{ route("api.chats.index") }}')
                .then(res => res.json())
                .then(messages => {
                    messageContainer.innerHTML = '';
                    if (messages.length === 0) {
                        renderEmptyChat();
                    } else {
                        messages.forEach(msg => {
                            appendMessage(msg);
                            if (msg.id > lastMessageId) {
                                lastMessageId = msg.id;
                            }
                        });
                        scrollToBottom();
                    }
                    showInitialAttachmentBar();
                })
                .catch(err => console.error('Gagal memuat pesan:', err));
        }

        function pollMessages() {
            fetch('{{ route("api.chats.index") }}')
                .then(res => res.json())
                .then(messages => {
                    let hasNewMessage = false;
                    messages.forEach(msg => {
                        if (msg.id > lastMessageId) {
                            appendMessage(msg);
                            lastMessageId = msg.id;
                            hasNewMessage = true;
                        }
                    });

                    if (hasNewMessage) {
                        scrollToBottom();
                        // Mark read since chat is currently open
                        markMessagesAsRead();
                    }
                })
                .catch(err => console.error('Gagal polling chat:', err));
        }

        function markMessagesAsRead() {
            fetch('{{ route("api.chats.read") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(() => {
                unreadBadge.style.opacity = 0;
            })
            .catch(err => console.error('Gagal menandai pesan terbaca:', err));
        }

        function renderEmptyChat() {
            messageContainer.innerHTML = `
                <div id="chat-empty-placeholder" class="flex flex-col items-center justify-center text-center h-full space-y-4 px-4 py-8">
                    <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-extrabold text-slate-800 mb-1">Ada yang bisa dibantu?</h4>
                        <p class="text-slate-400 text-[10px] font-semibold">Tulis keluhan atau pertanyaan Anda di bawah ini. Admin kami siap membantu!</p>
                    </div>
                </div>
            `;
        }

        function appendMessage(msg) {
            // Remove empty chat placeholder if it exists
            const emptyState = messageContainer.querySelector('#chat-empty-placeholder');
            if (emptyState) {
                messageContainer.innerHTML = '';
            }

            const messageDiv = document.createElement('div');
            messageDiv.className = `flex ${msg.is_from_admin ? 'justify-start' : 'justify-end'}`;

            let attachmentHtml = '';
            if (msg.product) {
                attachmentHtml = `
                    <div class="mb-2 p-2.5 bg-rose-50 rounded-2xl border border-rose-100 flex gap-2.5 items-center">
                        <img src="${msg.product.image_url}" class="w-10 h-10 object-cover rounded-xl border border-white shrink-0">
                        <div class="min-w-0 text-left">
                            <p class="text-[10px] font-extrabold text-rose-600 uppercase tracking-wider mb-0.5">Produk Terkait</p>
                            <h5 class="text-xs font-black text-slate-800 truncate mb-0.5">${msg.product.name}</h5>
                            <p class="text-[10px] font-extrabold text-slate-900">${msg.product.price}</p>
                        </div>
                    </div>
                `;
            } else if (msg.order) {
                attachmentHtml = `
                    <div class="mb-2 p-2.5 bg-rose-50 rounded-2xl border border-rose-100 text-left">
                        <p class="text-[10px] font-extrabold text-rose-600 uppercase tracking-wider mb-1">Pesanan Terkait</p>
                        <h5 class="text-xs font-black text-slate-800 mb-0.5">#${msg.order.id}</h5>
                        <p class="text-[9px] font-bold text-slate-500 mb-1">${msg.order.date}</p>
                        <span class="inline-block px-2.5 py-0.5 text-[8px] font-bold uppercase tracking-wider rounded-full bg-slate-900 text-white">${msg.order.status}</span>
                    </div>
                `;
            }

            let messageText = '';
            if (msg.message) {
                if (msg.is_from_admin) {
                    messageText = `<p class="text-xs font-semibold leading-relaxed"><span class="font-black text-rose-600 mr-1.5">Admin:</span>${msg.message}</p>`;
                } else {
                    messageText = `<p class="text-xs font-semibold leading-relaxed">${msg.message}</p>`;
                }
            }

            const bubbleBg = msg.is_from_admin 
                ? 'bg-slate-100 text-slate-800 rounded-3xl rounded-tl-sm' 
                : 'bg-rose-600 text-white rounded-3xl rounded-tr-sm';

            messageDiv.innerHTML = `
                <div class="max-w-[80%] flex flex-col ${msg.is_from_admin ? 'items-start' : 'items-end'}">
                    <div class="p-4 ${bubbleBg} shadow-sm">
                        ${attachmentHtml}
                        ${messageText}
                    </div>
                    <span class="text-[9px] font-bold text-slate-300 mt-1.5 px-1">${msg.time}</span>
                </div>
            `;

            messageContainer.appendChild(messageDiv);
        }

        function showInitialAttachmentBar() {
            if (attachedProductId && productContextData) {
                attachmentLabel.innerText = `Produk: ${productContextData.name}`;
                attachmentBar.classList.remove('hidden');
            } else if (attachedOrderId && orderContextData) {
                attachmentLabel.innerText = `Pesanan: #${orderContextData.id}`;
                attachmentBar.classList.remove('hidden');
            }
        }

        function fetchProductContext(productId) {
            // Fetch product detail locally via raw route fallback or custom details
            fetch(`/product/${productId}`)
                .then(res => res.text())
                .then(html => {
                    // Extract name from page title or details
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    const name = doc.querySelector('h1')?.innerText || 'Produk';
                    productContextData = { id: productId, name: name };
                    showInitialAttachmentBar();
                })
                .catch(() => {
                    productContextData = { id: productId, name: 'Produk Detail' };
                    showInitialAttachmentBar();
                });
        }

        function fetchOrderContext(orderId) {
            // Mock or get order ID
            orderContextData = { id: orderId };
            showInitialAttachmentBar();
        }

        function scrollToBottom() {
            messageContainer.scrollTop = messageContainer.scrollHeight;
        }

        window.tagOrderForChat = function(orderId) {
            if (!isLoggedIn) {
                openChat();
                return;
            }

            attachedOrderId = orderId;
            attachedProductId = null;
            orderContextData = { id: orderId };
            
            // Set input template text
            chatInput.value = `Saya mengalami masalah pada pesanan #${orderId}: `;
            
            // Open the chat window
            openChat();
            
            // Show attachment bar
            showInitialAttachmentBar();
            
            // Focus on input
            chatInput.focus();
        };

        // Check for unread messages at start (polled quietly to set initial badge status)
        if (isLoggedIn) {
            fetch('{{ route("api.chats.index") }}')
                .then(res => res.json())
                .then(messages => {
                    let unread = 0;
                    messages.forEach(msg => {
                        if (msg.sender_id !== {{ auth()->id() ?? '0' }} && !msg.is_read) {
                            unread++;
                        }
                    });

                    if (unread > 0) {
                        unreadBadge.innerText = unread;
                        unreadBadge.style.opacity = 1;
                    }
                });
        }
    })();
</script>
@endif
