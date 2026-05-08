@extends('layouts.app')

@section('title', 'Pembayaran E-Wallet - ALTAR4')

@section('content')
<div class="min-h-screen bg-[#2a2a2a] py-12 px-6">
    <div class="max-w-2xl mx-auto">
        <div class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-8 text-center shadow-2xl">
            <div class="mb-6">
                <svg class="w-16 h-16 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white mb-4">Pembayaran E-Wallet</h1>
            <p class="text-gray-400 mb-6">Scan QR code berikut menggunakan aplikasi <strong class="text-white uppercase">{{ $transaction->ewallet_provider }}</strong> untuk menyelesaikan pembayaran.</p>

            <div class="bg-white p-4 rounded-lg inline-block mx-auto mb-6">
                <img src="{{ route('checkout.qr', $transaction->id) }}" alt="QR Code" class="w-64 h-64 mx-auto">
            </div>

            <div class="bg-[#2a2a2a] rounded-lg p-4 mb-6 text-left">
                <p class="text-gray-400 text-sm">Detail Transaksi</p>
                <p class="text-white font-mono text-sm">ID: {{ $transaction->transaction_id }}</p>
                <p class="text-white font-bold">Total: IDR {{ number_format($transaction->total, 0, ',', '.') }}</p>
                <p class="text-gray-400 text-xs mt-2">Status: <span class="text-yellow-400">Pending (menunggu approval kasir)</span></p>
            </div>

            <div class="space-y-3">
                <a href="{{ route('receipt.show', $transaction->id) }}" class="inline-block w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition font-bold">
                    Lihat Detail Pesanan
                </a>
                <a href="{{ route('build') }}" class="inline-block w-full bg-[#2a2a2a] text-white py-3 rounded-lg hover:bg-[#333] transition border border-gray-700">
                    Kembali ke Beranda
                </a>
            </div>

            <p class="text-gray-500 text-xs mt-6">*Setelah melakukan pembayaran, pesanan akan diproses oleh kasir. Anda dapat melihat status di halaman Receipt History.</p>
        </div>
    </div>
</div>
@endsection
