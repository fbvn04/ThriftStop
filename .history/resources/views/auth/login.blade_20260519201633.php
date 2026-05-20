<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThriftStop</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Poppins', sans-serif; }
        input { outline: none !important; box-shadow: none !important; }
    </style>
</head>

<body class="bg-[#F1E0B4] min-h-screen flex items-center justify-center px-4 relative overflow-hidden">

    <div class="absolute -left-28 top-0 h-full w-[40%] overflow-hidden flex items-start justify-start">
        <img
            src="{{ asset('images/thrift-login.png') }}"
            alt="ThriftStop Fashion"
            class="w-full h-full object-contain object-top opacity-60 scale-110 -translate-y-6 -translate-x-6"
        >
    </div>

    <div class="bg-white/75 backdrop-blur-xxl rounded-3xl shadow-xl flex w-full max-w-[650px] overflow-hidden relative z-10">

    {{-- Kiri: Branding --}}
    <div class="w-[45%] flex flex-col justify-center px-8 py-10">
        <h1 class="text-[36px] font-extrabold leading-tight">
            <span class="text-orange-500">Thrift</span><span class="text-black">Stop</span>
        </h1>
        <p class="text-[13px] text-[#555] mt-2 leading-relaxed">
            Platform Marketplace Thrifting untuk UMKM indonesia
        </p>
    </div>

    {{-- Divider --}}
    <div class="w-px bg-[#cfc3a5] my-8"></div>

    {{-- Kanan: Form Login --}}
    <div class="w-[55%] flex flex-col justify-center px-9 py-10">
        
        <div class="w-full flex flex-col justify-center px-9 py-10">

            <h2 class="text-[20px] font-semibold text-[#1a1a1a] mb-6">Log in</h2>
  
            @if(session('error'))
                <div class="bg-red-50 text-red-600 px-4 py-2.5 rounded-lg text-[12px] mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form id="loginForm" action="{{ route('login') }}" method="POST" novalidate>
                @csrf

                {{-- Username --}}
                <div id="usernameBorder" class="flex items-center border-b border-[#000000] mb-1 transition-colors duration-200">
                    <i class="fa-regular fa-user text-[#000000] text-[13px] mr-3 shrink-0"></i>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="username"
                        value="{{ old('username') }}"
                        autocomplete="username"
                        class="flex-1 bg-transparent py-2.5 text-[13px] text-[#000000] placeholder-[#000000] border-none ring-0 focus:ring-0"
                    >
                </div>
                <span id="usernameError" class="block text-[10px] text-red-500 min-h-[14px] mb-3 pl-7">
                    @error('username') {{ $message }} @enderror
                </span>

                {{-- Password --}}
                <div id="passwordBorder" class="flex items-center border-b border-[#000000] mb-1 transition-colors duration-200">
                    <i class="fa-solid fa-lock text-[#000000] text-[13px] mr-3 shrink-0"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="password"
                        autocomplete="current-password"
                        class="flex-1 bg-transparent py-2.5 text-[13px] text-[#000000] placeholder-[#aaa] border-none ring-0 focus:ring-0"
                    >
                    <button type="button" id="togglePw" tabindex="-1" class="text-[#aaa] text-[13px] hover:text-[#888] transition-colors ml-2">
                        <i class="fa-regular fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
                <span id="passwordError" class="block text-[10px] text-red-500 min-h-[14px] mb-3 pl-7">
                    @error('password') {{ $message }} @enderror
                </span>

                {{-- Button --}}
                <button
                    type="submit"
                    id="submitBtn"
                    disabled
                    class="w-full bg-orange-500 hover:bg-orange-600 active:scale-[0.98] disabled:bg-orange-200 disabled:cursor-not-allowed text-white font-semibold text-[14px] py-3 rounded-lg mt-2 transition-all duration-200 tracking-wide"
                >
                    Login
                </button>
            </form>

            {{-- Register --}}
            <p class="text-center text-[11px] text-[#888] mt-4">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-orange-500 font-semibold hover:underline">
                    Daftar sekarang
                </a>
            </p>

        </div>
    </div>

    <script>
        const usernameInput  = document.getElementById('username');
        const passwordInput  = document.getElementById('password');
        const usernameError  = document.getElementById('usernameError');
        const passwordError  = document.getElementById('passwordError');
        const usernameBorder = document.getElementById('usernameBorder');
        const passwordBorder = document.getElementById('passwordBorder');
        const submitBtn      = document.getElementById('submitBtn');
        const togglePw       = document.getElementById('togglePw');
        const eyeIcon        = document.getElementById('eyeIcon');

        function validateUsername() {
            const val = usernameInput.value.trim();
            if (val === '') { setError(usernameBorder, usernameError, 'Username tidak boleh kosong.'); return false; }
            else if (val.length < 3) { setError(usernameBorder, usernameError, 'Username minimal 3 karakter.'); return false; }
            else if (/\s/.test(val)) { setError(usernameBorder, usernameError, 'Username tidak boleh mengandung spasi.'); return false; }
            setValid(usernameBorder, usernameError); return true;
        }

        function validatePassword() {
            const val = passwordInput.value;
            if (val === '') { setError(passwordBorder, passwordError, 'Password tidak boleh kosong.'); return false; }
            else if (val.length < 6) { setError(passwordBorder, passwordError, 'Password minimal 6 karakter.'); return false; }
            setValid(passwordBorder, passwordError); return true;
        }

        function setError(border, msgEl, msg) {
            border.classList.remove('border-green-400');
            border.classList.add('border-red-400');
            msgEl.textContent = msg;
        }

        function setValid(border, msgEl) {
            border.classList.remove('border-red-400');
            border.classList.add('border-green-400');
            msgEl.textContent = '';
        }

        function checkForm() {
            submitBtn.disabled = !(validateUsername() && validatePassword());
        }

        usernameInput.addEventListener('input', checkForm);
        passwordInput.addEventListener('input', checkForm);
        usernameInput.addEventListener('blur', checkForm);
        passwordInput.addEventListener('blur', checkForm);

        togglePw.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            eyeIcon.className  = isHidden ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
        });

        if (usernameInput.value.trim() !== '') checkForm();
    </script>

</body>
</html>