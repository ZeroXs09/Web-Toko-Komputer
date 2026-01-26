@extends('layouts.app')

@section('title', 'Receipt Detail - ALTAR4')

@section('content')
<div class="min-h-screen bg-[#2a2a2a] py-12 px-6">
    <div class="max-w-4xl mx-auto">
        <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-8 shadow-2xl">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Receipt Details</h1>
                    <p class="text-gray-400 font-mono">Transaction ID: {{ $transaction->transaction_id }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('receipt.print', $transaction->id) }}" class="flex items-center gap-2 px-4 py-2 bg-white text-black rounded-lg hover:bg-gray-200 transition font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download PDF
                    </a>
                </div>
            </div>

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
                    <p class="text-white font-medium">
                        {{ $transaction->transaction_date->format('d F Y, H:i') }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm mb-1">Payment Method</p>
                    <p class="text-white font-medium uppercase px-2 py-0.5 bg-[#333] rounded w-fit text-xs border border-gray-600">
                        {{ $transaction->payment_method }}
                    </p>
                </div>
                <div class="md:col-span-2 pt-4 border-t border-gray-700">
                    <p class="text-gray-400 text-sm mb-1">Shipping Address</p>
                    <p class="text-white font-medium leading-relaxed italic">
                        "{{ $transaction->customer_address }}"
                    </p>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-white font-bold mb-4 text-xl">Items Purchased</h3>
                <div class="space-y-3">
                    @foreach($transaction->items as $item)
                        <div class="flex justify-between items-start p-4 bg-[#2a2a2a] rounded-lg border border-gray-700/50">
                            <div class="flex-1">
                                <p class="text-white font-medium">{{ $item->product_name }}</p>
                                <p class="text-gray-400 text-xs uppercase tracking-wider">{{ $item->category }}</p>
                                <p class="text-gray-400 text-sm mt-1">
                                    {{ $item->quantity }} × IDR {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="text-white font-bold">
                                IDR {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

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

                @if($transaction->payment_method === 'cash')
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
            </div>

            <div class="mt-8 pt-8 border-t border-gray-800 flex justify-center">
                <a href="{{ route('receipts') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-white transition group">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Receipt History
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
