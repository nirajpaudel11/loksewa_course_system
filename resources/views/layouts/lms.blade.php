<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Loksewa Course LMS')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-icon.svg') }}">
    
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Custom Scrollbars */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex flex-col antialiased selection:bg-emerald-500 selection:text-white">

<div class="flex min-h-screen">
    <!-- Left Navigation Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-200/80 hidden md:flex flex-col shrink-0 sticky top-0 h-screen z-30 shadow-sm">
        <!-- Logo Branding -->
        <a href="{{ route('dashboard') }}" class="p-5 border-b border-slate-100 flex items-center gap-3 hover:bg-slate-50/80 transition-colors group">
            <img src="{{ asset('images/logo.png') }}" alt="Loksewa LMS" class="w-10 h-10 rounded-2xl object-cover shadow-md shadow-emerald-500/20 ring-1 ring-emerald-500/30 group-hover:scale-105 transition-transform">
            <div>
                <h1 class="text-base font-black text-slate-900 tracking-tight leading-none">Loksewa Path</h1>
                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">PSC Preparation</span>
            </div>
        </a>
        
        <!-- Navigation Links -->
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl transition-all {{ request()->is('dashboard') ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/25' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="layout-grid" class="w-4 h-4"></i>
                <span>Aspirant Dashboard</span>
            </a>
            <a href="{{ url('/catalog') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl transition-all {{ request()->is('catalog*') ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/25' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="book-open" class="w-4 h-4"></i>
                <span>Courses &amp; Syllabus</span>
            </a>
            <a href="{{ url('/analytics') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl transition-all {{ request()->is('analytics*') ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/25' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                <span>Study Velocity &amp; Pacing</span>
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-100 bg-slate-50/50 space-y-2">
            @auth
                @if(Auth::user()->hasRole('admin'))
                    <a href="{{ url('/admin') }}" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-xs font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-100 rounded-xl transition-all shadow-sm">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                        <span>Admin Panel</span>
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition-all">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            @else
                <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition-all shadow-md shadow-emerald-500/20">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    <span>Create Account</span>
                </a>
                <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-xs font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-100 rounded-xl transition-all">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    <span>Sign In</span>
                </a>
            @endauth
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Top App Bar Header -->
        <header class="bg-white border-b border-slate-200/80 h-16 flex items-center justify-between px-6 sm:px-8 shrink-0 z-20">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="md:hidden inline-flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Loksewa LMS" class="w-8 h-8 rounded-xl object-cover shadow-sm ring-1 ring-emerald-500/20">
                </a>
                <h2 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest">@yield('header', 'Dashboard')</h2>
            </div>
            
            <div class="flex items-center gap-3">
                @auth
                    <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-slate-900">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] font-extrabold text-emerald-600 uppercase tracking-wider">{{ Auth::user()->roles->first()->name ?? 'Aspirant' }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center font-bold text-xs shadow-sm shadow-emerald-500/20" aria-label="Profile">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-xl transition-all">Sign In</a>
                    <a href="{{ route('register') }}" class="text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 px-3.5 py-1.5 rounded-xl transition-all shadow-sm">Sign Up</a>
                @endauth
            </div>
        </header>

        <!-- Page Dynamic Content -->
        <main class="flex-1 overflow-y-auto p-6 sm:p-8 md:p-10">
            @yield('content')
        </main>
    </div>
</div>

<script>
    // Initialize Lucide Icons
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
        }
    });
</script>
</body>
</html>
