@extends('layouts.app')

@section('title', 'Build Your Dream PC - ALTAR4')

@section('content')
<div class="min-h-screen bg-[#2a2a2a]">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2a2a2a] py-16 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl font-bold text-white mb-6">Build Your Dream PC</h1>
                    <p class="text-gray-300 text-lg mb-6">
                        Select your components and create the perfect gaming setup tailored to your needs.
                    </p>
                    <div class="flex items-center gap-4 text-gray-400">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Compatibility Check</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Best Prices</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <img
                        src="https://images.unsplash.com/photo-1591405351990-4726e331f141?q=80&w=1170&auto=format&fit=crop"
                        alt="Gaming PC"
                        class="rounded-lg w-full h-[400px] object-cover shadow-2xl"
                    >
                </div>
            </div>
        </div>
    </div>

    <!-- Category Filter -->
    <div class="bg-[#1a1a1a] border-b border-gray-700 sticky top-[88px] z-10">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex gap-3 overflow-x-auto">
                @foreach($categories as $category)
                    <a
                        href="{{ route('build', ['category' => $category, 'search' => request('search')]) }}"
                        class="px-6 py-2 rounded-lg whitespace-nowrap transition {{ request('category', 'All') == $category ? 'bg-white text-black' : 'bg-[#2a2a2a] text-gray-300 hover:bg-[#333]' }}"
                    >
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Components Grid -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <!-- Search Bar -->
        <div class="mb-8">
            <form action="{{ route('build') }}" method="GET">
                <input type="hidden" name="category" value="{{ request('category', 'All') }}">
                <div class="relative max-w-xl">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input
                        type="text"
                        name="search"
                        placeholder="Search components by name or category..."
                        value="{{ request('search') }}"
                        class="w-full pl-12 pr-4 py-3 bg-[#1a1a1a] border border-gray-700 text-white rounded-lg placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-white focus:border-white transition"
                    />
                </div>
            </form>
            @if(request('search') && $products->isEmpty())
                <p class="text-gray-400 mt-3 text-sm">No components found for "{{ request('search') }}"</p>
            @endif
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Products Grid -->
            <div class="md:col-span-2">
                <div class="grid sm:grid-cols-2 gap-6">
                    @forelse($products as $product)
                        <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg overflow-hidden group hover:border-gray-500 transition">
                            <div class="relative overflow-hidden">
                                <img
                                    src="{{ $product->image }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-48 object-cover group-hover:scale-110 transition duration-500"
                                    onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'"
                                >
                            </div>
                            <div class="p-5">
                                <div class="text-xs text-gray-400 mb-2">{{ $product->category }}</div>
                                <h3 class="font-bold text-white mb-3">{{ $product->name }}</h3>
                                <div class="flex items-center justify-between">
                                    <div class="text-2xl font-bold text-white">
                                        Rp {{ number_format($product->price / 1000, 0) }}K
                                    </div>
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-1 bg-white text-black hover:bg-gray-200 px-4 py-2 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-12">
                            <p class="text-gray-400">No products available</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Cart Summary Sidebar -->
            <div class="md:col-span-1">
                <div class="bg-[#1a1a1a] border border-gray-700 p-6 rounded-lg sticky top-32">
                    <h2 class="text-2xl font-bold text-white mb-6">Your Build</h2>

                    @if(empty($cart))
                        <div class="text-center py-12">
                            <svg class="mx-auto text-gray-500 mb-3 w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-400">No components selected yet</p>
                        </div>
                    @else
                        @php
                            $subtotal = 0;
                            foreach($cart as $item) {
                                $subtotal += $item['price'] * $item['quantity'];
                            }
                            $total = $subtotal * 1.11;
                        @endphp

                        <div class="border-t border-gray-700 pt-4">
                            <div class="flex justify-between text-xl font-bold text-white pt-3">
                                <span>Total</span>
                                <span>Rp {{ number_format($total / 1000, 0) }}K</span>
                            </div>
                        </div>

                        <a href="{{ route('cart') }}" class="block w-full mt-6 bg-white text-black text-center py-3 rounded-lg hover:bg-gray-200 transition font-medium">
                            Checkout Build
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

