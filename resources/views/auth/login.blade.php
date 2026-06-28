<!DOCTYPE html>
<html lang="id" class="bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMKEB | Masuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'red': {
                            50:  '#fef2f2',
                            100: '#fee2e2',
                            800: '#991b1b',
                            900: '#7f1d1d',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-slate-50">

<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md">

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-lg p-8">

            {{-- Icon --}}
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-red-800 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 7a2 2 0 012-2h3l2 2h9a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11v4m0 0l-1.5-1.5M12 15l1.5-1.5"/>
                    </svg>
                </div>
            </div>

            <h1 class="text-2xl font-bold text-center text-gray-900 mt-4">Selamat Datang Kembali</h1>
            <p class="text-sm text-center text-gray-500 mb-8">Masuk ke Sistem Manajemen Dokumen</p>

            {{-- Flash sukses (dari register) --}}
            @if(session('success'))
                <div class="mb-4 flex items-center gap-2 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error global --}}
            @if($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                {{-- Email --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@mail.com"
                               class="w-full pl-10 pr-4 py-3 bg-white text-gray-900 placeholder:text-gray-400 border border-gray-300 rounded-lg focus:outline-none focus:border-red-800 focus:ring-1 focus:ring-red-800 @error('email') border-red-400 @enderror">
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <input type="password" name="password" placeholder="••••••••" id="password-input"
                               class="w-full pl-10 pr-10 py-3 bg-white text-gray-900 placeholder:text-gray-400 border border-gray-300 rounded-lg focus:outline-none focus:border-red-800 focus:ring-1 focus:ring-red-800">
                        <button type="button" onclick="togglePw('password-input','eye-login')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg id="eye-login" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Remember & Forgot --}}
                <div class="flex justify-between items-center mb-6 mt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 accent-red-800 rounded">
                        <span class="text-sm text-gray-600">Ingat Saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm font-bold text-red-800 hover:text-red-900">
                        Lupa password?
                    </a>
                </div>

                <button type="submit"
                        class="w-full bg-red-800 text-white font-bold py-3 rounded-lg hover:bg-red-900 transition-colors mb-6">
                    MASUK
                </button>
            </form>

            <div class="h-px bg-gray-200 mb-6"></div>

            <p class="text-center text-gray-600 text-sm">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-bold text-red-800 hover:text-red-900">Daftar di sini</a>
            </p>
        </div>

        <div class="flex items-center justify-center gap-2 mt-8 text-xs text-gray-500">
            <div class="w-1 h-1 bg-gray-400 rounded-full"></div>
            <span>Secure Login | Encrypted</span>
            <div class="w-1 h-1 bg-gray-400 rounded-full"></div>
        </div>
    </div>
</div>

<script>
function togglePw(inputId, iconId) {
    const input = document.getElementById(inputId);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>
