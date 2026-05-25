<x-layout-seller titlePage="Detail Produk">
            @if(session('success'))
                <div
                    class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-[13px] flex items-center gap-2.5 mb-5">
                    <i class="fa-solid fa-circle-check text-green-500"></i>
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('seller.produk') }}" class="back-link" style="color:#000000;">
                <i class="fa-solid fa-arrow-left" style="font-size:11px;color:#000000;"></i>
                Kembali ke Kelola Produk
            </a>

            <div class="detail-wrap">
                <div class="detail-img-side">
                    @if($produk->foto_utama)
                        <img src="{{ Storage::url($produk->foto_utama) }}" alt="{{ $produk->nama_produk }}">
                    @else
                        <div class="detail-img-placeholder">
                            <i class="fa-solid fa-image" style="font-size:56px;color:#d6c9b0;"></i>
                        </div>
                    @endif
                </div>

                <div class="detail-info-side">
                    <p class="detail-nama">{{ $produk->nama_produk }}</p>
                    <span class="detail-harga">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>

                    <div class="detail-meta-grid">
                        <div class="detail-meta-item">
                            <div class="meta-label">Stok</div>
                            <div class="meta-value">{{ $produk->stok }} Item</div>
                        </div>
                        <div class="detail-meta-item">
                            <div class="meta-label">Status</div>
                            <div class="meta-value">{{ $produk->label_stok }}</div>
                        </div>
                        @if($produk->kondisi)
                            <div class="detail-meta-item">
                                <div class="meta-label">Kondisi</div>
                                <div class="meta-value">{{ $produk->kondisi }}</div>
                            </div>
                        @endif
                        @if($produk->ukuran)
                            <div class="detail-meta-item">
                                <div class="meta-label">Ukuran</div>
                                <div class="meta-value">{{ $produk->ukuran }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="detail-tags">
                        @if($produk->kategori)
                            <span class="detail-tag orange">{{ $produk->kategori }}</span>
                        @endif
                        <span class="detail-tag">Ditambah {{ $produk->created_at->format('d M Y') }}</span>
                    </div>

                    @if($produk->deskripsi)
                        <div class="detail-desc-label">Keterangan</div>
                        <div class="detail-desc">{{ $produk->deskripsi }}</div>
                    @endif

                    <div class="detail-actions">
                        <a href="{{ route('seller.produk.edit', $produk->id) }}" class="btn-edit">
                            <i class="fa-solid fa-pen" style="font-size:12px;"></i>
                            Edit Produk
                        </a>
                        <form action="{{ route('seller.produk.destroy', $produk->id) }}" method="POST" style="flex:1;"
                            onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus" style="width:100%;">
                                <i class="fa-solid fa-trash" style="font-size:12px;"></i>
                                Hapus Produk
                            </button>
                        </form>
                    </div>
                </div>
            </div>
</x-layout-seller>