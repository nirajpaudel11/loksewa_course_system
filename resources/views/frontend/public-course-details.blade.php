<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} | Loksewa Path</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-50 text-gray-900">
    <header class="landing-header">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="landing-brand">
                <span class="landing-brand-mark">LP</span>
                <span>Loksewa Path</span>
            </a>
            <nav class="flex items-center gap-3">
                <a href="{{ url('/catalog') }}" class="landing-nav-link">Courses</a>
                <a href="{{ route('login') }}" class="landing-btn landing-btn-primary">Sign In</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="public-course-hero">
            <div class="max-w-7xl mx-auto px-6 public-course-hero-grid">
                <div>
                    <a href="{{ url('/catalog') }}" class="landing-inline-link">
                        <i data-lucide="chevron-right" class="w-4 h-4 public-back-icon"></i>
                        Back to catalog
                    </a>
                    <p class="landing-kicker-dark mt-8">Course preview</p>
                    <h1>{{ $course->title }}</h1>
                    <p>{{ $course->description ?: 'Preview this Loksewa preparation course, then sign in to enroll and continue lessons.' }}</p>
                    <div class="landing-actions">
                        <a href="{{ route('login') }}" class="landing-btn landing-btn-primary landing-btn-lg">Sign In to Start</a>
                        <a href="{{ url('/catalog') }}" class="landing-btn landing-btn-dark landing-btn-lg">Browse More</a>
                    </div>
                </div>

                <aside class="public-course-summary">
                    <div>
                        <span>{{ $course->modules->count() }}</span>
                        <p>Modules</p>
                    </div>
                    <div>
                        <span>{{ $course->modules->sum(fn ($module) => $module->chapters->count()) }}</span>
                        <p>Chapters</p>
                    </div>
                    <div>
                        <span>{{ $course->modules->sum(fn ($module) => $module->chapters->sum(fn ($chapter) => $chapter->lessons->count())) }}</span>
                        <p>Lessons</p>
                    </div>
                </aside>
            </div>
        </section>

        <section class="landing-section">
            <div class="max-w-7xl mx-auto px-6 public-course-layout">
                <div>
                    <div class="landing-section-heading">
                        <div>
                            <p class="landing-kicker-dark">Curriculum preview</p>
                            <h2 class="landing-section-title">See what this path covers.</h2>
                        </div>
                    </div>

                    <div class="public-curriculum-list">
                        @forelse($course->modules as $module)
                            <article class="public-module-preview">
                                <h3>{{ $module->title }}</h3>
                                @foreach($module->chapters as $chapter)
                                    <div class="public-chapter-preview">
                                        <h4>{{ $chapter->title }}</h4>
                                        <ul>
                                            @foreach($chapter->lessons->take(4) as $lesson)
                                                <li>
                                                    <i data-lucide="{{ $lesson->type === 'quiz' ? 'help-circle' : 'file-text' }}" class="w-4 h-4"></i>
                                                    <span>{{ $lesson->title }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </article>
                        @empty
                            <div class="public-empty">
                                <i data-lucide="calendar" class="w-12 h-12"></i>
                                <h2>Curriculum coming soon</h2>
                                <p>This preparation path is being updated.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <aside class="public-signin-panel">
                    <h2>Ready to study?</h2>
                    <p>Sign in to enroll, open lessons, complete quizzes, and track your preparation progress.</p>
                    <a href="{{ route('login') }}" class="landing-btn landing-btn-primary landing-btn-lg">Student Sign In</a>
                </aside>
            </div>
        </section>

        @if($relatedCourses->isNotEmpty())
            <section class="landing-section landing-section-soft">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="landing-section-heading">
                        <div>
                            <p class="landing-kicker-dark">Related courses</p>
                            <h2 class="landing-section-title">Continue exploring similar preparation paths.</h2>
                        </div>
                    </div>
                    <div class="landing-course-grid">
                        @foreach($relatedCourses as $related)
                            <article class="landing-course-card">
                                <div class="landing-course-media">
                                    @if($related->thumbnail)
                                        <img src="{{ Str::startsWith($related->thumbnail, 'http') ? $related->thumbnail : Storage::url($related->thumbnail) }}" alt="{{ $related->title }}">
                                    @else
                                        <div class="landing-course-fallback">{{ strtoupper(substr($related->title, 0, 1)) }}</div>
                                    @endif
                                </div>
                                <div class="landing-course-body">
                                    <div class="landing-course-meta">Related</div>
                                    <h3>{{ $related->title }}</h3>
                                    <p>{{ Str::limit($related->description, 120) }}</p>
                                    <a href="{{ route('courses.details', $related->slug) }}">
                                        View course
                                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </main>

    <script src="{{ asset('js/icons.js') }}"></script>
</body>
</html>
