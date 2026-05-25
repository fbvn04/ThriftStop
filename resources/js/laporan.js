const REKAP = {
    2025: [
        { bln: 'Januari',   income: 8200000,  order: 54, item: 68, itemLalu: 51, incomeLalu: 6100000, status: 'selesai' },
        { bln: 'Februari',  income: 7450000,  order: 48, item: 60, itemLalu: 44, incomeLalu: 5800000, status: 'selesai' },
        { bln: 'Maret',     income: 9100000,  order: 61, item: 77, itemLalu: 58, incomeLalu: 6400000, status: 'selesai' },
        { bln: 'April',     income: 8750000,  order: 57, item: 71, itemLalu: 63, incomeLalu: 7100000, status: 'selesai' },
        { bln: 'Mei',       income: 10200000, order: 68, item: 85, itemLalu: 70, incomeLalu: 6800000, status: 'selesai' },
        { bln: 'Juni',      income: 0, order: 0, item: 0, itemLalu: 62, incomeLalu: 7300000, status: 'proses' },
        { bln: 'Juli',      income: 0, order: 0, item: 0, itemLalu: 55, incomeLalu: 6100000, status: 'proses' },
        { bln: 'Agustus',   income: 0, order: 0, item: 0, itemLalu: 48, incomeLalu: 4700000, status: 'proses' },
        { bln: 'September', income: 0, order: 0, item: 0, itemLalu: 52, incomeLalu: 5200000, status: 'proses' },
        { bln: 'Oktober',   income: 0, order: 0, item: 0, itemLalu: 44, incomeLalu: 3800000, status: 'proses' },
        { bln: 'November',  income: 0, order: 0, item: 0, itemLalu: 46, incomeLalu: 4100000, status: 'proses' },
        { bln: 'Desember',  income: 0, order: 0, item: 0, itemLalu: 38, incomeLalu: 3200000, status: 'proses' },
    ],
    2024: [
        { bln: 'Januari',   income: 6100000, order: 41, item: 51, itemLalu: 38, incomeLalu: 4200000, status: 'selesai' },
        { bln: 'Februari',  income: 5800000, order: 38, item: 44, itemLalu: 34, incomeLalu: 3900000, status: 'selesai' },
        { bln: 'Maret',     income: 6400000, order: 43, item: 58, itemLalu: 40, incomeLalu: 4500000, status: 'selesai' },
        { bln: 'April',     income: 7100000, order: 47, item: 63, itemLalu: 44, incomeLalu: 4800000, status: 'selesai' },
        { bln: 'Mei',       income: 6800000, order: 45, item: 70, itemLalu: 50, incomeLalu: 5100000, status: 'selesai' },
        { bln: 'Juni',      income: 7300000, order: 49, item: 62, itemLalu: 46, incomeLalu: 4900000, status: 'selesai' },
        { bln: 'Juli',      income: 6100000, order: 40, item: 55, itemLalu: 42, incomeLalu: 4300000, status: 'selesai' },
        { bln: 'Agustus',   income: 4700000, order: 31, item: 48, itemLalu: 36, incomeLalu: 3600000, status: 'selesai' },
        { bln: 'September', income: 5200000, order: 34, item: 52, itemLalu: 39, incomeLalu: 3900000, status: 'selesai' },
        { bln: 'Oktober',   income: 3800000, order: 25, item: 44, itemLalu: 33, incomeLalu: 3100000, status: 'selesai' },
        { bln: 'November',  income: 4100000, order: 27, item: 46, itemLalu: 34, incomeLalu: 3300000, status: 'selesai' },
        { bln: 'Desember',  income: 3200000, order: 21, item: 38, itemLalu: 28, incomeLalu: 2700000, status: 'selesai' },
    ],
};

const rupiahFull = n => 'Rp ' + n.toLocaleString('id-ID');
const rupiah = n => {
    if (n >= 1000000) return 'Rp ' + (n / 1000000).toFixed(1).replace('.', ',') + ' jt';
    if (n >= 1000)    return 'Rp ' + (n / 1000).toFixed(0) + ' rb';
    return rupiahFull(n);
};
const pctDiff = (now, prev) => prev ? Math.round(((now - prev) / prev) * 100) : null;

