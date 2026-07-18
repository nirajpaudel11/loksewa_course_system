@extends('layouts.lms')

@section('title', 'Certificates | Loksewa LMS')
@section('header', 'Your Achievements')

@section('content')
<div class="max-w-4xl mx-auto py-10 text-center">
    <div class="w-20 h-20 bg-emerald-50 rounded-3xl flex items-center justify-center text-emerald-600 mx-auto mb-8 shadow-sm">
        <i data-lucide="award" class="w-10 h-10"></i>
    </div>
    <h3 class="text-3xl font-black text-gray-900 mb-4 tracking-tight">Earn Your First Certificate</h3>
    <p class="text-gray-500 text-lg leading-relaxed mb-10 max-w-lg mx-auto">Complete any of our professional courses to receive a verified certificate that you can share with your network.</p>
    
    <a href="{{ url('/catalog') }}" class="inline-flex items-center gap-2 bg-gray-900 text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-xl hover:bg-black">
        Browse Courses
        <i data-lucide="arrow-right" class="w-4 h-4"></i>
    </a>
</div>
@endsection
