<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThriftStop - Buyer</title>
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

    <div class="w-[45%] flex flex-col justify-center px-8 py-10">
        <h1 class="text-[36px] font-extrabold leading-tight">
            <span class="text-orange-500">Thrift</span><span class="text-black">Stop</span>
        </h1>
        <p class="text-[13px] text-[#555] mt-2 leading-relaxed">
            Platform Marketplace Thrifting untuk UMKM indonesia
        </p>
    </div>

    <div class="w-px bg-[#cfc3a5] my-8"></div>

    <div class="w-[55%] flex flex-col justify-center px-1 py-1">
        <div class="w-full flex flex-col justify-center px-9 py-10">
            <h2 class="text-[20px] font-semibold text-[#1a1a1a] mb-6">Login</h2>

            @if(session('error'))
                <div class="bg-red-50 text-red-600 px-4 py-2.5 rounded-lg text-[12px] mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-50 text-green-600 px-4 py-2.5 rounded-lg text-[11px] mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form id="loginForm" action="{{ route('login.post') }}" method="POST" novalidate>
                @csrf

                <div id="usernameBorder" class="flex items-center border-b border-[#000000] mb-1 transition-colors duration-200">
                    <i class="fa-regular fa-user text-[#000000] text-[13px] mr-2 shrink-0"></i>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="username"
                        value="{{ old('username') }}"
                        autocomplete="username"
                        class="flex-1 bg-transparent py-2.5 text-[13px] text-[#000000] placeholder-[#aaa] border-none ring-0 focus:ring-0"
                    >
                </div>
                <span id="usernameError" class="block text-[10px] text-red-500 min-h-[14px] mb-3 pl-5">
                    @error('username') {{ $message }} @enderror
                </span>

                <div id="passwordBorder" class="flex items-center border-b border-[#000000] mb-1 transition-colors duration-200">
                    <i class="fa-solid fa-lock text-[#000000] text-[13px] mr-2 shrink-0"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="password"
                        autocomplete="current-password"
                        class="flex-1 bg-transparent py-2.5 text-[13px] text-[#000000] placeholder-[#aaa] border-none ring-0 focus:ring-0"
                    >
                    <button type="button" id="togglePw" tabindex="-1" class="text-[#000000] text-[13px] hover:text-[#888] transition-colors ml-2">
                        <i class="fa-regular fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
                <span id="passwordError" class="block text-[10px] text-red-500 min-h-[14px] mb-3 pl-5">
                    @error('password') {{ $message }} @enderror
                </span>

                <button
                    type="submit"
                    id="submitBtn"
                    disabled
                    class="w-full bg-orange-500 hover:bg-orange-600 active:scale-[0.98] disabled:bg-orange-200 disabled:cursor-not-allowed text-white font-semibold text-[14px] py-3 rounded-lg mt-2 transition-all duration-200 tracking-wide"
                >
                    Login
                </button>
            </form>

                <p class="text-center text-[11px] text-[#888] mt-4">
                    Belum punya akun?
                    <a href="{{ route('register.buyer') }}" class="text-orange-500 font-semibold hover:underline">
                    Daftar sekarang
                    </a>
                </p>

                <div class="flex items-center gap-3 mt-5">
                    <div class="flex-1 h-px bg-[#cfc3a5]"></div>
                    <span class="text-[10px] text-[#000000]">atau masuk sebagai</span>
                    <div class="flex-1 h-px bg-[#cfc3a5]"></div>
                </div>

                <a href="{{ route('login.seller') }}"
                class="flex items-center justify-center gap-2 w-full mt-4 border border-[#cfc3a5] hover:border-orange-400 hover:text-orange-500 text-[#555] text-[13px] font-medium py-2.5 rounded-lg transition-all duration-200"
                >
                <i class="fa-solid fa-store text-[13px]"></i>
                Masuk sebagai Seller
                </a>
        </div>
        <script>
    const form = {
        username: {
            input: document.getElementById('username'),
            border: document.getElementById('usernameBorder'),
            error: document.getElementById('usernameError'),
            validate: (v) => {
                if (!v) return 'Username wajib diisi';
                if (v.length < 3) return 'Minimal 3 karakter';
                if (/\s/.test(v)) return 'Tidak boleh ada spasi';
                return '';
            }
        },

        password: {
            input: document.getElementById('password'),
            border: document.getElementById('passwordBorder'),
            error: document.getElementById('passwordError'),
            validate: (v) => {
                if (!v) return 'Password wajib diisi';
                if (v.length < 6) return 'Minimal 6 karakter';
                return '';
            }
        }
    };

    const submitBtn = document.getElementById('submitBtn');

    function validateField(field) {
        const value = field.input.value.trim();
        const message = field.validate(value);

        field.border.classList.remove('border-red-400', 'border-green-400');

        if (message) {
            field.border.classList.add('border-red-400');
            field.error.textContent = message;
            return false;
        }

        field.border.classList.add('border-green-400');
        field.error.textContent = '';
        return true;
    }

    function validateForm() {
        const valid = Object.values(form).every(validateField);
        submitBtn.disabled = !valid;
    }

    Object.values(form).forEach(field => {
        field.input.addEventListener('input', validateForm);
        field.input.addEventListener('blur', validateForm);
    });

    // Toggle password
    document.getElementById('togglePw').addEventListener('click', () => {
        const password = form.password.input;
        const icon = document.getElementById('eyeIcon');

        const hidden = password.type === 'password';

        password.type = hidden ? 'text' : 'password';
        icon.className = hidden
            ? 'fa-regular fa-eye-slash'
            : 'fa-regular fa-eye';
    });

    validateForm();
    </script>
</body>
</html>
