@extends('layouts.pembeli-navbar')

@section('title', 'Chatbot - UMKM Indramayu')

@section('content')
<div class="container py-4">
    <div class="chat-wrapper d-flex shadow rounded overflow-hidden" style="height: 600px;">

        {{-- SIDEBAR LIST KONTAK --}}
        <div class="chat-sidebar p-3 border-end bg-light" style="width: 280px;">
            <h5 class="fw-bold mb-3">Messages</h5>
            <div class="mb-3">
                <input type="text" class="form-control form-control-sm" placeholder="Search conversations...">
            </div>
            <ul class="list-unstyled chat-list">
                <li class="chat-item active d-flex align-items-center p-2 rounded mb-2">
                    <img src="https://i.pravatar.cc/40?img=1" class="rounded-circle me-2" width="40" height="40" alt="">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <strong>Gemini Asisten</strong>
                            <small class="text-muted">2m ago</small>
                        </div>
                        <small class="text-muted">Halo 👋! Ada yang bisa saya bantu?</small>
                    </div>
                </li>
            </ul>
        </div>

        {{-- AREA CHAT --}}
        <div class="chat-main flex-grow-1 d-flex flex-column bg-white">
            {{-- HEADER CHAT --}}
            <div class="chat-header d-flex align-items-center p-3 border-bottom bg-white">
                <img src="https://i.pravatar.cc/45?img=1" class="rounded-circle me-2" width="45" height="45" alt="">
                <div>
                    <h6 class="mb-0 fw-bold">Gemini Asisten</h6>
                    <small class="text-success">Online</small>
                </div>
            </div>

            {{-- BADAN CHAT --}}
            <div class="chat-body flex-grow-1 p-3 overflow-auto" id="chat-messages"
                style="background-color: #f8f9fa;">
                <div id="chat-content"></div>

                {{-- Indikator Mengetik --}}
                <div id="typing-indicator" class="text-start mb-2 d-none">
                    <span class="badge bg-secondary">Gemini sedang mengetik... 💬</span>
                </div>
            </div>

            {{-- INPUT PESAN --}}
            <div class="chat-footer border-top p-3 bg-white">
                <form id="chat-form">
                    <div class="input-group">
                        <input type="text" id="chat-input" class="form-control" placeholder="Tulis pesan..." required>
                        <button class="btn btn-primary" id="send-button" type="submit">
                            <i class="bi bi-send"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatContent = document.getElementById('chat-content');
        const chatContainer = document.getElementById('chat-messages');
        const typingIndicator = document.getElementById('typing-indicator');
        const sendButton = document.getElementById('send-button');
        const CHAT_URL = "{{ route('chatbot.chat') }}";
        const WELCOME_MESSAGE = 'Halo 👋! Saya Asisten UMKM Indramayu. Mau lihat produk, cek pesanan, atau tanya apa saja?';

        function appendMessage(text, isUser = false) {
            const div = document.createElement('div');
            div.className = (isUser ? 'text-end' : 'text-start') + ' mb-3';
            const badge = document.createElement('span');
            badge.className = 'badge';
            badge.innerHTML = text;
            div.appendChild(badge);
            chatContent.appendChild(div);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function showTypingIndicator(show) {
            typingIndicator.classList.toggle('d-none', !show);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        async function loadChats() {
            try {
                const res = await fetch(CHAT_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: '__load_history__' })
                });
                const data = await res.json();
                chatContent.innerHTML = '';
                if (data.history?.length > 0) {
                    data.history.forEach(chat => {
                        appendMessage(chat.message, true);
                        appendMessage(chat.reply, false);
                    });
                } else appendMessage(WELCOME_MESSAGE, false);
            } catch (err) {
                appendMessage(WELCOME_MESSAGE, false);
                appendMessage('Gagal memuat riwayat. Mulai chat baru.', false);
            }
        }

        chatForm.addEventListener('submit', async e => {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (!message) return;
            appendMessage(message, true);
            chatInput.value = '';
            chatInput.disabled = true;
            sendButton.disabled = true;
            showTypingIndicator(true);

            try {
                const res = await fetch(CHAT_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message })
                });
                const data = await res.json();
                showTypingIndicator(false);
                appendMessage(data.reply || 'Tidak ada balasan yang valid dari server.', false);
            } catch {
                showTypingIndicator(false);
                appendMessage('Terjadi kesalahan saat mengirim pesan.', false);
            } finally {
                chatInput.disabled = false;
                sendButton.disabled = false;
                chatInput.focus();
            }
        });

        loadChats();
    });
</script>
@endsection

@push('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .chat-item:hover {
        background-color: #e9ecef;
        cursor: pointer;
    }

    .chat-item.active {
        background-color: #dbeafe;
    }

    #chat-messages .badge {
        display: inline-block;
        padding: 0.5rem 0.75rem;
        border-radius: 0.75rem;
        max-width: 80%;
        word-wrap: break-word;
        white-space: pre-wrap;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.3s ease-out;
    }

    .text-end .badge {
        background-color: #0d6efd;
        color: #fff;
        border-bottom-right-radius: 0;
    }

    .text-start .badge {
        background-color: #e9ecef;
        color: #212529;
        border-bottom-left-radius: 0;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    #typing-indicator .badge { animation: pulse 1.5s infinite; }

    @keyframes pulse {
        0%,100% { opacity: 0.5; }
        50% { opacity: 1.0; }
    }
</style>
@endpush
