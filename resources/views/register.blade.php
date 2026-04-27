<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ALTAR</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#535353] min-h-screen bg-[#2a2a2a]  font-sans">

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full">

            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">

                <div class="text-center mb-10">
                    <div class="text-3xl font-black tracking-tighter text-[#2F2F2F] mb-2">ALTAR</div>
                    <p class="text-gray-500 text-sm">Create an account to start building your PC</p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2 ml-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-5 py-3 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-black focus:ring-0 transition duration-200 outline-none text-gray-700"
                            placeholder="Your full name">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2 ml-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-5 py-3 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-black focus:ring-0 transition duration-200 outline-none text-gray-700"
                            placeholder="name@example.com">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2 ml-1">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-5 py-3 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-black focus:ring-0 transition duration-200 outline-none text-gray-700"
                            placeholder="••••••••">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2 ml-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-5 py-3 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-black focus:ring-0 transition duration-200 outline-none text-gray-700"
                            placeholder="••••••••">
                    </div>

                    <button type="submit"
                        class="w-full py-4 mt-4 bg-[#2a2a2a] text-white rounded-2xl font-bold text-lg hover:bg-black transform active:scale-95 transition duration-200 shadow-lg shadow-gray-200">
                        Create Account
                    </button>
                </form>

                <div class="mt-10 text-center">
                    <p class="text-sm text-gray-500">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-black font-bold hover:underline underline-offset-4">Sign In</a>
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

    @if ($errors->any())
    <div class="mb-4 text-red-500 text-sm font-bold">
        {{ $errors->first() }}
    </div>
@endif

</body>
</html>
