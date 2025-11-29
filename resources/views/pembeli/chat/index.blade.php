@extends('layouts.pembeli-navbar')

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
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --secondary-color: #6c757d;
        }

        body {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 70%, var(--light-blue) 100%) !important;
            color: #e0e0e0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .chat-container {
            height: 88vh;
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.95) 0%, rgba(26, 58, 95, 0.9) 100%);
            backdrop-filter: blur(15px);
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            border: 2px solid var(--gold);
            box-shadow: 0 15px 40px rgba(255, 215, 0, 0.2);
            margin: 2rem auto;
        }

        .chat-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {

            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }
        }

        /* Sidebar Styling - Matching Navbar */
        .sidebar {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.98) 0%, rgba(26, 58, 95, 0.95) 100%);
            border-right: 2px solid var(--gold);
            backdrop-filter: blur(15px);
        }

        .sidebar-header {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 100%);
            padding: 1.5rem;
            border-bottom: 2px solid var(--gold);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 30px rgba(255, 215, 0, 0.15);
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.1), transparent);
            animation: slideLight 3s infinite;
        }

        @keyframes slideLight {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        .chat-avatar {
            width: 48px;
            height: 48px;
            font-size: 1.1rem;
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
        }

        .ai-avatar {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.4);
            animation: pulse-glow 2s infinite;
            color: var(--dark-blue);
            font-weight: 700;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(255, 215, 0, 0.4);
            }

            50% {
                box-shadow: 0 0 30px rgba(255, 215, 0, 0.6);
            }
        }

        .user-avatar {
            background: linear-gradient(135deg, var(--medium-blue) 0%, var(--light-blue) 100%);
            color: white;
            font-weight: 700;
        }

        .list-group-item {
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(255, 215, 0, 0.2);
            padding: 1rem 1.25rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .list-group-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--gold);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .list-group-item:hover {
            background: rgba(255, 215, 0, 0.1);
            transform: translateX(8px);
        }

        .list-group-item:hover::before {
            transform: scaleY(1);
        }

        .list-group-item.active {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.15) 0%, rgba(255, 237, 78, 0.1) 100%);
            border-left: 4px solid var(--gold);
        }

        /* Chat Area */
        .chat-header {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 100%);
            padding: 1.25rem 1.5rem;
            border-bottom: 2px solid var(--gold);
            backdrop-filter: blur(15px);
            box-shadow: 0 4px 30px rgba(255, 215, 0, 0.15);
        }

        .chat-messages {
            background-image:
                radial-gradient(circle at 20% 50%, rgba(255, 215, 0, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 215, 0, 0.08) 0%, transparent 50%);
            background-color: rgba(10, 22, 40, 0.8);
        }

        /* Message Bubbles */
        .bubble-appear {
            animation: bubbleIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes bubbleIn {
            from {
                opacity: 0;
                transform: translateY(10px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .message-bubble {
            padding: 0.875rem 1.125rem;
            max-width: 70%;
            word-wrap: break-word;
            position: relative;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            border-radius: 15px;
        }

        .message-bubble:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .message-mine {
            background: linear-gradient(135deg, var(--medium-blue) 0%, var(--light-blue) 100%);
            color: white;
            border-radius: 1.25rem 1.25rem 0.25rem 1.25rem;
            border: 1px solid rgba(255, 215, 0, 0.3);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .message-other {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.8) 0%, rgba(42, 74, 127, 0.9) 100%);
            color: #ffffff;
            border-radius: 1.25rem 1.25rem 1.25rem 0.25rem;
            border: 1px solid rgba(255, 215, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        .message-ai {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            border-radius: 1.25rem 1.25rem 1.25rem 0.25rem;
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
            font-weight: 700;
            border: 1px solid rgba(255, 215, 0, 0.3);
        }

        /* Input Area */
        .chat-input-area {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 100%);
            padding: 1.25rem 1.5rem;
            border-top: 2px solid var(--gold);
            backdrop-filter: blur(15px);
            box-shadow: 0 -4px 30px rgba(255, 215, 0, 0.15);
        }

        .chat-input {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.9) 0%, rgba(26, 58, 95, 0.8) 100%);
            border: 2px solid rgba(255, 215, 0, 0.3);
            color: #e0e0e0;
            padding: 0.875rem 1.25rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .chat-input:focus {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.95) 0%, rgba(26, 58, 95, 0.85) 100%);
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
            outline: none;
        }

        .chat-input::placeholder {
            color: #a0aec0;
        }

        .btn-send {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            border-radius: 50%;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
            color: var(--dark-blue);
            font-weight: 700;
        }

        .btn-send:hover:not(:disabled) {
            transform: scale(1.1) rotate(15deg);
            box-shadow: 0 8px 30px rgba(255, 215, 0, 0.6);
        }

        .btn-send:active:not(:disabled) {
            transform: scale(0.95) rotate(15deg);
        }

        .btn-send:disabled {
            background: #6c757d;
            opacity: 0.5;
            cursor: not-allowed;
            color: #a0aec0;
        }

        .btn-clear {
            background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            color: white;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
            font-weight: 600;
        }

        .btn-clear:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        }

        /* Header Titles */
        .sidebar-title {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            font-size: 1.5rem;
        }

        /* Status Indicator */
        .status-online {
            width: 12px;
            height: 12px;
            background: var(--gold);
            border-radius: 50%;
            border: 2px solid var(--dark-blue);
            position: absolute;
            bottom: 2px;
            right: 2px;
            animation: pulse 2s infinite;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.7;
                transform: scale(1.1);
            }
        }

        /* Empty State */
        .empty-state {
            color: #a0aec0;
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-state-icon {
            font-size: 4rem;
            opacity: 0.5;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Loading Animation */
        .loading-dots {
            display: inline-flex;
            gap: 4px;
        }

        .loading-dots span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--gold);
            animation: bounce 1.4s infinite ease-in-out;
        }

        .loading-dots span:nth-child(1) {
            animation-delay: -0.32s;
        }

        .loading-dots span:nth-child(2) {
            animation-delay: -0.16s;
        }

        @keyframes bounce {

            0%,
            80%,
            100% {
                transform: scale(0);
            }

            40% {
                transform: scale(1);
            }
        }

        /* Timestamp */
        .message-time {
            font-size: 0.75rem;
            opacity: 0.7;
            margin-top: 0.25rem;
        }

        /* Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 100%);
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border-radius: 4px;
            border: 1px solid var(--dark-blue);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
        }

        /* Floating animation untuk pesan */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .message-bubble:hover {
            animation: float 2s ease-in-out infinite;
        }

        /* Mobile Toggle Button */
        .sidebar-toggle {
            display: none;
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 1050;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            color: var(--dark-blue);
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .chat-container {
                height: 85vh;
                margin: 1.5rem;
                border-radius: 18px;
            }

            .message-bubble {
                max-width: 80%;
            }

            .chat-avatar {
                width: 42px;
                height: 42px;
                font-size: 1rem;
            }

            .sidebar-header {
                padding: 1.25rem;
            }

            .chat-header {
                padding: 1rem 1.25rem;
            }

            .chat-input-area {
                padding: 1rem 1.25rem;
            }
        }

        @media (max-width: 768px) {
            .chat-container {
                height: 82vh;
                margin: 1rem;
                border-radius: 15px;
                position: relative;
            }

            .sidebar {
                position: absolute;
                z-index: 10;
                width: 100%;
                height: 100%;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                border-radius: 15px 0 0 15px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .message-bubble {
                max-width: 85%;
                padding: 0.75rem 1rem;
            }

            .sidebar-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .chat-avatar {
                width: 38px;
                height: 38px;
                font-size: 0.9rem;
            }

            .list-group-item {
                padding: 0.875rem 1rem;
            }

            .sidebar-header {
                padding: 1rem;
            }

            .sidebar-title {
                font-size: 1.3rem;
            }

            .chat-header {
                padding: 0.875rem 1rem;
            }

            .chat-input {
                padding: 0.75rem 1rem;
            }

            .btn-send {
                width: 44px;
                height: 44px;
            }

            .empty-state {
                padding: 2rem 1rem;
            }

            .empty-state-icon {
                font-size: 3rem;
            }
        }

        @media (max-width: 576px) {
            .chat-container {
                height: 80vh;
                margin: 0.75rem;
                border-radius: 12px;
            }

            .message-bubble {
                max-width: 90%;
                padding: 0.625rem 0.875rem;
            }

            .chat-avatar {
                width: 36px;
                height: 36px;
                font-size: 0.85rem;
            }

            .status-online {
                width: 10px;
                height: 10px;
            }

            .list-group-item {
                padding: 0.75rem;
            }

            .sidebar-header {
                padding: 0.875rem;
            }

            .sidebar-title {
                font-size: 1.2rem;
            }

            .chat-header {
                padding: 0.75rem;
            }

            .chat-input {
                padding: 0.625rem 0.875rem;
                font-size: 0.9rem;
            }

            .btn-send {
                width: 40px;
                height: 40px;
                font-size: 0.9rem;
            }

            .btn-clear {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }

            .empty-state {
                padding: 1.5rem 0.75rem;
            }

            .empty-state-icon {
                font-size: 2.5rem;
            }

            .message-time {
                font-size: 0.7rem;
            }
        }

        @media (max-width: 400px) {
            .chat-container {
                height: 78vh;
                margin: 0.5rem;
                border-radius: 10px;
            }

            .message-bubble {
                max-width: 95%;
                padding: 0.5rem 0.75rem;
            }

            .chat-avatar {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }

            .list-group-item {
                padding: 0.625rem;
            }

            .sidebar-header {
                padding: 0.75rem;
            }

            .sidebar-title {
                font-size: 1.1rem;
            }

            .chat-header {
                padding: 0.625rem;
            }

            .chat-input {
                padding: 0.5rem 0.75rem;
                font-size: 0.85rem;
            }

            .btn-send {
                width: 36px;
                height: 36px;
                font-size: 0.8rem;
            }

            .empty-state {
                padding: 1rem 0.5rem;
            }

            .empty-state-icon {
                font-size: 2rem;
            }
        }

        /* Sparkle effect seperti di landing page */
        .sparkle {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        /* Overlay untuk mobile saat sidebar aktif */
        .sidebar-overlay {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9;
            border-radius: 15px;
        }

        .sidebar-overlay.active {
            display: block;
        }
    </style>

    {{-- 🚀 Library Real-time --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
@endpush

@section('content')
    <div class="d-flex chat-container rounded-4 shadow-lg overflow-hidden position-relative">
        {{-- Tombol Toggle untuk Mobile --}}
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        {{-- Overlay untuk mobile --}}
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        {{-- 🔹 SIDEBAR LIST PENGGUNA --}}
        <div class="col-12 col-md-4 sidebar d-flex flex-column">
            <div class="sidebar-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 sidebar-title d-flex align-items-center gap-2">
                        <i class="fas fa-comments"></i>
                        <span>Pesan</span>
                    </h5>
                    {{-- Tombol Hapus --}}
                    <button id="clearChatBtn" class="btn-clear d-none" onclick="clearChat()">
                        <i class="fas fa-trash me-1"></i> Hapus
                    </button>
                </div>
            </div>

            <div id="userList" class="flex-grow-1 overflow-y-auto custom-scrollbar list-group list-group-flush">
                {{-- AI Asisten --}}
                <a href="#" onclick="openChat(0); return false;" data-user-id="0"
                    class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                    <div class="position-relative">
                        <div
                            class="chat-avatar ai-avatar rounded-circle d-flex align-items-center justify-content-center fw-bold">
                            <i class="fas fa-robot"></i>
                        </div>
                        <span class="status-online"></span>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold text-white">Asisten AI</div>
                        <div class="text-muted small">Selalu siap membantu Anda</div>
                    </div>
                </a>

                {{-- Penjual --}}
                @foreach ($users as $user)
                    <a href="#" onclick="openChat({{ $user->id }}); return false;" data-user-id="{{ $user->id }}"
                        class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                        <div class="position-relative">
                            <div
                                class="chat-avatar user-avatar rounded-circle d-flex align-items-center justify-content-center fw-bold text-white">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold text-white">{{ $user->name }}</div>
                            <div class="text-muted small text-truncate">{{ $user->email }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- 🔹 CHAT AREA --}}
        <div class="flex-grow-1 d-flex flex-column">
            {{-- Header --}}
            <div id="chatHeader" class="chat-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="empty-state-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-white fw-semibold">Pilih Percakapan</h6>
                        <small class="text-muted">Pilih kontak untuk memulai percakapan</small>
                    </div>
                </div>
            </div>

            {{-- Pesan --}}
            <div id="chatMessages" class="flex-grow-1 overflow-y-auto custom-scrollbar p-4 chat-messages">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-comment-dots"></i>
                    </div>
                    <p>Pilih percakapan untuk memulai chat</p>
                </div>
            </div>

            {{-- Input --}}
            <form id="chatForm" onsubmit="sendMessage(event)" class="chat-input-area">
                <input type="hidden" id="receiver_id" value="">
                <div class="d-flex gap-3 align-items-center">
                    <input id="messageInput" type="text" class="chat-input flex-grow-1" placeholder="Ketik pesan Anda..."
                        disabled>
                    <button type="submit" class="btn-send" disabled>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 🔹 SCRIPT CHAT --}}
    <script>
        const authUserId = {{ Auth::id() }};
        let currentUserId = null;
        let echo = null;

        const chatBox = document.getElementById('chatMessages');
        const msgInput = document.getElementById('messageInput');
        const chatForm = document.getElementById('chatForm');
        const clearBtn = document.getElementById('clearChatBtn');
        const header = document.getElementById('chatHeader');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        // Toggle sidebar untuk mobile
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        }

        // Event listener untuk toggle sidebar
        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);

        // Inisialisasi Echo
        try {
            echo = new Echo({
                broadcaster: 'pusher',
                key: '{{ env('PUSHER_APP_KEY') }}',
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                forceTLS: false,
                wsHost: window.location.hostname,
                wsPort: 6001,
                disableStats: true,
                enabledTransports: ['ws', 'wss'],
                authEndpoint: '/broadcasting/auth'
            });
            console.log("✅ Echo initialized successfully");
        } catch (e) {
            console.error("❌ Echo initialization failed:", e);
        }

        function formatTime(iso) {
            if (!iso) return '';
            return new Date(iso).toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function createBubble(chat) {
            const senderId = chat.sender_id || (chat.sender ? chat.sender.id : null);
            const isMine = senderId === authUserId;
            const isAI = chat.is_ai === true || chat.is_ai === 1;

            const wrapper = document.createElement('div');
            wrapper.className = `d-flex ${isMine ? 'justify-content-end' : 'justify-content-start'} mb-3`;

            const bubble = document.createElement('div');
            let bubbleClass = 'message-bubble bubble-appear ';

            if (isAI) {
                bubbleClass += 'message-ai';
            } else if (isMine) {
                bubbleClass += 'message-mine';
            } else {
                bubbleClass += 'message-other';
            }

            bubble.className = bubbleClass;

            const timestampText = formatTime(chat.created_at ?? new Date());
            const timestampClass = isMine || isAI ? 'text-dark' : 'text-muted';

            bubble.innerHTML = `
                            <div style="line-height: 1.5;">${chat.message}</div>
                            <div class="message-time text-end ${timestampClass}">${timestampText}</div>
                        `;

            wrapper.appendChild(bubble);
            return wrapper;
        }

        function appendBubble(bubbleElement) {
            chatBox.appendChild(bubbleElement);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function setFormEnabled(enabled) {
            msgInput.disabled = !enabled;
            chatForm.querySelector('button[type="submit"]').disabled = !enabled;
            if (enabled) {
                msgInput.placeholder = "Ketik pesan Anda...";
                msgInput.focus();
            } else {
                msgInput.placeholder = "Pilih chat untuk memulai percakapan";
            }
        }

        function setActiveChat(userId) {
            document.querySelectorAll('.list-group-item').forEach(item => {
                item.classList.remove('active');
            });
            const activeItem = document.querySelector(`[data-user-id="${userId}"]`);
            if (activeItem) {
                activeItem.classList.add('active');
            }
        }

        async function openChat(userId) {
            // Tutup sidebar di mobile saat chat dibuka
            if (window.innerWidth <= 768) {
                toggleSidebar();
            }

            currentUserId = userId;
            document.getElementById('receiver_id').value = userId;
            setFormEnabled(true);
            setActiveChat(userId);

            clearBtn.classList.toggle('d-none', userId !== 0);

            chatBox.innerHTML = `
                            <div class="empty-state">
                                <div class="loading-dots">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <p class="mt-3">Memuat percakapan...</p>
                            </div>
                        `;

            if (echo) echo.leaveAllChannels();

            // Set header
            if (userId === 0) {
                header.innerHTML = `
                                <div class="d-flex align-items-center gap-3">
                                    <div class="chat-avatar ai-avatar rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                        <i class="fas fa-robot"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-white fw-semibold">Asisten AI</h6>
                                        <small class="text-success">Online • Selalu Tersedia</small>
                                    </div>
                                </div>
                            `;
            } else {
                const userButton = document.querySelector(`a[onclick="openChat(${userId}); return false;"]`);
                const userName = userButton ? userButton.querySelector('.fw-semibold').textContent : `User #${userId}`;
                const userInitial = userName.charAt(0).toUpperCase();

                header.innerHTML = `
                                <div class="d-flex align-items-center gap-3">
                                    <div class="chat-avatar user-avatar rounded-circle d-flex align-items-center justify-content-center fw-bold text-white">
                                        ${userInitial}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-white fw-semibold">${userName}</h6>
                                        <small class="text-muted">Penjual</small>
                                    </div>
                                </div>
                            `;
            }

            try {
                const res = await fetch(`/pembeli/chat/history/${userId}`);
                if (!res.ok) throw new Error('Gagal memuat riwayat chat');

                const data = await res.json();
                if (data.status !== 'ok') throw new Error(data.message || 'Format data tidak valid');

                chatBox.innerHTML = '';

                if (data.chats.length === 0) {
                    chatBox.innerHTML = `
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-comment-slash"></i>
                                        </div>
                                        <p>Belum ada pesan. Mulai percakapan!</p>
                                    </div>
                                `;
                } else {
                    data.chats.forEach(chat => chatBox.appendChild(createBubble(chat)));
                }

                chatBox.scrollTop = chatBox.scrollHeight;

                if (userId !== 0 && echo) {
                    echo.private('chat.' + authUserId)
                        .listen('.chat.message', (data) => {
                            if (data.chat.sender_id == currentUserId) {
                                appendBubble(createBubble(data.chat));
                            }
                        });
                    console.log("🎧 Listening to channel: chat." + authUserId);
                }

            } catch (err) {
                console.error("❌ Gagal memuat riwayat:", err);
                chatBox.innerHTML = `
                                <div class="empty-state">
                                    <div class="empty-state-icon text-danger">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <p class="text-danger">Gagal memuat percakapan</p>
                                    <small class="text-muted">${err.message}</small>
                                </div>
                            `;
            }
        }

        async function sendMessage(e) {
            e.preventDefault();
            const msg = msgInput.value.trim();
            const receiver = document.getElementById('receiver_id').value;
            if (!msg || receiver === '') return;

            const optimisticChat = {
                sender_id: authUserId,
                message: msg,
                created_at: new Date().toISOString(),
                is_ai: false
            };

            const myBubble = createBubble(optimisticChat);
            appendBubble(myBubble);
            msgInput.value = '';

            const timestampElement = myBubble.querySelector('.message-time');

            try {
                const res = await fetch(`/pembeli/chat/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: msg, receiver_id: receiver })
                });

                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Server error');

                if (receiver == 0 && data.ai_reply) {
                    appendBubble(createBubble(data.ai_reply));
                }

                if (receiver != 0 && data.status == 'sent') {
                    if (timestampElement) {
                        timestampElement.textContent = formatTime(data.chat.created_at);
                    }
                }

            } catch (error) {
                console.error("❌ Gagal mengirim:", error.message);
                if (timestampElement) {
                    timestampElement.textContent = `(Gagal: ${error.message})`;
                    timestampElement.classList.add('text-danger', 'fw-bold');
                }
            }
        }

        async function clearChat() {
            if (currentUserId !== 0 || !confirm('Yakin ingin menghapus semua riwayat chat AI?')) return;

            try {
                const res = await fetch(`/pembeli/chat/clear/0`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const data = await res.json();
                if (data.message) {
                    chatBox.innerHTML = `
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                        <p>Semua riwayat chat AI telah dihapus</p>
                                    </div>
                                `;
                }
            } catch (e) {
                alert('❌ Gagal menghapus chat AI');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const activeUserId = @json($activeUserId ?? null);

            if (activeUserId !== null) {
                console.log('🔄 Page refreshed, opening chat ID:', activeUserId);
                openChat(activeUserId);
            } else {
                setFormEnabled(false);
            }

            // Handle window resize
            window.addEventListener('resize', function () {
                // Jika ukuran layar > 768px, pastikan sidebar terlihat
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                }
            });
        });
    </script>
@endsection