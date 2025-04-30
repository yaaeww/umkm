@extends('layouts.app')

@section('title', 'Profil Penjual')

@section('content')
    <div class="card-box">
        <h4 class="h4 text-blue mb-20">Profil Penjual</h4>
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>

        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profil</a>
    </div>
@endsection
