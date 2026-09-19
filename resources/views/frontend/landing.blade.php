<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loksewa Path | Preparation Courses</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-icon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-50 text-gray-900">
    @php
        $heroCourse = $courses->first();
        $heroImage = $heroCourse?->thumbnail
            ? (Str::startsWith($heroCourse->thumbnail, 'http') ? $heroCourse->thumbnail : Storage::url($heroCourse->thumbnail))
            : null;
    @endphp

    <header class="landing-header">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="landing-brand flex items-center gap-2.5">
                <img src="{{ asset('images/logo.png') }}" alt="Loksewa LMS" style="width: 36px; height: 36px; border-radius: 10px; object-fit: cover; box-shadow: 0 2px 8px rgba(5, 150, 105, 0.25);">
                <span class="font-black text-slate-900 tracking-tight">Loksewa Path</span>
            </a>
            <nav class="flex items-center gap-3">
                <a href="{{ url('/catalog') }}" class="landing-nav-link">Courses</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="landing-btn landing-btn-dark">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="landing-btn landing-btn-light">Sign In</a>
                    <a href="{{ route('register') }}" class="landing-btn landing-btn-primary">Sign Up</a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        <section class="landing-hero" @if($heroImage) style="background-image: linear-gradient(90deg, rgba(7, 18, 29, .92), rgba(7, 18, 29, .72), rgba(7, 18, 29, .28)), url('{{ $heroImage }}')" @endif>
            <div class="landing-hero-inner">
                <p class="landing-kicker">Nepal public service preparation</p>
                <h1 class="landing-title">Prepare for Loksewa with a clear course path.</h1>
                <p class="landing-subtitle">
                    Browse structured preparation tracks, preview lessons and quizzes, then sign in to continue with progress tracking and recommendations.
                </p>
                <div class="landing-actions">
                    <a href="{{ route('register') }}" class="landing-btn landing-btn-primary landing-btn-lg">Create an Account</a>
                    <a href="{{ route('login') }}" class="landing-btn landing-btn-light landing-btn-lg">Student Sign In</a>
                    <a href="{{ url('/catalog') }}" class="landing-btn landing-btn-dark landing-btn-lg">Browse Courses</a>
                </div>
            </div>
        </section>

        <section class="landing-stats">
            <div class="max-w-7xl mx-auto px-6 landing-stats-grid">
                <div>
                    <p class="landing-stat-number">{{ $stats['total_courses'] }}</p>
                    <p class="landing-stat-label">Published courses</p>
                </div>
                <div>
                    <p class="landing-stat-number">{{ $stats['total_lessons'] }}</p>
                    <p class="landing-stat-label">Lessons and quizzes</p>
                </div>
                <div>
                    <p class="landing-stat-number">{{ $stats['total_students'] }}</p>
                    <p class="landing-stat-label">Registered students</p>
                </div>
            </div>
        </section>

        <section class="landing-section">
            <div class="max-w-7xl mx-auto px-6">
                <div class="landing-section-heading">
                    <div>
                        <p class="landing-kicker-dark">How learning works</p>
                        <h2 class="landing-section-title">Move from syllabus to practice without losing context.</h2>
                    </div>
                    <a href="{{ url('/catalog') }}" class="landing-inline-link">
                        Explore catalog
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <div class="landing-steps">
                    <div class="landing-step">
                        <span class="landing-step-icon"><i data-lucide="book-open" class="w-5 h-5"></i></span>
                        <h3>Choose a path</h3>
                        <p>Start from published courses matched to Loksewa preparation levels and subject areas.</p>
                    </div>
                    <div class="landing-step">
                        <span class="landing-step-icon"><i data-lucide="check-circle" class="w-5 h-5"></i></span>
                        <h3>Complete lessons</h3>
                        <p>Study ordered modules, chapters, lesson content, PDFs, and quizzes in one place.</p>
                    </div>
                    <div class="landing-step">
                        <span class="landing-step-icon"><i data-lucide="bar-chart-3" class="w-5 h-5"></i></span>
                        <h3>Track progress</h3>
                        <p>After sign in, your dashboard reveals enrollments, completion status, and next courses.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="landing-section landing-section-soft">
            <div class="max-w-7xl mx-auto px-6">
                <div class="landing-section-heading">
                <div>
                        <p class="landing-kicker-dark">Featured courses</p>
                        <h2 class="landing-section-title">Preview preparation paths before signing in.</h2>
                </div>
                    <a href="{{ url('/catalog') }}" class="landing-inline-link">
                    View full catalog
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            </div>

                <div class="landing-course-grid">
                @forelse($courses as $course)
                        <article class="landing-course-card">
                            <div class="landing-course-media">
                            @if($course->thumbnail)
                                    <img src="{{ Str::startsWith($course->thumbnail, 'http') ? $course->thumbnail : Storage::url($course->thumbnail) }}" alt="{{ $course->title }}">
                            @else
                                    <div class="landing-course-fallback">
                                    {{ strtoupper(substr($course->title, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                            <div class="landing-course-body">
                                <div class="landing-course-meta">
                                <i data-lucide="book-open" class="w-3 h-3"></i>
                                Open Access
                            </div>
                                <h3>{{ $course->title }}</h3>
                                <p>{{ Str::limit($course->description, 125) }}</p>
                                <a href="{{ route('courses.details', $course->slug) }}">
                                View course
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full bg-white border border-gray-200 rounded-2xl p-10 text-center">
                        <p class="text-gray-500 font-medium">Courses will appear here after they are published.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <script src="{{ asset('js/icons.js') }}"></script>
</body>
</html>