function renderRekap() {
    const yr    = parseInt(document.getElementById('yearSelect').value);
    const data  = REKAP[yr] || [];
    const aktif = data.filter(r => r.income > 0);

    const statusLabel = { selesai: 'Selesai', proses: 'Dalam Proses' };

    let rows = '', totalIncome = 0, totalOrder = 0, totalItem = 0;

    data.forEach(r => {
        totalIncome += r.income;
        totalOrder  += r.order;
        totalItem   += r.item;

        const yoy = r.income > 0 ? pctDiff(r.income, r.incomeLalu) : null;
        let yoyHtml = '<span style="color:#ccc;font-size:11px">—</span>';
        if (yoy !== null) {
            const cls  = yoy > 0 ? 'up' : (yoy < 0 ? 'down' : 'flat');
            const icon = yoy > 0 ? '▲' : (yoy < 0 ? '▼' : '—');
            yoyHtml = `<span class="badge-yoy ${cls}">${icon} ${Math.abs(yoy)}%</span>`;
        }

        const itemDiff = r.item - r.itemLalu;
        let itemArrow  = '';
        if (r.item > 0) {
            if (itemDiff > 0)      itemArrow = `<i class="fa-solid fa-arrow-up item-sold-arrow up"></i>`;
            else if (itemDiff < 0) itemArrow = `<i class="fa-solid fa-arrow-down item-sold-arrow down"></i>`;
        }

        const incomeDisplay = r.income > 0
            ? `<span class="income-cell">${rupiahFull(r.income)}</span>`
            : '<span style="color:#ccc">—</span>';
        const orderDisplay = r.order > 0
            ? r.order + ' order'
            : '<span style="color:#ccc">—</span>';
        const itemDisplay  = r.item > 0
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

    document.getElementById('rekapBody').innerHTML      = rows;
    document.getElementById('footerIncome').textContent = rupiahFull(totalIncome);
    document.getElementById('footerOrder').textContent  = totalOrder + ' order';
    document.getElementById('footerItem').textContent   = totalItem  + ' item';

    const aktifIncome = aktif.reduce((s, r) => s + r.income, 0);
    const aktifItem   = aktif.reduce((s, r) => s + r.item,   0);
    const aktifOrder  = aktif.reduce((s, r) => s + r.order,  0);
    const prevIncome  = aktif.reduce((s, r) => s + r.incomeLalu, 0);
    const prevItem    = aktif.reduce((s, r) => s + r.itemLalu,   0);
    const prevOrder   = aktif.reduce((s, r) => s + (r.order > 0 ? Math.round(r.order * 0.85) : 0), 0);
    const avgIncome   = aktif.length ? Math.round(aktifIncome / aktif.length) : 0;

    const setInsight = (valId, subId, value, prev, suffix = '') => {
        document.getElementById(valId).textContent = value;
        const pct = pctDiff(
            aktifIncome === value ? aktifIncome : (aktifItem === value ? aktifItem : aktifOrder),
            prev
        );
    };

    document.getElementById('insightIncome').textContent = rupiahFull(aktifIncome);
    const incPct = pctDiff(aktifIncome, prevIncome);
    const incEl  = document.getElementById('insightIncomeSub');
    incEl.innerHTML = `<i class="fa-solid fa-arrow-${incPct >= 0 ? 'up' : 'down'}"></i> ${Math.abs(incPct)}% vs tahun lalu`;
    incEl.className = `insight-sub ${incPct >= 0 ? 'up' : 'down'}`;

    document.getElementById('insightItem').textContent = aktifItem + ' item';
    const itemPct = pctDiff(aktifItem, prevItem);
    const itemEl  = document.getElementById('insightItemSub');
    itemEl.innerHTML = `<i class="fa-solid fa-arrow-${itemPct >= 0 ? 'up' : 'down'}"></i> ${Math.abs(itemPct)}% vs tahun lalu`;
    itemEl.className = `insight-sub ${itemPct >= 0 ? 'up' : 'down'}`;

    document.getElementById('insightOrder').textContent = aktifOrder + ' order';
    const ordPct = pctDiff(aktifOrder, prevOrder);
    const ordEl  = document.getElementById('insightOrderSub');
    ordEl.innerHTML = `<i class="fa-solid fa-arrow-${ordPct >= 0 ? 'up' : 'down'}"></i> ${Math.abs(ordPct)}% vs tahun lalu`;
    ordEl.className = `insight-sub ${ordPct >= 0 ? 'up' : 'down'}`;

    document.getElementById('insightAvg').textContent = rupiah(avgIncome);
}

document.addEventListener('DOMContentLoaded', () => {
    renderRekap();

    document.getElementById('yearSelect').addEventListener('change', renderRekap);
});