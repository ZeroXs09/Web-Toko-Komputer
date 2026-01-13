<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ALTAR4 - PC Builder POS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <!-- Header -->
    @include('partials.header')

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="bg-green-500 text-white px-6 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')
</body>
</html>
