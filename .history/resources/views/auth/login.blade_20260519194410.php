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

<body class="bg-[#F0E6C8] min-h-screen flex items-center justify-center px-6">

    <div class="flex items-center gap-10 w-full max-w-5xl">

        {{-- KIRI: GAMBAR --}}
        <div class="hidden md:block w-[45%]">
            <img
                src="{{ asset('images/thrift-login.png') }}"
                alt="ThriftStop Fashion"
                class="w-full h-[420px] object-cover rounded-3xl shadow-2xl hover:scale-[1.02] transition duration-300"
            >
        </div>

        {{-- KANAN: CARD LOGIN --}}
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl w-full md:w-[55%] px-9 py-10">

            {{-- Branding --}}
            <h1 class="text-[26px] font-extrabold mb-1">
                <span class="text-orange-500">Thrift</span><span class="text-[#1a1a1a]">Stop</span>
            </h1>
            <p class="text-[11px] text-[#666] mb-6">
                Platform Marketplace Thrifting untuk UMKM Indonesia
            </p>

            <h2 class="text-[20px] font-semibold text-[#1a1a1a] mb-6">Log in</h2>

            {{-- Error --}}
            @if(session('error'))
                <div class="bg-red-50 text-red-600 px-4 py-2.5 rounded-lg text-[12px] mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form id="loginForm" action="{{ route('login') }}" method="POST" novalidate>
                @csrf

                {{-- Username --}}
                <div id="usernameBorder" class="flex items-center border-b border-[#bbb] mb-1 transition-colors duration-200">
                    <i class="fa-regular fa-user text-[#888] text-[13px] mr-3"></i>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="username"
                        value="{{ old('username') }}"
                        class="flex-1 bg-transparent py-2.5 text-[13px] text-[#1a1a1a] placeholder-[#aaa]"
                    >
                </div>
                <span id="usernameError" class="block text-[10px] text-red-500 min-h-[14px] mb-3 pl-7">
                    @error('username') {{ $message }} @enderror
                </span>

                {{-- Password --}}
                <div id="passwordBorder" class="flex items-center border-b border-[#bbb] mb-1 transition-colors duration-200">
                    <i class="fa-solid fa-lock text-[#888] text-[13px] mr-3"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="password"
                        class="flex-1 bg-transparent py-2.5 text-[13px]"
                    >
                    <button type="button" id="togglePw" class="text-[#aaa] ml-2">
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
                    class="w-full bg-orange-500 hover:bg-orange-600 disabled:bg-orange-200 text-white font-semibold text-[14px] py-3 rounded-lg mt-2 transition"
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
            if (val === '') return setError(usernameBorder, usernameError, 'Username tidak boleh kosong.');
            if (val.length < 3) return setError(usernameBorder, usernameError, 'Minimal 3 karakter.');
            if (/\s/.test(val)) return setError(usernameBorder, usernameError, 'Tidak boleh ada spasi.');
            return setValid(usernameBorder, usernameError);
        }

        function validatePassword() {
            const val = passwordInput.value;
            if (val === '') return setError(passwordBorder, passwordError, 'Password kosong.');
            if (val.length < 6) return setError(passwordBorder, passwordError, 'Minimal 6 karakter.');
            return setValid(passwordBorder, passwordError);
        }

        function setError(border, msgEl, msg) {
            border.classList.add('border-red-400');
            border.classList.remove('border-green-400');
            msgEl.textContent = msg;
            return false;
        }

        function setValid(border, msgEl) {
            border.classList.remove('border-red-400');
            border.classList.add('border-green-400');
            msgEl.textContent = '';
            return true;
        }

        function checkForm() {
            submitBtn.disabled = !(validateUsername() && validatePassword());
        }

        usernameInput.addEventListener('input', checkForm);
        passwordInput.addEventListener('input', checkForm);

        togglePw.addEventListener('click', () => {
            const hidden = passwordInput.type === 'password';
            passwordInput.type = hidden ? 'text' : 'password';
            eyeIcon.className = hidden ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
        });
    </script>

</body>
</html>