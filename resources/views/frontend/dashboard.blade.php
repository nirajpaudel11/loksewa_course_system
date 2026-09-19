@extends('layouts.lms')

@section('title', 'Dashboard | Loksewa LMS')
@section('header', 'Overview')

@section('content')
<!-- Hero Welcome & Overall Preparation Progress -->
<div class="bg-white rounded-3xl border border-gray-100 p-6 md:p-8 mb-8 shadow-sm">
    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 pb-6 border-b border-gray-100">
        <div class="max-w-xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-bold mb-3 border border-emerald-100">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Aspirant Learning Dashboard
            </div>
            <h3 class="text-2xl md:text-3xl font-black text-gray-900 mb-1.5 tracking-tight">Ready for Loksewa, {{ explode(' ', Auth::user()->name ?? 'Learner')[0] }}?</h3>
            <p class="text-gray-500 text-xs md:text-sm leading-relaxed">Your syllabus progress, completion timeline forecasts, and spaced repetition queues are active.</p>
        </div>
        <div class="flex items-center gap-3 sm:gap-6 flex-wrap">
            <div class="text-center px-4 md:px-6 border-r border-gray-100">
                <p class="text-2xl md:text-3xl font-black text-emerald-600">{{ $stats['my_enrollments'] }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Enrolled Tracks</p>
            </div>
            <div class="text-center px-4 md:px-6 border-r border-gray-100">
                <p class="text-2xl md:text-3xl font-black text-sky-600">{{ number_format($stats['pace_multiplier'] ?? 1.0, 2) }}×</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Study Velocity</p>
            </div>
            <div class="text-center px-4 md:px-6">
                <p class="text-2xl md:text-3xl font-black text-purple-600">{{ $stats['total_courses'] }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Courses</p>
            </div>
        </div>
    </div>

    <!-- Overall Course Completion Bar Widget -->
    @php
        $overallPct = $stats['overall_completion_rate'] ?? 0;
    @endphp
    <div class="pt-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-bold text-xs shadow-md shadow-emerald-100">
                    <i data-lucide="award" class="w-4 h-4"></i>
                </div>
                <div>
                    <span class="text-sm font-extrabold text-gray-900 tracking-tight">Overall Preparation Progress</span>
                    <span class="text-xs text-gray-500 block sm:inline sm:ml-2">({{ $stats['total_completed_lessons'] ?? 0 }} of {{ $stats['total_enrolled_lessons'] ?? 0 }} lessons completed)</span>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-black text-emerald-800 bg-emerald-100 px-3.5 py-1 rounded-full border border-emerald-300 shadow-sm">
                    {{ $overallPct }}% Complete
                </span>
            </div>
        </div>

        <!-- High-Visibility Styled Progress Track -->
        <div style="width: 100%; height: 26px; background: #e2e8f0; border-radius: 9999px; padding: 3px; border: 1.5px solid #cbd5e1; box-shadow: inset 0 2px 4px rgba(0,0,0,0.08); position: relative; overflow: hidden;">
            <div style="height: 100%; width: {{ max(3, min(100, $overallPct)) }}%; background: linear-gradient(90deg, #10b981 0%, #059669 60%, #047857 100%); border-radius: 9999px; transition: width 1s ease-in-out; display: flex; align-items: center; justify-content: flex-end; padding-right: 8px; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.4);">
                @if($overallPct >= 12)
                    <span style="color: #ffffff; font-size: 11px; font-weight: 900; letter-spacing: 0.5px; text-shadow: 0 1px 2px rgba(0,0,0,0.4);">{{ $overallPct }}%</span>
                @endif
            </div>
        </div>

        <!-- Segmented Steps Representation [ ■ ■ ■ ■ ■ ■ ■ □ ] -->
        <!-- <div class="grid grid-cols-10 gap-1.5 mt-2.5">
            @for($seg = 1; $seg <= 10; $seg++)
                @php
                    $segActive = ($seg * 10) <= ($overallPct + 5);
                @endphp
                <div class="h-1.5 rounded-full {{ $segActive ? 'bg-emerald-500 shadow-sm' : 'bg-slate-200' }}"></div>
            @endfor
        </div> -->
    </div>
</div>

<!-- Daily Motivation Quote Banner with Stunning Himalayan Background -->
<div class="rounded-3xl p-6 md:p-8 mb-8 text-white shadow-xl relative overflow-hidden border border-slate-700/50"
     style="background-image: linear-gradient(135deg, rgba(15, 23, 42, 0.88) 0%, rgba(6, 78, 59, 0.80) 50%, rgba(15, 23, 42, 0.92) 100%), url('{{ asset('images/dashboard-mantra-bg.jpg') }}'); background-size: cover; background-position: center;">
    
    <div class="relative flex flex-col md:flex-row items-center gap-5 md:gap-6 z-10">
        <div class="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-md border border-white/20 flex items-center justify-center text-amber-300 shrink-0 shadow-lg">
            <i data-lucide="sparkles" class="w-7 h-7"></i>
        </div>
        <div class="text-center md:text-left flex-1">
            <div class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-emerald-500/30 border border-emerald-400/40 text-[10px] font-extrabold uppercase tracking-widest text-emerald-200 mb-2">
                <span>🏔️ Loksewa Success Mantra</span>
                <span>&bull;</span>
                <span>Daily Motivation</span>
            </div>
            <p class="text-base md:text-xl font-bold italic mb-1.5 leading-relaxed text-white drop-shadow-md">
                "निरन्तर अभ्यास र धैर्यता नै लोकसेवा सफलताको मूल मन्त्र हो। हरेक दिनको अध्ययनले तपाईंलाई लक्ष्यको नजिक पुर्याउँछ।"
            </p>
            <p class="text-xs font-semibold text-emerald-200/90 tracking-wide uppercase">
                Continuous practice &amp; perseverance &bull; Small daily efforts build civil service success
            </p>
        </div>
    </div>
</div>

<!-- Spaced Repetition (SM-2): Courses & Lessons Due for Review -->
<!-- Spaced Repetition (SM-2): Courses & Lessons Due for Review -->
@if(isset($dueReviews) && $dueReviews->isNotEmpty())
    <div class="mb-10 p-6 md:p-8 bg-gradient-to-r from-amber-950 via-slate-900 to-slate-900 text-white rounded-3xl border border-amber-500/30 shadow-xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-500/20 border border-amber-500/30 text-amber-400 flex items-center justify-center font-black">
                    <i data-lucide="brain-circuit" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-extrabold uppercase tracking-widest mb-1 border border-amber-400/30">
                        <span>SuperMemo SM-2 Active</span>
                        <span>&bull;</span>
                        <span>{{ $dueReviews->count() }} Due {{ Str::plural('Lesson', $dueReviews->count()) }}</span>
                    </div>
                    <h4 class="text-xl font-black text-white tracking-tight">Courses &amp; Lessons Due for Review</h4>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('flashcards.due') }}" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs transition-all shadow-md flex items-center gap-1.5">
                    <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                    <span>Review All Due Flashcards ({{ $dueReviews->count() }})</span>
                </a>
            </div>
        </div>

        @if(isset($dueCourses) && $dueCourses->isNotEmpty())
            <!-- Due Courses Flashcard Banners -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                @foreach($dueCourses as $dueGroup)
                    @php
                        $c = $dueGroup['course'];
                    @endphp
                    @if($c)
                        <div class="p-4 rounded-2xl bg-slate-800/90 border border-amber-500/40 flex items-center justify-between gap-4">
                            <div>
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-400">Course Due for Retention Review</span>
                                <h5 class="text-sm font-bold text-white">{{ $c->title }}</h5>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $dueGroup['due_count'] }} {{ Str::plural('lesson', $dueGroup['due_count']) }} ready for review &bull; 1 MCQ/lesson</p>
                            </div>
                            <a href="{{ route('courses.flashcards', [$c->slug, 'mode' => 'due']) }}" class="shrink-0 px-3.5 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 font-black text-xs transition-all shadow-sm flex items-center gap-1.5">
                                <i data-lucide="zap" class="w-3.5 h-3.5"></i>
                                <span>Review Flashcards</span>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($dueReviews as $dueProgress)
                @php
                    $dueLesson = $dueProgress->lesson;
                    $dueCourse = $dueLesson?->course;
                @endphp
                @if($dueLesson && $dueCourse)
                    <div class="bg-slate-800/80 border border-slate-700/70 rounded-2xl p-4 flex flex-col justify-between hover:border-amber-500/50 transition-all">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 truncate max-w-[180px]">
                                    {{ $dueCourse->title }}
                                </span>
                                <span class="text-[10px] font-bold text-amber-400">
                                    {{ $dueProgress->next_review_date ? \Carbon\Carbon::parse($dueProgress->next_review_date)->diffForHumans() : 'Due today' }}
                                </span>
                            </div>
                            <h5 class="text-sm font-bold text-white mb-1.5 line-clamp-1">{{ $dueLesson->title }}</h5>
                            <div class="flex items-center gap-2 text-[11px] text-slate-400 mb-3">
                                <span>Reps: <strong class="text-slate-200">{{ $dueProgress->repetitions ?? 0 }}</strong></span>
                                <span>&bull;</span>
                                <span>Ease: <strong class="text-slate-200">{{ number_format($dueProgress->easiness_factor ?? 2.5, 2) }}</strong></span>
                            </div>
                        </div>
                        <a href="{{ route('lessons.show', [$dueCourse->slug, $dueLesson->slug]) }}" class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-xl bg-slate-700 hover:bg-slate-600 text-slate-200 hover:text-white font-bold text-xs transition-all shadow-sm">
                            <i data-lucide="rotate-cw" class="w-3.5 h-3.5"></i>
                            <span>Review Full Lesson</span>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif

