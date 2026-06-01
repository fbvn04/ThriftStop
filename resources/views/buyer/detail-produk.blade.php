<x-layout-buyer :user="$user" titlePage="Detail Produk">

<div class="bg-[#f8f8f8] rounded-3xl p-6">

    <h1 class="text-[28px] font-bold mb-6">
        Detail Produk
    </h1>

    <div class="bg-white rounded-3xl p-6">

        <div class="flex flex-col lg:flex-row gap-8">

            {{-- FOTO --}}
            <div class="w-full lg:w-[320px]">

                <img
                    src="{{ $product->foto_utama ? Storage::url($product->foto_utama) : 'https://via.placeholder.com/400x400' }}"
                    class="w-full h-[320px] object-cover rounded-2xl border">

                <div class="flex gap-2 mt-3">

                    <img
                        src="{{ $product->foto_utama ? Storage::url($product->foto_utama) : 'https://via.placeholder.com/100x100' }}"
                        class="w-16 h-16 object-cover rounded-lg border">

                    @if($product->foto_lainnya)
                        @foreach($product->foto_lainnya as $foto)
                            <img
                                src="{{ Storage::url($foto) }}"
                                class="w-16 h-16 object-cover rounded-lg border">
                        @endforeach
                    @endif

                </div>

            </div>

            {{-- DETAIL --}}
            <div class="flex-1">

                <h2 class="text-[30px] font-bold text-[#1a1a1a] leading-tight">
                    {{ $product->nama_produk }}
                </h2>

                <div class="text-[32px] font-bold text-[#FF5500] mt-2">
                    Rp {{ number_format($product->harga,0,',','.') }}
                </div>

                <p class="text-[#888] text-sm mt-3 leading-relaxed">
                    {{ Str::limit($product->deskripsi,120) }}
                </p>

                <div class="flex gap-3 mt-5">


    <form
        action="{{ route('buyer.cart.add', $product->id) }}"
        method="POST">

        @csrf

        <button
            type="submit"
            class="px-6 py-2 rounded-full bg-[#FF5500] text-white text-sm font-semibold hover:bg-orange-600">

            Add to Cart

        </button>

    </form>

</div>

                <div class="mt-6 text-sm space-y-1">

                    <div>
                        <span class="font-semibold">Toko :</span>
                        {{ $product->toko->nama_toko ?? 'Toko Tidak Diketahui' }}
                    </div>

                    <div>
                        <span class="font-semibold">Kondisi :</span>
                        <span class="text-green-600">
                            {{ $product->kondisi }}
                        </span>
                    </div>

                    <div>
                        <span class="font-semibold">Kategori :</span>
                        {{ $product->kategori }}
                    </div>

                    <div>
                        <span class="font-semibold">Ukuran :</span>
                        {{ $product->ukuran }}
                    </div>

                    <div>
                        <span class="font-semibold">Stok :</span>
                        {{ $product->stok }}
                    </div>

                </div>

            </div>

        </div>

        {{-- DESKRIPSI --}}
        <div class="mt-8">

            <h3 class="font-bold mb-3">
                Description
            </h3>

            <div class="bg-[#f5f5f5] rounded-2xl p-5 text-sm text-[#666] leading-relaxed">
                {{ $product->deskripsi }}
            </div>

        </div>

    </div>

</div>

</x-layout-buyer>