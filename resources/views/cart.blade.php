@extends('layouts.app')

@section('title', 'Shopping Cart - ALTAR4')

@section('content')
<div class="min-h-screen bg-[#2a2a2a] py-12 px-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-white mb-8">Shopping Cart</h1>

        @if(empty($cart))
            <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-12 text-center">
                <svg class="mx-auto text-gray-500 mb-4 w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <p class="text-gray-400 text-lg mb-6">Your cart is empty</p>
                <a href="{{ route('build') }}" class="inline-block bg-white text-black px-6 py-3 rounded-lg hover:bg-gray-200 transition">
                    Start Building
                </a>
            </div>
        @else
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="md:col-span-2 space-y-4">
                    @foreach($cart as $id => $item)
                        <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-6 flex gap-6">
                            <img
                                src="{{ $item['image'] }}"
                                alt="{{ $item['name'] }}"
                                class="w-24 h-24 object-cover rounded"
                                onerror="this.src='https://via.placeholder.com/100?text=No+Image'"
                            >
                            <div class="flex-1">
                                <div class="text-xs text-gray-400 mb-1">{{ $item['category'] }}</div>
                                <h3 class="text-white font-bold mb-2">{{ $item['name'] }}</h3>
                                <p class="text-gray-300 text-lg font-bold">
                                    Rp {{ number_format($item['price'] / 1000, 0) }}K
                                </p>
                            </div>
                            <div class="flex flex-col items-end justify-between">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>

                                <div class="flex items-center gap-3">
                                    <form action="{{ route('cart.update', $id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                        <button type="submit" class="w-8 h-8 bg-[#2a2a2a] text-white rounded hover:bg-[#333] transition">-</button>
                                    </form>

                                    <span class="text-white font-bold w-8 text-center">{{ $item['quantity'] }}</span>

                                    <form action="{{ route('cart.update', $id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                        <button type="submit" class="w-8 h-8 bg-[#2a2a2a] text-white rounded hover:bg-[#333] transition">+</button>
                                    </form>
                                </div>

                                <p class="text-white font-bold text-lg">
                                    Rp {{ number_format(($item['price'] * $item['quantity']) / 1000, 0) }}K
                                </p>
                            </div>
                        </div>
                    @endforeach

                    <form action="{{ route('cart.clear') }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-300 transition">
                            Clear All Items
                        </button>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="md:col-span-1">
                    <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-6 sticky top-32">
                        <h2 class="text-2xl font-bold text-white mb-6">Order Summary</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-400">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($subtotal / 1000, 0) }}K</span>
                            </div>
                            <div class="flex justify-between text-gray-400">
                                <span>Tax (11%)</span>
                                <span>Rp {{ number_format($tax / 1000, 0) }}K</span>
                            </div>
                            <div class="border-t border-gray-700 pt-3">
                                <div class="flex justify-between text-white font-bold text-xl">
                                    <span>Total</span>
                                    <span>Rp {{ number_format($total / 1000, 0) }}K</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('checkout') }}" class="block w-full bg-white text-black text-center py-3 rounded-lg hover:bg-gray-200 transition font-medium mb-3">
                            Proceed to Checkout
                        </a>

                        <a href="{{ route('build') }}" class="block w-full bg-[#2a2a2a] text-white text-center py-3 rounded-lg hover:bg-[#333] transition">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
