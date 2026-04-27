@extends('layouts.app')

@section('title', 'About Us - ALTAR4')

@section('content')

<style>
    /* Animasi Fade In Up untuk Container */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }

    /* Styling kursor typewriter */
    .typewriter-text::after {
        content: '|';
        animation: blink 0.7s infinite;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0; }
    }
</style>

<div class="min-h-screen bg-[#2a2a2a] py-10">
    {{-- Section Tentang ALTAR --}}
    <div class="bg-white border border-gray-300 rounded-lg p-8 shadow-2xl max-w-4xl mx-auto mb-12 animate-fade-up">
        <h2 style="color: #2F2F2F" class="text-2xl text-center font-bold mb-4 uppercase tracking-wider">Tentang ALTAR</h2>

        {{-- Area Typewriter --}}
        <p id="typewriter" class="text-black leading-relaxed text-center min-h-[100px] typewriter-text text-lg italic">
            </p>
    </div>

    {{-- Section Lokasi --}}
    <div class="max-w-6xl mx-auto px-4 animate-fade-up" style="animation-delay: 0.4s">
        <div class="bg-[#1a1a1a] rounded-xl border border-white/20 overflow-hidden shadow-2xl">
            <div class="flex flex-col md:flex-row">
                {{-- Info Panel --}}
                <div class="w-full md:w-2/5 p-8 border-b md:border-b-0 md:border-r border-gray-700 bg-gradient-to-br from-[#1a1a1a] to-[#252525]">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Visit Our Location
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Store Address</p>
                            <p class="mt-1 leading-relaxed text-white">
                                Jl. Veteran No.1A, RT.005/RW.002, Babakan, Kec. Tangerang, <br>
                                Kota Tangerang, Banten 15118
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Operational Hours</p>
                            <p class="mt-1 text-white font-medium">Senin - Jumat: 06.00 - 15.00 WIB</p>
                            <p class="text-gray-500">Sabtu & Minggu: Tutup</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Phone</p>
                                <p class="text-white text-sm">+62 838-9568-3472</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Email</p>
                                <p class="text-white text-sm text-wrap">AltarComputer@Gmail.com</p>
                            </div>
                        </div>
                    </div>

                    <a href="https://maps.google.com" target="_blank" class="mt-8 w-full justify-center inline-flex items-center gap-2 bg-white text-black px-5 py-3 rounded-lg font-bold hover:bg-gray-200 transition-all duration-300 shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        Buka di Google Maps
                    </a>
                </div>

                {{-- Map Panel --}}
                <div class="w-full md:w-3/5 h-[400px] md:h-auto overflow-hidden">
                    <iframe
                        class="w-full h-full grayscale-[0.2] invert-[0.9] hue-rotate-[180deg] contrast-[0.9]"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.657!2d106.63!3d-6.175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTAnMzAuMCJTIDEwNsKwMzcnNDguMCJF!5e0!3m2!1sen!2sid!4v1"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script Typewriter --}}
<script>
    const text = "Kepuasan pelanggan adalah inti dari setiap layanan yang kami berikan di ALTAR. Kami tidak hanya menjual produk, tetapi juga menawarkan perakitan PC yang dibuat sesuai dengan kebutuhan yang pas di setiap harga. Didukung oleh tim teknisi yang berpengalaman, kami memastikan setiap sistem yang dirakit di toko kami memiliki manajemen kabel yang rapi, aliran udara yang optimal, dan performa yang stabil. Dengan kombinasi antara produk premium, layanan purna jual yang responsif, dan integritas tinggi, ALTAR terus berusaha memberikan pengalaman berbelanja perangkat IT yang aman, nyaman, dan inspiratif.";

    let index = 0;
    const speed = 22; // Kecepatan mengetik (ms)
    const target = document.getElementById("typewriter");

    function typeWriter() {
        if (index < text.length) {
            target.innerHTML += text.charAt(index);
            index++;
            setTimeout(typeWriter, speed);
        } else {
            // Menghilangkan kursor saat selesai
            target.classList.remove('typewriter-text');
        }
    }

    // Jalankan saat halaman selesai dimuat
    window.onload = typeWriter;
</script>
@endsection
