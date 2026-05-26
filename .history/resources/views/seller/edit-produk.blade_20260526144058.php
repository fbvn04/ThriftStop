<x-layout-seller titlePage="Edit Produk">
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-[13px] mb-5">
            <i class="fa-solid fa-circle-exclamation text-red-400 mr-2"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <a href="{{ route('seller.produk') }}" class="back-link" style="color:#000000;">
        <i class="fa-solid fa-arrow-left" style="font-size:11px;color:#000000;"></i>
        Kembali ke Detail Produk
    </a>

    <div class="edit-wrap">
        <div class="edit-img-side">
            <p style="font-size:12px;font-weight:600;color:#555;margin:0;">Foto Produk</p>

            <div class="current-img-wrap">
                @if($produk->foto_utama)
                    <img src="{{ Storage::url($produk->foto_utama) }}" alt="{{ $produk->nama_produk }}" id="currentImg">
                @else
                    <i class="fa-solid fa-image" style="font-size:48px;color:#d6c9b0;"></i>
                @endif
            </div>

            <div class="new-preview" id="newPreview">
                <img id="newPreviewImg" src="" alt="preview baru">
            </div>

            <div class="upload-area" id="uploadArea">
                <input type="file" id="fotoInput" accept="image/*" onchange="previewNewPhoto(event)">
                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                <p><span>Ganti foto</span><br>JPG, PNG, WEBP · Maks 5MB</p>
            </div>
        </div>

        <div class="edit-form-side">
            <form action="{{ route('seller.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data"
                id="editForm">
                @csrf
                @method('PUT')

                <input type="file" name="foto_utama" id="fotoFormInput" accept="image/*" style="display:none;">

                <div class="form-group">
                    <label>Nama Produk *</label>
                    <input type="text" name="nama_produk" class="form-control"
                        value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Harga (Rp) *</label>
                        <input type="number" name="harga" class="form-control"
                            value="{{ old('harga', $produk->harga) }}" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Stok *</label>
                        <input type="number" name="stok" class="form-control" value="{{ old('stok', $produk->stok) }}"
                            min="0" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori" class="form-control">
                            <option value="">Pilih kategori</option>
                            @foreach(['Jacket', 'Sweater', 'Kemeja', 'Celana', 'Sepatu', 'Aksesoris', 'Lainnya'] as $kat)
                                <option value="{{ $kat }}" {{ old('kategori', $produk->kategori) === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kondisi</label>
                        <select name="kondisi" class="form-control">
                            <option value="">Pilih kondisi</option>
                            @foreach(['Seperti Baru', 'Kondisi Baik', 'Kondisi Cukup'] as $kon)
                                <option value="{{ $kon }}" {{ old('kondisi', $produk->kondisi) === $kon ? 'selected' : '' }}>
                                    {{ $kon }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Ukuran</label>
                    <div class="filter-chip-row" id="ukuranChips">
                        @php $selectedUkuran = old('ukuran', $produk->ukuran ?? ''); @endphp
                        @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $ukuran)
                            <button type="button"
                                class="filter-chip {{ in_array($ukuran, explode(',', $selectedUkuran)) ? 'active' : '' }}"
                                onclick="toggleUkuran(this, '{{ $ukuran }}')">{{ $ukuran }}</button>
                        @endforeach
                    </div>
                    <input type="hidden" name="ukuran" id="ukuranInput" value="{{ old('ukuran', $produk->ukuran) }}">
                </div>

                <div class="form-group">
                    <label>Deskripsi Produk</label>
                    <textarea name="deskripsi"
                        class="form-control">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                </div>

                <div class="form-actions">
                    <a href="{{ route('seller.produk.detail', $produk->id) }}" class="btn-cancel">
                        Batal
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="fa-solid fa-floppy-disk" style="font-size:12px;"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout-seller>