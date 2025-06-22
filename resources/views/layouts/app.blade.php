<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'My App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Konten Utama --}}
    <main class="flex-grow container mx-auto p-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

</body>

</html>
