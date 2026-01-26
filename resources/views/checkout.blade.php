@extends('layouts.app')

@section('title', 'Checkout - ALTAR4')

@section('content')
<div class="min-h-screen bg-[#2a2a2a] py-12 px-6">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-4xl font-bold text-white mb-8">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm" onsubmit="this.querySelector('button[type=submit]').disabled=true;">
            @csrf
            <div class="grid md:grid-cols-3 gap-8">
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-6">
                        <h2 class="text-xl font-bold text-white mb-6">Customer Information</h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-400 mb-2">Full Name *</label>
                                <input
                                    type="text"
                                    name="customer_name"
                                    value="{{ old('customer_name') }}"
                                    class="w-full px-4 py-3 bg-[#2a2a2a] border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-white @error('customer_name') border-red-500 @enderror"
                                    required
                                >
                                @error('customer_name')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-400 mb-2">Phone Number *</label>
                                <input
                                    type="tel"
                                    name="customer_phone"
                                    value="{{ old('customer_phone') }}"
                                    class="w-full px-4 py-3 bg-[#2a2a2a] border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-white @error('customer_phone') border-red-500 @enderror"
                                    required
                                >
                                @error('customer_phone')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-white font-bold text-lg mb-4">Shipping Address</h3>
                            <textarea
                                name="customer_address"
                                rows="4"
                                class="w-full px-4 py-3 bg-[#2a2a2a] border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-white @error('customer_address') border-red-500 @enderror"
                                placeholder="Contoh: Jl. Veteran No.1A, Babakan, Tangerang. Kode Pos: 15118"
                                required
                            >{{ old('customer_address') }}</textarea>
                            @error('customer_address')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-6">
                        <h2 class="text-xl font-bold text-white mb-6">Payment Method</h2>

                        <div class="space-y-3">
                            <label class="flex items-center gap-4 p-4 border border-gray-600 rounded-lg cursor-pointer hover:border-white transition">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="cash"
                                    class="w-5 h-5"
                                    onchange="toggleCashInput(true)"
                                    {{ old('payment_method') == 'cash' ? 'checked' : '' }}
                                    required
                                >
                                <div class="flex-1">
                                    <div class="text-white font-medium">Cash</div>
                                    <div class="text-gray-400 text-sm">Pay with physical cash</div>
                                </div>
                            </label>

                            <label class="flex items-center gap-4 p-4 border border-gray-600 rounded-lg cursor-pointer hover:border-white transition">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="e-wallet"
                                    class="w-5 h-5"
                                    onchange="toggleCashInput(false)"
                                    {{ old('payment_method') == 'e-wallet' ? 'checked' : '' }}
                                >
                                <div class="flex-1">
                                    <div class="text-white font-medium">E-Wallet</div>
                                    <div class="text-gray-400 text-sm">GoPay, OVO, Dana, etc.</div>
                                </div>
                            </label>
                        </div>

                        <div id="cashAmountSection" class="mt-4 hidden">
                            <label class="block text-gray-400 mb-2">Cash Amount (Nominal Lengkap)</label>
                            <input
                                type="number"
                                name="cash_amount"
                                id="cashAmountInput"
                                value="{{ old('cash_amount') }}"
                                min="0"
                                placeholder="Contoh: 10000000"
                                class="w-full px-4 py-3 bg-[#2a2a2a] border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-white @error('cash_amount') border-red-500 @enderror"
                            >
                            @error('cash_amount')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <div id="changeDisplay" class="mt-3 text-green-400 font-medium hidden">
                                Change: IDR <span id="changeAmount">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-1">
                    <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-6 sticky top-32">
                        <h2 class="text-xl font-bold text-white mb-6">Order Summary</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-400">
                                <span>Subtotal</span>
                                <span>IDR {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-400">
                                <span>Tax (11%)</span>
                                <span>IDR {{ number_format($tax, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-gray-700 pt-3">
                                <div class="flex justify-between text-white font-bold text-2xl">
                                    <span>Total</span>
                                    <span id="totalAmount">IDR {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-white text-black py-3 rounded-lg hover:bg-gray-200 transition font-bold mb-3">
                            Complete Payment
                        </button>

                        <a href="{{ route('cart') }}" class="block w-full bg-[#2a2a2a] text-white text-center py-3 rounded-lg hover:bg-[#333] transition">
                            Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const totalInRupiah = {{ $total }};

    function toggleCashInput(show) {
        const cashSection = document.getElementById('cashAmountSection');
        const cashInput = document.getElementById('cashAmountInput');

        if (show) {
            cashSection.classList.remove('hidden');
            cashInput.required = true;
        } else {
            cashSection.classList.add('hidden');
            cashInput.required = false;
            cashInput.value = '';
            document.getElementById('changeDisplay').classList.add('hidden');
        }
    }

    document.getElementById('cashAmountInput')?.addEventListener('input', function() {
        const cashAmount = parseFloat(this.value) || 0;
        const change = cashAmount - totalInRupiah;
        const changeDisplay = document.getElementById('changeDisplay');
        const changeAmountSpan = document.getElementById('changeAmount');

        if (change >= 0) {
            changeAmountSpan.textContent = new Intl.NumberFormat('id-ID').format(change);
            changeDisplay.classList.remove('hidden');
        } else {
            changeDisplay.classList.add('hidden');
        }
    });

    @if(old('payment_method') == 'cash')
        toggleCashInput(true);
    @endif
</script>
@endsection
