<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | Tentukan driver broadcast default untuk event real-time kamu.
    | Gunakan "pusher" untuk real-time chat, atau "null" saat development offline.
    |
    | Supported: "pusher", "ably", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'pusher'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Di sini kamu bisa mendefinisikan semua koneksi broadcast yang akan
    | digunakan oleh Laravel untuk mengirim event ke WebSocket / layanan lain.
    |
    */

    'connections' => [

        // 🔹 Pusher / Laravel WebSockets (default)
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                // Jika pakai Pusher (online)
                'cluster' => env('PUSHER_APP_CLUSTER', 'ap1'),
                'useTLS' => env('PUSHER_SCHEME', 'https') === 'https',
                'encrypted' => true,
                'scheme' => env('PUSHER_SCHEME', 'https'),
                'host' => env('PUSHER_HOST', 'api-' . env('PUSHER_APP_CLUSTER', 'ap1') . '.pusher.com'),
                'port' => env('PUSHER_PORT', 443),

                // Jika pakai Laravel WebSockets, aktifkan baris berikut 👇
                // 'host' => env('PUSHER_HOST', '127.0.0.1'),
                // 'port' => env('PUSHER_PORT', 6001),
                // 'scheme' => 'http',
                // 'useTLS' => false,
            ],
            'client_options' => [
                // Opsi tambahan Guzzle client (jika diperlukan)
            ],
        ],

        // 🔹 Ably
        'ably' => [
            'driver' => 'ably',
            'key' => env('ABLY_KEY'),
        ],

        // 🔹 Redis Broadcasting
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        // 🔹 Log broadcasting (debug)
        'log' => [
            'driver' => 'log',
        ],

        // 🔹 Null broadcasting (nonaktif)
        'null' => [
            'driver' => 'null',
        ],

    ],

];
