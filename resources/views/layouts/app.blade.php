<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Furnie - Furniture Store')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Tailwind classes untuk memastikan semua utility tersedia -->
    <style>
        /* Custom styles untuk dropdown animation */
        .dropdown-enter {
            opacity: 0;
            transform: translateY(-10px);
        }

        .dropdown-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.2s ease-out;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    {{-- Enhanced Navbar --}}
    @include('partials.navbar')

    {{-- Main Content --}}
    <main class="flex-grow">
        <div class="container mx-auto px-4 py-6">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    @include('partials.footer')

</body>

</html>
