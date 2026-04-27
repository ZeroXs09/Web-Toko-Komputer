@extends('layouts.app')

@section('title', 'Kasir - Pending Transactions')

@section('content')
    <div class="min-h-screen bg-[#2a2a2a] py-12 px-6">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-4xl font-bold text-white mb-8">Pending Transactions</h1>

            @if ($transactions->isEmpty())
                <div class="bg-[#1a1a1a] border border-white rounded-lg p-12 text-center">
                    <p class="text-gray-400 text-lg">Tidak ada transaksi pending.</p>
                </div>
            @else
                <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-[#2a2a2a] border-b border-gray-700">
                            <tr>
                                <th class="px-6 py-4 text-white">Transaction ID</th>
                                <th class="px-6 py-4 text-white">Customer</th>
                                <th class="px-6 py-4 text-white">Date</th>
                                <th class="px-6 py-4 text-white">Total</th>
                                <th class="px-6 py-4 text-white text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($transactions as $trx)
                                <tr>
                                    <td class="px-6 py-4 text-white font-mono">{{ $trx->transaction_id }}</td>
                                    <td class="px-6 py-4 text-gray-300">{{ $trx->customer_name }}</td>
                                    <td class="px-6 py-4 text-gray-300">{{ $trx->transaction_date->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-white">IDR {{ number_format($trx->total, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('receipt.show', $trx->id) }}"
                                            class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
