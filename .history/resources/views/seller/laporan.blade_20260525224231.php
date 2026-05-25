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

        /* ── Stat Cards ── */
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 18px 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            display: flex;
            align-items: center;
            gap: 14px;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, .09);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .stat-icon.orange {
            background: #FFF3EC;
            color: #FF5500;
        }

        .stat-icon.green {
            background: #f0fdf4;
            color: #22c55e;
        }

        .stat-icon.blue {
            background: #eff6ff;
            color: #3b82f6;
        }

        .stat-info {
            flex: 1;
            min-width: 0;
        }

        .stat-label {
            font-size: 10.5px;
            color: #aaa;
            font-weight: 500;
            margin-bottom: 3px;
        }

        .stat-value {
            font-size: 17px;
            font-weight: 700;
            color: #1a1a1a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .stat-sub {
            font-size: 10px;
            color: #22c55e;
            font-weight: 500;
            margin-top: 2px;
        }

        /* ── Section Card ── */
        .section-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .section-header {
            padding: 16px 20px;
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

        /* ── Period Tabs ── */
        .period-tabs {
            display: flex;
            gap: 4px;
            background: #f5f0e8;
            padding: 3px;
            border-radius: 10px;
        }

        .period-tab {
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            color: #888;
            cursor: pointer;
            border: none;
            background: transparent;
            font-family: 'Poppins', sans-serif;
            transition: all .15s;
        }

        .period-tab.active {
            background: #fff;
            color: #FF5500;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .08);
        }

        /* ── Chart ── */
        .chart-wrap {
            padding: 20px;
            position: relative;
        }

        /* ── Top Produk ── */
        .top-produk-list {
            padding: 8px 0;
        }

        .top-produk-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            transition: background .15s;
        }

        .top-produk-item:hover {
            background: #fdf9f4;
        }

        .top-rank {
            width: 24px;
            height: 24px;
            border-radius: 8px;
            background: #f5f0e8;
            color: #aaa;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .top-rank.gold {
            background: #fef9c3;
            color: #ca8a04;
        }

        .top-rank.silver {
            background: #f1f5f9;
            color: #64748b;
        }

        .top-rank.bronze {
            background: #fff7ed;
            color: #c2410c;
        }

        .top-produk-bar-wrap {
            flex: 1;
        }

        .top-produk-name {
            font-size: 12px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 4px;
        }

        .top-produk-bar-bg {
            height: 5px;
            background: #f0ead8;
            border-radius: 10px;
            overflow: hidden;
        }

        .top-produk-bar {
            height: 100%;
            background: #FF5500;
            border-radius: 10px;
            transition: width .6s ease;
        }

        .top-produk-sold {
            font-size: 11px;
            font-weight: 600;
            color: #FF5500;
            white-space: nowrap;
            flex-shrink: 0;
        }

        /* ── Two Col ── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        @media (max-width: 860px) {
            .two-col {
                grid-template-columns: 1fr;
            }
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

    <!-- ── Sidebar ── -->
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

    <!-- ── Main ── -->
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

            <!-- Stat Cards + Chart sejajar -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                <!-- Stat Cards (kiri) -->
                <div class="flex flex-col gap-4">
                    <div class="stat-card">
                        <div class="stat-icon orange"><i class="fa-solid fa-sack-dollar"></i></div>
                        <div class="stat-info">
                            <div class="stat-label">Total Pendapatan</div>
                            <div class="stat-value" id="statPendapatan">—</div>
                            <div class="stat-sub" id="statPendapatanSub"></div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green"><i class="fa-solid fa-bag-shopping"></i></div>
                        <div class="stat-info">
                            <div class="stat-label">Total Orderan</div>
                            <div class="stat-value" id="statOrderan">—</div>
                            <div class="stat-sub" id="statOrderanSub"></div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon blue"><i class="fa-solid fa-box"></i></div>
                        <div class="stat-info">
                            <div class="stat-label">Produk Terjual</div>
                            <div class="stat-value" id="statTerjual">—</div>
                            <div class="stat-sub" id="statTerjualSub"></div>
                        </div>
                    </div>
                </div>

                <!-- Chart Pendapatan (kanan, 2/3 lebar) -->
                <div class="lg:col-span-2 section-card">
                    <div class="section-header">
                        <span class="section-title">
                            <i class="fa-solid fa-chart-line text-[#FF5500] mr-2"></i>Grafik Pendapatan
                        </span>
                        <div class="period-tabs">
                            <button class="period-tab active" onclick="setPeriod('7d', this)">7 Hari</button>
                            <button class="period-tab" onclick="setPeriod('30d', this)">30 Hari</button>
                            <button class="period-tab" onclick="setPeriod('12m', this)">12 Bulan</button>
                        </div>
                    </div>
                    <div class="chart-wrap" style="height:260px;">
                        <canvas id="chartPendapatan"></canvas>
                    </div>
                </div>

            </div>

            <!-- Two col: Top Produk + Kategori -->
            <div class="two-col">
                <div class="section-card">
                    <div class="section-header">
                        <span class="section-title">
                            <i class="fa-solid fa-trophy text-[#FF5500] mr-2"></i>Produk Terlaris
                        </span>
                    </div>
                    <div class="top-produk-list" id="topProdukList"></div>
                </div>

                <div class="section-card">
                    <div class="section-header">
                        <span class="section-title">
                            <i class="fa-solid fa-chart-pie text-[#FF5500] mr-2"></i>Per Kategori
                        </span>
                    </div>
                    <div class="chart-wrap" style="height:220px;">
                        <canvas id="chartKategori"></canvas>
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

    <script>
        // ── Tanggal ──
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const now = new Date();
        document.getElementById('tanggalHariIni').textContent =
            days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();

        // ── Sidebar ──
        function openSidebar() { document.getElementById('sidebar').classList.add('open'); document.getElementById('sidebarOverlay').classList.add('show'); document.body.style.overflow = 'hidden'; }
        function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sidebarOverlay').classList.remove('show'); document.body.style.overflow = ''; }
        function toggleCollapse() { document.getElementById('sidebar').classList.toggle('collapsed'); document.getElementById('mainWrap').classList.toggle('collapsed'); }
        function confirmLogout() { document.getElementById('logoutModal').classList.remove('hidden'); }
        function cancelLogout() { document.getElementById('logoutModal').classList.add('hidden'); }
        function doLogout() { document.getElementById('logoutForm').submit(); }

        // ── Data Semu ──
        const DATA = {
            '7d': {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                values: [320000, 580000, 410000, 760000, 540000, 890000, 670000],
                orderan: 28, terjual: 34,
            },
            '30d': {
                labels: ['1', '5', '10', '15', '20', '25', '30'].map(d => d + ' Mei'),
                values: [1200000, 980000, 1540000, 2100000, 1750000, 2300000, 1900000],
                orderan: 112, terjual: 138,
            },
            '12m': {
                labels: ['Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
                values: [3200000, 4100000, 3800000, 5200000, 4700000, 6100000, 7300000, 5800000, 6400000, 7100000, 6800000, 8200000],
                orderan: 487, terjual: 612,
            },
        };

        const TOP_PRODUK = [
            { nama: 'Nike 1990 Windbreaker', terjual: 24, max: 24 },
            { nama: "Levi's 501 Original", terjual: 18, max: 24 },
            { nama: 'ZAFUL Alaska Sweatshirt', terjual: 15, max: 24 },
            { nama: 'Stone Island TC Jacket', terjual: 11, max: 24 },
            { nama: 'Flannel Shirt Vintage', terjual: 8, max: 24 },
        ];

        const KATEGORI = {
            labels: ['Jacket', 'Celana', 'Sweater', 'Kemeja', 'Sepatu', 'Aksesoris'],
            values: [35, 22, 18, 12, 8, 5],
            colors: ['#FF5500', '#f59e0b', '#3b82f6', '#22c55e', '#a855f7', '#ec4899'],
        };

        // ── Format Rupiah ──
        function rupiah(n) {
            return 'Rp ' + n.toLocaleString('id-ID');
        }

        // ── Update Stats ──
        function updateStats(period) {
            const d = DATA[period];
            const total = d.values.reduce((a, b) => a + b, 0);
            document.getElementById('statPendapatan').textContent = rupiah(total);
            document.getElementById('statPendapatanSub').textContent = '↑ 12% vs periode lalu';
            document.getElementById('statOrderan').textContent = d.orderan + ' Order';
            document.getElementById('statOrderanSub').textContent = '↑ 8% vs periode lalu';
            document.getElementById('statTerjual').textContent = d.terjual + ' Item';
            document.getElementById('statTerjualSub').textContent = '↑ 15% vs periode lalu';
        }

        // ── Chart Pendapatan ──
        let chartPendapatan = null;
        function renderChartPendapatan(period) {
            const d = DATA[period];
            const ctx = document.getElementById('chartPendapatan').getContext('2d');

            if (chartPendapatan) chartPendapatan.destroy();

            const gradient = ctx.createLinearGradient(0, 0, 0, 220);
            gradient.addColorStop(0, 'rgba(255,85,0,0.18)');
            gradient.addColorStop(1, 'rgba(255,85,0,0)');

            chartPendapatan = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: d.labels,
                    datasets: [{
                        label: 'Pendapatan',
                        data: d.values,
                        borderColor: '#FF5500',
                        backgroundColor: gradient,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#FF5500',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: { label: c => rupiah(c.parsed.y) },
                            backgroundColor: '#1a1a1a',
                            titleFont: { family: 'Poppins', size: 11 },
                            bodyFont: { family: 'Poppins', size: 12, weight: '600' },
                            padding: 10, cornerRadius: 8,
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Poppins', size: 10 }, color: '#aaa' },
                        },
                        y: {
                            grid: { color: '#f5f0e8' },
                            ticks: {
                                font: { family: 'Poppins', size: 10 }, color: '#aaa',
                                callback: v => 'Rp ' + (v >= 1000000 ? (v / 1000000).toFixed(1) + 'jt' : (v / 1000) + 'rb'),
                            },
                        }
                    }
                }
            });
        }

        // ── Chart Kategori ──
        function renderChartKategori() {
            const ctx = document.getElementById('chartKategori').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: KATEGORI.labels,
                    datasets: [{
                        data: KATEGORI.values,
                        backgroundColor: KATEGORI.colors,
                        borderWidth: 2, borderColor: '#fff', hoverOffset: 6,
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: { family: 'Poppins', size: 10 },
                                color: '#555', padding: 10, boxWidth: 10, boxHeight: 10,
                            }
                        },
                        tooltip: {
                            callbacks: { label: c => ` ${c.label}: ${c.parsed}%` },
                            backgroundColor: '#1a1a1a',
                            titleFont: { family: 'Poppins', size: 11 },
                            bodyFont: { family: 'Poppins', size: 11 },
                            padding: 8, cornerRadius: 8,
                        }
                    }
                }
            });
        }

        // ── Top Produk ──
        function renderTopProduk() {
            const rankClass = ['gold', 'silver', 'bronze', '', ''];
            document.getElementById('topProdukList').innerHTML = TOP_PRODUK.map((p, i) => `
                <div class="top-produk-item">
                    <div class="top-rank ${rankClass[i]}">${i + 1}</div>
                    <div class="top-produk-bar-wrap">
                        <div class="top-produk-name">${p.nama}</div>
                        <div class="top-produk-bar-bg">
                            <div class="top-produk-bar" style="width:${Math.round(p.terjual / p.max * 100)}%"></div>
                        </div>
                    </div>
                    <div class="top-produk-sold">${p.terjual} terjual</div>
                </div>
            `).join('');
        }

        // ── Period Switch ──
        function setPeriod(period, el) {
            document.querySelectorAll('.period-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            renderChartPendapatan(period);
            updateStats(period);
        }

        // ── Init ──
        updateStats('7d');
        renderChartPendapatan('7d');
        renderChartKategori();
        renderTopProduk();
    </script>
</body>

</html>