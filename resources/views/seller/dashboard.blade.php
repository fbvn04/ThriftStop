<x-layout-seller titlePage="Dashboard">
    @if(session('success'))
            <div
                class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-[13px] flex items-center gap-2.5">
                <i class="fa-solid fa-circle-check text-green-500"></i>
                {{ session('success') }}
            </div>
        @endif

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

            <div class="absolute right-0 bottom-0 h-full flex items-end pointer-events-none select-none"
                style="height: 130%; overflow: visible; bottom: 0;">
                <img src="{{ asset('images/mask-group.svg') }}" alt="illustration"
                    style="height: 190px; width: auto; object-fit: contain; object-position: bottom; margin-bottom: -10px;">
            </div>

            <div class="absolute -top-10 -left-10 w-36 h-36 bg-white/10 rounded-full pointer-events-none"></div>
            <div class="absolute top-5 left-28 w-16 h-16 bg-white/10 rounded-full pointer-events-none"></div>
        </div>

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
        <script>
            const chartDataTahunan = {
                labels: {!! json_encode(($chartTahunan ?? [
                    'labels' => ['2020', '2021', '2022', '2023', '2024', '2025', '2026', '2027']
                ])['labels']) !!},

                data: {!! json_encode(($chartTahunan ?? [
                    'data' => [32, 29, 17, 14, 11, 9, 6, 2]
                ])['data']) !!}
            };

            const chartDataBulanan = {
                labels: {!! json_encode(($chartBulanan ?? [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
                ])['labels']) !!},

                data: {!! json_encode(($chartBulanan ?? [
                    'data' => [5, 8, 6, 12, 9, 14, 11, 7, 10, 13, 8, 15]
                ])['data']) !!}
            };

            let chartInstance = null;

            function buildChart = function (labels, data) {
                const ctx = document.getElementById('salesChart').getContext('2d');

                if (chartInstance) {
                    chartInstance.destroy();
                }

                chartInstance = new Chart(ctx, {
                    type: 'bar',

                    data: {
                        labels,

                        datasets: [
                            {
                                label: 'Produk Terjual',
                                data,

                                backgroundColor: data.map(v =>
                                    v === Math.max(...data)
                                        ? '#FF5500'
                                        : '#20C997'
                                ),

                                borderRadius: 7,
                                borderSkipped: false,
                                maxBarThickness: 42,
                            }
                        ]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        plugins: {
                            legend: {
                                display: false
                            },

                            tooltip: {
                                backgroundColor: '#1a1a1a',
                                titleColor: '#fff',
                                bodyColor: '#aaa',
                                padding: 10,
                                cornerRadius: 8,

                                callbacks: {
                                    label: c => ' ' + c.parsed.y + ' produk terjual'
                                }
                            }
                        },

                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },

                                ticks: {
                                    font: {
                                        family: 'Poppins',
                                        size: 11
                                    },

                                    color: '#bbb'
                                }
                            },

                            y: {
                                grid: {
                                    color: '#f0ead8'
                                },

                                ticks: {
                                    font: {
                                        family: 'Poppins',
                                        size: 11
                                    },

                                    color: '#bbb',
                                    stepSize: 5
                                },

                                beginAtZero: true
                            }
                        }
                    }
                });
            };

            function updateChart = function (mode) {
                mode === 'bulanan'
                    ? buildChart(chartDataBulanan.labels, chartDataBulanan.data)
                    : buildChart(chartDataTahunan.labels, chartDataTahunan.data);
            };

            buildChart(
                chartDataTahunan.labels,
                chartDataTahunan.data
            );
        </script>
</x-layout-seller>


