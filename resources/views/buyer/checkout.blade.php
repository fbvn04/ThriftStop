<x-layout-buyer :user="$user" titlePage="Checkout">

    <h1 class="text-3xl font-bold mb-6">
        Checkout
    </h1>

    <div class="bg-white rounded-3xl p-6">

        @foreach($items as $item)

            <div class="flex justify-between border-b py-4">

                <div>
                    {{ $item->product->nama_produk }}
                </div>

                <div>
                    Rp {{ number_format($item->product->harga,0,',','.') }}
                </div>

            </div>

        @endforeach

    </div>

</x-layout-buyer>