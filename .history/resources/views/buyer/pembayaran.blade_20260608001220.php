<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .pay-card {
            background: #fff;
            border-radius: 20px;
            padding: 28px 24px;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .07);
        }

        .store-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .store-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #FFF3EC;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .store-avatar i {
            font-size: 18px;
            color: #FF5500;
        }

        .store-name {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .store-id {
            font-size: 11px;
            color: #aaa;
            margin-top: 2px;
        }

        .divider {
            border: none;
            border-top: 1px solid #f0f0f0;
            margin: 0 0 16px;
        }

        .section-label {
            font-size: 10.5px;
            font-weight: 600;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 10px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 6px 0;
            font-size: 12.5px;
        }

        .item-name {
            color: #555;
            flex: 1;
            padding-right: 12px;
            line-height: 1.4;
        }

        .item-price {
            color: #1a1a1a;
            font-weight: 500;
            white-space: nowrap;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1.5px dashed #e5e7eb;
        }

        .total-label {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .total-amount {
            font-size: 20px;
            font-weight: 700;
            color: #FF5500;
        }

        .qris-section {
            margin-top: 22px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .qris-badge {
            background: #FFF3EC;
            color: #FF5500;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 14px;
            border-radius: 20px;
            letter-spacing: .04em;
        }

        .qris-img-wrap {
            border: 1.5px solid #e5e7eb;
            border-radius: 14px;
            padding: 50px;
            background: #fff;
        }

        .qris-img-wrap img {
            width: 240px;
            height: 240px;
            object-fit: contain;
            display: block;
        }

        .qris-note {
            font-size: 11px;
            color: #aaa;
            text-align: center;
        }
    </style>
</head>

<body>

    @php
        $namaToko = 'Toko Baju Vintage';
        $idToko = '0000001';
        $items = [
            ['nama' => 'Nike Windbreaker 1990 Original', 'harga' => 150000],
            ['nama' => "Levi's 501 Vintage Washed", 'harga' => 220000],
            ['nama' => 'Adidas Sweater 80s Grey', 'harga' => 95000],
        ];
        $subtotal = array_sum(array_column($items, 'harga'));
    @endphp

    <div class="pay-card">

        <div class="store-header">
            <div class="store-avatar">
                <i class="fa-solid fa-store"></i>
            </div>
            <div>
                <p class="store-name">{{ $namaToko }}</p>
                <p class="store-id">ID: {{ $idToko }}</p>
            </div>
        </div>

        <hr class="divider">

        <p class="section-label">Rincian Pesanan</p>

        @foreach($items as $item)
            <div class="item-row">
                <span class="item-name">{{ $item['nama'] }}</span>
                <span class="item-price">Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
            </div>
        @endforeach

        <div class="total-row">
            <span class="total-label">Subtotal</span>
            <span class="total-amount">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>

        <div class="qris-section">
            <span class="qris-badge">Bayar via QRIS</span>
            <div class="qris-img-wrap">
                <img src="{{ asset('images/qris.jpg') }}" alt="QR Code QRIS">
            </div>
            <p class="qris-note">Scan QR code di atas untuk menyelesaikan pembayaran</p>
        </div>

    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</body>

</html>