@extends('layouts.app')

@section('title', 'Receipt History - ALTAR4')

@section('content')
<div class="min-h-screen bg-[#2a2a2a] py-12 px-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-white mb-8">Receipt History</h1>

        <!-- Statistics -->
        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Total Revenue</p>
                        <p class="text-2xl font-bold text-white">
                            Rp {{ number_format($totalRevenue / 1000, 0) }}K
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Total Transactions</p>
                        <p class="text-2xl font-bold text-white">{{ $totalTransactions }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Items Sold</p>
                        <p class="text-2xl font-bold text-white">{{ $totalItems }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="mb-6">
            <form action="{{ route('receipts') }}" method="GET">
                <div class="relative max-w-xl">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input
                        type="text"
                        name="search"
                        placeholder="Search by ID or customer..."
                        value="{{ request('search') }}"
                        class="w-full pl-12 pr-4 py-3 bg-[#1a1a1a] border border-gray-700 text-white rounded-lg placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-white"
                    />
                </div>
            </form>
        </div>

        <!-- Receipts Table -->
        <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg overflow-hidden">
            @if($transactions->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto text-gray-500 mb-4 w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-400">No receipts found</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-[#2a2a2a] border-b border-gray-700">
                            <tr>
                                <th class="px-6 py-4 text-left text-white font-medium">Transaction ID</th>
                                <th class="px-6 py-4 text-left text-white font-medium">Customer</th>
                                <th class="px-6 py-4 text-left text-white font-medium">Date</th>
                                <th class="px-6 py-4 text-left text-white font-medium">Items</th>
                                <th class="px-6 py-4 text-left text-white font-medium">Payment</th>
                                <th class="px-6 py-4 text-left text-white font-medium">Total</th>
                                <th class="px-6 py-4 text-left text-white font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach($transactions as $transaction)
                                <tr class="hover:bg-[#2a2a2a] transition">
                                    <td class="px-6 py-4">
                                        <span class="text-white font-medium">{{ $transaction->transaction_id }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-white">{{ $transaction->customer_name }}</div>
                                        <div class="text-gray-400 text-sm">{{ $transaction->customer_phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">
                                        {{ $transaction->transaction_date->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">
                                        {{ $transaction->items->sum('quantity') }} items
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-[#2a2a2a] text-white rounded-full text-sm uppercase">
                                            {{ $transaction->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-white font-bold">
                                        Rp {{ number_format($transaction->total / 1000, 0) }}K
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('receipt.show', $transaction->id) }}" class="text-blue-400 hover:text-blue-300 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('receipt.print', $transaction->id) }}" class="text-gray-400 hover:text-white transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('receipt.delete', $transaction->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this receipt?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
