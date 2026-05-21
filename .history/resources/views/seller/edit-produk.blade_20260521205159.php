<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk – ThriftStop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            background: #F1E0B4;
            overflow-x: hidden;
        }

        #sidebar {
            width: 220px;
            flex-shrink: 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: #fff;
            box-shadow: 4px 0 24px rgba(0, 0, 0, .07);
            display: flex;
            flex-direction: column;
            z-index: 40;
            transition: width .3s ease, transform .3s ease;
            overflow: hidden;
        }

        #sidebar.collapsed {
            width: 68px;
        }

        #sidebar.collapsed .hide-on-collapse {
            display: none !important;
        }

        #sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 10px;
        }

        #sidebar.collapsed .nav-icon {
            margin: 0;
        }

        #sidebar.collapsed #toggleIcon {
            transform: rotate(180deg);
        }

        #sidebar.collapsed .profile-wrap {
            justify-content: center;
            padding: 8px;
        }

        #sidebar.collapsed .logout-btn {
            justify-content: center;
        }

        #mainWrap {
            margin-left: 220px;
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left .3s ease;
        }

        #mainWrap.collapsed {
            margin-left: 68px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            color: #555;
            text-decoration: none;
            white-space: nowrap;
            transition: all .18s ease;
        }

        .nav-link:hover {
            background: #FFF3EC;
            color: #FF5500;
        }

        .nav-link.active {
            background: #FF5500;
            color: #fff;
        }

        .nav-link .nav-icon {
            width: 18px;
            text-align: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        #sidebarOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 35;
        }

        #sidebarOverlay.show {
            display: block;
        }

        @media (max-width: 1023px) {
            #sidebar {
                transform: translateX(-100%);
                width: 220px !important;
            }

            #sidebar.open {
                transform: translateX(0);
            }

            #mainWrap {
                margin-left: 0 !important;
            }
        }

        /* ── Edit Layout ── */
        .edit-wrap {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, .07);
            overflow: hidden;
            display: grid;
            grid-template-columns: 320px 1fr;
        }

        @media (max-width: 860px) {
            .edit-wrap {
                grid-template-columns: 1fr;
            }
        }

        .edit-img-side {
            background: #f5f0e8;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .current-img-wrap {
            width: 100%;
            aspect-ratio: 1;
            border-radius: 14px;
            overflow: hidden;
            background: #ede6d6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .current-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .upload-area {
            border: 2px dashed #d6c9b0;
            border-radius: 12px;
            padding: 18px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            background: #faf7f2;
            position: relative;
        }

        .upload-area:hover,
        .upload-area.dragover {
            border-color: #FF5500;
            background: #FFF3EC;
        }

        .upload-area input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .upload-area i {
            font-size: 22px;
            color: #ccc;
            margin-bottom: 6px;
            display: block;
            transition: color .2s;
        }

        .upload-area:hover i {
            color: #FF5500;
        }

        .upload-area p {
            font-size: 11.5px;
            color: #bbb;
            margin: 0;
            line-height: 1.5;
        }

        .upload-area span {
            color: #FF5500;
            font-weight: 600;
        }

        .new-preview {
            width: 100%;
            aspect-ratio: 1;
            border-radius: 12px;
            overflow: hidden;
            display: none;
        }

        .new-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ── Form Side ── */
        .edit-form-side {
            padding: 28px 28px 32px;
            overflow-y: auto;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: #555;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 9px 13px;
            font-size: 12.5px;
            color: #333;
            font-family: 'Poppins', sans-serif;
            outline: none;
            transition: border-color .2s;
            background: #fafafa;
        }

        .form-control:focus {
            border-color: #FF5500;
            background: #fff;
        }

        .form-control::placeholder {
            color: #bbb;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .filter-chip-row {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .filter-chip {
            font-size: 11.5px;
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 20px;
            border: 1.5px solid #e5e7eb;
            color: #555;
            cursor: pointer;
            transition: all .15s;
            background: #fff;
        }

        .filter-chip:hover,
        .filter-chip.active {
            background: #FF5500;
            border-color: #FF5500;
            color: #fff;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 24px;
        }

        .btn-save {
            flex: 1;
            background: #FF5500;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: background .18s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-save:hover {
            background: #e04a00;
        }

        .btn-cancel {
            flex: 1;
            background: #fff;
            color: #555;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all .18s;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-cancel:hover {
            border-color: #ccc;
            background: #f5f5f5;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 12.5px;
            font-weight: 500;
            color: #888;
            text-decoration: none;
            margin-bottom: 18px;
            transition: color .15s;
        }

        .back-link:hover {
            color: #FF5500;
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #d6c9b0;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div id="sidebarOverlay" onclick="closeSidebar()"></div>
    <aside id="sidebar">
        <div class="flex items-center justify-between px-5 pt-6 pb-3 flex-shrink-0">
            <span class="text-[22px] font-extrabold leading-none hide-on-collapse">
                <span class="text-[#FF5500]">Thrift</span><span class="text-black">Stop</span>
            </span>
            <button id="desktopToggle" onclick="toggleCollapse()"
                class="hidden lg:flex w-7 h-7 items-center justify-center rounded-full bg-[#FFF3EC] hover:bg-orange-100 transition-colors flex-shrink-0">
                <i id="toggleIcon"
                    class="fa-solid fa-chevron-left text-[#FF5500] text-[10px] transition-transform duration-300"></i>
            </button>
            <button onclick="closeSidebar()" class="lg:hidden text-[#aaa] hover:text-red-400 ml-auto">
                <i class="fa-solid fa-xmark text-[16px]"></i>
            </button>
        </div>

        <div class="px-5 mb-4 flex-shrink-0">
            <span
                class="hide-on-collapse bg-[#1a1a1a] text-white text-[11px] font-semibold px-3 py-1 rounded-md tracking-wide">Seller</span>
        </div>

        <div class="mx-3 mb-4 rounded-xl bg-[#F1E0B4]/60 p-3 flex items-center gap-3 profile-wrap flex-shrink-0">
            @if(!empty($toko->foto_toko))
                <img src="{{ Storage::url($toko->foto_toko) }}"
                    class="w-9 h-9 rounded-full object-cover ring-2 ring-[#FF5500]/30 flex-shrink-0" alt="Foto Toko">
            @else
                <div
                    class="w-9 h-9 rounded-full bg-[#FF5500]/15 flex items-center justify-center ring-2 ring-[#FF5500]/25 flex-shrink-0">
                    <i class="fa-solid fa-store text-[#FF5500] text-[13px]"></i>
                </div>
            @endif
            <div class="hide-on-collapse overflow-hidden">
                <p class="text-[12px] font-semibold text-[#1a1a1a] truncate">{{ $toko->nama_toko ?? 'Nama Toko' }}</p>
                <p class="text-[10px] text-[#888]">ID: {{ str_pad($toko->id ?? 0, 7, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <nav class="px-3 space-y-1 overflow-y-auto flex-1">
            <a href="{{ route('seller.dashboard') }}"
                class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-house"></i></span>
                <span class="hide-on-collapse">Dashboard</span>
            </a>
            <a href="{{ route('seller.produk') }}"
                class="nav-link {{ request()->routeIs('seller.produk*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-boxes-stacked"></i></span>
                <span class="hide-on-collapse">Kelola Produk</span>
            </a>
            <a href="{{ route('seller.laporan') }}"
                class="nav-link {{ request()->routeIs('seller.laporan*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-chart-column"></i></span>
                <span class="hide-on-collapse">Laporan Penjualan</span>
            </a>
            <a href="{{ route('seller.toko') }}"
                class="nav-link {{ request()->routeIs('seller.toko*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-store"></i></span>
                <span class="hide-on-collapse">Kelola Toko Saya</span>
            </a>
            <a href="{{ route('seller.orderan') }}"
                class="nav-link {{ request()->routeIs('seller.orderan*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-bag-shopping"></i></span>
                <span class="hide-on-collapse">Orderan Saya</span>
            </a>
        </nav>

        <div class="p-4 border-t border-[#f0e9d8] flex-shrink-0">
            <button type="button" onclick="confirmLogout()"
                class="logout-btn w-full flex items-center gap-2.5 justify-center py-2.5 px-4 rounded-lg border border-red-200 text-red-400 hover:bg-red-50 hover:text-red-500 text-[13px] font-medium transition-all duration-200">
                <i class="fa-solid fa-right-from-bracket text-[13px] flex-shrink-0"></i>
                <span class="hide-on-collapse">Log Out</span>
            </button>
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </aside>

    <div id="mainWrap">
        <header
            class="sticky top-0 z-20 bg-white/85 backdrop-blur-md shadow-sm px-5 lg:px-8 py-3 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <button onclick="openSidebar()" class="lg:hidden text-[#555] hover:text-[#FF5500] transition-colors">
                    <i class="fa-solid fa-bars text-[18px]"></i>
                </button>
                <div>
                    <h1 class="text-[15px] font-bold text-[#1a1a1a] leading-tight">Edit Produk</h1>
                    <p class="text-[11px] text-[#aaa]" id="tanggalHariIni"></p>
                </div>
            </div>
            <div class="flex items-center gap-2.5 relative">
                <button
                    class="relative w-9 h-9 rounded-full bg-[#f5f5f5] hover:bg-[#FFF3EC] flex items-center justify-center transition-colors">
                    <i class="fa-regular fa-bell text-[#555] text-[15px]"></i>
                </button>
                <button
                    class="relative w-9 h-9 rounded-full bg-[#f5f5f5] hover:bg-[#FFF3EC] flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-cart-shopping text-[#555] text-[15px]"></i>
                </button>
            </div>
        </header>

        <main class="flex-1 p-5 lg:p-7 overflow-y-auto">
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-[13px] mb-5">
                    <i class="fa-solid fa-circle-exclamation text-red-400 mr-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <a href="{{ route('seller.produk.detail', $produk->id) }}" class="back-link">
                <i class="fa-solid fa-arrow-left" style="font-size:11px;"></i>
                Kembali ke Detail Produk
            </a>

            <div class="edit-wrap">
                {{-- Foto Side --}}
                <div class="edit-img-side">
                    <p style="font-size:12px;font-weight:600;color:#555;margin:0;">Foto Produk</p>

                    <div class="current-img-wrap">
                        @if($produk->foto_utama)
                            <img src="{{ Storage::url($produk->foto_utama) }}" alt="{{ $produk->nama_produk }}"
                                id="currentImg">
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

                {{-- Form Side --}}
                <div class="edit-form-side">
                    <form action="{{ route('seller.produk.update', $produk->id) }}" method="POST"
                        enctype="multipart/form-data" id="editForm">
                        @csrf
                        @method('PUT')

                        {{-- Hidden file input yang terhubung ke form --}}
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
                                <input type="number" name="stok" class="form-control"
                                    value="{{ old('stok', $produk->stok) }}" min="0" required>
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
                                    @foreach(['Seperti Baru', 'Kondisi Baik', 'Kondisi Cukup', 'Vintage'] as $kon)
                                        <option value="{{ $kon }}" {{ old('kondisi', $produk->kondisi) === $kon ? 'selected' : '' }}>{{ $kon }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Ukuran</label>
                            <div class="filter-chip-row" id="ukuranChips">
                                @php $selectedUkuran = old('ukuran', $produk->ukuran ?? ''); @endphp
                                @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL', 'Free Size'] as $ukuran)
                                    <button type="button"
                                        class="filter-chip {{ in_array($ukuran, explode(',', $selectedUkuran)) ? 'active' : '' }}"
                                        onclick="toggleUkuran(this, '{{ $ukuran }}')">{{ $ukuran }}</button>
                                @endforeach
                            </div>
                            <input type="hidden" name="ukuran" id="ukuranInput"
                                value="{{ old('ukuran', $produk->ukuran) }}">
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
        </main>
    </div>

    {{-- Logout Modal --}}
    <div id="logoutModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="cancelLogout()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-[300px] mx-4 text-center"
            style="animation:slideUp .2s ease">
            <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-right-from-bracket text-red-400 text-[22px]"></i>
            </div>
            <h3 class="text-[16px] font-bold text-[#1a1a1a]">Keluar dari Akun?</h3>
            <p class="text-[12px] text-[#888] mt-1.5 mb-5 leading-relaxed">Kamu akan keluar dari akun seller ThriftStop.
                Yakin ingin melanjutkan?</p>
            <div class="flex gap-3">
                <button onclick="cancelLogout()"
                    class="flex-1 py-2.5 rounded-xl border border-[#e5e7eb] text-[13px] font-medium text-[#555] hover:bg-[#f5f5f5] transition-colors">Batal</button>
                <button onclick="doLogout()"
                    class="flex-1 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-[13px] font-semibold text-white transition-colors">Ya,
                    Keluar</button>
            </div>
        </div>
    </div>

    <script>
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const now = new Date();
        document.getElementById('tanggalHariIni').textContent =
            days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();

        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('sidebarOverlay').classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('show');
            document.body.style.overflow = '';
        }
        function toggleCollapse() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('mainWrap').classList.toggle('collapsed');
        }

        // Preview foto baru & sinkronkan ke form input
        function previewNewPhoto(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Transfer file ke input form yang sebenarnya
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('fotoFormInput').files = dt.files;

            // Tampilkan preview
            const reader = new FileReader();
            reader.onload = ev => {
                const preview = document.getElementById('newPreview');
                const img = document.getElementById('newPreviewImg');
                img.src = ev.target.result;
                preview.style.display = 'block';

                // Sembunyikan foto lama
                const curr = document.getElementById('currentImg');
                if (curr) curr.style.opacity = '0.3';
            };
            reader.readAsDataURL(file);
        }

        // Ukuran chips
        const selectedUkuran = new Set(
            '{{ $produk->ukuran ?? '' }}'.split(',').filter(Boolean)
        );
        function toggleUkuran(el, val) {
            el.classList.toggle('active');
            selectedUkuran.has(val) ? selectedUkuran.delete(val) : selectedUkuran.add(val);
            document.getElementById('ukuranInput').value = Array.from(selectedUkuran).join(',');
        }

        function confirmLogout() { document.getElementById('logoutModal').classList.remove('hidden'); }
        function cancelLogout() { document.getElementById('logoutModal').classList.add('hidden'); }
        function doLogout() { document.getElementById('logoutForm').submit(); }
    </script>
</body>

</html>