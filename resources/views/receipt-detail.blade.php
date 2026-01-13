@extends('layouts.app')

@section('title', 'Receipt Detail - ALTAR4')

@section('content')
<div class="min-h-screen bg-[#2a2a2a] py-12 px-6">
    <div class="max-w-4xl mx-auto">
        <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-8">
            <!-- Header -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Receipt Details</h1>
                    <p class="text-gray-400">Transaction ID: {{ $transaction->transaction_id }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('receipt.print', $transaction->id) }}" class="flex items-center gap-2 px-4 py-2 border border-gray-600 text-white rounded-lg hover:bg-[#2a2a2a] transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print
                    </a>
                    <a href="{{ route('receipt.print', $transaction->id) }}" class="flex items-center gap-2 px-4 py-2 bg-white text-black rounded-lg hover:bg-gray-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download PDF
                    </a>
                </div>
            </div>

            <!-- Customer & Payment Info -->
            <div class="grid md:grid-cols-2 gap-6 mb-8 p-6 bg-[#2a2a2a] rounded-lg">
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
                    <p class="text-white font-medium">
                        {{ $transaction->transaction_date->format('d F Y, H:i') }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm mb-1">Payment Method</p>
                    <p class="text-white font-medium uppercase">{{ $transaction->payment_method }}</p>
                </div>
            </div>

            <!-- Items -->
            <div class="mb-8">
                <h3 class="text-white font-bold mb-4 text-xl">Items Purchased</h3>
                <div class="space-y-3">
                    @foreach($transaction->items as $item)
                        <div class="flex justify-between items-start p-4 bg-[#2a2a2a] rounded-lg">
                            <div class="flex-1">
                                <p class="text-white font-medium">{{ $item->product_name }}</p>
                                <p class="text-gray-400 text-sm">{{ $item->category }}</p>
                                <p class="text-gray-400 text-sm mt-1">
                                    {{ $item->quantity }} × Rp {{ number_format($item->price / 1000, 0) }}K
                                </p>
                            </div>
                            <div class="text-white font-bold">
                                Rp {{ number_format($item->subtotal / 1000, 0) }}K
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Totals -->
            <div class="border-t border-gray-700 pt-6 space-y-3">
                <div class="flex justify-between text-gray-400">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($transaction->subtotal / 1000, 0) }}K</span>
                </div>
                <div class="flex justify-between text-gray-400">
                    <span>Tax (11%)</span>
                    <span>Rp {{ number_format($transaction->tax / 1000, 0) }}K</span>
                </div>
                <div class="flex justify-between text-2xl font-bold text-white pt-3 border-t border-gray-700">
                    <span>Total</span>
                    <span>Rp {{ number_format($transaction->total / 1000, 0) }}K</span>
                </div>

                @if($transaction->payment_method === 'cash')
                    <div class="mt-6 p-4 bg-green-900/20 border border-green-700 rounded-lg">
                        <div class="flex justify-between text-green-400 mb-2">
                            <span>Cash Received</span>
                            <span>Rp {{ number_format($transaction->cash_amount / 1000, 0) }}K</span>
                        </div>
                        <div class="flex justify-between text-green-400">
                            <span>Change</span>
                            <span>Rp {{ number_format($transaction->change / 1000, 0) }}K</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Back Button -->
            <div class="mt-8">
                <a href="{{ route('receipts') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Receipt History
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
