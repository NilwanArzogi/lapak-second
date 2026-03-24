<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Lapak Second — Elektronik Pilihan')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Global Styles --}}
    @include('partials.styles')

    {{-- Page-specific styles --}}
    @stack('styles')
</head>
<body x-data="cartSystem()">

    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Page Content --}}
    @yield('content')

    {{-- Cart Drawer --}}
    @include('partials.cart-drawer')

    {{-- Success Modal --}}
    @include('partials.success-modal')

    {{-- Toast --}}
    @include('partials.toast')

    {{-- Global Scripts --}}
    @include('partials.scripts')

    {{-- Page-specific scripts --}}
    @stack('scripts')

</body>
</html>
