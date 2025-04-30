@php
    $role = Auth::user()->role ?? 'guest';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('deskapp/vendors/styles/core.css') }}">
    <link rel="stylesheet" href="{{ asset('deskapp/vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('deskapp/vendors/styles/style.css') }}">
</head>
<body>
    @include('partials.header')

    {{-- Include sidebar sesuai role --}}
    @includeIf('partials.sidebar-' . $role)

    <div class="main-container">
        <div class="pd-ltr-20">
            @yield('content')
        </div>
    </div>

    @include('partials.footer')

    <script src="{{ asset('deskapp/vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('deskapp/vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('deskapp/vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('deskapp/vendors/scripts/layout-settings.js') }}"></script>
</body>
</html>
