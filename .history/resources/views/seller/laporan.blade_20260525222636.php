@extends('layouts.seller')

@section('title', 'Laporan Penjualan - ThriftStop')

@section('content')

{{-- TOPBAR --}}
<div class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between">
    <div>
        <h1 class="text-base font-medium text-gray-800">Laporan Penjualan</h1>
        <p class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>
    <div class="flex items-center gap-2">
        <select id="filterPeriode"
            class="text-xs px-3 py-1.5 border border-gray-200 rounded-lg bg-white text-gray-600 focus:outline-none focus:border-[#E8501A] cursor-pointer">
            <option value="bulanan">Bulanan</option>
            <option value="tahunan">Tahunan</option>
        </select>
        <select id="filterKategori"
            class="text-xs px-3 py-1.5 border border-gray-200 rounded-lg bg-white text-gray-600 focus:outline-none focus:border-[#E8501A] cursor-pointer">
            <option value="semua">Semua Kategori</option>
            <option value="pakaian">Pakaian</option>
            <option value="aksesoris">Aksesoris</option>
            <option value="sepatu">Sepatu</option>
            <option value="tas">Tas</option>
        </select>
        <button id="btnExport"
            class="flex items-center gap-1.5 bg-[#E8501A] hover:bg-[#d04416] text-white text-xs font-medium px-3 py-1.5 rounded-lg transition-colors">
            <i class="ti ti-download text-sm"></i> Export CSV
        </button>
    </div>
</div>

<div class="p-6 overflow-y-auto flex-1">

    {{-- METRIC CARDS --}}
    <div class="grid grid-cols-3 gap-3 mb-5">
        <div class="bg-white border border-gray-200 rounded-xl p-4 border-t-[3px] border-t-[#E8501A]">
            <p class="text-[11px] text-gray-400 flex items-center gap-1 mb-2">
                <i class="ti ti-currency-dollar text-sm"></i> Total Pemasukan
            </p>
            <p class="text-xl font-medium text-gray-800" id="metricIncome">Rp 0</p>
            <p class="text-[11px] text-gray-400 mt-1">
                <span class="text-emerald-600 font-medium" id="metricIncomeChange">↑ 0%</span> vs periode lalu
            </p>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <p class="text-[11px] text-gray-400 flex items-center gap-1 mb-2">
                <i class="ti ti-shopping-bag text-sm"></i> Produk Terjual
            </p>
            <p class="text-xl font-medium text-gray-800" id="metricSold">0</p>
            <p class="text-[11px] text-gray-400 mt-1">
                <span class="text-emerald-600 font-medium" id="metricSoldChange">↑ 0%</span> vs periode lalu
            </p>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <p class="text-[11px] text-gray-400 flex items-center gap-1 mb-2">
                <i class="ti ti-receipt text-sm"></i> Total Order
            </p>
            <p class="text-xl font-medium text-gray-800" id="metricOrder">0</p>
            <p class="text-[11px] text-gray-400 mt-1">
                <span class="text-red-500 font-medium" id="metricOrderChange">↓ 0%</span> vs periode lalu
            </p>
        </div>
    </div>

    {{-- CHARTS ROW --}}
    <div class="grid grid-cols-5 gap-3 mb-5">

        {{-- Grafik Penjualan --}}
        <div class="col-span-3 bg-white border border-gray-200 rounded-xl p-4">
            <h3 class="text-[13px] font-medium text-gray-800">Grafik Penjualan</h3>
            <p class="text-[11px] text-gray-400 mt-0.5 mb-3" id="chartSubtitle">Jumlah produk terjual per bulan — 2026</p>
            <div class="relative w-full h-44">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        {{-- Kategori Terlaris --}}
        <div class="col-span-2 bg-white border border-gray-200 rounded-xl p-4">
            <h3 class="text-[13px] font-medium text-gray-800">Kategori Terlaris</h3>
            <p class="text-[11px] text-gray-400 mt-0.5 mb-4">Berdasarkan jumlah terjual</p>
            <div id="kategoriChart" class="space-y-3"></div>
        </div>
    </div>

    {{-- TABEL RIWAYAT ORDER --}}
    <div class="bg-white border border-gray-200 rounded-xl p-4">
        <div class="flex items-center justify-between mb-3">
            <div>
                <h3 class="text-[13px] font-medium text-gray-800">Riwayat Order</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">Transaksi masuk ke toko kamu</p>
            </div>
            <div class="flex items-center gap-3 text-[11px] text-gray-400">
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>Selesai</span>
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-500 inline-block"></span>Diproses</span>
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-red-400 inline-block"></span>Dibatalkan</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-[12px]">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-2 px-3 text-[11px] text-gray-400 font-medium">ID Order</th>
                        <th class="text-left py-2 px-3 text-[11px] text-gray-400 font-medium">Produk</th>
                        <th class="text-left py-2 px-3 text-[11px] text-gray-400 font-medium">Pembeli</th>
                        <th class="text-left py-2 px-3 text-[11px] text-gray-400 font-medium">Tanggal</th>
                        <th class="text-left py-2 px-3 text-[11px] text-gray-400 font-medium">Total</th>
                        <th class="text-left py-2 px-3 text-[11px] text-gray-400 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                    {{-- diisi JS --}}
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100">
            <span class="text-[11px] text-gray-400" id="paginationInfo">Menampilkan 0 dari 0 order</span>
            <div class="flex gap-1" id="paginationBtns"></div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/laporan.js') }}"></script>
@endpush