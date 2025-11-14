<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Di sini kita mendaftarkan semua channel broadcast.
| Setiap user hanya boleh mendengarkan channel-nya sendiri.
|
*/

// Default channel user (biarkan saja)
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Channel untuk chat real-time antar user
Broadcast::channel('chat.{id}', function ($user, $id) {
    // Izinkan hanya jika user sedang login & id channel = id user
    return (int) $user->id === (int) $id;
});
