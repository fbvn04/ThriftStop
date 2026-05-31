<x-layout-buyer :user="$user" titlePage="Keranjang">

<h1 class="text-3xl font-bold mb-6">
    My Cart
</h1>

<div class="grid lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 bg-white rounded-3xl p-6">

        @foreach($items as $item)

        <div class="flex justify-between border-b py-4">

            <div>

                <h3 class="font-semibold">
                    {{ $item->product->nama_produk }}
                </h3>

                <p class="text-[#FF5500] font-bold">
                    Rp {{ number_format($item->product->harga,0,',','.') }}
                </p>

            </div>

            <div>
                Qty: {{ $item->qty }}
            </div>

        </div>

        @endforeach

    </div>

    <div class="bg-white rounded-3xl p-6">

        <h3 class="font-bold mb-4">
            Order Summary
        </h3>

        @php
        $total = $items->sum(
            fn($item) =>
            $item->product->harga * $item->qty
        );
        @endphp

        <div class="font-bold text-xl">
            Rp {{ number_format($total,0,',','.') }}
        </div>

        <button
            class="w-full mt-6 bg-[#FF5500] text-white py-3 rounded-full">

            Checkout

        </button>

    </div>

</div>

</x-layout-buyer>