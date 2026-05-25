<x-seller-layout :toko="$toko" titlePage="Laporan Penjualan">

    <x-slot:styles>
        <style>
            .insight-strip {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 18px;
                margin-bottom: 22px;
            }

            .insight-card {
                background: rgba(255, 255, 255, 0.96);
                border-radius: 24px;
                padding: 20px;
                position: relative;
                overflow: hidden;
                transition: .3s ease;
                box-shadow: 0 10px 25px rgba(0, 0, 0, .04), 0 2px 10px rgba(0, 0, 0, .02);
            }

            .insight-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 18px 40px rgba(0, 0, 0, .07), 0 5px 15px rgba(0, 0, 0, .04);
            }

            .insight-top {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 12px;
            }

            .insight-label {
                font-size: 11px;
                color: #999;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: .6px;
                margin-bottom: 8px;
            }

            .insight-value {
                font-size: 26px;
                font-weight: 800;
                color: #1a1a1a;
                line-height: 1.1;
            }

            .insight-sub {
                font-size: 12px;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 5px;
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
                width: 48px;
                height: 48px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 17px;
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

            /* Filter bar */
            .filter-bar {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 18px;
                flex-wrap: wrap;
            }

            .filter-bar label {
                font-size: 12px;
                font-weight: 600;
                color: #888;
            }

            .year-select {
                padding: 6px 14px;
                border-radius: 10px;
                border: 1.5px solid #f0e6d2;
                font-family: 'Poppins', sans-serif;
                font-size: 13px;
                font-weight: 600;
                color: #1a1a1a;
                background: #fff;
                cursor: pointer;
                outline: none;
            }

            .year-select:focus {
                border-color: #FF5500;
            }

            /* Section card */
            .section-card {
                background: rgba(255, 255, 255, 0.96);
                border-radius: 24px;
                overflow: hidden;
                box-shadow: 0 10px 25px rgba(0, 0, 0, .04), 0 2px 10px rgba(0, 0, 0, .02);
            }

            .section-header {
                padding: 18px 22px;
                border-bottom: 1px solid #f4ede2;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .section-title {
                font-size: 14px;
                font-weight: 700;
                color: #1a1a1a;
            }

            /* Table */
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
                padding: 13px 18px;
                font-size: 11px;
                color: #999;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .5px;
                text-align: left;
                white-space: nowrap;
            }

            .rekap-table td {
                padding: 15px 18px;
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

            .rekap-table tfoot td {
                padding: 14px 18px;
                font-size: 13px;
                font-weight: 700;
                background: #fffaf4;
                color: #1a1a1a;
                border-top: 2px solid #f0e6d2;
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
                gap: 3px;
                padding: 4px 9px;
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

            .status-pill {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                padding: 4px 10px;
                border-radius: 999px;
                font-size: 11px;
                font-weight: 600;
            }

            .status-pill.selesai {
                background: #dcfce7;
                color: #15803d;
            }

            .status-pill.proses {
                background: #fef9c3;
                color: #a16207;
            }

            .item-sold-wrap {
                display: flex;
                align-items: center;
                gap: 5px;
            }

            .item-sold-arrow {
                font-size: 10px;
            }

            .item-sold-arrow.up {
                color: #22c55e;
            }

            .item-sold-arrow.down {
                color: #ef4444;
            }

            @media (max-width: 860px) {
                .insight-strip {
                    grid-template-columns: 1fr 1fr;
                }

                .insight-value {
                    font-size: 20px;
                }
            }

            @media (max-width: 540px) {
                .insight-strip {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </x-slot:styles>

    {{-- ── Insight Cards ── --}}
    <div class="insight-strip">
        <div class="insight-card">
            <div class="insight-top">
                <div>
                    <div class="insight-label">Total Income Tahun Ini</div>
                    <div class="insight-value" id="insightIncome">—</div>
                </div>
                <div class="insight-icon orange"><i class="fa-solid fa-wallet"></i></div>
            </div>
            <div class="insight-sub up" id="insightIncomeSub">—</div>
        </div>

        <div class="insight-card">
            <div class="insight-top">
                <div>
                    <div class="insight-label">Item Terjual</div>
                    <div class="insight-value" id="insightItem">—</div>
                </div>
                <div class="insight-icon green"><i class="fa-solid fa-box-open"></i></div>
            </div>
            <div class="insight-sub up" id="insightItemSub">—</div>
        </div>

        <div class="insight-card">
            <div class="insight-top">
                <div>
                    <div class="insight-label">Total Order</div>
                    <div class="insight-value" id="insightOrder">—</div>
                </div>
                <div class="insight-icon blue"><i class="fa-solid fa-cart-shopping"></i></div>
            </div>
            <div class="insight-sub up" id="insightOrderSub">—</div>
        </div>

        <div class="insight-card">
            <div class="insight-top">
                <div>
                    <div class="insight-label">Rata-rata / Bulan</div>
                    <div class="insight-value" id="insightAvg">—</div>
                </div>
                <div class="insight-icon purple"><i class="fa-solid fa-chart-line"></i></div>
            </div>
            <div class="insight-sub neutral">dari bulan aktif</div>
        </div>
    </div>

    {{-- ── Filter + Table ── --}}
    <div class="filter-bar">
        <label for="yearSelect">Tahun:</label>
        <select id="yearSelect" class="year-select" onchange="renderRekap()">
            <option value="2025">2025</option>
            <option value="2024">2024</option>
        </select>
    </div>

    <div class="section-card">
        <div class="section-header">
            <span class="section-title">
                <i class="fa-solid fa-book-open text-[#FF5500] mr-2"></i>
                Rekap Bulanan
            </span>
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
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="rekapBody"></tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td id="footerIncome" class="income-cell">—</td>
                        <td id="footerOrder">—</td>
                        <td id="footerItem">—</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <x-slot:scripts>
        <script>
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

            const rupiahFull = n => 'Rp ' + n.toLocaleString('id-ID');
            const rupiah = n => {
                if (n >= 1000000) return 'Rp ' + (n / 1000000).toFixed(1).replace('.', ',') + ' jt';
                if (n >= 1000) return 'Rp ' + (n / 1000).toFixed(0) + ' rb';
                return rupiahFull(n);
            };
            const pctDiff = (now, prev) => prev ? Math.round(((now - prev) / prev) * 100) : null;

            function renderRekap() {
                const yr = parseInt(document.getElementById('yearSelect').value);
                const data = REKAP[yr] || [];
                const aktif = data.filter(r => r.income > 0);

                const statusLabel = { selesai: 'Selesai', proses: 'Dalam Proses' };

                let rows = '', totalIncome = 0, totalOrder = 0, totalItem = 0;

                data.forEach(r => {
                    totalIncome += r.income;
                    totalOrder += r.order;
                    totalItem += r.item;

                    const yoy = r.income > 0 ? pctDiff(r.income, r.incomeLalu) : null;
                    let yoyHtml = '<span style="color:#ccc;font-size:11px">—</span>';
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
                    }

                    const incomeDisplay = r.income > 0
                        ? `<span class="income-cell">${rupiahFull(r.income)}</span>`
                        : '<span style="color:#ccc">—</span>';
                    const orderDisplay = r.order > 0 ? r.order + ' order' : '<span style="color:#ccc">—</span>';
                    const itemDisplay = r.item > 0
                        ? `<div class="item-sold-wrap">${itemArrow}<span>${r.item} item</span></div>`
                        : '<span style="color:#ccc">—</span>';

                    rows += `
                    <tr>
                        <td class="month-cell">${r.bln}</td>
                        <td>${incomeDisplay}</td>
                        <td>${orderDisplay}</td>
                        <td>${itemDisplay}</td>
                        <td>${yoyHtml}</td>
                        <td><span class="status-pill ${r.status}">${statusLabel[r.status]}</span></td>
                    </tr>`;
                });

                document.getElementById('rekapBody').innerHTML = rows;
                document.getElementById('footerIncome').textContent = rupiahFull(totalIncome);
                document.getElementById('footerOrder').textContent = totalOrder + ' order';
                document.getElementById('footerItem').textContent = totalItem + ' item';

                // ── Insight cards ──
                const prevIncome = aktif.reduce((s, r) => s + r.incomeLalu, 0);
                const prevItem = aktif.reduce((s, r) => s + r.itemLalu, 0);
                const prevOrder = aktif.reduce((s, r) => s + (r.order > 0 ? Math.round(r.order * .85) : 0), 0);
                const aktifIncome = aktif.reduce((s, r) => s + r.income, 0);
                const aktifItem = aktif.reduce((s, r) => s + r.item, 0);
                const aktifOrder = aktif.reduce((s, r) => s + r.order, 0);
                const avgIncome = aktif.length ? Math.round(aktifIncome / aktif.length) : 0;

                document.getElementById('insightIncome').textContent = rupiahFull(aktifIncome);
                const incPct = pctDiff(aktifIncome, prevIncome);
                const incEl = document.getElementById('insightIncomeSub');
                incEl.innerHTML = `<i class="fa-solid fa-arrow-${incPct >= 0 ? 'up' : 'down'}"></i> ${Math.abs(incPct)}% vs tahun lalu`;
                incEl.className = `insight-sub ${incPct >= 0 ? 'up' : 'down'}`;

                document.getElementById('insightItem').textContent = aktifItem + ' item';
                const itemPct = pctDiff(aktifItem, prevItem);
                const itemEl = document.getElementById('insightItemSub');
                itemEl.innerHTML = `<i class="fa-solid fa-arrow-${itemPct >= 0 ? 'up' : 'down'}"></i> ${Math.abs(itemPct)}% vs tahun lalu`;
                itemEl.className = `insight-sub ${itemPct >= 0 ? 'up' : 'down'}`;

                document.getElementById('insightOrder').textContent = aktifOrder + ' order';
                const ordPct = pctDiff(aktifOrder, prevOrder);
                const ordEl = document.getElementById('insightOrderSub');
                ordEl.innerHTML = `<i class="fa-solid fa-arrow-${ordPct >= 0 ? 'up' : 'down'}"></i> ${Math.abs(ordPct)}% vs tahun lalu`;
                ordEl.className = `insight-sub ${ordPct >= 0 ? 'up' : 'down'}`;

                document.getElementById('insightAvg').textContent = rupiah(avgIncome);
            }

            renderRekap();
        </script>
    </x-slot:scripts>

</x-seller-layout>