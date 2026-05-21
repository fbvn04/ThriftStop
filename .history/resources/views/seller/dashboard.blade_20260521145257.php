<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThriftStop Seller</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.07);
            display: flex;
            flex-direction: column;
            z-index: 40;
            transition: width 0.3s ease, transform 0.3s ease;
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
            transition: margin-left 0.3s ease;
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
            transition: all 0.18s ease;
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

        .welcome-card {
            background: linear-gradient(135deg, #FF5500 0%, #FF8040 55%, #FFAA55 100%);
            border-radius: 20px;
            position: relative;
            overflow: visible;
            min-height: 145px;
            display: flex;
            align-items: center;
        }

        .stat-green {
            background: linear-gradient(135deg, #10b981, #34d399);
        }

        .stat-orange {
            background: linear-gradient(135deg, #FF5500, #FF8C42);
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
            background: rgba(0, 0, 0, 0.45);
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

        .chart-wrap {
            position: relative;
            height: 235px;
            width: 100%;
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
                class="hide-on-collapse bg-[#1a1a1a] text-white text-[11px] font-semibold px-3 py-1 rounded-md tracking-wide">
                Seller
            </span>
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

        <!-- Logout -->
        <div class="p-4 border-t border-[#f0e9d8] flex-shrink-0">
            <button type="button" onclick="confirmLogout()"
                class="logout-btn w-full flex items-center gap-2.5 justify-center py-2.5 px-4 rounded-lg border border-red-200 text-red-400 hover:bg-red-50 hover:text-red-500 text-[13px] font-medium transition-all duration-200">
                <i class="fa-solid fa-right-from-bracket text-[13px] flex-shrink-0"></i>
                <span class="hide-on-collapse">Log Out</span>
            </button>
            <!-- Form tersembunyi, hanya di-submit setelah konfirmasi -->
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </aside>
    <div id="mainWrap">

        <!-- TOPBAR -->
        <header class="sticky top-0 z-20 bg-white/85 backdrop-blur-md shadow-sm px-5 lg:px-8 py-3
                   flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <button onclick="openSidebar()" class="lg:hidden text-[#555] hover:text-[#FF5500] transition-colors">
                    <i class="fa-solid fa-bars text-[18px]"></i>
                </button>
                <div>
                    <h1 class="text-[15px] font-bold text-[#1a1a1a] leading-tight">Dashboard Seller</h1>
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
                    @if(($pesananBaru ?? 0) > 0)
                        <span class="notif-badge">{{ $pesananBaru }}</span>
                    @endif
                </button>

                <!-- Notif dropdown -->
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

        <!-- PAGE BODY -->
        <main class="flex-1 p-5 lg:p-7 space-y-5 overflow-y-auto">

            @if(session('success'))
                <div
                    class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-[13px] flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-green-500"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- WELCOME CARD -->
            <div class="welcome-card">
                <div class="relative z-10 px-7 py-6 max-w-[58%]">
                    <h2 class="text-white text-[22px] lg:text-[26px] font-bold leading-tight">
                        Hi, {{ $toko->nama_toko ?? 'Toko Kamu' }}
                    </h2>
                    <p class="text-white/80 text-[12px] mt-2 leading-relaxed">
                        Welcome back seller ThriftStop!<br>
                        Ayo lihat perkembangan tokomu agar tetap berkembang.
                    </p>
                </div>

                <!-- SVG pojok kanan -->
                <div class="absolute right-0 bottom-0 h-full flex items-end pointer-events-none select-none"
                    style="height: 130%; overflow: visible; bottom: 0;">
                    <img src="{{ asset('images/mask-group.svg') }}" alt="illustration"
                        style="height: 190px; width: auto; object-fit: contain; object-position: bottom; margin-bottom: -10px;">
                </div>

                <!-- Bubbles dekoratif -->
                <div class="absolute -top-10 -left-10 w-36 h-36 bg-white/10 rounded-full pointer-events-none"></div>
                <div class="absolute top-5 left-28 w-16 h-16 bg-white/10 rounded-full pointer-events-none"></div>
            </div>

            <!-- STAT CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="stat-green rounded-2xl p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-credit-card text-white text-[20px]"></i>
                    </div>
                    <div>
                        <p class="text-white/80 text-[12px] font-medium">Pemasukan Bulan Ini</p>
                        <p class="text-white text-[20px] font-bold leading-tight">
                            Rp {{ number_format($pemasukanBulanIni ?? 0, 0, ',', '.') }}
                        </p>
                        @if(($growthPemasukan ?? null) !== null)
                            <p class="text-white/70 text-[11px] mt-0.5">
                                <i class="fa-solid fa-arrow-{{ $growthPemasukan >= 0 ? 'up' : 'down' }} text-[10px]"></i>
                                {{ abs($growthPemasukan) }}% dari bulan lalu
                            </p>
                        @endif
                    </div>
                </div>

                <div class="stat-orange rounded-2xl p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-cart-shopping text-white text-[20px]"></i>
                    </div>
                    <div>
                        <p class="text-white/80 text-[12px] font-medium">Produk Terjual Bulan Ini</p>
                        <p class="text-white text-[20px] font-bold leading-tight">
                            {{ $produkTerjual ?? 0 }} Produk
                        </p>
                        @if(($growthProduk ?? null) !== null)
                            <p class="text-white/70 text-[11px] mt-0.5">
                                <i class="fa-solid fa-arrow-{{ $growthProduk >= 0 ? 'up' : 'down' }} text-[10px]"></i>
                                {{ abs($growthProduk) }}% dari bulan lalu
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- GRAFIK FULL WIDTH -->
            <div class="bg-white rounded-2xl p-5 shadow-sm w-full">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-[14px] font-semibold text-[#1a1a1a]">Grafik Penjualan</h3>
                        <p class="text-[11px] text-[#aaa]">Jumlah produk terjual</p>
                    </div>
                    <select id="chartFilter" onchange="updateChart(this.value)"
                        class="text-[11px] border border-[#e5e7eb] rounded-lg px-2.5 py-1.5 text-[#555] bg-white outline-none cursor-pointer">
                        <option value="tahunan">Tahunan</option>
                        <option value="bulanan">Bulanan</option>
                    </select>
                </div>
                <div class="chart-wrap">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

        </main>

        <footer class="text-center py-3 text-[11px] text-[#bbb] flex-shrink-0">
            &copy; {{ date('Y') }} ThriftStop &middot; Platform Thrifting UMKM Indonesia
        </footer>
    </div>
    <!-- LOGOUT CONFIRMATION MODAL -->
    <div id="logoutModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="cancelLogout()"></div>
        <!-- Card -->
        <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-[300px] mx-4 text-center animate-[fadeUp_0.2s_ease]">
            <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-right-from-bracket text-red-400 text-[22px]"></i>
            </div>
            <h3 class="text-[16px] font-bold text-[#1a1a1a]">Keluar dari Akun?</h3>
            <p class="text-[12px] text-[#888] mt-1.5 mb-5 leading-relaxed">
                Kamu akan keluar dari akun seller ThriftStop. Yakin ingin melanjutkan?
            </p>
            <div class="flex gap-3">
                <button onclick="cancelLogout()"
                    class="flex-1 py-2.5 rounded-xl border border-[#e5e7eb] text-[13px] font-medium text-[#555] hover:bg-[#f5f5f5] transition-colors">
                    Batal
                </button>
                <button onclick="doLogout()"
                    class="flex-1 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-[13px] font-semibold text-white transition-colors">
                    Ya, Keluar
                </button>
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

        const chartDataTahunan = {
            labels: {!! json_encode(($chartTahunan ?? ['labels' => ['2020', '2021', '2022', '2023', '2024', '2025', '2026', '2027']])['labels']) !!},
            data: {!! json_encode(($chartTahunan ?? ['data' => [32, 29, 17, 14, 11, 9, 6, 2]])['data']) !!}
        };
        const chartDataBulanan = {
            labels: {!! json_encode(($chartBulanan ?? ['labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']])['labels']) !!},
            data: {!! json_encode(($chartBulanan ?? ['data' => [5, 8, 6, 12, 9, 14, 11, 7, 10, 13, 8, 15]])['data']) !!}
        };

        let chartInstance = null;
        function buildChart(labels, data) {
            const ctx = document.getElementById('salesChart').getContext('2d');
            if (chartInstance) chartInstance.destroy();
            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Produk Terjual',
                        data,
                        backgroundColor: data.map(v => v === Math.max(...data) ? '#FF5500' : '#20C997'),
                        borderRadius: 7,
                        borderSkipped: false,
                        maxBarThickness: 42,
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1a1a1a', titleColor: '#fff', bodyColor: '#aaa',
                            padding: 10, cornerRadius: 8,
                            callbacks: { label: c => '  ' + c.parsed.y + ' produk terjual' }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { family: 'Poppins', size: 11 }, color: '#bbb' } },
                        y: { grid: { color: '#f0ead8' }, ticks: { font: { family: 'Poppins', size: 11 }, color: '#bbb', stepSize: 5 }, beginAtZero: true }
                    }
                }
            });
        }
        function updateChart(mode) {
            mode === 'bulanan' ? buildChart(chartDataBulanan.labels, chartDataBulanan.data)
                : buildChart(chartDataTahunan.labels, chartDataTahunan.data);
        }
        buildChart(chartDataTahunan.labels, chartDataTahunan.data);

        function confirmLogout() {
            document.getElementById('logoutModal').classList.remove('hidden');
        }
        function cancelLogout() {
            document.getElementById('logoutModal').classList.add('hidden');
        }
        function doLogout() {
            document.getElementById('logoutForm').submit();
        }
    </script>
</body>

</html>