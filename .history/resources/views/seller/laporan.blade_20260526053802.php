<x-layout-seller titlePage="Laporan Penjualan">

    @push('styles')
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
    @endpush

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

    <div class="filter-bar">
        <label for="yearSelect">Tahun:</label>
        <select id="yearSelect" class="year-select">
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

    @push('scripts')
        @vite('resources/js/laporan.js')
    @endpush

</x-layout-seller>