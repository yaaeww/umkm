@extends('layouts.app')

@php
    use Carbon\Carbon;
@endphp

@push('style')
    <style>
        :root {
            --dark-blue: #0a1628;
            --medium-blue: #1a3a5f;
            --light-blue: #2a4a7f;
            --gold: #ffd700;
            --gold-light: #ffed4e;
            --gold-dark: #d4af37;
            --wa-bg: var(--dark-blue);
            --wa-sidebar: var(--medium-blue);
            --wa-header: var(--light-blue);
            --wa-bubble-in: var(--medium-blue);
            --wa-bubble-out: var(--gold);
            --wa-text: #e0e0e0;
            --wa-text-light: #a0a0a0;
            --wa-border: rgba(255, 215, 0, 0.3);
        }

        .chat-container {
            height: 85vh;
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 100%);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        /* SIDEBAR */
        .chat-sidebar {
            background: linear-gradient(135deg, var(--medium-blue) 0%, var(--light-blue) 100%);
            border-right: 2px solid var(--wa-border);
            backdrop-filter: blur(10px);
        }

        .sidebar-header {
            background: linear-gradient(135deg, var(--light-blue) 0%, var(--medium-blue) 100%);
            padding: 15px 20px;
            color: var(--gold);
            border-bottom: 2px solid var(--wa-border);
        }

        .sidebar-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .user-list {
            overflow-y: auto;
            height: calc(85vh - 70px);
        }

        .user-item {
            padding: 15px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 1px solid var(--wa-border);
            background: transparent;
        }

        .user-item:hover {
            background: rgba(255, 215, 0, 0.1);
            transform: translateX(5px);
        }

        .user-item.active {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.15) 0%, rgba(255, 237, 78, 0.1) 100%);
            border-left: 3px solid var(--gold);
        }

        .chat-avatar {
            width: 50px;
            height: 50px;
            font-size: 18px;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            font-weight: 700;
        }

        .user-name {
            font-size: 15px;
            font-weight: 600;
            color: var(--gold);
            margin-bottom: 4px;
        }

        .user-email {
            font-size: 12px;
            color: var(--wa-text-light);
        }

        /* CHAT AREA */
        .chat-main {
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 100%);
        }

        .chat-header {
            background: linear-gradient(135deg, var(--light-blue) 0%, var(--medium-blue) 100%);
            padding: 15px 20px;
            border-bottom: 2px solid var(--wa-border);
            color: var(--gold);
        }

        .chat-header-avatar {
            width: 45px;
            height: 45px;
            font-size: 16px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            font-weight: 700;
        }

        .chat-header-name {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            color: var(--gold);
        }

        .chat-header-status {
            font-size: 12px;
            color: var(--wa-text-light);
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px 8%;
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.9) 0%, rgba(26, 58, 95, 0.8) 100%);
            backdrop-filter: blur(10px);
        }

        /* MESSAGE BUBBLES */
        .message-wrapper {
            margin-bottom: 15px;
            display: flex;
            gap: 10px;
        }

        .message-wrapper.mine {
            justify-content: flex-end;
        }

        .message-bubble {
            max-width: 65%;
            padding: 12px 15px;
            border-radius: 15px;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.3s ease-out;
            backdrop-filter: blur(10px);
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
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border-radius: 15px 15px 5px 15px;
            color: var(--dark-blue);
        }

        .message-wrapper.other .message-bubble {
            background: linear-gradient(135deg, var(--medium-blue) 0%, var(--light-blue) 100%);
            border-radius: 15px 15px 15px 5px;
            border: 1px solid rgba(255, 215, 0, 0.2);
        }

        .message-text {
            font-size: 14px;
            line-height: 1.5;
            color: inherit;
            word-wrap: break-word;
            margin-bottom: 5px;
        }

        .message-wrapper.other .message-text {
            color: var(--wa-text);
        }

        .message-meta {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 5px;
            margin-top: 5px;
        }

        .message-time {
            font-size: 11px;
            opacity: 0.7;
        }

        .message-wrapper.other .message-time {
            color: var(--wa-text-light);
        }

        .message-wrapper.mine .message-time {
            color: var(--dark-blue);
        }

        .message-checkmark {
            font-size: 14px;
            color: var(--dark-blue);
        }

        /* CHAT INPUT */
        .chat-input-container {
            background: linear-gradient(135deg, var(--light-blue) 0%, var(--medium-blue) 100%);
            padding: 15px 20px;
            border-top: 2px solid var(--wa-border);
        }

        .chat-input-wrapper {
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }

        .input-box {
            flex: 1;
            background: rgba(10, 22, 40, 0.6);
            border-radius: 25px;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            gap: 12px;
            border: 2px solid rgba(255, 215, 0, 0.2);
            transition: all 0.3s ease;
        }

        .input-box:focus-within {
            border-color: var(--gold);
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
        }

        .chat-input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            color: var(--wa-text);
            font-size: 14px;
            padding: 2px 0;
        }

        .chat-input::placeholder {
            color: var(--wa-text-light);
        }

        .send-button {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
        }

        .send-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.5);
        }

        .send-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* EMPTY STATE */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: var(--wa-text-light);
            text-align: center;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .empty-state-text {
            font-size: 16px;
            line-height: 1.5;
        }

        .empty-state strong {
            color: var(--gold);
            font-weight: 600;
        }

        /* SCROLLBAR */
        .user-list::-webkit-scrollbar,
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .user-list::-webkit-scrollbar-track,
        .chat-messages::-webkit-scrollbar-track {
            background: rgba(255, 215, 0, 0.1);
            border-radius: 3px;
        }

        .user-list::-webkit-scrollbar-thumb,
        .chat-messages::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border-radius: 3px;
        }

        .user-list::-webkit-scrollbar-thumb:hover,
        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: var(--gold-light);
        }

        /* EMOJI BUTTON */
        .emoji-button {
            font-size: 20px;
            color: var(--gold);
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 5px;
            border-radius: 50%;
        }

        .emoji-button:hover {
            background: rgba(255, 215, 0, 0.1);
            transform: scale(1.1);
        }

        /* TYPING INDICATOR */
        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 10px 15px;
            color: var(--wa-text-light);
            font-size: 12px;
            font-style: italic;
        }

        .typing-dots {
            display: flex;
            gap: 3px;
        }

        .typing-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
            animation: typing 1.4s infinite ease-in-out;
        }

        .typing-dot:nth-child(1) {
            animation-delay: -0.32s;
        }

        .typing-dot:nth-child(2) {
            animation-delay: -0.16s;
        }

        @keyframes typing {

            0%,
            80%,
            100% {
                transform: scale(0.8);
                opacity: 0.5;
            }

            40% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .chat-container {
                height: 80vh;
            }

            .chat-sidebar {
                width: 100%;
                max-width: 100%;
            }

            .user-list {
                height: calc(80vh - 70px);
            }

            .chat-messages {
                padding: 15px 5%;
            }

            .message-bubble {
                max-width: 80%;
            }

            .sidebar-header,
            .chat-header,
            .chat-input-container {
                padding: 12px 15px;
            }
        }

        /* ONLINE STATUS */
        .online-status {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--gold);
            margin-left: 5px;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        /* MESSAGE STATUS */
        .message-status {
            display: flex;
            align-items: center;
            gap: 2px;
        }
    </style>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
