<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ $toko->nama_toko ?? 'ThriftStop Seller' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        #sidebar {
            transition: transform 0.3s ease, width 0.3s ease;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            color: #444;
            transition: all 0.18s ease;
            text-decoration: none;
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
        }

        .welcome-card {
            background: linear-gradient(135deg, #FF5500 0%, #FF8C42 60%, #FFB347 100%);
            position: relative;
            overflow: hidden;
        }

        .stat-card-green {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }

        .stat-card-orange {
            background: linear-gradient(135deg, #FF5500 0%, #FF8C42 100%);
        }

        #sidebarOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 30;
        }

        #sidebarOverlay.show {
            display: block;
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

        @media (min-width: 1024px) {
            .sidebar-collapsed {
                width: 70px !important;
            }

            .sidebar-collapsed .nav-label,
            .sidebar-collapsed .sidebar-brand-text,
            .sidebar-collapsed .sidebar-profile-text,
            .sidebar-collapsed .sidebar-badge,
            .sidebar-collapsed .sidebar-divider-text {
                display: none !important;
            }

            .sidebar-collapsed .nav-link {
                justify-content: center;
                padding: 10px;
            }

            .sidebar-collapsed .nav-icon {
                margin: 0;
            }

            .sidebar-collapsed #sidebarToggleIcon {
                transform: rotate(180deg);
            }
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #f1e0b4;
        }

        ::-webkit-scrollbar-thumb {
            background: #cfc3a5;
            border-radius: 10px;
        }

        .chart-container {
            position: relative;
            height: 220px;
        }

        @keyframes shimmer {
            0% {
                background-position: -400px 0;
            }

            100% {
                background-position: 400px 0;
            }
        }

        .shimmer {
            background: linear-gradient(90deg, #f0e9d8 25%, #f8f4ec 50%, #f0e9d8 75%);
            background-size: 800px 100%;
            animation: shimmer 1.5s infinite;
        }
    </style>
</head>

<body class="bg-[#F1E0B4] min-h-screen flex overflow-x-hidden">
    }
    <div id="sidebarOverlay" onclick="closeSidebar()"></div>
    <aside id="sidebar" class="fixed top-0 left-0 h-full z-40 bg-white shadow-xl flex flex-col
           w-[220px]
           -translate-x-full lg:translate-x-0 lg:relative lg:flex-shrink-0">
        <div class="flex items-center justify-between px-5 pt-6 pb-4">
            <div class="flex items-center gap-2 sidebar-brand-text">
                <span class="text-[24px] font-extrabold leading-none">
                    <span class="text-[#FF5500]">Thrift</span><span class="text-black">Stop</span>
                </span>
            </div>
            {{-- Collapsed shows only icon --}}
            <div class="hidden sidebar-brand-text lg:block"></div>
            <button id="sidebarToggleBtn" onclick="toggleSidebarDesktop()"
                class="hidden lg:flex items-center justify-center w-7 h-7 rounded-full bg-[#FFF3EC] hover:bg-orange-100 transition-colors">
                <i id="sidebarToggleIcon"
                    class="fa-solid fa-chevron-left text-[#FF5500] text-[11px] transition-transform duration-300"></i>
            </button>
            {{-- Mobile close --}}
            <button onclick="closeSidebar()" class="lg:hidden text-[#aaa] hover:text-red-400 transition-colors">
                <i class="fa-solid fa-xmark text-[16px]"></i>
            </button>
        </div>

        {{-- Seller badge --}}
        <div class="px-5 mb-4 sidebar-brand-text">
            <span
                class="bg-[#1a1a1a] text-white text-[11px] font-semibold px-3 py-1 rounded-md tracking-wide sidebar-badge">
                Seller
            </span>
        </div>

        {{-- Profile --}}
        <div class="mx-3 mb-5 rounded-xl bg-[#F1E0B4]/60 p-3 flex items-center gap-3">
            @if(!empty($toko->foto_toko))
                <img src="{{ Storage::url($toko->foto_toko) }}"
                    class="w-9 h-9 rounded-full object-cover ring-2 ring-[#FF5500]/30" alt="Foto Toko">
            @else
                <div
                    class="w-9 h-9 rounded-full bg-[#FF5500]/20 flex items-center justify-center ring-2 ring-[#FF5500]/30 shrink-0">
                    <i class="fa-solid fa-store text-[#FF5500] text-[14px]"></i>
                </div>
            @endif
            <div class="sidebar-profile-text overflow-hidden">
                <p class="text-[12px] font-semibold text-[#1a1a1a] truncate">{{ $toko->nama_toko ?? 'Nama Toko' }}</p>
                <p class="text-[10px] text-[#888] truncate">ID: {{ str_pad($toko->id ?? 0, 7, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 space-y-1 overflow-y-auto">
            <a href="{{ route('seller.dashboard') }}"
                class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-house"></i></span>
                <span class="nav-label">Dashboard</span>
            </a>
            <a href="{{ route('seller.produk') }}"
                class="nav-link {{ request()->routeIs('seller.produk*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-boxes-stacked"></i></span>
                <span class="nav-label">Kelola Produk</span>
            </a>
            <a href="{{ route('seller.laporan') }}"
                class="nav-link {{ request()->routeIs('seller.laporan*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-chart-column"></i></span>
                <span class="nav-label">Laporan Penjualan</span>
            </a>
            <a href="{{ route('seller.toko') }}"
                class="nav-link {{ request()->routeIs('seller.toko*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-store"></i></span>
                <span class="nav-label">Kelola Toko Saya</span>
            </a>
            <a href="{{ route('seller.orderan') }}"
                class="nav-link {{ request()->routeIs('seller.orderan*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-bag-shopping"></i></span>
                <span class="nav-label">Orderan Saya</span>
            </a>
        </nav>

        {{-- Logout --}}
        <div class="p-4 border-t border-[#f0e9d8]">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 justify-center py-2.5 px-4 rounded-lg
                       border border-red-200 text-red-400 hover:bg-red-50 hover:text-red-500
                       text-[13px] font-medium transition-all duration-200">
                    <i class="fa-solid fa-right-from-bracket text-[13px]"></i>
                    <span class="nav-label">Log Out</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══════════════ MAIN CONTENT ═══════════════ --}}
    <div class="flex-1 flex flex-col min-h-screen min-w-0">

        {{-- ── TOP NAVBAR ── --}}
        <header
            class="sticky top-0 z-20 bg-white/80 backdrop-blur-md shadow-sm px-5 lg:px-8 py-3 flex items-center justify-between">

            {{-- Hamburger (mobile) + Page title --}}
            <div class="flex items-center gap-3">
                <button onclick="openSidebar()" class="lg:hidden text-[#555] hover:text-[#FF5500] transition-colors">
                    <i class="fa-solid fa-bars text-[18px]"></i>
                </button>
                <div>
                    <h1 class="text-[15px] font-bold text-[#1a1a1a] leading-tight">Dashboard Seller</h1>
                    <p class="text-[11px] text-[#aaa]" id="tanggalHariIni"></p>
                </div>
            </div>

            {{-- Right actions --}}
            <div class="flex items-center gap-3">
                {{-- Notifikasi --}}
                <button
                    class="relative w-9 h-9 rounded-full bg-[#f5f5f5] hover:bg-[#FFF3EC] flex items-center justify-center transition-colors"
                    id="notifBtn" onclick="toggleNotif()">
                    <i class="fa-regular fa-bell text-[#555] text-[15px]"></i>
                    @if(($notifCount ?? 0) > 0)
                        <span class="notif-badge">{{ $notifCount }}</span>
                    @endif
                </button>

                {{-- Keranjang / pesanan --}}
                <button
                    class="relative w-9 h-9 rounded-full bg-[#f5f5f5] hover:bg-[#FFF3EC] flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-cart-shopping text-[#555] text-[15px]"></i>
                    @if(($pesananBaru ?? 0) > 0)
                        <span class="notif-badge">{{ $pesananBaru }}</span>
                    @endif
                </button>
            </div>

            {{-- Notif dropdown --}}
            <div id="notifDropdown"
                class="hidden absolute top-14 right-5 lg:right-8 w-72 bg-white rounded-2xl shadow-xl border border-[#f0e9d8] overflow-hidden z-50">
                <div class="px-4 py-3 border-b border-[#f0e9d8] flex items-center justify-between">
                    <span class="text-[13px] font-semibold text-[#1a1a1a]">Notifikasi</span>
                    <span class="text-[10px] text-[#FF5500] font-medium cursor-pointer hover:underline">Tandai semua
                        dibaca</span>
                </div>
                @forelse($notifikasi ?? [] as $notif)
                    <div class="px-4 py-3 hover:bg-[#FFF3EC] transition-colors border-b border-[#f9f4ed] cursor-pointer">
                        <p class="text-[12px] font-medium text-[#1a1a1a]">{{ $notif->judul }}</p>
                        <p class="text-[11px] text-[#888] mt-0.5">{{ $notif->pesan }}</p>
                        <p class="text-[10px] text-[#bbb] mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <div class="px-4 py-6 text-center">
                        <i class="fa-regular fa-bell-slash text-[#ccc] text-[24px]"></i>
                        <p class="text-[12px] text-[#aaa] mt-2">Tidak ada notifikasi</p>
                    </div>
                @endforelse
            </div>
        </header>

        {{-- ── PAGE BODY ── --}}
        <main class="flex-1 p-5 lg:p-8 space-y-6">

            {{-- Flash success --}}
            @if(session('success'))
                <div
                    class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-[13px] flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-green-500"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- ── WELCOME CARD ── --}}
            <div class="welcome-card rounded-2xl p-6 flex items-center justify-between overflow-hidden min-h-[130px]">
                <div class="relative z-10 max-w-[60%]">
                    <h2 class="text-white text-[20px] lg:text-[24px] font-bold leading-tight">
                        Hi, {{ $toko->nama_toko ?? 'Toko Kamu' }}
                    </h2>
                    <p class="text-white/80 text-[12px] mt-1 leading-relaxed">
                        Welcome back seller ThriftStop!<br>
                        Ayo lihat perkembangan tokomu agar tetap berkembang.
                    </p>
                </div>

                {{-- Illustration --}}
                <div class="absolute right-0 bottom-0 h-full flex items-end pointer-events-none select-none">
                    <img src="{{ asset('images/Mask_group.svg') }}" alt="illustration"
                        class="h-[130px] lg:h-[160px] object-contain object-bottom opacity-95">
                </div>

                {{-- Decorative circles --}}
                <div class="absolute -top-8 -left-8 w-32 h-32 bg-white/10 rounded-full pointer-events-none"></div>
                <div class="absolute top-4 left-24 w-16 h-16 bg-white/10 rounded-full pointer-events-none"></div>
            </div>

            {{-- ── STAT CARDS ── --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- Pemasukan --}}
                <div class="stat-card-green rounded-2xl p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
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

                {{-- Produk terjual --}}
                <div class="stat-card-orange rounded-2xl p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <div class="lg:col-span-2 bg-white rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-[14px] font-semibold text-[#1a1a1a]">Grafik Penjualan</h3>
                            <p class="text-[11px] text-[#aaa]">Jumlah produk terjual per tahun</p>
                        </div>
                        <select id="chartFilter" onchange="updateChart(this.value)"
                            class="text-[11px] border border-[#e5e7eb] rounded-lg px-2.5 py-1.5 text-[#555] bg-white focus:ring-0 outline-none cursor-pointer">
                            <option value="tahunan">Tahunan</option>
                            <option value="bulanan">Bulanan</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>

        </main>

        <footer class="text-center py-4 text-[11px] text-[#bbb]">
            © {{ date('Y') }} ThriftStop · Platform Thrifting UMKM Indonesia
        </footer>
    </div>

    <script>
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const now = new Date();
        document.getElementById('tanggalHariIni').textContent =
            days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();

        function openSidebar() {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.remove('show');
            document.body.style.overflow = '';
        }

        function toggleSidebarDesktop() {
            document.getElementById('sidebar').classList.toggle('sidebar-collapsed');
        }

        function toggleNotif() {
            const el = document.getElementById('notifDropdown');
            el.classList.toggle('hidden');
        }
        document.addEventListener('click', function (e) {
            const btn = document.getElementById('notifBtn');
            const dd = document.getElementById('notifDropdown');
            if (!btn.contains(e.target) && !dd.contains(e.target)) dd.classList.add('hidden');
        });

        // ── Chart data from Laravel ─────────────────────────────────────────────────
        const chartDataTahunan = {
            labels: {!! json_encode(($chartTahunan ?? ['labels' => ['2020', '2021', '2022', '2023', '2024', '2025', '2026', '2027']])['labels']) !!},
            data: {!! json_encode(($chartTahunan ?? ['data' => [32, 29, 17, 14, 11, 9, 6, 2]])['data']) !!}
        };
        const chartDataBulanan = {
            labels: {!! json_encode(($chartBulanan ?? ['labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']])['labels']) !!},
            data: {!! json_encode(($chartBulanan ?? ['data' => [5, 8, 6, 12, 9, 14, 11, 7, 10, 13, 8, 15]])['data']) !!}
        };

        let salesChartInstance = null;

        function buildChart(labels, data) {
            const ctx = document.getElementById('salesChart').getContext('2d');
            if (salesChartInstance) salesChartInstance.destroy();

            const gradient = ctx.createLinearGradient(0, 0, 0, 220);
            gradient.addColorStop(0, 'rgba(255,85,0,0.18)');
            gradient.addColorStop(1, 'rgba(255,85,0,0.01)');

            salesChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Produk Terjual',
                        data,
                        backgroundColor: data.map((_, i) =>
                            i === data.indexOf(Math.max(...data)) ? '#FF5500' : '#20C997'
                        ),
                        borderRadius: 6,
                        borderSkipped: false,
                        maxBarThickness: 38,
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1a1a1a',
                            titleColor: '#fff',
                            bodyColor: '#aaa',
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: {
                                label: ctx => ' ' + ctx.parsed.y + ' produk terjual'
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Poppins', size: 11 }, color: '#aaa' }
                        },
                        y: {
                            grid: { color: '#f0e9d8', drawBorder: false },
                            ticks: { font: { family: 'Poppins', size: 11 }, color: '#aaa', stepSize: 5 },
                            beginAtZero: true,
                        }
                    }
                }
            });
        }

        function updateChart(mode) {
            if (mode === 'bulanan') buildChart(chartDataBulanan.labels, chartDataBulanan.data);
            else buildChart(chartDataTahunan.labels, chartDataTahunan.data);
        }

        // Init
        buildChart(chartDataTahunan.labels, chartDataTahunan.data);
    </script>

</body>

</html>