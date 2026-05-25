<x-layout-seller titlePage="Laporan Penjualan">
    <style>
        .filter-bar {
            background: #fff;
            border-radius: 14px;
            padding: 14px 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .filter-bar select,
        .filter-bar input[type="month"] {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            padding: 7px 12px;
            border: 1px solid #f0e9d8;
            border-radius: 10px;
            background: #fdf9f4;
            color: #1a1a1a;
            outline: none;
            cursor: pointer;
        }
        .filter-bar select:focus,
        .filter-bar input[type="month"]:focus {
            border-color: #FF5500;
        }
        .btn-export {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            background: #FF5500;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 12px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
        }
        .btn-export:hover { background: #e04b00; }

        .summary-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        @media (max-width: 640px) { .summary-row { grid-template-columns: 1fr; } }

        .sum-card {
            background: #fff;
            border-radius: 14px;
            padding: 16px 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
        }
        .sum-card .lbl {
            font-size: 11px;
            color: #aaa;
            font-weight: 500;
            margin-bottom: 4px;
        }
        .sum-card .val {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
        }
        .sum-card .val.green { color: #16a34a; }
        .sum-card .val.amber { color: #d97706; }

        .table-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            overflow: hidden;
        }
        .table-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid #f5f0e8;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }
        .table-card-title {
            font-size: 13px;
            font-weight: 700;
            color: #1a1a1a;
        }
        .search-input {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            padding: 6px 12px 6px 32px;
            border: 1px solid #f0e9d8;
            border-radius: 10px;
            background: #fdf9f4 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='%23aaa' stroke-width='2.5'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 10px center;
            outline: none;
            width: 180px;
        }
        .search-input:focus { border-color: #FF5500; }

        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #fdf9f4; }
        thead th {
            padding: 11px 16px;
            font-size: 11px;
            font-weight: 600;
            color: #aaa;
            text-align: left;
            border-bottom: 1px solid #f5f0e8;
            white-space: nowrap;
        }
        thead th.text-right { text-align: right; }
        thead th.text-center { text-align: center; }

        tbody tr { border-bottom: 1px solid #f9f4ed; transition: background .1s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fffaf6; }

        td {
            padding: 11px 16px;
            font-size: 12.5px;
            color: #1a1a1a;
            vertical-align: middle;
        }
        td.text-right { text-align: right; }
        td.text-center { text-align: center; }
        td.muted { color: #aaa; font-size: 12px; }

        .month-separator td {
            padding: 7px 16px;
            background: #f5f0e8;
            font-size: 11px;
            font-weight: 700;
            color: #FF5500;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .month-total td {
            padding: 9px 16px;
            background: #fff8f3;
            font-size: 12px;
            font-weight: 600;
            color: #1a1a1a;
            border-top: 1px solid #f5f0e8;
        }
        .month-total td.val { color: #FF5500; }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 10.5px;
            font-weight: 600;
        }
        .badge-lunas   { background: #dcfce7; color: #15803d; }
        .badge-pending { background: #fef9c3; color: #a16207; }
        .badge-batal   { background: #fee2e2; color: #b91c1c; }

        .no-data {
            padding: 48px 20px;
            text-align: center;
            color: #ccc;
            font-size: 13px;
        }
        .no-data i { font-size: 32px; display: block; margin-bottom: 10px; }

        .pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            border-top: 1px solid #f5f0e8;
            font-size: 12px;
            color: #aaa;
            flex-wrap: wrap;
            gap: 8px;
        }
        .pagination .pages { display: flex; gap: 4px; }
        .pagination .pages button {
            width: 30px; height: 30px;
            border-radius: 8px;
            border: 1px solid #f0e9d8;
            background: transparent;
            font-size: 12px;
            font-family: 'Poppins', sans-serif;
            color: #555;
            cursor: pointer;
            transition: all .15s;
        }
        .pagination .pages button:hover,
        .pagination .pages button.active {
            background: #FF5500;
            color: #fff;
            border-color: #FF5500;
        }
    </style>

    {{-- Filter Bar --}}
    <div class="filter-bar">
        <i class="fa-solid fa-filter text-[#FF5500] text-[13px]"></i>
        <input type="month" id="filterBulan" value="{{ date('Y-m') }}" onchange="applyFilter()">
        <select id="filterStatus" onchange="applyFilter()">
            <option value="">Semua Status</option>
            <option value="lunas">Lunas</option>
            <option value="pending">Pending</option>
            <option value="batal">Batal</option>
        </select>
        <select id="filterKategori" onchange="applyFilter()">
            <option value="">Semua Kategori</option>
            <option value="jacket">Jacket</option>
            <option value="celana">Celana</option>
            <option value="sweater">Sweater</option>
            <option value="kemeja">Kemeja</option>
            <option value="sepatu">Sepatu</option>
            <option value="aksesoris">Aksesoris</option>
        </select>
        <button class="btn-export" onclick="exportCSV()">
            <i class="fa-solid fa-file-arrow-down"></i> Export CSV
        </button>
    </div>

    {{-- Summary Cards --}}
    <div class="summary-row">
        <div class="sum-card">
            <div class="lbl"><i class="fa-solid fa-sack-dollar text-[#FF5500] mr-1"></i> Total Pendapatan</div>
            <div class="val green" id="sumPendapatan">—</div>
        </div>
        <div class="sum-card">
            <div class="lbl"><i class="fa-solid fa-bag-shopping text-blue-400 mr-1"></i> Total Transaksi</div>
            <div class="val" id="sumTransaksi">—</div>
        </div>
        <div class="sum-card">
            <div class="lbl"><i class="fa-solid fa-clock text-amber-400 mr-1"></i> Menunggu Pembayaran</div>
            <div class="val amber" id="sumPending">—</div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="table-card">
        <div class="table-card-header">
            <span class="table-card-title">
                <i class="fa-solid fa-book text-[#FF5500] mr-1.5"></i>Buku Kas Penjualan
            </span>
            <input type="text" class="search-input" id="searchInput" placeholder="Cari produk..." oninput="applyFilter()">
        </div>

        <div style="overflow-x:auto;">
            <table id="laporanTable">
                <thead>
                    <tr>
                        <th style="width:40px" class="text-center">#</th>
                        <th>Tanggal</th>
                        <th>No. Order</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Harga Satuan</th>
                        <th class="text-right">Total</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    {{-- diisi via JS / bisa diganti @foreach dari controller --}}
                </tbody>
            </table>
            <div id="noData" class="no-data hidden">
                <i class="fa-regular fa-folder-open"></i>
                Tidak ada data untuk filter ini.
            </div>
        </div>

        <div class="pagination">
            <span id="paginationInfo">Menampilkan 0 data</span>
            <div class="pages" id="paginationPages"></div>
        </div>
    </div>

    <script>
        // =============================================
        // DATA — ganti dengan @json($orders) dari controller
        // =============================================
        const ORDERS = @json($orders ?? [
              id:1,  tgl:'2025-05-02', no_order:'ORD-0001', produk:'Knit Sweater Stripe',    kategori:'sweater', qty:2, harga:410000, status:'lunas'   },
            { id:2,  tgl:'2025-05-08', no_order:'ORD-0002', produk:'Nike 1990 Windbreaker',  kategori:'jacket',  qty:1, harga:850000, status:'lunas'   },
            { id:3,  tgl:'2025-05-12', no_order:'ORD-0003', produk:"Levi's 501 Original",    kategori:'celana',  qty:1, harga:620000, status:'lunas'   },
            { id:4,  tgl:'2025-05-15', no_order:'ORD-0004', produk:'ZAFUL Alaska Sweatshirt',kategori:'sweater', qty:3, harga:320000, status:'pending'  },
            { id:5,  tgl:'2025-05-20', no_order:'ORD-0005', produk:'Oxford Button-down',     kategori:'kemeja',  qty:1, harga:310000, status:'pending'  },
            { id:6,  tgl:'2025-04-03', no_order:'ORD-0006', produk:'Stone Island TC Jacket', kategori:'jacket',  qty:1, harga:1250000,status:'lunas'   },
            { id:7,  tgl:'2025-04-10', no_order:'ORD-0007', produk:'Cargo Pants Utility',    kategori:'celana',  qty:1, harga:390000, status:'batal'   },
            { id:8,  tgl:'2025-04-18', no_order:'ORD-0008', produk:'Hoodie Oversized',       kategori:'sweater', qty:3, harga:280000, status:'lunas'   },
            { id:9,  tgl:'2025-04-25', no_order:'ORD-0009', produk:'Chino Pants Slim',       kategori:'celana',  qty:2, harga:350000, status:'lunas'   },
            { id:10, tgl:'2025-03-08', no_order:'ORD-0010', produk:'Adidas Campus 00s',      kategori:'sepatu',  qty:2, harga:950000, status:'lunas'   },
            { id:11, tgl:'2025-03-15', no_order:'ORD-0011', produk:'Corduroy Blazer',        kategori:'jacket',  qty:1, harga:720000, status:'lunas'   },
            { id:12, tgl:'2025-03-28', no_order:'ORD-0012', produk:'Denim Trucker Jacket',   kategori:'jacket',  qty:1, harga:580000, status:'pending'  },
            { id:13, tgl:'2025-02-14', no_order:'ORD-0013', produk:'Flannel Shirt Vintage',  kategori:'kemeja',  qty:2, harga:480000, status:'lunas'   },
            { id:14, tgl:'2025-02-22', no_order:'ORD-0014', produk:'Cargo Pants Utility',    kategori:'celana',  qty:1, harga:390000, status:'batal'   },
            { id:15, tgl:'2025-01-12', no_order:'ORD-0015', produk:'Nike 1990 Windbreaker',  kategori:'jacket',  qty:2, harga:850000, status:'lunas'   },
        ]);

        const PER_PAGE = 10;
        let currentPage = 1;
        let filtered = [];

        const BULAN = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        function rp(n){ return 'Rp ' + Math.round(n).toLocaleString('id-ID'); }

        function badgeHTML(status){
            const map = { lunas:'badge-lunas', pending:'badge-pending', batal:'badge-batal' };
            const label = status.charAt(0).toUpperCase() + status.slice(1);
            return `<span class="badge ${map[status]||''}">${label}</span>`;
        }

        function applyFilter(){
            const bulan   = document.getElementById('filterBulan').value;    // 'YYYY-MM'
            const status  = document.getElementById('filterStatus').value;
            const kat     = document.getElementById('filterKategori').value;
            const keyword = document.getElementById('searchInput').value.toLowerCase().trim();

            filtered = ORDERS.filter(o => {
                const oBulan = o.tgl.slice(0, 7);
                return (!bulan   || oBulan === bulan)
                    && (!status  || o.status === status)
                    && (!kat     || o.kategori === kat)
                    && (!keyword || o.produk.toLowerCase().includes(keyword) || o.no_order.toLowerCase().includes(keyword));
            });

            currentPage = 1;
            renderTable();
            renderSummary();
        }

        function renderTable(){
            const body   = document.getElementById('tableBody');
            const noData = document.getElementById('noData');

            if(!filtered.length){
                body.innerHTML = '';
                noData.classList.remove('hidden');
                document.getElementById('paginationInfo').textContent = 'Menampilkan 0 data';
                document.getElementById('paginationPages').innerHTML = '';
                return;
            }
            noData.classList.add('hidden');

            // Kelompokkan per bulan untuk baris separator
            const groups = {};
            filtered.forEach(o => {
                const key = o.tgl.slice(0, 7);
                if(!groups[key]) groups[key] = [];
                groups[key].push(o);
            });
            const sortedKeys = Object.keys(groups).sort().reverse();

            // Flatten dengan metadata bulan
            const rows = [];
            sortedKeys.forEach(key => {
                rows.push({ type:'separator', key });
                groups[key].forEach(o => rows.push({ type:'row', data:o }));
                rows.push({ type:'total', key, items: groups[key] });
            });

            // Pagination hanya pada baris data (bukan separator/total)
            const dataRows = rows.filter(r => r.type === 'row');
            const totalPages = Math.ceil(dataRows.length / PER_PAGE);
            const start = (currentPage - 1) * PER_PAGE;
            const pageData = new Set(dataRows.slice(start, start + PER_PAGE).map(r => r.data.id));

            // Render — tampilkan separator & total hanya jika ada data di halaman ini
            let html = '';
            let no = start + 1;
            sortedKeys.forEach(key => {
                const monthRows = groups[key].filter(o => pageData.has(o.id));
                if(!monthRows.length) return;

                const [y, m] = key.split('-');
                html += `<tr class="month-separator"><td colspan="9">${BULAN[parseInt(m)-1]} ${y}</td></tr>`;

                monthRows.forEach(o => {
                    const total = o.qty * o.harga;
                    const isCoretan = o.status === 'batal';
                    html += `
                        <tr>
                            <td class="text-center muted">${no++}</td>
                            <td class="muted">${formatTgl(o.tgl)}</td>
                            <td style="font-size:11.5px;color:#aaa">${o.no_order}</td>
                            <td style="font-weight:600">${o.produk}</td>
                            <td><span style="font-size:11px;background:#f5f0e8;padding:2px 8px;border-radius:999px;color:#888;text-transform:capitalize">${o.kategori}</span></td>
                            <td class="text-center">${o.qty}</td>
                            <td class="text-right">${rp(o.harga)}</td>
                            <td class="text-right" style="font-weight:600;${isCoretan?'text-decoration:line-through;color:#ccc':''}">${rp(total)}</td>
                            <td class="text-center">${badgeHTML(o.status)}</td>
                        </tr>`;
                });

                const monthTotal = monthRows.filter(o=>o.status!=='batal').reduce((s,o)=>s+o.qty*o.harga, 0);
                html += `
                    <tr class="month-total">
                        <td colspan="7" style="color:#aaa">Subtotal ${BULAN[parseInt(m)-1]}</td>
                        <td class="text-right val">${rp(monthTotal)}</td>
                        <td></td>
                    </tr>`;
            });

            body.innerHTML = html;

            // Pagination info
            const showing = Math.min(start + PER_PAGE, dataRows.length);
            document.getElementById('paginationInfo').textContent =
                `Menampilkan ${start+1}–${showing} dari ${dataRows.length} transaksi`;

            // Pagination buttons
            let pages = '';
            for(let i = 1; i <= totalPages; i++){
                pages += `<button class="${i===currentPage?'active':''}" onclick="goPage(${i})">${i}</button>`;
            }
            document.getElementById('paginationPages').innerHTML = pages;
        }

        function renderSummary(){
            const lunas = filtered.filter(o => o.status === 'lunas');
            const pending = filtered.filter(o => o.status === 'pending');
            const totalPendapatan = lunas.reduce((s,o) => s + o.qty * o.harga, 0);
            const totalPending    = pending.reduce((s,o) => s + o.qty * o.harga, 0);

            document.getElementById('sumPendapatan').textContent = rp(totalPendapatan);
            document.getElementById('sumTransaksi').textContent  = filtered.length + ' transaksi';
            document.getElementById('sumPending').textContent    = rp(totalPending);
        }

        function formatTgl(str){
            const d = new Date(str);
            return `${d.getDate()} ${BULAN[d.getMonth()].slice(0,3)} ${d.getFullYear()}`;
        }

        function goPage(p){ currentPage = p; renderTable(); }

        function exportCSV(){
            const headers = ['No','Tanggal','No Order','Produk','Kategori','Qty','Harga Satuan','Total','Status'];
            const rows = filtered.map((o,i) => [
                i+1, o.tgl, o.no_order, o.produk, o.kategori, o.qty, o.harga, o.qty*o.harga, o.status
            ]);
            const csv = [headers, ...rows].map(r => r.join(',')).join('\n');
            const a = document.createElement('a');
            a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
            a.download = 'laporan-penjualan.csv';
            a.click();
        }

        applyFilter();
    </script>
</x-layout-seller>