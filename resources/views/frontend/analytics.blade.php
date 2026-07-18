@extends('layouts.lms')

@section('title', 'Analytics | Loksewa LMS')
@section('header', 'Learning Analytics')

@section('content')
<div class="max-w-4xl mx-auto py-10 text-center">
    <div class="w-20 h-20 bg-emerald-50 rounded-3xl flex items-center justify-center text-emerald-600 mx-auto mb-8 shadow-sm">
        <i data-lucide="bar-chart-3" class="w-10 h-10"></i>
    </div>
    <h3 class="text-3xl font-black text-gray-900 mb-4 tracking-tight">Your Real-Time Progress</h3>
    <p class="text-gray-500 text-lg leading-relaxed mb-10 max-w-lg mx-auto">This dashboard reflects your personal interaction with the preparation materials. Admin actions are excluded to ensure your data is 100% accurate.</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-gray-50">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Enrolled Paths</p>
            <p class="text-3xl font-black text-gray-900">{{ $totalEnrollments }}</p>
            <p class="text-xs text-gray-400 mt-2">Active preparations</p>
        </div>
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-gray-50">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Completion Rate</p>
            <p class="text-3xl font-black text-emerald-600">{{ $completionRate }}%</p>
            <div class="w-full bg-gray-100 h-1.5 rounded-full mt-4 overflow-hidden">
                <div class="bg-emerald-500 h-full transition-all duration-1000" style="width: {{ $completionRate }}%"></div>
            </div>
        </div>
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-gray-50">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Lessons Finished</p>
            <p class="text-3xl font-black text-gray-900">{{ $completedLessonsCount }}</p>
            <p class="text-xs text-gray-400 mt-2">Total across all courses</p>
        </div>
    </div>

    <div class="mt-12 p-6 bg-emerald-50 rounded-2xl border border-emerald-100 inline-block">
        <p class="text-sm font-bold text-emerald-800 flex items-center gap-2">
            <i data-lucide="info" class="w-4 h-4"></i>
            Logic Check: These stats are calculated exclusively for your User ID.
        </p>
    </div>
</div>
@endsection
