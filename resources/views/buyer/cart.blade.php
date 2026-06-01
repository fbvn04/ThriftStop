<x-layout-buyer :user="$user" titlePage="Keranjang Belanja">
    
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

    <h1 class="text-3xl font-bold text-black mb-6 border-b pb-4">My Cart</h1>

    @if($items->isEmpty())
        <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100">
            <div class="flex justify-center mb-4 text-gray-300">
                <i class="fa-solid fa-basket-shopping text-6xl"></i>
            </div>
            <p class="text-gray-500 font-medium">Wah, keranjang belanjaanmu masih kosong nih.</p>
            <a href="{{ route('buyer.shop') }}" class="inline-block mt-6 bg-[#FF5500] hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-full transition duration-200 shadow-sm text-sm">
                Yuk, Cari Pakaian Thrift &rarr;
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-black mb-6">My Cart ({{ $items->count() }})</h2>

                <div class="divide-y divide-gray-200">
                    
                    @foreach($items as $item)
                    <div class="flex items-center justify-between py-5 {{ $loop->first ? 'pt-0' : '' }} {{ $loop->last ? 'pb-0' : '' }}">
                        <div class="flex items-center gap-4">
                            <div class="product-cart-img flex items-center justify-center text-gray-400 overflow-hidden">
                                @if(isset($item->product->foto) && $item->product->foto)
                                    <img src="{{ asset('storage/' . $item->product->foto) }}" alt="{{ $item->product->nama_produk }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-regular fa-image text-2xl"></i>
                                @endif
                            </div>
                            
                            <div>
                                <h3 class="font-bold text-gray-900 text-base">{{ $item->product->nama_produk }}</h3>
                                <p class="text-gray-400 text-xs max-w-sm line-clamp-2 mt-0.5">
                                    {{ $item->product->deskripsi ?? 'No description available.' }}
                                </p>
                                <p class="text-[#FF5500] font-extrabold text-lg mt-2">
                                    Rp {{ number_format($item->product->harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 border border-gray-300 rounded-full px-2 py-1 bg-white shadow-sm">
                            <button class="text-gray-500 hover:text-black font-bold px-2 text-xs focus:outline-none">-</button>
                            <span class="text-xs font-semibold px-1 text-gray-800">{{ $item->qty }}</span>
                            <button class="text-gray-500 hover:text-black font-bold px-2 text-xs focus:outline-none">+</button>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>

            @php
                $subtotal = $items->sum(fn($item) => $item->product->harga * $item->qty);
                $deliveryFee = 20000; // Sesuai mockup awal Anda
                $discount = 0;
                $totalFinal = $subtotal + $deliveryFee - $discount;
            @endphp
            
            <div class="bg-white p-6 rounded-3xl border-2 border-blue-400 shadow-sm">
                <h2 class="text-xl font-bold text-black text-center mb-6">Order Summary</h2>

                <div class="space-y-4 text-sm font-medium text-gray-700">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Sub Total</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Discount</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($discount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-4">
                        <span class="text-gray-500">Delivery Fee</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center pt-2 text-base">
                        <span class="font-bold text-black">Total</span>
                        <span class="font-extrabold text-xl text-black">Rp {{ number_format($totalFinal, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button class="w-full mt-8 bg-[#FF5500] hover:bg-orange-600 text-white font-bold py-3.5 px-4 rounded-2xl transition duration-200 shadow-md focus:outline-none">
                    Checkout
                </button>
            </div>

        </div>
    @endif

</x-layout-buyer>