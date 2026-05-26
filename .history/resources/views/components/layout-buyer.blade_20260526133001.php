@dump('layout loaded')

@props(['user' => null, 'titlePage' => 'Beranda'])

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThriftStop - {{ $titlePage }}</title>
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

        /* ── Sidebar ── */
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
            flex: 1;
            margin-left: 220px;
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

        /* Search bar */
        .search-wrap {
            flex: 1;
            max-width: 560px;
            display: flex;
            align-items: center;
            gap: 0;
            background: #f5f5f5;
            border-radius: 12px;
            overflow: hidden;
            border: 1.5px solid #ede4d4;
            transition: border-color .2s;
        }

        .search-wrap:focus-within {
            border-color: #FF5500;
            background: #fff;
        }

        .search-filter {
            padding: 0 12px;
            height: 40px;
            border: none;
            border-right: 1.5px solid #ede4d4;
            background: transparent;
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            font-weight: 500;
            color: #555;
            cursor: pointer;
            outline: none;
            white-space: nowrap;
        }

        .search-input {
            flex: 1;
            height: 40px;
            border: none;
            background: transparent;
            outline: none;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            color: #1a1a1a;
            padding: 0 12px;
        }

        .search-input::placeholder {
            color: #bbb;
        }

        .search-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: #FF5500;
            color: #fff;
            cursor: pointer;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s;
            flex-shrink: 0;
        }

        .search-btn:hover {
            background: #e04d00;
        }

        /* Filter dropdown */
        .filter-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, .12);
            border: 1px solid #f0e9d8;
            z-index: 100;
            padding: 16px;
            display: none;
        }

        .filter-dropdown.show {
            display: block;
        }

        .filter-group-label {
            font-size: 10px;
            font-weight: 700;
            color: #bbb;
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 8px;
        }

        .filter-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 14px;
        }

        .filter-chip {
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            border: 1.5px solid #ede4d4;
            color: #666;
            cursor: pointer;
            transition: all .15s ease;
            background: #fff;
        }

        .filter-chip:hover {
            border-color: #FF5500;
            color: #FF5500;
        }

        .filter-chip.active {
            background: #FF5500;
            border-color: #FF5500;
            color: #fff;
        }

        .filter-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            margin-top: 4px;
        }

        .filter-reset {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            border: 1.5px solid #ede4d4;
            color: #888;
            background: #fff;
            cursor: pointer;
        }

        .filter-apply {
            padding: 6px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            border: none;
            background: #FF5500;
            color: #fff;
            cursor: pointer;
        }

        /* Notif badge */
        .notif-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            background: #FF5500;
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Footer */
        footer {
            background: #fff;
            border-top: 1px solid #f0e9d8;
            padding: 32px 32px 20px;
            margin-top: auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 32px;
            margin-bottom: 24px;
        }

        .footer-brand-name {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .footer-desc {
            font-size: 12px;
            color: #888;
            line-height: 1.8;
            margin-bottom: 14px;
        }

        .footer-socials {
            display: flex;
            gap: 8px;
        }

        .footer-social-btn {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #FFF3EC;
            color: #FF5500;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all .2s;
        }

        .footer-social-btn:hover {
            background: #FF5500;
            color: #fff;
        }

        .footer-col-title {
            font-size: 13px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 12px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .footer-links a {
            font-size: 12px;
            color: #888;
            text-decoration: none;
            transition: color .15s;
        }

        .footer-links a:hover {
            color: #FF5500;
        }

        .footer-bottom {
            border-top: 1px solid #f0e9d8;
            padding-top: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .footer-copy {
            font-size: 11px;
            color: #bbb;
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

        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

            .search-filter {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @stack('styles')
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
                class="hide-on-collapse bg-[#FF5500] text-white text-[11px] font-semibold px-3 py-1 rounded-md tracking-wide">Buyer</span>
        </div>

        <div class="mx-3 mb-4 rounded-xl bg-[#F1E0B4]/60 p-3 flex items-center gap-3 profile-wrap flex-shrink-0">
            @if(!empty($user->foto_profil))
                <img src="{{ Storage::url($user->foto_profil) }}"
                    class="w-9 h-9 rounded-full object-cover ring-2 ring-[#FF5500]/30 flex-shrink-0" alt="Foto Profil">
            @else
                <div
                    class="w-9 h-9 rounded-full bg-[#FF5500]/15 flex items-center justify-center ring-2 ring-[#FF5500]/25 flex-shrink-0">
                    <i class="fa-solid fa-user text-[#FF5500] text-[13px]"></i>
                </div>
            @endif
            <div class="hide-on-collapse overflow-hidden">
                <p class="text-[12px] font-semibold text-[#1a1a1a] truncate">{{ $user->name ?? 'Pengguna' }}</p>
                <p class="text-[10px] text-[#888]">{{ $user->email ?? '' }}</p>
            </div>
        </div>

        <nav class="px-3 space-y-1 overflow-y-auto flex-1">
            <a href="{{ route('buyer.home') }}" class="nav-link {{ request()->routeIs('buyer.home') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-house"></i></span>
                <span class="hide-on-collapse">Beranda</span>
            </a>
            <a href="{{ route('buyer.shop') }}"
                class="nav-link {{ request()->routeIs('buyer.shop*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-store"></i></span>
                <span class="hide-on-collapse">Toko</span>
            </a>
            <a href="{{ route('buyer.keranjang') }}"
                class="nav-link {{ request()->routeIs('buyer.keranjang*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-cart-shopping"></i></span>
                <span class="hide-on-collapse">Keranjang</span>
            </a>
            <a href="{{ route('buyer.akun') }}"
                class="nav-link {{ request()->routeIs('buyer.akun*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-user"></i></span>
                <span class="hide-on-collapse">Akun Saya</span>
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
        {{-- Header --}}
        <header
            class="sticky top-0 z-20 bg-white/90 backdrop-blur-md shadow-sm px-5 lg:px-8 py-3 flex items-center gap-4 flex-shrink-0">
            <button onclick="openSidebar()"
                class="lg:hidden text-[#555] hover:text-[#FF5500] transition-colors flex-shrink-0">
                <i class="fa-solid fa-bars text-[18px]"></i>
            </button>

            {{-- Search + Filter --}}
            <div class="relative flex-1 max-w-xl" id="searchArea">
                <div class="search-wrap" id="searchWrap">
                    <select class="search-filter" id="filterKategori" title="Kategori">
                        <option value="">Semua</option>
                        <option value="pria">Pria</option>
                        <option value="wanita">Wanita</option>
                        <option value="anak">Anak</option>
                        <option value="aksesori">Aksesori</option>
                    </select>
                    <input type="text" class="search-input" placeholder="Cari produk..." id="searchInput"
                        onfocus="openFilter()" autocomplete="off">
                    <button class="search-btn" onclick="doSearch()">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>

                {{-- Filter Dropdown --}}
                <div class="filter-dropdown" id="filterDropdown">
                    <div class="filter-group-label">Ukuran</div>
                    <div class="filter-chips" id="chipsUkuran">
                        @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $uk)
                            <span class="filter-chip" onclick="toggleChip(this)">{{ $uk }}</span>
                        @endforeach
                    </div>
                    <div class="filter-group-label">Kondisi</div>
                    <div class="filter-chips" id="chipsKondisi">
                        @foreach(['Baru', 'Seperti Baru', 'Bekas - Baik', 'Bekas - Cukup'] as $kd)
                            <span class="filter-chip" onclick="toggleChip(this)">{{ $kd }}</span>
                        @endforeach
                    </div>
                    <div class="filter-actions">
                        <button class="filter-reset" onclick="resetFilter()">Reset</button>
                        <button class="filter-apply" onclick="applyFilter()">Terapkan</button>
                    </div>
                </div>
            </div>

            {{-- Notif + Keranjang --}}
            <div class="flex items-center gap-2 flex-shrink-0 relative">
                <button id="notifBtn" onclick="toggleNotif()"
                    class="relative w-9 h-9 rounded-full bg-[#f5f5f5] hover:bg-[#FFF3EC] flex items-center justify-center transition-colors">
                    <i class="fa-regular fa-bell text-[#555] text-[15px]"></i>
                    @if(($notifCount ?? 0) > 0)
                        <span class="notif-badge">{{ $notifCount }}</span>
                    @endif
                </button>
                <a href="{{ route('buyer.keranjang') }}"
                    class="relative w-9 h-9 rounded-full bg-[#f5f5f5] hover:bg-[#FFF3EC] flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-cart-shopping text-[#555] text-[15px]"></i>
                    @if(($cartCount ?? 0) > 0)
                        <span class="notif-badge">{{ $cartCount }}</span>
                    @endif
                </a>

                {{-- Notif Dropdown --}}
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

        {{-- Main content --}}
        <main class="flex-1 p-5 lg:p-7 space-y-6 overflow-y-auto">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer>
            <div class="footer-grid">
                <div>
                    <div class="footer-brand-name">
                        <span class="text-[#FF5500]">Thrift</span><span class="text-[#1a1a1a]">Stop</span>
                    </div>
                    <p class="footer-desc">Platform thrift terpercaya untuk kamu yang ingin berbelanja produk fashion
                        berkualitas dengan harga terjangkau.</p>
                    <div class="footer-socials">
                        <a href="#" class="footer-social-btn"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="footer-social-btn"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="#" class="footer-social-btn"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="footer-social-btn"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>
                <div>
                    <div class="footer-col-title">Navigasi</div>
                    <ul class="footer-links">
                        <li><a href="{{ route('buyer.home') }}">Beranda</a></li>
                        <li><a href="{{ route('buyer.shop') }}">Toko</a></li>
                        <li><a href="{{ route('buyer.keranjang') }}">Keranjang</a></li>
                        <li><a href="{{ route('buyer.akun') }}">Akun Saya</a></li>
                    </ul>
                </div>
                <div>
                    <div class="footer-col-title">Bantuan</div>
                    <ul class="footer-links">
                        <li><a href="#">Cara Belanja</a></li>
                        <li><a href="#">Kebijakan Pengembalian</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div>
                    <div class="footer-col-title">Kontak</div>
                    <ul class="footer-links">
                        <li><a href="#">support@thriftstop.id</a></li>
                        <li><a href="#">+62 812-3456-7890</a></li>
                        <li><a href="#">Jakarta, Indonesia</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span class="footer-copy">© {{ date('Y') }} ThriftStop. Semua hak dilindungi.</span>
                <span class="footer-copy">Dibuat dengan <i class="fa-solid fa-heart text-[#FF5500] text-[10px]"></i> di
                    Indonesia</span>
            </div>
        </footer>
    </div>

    {{-- Logout Modal --}}
    <div id="logoutModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="cancelLogout()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-[300px] mx-4 text-center">
            <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-right-from-bracket text-red-400 text-[22px]"></i>
            </div>
            <h3 class="text-[16px] font-bold text-[#1a1a1a]">Keluar dari Akun?</h3>
            <p class="text-[12px] text-[#888] mt-1.5 mb-5 leading-relaxed">Kamu akan keluar dari akun ThriftStop. Yakin
                ingin melanjutkan?</p>
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
        // Tanggal
        const _days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const _months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const _now = new Date();
        const tglEl = document.getElementById('tanggalHariIni');
        if (tglEl) tglEl.textContent = _days[_now.getDay()] + ', ' + _now.getDate() + ' ' + _months[_now.getMonth()] + ' ' + _now.getFullYear();

        // Sidebar
        function openSidebar() { document.getElementById('sidebar').classList.add('open'); document.getElementById('sidebarOverlay').classList.add('show'); document.body.style.overflow = 'hidden'; }
        function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sidebarOverlay').classList.remove('show'); document.body.style.overflow = ''; }
        function toggleCollapse() { document.getElementById('sidebar').classList.toggle('collapsed'); document.getElementById('mainWrap').classList.toggle('collapsed'); }

        // Notif
        function toggleNotif() { document.getElementById('notifDropdown').classList.toggle('hidden'); }
        document.addEventListener('click', e => {
            const btn = document.getElementById('notifBtn');
            const dd = document.getElementById('notifDropdown');
            if (btn && !btn.contains(e.target) && dd && !dd.contains(e.target)) dd.classList.add('hidden');
        });

        // Logout
        function confirmLogout() { document.getElementById('logoutModal').classList.remove('hidden'); }
        function cancelLogout() { document.getElementById('logoutModal').classList.add('hidden'); }
        function doLogout() { document.getElementById('logoutForm').submit(); }

        // Filter
        function openFilter() { document.getElementById('filterDropdown').classList.add('show'); }
        function closeFilter() { document.getElementById('filterDropdown').classList.remove('show'); }
        function toggleChip(el) { el.classList.toggle('active'); }
        function resetFilter() {
            document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
            document.getElementById('filterKategori').value = '';
        }
        function applyFilter() {
            const kategori = document.getElementById('filterKategori').value;
            const ukuran = [...document.querySelectorAll('#chipsUkuran .filter-chip.active')].map(c => c.textContent);
            const kondisi = [...document.querySelectorAll('#chipsKondisi .filter-chip.active')].map(c => c.textContent);
            const q = document.getElementById('searchInput').value;
            const params = new URLSearchParams();
            if (q) params.set('q', q);
            if (kategori) params.set('kategori', kategori);
            if (ukuran.length) params.set('ukuran', ukuran.join(','));
            if (kondisi.length) params.set('kondisi', kondisi.join(','));
            window.location.href = '{{ route("buyer.shop") }}?' + params.toString();
        }
        function doSearch() {
            const q = document.getElementById('searchInput').value;
            if (q.trim()) window.location.href = '{{ route("buyer.shop") }}?q=' + encodeURIComponent(q);
        }
        document.getElementById('searchInput')?.addEventListener('keydown', e => { if (e.key === 'Enter') doSearch(); });
        document.addEventListener('click', e => {
            const area = document.getElementById('searchArea');
            if (area && !area.contains(e.target)) closeFilter();
        });
    </script>

    @stack('scripts')
</body>

</html>