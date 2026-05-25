<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThriftStop - Seller</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
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

        main {
            flex: 1;
            padding: 28px;
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

        .insight-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .insight-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 28px;
            padding: 22px;
            position: relative;
            overflow: hidden;
            transition: .3s ease;
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.04),
                0 2px 10px rgba(0, 0, 0, 0.02);
        }

        .insight-card:hover {
            transform: translateY(-4px);
            box-shadow:
                0 18px 40px rgba(0, 0, 0, 0.07),
                0 5px 15px rgba(0, 0, 0, 0.04);
        }

        .insight-card::before {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            top: -50px;
            right: -50px;
            opacity: .08;
        }

        .insight-top {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 14px;
        }

        .insight-label {
            font-size: 11px;
            color: #999;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 10px;
        }

        .insight-value {
            font-size: 28px;
            font-weight: 800;
            color: #1a1a1a;
            line-height: 1.1;
        }

        .insight-sub {
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .insight-sub.up {
            color: #16a34a;
        }

        .insight-sub.down {
            color: #dc2626;
        }

        .insight-sub.neutral {
            color: #999;
        }

        .insight-icon {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .insight-icon.orange {
            background: #FFF3EC;
            color: #FF5500;
        }

        .insight-icon.green {
            background: #f0fdf4;
            color: #22c55e;
        }

        .insight-icon.blue {
            background: #eff6ff;
            color: #3b82f6;
        }

        .insight-icon.purple {
            background: #faf5ff;
            color: #a855f7;
        }

        .section-card {
            background: rgba(255, 255, 255, 0.96);
            border-radius: 28px;
            overflow: hidden;
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.04),
                0 2px 10px rgba(0, 0, 0, 0.02);
        }

        .section-header {
            padding: 20px 24px;
            border-bottom: 1px solid #f4ede2;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .table-scroll {
            overflow-x: auto;
        }

        .rekap-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rekap-table thead tr {
            background: #fffaf4;
        }

        .rekap-table th {
            padding: 14px 20px;
            font-size: 11px;
            color: #999;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            text-align: left;
        }

        .rekap-table td {
            padding: 16px 20px;
            font-size: 13px;
            border-bottom: 1px solid #f8f2e9;
            color: #333;
        }

        .rekap-table tbody tr {
            transition: .2s ease;
        }

        .rekap-table tbody tr:hover {
            background: #fffaf6;
        }

        .month-cell {
            font-weight: 700;
            color: #1a1a1a;
        }

        .income-cell {
            font-weight: 700;
            color: #FF5500;
        }

        .badge-yoy {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-yoy.up {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-yoy.down {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-yoy.flat {
            background: #f3f4f6;
            color: #6b7280;
        }

        .pay-list {
            padding: 10px 0;
        }

        .pay-item {
            padding: 16px 22px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .pay-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .pay-icon.qris {
            background: #FFF3EC;
            color: #FF5500;
        }

        .pay-icon.tf {
            background: #eff6ff;
            color: #3b82f6;
        }

        .pay-icon.cod {
            background: #f0fdf4;
            color: #22c55e;
        }

        .pay-bar-wrap {
            flex: 1;
        }

        .pay-name {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #1a1a1a;
        }

        .pay-bar-bg {
            height: 8px;
            border-radius: 999px;
            background: #f3ead9;
            overflow: hidden;
        }

        .pay-bar {
            height: 100%;
            border-radius: 999px;
        }

        .pay-bar.qris {
            width: 52%;
            background: #FF5500;
        }

        .pay-bar.tf {
            width: 28%;
            background: #3b82f6;
        }

        .pay-bar.cod {
            width: 13%;
            background: #22c55e;
        }

        .pay-pct {
            font-size: 12px;
            font-weight: 700;
            color: #666;
            min-width: 40px;
            text-align: right;
        }

        @media (max-width: 860px) {

            .rekap-grid {
                grid-template-columns: 1fr;
            }

            main {
                padding: 20px;
            }

            .insight-strip {
                grid-template-columns: 1fr;
            }

            .insight-value {
                font-size: 24px;
            }

            #mainWrap {
                margin-left: 0;
            }
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
                    <h1 class="text-[15px] font-bold text-[#1a1a1a] leading-tight">Laporan Penjualan</h1>
                    <p class="text-[11px] text-[#aaa]" id="tanggalHariIni"></p>
                </div>
            </div>
            <div class="flex items-center gap-2.5">
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

        <main class="flex-1 p-5 lg:p-7 space-y-5 overflow-y-auto">
            <div class="insight-strip">
                <div class="insight-card orange">
                    <div class="insight-top">
                        <div>
                            <div class="insight-label">Total Income Tahun Ini</div>
                            <div class="insight-value">Rp 43,7 jt</div>
                        </div>
                        <div class="insight-icon orange">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                    </div>
                    <div class="insight-sub up">
                        <i class="fa-solid fa-arrow-up"></i>
                        24% vs tahun lalu
                    </div>
                </div>
                <div class="insight-card green">
                    <div class="insight-top">
                        <div>
                            <div class="insight-label">Item Terjual</div>
                            <div class="insight-value">361</div>
                        </div>
                        <div class="insight-icon green">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                    </div>
                    <div class="insight-sub up">
                        <i class="fa-solid fa-arrow-up"></i>
                        14% vs tahun lalu
                    </div>
                </div>
                <div class="insight-card blue">
                    <div class="insight-top">
                        <div>
                            <div class="insight-label">Total Order</div>
                            <div class="insight-value">288</div>
                        </div>

                        <div class="insight-icon blue">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                    </div>
                    <div class="insight-sub up">
                        <i class="fa-solid fa-arrow-up"></i>
                        11% vs tahun lalu
                    </div>
                </div>
                <div class="insight-card purple">
                    <div class="insight-top">
                        <div>
                            <div class="insight-label">Rata-rata / Bulan</div>
                            <div class="insight-value">Rp 8,7 jt</div>
                        </div>

                        <div class="insight-icon purple">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="insight-sub neutral">
                        dari bulan aktif
                    </div>
                </div>
            </div>

            <div class="rekap-grid">

                <!-- TABLE -->
                <div class="section-card">

                    <div class="section-header">
                        <div class="section-title">
                            <i class="fa-solid fa-book-open text-[#FF5500] mr-2"></i>
                            Rekap Bulanan
                        </div>
                    </div>

                    <div class="table-scroll">
                        <table class="rekap-table">

                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th>Income</th>
                                    <th>Order</th>
                                    <th>Item</th>
                                    <th>YoY</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td class="month-cell">Januari</td>
                                    <td class="income-cell">Rp 8.200.000</td>
                                    <td>54 order</td>
                                    <td>68 item</td>
                                    <td>
                                        <span class="badge-yoy up">
                                            ▲ 24%
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="month-cell">Februari</td>
                                    <td class="income-cell">Rp 7.450.000</td>
                                    <td>48 order</td>
                                    <td>60 item</td>
                                    <td>
                                        <span class="badge-yoy up">
                                            ▲ 18%
                                        </span>
                                    </td>
                                </tr>

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>


        </main>
    </div>

    <!-- Logout Modal -->
    <div id="logoutModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="cancelLogout()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-[300px] mx-4 text-center">
            <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-right-from-bracket text-red-400 text-[22px]"></i>
            </div>
            <h3 class="text-[16px] font-bold text-[#1a1a1a]">Keluar dari Akun?</h3>
            <p class="text-[12px] text-[#888] mt-1.5 mb-5 leading-relaxed">Kamu akan keluar dari akun seller ThriftStop.
            </p>
            <div class="flex gap-3">
                <button onclick="cancelLogout()"
                    class="flex-1 py-2.5 rounded-xl border border-[#e5e7eb] text-[13px] font-medium text-[#555] hover:bg-[#f5f5f5] transition-colors">Batal</button>
                <button onclick="doLogout()"
                    class="flex-1 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-[13px] font-semibold text-white transition-colors">Ya,
                    Keluar</button>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 860px) {
            .rekap-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

    <script>
        // ── Tanggal ──
        const _days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const _months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const _now = new Date();
        document.getElementById('tanggalHariIni').textContent =
            _days[_now.getDay()] + ', ' + _now.getDate() + ' ' + _months[_now.getMonth()] + ' ' + _now.getFullYear();

        // ── Sidebar ──
        function openSidebar() { document.getElementById('sidebar').classList.add('open'); document.getElementById('sidebarOverlay').classList.add('show'); document.body.style.overflow = 'hidden'; }
        function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sidebarOverlay').classList.remove('show'); document.body.style.overflow = ''; }
        function toggleCollapse() { document.getElementById('sidebar').classList.toggle('collapsed'); document.getElementById('mainWrap').classList.toggle('collapsed'); }
        function confirmLogout() { document.getElementById('logoutModal').classList.remove('hidden'); }
        function cancelLogout() { document.getElementById('logoutModal').classList.add('hidden'); }
        function doLogout() { document.getElementById('logoutForm').submit(); }

        const REKAP = {
            2025: [
                { bln: 'Januari', income: 8200000, order: 54, item: 68, itemLalu: 51, incomeLalu: 6100000, status: 'selesai' },
                { bln: 'Februari', income: 7450000, order: 48, item: 60, itemLalu: 44, incomeLalu: 5800000, status: 'selesai' },
                { bln: 'Maret', income: 9100000, order: 61, item: 77, itemLalu: 58, incomeLalu: 6400000, status: 'selesai' },
                { bln: 'April', income: 8750000, order: 57, item: 71, itemLalu: 63, incomeLalu: 7100000, status: 'selesai' },
                { bln: 'Mei', income: 10200000, order: 68, item: 85, itemLalu: 70, incomeLalu: 6800000, status: 'selesai' },
                { bln: 'Juni', income: 0, order: 0, item: 0, itemLalu: 62, incomeLalu: 7300000, status: 'proses' },
                { bln: 'Juli', income: 0, order: 0, item: 0, itemLalu: 55, incomeLalu: 6100000, status: 'proses' },
                { bln: 'Agustus', income: 0, order: 0, item: 0, itemLalu: 48, incomeLalu: 4700000, status: 'proses' },
                { bln: 'September', income: 0, order: 0, item: 0, itemLalu: 52, incomeLalu: 5200000, status: 'proses' },
                { bln: 'Oktober', income: 0, order: 0, item: 0, itemLalu: 44, incomeLalu: 3800000, status: 'proses' },
                { bln: 'November', income: 0, order: 0, item: 0, itemLalu: 46, incomeLalu: 4100000, status: 'proses' },
                { bln: 'Desember', income: 0, order: 0, item: 0, itemLalu: 38, incomeLalu: 3200000, status: 'proses' },
            ],
            2024: [
                { bln: 'Januari', income: 6100000, order: 41, item: 51, itemLalu: 38, incomeLalu: 4200000, status: 'selesai' },
                { bln: 'Februari', income: 5800000, order: 38, item: 44, itemLalu: 34, incomeLalu: 3900000, status: 'selesai' },
                { bln: 'Maret', income: 6400000, order: 43, item: 58, itemLalu: 40, incomeLalu: 4500000, status: 'selesai' },
                { bln: 'April', income: 7100000, order: 47, item: 63, itemLalu: 44, incomeLalu: 4800000, status: 'selesai' },
                { bln: 'Mei', income: 6800000, order: 45, item: 70, itemLalu: 50, incomeLalu: 5100000, status: 'selesai' },
                { bln: 'Juni', income: 7300000, order: 49, item: 62, itemLalu: 46, incomeLalu: 4900000, status: 'selesai' },
                { bln: 'Juli', income: 6100000, order: 40, item: 55, itemLalu: 42, incomeLalu: 4300000, status: 'selesai' },
                { bln: 'Agustus', income: 4700000, order: 31, item: 48, itemLalu: 36, incomeLalu: 3600000, status: 'selesai' },
                { bln: 'September', income: 5200000, order: 34, item: 52, itemLalu: 39, incomeLalu: 3900000, status: 'selesai' },
                { bln: 'Oktober', income: 3800000, order: 25, item: 44, itemLalu: 33, incomeLalu: 3100000, status: 'selesai' },
                { bln: 'November', income: 4100000, order: 27, item: 46, itemLalu: 34, incomeLalu: 3300000, status: 'selesai' },
                { bln: 'Desember', income: 3200000, order: 21, item: 38, itemLalu: 28, incomeLalu: 2700000, status: 'selesai' },
            ],
        };

        function rupiah(n) {
            if (n >= 1000000) return 'Rp ' + (n / 1000000).toFixed(1).replace('.', ',') + ' jt';
            if (n >= 1000) return 'Rp ' + (n / 1000).toFixed(0) + ' rb';
            return 'Rp ' + n.toLocaleString('id-ID');
        }
        function rupiahFull(n) {
            return 'Rp ' + n.toLocaleString('id-ID');
        }

        function pctDiff(now, prev) {
            if (!prev) return null;
            return Math.round(((now - prev) / prev) * 100);
        }

        function renderRekap() {
            const yr = parseInt(document.getElementById('yearSelect').value);
            const data = REKAP[yr] || [];

            let totalIncome = 0, totalOrder = 0, totalItem = 0;
            const aktif = data.filter(r => r.income > 0);

            const statusLabel = { selesai: 'Selesai', proses: 'Dalam Proses', retur: 'Ada Retur' };
            const statusClass = { selesai: 'selesai', proses: 'proses', retur: 'retur' };

            let rows = '';
            data.forEach(r => {
                totalIncome += r.income;
                totalOrder += r.order;
                totalItem += r.item;

                const yoy = r.income > 0 ? pctDiff(r.income, r.incomeLalu) : null;
                let yoyHtml = '<span style="color:#ccc; font-size:11px;">—</span>';
                if (yoy !== null) {
                    const cls = yoy > 0 ? 'up' : (yoy < 0 ? 'down' : 'flat');
                    const icon = yoy > 0 ? '▲' : (yoy < 0 ? '▼' : '—');
                    yoyHtml = `<span class="badge-yoy ${cls}">${icon} ${Math.abs(yoy)}%</span>`;
                }

                const itemDiff = r.item - r.itemLalu;
                let itemArrow = '';
                if (r.item > 0) {
                    if (itemDiff > 0) itemArrow = `<i class="fa-solid fa-arrow-up item-sold-arrow up"></i>`;
                    else if (itemDiff < 0) itemArrow = `<i class="fa-solid fa-arrow-down item-sold-arrow down"></i>`;
                    else itemArrow = `<span style="color:#aaa; font-size:11px;">—</span>`;
                }

                const incomeDisplay = r.income > 0 ? rupiahFull(r.income) : '<span style="color:#ccc">—</span>';
                const orderDisplay = r.order > 0 ? r.order + ' order' : '<span style="color:#ccc">—</span>';
                const itemDisplay = r.item > 0
                    ? `<div class="item-sold-wrap">${itemArrow}<span>${r.item} item</span></div>`
                    : '<span style="color:#ccc">—</span>';

                rows += `
            <tr>
                <td class="month-cell">${r.bln}</td>
                <td class="income-cell">${incomeDisplay}</td>
                <td>${orderDisplay}</td>
                <td>${itemDisplay}</td>
                <td>${yoyHtml}</td>
                <td><span class="status-pill ${statusClass[r.status]}">${statusLabel[r.status]}</span></td>
            </tr>`;
            });

            document.getElementById('rekapBody').innerHTML = rows;
            document.getElementById('footerIncome').textContent = rupiahFull(totalIncome);
            document.getElementById('footerOrder').textContent = totalOrder + ' order';
            document.getElementById('footerItem').textContent = totalItem + ' item';

            // Update insight cards
            const avgIncome = aktif.length ? Math.round(totalIncome / aktif.length) : 0;
            const prevIncome = aktif.reduce((s, r) => s + r.incomeLalu, 0);
            const prevItem = aktif.reduce((s, r) => s + r.itemLalu, 0);
            const prevOrder = aktif.reduce((s, r) => s + (r.order > 0 ? Math.round(r.order * 0.85) : 0), 0);

            document.getElementById('insightIncome').textContent = rupiahFull(totalIncome);
            const incPct = pctDiff(totalIncome, prevIncome);
            const incEl = document.getElementById('insightIncomeSub');
            incEl.innerHTML = `<i class="fa-solid fa-arrow-${incPct >= 0 ? 'up' : 'down'}"></i> ${Math.abs(incPct)}% vs tahun lalu`;
            incEl.className = `insight-sub ${incPct >= 0 ? 'up' : 'down'}`;

            const totalItemAktif = aktif.reduce((s, r) => s + r.item, 0);
            document.getElementById('insightItem').textContent = totalItemAktif + ' item';
            const itemPct = pctDiff(totalItemAktif, prevItem);
            const itemEl = document.getElementById('insightItemSub');
            itemEl.innerHTML = `<i class="fa-solid fa-arrow-${itemPct >= 0 ? 'up' : 'down'}"></i> ${Math.abs(itemPct)}% vs tahun lalu`;
            itemEl.className = `insight-sub ${itemPct >= 0 ? 'up' : 'down'}`;

            const totalOrderAktif = aktif.reduce((s, r) => s + r.order, 0);
            document.getElementById('insightOrder').textContent = totalOrderAktif + ' order';
            const ordPct = pctDiff(totalOrderAktif, prevOrder);
            const ordEl = document.getElementById('insightOrderSub');
            ordEl.innerHTML = `<i class="fa-solid fa-arrow-${ordPct >= 0 ? 'up' : 'down'}"></i> ${Math.abs(ordPct)}% vs tahun lalu`;
            ordEl.className = `insight-sub ${ordPct >= 0 ? 'up' : 'down'}`;

            document.getElementById('insightAvg').textContent = rupiah(avgIncome);
            document.getElementById('insightAvg').title = rupiahFull(avgIncome);
        }

        // ── Init ──
        renderRekap();
    </script>
</body>

</html>