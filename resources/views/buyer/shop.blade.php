<x-layout-buyer :user="auth()->user()" titlePage="Shop">

    <div class="mb-6">
        <h1 class="text-2xl font-bold">Shop</h1>
        <p class="text-gray-500 text-sm">
            Temukan produk thrift terbaik
        </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">

        @forelse($products as $product)

            <a href="{{ route('buyer.produk', $product->id) }}"
                class="bg-white rounded-2xl overflow-hidden shadow hover:shadow-lg transition">

                <div class="aspect-[3/4] bg-gray-100">
                    @if($product->foto_utama)
                        <img
                            src="{{ asset('storage/'.$product->foto_utama) }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fa-regular fa-image text-4xl text-gray-400"></i>
                        </div>
                    @endif
                </div>

                <div class="p-4">
                    <h3 class="font-semibold text-sm">
                        {{ $product->nama_produk }}
                    </h3>

                    <p class="text-xs text-gray-500">
                        {{ $product->toko->nama_toko ?? '-' }}
                    </p>

                    <p class="text-orange-500 font-bold mt-2">
                        Rp {{ number_format($product->harga,0,',','.') }}
                    </p>

                    <span class="text-xs bg-gray-100 px-2 py-1 rounded-full">
                        {{ $product->kondisi }}
                    </span>
                </div>

            </a>

        @empty

            <div class="col-span-full text-center py-10">
                <h3 class="font-semibold">
                    Belum ada produk
                </h3>
            </div>

        @endforelse

    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>

</x-layout-buyer>