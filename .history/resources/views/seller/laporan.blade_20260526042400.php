<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThriftStop - Seller</title>

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
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            display: flex;
            background: #F1E0B4;
            overflow-x: hidden;
        }

        /* =========================
           MAIN CONTENT
        ========================= */

        #mainWrap {
            margin-left: 220px;
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            padding: 28px;
        }

        /* =========================
           INSIGHT CARD
        ========================= */

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

        .insight-card.orange::before {
            background: #FF5500;
        }

        .insight-card.green::before {
            background: #22c55e;
        }

        .insight-card.blue::before {
            background: #3b82f6;
        }

        .insight-card.purple::before {
            background: #a855f7;
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

        /* =========================
           CONTENT GRID
        ========================= */

        .rekap-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 22px;
        }

        /* =========================
           SECTION CARD
        ========================= */

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

        /* =========================
           TABLE
        ========================= */

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

        /* =========================
           BADGE
        ========================= */

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

        /* =========================
           PAYMENT
        ========================= */

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

        /* =========================
           RESPONSIVE
        ========================= */

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

    <!-- SIDEBAR KAMU -->
    <!-- BIARIN YANG LAMA -->

    <div id="mainWrap">

        <!-- HEADER KAMU -->
        <!-- BIARIN YANG LAMA -->

        <main>

            <!-- INSIGHT -->
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

            <!-- GRID -->
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

                <!-- PAYMENT -->
                <div class="section-card">

                    <div class="section-header">
                        <div class="section-title">
                            <i class="fa-solid fa-credit-card text-[#FF5500] mr-2"></i>
                            Metode Pembayaran
                        </div>
                    </div>

                    <div class="pay-list">

                        <div class="pay-item">

                            <div class="pay-icon qris">
                                <i class="fa-solid fa-qrcode"></i>
                            </div>

                            <div class="pay-bar-wrap">

                                <div class="pay-name">
                                    QRIS
                                </div>

                                <div class="pay-bar-bg">
                                    <div class="pay-bar qris"></div>
                                </div>

                            </div>

                            <div class="pay-pct">
                                52%
                            </div>

                        </div>

                        <div class="pay-item">

                            <div class="pay-icon tf">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>

                            <div class="pay-bar-wrap">

                                <div class="pay-name">
                                    Transfer Bank
                                </div>

                                <div class="pay-bar-bg">
                                    <div class="pay-bar tf"></div>
                                </div>

                            </div>

                            <div class="pay-pct">
                                28%
                            </div>

                        </div>

                        <div class="pay-item">

                            <div class="pay-icon cod">
                                <i class="fa-solid fa-hand-holding-dollar"></i>
                            </div>

                            <div class="pay-bar-wrap">

                                <div class="pay-name">
                                    COD
                                </div>

                                <div class="pay-bar-bg">
                                    <div class="pay-bar cod"></div>
                                </div>

                            </div>

                            <div class="pay-pct">
                                13%
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>

</body>

</html>