
<x-layout-buyer :user="auth()->user()" titlePage="Keranjang Belanja">
    
    @push('styles')
        <style>
            .product-cart-img {
                width: 90px;
                height: 90px;
                border-radius: 16px;
                background-color: #e5e7eb;
                object-fit: cover;
            }
        </style>
    @endpush

    <h1 class="text-3xl font-bold text-black mb-6 border-b pb-4">Keranjang Saya</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-black mb-6">Keranjang (4)</h2>

            <div class="divide-y divide-gray-200">
                
                @foreach(range(1, 4) as $index)
                <div class="flex items-center justify-between py-5 {{ $index === 1 ? 'pt-0' : '' }} {{ $index === 4 ? 'pb-0' : '' }}">
                    <div class="flex items-center gap-4">
                        <div class="product-cart-img flex items-center justify-center text-gray-400">
                            <i class="fa-regular fa-image text-2xl"></i>
                        </div>
                        
                        <div>
                            <h3 class="font-bold text-gray-900 text-base">Nama Produk</h3>
                            <p class="text-gray-400 text-xs max-w-sm line-clamp-2 mt-0.5">
                                Nama Toko
                            </p>
                            <p class="text-[#FF5500] font-extrabold text-lg mt-2">Rp 150.000,00</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 border border-gray-300 rounded-full px-2 py-1 bg-white shadow-sm">
                        <button class="text-gray-500 hover:text-black font-bold px-2 text-xs focus:outline-none">-</button>
                        <span class="text-xs font-semibold px-1 text-gray-800">1</span>
                        <button class="text-gray-500 hover:text-black font-bold px-2 text-xs focus:outline-none">+</button>
                    </div>
                </div>
                @endforeach

            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border-2 border-blue-400 shadow-sm">
            <h2 class="text-xl font-bold text-black text-center mb-6">Order Summary</h2>

            <div class="space-y-4 text-sm font-medium text-gray-700">
                <div class="flex justify-between">
                    <span class="text-gray-500">Sub Total</span>
                    <span class="font-bold text-gray-900">Rp 600.000,00</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Discount</span>
                    <span class="font-bold text-gray-900">Rp 0</span>
                </div>
                <div class="flex justify-between border-b pb-4">
                    <span class="text-gray-500">Delivery Fee</span>
                    <span class="font-bold text-gray-900">Rp 20.000,00</span>
                </div>
                
                <div class="flex justify-between items-center pt-2 text-base">
                    <span class="font-bold text-black">Total</span>
                    <span class="font-extrabold text-xl text-black">Rp 620.000,00</span>
                </div>
            </div>

            <button class="w-full mt-8 bg-[#FF5500] hover:bg-orange-600 text-white font-bold py-3.5 px-4 rounded-2xl transition duration-200 shadow-md focus:outline-none">
                Checkout
            </button>
        </div>

    </div>

</x-layout-buyer>

<!--
<x-layout-buyer :user="auth()->user()" titlePage="Keranjang Belanja">
    
    @push('styles')
        <style>
            .cart-container {
                background: #fff;
                border-radius: 18px;
                box-shadow: 0 4px 14px rgba(0, 0, 0, .05);
            }
        </style>
    @endpush

    <div class="section-head mb-4">
        <span class="section-head-title">
            <i class="fa-solid fa-cart-shopping text-[#FF5500] mr-2"></i>Keranjang Belanja Saya
        </span>
    </div>

    <div class="cart-container p-6 text-center">
        <div class="py-10">
            <i class="fa-solid fa-basket-shopping text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-sm mb-6">Wah, keranjang belanjaanmu masih kosong nih.</p>
            
            <a href="/" class="hero-btn" style="text-decoration: none;">
                Yuk, Cari Pakaian Thrift <i class="fa-solid fa-arrow-right text-[11px] ml-2"></i>
            </a>
        </div>
    </div>

    @push('scripts')
        <script>
            console.log('Halaman keranjang berhasil dimuat!');
        </script>
    @endpush

</x-layout-buyer>
-->