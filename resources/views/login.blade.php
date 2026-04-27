<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ALTAR</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#2a2a2a] min-h-screen font-sans">

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full">

            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">

                <div class="text-center mb-10">
                    <div class="text-3xl font-black tracking-tighter text-[#2F2F2F] mb-2">ALTAR</div>
                    <p class="text-gray-500 text-sm">Sign in to manage your custom build</p>
                </div>

                
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 flex items-center gap-3 animate-pulse">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <ul class="list-none">
                            @foreach ($errors->all() as $error)
                                <li class="text-red-600 text-sm font-semibold">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2 ml-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-5 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-black focus:ring-0 transition duration-200 outline-none text-gray-700 @error('email') border-red-500 @enderror"
                            placeholder="name@example.com">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2 ml-1">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-5 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-black focus:ring-0 transition duration-200 outline-none text-gray-700 @error('email') border-red-500 @enderror"
                            placeholder="••••••••">
                    </div>

                    <div class="flex items-center justify-between px-1">
                        <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-black focus:ring-black mr-2">
                            Remember me
                        </label>
                        <a href="#" class="text-sm font-semibold text-gray-400 hover:text-black transition">Forgot?</a>
                    </div>

                    <button type="submit"
                        class="w-full py-4 bg-[#2a2a2a] text-white rounded-2xl font-bold text-lg hover:bg-black transform active:scale-95 transition duration-200 shadow-lg shadow-gray-200">
                        Login Now
                    </button>
                </form>

                <div class="text-center mt-8">
                    <a href="{{ route('build') }}" class="text-gray-400 hover:text-black transition text-sm flex items-center justify-center gap-2">
                        ← Back to Store
                    </a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
