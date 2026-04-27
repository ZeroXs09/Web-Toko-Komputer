@extends('layouts.app')

@section('title', 'Shopping Cart - ALTAR4')

@section('content')
    <div class="min-h-screen bg-[#2a2a2a] py-12 px-6">
        <div class="max-w-7xl mx-auto">
            {{-- Judul dengan Typewriter --}}
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-8 animate-fade-in-up">
                <span id="typewriter-cart"></span>
            </h1>

            @if (empty($cart))
                {{-- Empty State dengan animasi --}}
                <div class="bg-[#1a1a1a] border border-dashed border-gray-600 rounded-2xl p-16 text-center animate-zoom-in">
                    <div class="mb-6 transform transition-transform hover:scale-110 duration-500">
                        <svg class="w-32 h-32 mx-auto text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-400 text-xl mb-8 font-light tracking-wide">Your cart is currently empty_</p>
                    <a href="{{ route('build') }}"
                        class="inline-block bg-white text-black px-8 py-3 rounded-xl font-bold hover:bg-gray-200 transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg">
                        Start Building
                    </a>
                </div>
            @else
                <div class="grid lg:grid-cols-3 gap-8">
                    {{-- Daftar Item --}}
                    <div class="lg:col-span-2 space-y-5">
                        @foreach ($cart as $id => $item)
                            <div class="group bg-[#1a1a1a] border border-gray-700 rounded-xl p-5 flex flex-wrap md:flex-nowrap gap-5 hover:border-white/50 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in-up"
                                style="animation-delay: {{ $loop->index * 0.05 }}s">
                                {{-- Gambar --}}
                                <div class="w-28 h-28 flex-shrink-0 overflow-hidden rounded-lg bg-[#2a2a2a]">
                                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                </div>
                                {{-- Info --}}
                                <div class="flex-1">
                                    <div class="text-xs uppercase tracking-wider text-gray-500">{{ $item['category'] }}
                                    </div>
                                    <h3 class="text-white font-bold text-xl mt-1">{{ $item['name'] }}</h3>
                                    <p class="text-green-400 font-bold text-lg mt-2">IDR
                                        {{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                                {{-- Aksi --}}
                                <div class="flex flex-col items-end justify-between gap-3">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="remove-form">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-red-400 hover:text-red-300 transition p-2 hover:bg-red-500/10 rounded-full">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                    <div
                                        class="flex items-center gap-2 bg-[#2a2a2a] rounded-full border border-gray-600 p-1">
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                            <button type="submit"
                                                class="w-8 h-8 rounded-full hover:bg-gray-700 text-white font-bold transition">-</button>
                                        </form>
                                        <span class="w-8 text-center text-white font-bold">{{ $item['quantity'] }}</span>
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                            <button type="submit"
                                                class="w-8 h-8 rounded-full hover:bg-gray-700 text-white font-bold transition">+</button>
                                        </form>
                                    </div>
                                    <div class="text-sm text-gray-400">Sub: IDR
                                        {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @endforeach
                        <div class="flex justify-end mt-4 animate-fade-in-up">
                            <form action="{{ route('cart.clear') }}" method="POST"
                                onsubmit="return confirm('Hapus semua item?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-red-400 hover:text-red-300 text-sm uppercase tracking-wider flex items-center gap-1 transition">Clear
                                    All Items <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg></button>
                            </form>
                        </div>
                    </div>

                    {{-- Summary --}}
                    <div class="lg:col-span-1">
                        <div
                            class="bg-[#1a1a1a] border border-white/10 rounded-2xl p-6 sticky top-32 backdrop-blur-sm shadow-2xl animate-fade-in-up animation-delay-200">
                            <h2 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-3">Order Summary</h2>
                            <div class="space-y-3">
                                <div class="flex justify-between text-gray-300"><span>Subtotal</span><span>IDR
                                        {{ number_format($subtotal, 0, ',', '.') }}</span></div>
                                <div class="flex justify-between text-gray-300"><span>Tax (11%)</span><span>IDR
                                        {{ number_format($tax, 0, ',', '.') }}</span></div>
                                <div class="border-t border-gray-700 pt-3 mt-2">
                                    <div class="flex justify-between text-white text-2xl font-bold"><span>Total</span><span
                                            class="text-green-400">IDR {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('checkout') }}"
                                class="mt-8 block w-full bg-white text-black text-center py-4 rounded-xl font-bold hover:bg-gray-200 transition-all duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg">Proceed
                                to Checkout →</a>
                            <a href="{{ route('build') }}"
                                class="mt-4 block w-full text-center text-gray-400 hover:text-white transition text-sm">←
                                Continue Shopping</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Animasi CSS --}}
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }

        .animate-zoom-in {
            animation: zoomIn 0.5s ease forwards;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
        }

        .animation-delay-300 {
            animation-delay: 0.3s;
        }

        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('typewriter-cart')) {
                new Typed('#typewriter-cart', {
                    strings: ['Shopping Cart', 'Review Your Build', 'Finalize Components'],
                    typeSpeed: 60,
                    backSpeed: 30,
                    loop: true,
                    cursorChar: '_'
                });
            }
        });
    </script>
@endsection
