@extends('layouts.app')

@section('title', 'Receipt Detail - ALTAR4')

@section('content')
    <div class="min-h-screen bg-[#2a2a2a] py-12 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-8 shadow-2xl">

                {{-- Header dengan tombol approval (hanya untuk kasir & pending) --}}
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Receipt Details</h1>
                        <p class="text-gray-400 font-mono">Transaction ID: {{ $transaction->transaction_id }}</p>
                        @if ($transaction->status === 'pending')
                            <span class="inline-block mt-2 px-3 py-1 bg-yellow-600 text-white text-xs rounded-full">Menunggu
                                Persetujuan</span>
                        @elseif($transaction->status === 'approved')
                            <span
                                class="inline-block mt-2 px-3 py-1 bg-green-600 text-white text-xs rounded-full">Disetujui</span>
                        @else
                            <span
                                class="inline-block mt-2 px-3 py-1 bg-red-600 text-white text-xs rounded-full">Ditolak</span>
                        @endif
                    </div>
                    <div class="flex gap-3">
                        @if (Auth::user()->role == 2 && $transaction->status === 'pending')
                            {{-- Tombol Approve --}}
                            <form action="{{ route('kasir.approve', $transaction->id) }}" method="POST"
                                onsubmit="return confirm('Setujui transaksi ini? Stok akan berkurang.')">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Approve
                                </button>
                            </form>

                            {{-- Tombol Reject (buka modal) --}}
                            <button type="button" onclick="openRejectModal()"
                                class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reject
                            </button>
                        @endif

                        @if ($transaction->status === 'approved')
                            <a href="{{ route('receipt.print', $transaction->id) }}"
                                class="flex items-center gap-2 px-4 py-2 bg-white text-black rounded-lg hover:bg-gray-200 transition font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download PDF
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Tampilkan alasan reject jika status rejected dan ada isinya --}}
                @if ($transaction->status === 'rejected')
                    <div class="mb-6 p-4 bg-red-900/30 border border-red-700 rounded-lg">
                        <p class="text-red-300 text-sm font-bold mb-1">Reason for Rejection:</p>
                        <p class="text-white text-sm">
                            {{ $transaction->rejection_reason ?? 'Tidak ada alasan yang diberikan.' }}</p>
                    </div>
                @endif

                {{-- Informasi transaksi --}}
                <div class="grid md:grid-cols-2 gap-6 mb-8 p-6 bg-[#2a2a2a] rounded-lg border border-gray-700">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Customer Name</p>
                        <p class="text-white font-medium">{{ $transaction->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Phone Number</p>
                        <p class="text-white font-medium">{{ $transaction->customer_phone }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Date & Time</p>
                        <p class="text-white font-medium">{{ $transaction->transaction_date->format('d F Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Payment Method</p>
                        <p
                            class="text-white font-medium uppercase px-2 py-0.5 bg-[#333] rounded w-fit text-xs border border-gray-600">
                            {{ $transaction->payment_method }}
                        </p>
                    </div>
                    <div class="md:col-span-2 pt-4 border-t border-gray-700">
                        <p class="text-gray-400 text-sm mb-1">Shipping Address</p>
                        <p class="text-white font-medium leading-relaxed italic">"{{ $transaction->customer_address }}"</p>
                    </div>
                </div>

                {{-- Items purchased --}}
                <div class="mb-8">
                    <h3 class="text-white font-bold mb-4 text-xl">Items Purchased</h3>
                    <div class="space-y-3">
                        @foreach ($transaction->items as $item)
                            <div
                                class="flex justify-between items-start p-4 bg-[#2a2a2a] rounded-lg border border-gray-700/50">
                                <div class="flex-1">
                                    <p class="text-white font-medium">{{ $item->product_name }}</p>
                                    <p class="text-gray-400 text-xs uppercase tracking-wider">{{ $item->category }}</p>
                                    <p class="text-gray-400 text-sm mt-1">
                                        {{ $item->quantity }} × IDR {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-white font-bold">IDR {{ number_format($item->subtotal, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Total & payment info --}}
                <div class="border-t border-gray-700 pt-6 space-y-3">
                    <div class="flex justify-between text-gray-400">
                        <span>Subtotal</span>
                        <span>IDR {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-400">
                        <span>Tax (11%)</span>
                        <span>IDR {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-2xl font-bold text-white pt-4 border-t-2 border-gray-700">
                        <span>Total</span>
                        <span class="text-white">IDR {{ number_format($transaction->total, 0, ',', '.') }}</span>
                    </div>

                    @if ($transaction->payment_method === 'cash')
                        <div class="mt-6 p-5 bg-green-900/10 border border-green-800/50 rounded-lg space-y-2">
                            <div class="flex justify-between text-gray-300 text-sm">
                                <span>Cash Received</span>
                                <span>IDR {{ number_format($transaction->cash_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-green-400 font-bold text-lg">
                                <span>Change</span>
                                <span>IDR {{ number_format($transaction->change, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endif

                    @if ($transaction->payment_method === 'e-wallet' && $transaction->ewallet_provider)
                        <div>
                            <p class="text-gray-400 text-sm mb-1">E-Wallet Provider</p>
                            <p class="text-white font-medium uppercase">{{ $transaction->ewallet_provider }}</p>
                        </div>
                    @endif
                </div>

                <div class="mt-8 pt-8 border-t border-gray-800 flex justify-center">
                    <a href="{{ route('receipts') }}"
                        class="inline-flex items-center gap-2 text-gray-500 hover:text-white transition group">
                        <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Receipt History
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Reject --}}
    <div id="rejectModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity duration-300"
                onclick="closeRejectModal()"></div>
            <div class="relative bg-[#1a1a1a] border border-gray-700 rounded-xl p-8 max-w-md w-full shadow-2xl transform transition-all duration-300 scale-95 opacity-0"
                id="rejectModalCard">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-white uppercase tracking-tight">Reject Transaction</h3>
                    <button onclick="closeRejectModal()"
                        class="text-gray-400 hover:text-white transition-colors text-xl">✕</button>
                </div>
                <form id="rejectForm" action="{{ route('kasir.reject', $transaction->id) }}" method="POST"
                    class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-gray-400 text-sm block mb-2">Reason for Rejection</label>
                        <textarea name="rejection_reason" rows="4" placeholder="Masukkan alasan penolakan (minimal 5 karakter)..."
                            class="w-full p-3 bg-[#2a2a2a] border border-gray-600 rounded-lg text-white focus:border-red-500 outline-none transition-all"
                            required></textarea>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" onclick="closeRejectModal()"
                            class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-bold">Ya,
                            Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal() {
            const modal = document.getElementById('rejectModal');
            const card = document.getElementById('rejectModalCard');
            modal.classList.remove('hidden');
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            const card = document.getElementById('rejectModalCard');
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                background: '#1a1a1a',
                color: '#fff',
                timer: 2500,
                showConfirmButton: false,
                iconColor: '#4ade80'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                background: '#1a1a1a',
                color: '#fff',
                timer: 3000,
                showConfirmButton: true,
                confirmButtonColor: '#ef4444'
            });
        </script>
    @endif

@endsection
