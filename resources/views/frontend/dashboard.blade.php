@extends('layouts.lms')

@section('title', 'Dashboard | Loksewa LMS')
@section('header', 'Overview')

@section('content')
<!-- Hero Welcome -->
<div class="bg-white rounded-2xl border border-gray-200 p-8 mb-8 flex flex-col lg:flex-row items-center justify-between shadow-sm">
    <div class="max-w-xl">
        <h3 class="text-2xl font-black text-gray-900 mb-2 tracking-tight">Ready for Loksewa, {{ explode(' ', Auth::user()->name ?? 'Learner')[0] }}?</h3>
        <p class="text-gray-500 leading-relaxed">Your preparation platform is live. We have matched you with the best courses for your career goals.</p>
    </div>
    <div class="flex gap-4 mt-6 lg:mt-0">
        <div class="text-center px-6 border-r border-gray-100">
            <p class="text-2xl font-black text-emerald-600">{{ $stats['total_students'] }}</p>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Students</p>
        </div>
        <div class="text-center px-6">
            <p class="text-2xl font-black text-emerald-600">{{ $stats['total_courses'] }}</p>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Courses</p>
        </div>
    </div>
</div>

<!-- Daily Motivation Quote -->
<div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-6 md:p-8 mb-8 text-white shadow-md relative overflow-hidden">
    <!-- Subtle Decorative Background Shape -->
    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
    <div class="absolute -left-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
    
    <div class="relative flex flex-col md:flex-row items-center gap-6">
        <div class="w-12 h-12 rounded-xl bg-white/25 flex items-center justify-center text-white shrink-0 shadow-inner animate-pulse">
            <i data-lucide="quote" class="w-6 h-6"></i>
        </div>
        <div class="text-center md:text-left">
            <p class="text-lg md:text-xl font-medium italic mb-2 leading-relaxed">
                "Success is the sum of small efforts, repeated day in and day out. Hard work is the bridge between your goals and your success."
            </p>
            <p class="text-xs font-bold text-emerald-100 tracking-wider uppercase">
                Daily Motivation &bull; Stay Focused
            </p>
        </div>
    </div>
</div>


<!-- All Courses -->
<div class="mb-10">
    <h4 class="text-lg font-bold text-gray-900 mb-6">Recent Courses</h4>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($courses->take(6) as $course)
            <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-5 hover:border-gray-300 transition-all shadow-sm">
                <img src="{{ Str::startsWith($course->thumbnail, 'http') ? $course->thumbnail : Storage::url($course->thumbnail) }}" class="w-20 h-20 rounded-lg object-cover" alt="">
                <div class="flex-1">
                    <h5 class="font-bold text-gray-900 mb-3 leading-tight">{{ $course->title }}</h5>
                    <a href="{{ url('/courses/' . $course->slug) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                        View Preparation Content
                        <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
