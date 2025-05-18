@extends('layouts.pembeli-navbar')

@section('title', 'Edit Profil')

@section('content')
<style>
    body {
        background-color: black !important;
    }
</style>
<div class="card-box">
    <h4 class="h4 text-blue mb-20">Edit Profil</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('pembeli.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH') <!-- HARUS PATCH agar cocok dengan route -->
        
        <div class="form-group">
            <label for="name">Nama:</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="avatar">Avatar (optional):</label><br>
            @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" width="100" class="mb-2" alt="avatar">
            @endif
            <input type="file" class="form-control" name="avatar" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Update Profil</button>
    </form>
</div>
@endsection
