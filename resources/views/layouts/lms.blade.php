<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Loksewa Course LMS')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
        <div class="p-6">
            <h1 class="text-xl font-black text-emerald-600 tracking-tighter uppercase">Loksewa Path</h1>
        </div>
        
        <nav class="flex-1 px-4 space-y-1">
            <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->is('/') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i data-lucide="layout-grid" class="w-4 h-4"></i>
                Dashboard
            </a>
            <a href="{{ url('/catalog') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->is('catalog*') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i data-lucide="book-open" class="w-4 h-4"></i>
                Courses
            </a>
            <a href="{{ url('/analytics') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->is('analytics*') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                Analytics
            </a>
                {{-- Path Visualizer removed --}}
        </nav>

        <div class="p-4 border-t border-gray-100">
            @auth
                @if(Auth::user()->hasRole('admin'))
                    <a href="{{ url('/admin') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                        Admin Panel
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg mt-1">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        Sign Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-emerald-600 hover:bg-emerald-50 rounded-lg">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    Sign In
                </a>
            @endauth
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Top Header -->
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8">
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest">@yield('header', 'Dashboard')</h2>
            
            <div class="flex items-center gap-4">
                @auth
                    <div class="flex items-center gap-3 pl-4">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">{{ Auth::user()->roles->first()->name ?? 'User' }}</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=10b981&color=fff" class="w-8 h-8 rounded-full ring-2 ring-emerald-50 shadow-sm" alt="Profile">
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-700">Sign In to Continue &rarr;</a>
                @endauth
            </div>
        </header>

        <!-- Page Scrollable Area -->
        <div class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </div>
    </main>
</div>

<!-- Lucide Icon Initialization -->
<script>
    lucide.createIcons();
</script>
</body>
</html>
