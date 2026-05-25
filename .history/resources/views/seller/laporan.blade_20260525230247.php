<x-layout-seller titlePage="Laporan Penjualan">

    <style>
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

        .chart-wrap {
            padding: 20px;
            position: relative;
        }

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
    </style>

    {{-- Stat Cards + Chart --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Stat Cards (kiri) --}}
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

        {{-- Chart Pendapatan (kanan) --}}
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

    {{-- Top Produk + Kategori --}}
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
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

        function rupiah(n) {
            return 'Rp ' + n.toLocaleString('id-ID');
        }

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
                    responsive: true, maintainAspectRatio: false,
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
                        x: { grid: { display: false }, ticks: { font: { family: 'Poppins', size: 10 }, color: '#aaa' } },
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
                            labels: { font: { family: 'Poppins', size: 10 }, color: '#555', padding: 10, boxWidth: 10, boxHeight: 10 }
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

        function setPeriod(period, el) {
            document.querySelectorAll('.period-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            renderChartPendapatan(period);
            updateStats(period);
        }

        updateStats('7d');
        renderChartPendapatan('7d');
        renderChartKategori();
        renderTopProduk();
    </script>

</x-layout-seller>