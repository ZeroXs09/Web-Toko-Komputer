@extends('layouts.app')

@section('title', 'Checkout - ALTAR4')

@section('content')
    <div class="min-h-screen bg-[#2a2a2a] py-12 px-6">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-4xl font-bold text-white mb-8">
                <span id="typewriter-checkout"></span>
            </h1>

            <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                @csrf
                <div class="grid md:grid-cols-3 gap-8">

                    <!-- Kolom Kiri: Informasi Customer & Payment -->
                    <div class="md:col-span-2 space-y-6">

                        <!-- Customer Information -->
                        <div
                            class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-6 transition-all duration-300 hover:border-white/30">
                            <h2 class="text-xl font-bold text-white mb-6">Customer Information</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-gray-400 mb-2">Full Name *</label>
                                    <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                                        class="w-full px-4 py-3 bg-[#2a2a2a] border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-white transition-all @error('customer_name') border-red-500 @enderror"
                                        required>
                                    @error('customer_name')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-gray-400 mb-2">Phone Number *</label>
                                    <input type="number" name="customer_phone" value="{{ old('customer_phone') }}"
                                        class="w-full px-4 py-3 bg-[#2a2a2a] border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-white transition-all @error('customer_phone') border-red-500 @enderror"
                                        required>
                                    @error('customer_phone')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-6">
                                <h3 class="text-white font-bold text-lg mb-4">Shipping Address</h3>
                                <textarea name="customer_address" rows="4"
                                    class="w-full px-4 py-3 bg-[#2a2a2a] border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-white transition-all @error('customer_address') border-red-500 @enderror"
                                    placeholder="Contoh: Jl. Veteran No.1A, Babakan, Tangerang. Kode Pos: 15118" required>{{ old('customer_address') }}</textarea>
                                @error('customer_address')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div
                            class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-6 transition-all duration-300 hover:border-white/30">
                            <h2 class="text-xl font-bold text-white mb-6">Payment Method</h2>
                            <div class="space-y-3">


                                <!-- E-Wallet -->
                                <label
                                    class="flex items-center gap-4 p-4 border border-gray-600 rounded-lg cursor-pointer hover:border-white transition">
                                    <input type="radio" name="payment_method" value="e-wallet" class="w-5 h-5"
                                        onchange="togglePaymentFields('e-wallet')"
                                        {{ old('payment_method') == 'e-wallet' ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <div class="text-white font-medium">E-Wallet</div>
                                        <div class="text-gray-400 text-sm">GoPay, OVO, Dana, etc.</div>
                                    </div>
                                </label>

                                <!-- Credit Card -->
                                <label
                                    class="flex items-center gap-4 p-4 border border-gray-600 rounded-lg cursor-pointer hover:border-white transition">
                                    <input type="radio" name="payment_method" value="credit_card" class="w-5 h-5"
                                        onchange="togglePaymentFields('credit_card')"
                                        {{ old('payment_method') == 'credit_card' ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <div class="text-white font-medium">Credit Card</div>
                                        <div class="text-gray-400 text-sm">Visa or MasterCard</div>
                                    </div>
                                </label>
                            </div>

                          
                            <!-- E-Wallet Provider Section (muncul jika e-wallet dipilih) -->
                            <div id="ewalletProviderSection" class="mt-4 hidden border-t border-gray-700 pt-4">
                                <label class="block text-gray-400 mb-2 text-sm uppercase tracking-wider font-bold">Pilih
                                    E-Wallet</label>
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <label
                                        class="flex items-center gap-2 p-3 border border-gray-600 rounded-lg cursor-pointer hover:border-white transition">
                                        <input type="radio" name="ewallet_provider" value="gopay" class="w-4 h-4"
                                            onchange="generateQRCode()">
                                        <span class="text-white">GoPay</span>
                                    </label>
                                    <label
                                        class="flex items-center gap-2 p-3 border border-gray-600 rounded-lg cursor-pointer hover:border-white transition">
                                        <input type="radio" name="ewallet_provider" value="ovo" class="w-4 h-4"
                                            onchange="generateQRCode()">
                                        <span class="text-white">OVO</span>
                                    </label>
                                    <label
                                        class="flex items-center gap-2 p-3 border border-gray-600 rounded-lg cursor-pointer hover:border-white transition">
                                        <input type="radio" name="ewallet_provider" value="dana" class="w-4 h-4"
                                            onchange="generateQRCode()">
                                        <span class="text-white">Dana</span>
                                    </label>
                                    <label
                                        class="flex items-center gap-2 p-3 border border-gray-600 rounded-lg cursor-pointer hover:border-white transition">
                                        <input type="radio" name="ewallet_provider" value="linkaja" class="w-4 h-4"
                                            onchange="generateQRCode()">
                                        <span class="text-white">LinkAja</span>
                                    </label>
                                </div>
                                <div id="qrCodeContainer"
                                    class="hidden flex flex-col items-center justify-center p-4 bg-white rounded-lg">
                                    <p class="text-black text-sm mb-2">Scan QR Code dengan aplikasi <span
                                            id="selectedProviderLabel">E-Wallet</span></p>
                                    <div id="qrCodeImage" class="w-48 h-48 bg-gray-200 flex items-center justify-center">
                                        <img src="" alt="QR Code" class="w-full h-full object-contain">
                                    </div>
                                    <p class="text-gray-500 text-xs mt-2">*Simulasi pembayaran. Setelah scan, klik Complete
                                        Payment.</p>
                                </div>
                                @error('ewallet_provider')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Credit Card Section (muncul jika credit card dipilih) -->
                            <div id="creditCardSection" class="mt-4 hidden border-t border-gray-700 pt-4 space-y-4">
                                <div>
                                    <label class="block text-gray-400 mb-2 text-sm uppercase tracking-wider font-bold">Card
                                        Number</label>
                                    <input type="text" name="card_number" placeholder="4444 4444 4444 4444"
                                        maxlength="19"
                                        class="w-full px-4 py-3 bg-[#2a2a2a] border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-white font-mono">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-gray-400 mb-2 text-sm uppercase tracking-wider font-bold">Expiry
                                            Date</label>
                                        <input type="text" name="expiry" placeholder="MM/YY" maxlength="5"
                                            class="w-full px-4 py-3 bg-[#2a2a2a] border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-white">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-gray-400 mb-2 text-sm uppercase tracking-wider font-bold">CVV</label>
                                        <input type="password" name="cvv" placeholder="***" maxlength="3"
                                            class="w-full px-4 py-3 bg-[#2a2a2a] border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-white">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Order Summary -->
                    <div class="md:col-span-1">
                        <div
                            class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-6 sticky top-32 transition-all duration-300 hover:shadow-xl">
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
                            <button type="submit" id="completePaymentBtn"
                                class="w-full bg-white text-black py-3 rounded-lg hover:bg-gray-200 transition-all font-bold mb-3 transform hover:scale-[1.02] active:scale-95">
                                Complete Payment
                            </button>
                            <a href="{{ route('cart') }}"
                                class="block w-full bg-[#2a2a2a] text-white text-center py-3 rounded-lg hover:bg-[#333] transition border border-gray-700">
                                Back to Cart
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        // Typewriter
        document.addEventListener('DOMContentLoaded', function() {
            new Typed('#typewriter-checkout', {
                strings: ['Checkout'],
                typeSpeed: 100,
                showCursor: true,
                cursorChar: '_',
                loop: false
            });
        });

        // Data total (dari server)
        const totalInRupiah = {{ $total }};

        // Toggle tampilan berdasarkan metode pembayaran
        function togglePaymentFields(method) {
            const cashSection = document.getElementById('cashAmountSection');
            const ewalletSection = document.getElementById('ewalletProviderSection');
            const ccSection = document.getElementById('creditCardSection');
            const cashInput = document.getElementById('cashAmountInput');

            if (cashSection) cashSection.classList.add('hidden');
            if (ewalletSection) ewalletSection.classList.add('hidden');
            if (ccSection) ccSection.classList.add('hidden');
            if (cashInput) cashInput.required = false;

            if (method === 'cash') {
                if (cashSection) cashSection.classList.remove('hidden');
                if (cashInput) cashInput.required = true;
            } else if (method === 'e-wallet') {
                if (ewalletSection) ewalletSection.classList.remove('hidden');
                // Jangan lupa sembunyikan QR jika belum pilih provider
                document.getElementById('qrCodeContainer')?.classList.add('hidden');
            } else if (method === 'credit_card') {
                if (ccSection) ccSection.classList.remove('hidden');
            }
        }

        // Generate QR simulasi berdasarkan provider yang dipilih
        function generateQRCode() {
            const selected = document.querySelector('input[name="ewallet_provider"]:checked');

            if (!selected) return;

            const provider = selected.value;

            const providerLabel = document.getElementById('selectedProviderLabel');
            providerLabel.innerText = provider.toUpperCase();

            const qrContainer = document.getElementById('qrCodeContainer');
            const qrImage = document.querySelector('#qrCodeImage img');

            // Data QR
            const qrText =
                `Pembayaran ALTAR PC - ${provider.toUpperCase()} - Total Rp {{ $total }}`;

            // Generate QR online
            qrImage.src =
                `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(qrText)}`;

            qrContainer.classList.remove('hidden');
        }

        // Hitung kembalian cash
        const cashInput = document.getElementById('cashAmountInput');
        if (cashInput) {
            cashInput.addEventListener('input', function() {
                const cashAmount = parseFloat(this.value) || 0;
                const change = cashAmount - totalInRupiah;
                const changeDisplay = document.getElementById('changeDisplay');
                const changeAmountSpan = document.getElementById('changeAmount');
                if (change >= 0) {
                    if (changeAmountSpan) changeAmountSpan.textContent = new Intl.NumberFormat('id-ID').format(
                        change);
                    if (changeDisplay) changeDisplay.classList.remove('hidden');
                } else {
                    if (changeDisplay) changeDisplay.classList.add('hidden');
                }
            });
        }

        // Format credit card number
        const cardNumber = document.getElementById('card_number');
        if (cardNumber) {
            cardNumber.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                let formatted = value.match(/.{1,4}/g)?.join(' ') || '';
                e.target.value = formatted;
            });
        }

        // Format expiry
        const expiry = document.getElementById('expiry');
        if (expiry) {
            expiry.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 2) {
                    e.target.value = value.slice(0, 2) + '/' + value.slice(2, 4);
                } else {
                    e.target.value = value;
                }
            });
        }

        // Submit validation untuk e-wallet (provider wajib + konfirmasi QR)
        const checkoutForm = document.getElementById('checkoutForm');
        checkoutForm.addEventListener('submit', function(e) {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethod) {
                e.preventDefault();
                alert('Pilih metode pembayaran terlebih dahulu.');
                return false;
            }

            if (paymentMethod.value === 'e-wallet') {
                const provider = document.querySelector('input[name="ewallet_provider"]:checked');
                if (!provider) {
                    e.preventDefault();
                    alert('Pilih provider e-wallet (GoPay, OVO, Dana, atau LinkAja).');
                    return false;
                }
                // Simulasi konfirmasi pembayaran dengan QR
                if (!confirm(
                        'Apakah Anda sudah melakukan pembayaran dengan memindai QR code? Klik OK untuk melanjutkan.'
                    )) {
                    e.preventDefault();
                    return false;
                }
            }

            if (paymentMethod.value === 'cash') {
                const cashAmount = parseFloat(document.getElementById('cashAmountInput')?.value || 0);
                if (cashAmount < totalInRupiah) {
                    e.preventDefault();
                    alert('Jumlah uang cash tidak mencukupi.');
                    return false;
                }
            }

            // Nonaktifkan tombol submit setelah submit (mencegah double)
            const submitBtn = document.getElementById('completePaymentBtn');
            if (submitBtn) submitBtn.disabled = true;
            return true;
        });

        // Menjalankan toggle awal berdasarkan old value atau default
        document.addEventListener('DOMContentLoaded', function() {
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
            if (selectedMethod) {
                togglePaymentFields(selectedMethod.value);
                if (selectedMethod.value === 'e-wallet') {
                    // Jika ada old value provider, set ulang QR
                    const oldProvider = document.querySelector('input[name="ewallet_provider"]:checked');
                    if (oldProvider) generateQRCode();
                }
            }
            // Trigger cash change jika ada old value
            if (cashInput && cashInput.value) cashInput.dispatchEvent(new Event('input'));
        });
    </script>
@endsection
