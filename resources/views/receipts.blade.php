@extends('layouts.app')

@section('title', 'Receipt History - ALTAR4')

@section('content')

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.3s;
        }
    </style>

    <div class="min-h-screen bg-[#2a2a2a] py-12 px-6">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-4xl font-bold text-white mb-8 animate-fade-up">Receipt History</h1>

            {{-- Stats Cards --}}
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                {{-- Card 1 --}}
                <div
                    class="bg-[#1a1a1a] border border-white/10 rounded-lg p-6 animate-fade-up delay-1 hover:border-white transition-all duration-300 hover:-translate-y-2 shadow-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Total Revenue</p>
                            <p class="text-2xl font-bold text-white">IDR {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div
                    class="bg-[#1a1a1a] border border-white/10 rounded-lg p-6 animate-fade-up delay-2 hover:border-white transition-all duration-300 hover:-translate-y-2 shadow-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Total Transactions</p>
                            <p class="text-2xl font-bold text-white">{{ $totalTransactions }}</p>
                        </div>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div
                    class="bg-[#1a1a1a] border border-white/10 rounded-lg p-6 animate-fade-up delay-3 hover:border-white transition-all duration-300 hover:-translate-y-2 shadow-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Items Sold</p>
                            <p class="text-2xl font-bold text-white">{{ $totalItems }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Search Bar --}}
            <div class="mb-6 animate-fade-up delay-3">
                <form action="{{ route('receipts') }}" method="GET">
                    <div class="relative max-w-xl group">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5 group-focus-within:text-white transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" placeholder="Search by ID or customer..."
                            value="{{ request('search') }}"
                            class="w-full pl-12 pr-4 py-3 bg-[#1a1a1a] border border-white/20 text-white rounded-lg placeholder:text-gray-500 focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all" />
                    </div>
                </form>
            </div>

            {{-- Table Section --}}
            <div class="bg-[#1a1a1a] border border-white/10 rounded-lg overflow-hidden animate-fade-up shadow-2xl"
                style="animation-delay: 0.4s">
                @if ($transactions->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-gray-400">No transactions found.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-[#2a2a2a] border-b border-white/10">
                                <tr>
                                    <th class="px-6 py-4 text-white font-medium uppercase text-xs tracking-wider">ID</th>
                                    <th class="px-6 py-4 text-white font-medium uppercase text-xs tracking-wider">Customer
                                    </th>
                                    <th class="px-6 py-4 text-white font-medium uppercase text-xs tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-white font-medium uppercase text-xs tracking-wider">Total</th>
                                    <th class="px-6 py-4 text-white font-medium uppercase text-xs tracking-wider">Status
                                    </th> {{-- Tambahan kolom status --}}
                                    <th
                                        class="px-6 py-4 text-white font-medium uppercase text-xs tracking-wider text-right">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach ($transactions as $transaction)
                                    <tr class="hover:bg-white/5 transition-colors duration-200 group">
                                        <td class="px-6 py-4 text-white font-medium">{{ $transaction->transaction_id }}</td>
                                        <td class="px-6 py-4 text-gray-300">
                                            <div>{{ $transaction->customer_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $transaction->customer_phone }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-400 text-sm">
                                            {{ $transaction->transaction_date->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-white font-bold">IDR
                                            {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                            @if ($transaction->status == 'pending')
                                                <span
                                                    class="px-2 py-1 bg-yellow-600 text-white text-xs rounded-full">Pending</span>
                                            @elseif($transaction->status == 'approved')
                                                <span
                                                    class="px-2 py-1 bg-green-600 text-white text-xs rounded-full">Approved</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div
                                                class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                {{-- Tombol View --}}
                                                <a href="{{ route('receipt.show', $transaction->id) }}" title="View Detail"
                                                    class="p-2 bg-blue-500/10 text-blue-400 rounded-md hover:bg-blue-500 hover:text-white transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                </a>

                                                {{-- Tombol Print --}}
                                                <a href="{{ route('receipt.print', $transaction->id) }}"
                                                    title="Print Receipt"
                                                    class="p-2 bg-gray-500/10 text-gray-400 rounded-md hover:bg-gray-100 hover:text-black transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                                        </path>
                                                    </svg>
                                                </a>

                                                {{-- Tombol Approve (hanya untuk kasir & status pending) --}}
                                                @if (Auth::user()->role == 2 && $transaction->status == 'pending')
                                                    <form action="{{ route('kasir.approve', $transaction->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Setujui transaksi ini? Stok akan berkurang.')">
                                                        @csrf
                                                        <button type="submit" title="Approve"
                                                            class="p-2 bg-green-500/10 text-green-400 rounded-md hover:bg-green-500 hover:text-white transition-all">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- Tombol Reject (hanya untuk kasir & status pending) --}}
                                                @if (Auth::user()->role == 2 && $transaction->status == 'pending')
                                                    <form action="{{ route('kasir.reject', $transaction->id) }}"
                                                        method="POST" onsubmit="return confirm('Tolak transaksi ini?')">
                                                        @csrf
                                                        <button type="submit" title="Reject"
                                                            class="p-2 bg-red-500/10 text-red-400 rounded-md hover:bg-red-500 hover:text-white transition-all">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- Tombol Delete (hanya untuk customer atau kasir, terserah) --}}
                                                @if (Auth::user()->role != 2 || $transaction->status == 'rejected')
                                                    <form action="{{ route('receipt.delete', $transaction->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus riwayat transaksi ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete"
                                                            class="p-2 bg-red-500/10 text-red-400 rounded-md hover:bg-red-500 hover:text-white transition-all">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
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
