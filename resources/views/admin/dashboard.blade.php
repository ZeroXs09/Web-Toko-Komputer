<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - ALTAR</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-10">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-4">Selamat Datang, Admin!</h1>
        <p class="text-gray-400">Ini adalah halaman dashboard khusus Admin ALTAR.</p>

        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg font-bold transition">
                Logout
            </button>
        </form>
    </div>
</body>
</html><!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - ALTAR</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-10">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-4">Selamat Datang, Admin!</h1>
        <p class="text-gray-400">Ini adalah halaman dashboard khusus Admin ALTAR.</p>

        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg font-bold transition">
                Logout
            </button>
        </form>
    </div>
</body>
</html>
