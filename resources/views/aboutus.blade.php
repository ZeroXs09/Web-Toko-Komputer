@extends('layouts.app')

@section('title', 'About Us - ALTAR4')

@section('content')
<div class="bg-[#ffffff] border border-gray-300 rounded-lg p-6 shadow-xl/30 w-85 h-35 mx-60 mb-5 mt-5">
    <h2 style="color: #2F2F2F" class="text-xl text-center font-bold text-black mb-2">Tentang ALTAR</h2>
    <p class="text-black leading-relaxed text-center">
       Kepuasan pelanggan adalah inti dari setiap layanan yang kami berikan di ALTAR. Kami tidak hanya menjual produk, tetapi juga menawarkan perakitan PC yang dibuat sesuai dengan kebutuhan yang pas di setiap harga. Didukung oleh tim teknisi yang berpengalaman, kami memastikan setiap sistem yang dirakit di toko kami memiliki manajemen kabel yang rapi, aliran udara yang optimal, dan performa yang stabil. Dengan kombinasi antara produk premium, layanan purna jual yang responsif, dan integritas tinggi, ALTAR terus berusaha memberikan pengalaman berbelanja perangkat IT yang aman, nyaman, dan inspiratif.
    </p>
</div>

<<div class="max-w-5xl mx-auto mt-12 px-4 mb-16">
    <div class="bg-[#1a1a1a] rounded-[8px] border border-gray-700 overflow-hidden shadow-2xl">
        <div class="flex flex-col md:flex-row">

            <div class="w-full md:w-2/5 p-8 border-b md:border-b-0 md:border-r border-gray-700 bg-gradient-to-br from-[#1a1a1a] to-[#252525]">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-black-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Visit Our Location
                </h3>

                <div class="space-y-5 text-gray-300">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Store Address</p>
                        <p class="mt-1 leading-relaxed text-white">
                            Jl. Veteran No.1A, RT.005/RW.002, Babakan, Kec. Tangerang, <br>
                            Kota Tangerang, Banten 15118
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Operational Hours</p>
                        <p class="mt-1 text-white">Senin - Jumat: 06.00 - 15.00 WIB</p>
                        <p class="text-gray-400">Sabtu & Minggu: Tutup</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Phone / Contact</p>
                        <p class="mt-1 text-white font-medium">+62 838-9568-3472 </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-widest"> Email </p>
                        <P class="mt-1 text-white font-medium">AltarComputer@Gmail.com</P>
                    </div>
                </div>



                <a href="https://maps.google.com/?cid=13543257802007271501&g_mp=CiVnb29nbGUubWFwcy5wbGFjZXMudjEuUGxhY2VzLkdldFBsYWNl" target="_blank" class="mt-8 w-full justify-center inline-flex items-center gap-2 bg-black text-white px-5 py-3 rounded-[8px] font-bold transition shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    Buka di Google Maps
                </a>
            </div>

            <div class="w-full md:w-3/5 h-[350px] md:h-auto min-h-[400px]">
                <iframe
                    class="w-full h-full grayscale-[0.2] invert-[0.9] hue-rotate-[180deg] contrast-[0.9]"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.611140685608!2d106.6351776758671!3d-6.182772560578559!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e1f929162547c7%3A0xbbf3d137362e584d!2sSMK%20Negeri%204%20Kota%20Tangerang!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy">
                </iframe>
            </div>

        </div>
    </div>
</div>

        </div>
    </div>
</div>
@endsection
