@extends('layouts.app')

@php
    use Carbon\Carbon;
@endphp

@push('style')
    <style>
        :root {
            --wa-green: #25D366;
            --wa-green-dark: #128C7E;
            --wa-green-light: #DCF8C6;
            --wa-bg: #ECE5DD;
            --wa-sidebar: #FFFFFF;
            --wa-header: #075E54;
            --wa-bubble-in: #FFFFFF;
            --wa-bubble-out: #DCF8C6;
            --wa-text: #303030;
            --wa-text-light: #667781;
            --wa-border: #E9EDEF;
        }

        [data-bs-theme="dark"] {
            --wa-bg: #0B141A;
            --wa-sidebar: #111B21;
            --wa-header: #202C33;
            --wa-bubble-in: #202C33;
            --wa-bubble-out: #005C4B;
            --wa-text: #E9EDEF;
            --wa-text-light: #8696A0;
            --wa-border: #2A3942;
            --wa-green: #00A884;
        }

        .chat-container {
            height: 85vh;
            background: var(--wa-bg);
        }

        /* SIDEBAR */
        .chat-sidebar {
            background: var(--wa-sidebar);
            border-right: 1px solid var(--wa-border);
        }

        .sidebar-header {
            background: var(--wa-header);
            padding: 10px 16px;
            color: white;
        }

        .sidebar-title {
            font-size: 19px;
            font-weight: 600;
            margin: 0;
        }

        .user-list {
            overflow-y: auto;
            height: calc(85vh - 59px);
        }

        .user-item {
            padding: 12px 16px;
            cursor: pointer;
            transition: background 0.2s;
            border-bottom: 1px solid var(--wa-border);
            background: var(--wa-sidebar);
        }

        .user-item:hover {
            background: var(--bs-secondary-bg);
        }

        .user-item.active {
            background: var(--bs-secondary-bg);
        }

        .chat-avatar {
            width: 49px;
            height: 49px;
            font-size: 20px;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 16px;
            font-weight: 500;
            color: var(--wa-text);
            margin-bottom: 2px;
        }

        .user-email {
            font-size: 13px;
            color: var(--wa-text-light);
        }

        /* CHAT AREA */
        .chat-main {
            display: flex;
            flex-direction: column;
            background: var(--wa-bg);
        }

        .chat-header {
            background: var(--wa-header);
            padding: 10px 16px;
            border-bottom: 1px solid var(--wa-border);
            color: white;
        }

        .chat-header-avatar {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .chat-header-name {
            font-size: 16px;
            font-weight: 500;
            margin: 0;
        }

        .chat-header-status {
            font-size: 13px;
            opacity: 0.8;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px 8%;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.03), rgba(255, 255, 255, 0.03)),
                url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"><rect fill="%23E4DCD4" width="100" height="100"/><path d="M0 0 L50 50 L0 100 M50 0 L100 50 L50 100" stroke="%23DACED7" stroke-width="1" fill="none" opacity="0.1"/></svg>');
            background-size: 300px 300px;
        }

        [data-bs-theme="dark"] .chat-messages {
            background-image:
                linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
                url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"><rect fill="%230B141A" width="100" height="100"/><path d="M0 0 L50 50 L0 100 M50 0 L100 50 L50 100" stroke="%23182229" stroke-width="1" fill="none" opacity="0.3"/></svg>');
        }

        /* MESSAGE BUBBLES */
        .message-wrapper {
            margin-bottom: 8px;
            display: flex;
            gap: 8px;
        }

        .message-wrapper.mine {
            justify-content: flex-end;
        }

        .message-bubble {
            max-width: 65%;
            padding: 6px 7px 8px 9px;
            border-radius: 7.5px;
            position: relative;
            box-shadow: 0 1px 0.5px rgba(0, 0, 0, 0.13);
            animation: slideUp 0.2s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-wrapper.mine .message-bubble {
            background: var(--wa-bubble-out);
            border-radius: 7.5px 7.5px 0 7.5px;
        }

        .message-wrapper.other .message-bubble {
            background: var(--wa-bubble-in);
            border-radius: 7.5px 7.5px 7.5px 0;
        }

        .message-text {
            font-size: 14.2px;
            line-height: 19px;
            color: var(--wa-text);
            word-wrap: break-word;
            margin-bottom: 2px;
        }

        .message-meta {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 4px;
            margin-top: 4px;
        }

        .message-time {
            font-size: 11px;
            color: var(--wa-text-light);
        }

        .message-checkmark {
            font-size: 16px;
            color: #53BDEB;
        }

        /* CHAT INPUT */
        .chat-input-container {
            background: var(--wa-header);
            padding: 5px 16px;
        }

        .chat-input-wrapper {
            display: flex;
            gap: 8px;
            align-items: flex-end;
        }

        .input-box {
            flex: 1;
            background: var(--wa-sidebar);
            border-radius: 21px;
            display: flex;
            align-items: center;
            padding: 8px 12px;
            gap: 8px;
        }

        .chat-input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            color: var(--wa-text);
            font-size: 15px;
            padding: 2px 0;
        }

        .chat-input::placeholder {
            color: var(--wa-text-light);
        }

        .send-button {
            width: 42px;
            height: 42px;
            background: var(--wa-green);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s;
        }

        .send-button:hover {
            background: var(--wa-green-dark);
        }

        /* EMPTY STATE */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: var(--wa-text-light);
        }

        .empty-state-icon {
            font-size: 80px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-state-text {
            font-size: 16px;
            text-align: center;
        }

        /* SCROLLBAR */
        .user-list::-webkit-scrollbar,
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .user-list::-webkit-scrollbar-track,
        .chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        .user-list::-webkit-scrollbar-thumb,
        .chat-messages::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        [data-bs-theme="dark"] .user-list::-webkit-scrollbar-thumb,
        [data-bs-theme="dark"] .chat-messages::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
        }
    </style>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
