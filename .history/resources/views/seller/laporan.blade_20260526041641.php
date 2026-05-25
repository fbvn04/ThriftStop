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

        /* ── Section Cards ── */
        .section-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .section-header {
            padding: 14px 20px;
            border-bottom: 1px solid #f5f0e8;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #1a1a1a;
        }

        /* ── Insight Cards ── */
        .insight-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 12px;
        }

        .insight-card {
            background: #fff;
            border-radius: 14px;
            padding: 14px 16px;
            box-shadow: 0 1px 8px rgba(0, 0, 0, .05);
            border-left: 3px solid transparent;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .insight-card.orange {
            border-left-color: #FF5500;
        }

        .insight-card.green {
            border-left-color: #22c55e;
        }

        .insight-card.blue {
            border-left-color: #3b82f6;
        }

        .insight-card.purple {
            border-left-color: #a855f7;
        }

        .insight-label {
            font-size: 10px;
            color: #aaa;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .insight-value {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1.2;
        }

        .insight-sub {
            font-size: 10.5px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 3px;
            margin-top: 2px;
        }

        .insight-sub.up {
            color: #22c55e;
        }

        .insight-sub.down {
            color: #ef4444;
        }

        .insight-sub.neutral {
            color: #aaa;
        }

        /* ── Tabel Rekap ── */
        .rekap-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .rekap-table thead tr {
            background: #fdf8f0;
        }

        .rekap-table th {
            padding: 10px 16px;
            text-align: left;
            font-size: 10.5px;
            font-weight: 700;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-bottom: 1px solid #f0e9d8;
            white-space: nowrap;
        }

        .rekap-table td {
            padding: 11px 16px;
            border-bottom: 1px solid #f9f5ee;
            color: #333;
            vertical-align: middle;
        }

        .rekap-table tbody tr:last-child td {
            border-bottom: none;
        }

        .rekap-table tbody tr:hover td {
            background: #fdf9f4;
        }

        .rekap-table .month-cell {
            font-weight: 600;
            color: #1a1a1a;
        }

        .rekap-table .income-cell {
            font-weight: 700;
            color: #1a1a1a;
        }

        .badge-yoy {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 20px;
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

        .item-sold-wrap {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .item-sold-arrow {
            font-size: 11px;
        }

        .item-sold-arrow.up {
            color: #22c55e;
        }

        .item-sold-arrow.down {
            color: #ef4444;
        }

        /* ── Payment Method ── */
        .pay-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .pay-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 20px;
            border-bottom: 1px solid #f9f5ee;
        }

        .pay-item:last-child {
            border-bottom: none;
        }

        .pay-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .pay-icon.qris {
            background: #fff0ea;
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

        .pay-icon.wallet {
            background: #faf5ff;
            color: #a855f7;
        }

        .pay-bar-wrap {
            flex: 1;
        }

        .pay-name {
            font-size: 12px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 4px;
        }

        .pay-bar-bg {
            height: 5px;
            background: #f0ead8;
            border-radius: 10px;
            overflow: hidden;
        }

        .pay-bar {
            height: 100%;
            border-radius: 10px;
            transition: width .6s ease;
        }

        .pay-bar.qris {
            background: #FF5500;
        }

        .pay-bar.tf {
            background: #3b82f6;
        }

        .pay-bar.cod {
            background: #22c55e;
        }

        .pay-bar.wallet {
            background: #a855f7;
        }

        .pay-pct {
            font-size: 11px;
            font-weight: 700;
            color: #555;
            white-space: nowrap;
            min-width: 36px;
            text-align: right;
        }

        /* ── Status Pill ── */
        .status-pill {
            display: inline-block;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .status-pill.selesai {
            background: #dcfce7;
            color: #15803d;
        }

        .status-pill.proses {
            background: #fef9c3;
            color: #92400e;
        }

        .status-pill.retur {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* ── Rekap Year Filter ── */
        .year-select {
            border: 1px solid #f0e9d8;
            border-radius: 8px;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 600;
            color: #555;
            background: #fff;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            outline: none;
        }

        /* ── Scrollbar ── */
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

        /* ── Table scroll on mobile ── */
        .table-scroll {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <div id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- ══════════ SIDEBAR ══════════ -->
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

    <!-- ══════════ MAIN ══════════ -->
    <div id="mainWrap">

        <!-- Header -->
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

        <!-- ══ KONTEN UTAMA ══ -->
        <main class="flex-1 p-5 lg:p-7 space-y-5 overflow-y-auto">

            <!-- ── Insight Strip ── -->
            <div class="insight-strip">
                <div class="insight-card orange">
                    <div class="insight-label">Total Income Tahun Ini</div>
                    <div class="insight-value" id="insightIncome">—</div>
                    <div class="insight-sub up" id="insightIncomeSub"></div>
                </div>
                <div class="insight-card green">
                    <div class="insight-label">Item Terjual</div>
                    <div class="insight-value" id="insightItem">—</div>
                    <div class="insight-sub up" id="insightItemSub"></div>
                </div>
                <div class="insight-card blue">
                    <div class="insight-label">Total Order</div>
                    <div class="insight-value" id="insightOrder">—</div>
                    <div class="insight-sub up" id="insightOrderSub"></div>
                </div>
                <div class="insight-card purple">
                    <div class="insight-label">Rata-rata / Bulan</div>
                    <div class="insight-value" id="insightAvg">—</div>
                    <div class="insight-sub neutral">dari bulan aktif</div>
                </div>
            </div>

            <!-- ── Row: Tabel Rekap + Payment Method ── -->
            <div style="display:grid; grid-template-columns: 1fr 300px; gap:14px;" class="rekap-grid">

                <!-- Tabel Rekap Bulanan -->
                <div class="section-card">
                    <div class="section-header">
                        <span class="section-title">
                            <i class="fa-solid fa-book-open text-[#FF5500] mr-2"></i>Rekap Bulanan
                        </span>
                        <select class="year-select" id="yearSelect" onchange="renderRekap()">
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                        </select>
                    </div>
                    <div class="table-scroll">
                        <table class="rekap-table">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th>Income</th>
                                    <th>Order</th>
                                    <th>Item Terjual</th>
                                    <th>YoY Income</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="rekapBody"></tbody>
                        </table>
                    </div>
                    <!-- Footer total -->
                    <div
                        style="padding: 12px 20px; background: #fdf8f0; border-top: 1px solid #f0e9d8; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                        <span style="font-size:11px; color:#aaa; font-weight:600;">TOTAL TAHUN INI</span>
                        <div style="display:flex; gap:24px;">
                            <span style="font-size:12px; font-weight:700; color:#FF5500;" id="footerIncome">—</span>
                            <span style="font-size:12px; font-weight:700; color:#1a1a1a;" id="footerOrder">—
                                order</span>
                            <span style="font-size:12px; font-weight:700; color:#1a1a1a;" id="footerItem">— item</span>
                        </div>
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="section-card" style="display:flex; flex-direction:column;">
                    <div class="section-header">
                        <span class="section-title">
                            <i class="fa-solid fa-credit-card text-[#FF5500] mr-2"></i>Metode Pembayaran
                        </span>
                    </div>
                    <div class="pay-list" style="flex:1;">
                        <div class="pay-item">
                            <div class="pay-icon qris"><i class="fa-solid fa-qrcode"></i></div>
                            <div class="pay-bar-wrap">
                                <div class="pay-name">QRIS</div>
                                <div class="pay-bar-bg">
                                    <div class="pay-bar qris" style="width:52%"></div>
                                </div>
                            </div>
                            <div class="pay-pct">52%</div>
                        </div>
                        <div class="pay-item">
                            <div class="pay-icon tf"><i class="fa-solid fa-building-columns"></i></div>
                            <div class="pay-bar-wrap">
                                <div class="pay-name">Transfer Bank</div>
                                <div class="pay-bar-bg">
                                    <div class="pay-bar tf" style="width:28%"></div>
                                </div>
                            </div>
                            <div class="pay-pct">28%</div>
                        </div>
                        <div class="pay-item">
                            <div class="pay-icon cod"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                            <div class="pay-bar-wrap">
                                <div class="pay-name">COD</div>
                                <div class="pay-bar-bg">
                                    <div class="pay-bar cod" style="width:13%"></div>
                                </div>
                            </div>
                            <div class="pay-pct">13%</div>
                        </div>
                    </div>
                </div>

            </div><!-- /rekap-grid -->

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