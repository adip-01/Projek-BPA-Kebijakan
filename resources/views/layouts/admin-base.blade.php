<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMKA Admin') - SIMKA Telkom University</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        slate: {
                            900: '#0f172a',
                            800: '#1e293b',
                            700: '#334155',
                            600: '#475569',
                            500: '#64748b',
                            400: '#94a3b8',
                            300: '#cbd5e1',
                            200: '#e2e8f0',
                            100: '#f1f5f9',
                        },
                        emerald: {
                            700: '#047857',
                            600: '#059669',
                            500: '#10b981',
                            400: '#34d399',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    @stack('styles')
</head>
<body class="bg-slate-900 text-slate-100 font-sans antialiased">
    
    @yield('content')

    @stack('scripts')
    
</body>
</html>