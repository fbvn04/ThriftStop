<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThriftStop Seller</title>
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

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
        }

        .product-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .10);
        }

        .product-img-wrap {
            width: 100%;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            background: #f5f0e8;
            position: relative;
        }

        .product-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .3s ease;
        }

        .product-card:hover .product-img-wrap img {
            transform: scale(1.04);
        }

        .stock-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #FF5500;
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .stock-badge.habis {
            background: #ef4444;
        }

        .stock-badge.sedikit {
            background: #f59e0b;
        }

        .product-info {
            padding: 12px 13px 14px;
        }

        .product-name {
            font-size: 12.5px;
            font-weight: 600;
            color: #1a1a1a;
            line-height: 1.4;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-price {
            font-size: 13px;
            font-weight: 700;
            color: #FF5500;
        }

        .product-category {
            font-size: 10.5px;
            color: #aaa;
            margin-top: 3px;
        }

        /* ── Search & Filter Bar ── */
        .search-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .search-input-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 8px 14px;
            flex: 1;
            min-width: 180px;
            transition: border-color .2s;
        }

        .search-input-wrap:focus-within {
            border-color: #FF5500;
        }

        .search-input-wrap input {
            border: none;
            outline: none;
            font-size: 12.5px;
            color: #333;
            width: 100%;
            background: transparent;
            font-family: 'Poppins', sans-serif;
        }

        .search-input-wrap input::placeholder {
            color: #bbb;
        }

        .filter-btn {
            display: flex;
            align-items: center;
            gap: 7px;
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 8px 14px;
            font-size: 12px;
            font-weight: 500;
            color: #555;
            cursor: pointer;
            transition: all .18s ease;
            white-space: nowrap;
        }

        .filter-btn:hover {
            border-color: #FF5500;
            color: #FF5500;
        }

        .filter-btn.active {
            background: #FFF3EC;
            border-color: #FF5500;
            color: #FF5500;
        }

        .tambah-btn {
            display: flex;
            align-items: center;
            gap: 7px;
            background: #FF5500;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 9px 18px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            transition: background .18s;
            white-space: nowrap;
            text-decoration: none;
        }

        .tambah-btn:hover {
            background: #e04a00;
        }

        .filter-dropdown {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .12);
            border: 1px solid #f0e9d8;
            padding: 16px;
            width: 260px;
            position: absolute;
            z-index: 30;
            margin-top: 4px;
        }

        .filter-dropdown label {
            font-size: 11px;
            font-weight: 600;
            color: #888;
            text-transform: uppercase;
            letter-spacing: .05em;
            display: block;
            margin-bottom: 7px;
            margin-top: 12px;
        }

        .filter-dropdown label:first-child {
            margin-top: 0;
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

        /* ── Modal ── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            backdrop-filter: blur(4px);
            z-index: 60;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-box {
            background: #fff;
            border-radius: 20px;
            width: 100%;
            max-width: 520px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 24px 64px rgba(0, 0, 0, .18);
            animation: slideUp .25s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            padding: 20px 22px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            font-size: 15px;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
        }

        .modal-close {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: none;
            background: #f5f5f5;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #888;
            transition: all .15s;
        }

        .modal-close:hover {
            background: #ffe4d9;
            color: #FF5500;
        }

        .modal-body {
            padding: 18px 22px 24px;
        }

        .form-group {
            margin-bottom: 15px;
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
            min-height: 80px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .upload-area {
            border: 2px dashed #e5e7eb;
            border-radius: 12px;
            padding: 28px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            background: #fafafa;
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
            font-size: 28px;
            color: #ddd;
            margin-bottom: 8px;
            display: block;
            transition: color .2s;
        }

        .upload-area:hover i {
            color: #FF5500;
        }

        .upload-area p {
            font-size: 12px;
            color: #bbb;
            margin: 0;
            line-height: 1.5;
        }

        .upload-area span {
            color: #FF5500;
            font-weight: 600;
        }

        .preview-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-top: 10px;
        }

        .preview-item {
            aspect-ratio: 1;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            background: #f0ead8;
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-item .remove-img {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: rgba(0, 0, 0, .5);
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-submit {
            width: 100%;
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
            margin-top: 6px;
        }

        .btn-submit:hover {
            background: #e04a00;
        }

        /* ── Empty State ── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #bbb;
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
                    <h1 class="text-[15px] font-bold text-[#1a1a1a] leading-tight">Kelola Produk</h1>
                    <p class="text-[11px] text-[#aaa]" id="tanggalHariIni"></p>
                </div>
            </div>
            <div class="flex items-center gap-2.5 relative">
                <button id="notifBtn" onclick="toggleNotif()"
                    class="relative w-9 h-9 rounded-full bg-[#f5f5f5] hover:bg-[#FFF3EC] flex items-center justify-center transition-colors">
                    <i class="fa-regular fa-bell text-[#555] text-[15px]"></i>
                    @if(($notifCount ?? 0) > 0)
                        <span class="notif-badge">{{ $notifCount }}</span>
                    @endif
                </button>
                <button
                    class="relative w-9 h-9 rounded-full bg-[#f5f5f5] hover:bg-[#FFF3EC] flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-cart-shopping text-[#555] text-[15px]"></i>
                </button>
                <div id="notifDropdown"
                    class="hidden absolute top-12 right-0 w-72 bg-white rounded-2xl shadow-xl border border-[#f0e9d8] overflow-hidden z-50">
                    <div class="px-4 py-3 border-b border-[#f0e9d8] flex items-center justify-between">
                        <span class="text-[13px] font-semibold text-[#1a1a1a]">Notifikasi</span>
                        <span class="text-[10px] text-[#FF5500] font-medium cursor-pointer hover:underline">Tandai semua
                            dibaca</span>
                    </div>
                    @forelse($notifikasi ?? [] as $notif)
                        <div
                            class="px-4 py-3 hover:bg-[#FFF3EC] transition-colors border-b border-[#f9f4ed] cursor-pointer">
                            <p class="text-[12px] font-medium text-[#1a1a1a]">{{ $notif->judul }}</p>
                            <p class="text-[11px] text-[#888] mt-0.5">{{ $notif->pesan }}</p>
                            <p class="text-[10px] text-[#bbb] mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <div class="px-4 py-6 text-center">
                            <i class="fa-regular fa-bell-slash text-[#ddd] text-[26px]"></i>
                            <p class="text-[12px] text-[#aaa] mt-2">Tidak ada notifikasi</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </header>

        <main class="flex-1 p-5 lg:p-7 space-y-5 overflow-y-auto">
            @if(session('success'))
                <div
                    class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-[13px] flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-green-500"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="search-bar">
                <div class="search-input-wrap">
                    <i class="fa-solid fa-magnifying-glass" style="color:#bbb;font-size:13px;flex-shrink:0;"></i>
                    <input type="text" id="searchInput" placeholder="Cari produk..." oninput="filterProducts()">
                </div>
                <div style="position:relative;">
                    <button class="filter-btn" id="filterToggleBtn" onclick="toggleFilterDropdown()">
                        <i class="fa-solid fa-sliders" style="font-size:12px;"></i>
                        Filter
                    </button>
                    <div class="filter-dropdown" id="filterDropdown" style="display:none;">
                        <label>Kategori</label>
                        <div class="filter-chip-row">
                            <button class="filter-chip active"
                                onclick="toggleChip(this,'kategori','Semua')">Semua</button>
                            <button class="filter-chip" onclick="toggleChip(this,'kategori','Jacket')">Jacket</button>
                            <button class="filter-chip" onclick="toggleChip(this,'kategori','Sweater')">Sweater</button>
                            <button class="filter-chip" onclick="toggleChip(this,'kategori','Kemeja')">Kemeja</button>
                            <button class="filter-chip" onclick="toggleChip(this,'kategori','Celana')">Celana</button>
                            <button class="filter-chip" onclick="toggleChip(this,'kategori','Sepatu')">Sepatu</button>
                        </div>
                        <label>Stok</label>
                        <div class="filter-chip-row">
                            <button class="filter-chip active" onclick="toggleChip(this,'stok','Semua')">Semua</button>
                            <button class="filter-chip" onclick="toggleChip(this,'stok','Tersedia')">Tersedia</button>
                            <button class="filter-chip" onclick="toggleChip(this,'stok','Habis')">Habis</button>
                        </div>
                        <label>Urutkan</label>
                        <div class="filter-chip-row">
                            <button class="filter-chip active"
                                onclick="toggleChip(this,'sort','Terbaru')">Terbaru</button>
                            <button class="filter-chip" onclick="toggleChip(this,'sort','Termurah')">Termurah</button>
                            <button class="filter-chip" onclick="toggleChip(this,'sort','Termahal')">Termahal</button>
                        </div>
                        <div style="margin-top:14px;display:flex;gap:8px;">
                            <button onclick="resetFilter()"
                                style="flex:1;padding:8px;border-radius:10px;border:1.5px solid #e5e7eb;background:#fff;color:#555;font-size:12px;font-weight:500;cursor:pointer;font-family:'Poppins',sans-serif;">Reset</button>
                            <button onclick="applyFilter()"
                                style="flex:1;padding:8px;border-radius:10px;border:none;background:#FF5500;color:#fff;font-size:12px;font-weight:600;cursor:pointer;font-family:'Poppins',sans-serif;">Terapkan</button>
                        </div>
                    </div>
                </div>
                <button class="tambah-btn" onclick="openModal()">
                    <i class="fa-solid fa-plus" style="font-size:12px;"></i>
                    Tambah Produk
                </button>
            </div>

            {{-- Product Grid --}}
            @if($produks->isEmpty())
                <div class="empty-state">
                    <i class="fa-solid fa-box-open"
                        style="font-size:48px;color:#000000;display:block;margin-bottom:14px;"></i>
                    <p style="font-size:14px;font-weight:600;color:#000000;margin-bottom:6px;">Belum ada produk</p>
                    <p style="font-size:13px;color:#000000;margin:0;">Klik "Tambah Produk" untuk menambahkan produk
                        pertamamu
                    </p>
                </div>
            @else
                <div class="product-grid" id="productGrid">
                    @foreach($produks as $produk)
                        <div class="product-card" data-id="{{ $produk->id }}" data-nama="{{ $produk->nama_produk }}"
                            data-harga="{{ $produk->harga }}" data-kategori="{{ $produk->kategori }}"
                            data-stok="{{ $produk->stok }}" onclick=""
                            window.location='{{ route('seller.produk.detail', $produk->id) }}'>
                            <div class="product-img-wrap">
                                @if($produk->foto_utama)
                                    <img src="{{ Storage::url($produk->foto_utama) }}" alt="{{ $produk->nama_produk }}">
                                @else
                                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                                        <i class="fa-solid fa-image" style="font-size:36px;color:#d6c9b0;"></i>
                                    </div>
                                @endif
                                <span class="stock-badge {{ $produk->warna_badge }}">{{ $produk->stok }} Item</span>
                            </div>
                            <div class="product-info">
                                <p class="product-name">{{ $produk->nama_produk }}</p>
                                <p class="product-category">{{ $produk->kategori ?? '—' }} · {{ $produk->kondisi ?? '—' }}</p>
                                <p class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="empty-state" id="emptyState" style="display:none;">
                    <i class="fa-solid fa-magnifying-glass"
                        style="font-size:36px;color:#e0d5c0;display:block;margin-bottom:12px;"></i>
                    <p style="font-size:13px;color:#bbb;margin:0;">Produk tidak ditemukan</p>
                </div>
            @endif

        </main>
    </div>

    <div class="modal-overlay" id="modalTambah" style="display:none;" onclick="closeModalOutside(event)">
        <div class="modal-box" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3>Tambah Produk Baru</h3>
                <button class="modal-close" onclick="closeModal()"><i class="fa-solid fa-xmark"
                        style="font-size:12px;"></i></button>
            </div>
            <div class="modal-body">
                <form id="formTambahProduk" action="{{ route('seller.produk.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Foto Produk</label>
                        <div class="upload-area" id="uploadArea">
                            <input type="file" name="foto_utama" accept="image/*" onchange="handleImageUpload(event)">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <p><span>Klik untuk upload</span> atau drag & drop<br>JPG, PNG, WEBP · Maks 5MB</p>
                        </div>
                        <div class="preview-grid" id="previewGrid"></div>
                    </div>

                    <div class="form-group">
                        <label>Nama Produk *</label>
                        <input type="text" name="nama_produk" class="form-control"
                            placeholder="Contoh: Nike Windbreaker 1990 Original" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Harga (Rp) *</label>
                            <input type="number" name="harga" class="form-control" placeholder="150000" min="0"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Stok *</label>
                            <input type="number" name="stok" class="form-control" placeholder="1" min="0" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori" class="form-control">
                                <option value="">Pilih kategori</option>
                                <option>Jacket</option>
                                <option>Sweater</option>
                                <option>Kemeja</option>
                                <option>Celana</option>
                                <option>Sepatu</option>
                                <option>Aksesoris</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kondisi</label>
                            <select name="kondisi" class="form-control">
                                <option value="">Pilih kondisi</option>
                                <option>Seperti Baru</option>
                                <option>Kondisi Baik</option>
                                <option>Kondisi Cukup</option>
                                <option>Vintage</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Ukuran</label>
                        <div class="filter-chip-row" id="ukuranChips">
                            @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL', 'Free Size'] as $ukuran)
                                <button type="button" class="filter-chip"
                                    onclick="toggleUkuran(this, '{{ $ukuran }}')">{{ $ukuran }}</button>
                            @endforeach
                        </div>
                        <input type="hidden" name="ukuran" id="ukuranInput">
                    </div>

                    <div class="form-group">
                        <label>Deskripsi Produk</label>
                        <textarea name="deskripsi" class="form-control"
                            placeholder="Ceritakan detail produk, kondisi, bahan, dll..."></textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-plus" style="margin-right:6px;"></i>
                        Tambahkan Produk
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="modalDetail" style="display:none;" onclick="closeDetailOutside(event)">
        <div class="modal-box" onclick="event.stopPropagation()" style="max-width:480px;">
            <div class="modal-header">
                <h3 id="detailNama">Detail Produk</h3>
                <button class="modal-close" onclick="closeDetail()"><i class="fa-solid fa-xmark"
                        style="font-size:12px;"></i></button>
            </div>
            <div class="modal-body" id="detailBody">
                <div style="text-align:center;padding:40px 0;">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#FF5500;"></i>
                </div>
            </div>
        </div>
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

        function toggleNotif() {
            document.getElementById('notifDropdown').classList.toggle('hidden');
        }
        document.addEventListener('click', e => {
            const btn = document.getElementById('notifBtn');
            const dd = document.getElementById('notifDropdown');
            if (dd && btn && !btn.contains(e.target) && !dd.contains(e.target)) dd.classList.add('hidden');
        });

        let activeFilters = { kategori: 'Semua', stok: 'Semua', sort: 'Terbaru' };

        function toggleFilterDropdown() {
            const dd = document.getElementById('filterDropdown');
            const btn = document.getElementById('filterToggleBtn');
            const open = dd.style.display === 'none';
            dd.style.display = open ? 'block' : 'none';
            btn.classList.toggle('active', open);
        }
        document.addEventListener('click', e => {
            const btn = document.getElementById('filterToggleBtn');
            const dd = document.getElementById('filterDropdown');
            if (dd && btn && !btn.contains(e.target) && !dd.contains(e.target)) {
                dd.style.display = 'none';
                btn.classList.remove('active');
            }
        });
        function toggleChip(el, group, val) {
            el.closest('.filter-chip-row').querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            activeFilters[group] = val;
        }
        function applyFilter() {
            document.getElementById('filterDropdown').style.display = 'none';
            document.getElementById('filterToggleBtn').classList.remove('active');
            filterProducts();
        }
        function resetFilter() {
            activeFilters = { kategori: 'Semua', stok: 'Semua', sort: 'Terbaru' };
            document.querySelectorAll('#filterDropdown .filter-chip-row').forEach(row => {
                row.querySelectorAll('.filter-chip').forEach((c, i) => c.classList.toggle('active', i === 0));
            });
            filterProducts();
        }
        function filterProducts() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('#productGrid .product-card');
            let visible = 0;
            cards.forEach(card => {
                const nama = (card.dataset.nama || '').toLowerCase();
                const kategori = card.dataset.kategori || '';
                const stok = parseInt(card.dataset.stok) || 0;
                let show = true;
                if (q && !nama.includes(q)) show = false;
                if (activeFilters.kategori !== 'Semua' && kategori !== activeFilters.kategori) show = false;
                if (activeFilters.stok === 'Tersedia' && stok === 0) show = false;
                if (activeFilters.stok === 'Habis' && stok > 0) show = false;
                if (activeFilters.stok === 'Hampir Habis' && (stok > 2 || stok === 0)) show = false;
                card.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            const empty = document.getElementById('emptyState');
            if (empty) empty.style.display = visible === 0 ? 'block' : 'none';
        }

        function openModal() {
            document.getElementById('modalTambah').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        function closeModal() {
            document.getElementById('modalTambah').style.display = 'none';
            document.body.style.overflow = '';
        }
        function closeModalOutside(e) {
            if (e.target === document.getElementById('modalTambah')) closeModal();
        }

        function handleImageUpload(e) {
            const files = Array.from(e.target.files);
            const grid = document.getElementById('previewGrid');
            grid.innerHTML = '';
            files.forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = ev => {
                    const item = document.createElement('div');
                    item.className = 'preview-item';
                    item.innerHTML = `<img src="${ev.target.result}" alt="preview">`;
                    grid.appendChild(item);
                };
                reader.readAsDataURL(file);
            });
        }

        const selectedUkuran = new Set();
        function toggleUkuran(el, val) {
            el.classList.toggle('active');
            selectedUkuran.has(val) ? selectedUkuran.delete(val) : selectedUkuran.add(val);
            document.getElementById('ukuranInput').value = Array.from(selectedUkuran).join(',');
        }

        function bukaDetailProduk(id) {
            document.getElementById('modalDetail').style.display = 'flex';
            document.body.style.overflow = 'hidden';
            document.getElementById('detailNama').textContent = 'Memuat...';
            document.getElementById('detailBody').innerHTML = '<div style="text-align:center;padding:40px 0;"><i class="fa-solid fa-spinner fa-spin" style="font-size:24px;color:#FF5500;"></i></div>';

            fetch(`/seller/produk/${id}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
                .then(r => r.json())
                .then(p => {
                    document.getElementById('detailNama').textContent = p.nama_produk;
                    document.getElementById('detailBody').innerHTML = `
            ${p.foto_utama ? `<img src="${p.foto_utama}" style="width:100%;aspect-ratio:1;object-fit:cover;border-radius:12px;margin-bottom:16px;">` : ''}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px;">
                <div style="background:#f9f5ee;border-radius:10px;padding:10px 14px;">
                    <p style="font-size:10px;color:#aaa;margin:0 0 2px;font-weight:600;text-transform:uppercase;">Harga</p>
                    <p style="font-size:15px;font-weight:700;color:#FF5500;margin:0;">Rp ${Number(p.harga).toLocaleString('id-ID')}</p>
                </div>
                <div style="background:#f9f5ee;border-radius:10px;padding:10px 14px;">
                    <p style="font-size:10px;color:#aaa;margin:0 0 2px;font-weight:600;text-transform:uppercase;">Stok</p>
                    <p style="font-size:15px;font-weight:700;color:#1a1a1a;margin:0;">${p.stok} Item</p>
                </div>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px;">
                ${p.kategori ? `<span style="background:#FFF3EC;color:#FF5500;font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;">${p.kategori}</span>` : ''}
                ${p.kondisi ? `<span style="background:#f0f0f0;color:#555;font-size:11px;font-weight:500;padding:3px 10px;border-radius:20px;">${p.kondisi}</span>` : ''}
                ${p.ukuran ? `<span style="background:#f0f0f0;color:#555;font-size:11px;font-weight:500;padding:3px 10px;border-radius:20px;">${p.ukuran}</span>` : ''}
            </div>
            ${p.deskripsi ? `<p style="font-size:12px;color:#666;line-height:1.6;margin:0 0 16px;">${p.deskripsi}</p>` : ''}
            <div style="display:flex;gap:10px;margin-top:4px;">
                <a href="/seller/produk/${p.id}/edit"
                   style="flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:12px;background:#FFF3EC;border:1.5px solid #FF5500;color:#FF5500;font-size:13px;font-weight:600;text-decoration:none;">
                    <i class="fa-solid fa-pen"></i> Edit
                </a>
                <form action="/seller/produk/${p.id}" method="POST" style="flex:1;" onsubmit="return confirm('Hapus produk ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="width:100%;padding:10px;border-radius:12px;background:#fef2f2;border:1.5px solid #fca5a5;color:#ef4444;font-size:13px;font-weight:600;cursor:pointer;font-family:'Poppins',sans-serif;">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        `;
                })
                .catch(() => {
                    document.getElementById('detailBody').innerHTML = '<p style="text-align:center;color:#aaa;font-size:13px;">Gagal memuat data produk.</p>';
                });
        }
        function closeDetail() {
            document.getElementById('modalDetail').style.display = 'none';
            document.body.style.overflow = '';
        }
        function closeDetailOutside(e) {
            if (e.target === document.getElementById('modalDetail')) closeDetail();
        }

        function confirmLogout() { document.getElementById('logoutModal').classList.remove('hidden'); }
        function cancelLogout() { document.getElementById('logoutModal').classList.add('hidden'); }
        function doLogout() { document.getElementById('logoutForm').submit(); }
    </script>

</body>

</html>