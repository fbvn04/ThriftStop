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

    <h1 class="text-3xl font-bold text-black mb-6 border-b pb-4">
        My Cart
    </h1>

    @if($items->isEmpty())

        <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100">

            <div class="flex justify-center mb-4 text-gray-300">
                <i class="fa-solid fa-basket-shopping text-6xl"></i>
            </div>

            <p class="text-gray-500 font-medium">
                Wah, keranjang belanjaanmu masih kosong nih.
            </p>

            <a
                href="{{ route('buyer.shop') }}"
                class="inline-block mt-6 bg-[#FF5500] hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-full">

                Yuk, Cari Pakaian Thrift →

            </a>

        </div>

    @else

        @php
            $subtotal = $items->sum(fn($item) => $item->product->harga * $item->qty);
            $deliveryFee = 20000;
            $discount = 0;
            $totalFinal = $subtotal + $deliveryFee - $discount;
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- CART ITEMS --}}
            <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">

                <h2 class="text-xl font-bold text-black mb-6">
                    My Cart ({{ $items->count() }})
                </h2>

                <div class="divide-y divide-gray-200">

                    @foreach($items as $item)

                    <div class="flex items-center justify-between py-5">

                        <div class="flex items-center gap-4">

                            <div class="product-cart-img flex items-center justify-center text-gray-400 overflow-hidden">

                                @if($item->product->foto_utama)

                                    <img
                                        src="{{ Storage::url($item->product->foto_utama) }}"
                                        alt="{{ $item->product->nama_produk }}"
                                        class="w-full h-full object-cover">

                                @else

                                    <i class="fa-regular fa-image text-2xl"></i>

                                @endif

                            </div>

                            <div>

                                <h3 class="font-bold text-gray-900 text-xl">
                                    {{ $item->product->nama_produk }}
                                </h3>

                                <p class="text-gray-500 text-sm mt-1 max-w-md">
                                    {{ Str::limit($item->product->deskripsi, 70) }}
                                </p>

                                <p class="text-[#FF5500] font-bold text-2xl mt-3">
                                    Rp {{ number_format($item->product->harga,0,',','.') }}
                                </p>

                            </div>

                        </div>

                        {{-- QTY --}}
                        <div class="flex items-center gap-2 border border-gray-300 rounded-full px-3 py-1 bg-white shadow-sm">

                            <form
                                action="{{ route('buyer.cart.decrease', $item->id) }}"
                                method="POST">

                                @csrf

                                <button
                                    type="submit"
                                    class="px-2 font-bold text-lg">

                                    -

                                </button>

                            </form>

                            <span class="font-semibold min-w-[20px] text-center">
                                {{ $item->qty }}
                            </span>

                            <form
                                action="{{ route('buyer.cart.increase', $item->id) }}"
                                method="POST">

                                @csrf

                                <button
                                    type="submit"
                                    class="px-2 font-bold text-lg">

                                    +

                                </button>

                            </form>

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

            {{-- ORDER SUMMARY --}}
            <div class="bg-white p-6 rounded-3xl border-2 border-blue-400 shadow-sm">

                <h2 class="text-2xl font-bold text-center mb-8">
                    Order Summary
                </h2>

                <div class="space-y-5">

                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            Sub Total
                        </span>

                        <span class="font-bold">
                            Rp {{ number_format($subtotal,0,',','.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            Discount
                        </span>

                        <span class="font-bold">
                            Rp {{ number_format($discount,0,',','.') }}
                        </span>
                    </div>

                    <div class="flex justify-between border-b pb-5">
                        <span class="text-gray-500">
                            Delivery Fee
                        </span>

                        <span class="font-bold">
                            Rp {{ number_format($deliveryFee,0,',','.') }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center pt-2">

                        <span class="text-xl font-bold">
                            Total
                        </span>

                        <span class="text-3xl font-extrabold">
                            Rp {{ number_format($totalFinal,0,',','.') }}
                        </span>

                    </div>

                </div>

                <a
                    href="{{ route('buyer.checkout') }}"
                    class="block text-center w-full mt-8 bg-[#FF5500] hover:bg-orange-600 text-white font-bold py-4 rounded-2xl shadow-md">

                    Checkout

                </a>

            </div>

        </div>

    @endif

</x-layout-buyer>