<!-- Learning Pacing & Exam Readiness Section -->
<div class="mb-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6">
        <div>
            <div class="flex items-center gap-2">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></div>
                <h4 class="text-xl font-black text-gray-900 tracking-tight">Learning Pacing &amp; Exam Readiness Forecast</h4>
            </div>
            <p class="text-xs text-gray-500 mt-0.5">Calculated by Historical Pace Extrapolation &bull; Automatically updates every time you complete a lesson</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full">
                Personal Pace: <strong>{{ number_format($stats['pace_multiplier'] ?? 1.0, 2) }}×</strong>
                @if(($stats['pace_multiplier'] ?? 1.0) < 0.9)
                    (Fast Track 🚀)
                @elseif(($stats['pace_multiplier'] ?? 1.0) <= 1.1)
                    (Balanced ⏱️)
                @else
                    (Thorough 📚)
                @endif
            </span>
        </div>
    </div>

    @if(isset($enrolledPacing) && count($enrolledPacing) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($enrolledPacing as $item)
                @php
                    $pct = $item['progress_percentage'] ?? ($item['enrollment']->progress_percentage ?? 0);
                    $isFinished = $item['remaining_lessons'] === 0 || $pct >= 100;
                @endphp
                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <!-- Header row -->
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div>
                                <h5 class="font-bold text-base text-gray-900 leading-tight mb-1">{{ $item['course']->title }}</h5>
                                <span class="text-[11px] font-semibold text-gray-400">
                                    {{ $item['completed_lessons'] }} of {{ $item['total_lessons'] }} lessons completed
                                </span>
                            </div>
                            @if(($item['enrollment']->status ?? 'active') === 'pending')
                                <span class="px-3 py-1 bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold rounded-full flex items-center gap-1">
                                    <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-600"></i>
                                    Pending Approval ⏳
                                </span>
                            @elseif($isFinished)
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full border border-emerald-300">
                                    Completed 🎉
                                </span>
                            @elseif($item['predicted_date'])
                                <span class="px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-full flex items-center gap-1">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-sky-600"></i>
                                    Est. Finish: {{ $item['predicted_date']->format('M d, Y') }}
                                </span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full">
                                    Pacing Calibrating...
                                </span>
                            @endif
                        </div>

                        <!-- High-Visibility Course Progress Bar -->
                        <div class="space-y-2 mb-5">
                            <div class="flex justify-between items-center text-xs font-bold text-gray-700">
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full {{ $pct > 0 ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
                                    Course Completion
                                </span>
                                <span class="font-black text-xs {{ $pct >= 100 ? 'text-emerald-700' : ($pct > 0 ? 'text-emerald-600' : 'text-gray-500') }}">
                                    {{ $pct }}%
                                </span>
                            </div>

                            <!-- Styled Progress Bar Container with Explicit CSS -->
                            <div style="width: 100%; height: 22px; background: #e2e8f0; border-radius: 9999px; padding: 2.5px; border: 1.5px solid #cbd5e1; box-shadow: inset 0 2px 4px rgba(0,0,0,0.08); position: relative; overflow: hidden;">
                                <div style="height: 100%; width: {{ max(3, min(100, $pct)) }}%; background: linear-gradient(90deg, #10b981 0%, #059669 100%); border-radius: 9999px; transition: width 0.8s ease-in-out; display: flex; align-items: center; justify-content: flex-end; padding-right: 6px; box-shadow: 0 1px 4px rgba(16, 185, 129, 0.4);">
                                    @if($pct >= 15)
                                        <span style="color: #ffffff; font-size: 10px; font-weight: 900; letter-spacing: 0.5px; text-shadow: 0 1px 2px rgba(0,0,0,0.4);">{{ $pct }}%</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Mini Segmented Ticks [ ■ ■ ■ ■ ■ ■ □ □ ] -->
                            <div class="grid grid-cols-8 gap-1 pt-1">
                                @for($tick = 1; $tick <= 8; $tick++)
                                    @php
                                        $tickActive = ($tick * 12.5) <= ($pct + 6);
                                    @endphp
                                    <div class="h-1 rounded-full {{ $tickActive ? 'bg-emerald-500' : 'bg-slate-200' }}"></div>
                                @endfor
                            </div>
                        </div>

                        <!-- Pacing Metric Pills -->
                        <div class="grid grid-cols-2 gap-3 mb-6 text-xs">
                            <div class="p-3 bg-gray-50 rounded-2xl border border-gray-100">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-0.5">Remaining Content</span>
                                <span class="font-bold text-gray-900">{{ $item['remaining_lessons'] }} Lessons</span>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-2xl border border-gray-100">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-0.5">Study Multiplier</span>
                                <span class="font-bold text-emerald-600">{{ number_format($item['pace_multiplier'], 2) }}× pace</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-2 border-t border-gray-50">
                        @if(($item['enrollment']->status ?? 'active') === 'pending')
                            <a href="{{ url('/courses/' . $item['course']->slug) }}" class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs transition-all shadow-sm">
                                <span>Awaiting Admin Verification</span>
                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                            </a>
                        @else
                            <a href="{{ url('/courses/' . $item['course']->slug) }}" class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-2xl bg-gray-900 hover:bg-emerald-600 text-white font-bold text-xs transition-all shadow-sm">
                                <span>{{ $isFinished ? 'Review Completed Syllabus' : 'Resume Preparation' }}</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="p-8 bg-white rounded-3xl border border-gray-100 text-center shadow-sm">
            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mx-auto mb-3">
                <i data-lucide="book-open" class="w-6 h-6"></i>
            </div>
            <h5 class="font-bold text-gray-900 text-base mb-1">No Active Enrollments Yet</h5>
            <p class="text-xs text-gray-500 max-w-sm mx-auto mb-4">Enroll in a Loksewa preparation course to activate your personalized completion calendar and pacing velocity.</p>
            <a href="{{ route('courses.catalog') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 transition-all shadow-sm">
                <span>Browse Preparation Catalog</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    @endif
</div>

<!-- Recommended & Available Courses -->
<div class="mb-10">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h4 class="text-xl font-black text-gray-900 tracking-tight">Explore More Loksewa Tracks</h4>
            <p class="text-xs text-gray-500">Curated civil service and banking exam preparation modules</p>
        </div>
        <a href="{{ route('courses.catalog') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
            <span>View Full Catalog</span>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($courses->take(6) as $course)
            <div class="bg-white rounded-3xl border border-gray-100 p-5 flex items-center gap-4 hover:border-emerald-200 hover:shadow-md transition-all shadow-sm">
                @if($course->thumbnail)
                    <img src="{{ Str::startsWith($course->thumbnail, 'http') ? $course->thumbnail : Storage::url($course->thumbnail) }}" class="w-16 h-16 rounded-2xl object-cover shrink-0" alt="{{ $course->title }}">
                @else
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-black text-2xl shrink-0">
                        {{ strtoupper(substr($course->title, 0, 1)) }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h5 class="font-bold text-gray-900 text-sm truncate mb-1">{{ $course->title }}</h5>
                    <a href="{{ url('/courses/' . $course->slug) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1">
                        <span>Course Details</span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
