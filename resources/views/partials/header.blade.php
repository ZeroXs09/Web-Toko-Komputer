<header class="bg-white border-b border-gray-200 px-6 py-4 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ route('build') }}" class="flex items-center gap-3 hover:opacity-80 transition">
            <img src="{{ asset('images/logos/logo.png') }}" alt="ALTAR Logo" class="w-20 h-200 object-contain">
            <div>
                <div class="font-bold text-2xl " style="color: #2F2F2F;">ALTAR</div>
                <div class="text-sm text-gray-600">Part & Computer</div>
            </div>
        </a>



        <!-- Navigation Buttons -->
        <div class="flex items-center gap-4">
            <!-- Cart Button -->
            <a href="{{ route('cart') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg transition relative {{ request()->routeIs('cart') ? 'bg-black text-white' : 'bg-[#2a2a2a] text-white hover:bg-[#333]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span>Cart</span>
                @if($cartCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>

            <!-- Receipt Button -->
            <a href="{{ route('receipts') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg transition {{ request()->routeIs('receipts') ? 'bg-black text-white' : 'bg-[#2a2a2a] text-white hover:bg-[#333]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Receipt</span>
            </a>

            <!-- Build Now Button -->
            <a href="{{ route('build') }}" class="flex items-center gap-2 px-6 py-2 rounded-lg transition {{ request()->routeIs('build') ? 'bg-black text-white' : 'bg-[#2a2a2a] text-white hover:bg-[#333]' }}">
                <span>Build Now !</span>
                <span>→</span>
            </a>
        </div>
    </div>
</header>
