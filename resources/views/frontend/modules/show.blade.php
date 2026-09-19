@extends('layouts.lms')

@section('title', $module->title . ' | ' . $course->title)
@section('header', 'Module Learning')

@section('content')
<div class="max-w-7xl mx-auto pb-16">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-medium text-gray-400 mb-6 flex-wrap">
        <a href="{{ route('courses.catalog') }}" class="hover:text-emerald-600 transition-colors">Catalog</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
        <a href="{{ route('courses.details', $course->slug) }}" class="hover:text-emerald-600 transition-colors">{{ $course->title }}</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
        <span class="text-gray-900 font-bold">{{ $module->title }}</span>
    </nav>

    <!-- Feedback Alerts -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-sm">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 shrink-0"></i>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- 1. COURSE MASTER SYLLABUS PDF BANNER (Outside Module Content) -->
    @if($courseSyllabusUrl)
        <div class="mb-8 p-6 bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-950 text-white rounded-3xl border border-slate-700/80 shadow-lg relative overflow-hidden">
            <div class="flex items-start gap-4 mb-5">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center shrink-0 shadow-inner mt-0.5">
                    <i data-lucide="file-text" class="w-6 h-6"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/30 border border-emerald-400/40 text-[9px] font-extrabold uppercase tracking-widest text-emerald-200 mb-1.5">
                        <span>Official Master Curriculum</span>
                    </div>
                    <h4 class="text-base md:text-lg font-bold text-white leading-snug">Course Syllabus Document: {{ $course->title }}</h4>
                    <p class="text-xs md:text-sm text-slate-300 mt-1 leading-relaxed">Download or preview the complete Loksewa Public Service Commission syllabus specifications.</p>
                </div>
            </div>
            <div class="pt-4 border-t border-slate-700/60 flex flex-wrap items-center gap-3">
                <a href="{{ $courseSyllabusUrl }}" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-100 border border-slate-600 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-sm">
                    <i data-lucide="external-link" class="w-4 h-4 text-emerald-400"></i>
                    <span>Open Syllabus</span>
                </a>
                <a href="{{ $courseSyllabusUrl }}" download class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-md">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    <span>Download PDF</span>
                </a>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Learning Content Area (3 Cols) -->
        <div class="lg:col-span-3 space-y-8">

            <!-- Module Header Card -->
            <div class="bg-white rounded-3xl border border-gray-100 p-6 md:p-8 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                    <span class="px-3.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-black uppercase tracking-wider">
                        Module {{ $module->order ?? 1 }} &bull; {{ $course->title }}
                    </span>
                    @if($predictedCompletion)
                        <span class="text-xs text-sky-700 bg-sky-50 border border-sky-200 px-3 py-1 rounded-full font-bold flex items-center gap-1">
                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                            Predicted Finish: {{ $predictedCompletion->format('M d, Y') }}
                        </span>
                    @endif
                </div>

                <h1 class="text-2xl md:text-3xl font-black text-gray-900 mb-3 tracking-tight">{{ $module->title }}</h1>
                @if($module->description)
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $module->description }}</p>
                @endif
            </div>

            <!-- 2. KEY POINTS TO FOCUS ON (Admin Space) -->
            @if(!empty($module->key_points))
                <div class="bg-gradient-to-br from-amber-500/10 via-amber-50 to-orange-50/60 border-2 border-amber-200/90 rounded-3xl p-6 md:p-8 shadow-sm relative overflow-hidden">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-amber-200">
                            <i data-lucide="pin" class="w-6 h-6 rotate-45"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-lg font-black text-amber-950 tracking-tight">Key Points to Focus On</h3>
                                <span class="text-[10px] font-black uppercase tracking-widest bg-amber-200/80 text-amber-900 px-2.5 py-0.5 rounded-full">High Yield</span>
                            </div>
                            <p class="text-xs text-amber-800/90 mb-4 font-medium">Critical exam takeaways, formulas, legal articles, and revision tips recommended for this module.</p>
                            
                            <div class="bg-white/80 backdrop-blur rounded-2xl p-5 border border-amber-200/70 text-sm text-gray-800 space-y-2.5 leading-relaxed font-medium">
                                {!! nl2br(e($module->key_points)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- 3. MODULE STUDY PDF VIEWER -->
            <div class="bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl">
                <!-- PDF Toolbar -->
                <div class="bg-gray-950/95 backdrop-blur border-b border-gray-800 px-6 py-4 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-rose-500/15 border border-rose-500/30 text-rose-400 flex items-center justify-center shrink-0">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-100">{{ isset($primaryPdfLesson) && $primaryPdfLesson ? $primaryPdfLesson->title : $module->title }} — Study Document</h4>
                            <span class="text-[11px] text-gray-400 font-medium">{{ isset($primaryPdfLesson) && $primaryPdfLesson ? 'Lesson PDF: ' . $primaryPdfLesson->title : 'Official Loksewa Module Reference Material' }}</span>
                        </div>
                    </div>
                    @if($modulePdfUrl)
                        <div class="flex items-center gap-2">
                            <a href="{{ $modulePdfUrl }}" target="_blank" rel="noopener noreferrer" class="px-3.5 py-1.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-200 text-xs font-semibold flex items-center gap-1.5 transition-colors border border-gray-700 shadow-sm" title="Open in Full Window">
                                <i data-lucide="external-link" class="w-3.5 h-3.5 text-emerald-400"></i>
                                <span>Open Tab</span>
                            </a>
                            <a href="{{ $modulePdfUrl }}" download class="px-4 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold flex items-center gap-1.5 transition-colors shadow-sm">
                                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                <span>Download PDF</span>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- PDF Embedded Viewport -->
                @if($modulePdfUrl)
                    <div class="w-full h-[650px] md:h-[750px] bg-gray-950 relative">
                        <iframe 
                            src="{{ $modulePdfUrl }}#toolbar=1&navpanes=0&scrollbar=1" 
                            class="w-full h-full border-0" 
                            title="{{ $module->title }} PDF Notes"
                            loading="lazy">
                        </iframe>
                    </div>

                    <!-- PDF Footer Quick Actions -->
                    <div class="bg-gray-950 px-6 py-3 border-t border-gray-800/80 flex flex-wrap items-center justify-between text-xs text-gray-400 gap-2">
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
                            <span>Complete syllabus coverage for Loksewa civil service examination</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-[11px] text-gray-500">Trouble viewing in frame?</span>
                            <a href="{{ $modulePdfUrl }}" target="_blank" class="text-emerald-400 hover:underline font-semibold">Open directly in browser</a>
                        </div>
                    </div>
                @else
                    <div class="p-12 text-center text-gray-400">
                        <i data-lucide="file-question" class="w-12 h-12 text-gray-600 mx-auto mb-3"></i>
                        <h5 class="font-bold text-gray-200 text-sm mb-1">No Dedicated Module PDF Attached Yet</h5>
                        <p class="text-xs text-gray-500 max-w-sm mx-auto">Please refer to the course syllabus PDF or study notes below.</p>
                    </div>
                @endif
            </div>

            <!-- 4. DETAILED STUDY NOTES -->
            @if(!empty($module->notes))
                <div class="bg-white rounded-3xl border border-gray-100 p-6 md:p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                            <i data-lucide="book-open" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900 tracking-tight">Theoretical Study Notes</h3>
                            <p class="text-xs text-gray-500">In-depth concepts, legal definitions, and theoretical breakdowns</p>
                        </div>
                    </div>
                    <div class="prose max-w-none text-gray-700 text-sm leading-relaxed space-y-4">
                        {!! nl2br(e($module->notes)) !!}
                    </div>
                </div>
            @endif

            <!-- 5. INTERACTIVE MODULE PRACTICE QUIZ (WITH HINTS & INSTANT FEEDBACK) -->
            @if(!empty($quizQuestions) && count($quizQuestions) > 0)
                <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl p-6 md:p-8 text-white select-none" id="module-quiz-hub">
                    <!-- Quiz Header -->
                    <div class="flex items-center justify-between border-b border-slate-800 pb-5 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">
                                <i data-lucide="help-circle" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white">Module Practice Test</h3>
                                <p class="text-xs text-slate-400">{{ count($quizQuestions) }} Questions with Clues &amp; Real-time Verification</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span id="quiz-q-counter" class="text-xs font-bold text-slate-400">Question 1 of {{ count($quizQuestions) }}</span>
                            <div class="w-28 bg-slate-800 h-2 rounded-full overflow-hidden mt-1.5">
                                <div id="quiz-progress-fill" class="h-full bg-emerald-500 rounded-full transition-all duration-300" style="width: {{ round(100 / count($quizQuestions)) }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Question Container -->
                    <div id="quiz-active-view">
                        <!-- Question Text -->
                        <div class="mb-5">
                            <h4 id="q-prompt" class="text-base md:text-xl font-bold text-white leading-snug"></h4>
                        </div>

                        <!-- Hint Toggle & Box -->
                        <div class="mb-5" id="hint-wrapper">
                            <button type="button" onclick="toggleHint()" id="hint-toggle-btn" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-amber-500/15 border border-amber-400/30 text-amber-300 hover:bg-amber-500/25 transition-all text-xs font-bold shadow-sm">
                                <i data-lucide="lightbulb" class="w-3.5 h-3.5 text-amber-400"></i>
                                <span>Need a Hint? 💡</span>
                            </button>
                            <div id="hint-box" class="hidden mt-3 p-4 rounded-2xl bg-amber-950/40 border border-amber-500/40 text-amber-200 text-xs leading-relaxed flex items-start gap-2.5">
                                <i data-lucide="info" class="w-4 h-4 text-amber-400 shrink-0 mt-0.5"></i>
                                <span id="hint-text"></span>
                            </div>
                        </div>

                        <!-- 4 Interactive Option Buttons -->
                        <div id="options-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 mb-6">
                            <!-- Injected dynamically -->
                        </div>

                        <!-- Explanation & Verification Box -->
                        <div id="feedback-box" class="hidden mb-6 p-5 rounded-2xl border transition-all space-y-2">
                            <div class="flex items-center gap-2" id="feedback-status-line">
                                <!-- Injected dynamically: checkmark or cross -->
                            </div>
                            <div class="text-xs leading-relaxed text-slate-300 pt-2 border-t border-slate-700/50" id="feedback-explanation">
                                <!-- Explanation text -->
                            </div>
                        </div>

                        <!-- Bottom Controls -->
                        <div class="flex items-center justify-between pt-4 border-t border-slate-800">
                            <div class="text-xs text-slate-400 font-medium">
                                Score: <strong id="score-counter" class="text-emerald-400 text-sm">0</strong> / {{ count($quizQuestions) }}
                            </div>
                            <button type="button" id="next-q-btn" onclick="nextQuestion()" class="hidden px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl flex items-center gap-1.5 transition-all shadow-md">
                                <span>Next Question</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Quiz Completed Summary View -->
                    <div id="quiz-summary-view" class="hidden text-center py-8">
                        <div class="w-16 h-16 rounded-3xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="award" class="w-8 h-8 animate-bounce"></i>
                        </div>
                        <h3 class="text-2xl font-black text-white mb-2">Practice Quiz Completed!</h3>
                        <p class="text-xs text-slate-400 max-w-sm mx-auto mb-6">You have completed all multiple choice questions for {{ $module->title }}.</p>

                        <div class="grid grid-cols-2 gap-4 max-w-xs mx-auto mb-8 bg-slate-800/80 border border-slate-700 p-4 rounded-2xl">
                            <div class="border-r border-slate-700">
                                <p id="summary-score-pct" class="text-2xl font-black text-emerald-400">0%</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Accuracy</p>
                            </div>
                            <div>
                                <p id="summary-correct-total" class="text-2xl font-black text-white">0 / 0</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Score</p>
                            </div>
                        </div>

                        <form action="{{ route('modules.complete', [$course->slug, $module->slug]) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-8 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-2xl transition-all shadow-xl inline-flex items-center gap-2">
                                <span>Mark Module Completed &amp; Continue</span>
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Navigation Bar (Next / Prev Module) -->
            <div class="flex items-center justify-between gap-4 pt-6 border-t border-gray-100">
                @if($prevModule)
                    <a href="{{ route('modules.show', [$course->slug, $prevModule->slug]) }}" class="px-5 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold text-xs flex items-center gap-2 transition-all">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        <span>Previous: {{ $prevModule->title }}</span>
                    </a>
                @else
                    <div></div>
                @endif

                @if($nextModule)
                    <a href="{{ route('modules.show', [$course->slug, $nextModule->slug]) }}" class="px-6 py-2.5 rounded-xl bg-gray-900 hover:bg-emerald-600 text-white font-bold text-xs flex items-center gap-2 transition-all shadow-sm">
                        <span>Next: {{ $nextModule->title }}</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                @else
                    <form action="{{ route('modules.complete', [$course->slug, $module->slug]) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-2 transition-all shadow-sm">
                            <span>Finish Course Preparation 🎉</span>
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Sidebar: Course Modules Navigation (1 Col) -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm sticky top-8">
                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Course Modules</h4>
                <div class="space-y-2.5">
                    @foreach($allModules as $idx => $m)
                        @php
                            $isActive = $m->id === $module->id;
                        @endphp
                        <a href="{{ route('modules.show', [$course->slug, $m->slug]) }}" class="block p-3 rounded-2xl transition-all border {{ $isActive ? 'bg-emerald-50 border-emerald-200 text-emerald-950 font-bold shadow-sm' : 'bg-gray-50/60 border-transparent hover:bg-gray-100 text-gray-700 font-medium' }}">
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider {{ $isActive ? 'text-emerald-700' : 'text-gray-400' }}">
                                    Module {{ $idx + 1 }}
                                </span>
                                @if($isActive)
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                @endif
                            </div>
                            <p class="text-xs leading-snug">{{ $m->title }}</p>
                        </a>
                    @endforeach
                </div>

                <div class="mt-6 pt-6 border-t border-gray-100">
                    <a href="{{ route('courses.details', $course->slug) }}" class="w-full text-center text-xs font-bold text-gray-500 hover:text-emerald-600 flex items-center justify-center gap-1">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                        <span>Back to Course Overview</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Interactive Quiz Engine Script -->
@if(!empty($quizQuestions) && count($quizQuestions) > 0)
<script>
    const questions = @json($quizQuestions);
    let currentQIndex = 0;
    let score = 0;
    let answered = false;

    function renderQuestion(idx) {
        if (idx >= questions.length) {
            showSummary();
            return;
        }

        answered = false;
        const q = questions[idx];
        document.getElementById('q-prompt').innerText = (idx + 1) + '. ' + q.question;
        document.getElementById('quiz-q-counter').innerText = 'Question ' + (idx + 1) + ' of ' + questions.length;
        document.getElementById('quiz-progress-fill').style.width = Math.round(((idx + 1) / questions.length) * 100) + '%';
        
        // Hint Setup
        const hintBtn = document.getElementById('hint-toggle-btn');
        const hintBox = document.getElementById('hint-box');
        hintBox.classList.add('hidden');
        if (q.hint && q.hint.trim() !== '') {
            hintBtn.classList.remove('hidden');
            document.getElementById('hint-text').innerText = q.hint;
        } else {
            hintBtn.classList.add('hidden');
        }

        // Feedback Setup
        document.getElementById('feedback-box').classList.add('hidden');
        document.getElementById('next-q-btn').classList.add('hidden');

        // Options Setup
        const grid = document.getElementById('options-grid');
        grid.innerHTML = '';
        const labels = ['A', 'B', 'C', 'D'];

        q.options.forEach((opt, oIdx) => {
            if (!opt || opt.trim() === '') return;
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'w-full p-4 rounded-2xl bg-slate-800/90 border border-slate-700/80 hover:border-emerald-500/60 hover:bg-slate-800 text-left text-xs font-semibold text-slate-200 transition-all flex items-start gap-3 shadow-sm group';
            btn.id = 'opt-btn-' + oIdx;
            btn.onclick = () => selectOption(oIdx);

            btn.innerHTML = `
                <span class="w-6 h-6 rounded-lg bg-slate-700 text-slate-300 group-hover:bg-emerald-500 group-hover:text-white flex items-center justify-center font-bold text-[10px] shrink-0 transition-colors">
                    ${labels[oIdx]}
                </span>
                <span class="flex-1 pt-0.5 leading-relaxed">${opt}</span>
                <span class="status-indicator shrink-0"></span>
            `;
            grid.appendChild(btn);
        });
    }

    function toggleHint() {
        const hintBox = document.getElementById('hint-box');
        hintBox.classList.toggle('hidden');
    }

    function selectOption(selectedIdx) {
        if (answered) return;
        answered = true;

        const q = questions[currentQIndex];
        const isCorrect = selectedIdx === q.answer;
        if (isCorrect) score++;

        document.getElementById('score-counter').innerText = score;

        // Visual feedback on all option buttons
        q.options.forEach((_, oIdx) => {
            const btn = document.getElementById('opt-btn-' + oIdx);
            if (!btn) return;
            btn.disabled = true;
            btn.classList.remove('hover:border-emerald-500/60', 'hover:bg-slate-800');

            const indicator = btn.querySelector('.status-indicator');

            if (oIdx === selectedIdx) {
                if (isCorrect) {
                    // User Selected Correct Answer (Green)
                    btn.className = 'w-full p-4 rounded-2xl bg-emerald-950/80 border-2 border-emerald-500 text-white text-left text-xs font-bold transition-all flex items-start gap-3 shadow-md shadow-emerald-900/30';
                    indicator.innerHTML = '<span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-500 text-slate-950 text-[10px] font-black">✔ Correct</span>';
                } else {
                    // User Selected Wrong Answer (Red)
                    btn.className = 'w-full p-4 rounded-2xl bg-rose-950/80 border-2 border-rose-500 text-white text-left text-xs font-bold transition-all flex items-start gap-3 shadow-md shadow-rose-900/30';
                    indicator.innerHTML = '<span class="inline-flex items-center px-2 py-0.5 rounded-full bg-rose-500 text-white text-[10px] font-black">✖ Your Answer</span>';
                }
            } else if (!isCorrect && oIdx === q.answer) {
                // When wrong, highlight the correct option in distinctive red/rose styling
                btn.className = 'w-full p-4 rounded-2xl bg-rose-950/40 border-2 border-rose-400 text-rose-100 text-left text-xs font-bold transition-all flex items-start gap-3 shadow-md shadow-rose-950/30';
                indicator.innerHTML = '<span class="inline-flex items-center px-2 py-0.5 rounded-full bg-rose-500/20 border border-rose-500/60 text-rose-300 text-[10px] font-bold">✔ Correct Answer</span>';
            } else {
                btn.classList.add('opacity-30');
            }
        });

        // Show Explanation Box
        const fbBox = document.getElementById('feedback-box');
        const statusLine = document.getElementById('feedback-status-line');
        const expText = document.getElementById('feedback-explanation');

        fbBox.classList.remove('hidden');
        if (isCorrect) {
            fbBox.className = 'mb-6 p-5 rounded-2xl border border-emerald-500/50 bg-emerald-950/40 text-emerald-200';
            statusLine.innerHTML = '<i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400"></i><strong class="text-sm font-bold text-emerald-300">Excellent! Correct Choice</strong>';
            expText.classList.remove('hidden');
            expText.innerText = q.explanation && q.explanation.trim() !== '' 
                ? 'Loksewa Reference: ' + q.explanation 
                : 'Great job! This answer matches the standard PSC curriculum.';
        } else {
            fbBox.className = 'mb-6 p-4 rounded-2xl border border-rose-500/50 bg-rose-950/40 text-rose-200';
            statusLine.innerHTML = `<div class="flex flex-col gap-1"><span class="inline-flex items-center gap-2 text-rose-300 text-xs font-bold">✖ Incorrect option selected.</span><span class="text-xs text-rose-100 font-medium">Correct Option is <strong class="text-white underline">Option ${labels[q.answer]}: ${q.options[q.answer]}</strong></span></div>`;
            if (q.explanation && q.explanation.trim() !== '') {
                expText.classList.remove('hidden');
                expText.innerText = 'Loksewa Reference: ' + q.explanation;
            } else {
                expText.classList.add('hidden');
                expText.innerText = '';
            }
        }

        lucide.createIcons();
        document.getElementById('next-q-btn').classList.remove('hidden');
    }

    function nextQuestion() {
        currentQIndex++;
        renderQuestion(currentQIndex);
    }

    function showSummary() {
        document.getElementById('quiz-active-view').classList.add('hidden');
        document.getElementById('quiz-summary-view').classList.remove('hidden');

        const pct = Math.round((score / questions.length) * 100);
        document.getElementById('summary-score-pct').innerText = pct + '%';
        document.getElementById('summary-correct-total').innerText = score + ' / ' + questions.length;
        lucide.createIcons();
    }

    // Initialize first question on load
    document.addEventListener('DOMContentLoaded', () => {
        renderQuestion(0);
    });
</script>
@endif
@endsection
