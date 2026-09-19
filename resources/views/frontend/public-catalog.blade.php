<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Courses | Loksewa Path</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-icon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-50 text-gray-900">
    <header class="landing-header">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="landing-brand flex items-center gap-2.5">
                <img src="{{ asset('images/logo.png') }}" alt="Loksewa LMS" style="width: 36px; height: 36px; border-radius: 10px; object-fit: cover; box-shadow: 0 2px 8px rgba(5, 150, 105, 0.25);">
                <span class="font-black text-slate-900 tracking-tight">Loksewa Path</span>
            </a>
            <nav class="flex items-center gap-3">
                <a href="{{ route('landing') }}" class="landing-nav-link">Home</a>
                <a href="{{ route('login') }}" class="landing-btn landing-btn-light">Sign In</a>
                <a href="{{ route('register') }}" class="landing-btn landing-btn-primary">Sign Up</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="public-page-hero">
            <div class="max-w-7xl mx-auto px-6">
                <p class="landing-kicker">Course catalog</p>
                <h1>Browse Loksewa preparation paths.</h1>
                <p>Preview available courses before signing in. Sign in when you are ready to enroll, track progress, and continue lessons.</p>

                <form action="{{ url('/catalog') }}" method="GET" class="public-search">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search courses by title or topic">
                    @if($search)
                        <a href="{{ url('/catalog') }}" aria-label="Clear search"><i data-lucide="x" class="w-4 h-4"></i></a>
                    @endif
                </form>
            </div>
        </section>

        <section class="landing-section landing-section-soft">
            <div class="max-w-7xl mx-auto px-6">
                <div class="landing-course-grid">
                    @forelse($courses as $course)
                        <article class="landing-course-card">
                            <div class="landing-course-media">
                                @if($course->thumbnail)
                                    <img src="{{ Str::startsWith($course->thumbnail, 'http') ? $course->thumbnail : Storage::url($course->thumbnail) }}" alt="{{ $course->title }}">
                                @else
                                    <div class="landing-course-fallback">{{ strtoupper(substr($course->title, 0, 1)) }}</div>
                                @endif
                            </div>
                            <div class="landing-course-body">
                                <div class="landing-course-meta">
                                    <i data-lucide="book-open" class="w-3 h-3"></i>
                                    Public Preview
                                </div>
                                <h3>{{ $course->title }}</h3>
                                <p>{{ Str::limit($course->description, 130) }}</p>
                                <a href="{{ route('courses.details', $course->slug) }}">
                                    View course
                                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="public-empty">
                            <i data-lucide="search-x" class="w-12 h-12"></i>
                            <h2>No courses found</h2>
                            <p>Try a different search term or return to the full catalog.</p>
                            <a href="{{ url('/catalog') }}" class="landing-btn landing-btn-primary">Clear Search</a>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $courses->links() }}
                </div>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/icons.js') }}"></script>
</body>
</html>