@endpush

@section('content')
    <div class="chat-container d-flex rounded-3 overflow-hidden shadow-lg" data-bs-theme="dark">

        {{-- SIDEBAR --}}
        <div class="chat-sidebar" style="width: 400px; max-width: 40%;">
            <div class="sidebar-header d-flex align-items-center justify-content-between">
                <h5 class="sidebar-title">💬 Chat Pembeli</h5>
            </div>

            <div class="user-list">
                @foreach ($customers as $cust)
                    <div class="user-item" onclick="openChat({{ $cust->id }}, '{{ e($cust->name) }}'); setActiveUser(this);">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="chat-avatar rounded-circle bg-secondary d-flex align-items-center justify-content-center fw-bold text-white">
                                {{ strtoupper(substr($cust->name, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1" style="min-width: 0;">
                                <div class="user-name text-truncate">{{ $cust->name }}</div>
                                <div class="user-email text-truncate">{{ $cust->email }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($customers->isEmpty())
                    <div class="empty-state p-4">
                        <div class="empty-state-icon">💬</div>
                        <div class="empty-state-text">Belum ada pembeli<br>yang melakukan chat</div>
                    </div>
                @endif
            </div>
        </div>

        {{-- CHAT AREA --}}
        <div class="chat-main flex-grow-1">
            <div id="chatHeader" class="chat-header d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-3 flex-grow-1">
                    <div class="empty-state-icon mb-0" style="font-size: 28px; opacity: 0.5;">💬</div>
                    <div>
                        <div class="chat-header-name">Pilih Pembeli</div>
                        <div class="chat-header-status">Pilih chat dari daftar</div>
                    </div>
                </div>
            </div>

            <div id="chatMessages" class="chat-messages">
                <div class="empty-state">
                    <div class="empty-state-icon">💬</div>
                    <div class="empty-state-text">
                        <strong>WhatsApp Business</strong><br>
                        Kirim dan terima pesan tanpa menyimpan<br>
                        nomor telepon di ponsel Anda
                    </div>
                </div>
            </div>

            <form id="chatForm" onsubmit="sendMessage(event)" class="chat-input-container">
                <input type="hidden" id="receiver_id" value="">
                <div class="chat-input-wrapper">
                    <div class="input-box">
                        <span style="font-size: 20px; color: var(--wa-text-light); cursor: pointer;">😊</span>
                        <input id="messageInput" type="text" class="chat-input" placeholder="Ketik pesan"
                            autocomplete="off">
                    </div>
                    <button type="submit" class="send-button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                            <path
                                d="M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const authUserId = {{ Auth::id() }};
        let currentUserId = null;
        let currentUserName = '';
        let echo = null;

        // Inisialisasi Laravel Echo
        try {
            echo = new Echo({
                broadcaster: 'pusher',
                key: '{{ env('PUSHER_APP_KEY') }}',
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                wsHost: '{{ env('PUSHER_HOST', 'ws.pusherapp.com') }}',
                wsPort: '{{ env('PUSHER_PORT', 6001) }}',
                forceTLS: false,
                disableStats: true,
                enabledTransports: ['ws', 'wss']
            });
            console.log("✅ Laravel Echo aktif");
        } catch (e) {
            console.error("❌ Echo gagal inisialisasi:", e);
        }

        function formatTime(iso) {
            if (!iso) return '';
            return new Date(iso).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function createBubble(chat) {
            const isMine = chat.sender_id === authUserId;
            const wrapper = document.createElement('div');
            wrapper.className = `message-wrapper ${isMine ? 'mine' : 'other'}`;

            const bubble = document.createElement('div');
            bubble.className = 'message-bubble';

            bubble.innerHTML = `
                    <div class="message-text">${escapeHtml(chat.message)}</div>
                    <div class="message-meta">
                        <span class="message-time">${formatTime(chat.created_at ?? new Date())}</span>
                        ${isMine ? '<span class="message-checkmark">✓✓</span>' : ''}
                    </div>
                `;

            wrapper.appendChild(bubble);
            return wrapper;
        }

        function setActiveUser(element) {
            document.querySelectorAll('.user-item').forEach(item => item.classList.remove('active'));
            element.classList.add('active');
        }

        async function openChat(userId, name) {
            currentUserId = userId;
            currentUserName = name;
            document.getElementById('receiver_id').value = userId;
            const chatBox = document.getElementById('chatMessages');

            // Update header
            const firstLetter = name.charAt(0).toUpperCase();
            document.getElementById('chatHeader').innerHTML = `
                    <div class="d-flex align-items-center gap-3 flex-grow-1">
                        <div class="chat-header-avatar rounded-circle bg-secondary d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0">
                            ${firstLetter}
                        </div>
                        <div>
                            <div class="chat-header-name">${escapeHtml(name)}</div>
                            <div class="chat-header-status">online</div>
                        </div>
                    </div>
                `;

            chatBox.innerHTML = '<div class="empty-state"><div class="empty-state-text">Memuat percakapan...</div></div>';

            if (echo) echo.leaveAllChannels();

            try {
                const res = await fetch(`/penjual/chat/history/${userId}`);
                const data = await res.json();

                chatBox.innerHTML = '';

                if (data.chats && data.chats.length > 0) {
                    data.chats.forEach(chat => chatBox.appendChild(createBubble(chat)));
                } else {
                    chatBox.innerHTML = '<div class="empty-state"><div class="empty-state-text">Belum ada pesan</div></div>';
                }

                chatBox.scrollTop = chatBox.scrollHeight;

                if (echo) {
                    echo.private('chat.' + authUserId)
                        .listen('.chat.message', (data) => {
                            if (data.chat.sender_id == currentUserId) {
                                // Remove empty state if exists
                                const emptyState = chatBox.querySelector('.empty-state');
                                if (emptyState) emptyState.remove();

                                chatBox.appendChild(createBubble(data.chat));
                                chatBox.scrollTop = chatBox.scrollHeight;
                            }
                        });
                    console.log("🎧 Mendengarkan: chat." + authUserId);
                }
            } catch (err) {
                console.error(err);
                chatBox.innerHTML = '<div class="empty-state"><div class="empty-state-text" style="color: #dc3545;">Gagal memuat percakapan</div></div>';
            }
        }

        async function sendMessage(e) {
            e.preventDefault();
            const msgInput = document.getElementById('messageInput');
            const msg = msgInput.value.trim();
            const receiver = document.getElementById('receiver_id').value;

            if (!msg || receiver === '') return;

            const chatBox = document.getElementById('chatMessages');

            // Remove empty state if exists
            const emptyState = chatBox.querySelector('.empty-state');
            if (emptyState) emptyState.remove();

            // Show message immediately
            const myBubble = createBubble({
                sender_id: authUserId,
                message: msg,
                created_at: new Date().toISOString()
            });
            chatBox.appendChild(myBubble);
            chatBox.scrollTop = chatBox.scrollHeight;
            msgInput.value = '';

            try {
                const res = await fetch(`/penjual/chat/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: msg, receiver_id: receiver })
                });

                if (res.ok) {
                    await res.text();
                }
            } catch (error) {
                console.error("❌ Gagal mengirim pesan:", error);
            }
        }

        // Focus input when clicking emoji
        document.addEventListener('DOMContentLoaded', function () {
            const emojiBtn = document.querySelector('.input-box span');
            if (emojiBtn) {
                emojiBtn.addEventListener('click', function () {
                    document.getElementById('messageInput').focus();
                });
            }
        });
    </script>
@endsection