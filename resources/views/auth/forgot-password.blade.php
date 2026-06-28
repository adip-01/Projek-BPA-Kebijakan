<!DOCTYPE html>
<html lang="id" class="bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMKEB | Lupa Password</title>
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

            {{-- Icon --}}
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-red-800 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>

            <h1 class="text-2xl font-bold text-center text-gray-900 mt-4">Lupa Password?</h1>
            <p class="text-sm text-center text-gray-600 mb-8">
                Masukkan email yang terdaftar, kami akan mengirimkan tautan reset.
            </p>

            {{-- Success --}}
            @if(session('success'))
                <div class="mb-4 flex items-center gap-2 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@mail.com"
                               class="w-full pl-10 pr-4 py-3 bg-white text-gray-900 placeholder:text-gray-400 border border-gray-300 rounded-lg focus:outline-none focus:border-red-800 focus:ring-1 focus:ring-red-800">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-red-800 text-white font-bold py-3 rounded-lg hover:bg-red-900 transition-colors mb-4">
                    Kirim Link Reset
                </button>
            </form>

            <a href="{{ route('login') }}"
               class="w-full flex items-center justify-center gap-2 text-sm text-gray-600 hover:text-red-800 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Halaman Login
            </a>
        </div>

        <div class="flex items-center justify-center gap-2 mt-8 text-xs text-gray-500">
            <div class="w-1 h-1 bg-gray-400 rounded-full"></div>
            <span>Secure Login | Encrypted</span>
            <div class="w-1 h-1 bg-gray-400 rounded-full"></div>
        </div>
    </div>
</div>

</body>
</html>
