const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
const now = new Date();
document.getElementById('tanggalHariIni').textContent =
    days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();

window.openSidebar = function () {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('sidebarOverlay').classList.add('show');
    document.body.style.overflow = 'hidden';
}
window.closeSidebar = function () {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('show');
    document.body.style.overflow = '';
}
window.toggleCollapse = function () {
    document.getElementById('sidebar').classList.toggle('collapsed');
    document.getElementById('mainWrap').classList.toggle('collapsed');
}

window.toggleNotif = function () {
    document.getElementById('notifDropdown').classList.toggle('hidden');
}
document.addEventListener('click', e => {
    const btn = document.getElementById('notifBtn');
    const dd = document.getElementById('notifDropdown');
    if (dd && btn && !btn.contains(e.target) && !dd.contains(e.target)) dd.classList.add('hidden');
})
window.confirmLogout = function() { document.getElementById('logoutModal').classList.remove('hidden'); }
window.cancelLogout = function() { document.getElementById('logoutModal').classList.add('hidden'); }
window.doLogout = function() { document.getElementById('logoutForm').submit(); }
