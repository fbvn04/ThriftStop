<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThriftStop - Seller</title>
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

        .notif-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #FF5500;
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
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

        .detail-wrap {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, .07);
            overflow: hidden;
            display: grid;
            grid-template-columns: 380px 1fr;
            min-height: 500px;
        }

        @media (max-width: 900px) {
            .detail-wrap {
                grid-template-columns: 1fr;
            }
        }

        .detail-img-side {
            background: #f5f0e8;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 380px;
            overflow: hidden;
        }

        .detail-img-side img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .detail-img-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            min-height: 380px;
        }

        .detail-info-side {
            padding: 32px 28px;
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .detail-nama {
            font-size: 22px;
            font-weight: 800;
            color: #1a1a1a;
            line-height: 1.3;
            margin-bottom: 12px;
        }

        .detail-harga {
            display: inline-block;
            background: #FFF3EC;
            color: #FF5500;
            font-size: 18px;
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .detail-meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }

        .detail-meta-item {
            background: #f9f5ee;
            border-radius: 10px;
            padding: 10px 14px;
        }

        .detail-meta-item .meta-label {
            font-size: 10px;
            color: #aaa;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: 3px;
        }

        .detail-meta-item .meta-value {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .detail-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-bottom: 20px;
        }

        .detail-tag {
            font-size: 11.5px;
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 20px;
            background: #f0f0f0;
            color: #555;
        }

        .detail-tag.orange {
            background: #FFF3EC;
            color: #FF5500;
            font-weight: 600;
        }

        .detail-desc-label {
            font-size: 11px;
            font-weight: 700;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 7px;
        }

        .detail-desc {
            font-size: 12.5px;
            color: #666;
            line-height: 1.7;
            flex: 1;
            margin-bottom: 24px;
        }

        .detail-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .btn-edit {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border-radius: 12px;
            background: #1a1a1a;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background .18s;
        }

        .btn-edit:hover {
            background: #333;
        }

        .btn-hapus {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border-radius: 12px;
            background: #fef2f2;
            border: 1.5px solid #fca5a5;
            color: #ef4444;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: all .18s;
        }

        .btn-hapus:hover {
            background: #fee2e2;
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
                    <h1 class="text-[15px] font-bold text-[#1a1a1a] leading-tight">Detail Produk</h1>
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
        </main>
    </div>

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
        function confirmLogout() { document.getElementById('logoutModal').classList.remove('hidden'); }
        function cancelLogout() { document.getElementById('logoutModal').classList.add('hidden'); }
        function doLogout() { document.getElementById('logoutForm').submit(); }
    </script>
</body>

</html>