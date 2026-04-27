<header class="bg-white border-b border-gray-200 px-6 py-4 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        {{-- Logo --}}
        <a href="{{ route('build') }}" class="flex items-center gap-3 hover:opacity-80 transition">
            <img src="{{ asset('images/logos/logo.png') }}" alt="ALTAR Logo" class="w-20 h-20 object-contain">
            <div>
                <div class="font-bold text-2xl" style="color: #2F2F2F;">ALTAR</div>
                <div class="text-sm text-gray-600">Part & Computer</div>
            </div>
        </a>

        {{-- Navigasi Kanan --}}
        <div class="flex items-center gap-4">
            <!-- Cart -->
            <a href="{{ route('cart') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg transition relative {{ request()->routeIs('cart') ? 'bg-black text-white' : 'bg-[#2a2a2a] text-white hover:bg-[#333]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Cart</span>
                @if (isset($cartCount) && $cartCount > 0)
                    <span
                        class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>

            <!-- Receipt -->
            <a href="{{ route('receipts') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg transition {{ request()->routeIs('receipts') ? 'bg-black text-white' : 'bg-[#2a2a2a] text-white hover:bg-[#333]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Receipt</span>
            </a>

            <!-- About Us -->
            <a href="{{ route('aboutus') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg transition {{ request()->routeIs('aboutus') ? 'bg-black text-white' : 'bg-[#2a2a2a] text-white hover:bg-[#333]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>About Us</span>
            </a>

            <!-- Build Now -->
            <a href="{{ route('build') }}"
                class="flex items-center gap-2 px-6 py-2 rounded-lg transition {{ request()->routeIs('build') ? 'bg-black text-white' : 'bg-[#2a2a2a] text-white hover:bg-[#333]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.527.288 1.137.288 1.664 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Build Now !</span>
                <span>→</span>
            </a>

            <!-- Auth Section (Login/Logout & User) -->
            <div class="flex items-center gap-4">
                @auth
                    <div class="flex items-center gap-3 bg-blue-700 px-4 py-2 rounded-lg border border-gray-200">
                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-white">{{ Auth::user()->name }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-[#e3242b] text-white px-5 py-2.5 rounded-lg font-bold flex items-center gap-2 hover:bg-red-700 transition shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
