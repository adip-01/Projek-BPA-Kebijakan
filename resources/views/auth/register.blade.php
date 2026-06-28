<!DOCTYPE html>
<html lang="id" class="bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMKEB | Daftar</title>
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

        <div class="bg-white rounded-2xl shadow-lg p-8">

            {{-- Logo & Title --}}
            <div class="flex flex-col items-center mb-6">
                <div class="w-14 h-14 bg-red-800 rounded-lg flex items-center justify-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-lg font-bold text-red-800">SIMKEB</p>
            </div>

            <h1 class="text-2xl font-bold text-center text-gray-900 mt-2">Buat Akun Baru</h1>
            <p class="text-sm text-center text-gray-600 mb-8">Daftarkan diri Anda untuk mengakses sistem manajemen dokumen.</p>

            {{-- Error summary --}}
            @if($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 space-y-1">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap"
                               class="w-full pl-10 pr-4 py-3 bg-white text-gray-900 placeholder:text-gray-400 border border-gray-300 rounded-lg focus:outline-none focus:border-red-800 focus:ring-1 focus:ring-red-800 @error('name') border-red-400 @enderror">
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@mail.com"
                               class="w-full pl-10 pr-4 py-3 bg-white text-gray-900 placeholder:text-gray-400 border border-gray-300 rounded-lg focus:outline-none focus:border-red-800 focus:ring-1 focus:ring-red-800 @error('email') border-red-400 @enderror">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <input type="password" name="password" id="pw1" placeholder="Minimal 8 karakter"
                               class="w-full pl-10 pr-10 py-3 bg-white text-gray-900 placeholder:text-gray-400 border border-gray-300 rounded-lg focus:outline-none focus:border-red-800 focus:ring-1 focus:ring-red-800 @error('password') border-red-400 @enderror">
                        <button type="button" onclick="togglePw('pw1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <input type="password" name="password_confirmation" id="pw2" placeholder="Ulangi password Anda"
                               class="w-full pl-10 pr-10 py-3 bg-white text-gray-900 placeholder:text-gray-400 border border-gray-300 rounded-lg focus:outline-none focus:border-red-800 focus:ring-1 focus:ring-red-800">
                        <button type="button" onclick="togglePw('pw2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Terms --}}
                <div class="pt-2">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="agree_terms" class="w-4 h-4 accent-red-800 rounded mt-1 flex-shrink-0" required>
                        <span class="text-sm text-gray-600">
                            Saya menyetujui <span class="font-bold text-red-800">Syarat &amp; Ketentuan</span> serta
                            <span class="font-bold text-red-800">Kebijakan Privasi</span>
                        </span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full bg-red-800 text-white font-bold py-3 rounded-lg hover:bg-red-900 transition-colors mt-2">
                    DAFTAR SEKARANG
                </button>
            </form>

            <div class="h-px bg-gray-200 my-6"></div>

            <p class="text-center text-gray-600 text-sm">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-red-800 hover:text-red-900">Masuk di sini</a>
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
function togglePw(id) {
    const el = document.getElementById(id);
    el.type = el.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>