@endpush

@section('content')
    <div class="container mt-4">
        <h2 class="section-title text-center mb-4"
            style="font-size: 2.2rem; font-weight: 700; background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
            <i class="fas fa-comments me-3"></i>Chat dengan Pembeli
        </h2>

        <div class="chat-container d-flex rounded-3 overflow-hidden shadow-lg">

            {{-- SIDEBAR --}}
            <div class="chat-sidebar" style="width: 400px; max-width: 40%;">
                <div class="sidebar-header d-flex align-items-center justify-content-between">
                    <h5 class="sidebar-title"><i class="fas fa-users me-2"></i>Daftar Pembeli</h5>
                    <span class="badge"
                        style="background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%); color: var(--dark-blue); font-weight: 600;">
                        {{ $customers->count() }}
                    </span>
                </div>

                <div class="user-list">
                    @foreach ($customers as $cust)
                        <div class="user-item"
                            onclick="openChat({{ $cust->id }}, '{{ e($cust->name) }}'); setActiveUser(this);">
                            <div class="d-flex align-items-center gap-3">
                                <div
                                    class="chat-avatar rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                    {{ strtoupper(substr($cust->name, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1" style="min-width: 0;">
                                    <div class="user-name text-truncate">
                                        {{ $cust->name }}
                                        <span class="online-status"></span>
                                    </div>
                                    <div class="user-email text-truncate">{{ $cust->email }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($customers->isEmpty())
                        <div class="empty-state p-4">
                            <div class="empty-state-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="empty-state-text">
                                <strong>Belum ada pembeli</strong><br>
                                yang melakukan chat
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- CHAT AREA --}}
            <div class="chat-main flex-grow-1">
                <div id="chatHeader" class="chat-header d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center gap-3 flex-grow-1">
                        <div class="empty-state-icon mb-0" style="font-size: 2rem;">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div>
                            <div class="chat-header-name">Pilih Pembeli</div>
                            <div class="chat-header-status">Pilih chat dari daftar pembeli</div>
                        </div>
                    </div>
                </div>

                <div id="chatMessages" class="chat-messages">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="empty-state-text">
                            <strong>UMKM Indramayu Chat</strong><br>
                            Kirim dan terima pesan dari pembeli<br>
                            dengan aman dan terintegrasi
                        </div>
                    </div>
                </div>

                <form id="chatForm" onsubmit="sendMessage(event)" class="chat-input-container">
                    <input type="hidden" id="receiver_id" value="">
                    <div class="chat-input-wrapper">
                        <div class="input-box">
                            <input id="messageInput" type="text" class="chat-input"
                                placeholder="Ketik pesan untuk pembeli..." autocomplete="off" disabled>
                        </div>
                        <button type="submit" class="send-button" disabled>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
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
                    ${isMine ? '<span class="message-checkmark"><i class="fas fa-check-double"></i></span>' : ''}
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
            const messageInput = document.getElementById('messageInput');
            const sendButton = document.querySelector('.send-button');

            // Enable input and button
            messageInput.disabled = false;
            sendButton.disabled = false;

            // Update header
            const firstLetter = name.charAt(0).toUpperCase();
            document.getElementById('chatHeader').innerHTML = `
                <div class="d-flex align-items-center gap-3 flex-grow-1">
                    <div class="chat-header-avatar rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0">
                        ${firstLetter}
                    </div>
                    <div>
                        <div class="chat-header-name">${escapeHtml(name)}</div>
                        <div class="chat-header-status">
                            <span class="online-status"></span>
                            Online
                        </div>
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
                    chatBox.scrollTop = chatBox.scrollHeight;
                } else {
                    chatBox.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-comment-slash"></i>
                            </div>
                            <div class="empty-state-text">
                                <strong>Belum ada pesan</strong><br>
                                Mulai percakapan dengan ${name}
                            </div>
                        </div>
                    `;
                }

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
                chatBox.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-state-text" style="color: #ff6b6b;">
                            <strong>Gagal memuat percakapan</strong><br>
                            Silakan refresh halaman
                        </div>
                    </div>
                `;
            }
        }

        async function sendMessage(e) {
            e.preventDefault();
            const msgInput = document.getElementById('messageInput');
            const msg = msgInput.value.trim();
            const receiver = document.getElementById('receiver_id').value;
            const sendButton = document.querySelector('.send-button');

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

            // Clear input and disable temporarily
            msgInput.value = '';
            sendButton.disabled = true;
            msgInput.disabled = true;

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
                // Show error message
                const errorBubble = createBubble({
                    sender_id: authUserId,
                    message: '⚠️ Gagal mengirim pesan. Silakan coba lagi.',
                    created_at: new Date().toISOString()
                });
                chatBox.appendChild(errorBubble);
                chatBox.scrollTop = chatBox.scrollHeight;
            } finally {
                // Re-enable input and button
                sendButton.disabled = false;
                msgInput.disabled = false;
                msgInput.focus();
            }
        }

        // Auto-focus input when chat is opened
        document.addEventListener('DOMContentLoaded', function () {
            const messageInput = document.getElementById('messageInput');
            messageInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.querySelector('.send-button').click();
                }
            });

            // Add loading state to send button
            const sendButton = document.querySelector('.send-button');
            sendButton.innerHTML = '<i class="fas fa-paper-plane"></i>';
        });
    </script>
@endsection