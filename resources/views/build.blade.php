@extends('layouts.app')

@section('title', 'Build Your Dream PC - ALTAR4')

@section('content')
    <div class="min-h-screen bg-[#2a2a2a]">
        {{-- Hero Section --}}
        <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2a2a2a] py-16 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h1 class="text-5xl font-bold text-white mb-6">Build Your Dream PC</h1>
                        <p class="text-gray-300 text-lg mb-6">Select your components and create the perfect gaming setup
                            tailored to your needs.</p>
                        <div class="flex items-center gap-6 text-gray-400">
                            <div class="flex items-center gap-2"><svg class="w-5 h-5 text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg><span>Compatibility Check</span></div>
                            <div class="flex items-center gap-2"><svg class="w-5 h-5 text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg><span>Best Prices</span></div>
                        </div>
                    </div>
                    <div><img
                            src="https://images.unsplash.com/photo-1591405351990-4726e331f141?q=80&w=1170&auto=format&fit=crop"
                            alt="Gaming PC"
                            class="rounded-lg w-full h-[350px] object-cover shadow-2xl border border-gray-700 hover:scale-105 transition duration-700">
                    </div>
                </div>
            </div>
        </div>

        {{-- Category Nav --}}
        <div class="bg-[#1a1a1a] border-b border-white sticky top-[88px] z-10">
            <div class="max-w-7xl mx-auto px-6 py-4">
                <div class="flex gap-3 overflow-x-auto no-scrollbar">
                    @foreach ($categories as $category)
                        <a href="{{ route('build', ['category' => $category, 'search' => request('search')]) }}"
                            class="px-6 py-2 rounded-lg whitespace-nowrap transition-all duration-300 font-medium {{ request('category', 'All') == $category ? 'bg-black text-white ring-1 ring-white' : 'bg-[#2a2a2a] text-gray-300 hover:bg-[#333] hover:scale-105' }}">{{ $category }}</a>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="w-full px-6 py-12">
            <div class="max-w-[1600px] mx-auto">

                <div class="mb-10 flex justify-between items-center gap-4">
                    <form action="{{ route('build') }}" method="GET" class="w-full max-w-xl">
                        <input type="hidden" name="category" value="{{ request('category', 'All') }}">
                        <div class="relative group">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5 group-focus-within:text-white transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" name="search" placeholder="Search components by name..."
                                value="{{ request('search') }}"
                                class="w-full pl-12 pr-4 py-3 bg-[#1a1a1a] border border-white/20 text-white rounded-lg placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent transition-all duration-300" />
                        </div>
                    </form>
                    @auth @if (auth()->user()->role == 1)
                        <button onclick="openTambahModal()"
                            class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-lg font-bold transition-all duration-300 shadow-lg hover:shadow-blue-600/30 active:scale-95 whitespace-nowrap">+
                            Tambah Produk Baru</button>
                    @endif @endauth
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse ($products as $product)
                        <div
                            class="product-card bg-[#1a1a1a] border border-white/10 rounded-xl overflow-hidden flex flex-col transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl hover:border-white/30 group h-full">
                            <div class="relative overflow-hidden">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-56 object-cover group-hover:scale-110 transition duration-700 ease-out"
                                    onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'">
                                <div
                                    class="absolute top-3 left-3 bg-black/60 backdrop-blur-md text-white text-[10px] uppercase tracking-widest px-2 py-1 rounded">
                                    {{ $product->category }}</div>
                                @if ($product->stock <= 0)
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center"><span
                                            class="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-bold">SOLD
                                            OUT</span></div>
                                @endif
                            </div>
                            <div class="p-5 flex flex-col flex-grow">
                                <h3
                                    class="font-bold text-white text-lg mb-2 line-clamp-2 leading-tight group-hover:text-green-400 transition-colors">
                                    {{ $product->name }}</h3>
                                <p class="text-sm text-gray-400 line-clamp-2 mb-4 min-h-[40px]">
                                    {{ $product->description ?? 'No description available for this component.' }}</p>
                                <div class="flex flex-col gap-4 mt-auto">
                                    <div class="flex justify-between items-center gap-2">
                                        <div class="text-xl font-bold text-white">IDR
                                            {{ number_format($product->price, 0, ',', '.') }}</div>
                                        <div
                                            class="flex items-center bg-black/40 rounded-full border border-gray-700 p-1 gap-1">
                                            @if ($product->stock > 0)
                                                <span
                                                    class="text-[10px] text-green-400 px-1 font-bold whitespace-nowrap uppercase">Stok:
                                                    {{ $product->stock }}</span>
                                            @else
                                                <span
                                                    class="text-[10px] text-red-500 px-1 font-bold whitespace-nowrap uppercase">Sold
                                                    Out</span>
                                            @endif
                                            @auth @if (auth()->user()->role == 1)
                                                <div class="flex gap-1 border-l border-gray-600 pl-1">
                                                    <form action="{{ route('admin.products.updateStock', $product->id) }}"
                                                        method="POST">@csrf @method('PATCH')<input type="hidden"
                                                            name="action" value="minus"><button type="submit"
                                                            class="w-5 h-5 bg-gray-700 hover:bg-red-900 text-white rounded-full flex items-center justify-center text-[10px] transition-colors">-</button>
                                                    </form>
                                                    <form action="{{ route('admin.products.updateStock', $product->id) }}"
                                                        method="POST">@csrf @method('PATCH')<input type="hidden"
                                                            name="action" value="plus"><button type="submit"
                                                            class="w-5 h-5 bg-gray-700 hover:bg-green-700 text-white rounded-full flex items-center justify-center text-[10px] transition-colors">+</button>
                                                    </form>
                                                </div>
                                            @endif @endauth
                                        </div>
                                    </div>
                                    @auth
                                        @if (auth()->user()->role == 1)
                                            <div class="flex flex-col gap-2">
                                                <div
                                                    class="p-2 bg-white/10 border border-white/20 rounded-lg text-center shadow-sm">
                                                    <span
                                                        class="text-[10px] text-white font-bold uppercase tracking-widest">Admin
                                                        Mode</span>
                                                </div><button type="button" onclick="openEditModal({{ $product->toJson() }})"
                                                    class="w-full bg-green-800 hover:bg-green-600 text-white py-2 rounded-lg text-[10px] font-bold transition-all duration-300 uppercase tracking-wider active:scale-95">Edit
                                                    Component</button>
                                                <form id="delete-form-{{ $product->id }}"
                                                    action="{{ route('admin.products.destroy', $product->id) }}"
                                                    method="POST">@csrf @method('DELETE')<button type="button"
                                                        onclick="confirmDelete('delete-form-{{ $product->id }}')"
                                                        class="w-full bg-red-900/40 hover:bg-red-600 text-white py-2 rounded-lg text-[10px] font-bold transition-all duration-300 uppercase tracking-wider active:scale-95">DELETE</button>
                                                </form>
                                            </div>
                                        @elseif (auth()->user()->role == 2)
                                            <div
                                                class="p-3 bg-yellow-900/30 border border-yellow-600/50 rounded-lg text-center shadow-sm">
                                                <span class="text-xs text-yellow-300 font-bold uppercase tracking-wider">Kasir
                                                    Mode - Read Only</span>
                                            </div>
                                        @else
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST">@csrf<button
                                                    type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }}
                                                    class="w-full flex items-center justify-center gap-2 {{ $product->stock > 0 ? 'bg-white text-black hover:bg-gray-200' : 'bg-red-950 text-white cursor-not-allowed' }} px-4 py-2.5 rounded-lg transition-all duration-300 font-bold active:scale-95">{{ $product->stock > 0 ? 'Add to Build' : 'Out of Stock' }}</button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="w-full block text-center bg-gray-800 text-white py-2.5 rounded-lg font-bold hover:bg-gray-700 transition duration-300 active:scale-95">Login
                                            to Build</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-full text-center py-20 bg-[#1a1a1a] rounded-xl border border-dashed border-gray-700">
                            <p class="text-gray-500 text-lg">No components found.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Your Build Cart Section (diletakkan di bawah, lebar dibatasi agar tidak kegedean) --}}
                <div class="mt-16 max-w-2xl mx-auto">
                    <div class="bg-[#1a1a1a] border border-white/20 rounded-xl p-6 shadow-xl">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-white">Your Build</h2>
                            <span class="bg-white text-black text-xs font-bold px-2 py-1 rounded-full">
                                {{ is_array($cart) ? count($cart) : 0 }} Items
                            </span>
                        </div>
                        @if (empty($cart))
                            <div class="text-center py-12 border border-dashed border-gray-800 rounded-lg">
                                <p class="text-gray-500">Your configuration is empty. Add some components!</p>
                            </div>
                        @else
                            @php $total = 0; @endphp
                            <div class="space-y-4 mb-6 max-h-[100px] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach ($cart as $id => $details)
                                    @php $total += $details['price'] * $details['quantity']; @endphp
                                    <div class="flex justify-between items-start gap-4">
                                        <div class="flex-1 text-sm text-white font-medium line-clamp-1">
                                            {{ $details['name'] }}</div>
                                        <p class="text-sm text-gray-300 font-mono whitespace-nowrap">
                                            IDR {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="border-t border-gray-800 pt-4 flex justify-between text-xl font-bold text-white">
                                <span>Total</span>
                                <span class="text-green-400">IDR {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('cart') }}"
                                class="block w-full mt-6 bg-white text-black text-center py-3.5 rounded-lg hover:bg-gray-200 transition-all duration-300 font-bold uppercase tracking-widest text-sm active:scale-95">
                                Review & Checkout
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div id="modalTambah" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity duration-300"
                onclick="closeTambahModal()"></div>
            <div id="cardTambah"
                class="relative bg-[#1a1a1a] border border-gray-700 rounded-xl p-8 max-w-md w-full shadow-2xl transform transition-all duration-300 scale-95 opacity-0">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-white uppercase tracking-tight">New Component</h3><button
                        onclick="closeTambahModal()"
                        class="text-gray-400 hover:text-white transition-colors text-xl">✕</button>
                </div>
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">@csrf<input type="text" name="name" placeholder="Product Name"
                        class="w-full p-3 bg-[#2a2a2a] border border-gray-600 rounded-lg text-white outline-none focus:border-white transition-all"
                        required>
                    <div class="grid grid-cols-2 gap-4"><input type="number" name="price" placeholder="Price (IDR)"
                            class="w-full p-3 bg-[#2a2a2a] border border-gray-600 rounded-lg text-white outline-none focus:border-white transition-all"
                            required><input type="number" name="stock" placeholder="Stock"
                            class="w-full p-3 bg-[#2a2a2a] border border-gray-600 rounded-lg text-white outline-none focus:border-white transition-all"
                            required></div><select name="category"
                        class="w-full p-3 bg-[#2a2a2a] border border-gray-600 rounded-lg text-white outline-none focus:border-white transition-all">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                    <textarea name="description" placeholder="Description..."
                        class="w-full p-3 bg-[#2a2a2a] border border-gray-600 rounded-lg text-white outline-none focus:border-white transition-all"
                        rows="3"></textarea>
                    <div class="bg-[#2a2a2a] p-3 rounded-lg border border-gray-600"><label
                            class="text-[10px] text-gray-400 block mb-1 uppercase font-bold tracking-widest">Product
                            Image</label><input type="file" name="image" class="text-white text-sm"></div><button
                        type="submit"
                        class="w-full py-4 bg-blue-700 hover:bg-blue-600 text-white rounded-lg font-bold transition-all uppercase tracking-widest active:scale-95 shadow-lg shadow-blue-900/20">SAVE
                        COMPONENT</button>
                </form>
            </div>
        </div>
    </div>

    <div id="modalEdit" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity duration-300"
                onclick="closeEditModal()"></div>
            <div id="cardEdit"
                class="relative bg-[#1a1a1a] border border-gray-700 rounded-xl p-8 max-w-md w-full shadow-2xl transform transition-all duration-300 scale-95 opacity-0">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-white uppercase tracking-tight">Edit Component</h3><button
                        onclick="closeEditModal()"
                        class="text-gray-400 hover:text-white transition-colors text-xl">✕</button>
                </div>
                <form id="formEdit" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf @method('PUT')<input type="text" name="name" id="edit_name"
                        placeholder="Product Name"
                        class="w-full p-3 bg-[#2a2a2a] border border-gray-600 rounded-lg text-white outline-none focus:border-green-500 transition-all"
                        required>
                    <div class="grid grid-cols-2 gap-4"><input type="number" name="price" id="edit_price"
                            placeholder="Price (IDR)"
                            class="w-full p-3 bg-[#2a2a2a] border border-gray-600 rounded-lg text-white outline-none focus:border-green-500 transition-all"
                            required><input type="number" name="stock" id="edit_stock" placeholder="Stock"
                            class="w-full p-3 bg-[#2a2a2a] border border-gray-600 rounded-lg text-white outline-none focus:border-green-500 transition-all"
                            required></div><select name="category" id="edit_category"
                        class="w-full p-3 bg-[#2a2a2a] border border-gray-600 rounded-lg text-white outline-none focus:border-green-500 transition-all">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                    <textarea name="description" id="edit_description" placeholder="Description..."
                        class="w-full p-3 bg-[#2a2a2a] border border-gray-600 rounded-lg text-white outline-none focus:border-green-500 transition-all"
                        rows="3"></textarea>
                    <div class="bg-[#2a2a2a] p-3 rounded-lg border border-gray-600"><label
                            class="text-[10px] text-gray-400 block mb-1 uppercase font-bold tracking-widest">New Image
                            (Optional)</label><input type="file" name="image" class="text-white text-sm"></div>
                    <button type="submit"
                        class="w-full py-4 bg-green-700 hover:bg-green-600 text-white rounded-lg font-bold transition-all uppercase tracking-widest active:scale-95 shadow-lg shadow-green-900/20">UPDATE
                        COMPONENT</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #444;
            border-radius: 10px;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .product-card {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .product-card.reveal {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("reveal");
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15
            });
            document.querySelectorAll(".product-card").forEach(card => observer.observe(card));
        });

        function openTambahModal() {
            const modal = document.getElementById('modalTambah'),
                card = document.getElementById('cardTambah');
            modal.classList.remove('hidden');
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeTambahModal() {
            const modal = document.getElementById('modalTambah'),
                card = document.getElementById('cardTambah');
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        function openEditModal(product) {
            const modal = document.getElementById('modalEdit'),
                card = document.getElementById('cardEdit'),
                form = document.getElementById('formEdit');
            form.action = `/admin/products/update/${product.id}`;
            document.getElementById('edit_name').value = product.name;
            document.getElementById('edit_price').value = product.price;
            document.getElementById('edit_stock').value = product.stock;
            document.getElementById('edit_category').value = product.category;
            document.getElementById('edit_description').value = product.description || '';
            modal.classList.remove('hidden');
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeEditModal() {
            const modal = document.getElementById('modalEdit'),
                card = document.getElementById('cardEdit');
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        function confirmDelete(formId) {
            Swal.fire({
                title: 'Hapus Komponen?',
                text: "Data akan hilang selamanya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#374151',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#1a1a1a',
                color: '#fff',
                customClass: {
                    popup: 'rounded-2xl border border-gray-700'
                }
            }).then((result) => {
                if (result.isConfirmed) document.getElementById(formId).submit();
            });
        }
        @if (session('success'))
            Swal.fire({
                title: 'BERHASIL!',
                text: "{{ session('success') }}",
                icon: 'success',
                background: '#1a1a1a',
                color: '#fff',
                timer: 2500,
                showConfirmButton: false,
                iconColor: '#4ade80',
                customClass: {
                    popup: 'rounded-2xl border border-gray-700 shadow-2xl'
                }
            });
        @endif
    </script>
@endsection
