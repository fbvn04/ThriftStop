<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - ThriftStop</title>

    {{-- Poppins Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Vite (Tailwind) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Poppins', sans-serif; }
        input { outline: none !important; box-shadow: none !important; }

        /* Password strength bar */
        .strength-bar { transition: width 0.3s ease, background-color 0.3s ease; }
    </style>
</head>

<body class="bg-[#F1E0B4] min-h-screen flex items-center justify-center px-4 py-8 relative overflow-x-hidden">

    {{-- Background image kiri (senada login) --}}
    <div class="absolute -left-28 top-0 h-full w-[40%] overflow-hidden flex items-start justify-start pointer-events-none">
        <img
            src="{{ asset('images/thrift-login.png') }}"
            alt="ThriftStop Fashion"
            class="w-full h-full object-contain object-top opacity-60 scale-110 -translate-y-6 -translate-x-6"
        >
    </div>

    {{-- Card --}}
    <div class="bg-white/75 backdrop-blur-xl rounded-3xl shadow-xl flex flex-col md:flex-row w-full max-w-[700px] overflow-hidden relative z-10 my-4">

        {{-- Kiri: Branding (hidden di mobile, tampil di md+) --}}
        <div class="hidden md:flex w-[38%] flex-col justify-center px-8 py-10 shrink-0">
            <h1 class="text-[34px] font-extrabold leading-tight">
                <span class="text-orange-500">Thrift</span><span class="text-black">Stop</span>
            </h1>
            <p class="text-[12px] text-[#555] mt-2 leading-relaxed">
                Platform Marketplace Thrifting<br>untuk UMKM indonesia
            </p>

            {{-- Ilustrasi mini --}}
            <div class="mt-8 space-y-3">
                <div class="flex items-center gap-3 text-[11px] text-[#666]">
                    <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-tag text-orange-500 text-[11px]"></i>
                    </div>
                    Temukan barang thrift terbaik
                </div>
                <div class="flex items-center gap-3 text-[11px] text-[#666]">
                    <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-shield-halved text-orange-500 text-[11px]"></i>
                    </div>
                    Transaksi aman & terpercaya
                </div>
                <div class="flex items-center gap-3 text-[11px] text-[#666]">
                    <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-heart text-orange-500 text-[11px]"></i>
                    </div>
                    Dukung UMKM Indonesia
                </div>
            </div>
        </div>

        {{-- Divider (hanya di md+) --}}
        <div class="hidden md:block w-px bg-[#cfc3a5] my-8 shrink-0"></div>

        {{-- Kanan: Form Register --}}
        <div class="flex-1 flex flex-col justify-center px-6 md:px-9 py-8">

            {{-- Brand mobile only --}}
            <div class="md:hidden mb-5">
                <h1 class="text-[28px] font-extrabold leading-tight">
                    <span class="text-orange-500">Thrift</span><span class="text-black">Stop</span>
                </h1>
                <p class="text-[11px] text-[#555] mt-1">Platform Marketplace Thrifting untuk UMKM indonesia</p>
            </div>

            <h2 class="text-[18px] font-semibold text-[#1a1a1a] mb-1">Buat Akun Baru</h2>
            <p class="text-[11px] text-[#888] mb-5">Isi data diri kamu untuk mulai berbelanja</p>

            {{-- Alert error server --}}
            @if($errors->any())
                <div class="bg-red-50 text-red-600 px-4 py-2.5 rounded-lg text-[11px] mb-4 flex items-start gap-2">
                    <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form id="registerForm" action="{{ route('register.buyer') }}" method="POST" novalidate>
                @csrf

                {{-- Nama Lengkap --}}
                <div class="mb-1">
                    <div id="namaBorder" class="flex items-center border-b border-[#000] transition-colors duration-200">
                        <i class="fa-regular fa-id-card text-[#000] text-[13px] mr-2 shrink-0"></i>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            placeholder="Nama lengkap"
                            value="{{ old('nama') }}"
                            autocomplete="name"
                            class="flex-1 bg-transparent py-2.5 text-[13px] text-[#000] placeholder-[#aaa] border-none ring-0 focus:ring-0"
                        >
                        <i class="fa-solid fa-circle-check text-green-400 text-[12px] ml-2 hidden" id="namaCheck"></i>
                    </div>
                    <span id="namaError" class="block text-[10px] text-red-500 min-h-[14px] mt-0.5 pl-5"></span>
                </div>

                {{-- Username --}}
                <div class="mb-1">
                    <div id="usernameBorder" class="flex items-center border-b border-[#000] transition-colors duration-200">
                        <i class="fa-regular fa-user text-[#000] text-[13px] mr-2 shrink-0"></i>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Username (tanpa spasi)"
                            value="{{ old('username') }}"
                            autocomplete="username"
                            class="flex-1 bg-transparent py-2.5 text-[13px] text-[#000] placeholder-[#aaa] border-none ring-0 focus:ring-0"
                        >
                        <i class="fa-solid fa-circle-check text-green-400 text-[12px] ml-2 hidden" id="usernameCheck"></i>
                    </div>
                    <span id="usernameError" class="block text-[10px] text-red-500 min-h-[14px] mt-0.5 pl-5"></span>
                </div>

                {{-- Email --}}
                <div class="mb-1">
                    <div id="emailBorder" class="flex items-center border-b border-[#000] transition-colors duration-200">
                        <i class="fa-regular fa-envelope text-[#000] text-[13px] mr-2 shrink-0"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Email aktif kamu"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            class="flex-1 bg-transparent py-2.5 text-[13px] text-[#000] placeholder-[#aaa] border-none ring-0 focus:ring-0"
                        >
                        <i class="fa-solid fa-circle-check text-green-400 text-[12px] ml-2 hidden" id="emailCheck"></i>
                    </div>
                    <span id="emailError" class="block text-[10px] text-red-500 min-h-[14px] mt-0.5 pl-5"></span>
                </div>

                {{-- No. HP --}}
                <div class="mb-1">
                    <div id="hpBorder" class="flex items-center border-b border-[#000] transition-colors duration-200">
                        <i class="fa-solid fa-phone text-[#000] text-[13px] mr-2 shrink-0"></i>
                        <span class="text-[13px] text-[#555] mr-1 shrink-0">+62</span>
                        <input
                            type="tel"
                            id="hp"
                            name="hp"
                            placeholder="8xx xxxx xxxx"
                            value="{{ old('hp') }}"
                            autocomplete="tel"
                            maxlength="13"
                            class="flex-1 bg-transparent py-2.5 text-[13px] text-[#000] placeholder-[#aaa] border-none ring-0 focus:ring-0"
                        >
                        <i class="fa-solid fa-circle-check text-green-400 text-[12px] ml-2 hidden" id="hpCheck"></i>
                    </div>
                    <span id="hpError" class="block text-[10px] text-red-500 min-h-[14px] mt-0.5 pl-5"></span>
                </div>

                {{-- Password --}}
                <div class="mb-1">
                    <div id="passwordBorder" class="flex items-center border-b border-[#000] transition-colors duration-200">
                        <i class="fa-solid fa-lock text-[#000] text-[13px] mr-2 shrink-0"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Password (min. 8 karakter)"
                            autocomplete="new-password"
                            class="flex-1 bg-transparent py-2.5 text-[13px] text-[#000] placeholder-[#aaa] border-none ring-0 focus:ring-0"
                        >
                        <button type="button" id="togglePw" tabindex="-1" class="text-[#000] text-[13px] hover:text-[#888] transition-colors ml-2">
                            <i class="fa-regular fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    {{-- Password strength bar --}}
                    <div class="flex gap-1 mt-1.5 pl-5">
                        <div class="h-1 flex-1 rounded-full bg-gray-200 overflow-hidden">
                            <div id="bar1" class="h-full w-0 strength-bar rounded-full"></div>
                        </div>
                        <div class="h-1 flex-1 rounded-full bg-gray-200 overflow-hidden">
                            <div id="bar2" class="h-full w-0 strength-bar rounded-full"></div>
                        </div>
                        <div class="h-1 flex-1 rounded-full bg-gray-200 overflow-hidden">
                            <div id="bar3" class="h-full w-0 strength-bar rounded-full"></div>
                        </div>
                    </div>
                    <span id="strengthLabel" class="block text-[10px] text-[#aaa] mt-0.5 pl-5"></span>
                    <span id="passwordError" class="block text-[10px] text-red-500 min-h-[14px] mt-0.5 pl-5"></span>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-1">
                    <div id="konfirmBorder" class="flex items-center border-b border-[#000] transition-colors duration-200">
                        <i class="fa-solid fa-lock text-[#000] text-[13px] mr-2 shrink-0"></i>
                        <input
                            type="password"
                            id="konfirm"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            autocomplete="new-password"
                            class="flex-1 bg-transparent py-2.5 text-[13px] text-[#000] placeholder-[#aaa] border-none ring-0 focus:ring-0"
                        >
                        <button type="button" id="toggleKonfirm" tabindex="-1" class="text-[#000] text-[13px] hover:text-[#888] transition-colors ml-2">
                            <i class="fa-regular fa-eye" id="eyeKonfirmIcon"></i>
                        </button>
                    </div>
                    <span id="konfirmError" class="block text-[10px] text-red-500 min-h-[14px] mt-0.5 pl-5"></span>
                </div>

                {{-- Tombol Daftar --}}
                <button
                    type="submit"
                    id="submitBtn"
                    disabled
                    class="w-full bg-orange-500 hover:bg-orange-600 active:scale-[0.98] disabled:bg-orange-200 disabled:cursor-not-allowed text-white font-semibold text-[14px] py-3 rounded-lg mt-4 transition-all duration-200 tracking-wide"
                >
                    Buat Akun
                </button>

            </form>

            {{-- Login link --}}
            <p class="text-center text-[11px] text-[#888] mt-4">
                Sudah punya akun?
                <a href="{{ route('login.buyer') }}" class="text-orange-500 font-semibold hover:underline">Masuk sekarang</a>
            </p>

        </div>
    </div>

    <script>
        // ── Elements ──────────────────────────────────────────
        const fields = {
            nama:     { input: document.getElementById('nama'),     border: document.getElementById('namaBorder'),     error: document.getElementById('namaError'),     check: document.getElementById('namaCheck') },
            username: { input: document.getElementById('username'), border: document.getElementById('usernameBorder'), error: document.getElementById('usernameError'), check: document.getElementById('usernameCheck') },
            email:    { input: document.getElementById('email'),    border: document.getElementById('emailBorder'),    error: document.getElementById('emailError'),    check: document.getElementById('emailCheck') },
            hp:       { input: document.getElementById('hp'),       border: document.getElementById('hpBorder'),       error: document.getElementById('hpError'),       check: document.getElementById('hpCheck') },
            password: { input: document.getElementById('password'), border: document.getElementById('passwordBorder'), error: document.getElementById('passwordError'), check: null },
            konfirm:  { input: document.getElementById('konfirm'),  border: document.getElementById('konfirmBorder'),  error: document.getElementById('konfirmError'),  check: null },
        };

        const submitBtn     = document.getElementById('submitBtn');
        const strengthLabel = document.getElementById('strengthLabel');
        const bars          = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3')];

        // ── Helpers ───────────────────────────────────────────
        function setError(key, msg) {
            const f = fields[key];
            f.border.classList.remove('border-green-400');
            f.border.classList.add('border-red-400');
            f.error.textContent = msg;
            if (f.check) f.check.classList.add('hidden');
        }

        function setValid(key) {
            const f = fields[key];
            f.border.classList.remove('border-red-400');
            f.border.classList.add('border-green-400');
            f.error.textContent = '';
            if (f.check) f.check.classList.remove('hidden');
        }

        function setNeutral(key) {
            const f = fields[key];
            f.border.classList.remove('border-red-400', 'border-green-400');
            f.error.textContent = '';
            if (f.check) f.check.classList.add('hidden');
        }

        // ── Validators ────────────────────────────────────────
        function validateNama() {
            const v = fields.nama.input.value.trim();
            if (!v) { setError('nama', 'Nama lengkap tidak boleh kosong.'); return false; }
            if (v.length < 2) { setError('nama', 'Nama minimal 2 karakter.'); return false; }
            if (/[^a-zA-Z\s]/.test(v)) { setError('nama', 'Nama hanya boleh huruf dan spasi.'); return false; }
            setValid('nama'); return true;
        }

        function validateUsername() {
            const v = fields.username.input.value.trim();
            if (!v) { setError('username', 'Username tidak boleh kosong.'); return false; }
            if (v.length < 3) { setError('username', 'Username minimal 3 karakter.'); return false; }
            if (/\s/.test(v)) { setError('username', 'Username tidak boleh mengandung spasi.'); return false; }
            if (!/^[a-zA-Z0-9_.]+$/.test(v)) { setError('username', 'Hanya huruf, angka, titik, dan underscore.'); return false; }
            setValid('username'); return true;
        }

        function validateEmail() {
            const v = fields.email.input.value.trim();
            if (!v) { setError('email', 'Email tidak boleh kosong.'); return false; }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) { setError('email', 'Format email tidak valid. Contoh: kamu@gmail.com'); return false; }
            setValid('email'); return true;
        }

        function validateHp() {
            // Auto-format: hanya angka
            let v = fields.hp.input.value.replace(/\D/g, '');
            // Jika user ketik awalan 0, hapus
            if (v.startsWith('0')) v = v.slice(1);
            fields.hp.input.value = v;

            if (!v) { setError('hp', 'Nomor HP tidak boleh kosong.'); return false; }
            if (v.length < 8) { setError('hp', 'Nomor HP minimal 8 digit setelah +62.'); return false; }
            if (v.length > 13) { setError('hp', 'Nomor HP maksimal 13 digit.'); return false; }
            setValid('hp'); return true;
        }

        function getStrength(pw) {
            let score = 0;
            if (pw.length >= 8) score++;
            if (/[A-Z]/.test(pw)) score++;
            if (/[0-9]/.test(pw)) score++;
            if (/[^a-zA-Z0-9]/.test(pw)) score++;
            return score;
        }

        function updateStrengthBar(pw) {
            const score = getStrength(pw);
            const colors = ['#ef4444', '#f97316', '#22c55e'];
            const labels = ['', 'Lemah', 'Sedang', 'Kuat'];
            const labelColors = ['', 'text-red-400', 'text-orange-400', 'text-green-500'];

            bars.forEach((bar, i) => {
                if (pw.length === 0) {
                    bar.style.width = '0%';
                    bar.style.backgroundColor = '';
                } else if (i < Math.ceil(score / 4 * 3)) {
                    bar.style.width = '100%';
                    bar.style.backgroundColor = score <= 1 ? colors[0] : score <= 2 ? colors[1] : colors[2];
                } else {
                    bar.style.width = '0%';
                }
            });

            if (pw.length === 0) {
                strengthLabel.textContent = '';
                strengthLabel.className = 'block text-[10px] mt-0.5 pl-5 text-[#aaa]';
            } else {
                const lvl = score <= 1 ? 1 : score <= 2 ? 2 : 3;
                strengthLabel.textContent = 'Kekuatan password: ' + labels[lvl];
                strengthLabel.className = 'block text-[10px] mt-0.5 pl-5 ' + labelColors[lvl];
            }
        }

        function validatePassword() {
            const v = fields.password.input.value;
            updateStrengthBar(v);
            if (!v) { setError('password', 'Password tidak boleh kosong.'); return false; }
            if (v.length < 8) { setError('password', 'Password minimal 8 karakter.'); return false; }
            if (getStrength(v) < 2) { setError('password', 'Password terlalu lemah. Tambahkan huruf besar atau angka.'); return false; }
            setValid('password');
            // Re-validasi konfirmasi jika sudah diisi
            if (fields.konfirm.input.value) validateKonfirm();
            return true;
        }

        function validateKonfirm() {
            const v  = fields.konfirm.input.value;
            const pw = fields.password.input.value;
            if (!v) { setError('konfirm', 'Konfirmasi password tidak boleh kosong.'); return false; }
            if (v !== pw) { setError('konfirm', 'Password tidak cocok.'); return false; }
            setValid('konfirm'); return true;
        }

        // ── Check all & toggle submit ─────────────────────────
        function checkAll() {
            const ok = validateNama() && validateUsername() && validateEmail()
                    && validateHp() && validatePassword() && validateKonfirm();
            submitBtn.disabled = !ok;
        }

        // ── Event listeners ───────────────────────────────────
        fields.nama.input.addEventListener('input', () => { validateNama(); checkAll(); });
        fields.nama.input.addEventListener('blur',  () => { validateNama(); checkAll(); });

        fields.username.input.addEventListener('input', () => { validateUsername(); checkAll(); });
        fields.username.input.addEventListener('blur',  () => { validateUsername(); checkAll(); });

        fields.email.input.addEventListener('input', () => { validateEmail(); checkAll(); });
        fields.email.input.addEventListener('blur',  () => { validateEmail(); checkAll(); });

        fields.hp.input.addEventListener('input', () => { validateHp(); checkAll(); });
        fields.hp.input.addEventListener('blur',  () => { validateHp(); checkAll(); });

        fields.password.input.addEventListener('input', () => { validatePassword(); checkAll(); });
        fields.password.input.addEventListener('blur',  () => { validatePassword(); checkAll(); });

        fields.konfirm.input.addEventListener('input', () => { validateKonfirm(); checkAll(); });
        fields.konfirm.input.addEventListener('blur',  () => { validateKonfirm(); checkAll(); });

        // ── Toggle password visibility ────────────────────────
        document.getElementById('togglePw').addEventListener('click', () => {
            const inp = fields.password.input;
            const ico = document.getElementById('eyeIcon');
            inp.type  = inp.type === 'password' ? 'text' : 'password';
            ico.className = inp.type === 'password' ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
        });

        document.getElementById('toggleKonfirm').addEventListener('click', () => {
            const inp = fields.konfirm.input;
            const ico = document.getElementById('eyeKonfirmIcon');
            inp.type  = inp.type === 'password' ? 'text' : 'password';
            ico.className = inp.type === 'password' ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
        });

        // ── Old input dari server (validasi gagal) ────────────
        ['nama','username','email','hp'].forEach(key => {
            if (fields[key].input.value.trim() !== '') checkAll();
        });
    </script>

</body>
</html>