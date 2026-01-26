<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ALTAR</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8f9fa] min-h-screen bg-[#2a2a2a] font-sans">

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full">

            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">

                <div class="text-center mb-10">
                    <div class="text-3xl font-black tracking-tighter text-[#2F2F2F] mb-2">ALTAR</div>
                    <p class="text-gray-500 text-sm">Sign in to manage your custom build</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2 ml-1">Email Address</label>
                        <input type="email" name="email" required
                            class="w-full px-5 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-black focus:ring-0 transition duration-200 outline-none text-gray-700"
                            placeholder="name@example.com">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2 ml-1">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-5 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-black focus:ring-0 transition duration-200 outline-none text-gray-700"
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

                <div class="mt-10 text-center">
                    <p class="text-sm text-gray-500">
                        New here?
                        <a href="{{ route('register') }}" class="text-black font-bold hover:underline underline-offset-4">Create Account</a>
                    </p>
                </div>
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('build') }}" class="text-gray-400 hover:text-black transition text-sm flex items-center justify-center gap-2">
                    ← Back to Store
                </a>
            </div>

        </div>
    </div>

</body>
</html>
