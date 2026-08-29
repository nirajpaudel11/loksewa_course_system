@extends('layouts.lms')

@section('title', $lesson->title . ' | ' . $course->title)
@section('header', 'Lesson Player')

@section('content')
<div class="flex flex-col lg:flex-row gap-8 max-w-7xl mx-auto">
    <!-- Main Player Area -->
    <div class="flex-1 min-w-0">
        <!-- Toast Success Notification -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 animate-pulse">
                <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        @if($lesson->type !== 'text')
        <!-- Player Box -->
        <div class="bg-gray-950 rounded-3xl shadow-2xl mb-8 relative border border-gray-800 overflow-hidden">
            @if($lesson->type == 'video')
                <div class="aspect-video flex items-center justify-center bg-gray-900">
                    <i data-lucide="play-circle" class="w-20 h-20 text-emerald-500 opacity-50"></i>
                    <p class="absolute bottom-10 text-gray-500 text-sm font-medium uppercase tracking-widest">Video Player Interface</p>
                </div>
            @elseif($lesson->type == 'pdf')
                <div class="aspect-[16/10] w-full bg-gray-950">
                    <iframe src="{{ asset($lesson->attachment_path) }}" class="w-full h-full border-0 rounded-3xl" title="PDF Notes"></iframe>
                </div>
            @elseif($lesson->type == 'quiz')
                <!-- Interactive GK/IQ Quiz Player – scrollable, no fixed aspect ratio -->
                <div id="quiz-container" class="text-white select-none p-6 md:p-8" data-questions="{{ $lesson->content }}">

                    <!-- Quiz Header -->
                    <div class="flex items-center justify-between border-b border-gray-800 pb-4 mb-4">
                        <div>
                            <h4 class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">GK / IQ Practice Quiz</h4>
                            <p class="text-sm font-bold text-gray-200">{{ $lesson->title }}</p>
                        </div>
                        <div class="text-right">
                            <p id="quiz-progress-text" class="text-xs font-bold text-gray-400">Question 1 of 1</p>
                            <div class="w-24 bg-gray-800 h-1.5 rounded-full overflow-hidden mt-1 ml-auto">
                                <div id="quiz-progress-bar" class="bg-emerald-500 h-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Question -->
                    <div class="mb-4">
                        <h3 id="quiz-question" class="text-base md:text-xl font-bold mb-5 text-gray-100 leading-snug">Question text loads here?</h3>
                        <div id="quiz-options" class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                            <!-- Options generated dynamically -->
                        </div>
                    </div>

                    <!-- Explanation Box -->
                    <div id="quiz-explanation" class="hidden mb-4 bg-gray-900 border border-gray-700 p-5 rounded-2xl text-sm text-gray-300 space-y-2">
                        <div class="flex items-start gap-2">
                            <i data-lucide="lightbulb" class="w-4 h-4 text-yellow-400 shrink-0 mt-0.5"></i>
                            <div>
                                <strong class="text-emerald-400 block mb-1">Loksewa Explanation:</strong>
                                <p id="quiz-explanation-text" class="leading-relaxed"></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 pt-2 border-t border-gray-800">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-400 shrink-0"></i>
                            <p id="quiz-correct-answer" class="font-bold text-emerald-300 text-sm"></p>
                        </div>
                    </div>

                    <!-- Quiz Footer -->
                    <div class="flex items-center justify-between border-t border-gray-800 pt-4">
                        <div class="text-[10px] bg-emerald-500/10 text-emerald-400 px-3 py-1 rounded-full font-bold uppercase tracking-wider">
                            Live Score &bull; <span id="quiz-correct-count">0</span> Correct
                        </div>
                        <button id="quiz-next-btn" class="hidden bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2 rounded-xl text-xs transition-all flex items-center gap-1">
                            <span>Next Question</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                </div>

                <!-- Quiz Results Screen -->
                <div id="quiz-results-container" class="hidden p-8 text-white text-center">
                    <div class="w-16 h-16 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-3xl flex items-center justify-center mb-6 mx-auto">
                        <i data-lucide="award" class="w-8 h-8 animate-bounce"></i>
                    </div>
                    <h3 class="text-2xl font-black mb-2 text-gray-100">Quiz Completed!</h3>
                    <p class="text-xs text-gray-400 max-w-sm mb-6 mx-auto">Excellent effort! You have completed the practice test for {{ $lesson->title }}.</p>

                    <div class="grid grid-cols-2 gap-4 max-w-xs w-full mb-8 bg-gray-900 border border-gray-800 p-4 rounded-2xl mx-auto">
                        <div class="text-center border-r border-gray-800">
                            <p id="results-score-percent" class="text-2xl font-black text-emerald-400">0%</p>
                            <p class="text-[8px] font-bold text-gray-500 uppercase tracking-widest">Success Rate</p>
                        </div>
                        <div class="text-center">
                            <p id="results-correct-fraction" class="text-2xl font-black text-gray-200">0 / 0</p>
                            <p class="text-[8px] font-bold text-gray-500 uppercase tracking-widest">Questions Correct</p>
                        </div>
                    </div>

                    <form action="{{ route('lessons.complete', [$course->slug, $lesson->slug]) }}" method="POST" class="max-w-xs mx-auto">
                        @csrf
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3.5 rounded-2xl font-bold text-sm flex items-center justify-center gap-2">
                            Submit Score &amp; Continue
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            @endif
        </div>
        @endif


        <!-- Player Actions Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pb-6 border-b border-gray-100">
            <div>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight mb-1">{{ $lesson->title }}</h1>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    Current Chapter &bull; {{ $lesson->type }} lesson
                </p>
            </div>
            @if($lesson->type !== 'quiz')
                <form action="{{ route('lessons.complete', [$course->slug, $lesson->slug]) }}" method="POST">
                    @csrf
                    <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-bold flex items-center justify-center gap-2 shadow-xl shadow-emerald-50 transition-all">
                        Complete Lesson
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                    </button>
                </form>
            @endif
        </div>

        <!-- Premium Tabs System -->
        <div class="mb-10">
            <!-- Tab Headers -->
            <div class="flex border-b border-gray-200 gap-4 mb-6">
                <button onclick="switchTab('tab-content')" id="btn-tab-content" class="tab-btn pb-3 text-sm font-bold text-emerald-600 border-b-2 border-emerald-500 tracking-tight transition-all">
                    Lesson Content
                </button>
                <button onclick="switchTab('tab-notes')" id="btn-tab-notes" class="tab-btn pb-3 text-sm font-medium text-gray-400 hover:text-gray-600 tracking-tight transition-all">
                    Syllabus Study Notes
                </button>
                <button onclick="switchTab('tab-notepad')" id="btn-tab-notepad" class="tab-btn pb-3 text-sm font-medium text-gray-400 hover:text-gray-600 tracking-tight transition-all flex items-center gap-1.5">
                    My Personal Notes
                    <span id="notepad-badge" class="hidden w-2 h-2 rounded-full bg-emerald-500"></span>
                </button>
            </div>

            <!-- Tab Content: Lesson Content -->
            <div id="tab-content" class="tab-panel prose prose-emerald max-w-none text-gray-600 leading-relaxed bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                @if($lesson->type === 'quiz')
                    @php $questions = json_decode($lesson->content, true) ?? []; @endphp
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Quiz Questions Overview</h4>
                    <ol class="space-y-4">
                        @foreach($questions as $i => $q)
                        <li class="p-4 bg-gray-50 border border-gray-100 rounded-xl">
                            <p class="font-semibold text-gray-800 mb-2">Question {{ $i + 1 }}: {{ $q['question'] }}</p>
                            <ul class="grid grid-cols-2 gap-2 mb-2">
                                @foreach($q['options'] as $j => $opt)
                                <li class="text-sm px-3 py-1.5 rounded-lg {{ $j == $q['answer'] ? 'bg-emerald-50 text-emerald-700 font-bold border border-emerald-200' : 'bg-white border border-gray-200 text-gray-600' }}">
                                    {{ chr(65 + $j) }}. {{ $opt }}
                                </li>
                                @endforeach
                            </ul>
                            <p class="text-xs text-gray-500 italic">💡 {{ $q['explanation'] }}</p>
                        </li>
                        @endforeach
                    </ol>
                @else
                    {!! $lesson->content !!}
                @endif
            </div>

            <!-- Tab Content: Syllabus Study Notes -->
            <div id="tab-notes" class="tab-panel hidden bg-white p-8 rounded-3xl border border-gray-100 shadow-sm leading-relaxed text-gray-600">
                <h4 class="text-lg font-bold text-gray-900 mb-4">Syllabus Key Focus & Study Tips</h4>
                <p class="mb-4">This section summarizes high-yield information and memorization tips mapped directly to current Loksewa curriculum standards:</p>
                
                <ul class="space-y-3 mb-8">
                    <li class="flex gap-3 text-sm bg-gray-50 p-4 rounded-xl border-l-4 border-emerald-500">
                        <i data-lucide="help-circle" class="w-5 h-5 text-emerald-500 shrink-0"></i>
                        <div>
                            <strong class="text-gray-900 block mb-0.5">Exam Core Focus</strong>
                            Questions from this topic are frequently asked in both the GK paper and written/subjective paper (e.g. governance and administrative systems).
                        </div>
                    </li>
                    <li class="flex gap-3 text-sm bg-gray-50 p-4 rounded-xl border-l-4 border-emerald-500">
                        <i data-lucide="award" class="w-5 h-5 text-emerald-500 shrink-0"></i>
                        <div>
                            <strong class="text-gray-900 block mb-0.5">Mnemonic Technique</strong>
                            Write concise headings, draw neat flowchart diagrams in subjective answers, and review geographical maps of Nepal weekly to improve recall.
                        </div>
                    </li>
                </ul>

                @if($lesson->attachment_path)
                    <!-- PDF Attachment Section -->
                    <div class="p-6 bg-emerald-50 border border-emerald-100 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white text-emerald-500 flex items-center justify-center shadow-sm">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-emerald-800">Chapter PDF Notes Available</p>
                                <p class="text-[10px] text-emerald-600">Download for offline reading and revision</p>
                            </div>
                        </div>
                        <a href="{{ asset($lesson->attachment_path) }}" download class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition-all shadow-md flex items-center gap-1.5">
                            <i data-lucide="download" class="w-3.5 h-3.5"></i>
                            Download PDF
                        </a>
                    </div>
                @else
                    <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl text-xs text-gray-400 italic text-center">
                        No additional PDF attachments available for this lesson.
                    </div>
                @endif
            </div>

            <!-- Tab Content: Personal Notepad -->
            <div id="tab-notepad" class="tab-panel hidden bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">Personal Study Notepad</h4>
                        <p class="text-xs text-gray-400">Take custom notes as you learn. Notes are private and saved instantly to your browser.</p>
                    </div>
                    <div id="notepad-status" class="text-[10px] font-black text-gray-400 uppercase tracking-widest flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                        Notepad ready
                    </div>
                </div>

                <textarea id="notepad-textarea" rows="8" placeholder="Type your personal study notes, key facts, or quick formulas here..." 
                    class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-5 text-sm text-gray-700 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white outline-none transition-all shadow-inner leading-relaxed resize-none"></textarea>
            </div>
        </div>
    </div>

    <!-- Sidebar: Course Content -->
    <div class="lg:w-80 flex-shrink-0">
        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-50 overflow-hidden sticky top-8">
            <div class="p-6 border-b border-gray-50">
                <h6 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Course Content</h6>
                <h5 class="font-bold text-gray-900 truncate">{{ $course->title }}</h5>
            </div>
            
            <div class="overflow-y-auto max-h-[60vh] p-2">
                @foreach($course->modules as $module)
                    <div class="mb-4">
                        <p class="px-4 py-2 text-[10px] font-black text-emerald-600 uppercase tracking-widest">{{ $module->title }}</p>
                        @foreach($module->chapters as $chapter)
                            @foreach($chapter->lessons as $l)
                                <a href="{{ route('lessons.show', [$course->slug, $l->slug]) }}" class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all {{ $l->id == $lesson->id ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                                    <span class="flex items-center gap-3 truncate">
                                        <i data-lucide="{{ $l->type == 'video' ? 'play-circle' : ($l->type == 'quiz' ? 'help-circle' : ($l->type == 'pdf' ? 'file' : 'file-text')) }}" class="w-4 h-4 text-gray-400"></i>
                                        <span class="text-sm truncate">{{ $l->title }}</span>
                                    </span>
                                    @if(in_array($l->id, $completedLessonIds))
                                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-500 shrink-0"></i>
                                    @endif
                                </a>
                            @endforeach
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



<!-- JavaScript Engine for Tabs, Notepad and Interactive Quiz -->
<script>
    // 1. TABS SYSTEM
    function switchTab(tabId) {
        // Hide all panels
        document.querySelectorAll('.tab-panel').forEach(panel => {
            panel.classList.add('hidden');
        });
        
        // Show selected panel
        document.getElementById(tabId).classList.remove('hidden');

        // Reset tab button states
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('text-emerald-600', 'border-b-2', 'border-emerald-500');
            btn.classList.add('text-gray-400', 'font-medium');
        });

        // Set active tab button state
        const activeBtn = document.getElementById('btn-' + tabId);
        activeBtn.classList.remove('text-gray-400', 'font-medium');
        activeBtn.classList.add('text-emerald-600', 'border-b-2', 'border-emerald-500');
    }

    // 2. PERSONAL AUTOSAVING NOTEPAD
    const lessonId = "{{ $lesson->id }}";
    const storageKey = `loksewa_notes_lesson_${lessonId}`;
    const notepadTextarea = document.getElementById('notepad-textarea');
    const notepadStatus = document.getElementById('notepad-status');
    const notepadBadge = document.getElementById('notepad-badge');

    if (notepadTextarea) {
        // Load saved notes
        const savedNotes = localStorage.getItem(storageKey);
        if (savedNotes) {
            notepadTextarea.value = savedNotes;
            notepadBadge.classList.remove('hidden');
        }

        // Autosave on input change
        let timeout = null;
        notepadTextarea.addEventListener('input', () => {
            notepadStatus.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-ping"></span> Saving...`;
            
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const text = notepadTextarea.value;
                if (text.trim() !== '') {
                    localStorage.setItem(storageKey, text);
                    notepadBadge.classList.remove('hidden');
                } else {
                    localStorage.removeItem(storageKey);
                    notepadBadge.classList.add('hidden');
                }
                
                notepadStatus.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Autosaved`;
            }, 800); // Debounce delay
        });
    }

    // 3. INTERACTIVE QUIZ ENGINE
    const quizContainer = document.getElementById('quiz-container');
    if (quizContainer) {
        const questions = JSON.parse(quizContainer.dataset.questions || '[]');
        let currentQuestionIndex = 0;
        let score = 0;
        let selectedOptionIndex = null;

        const quizQuestion = document.getElementById('quiz-question');
        const quizOptions = document.getElementById('quiz-options');
        const quizExplanation = document.getElementById('quiz-explanation');
        const quizExplanationText = document.getElementById('quiz-explanation-text');
        const quizProgressText = document.getElementById('quiz-progress-text');
        const quizProgressBar = document.getElementById('quiz-progress-bar');
        const quizCorrectCount = document.getElementById('quiz-correct-count');
        const quizNextBtn = document.getElementById('quiz-next-btn');

        function loadQuestion() {
            if (questions.length === 0) return;

            selectedOptionIndex = null;
            quizNextBtn.classList.add('hidden');
            quizExplanation.classList.add('hidden');

            const q = questions[currentQuestionIndex];
            quizQuestion.textContent = q.question;
            quizProgressText.textContent = `Question ${currentQuestionIndex + 1} of ${questions.length}`;
            quizProgressBar.style.width = `${((currentQuestionIndex) / questions.length) * 100}%`;

            // Clear old options
            quizOptions.innerHTML = '';

            // Generate options
            q.options.forEach((opt, idx) => {
                const btn = document.createElement('button');
                btn.className = "w-full bg-gray-900 border border-gray-800 text-left p-4 rounded-2xl hover:border-gray-700 transition-all font-semibold text-xs flex items-center justify-between text-gray-300";
                btn.innerHTML = `<span>${opt}</span><span class="w-5 h-5 rounded-full border border-gray-800 flex items-center justify-center text-[10px] font-bold text-gray-500 uppercase tracking-widest">${String.fromCharCode(65 + idx)}</span>`;
                
                btn.onclick = () => selectOption(idx, btn);
                quizOptions.appendChild(btn);
            });
        }

        function selectOption(index, buttonElement) {
            if (selectedOptionIndex !== null) return; // Prevent double selecting

            selectedOptionIndex = index;
            const q = questions[currentQuestionIndex];
            const correctIndex = q.answer;

            // Update all buttons based on correct/incorrect choices
            const buttons = quizOptions.querySelectorAll('button');
            buttons.forEach((btn, idx) => {
                btn.disabled = true;
                btn.classList.remove('hover:border-gray-700');
                
                if (idx === correctIndex) {
                    // Highlight correct answer in green
                    btn.className = "w-full bg-emerald-950/40 border border-emerald-500/30 text-emerald-200 text-left p-4 rounded-2xl transition-all font-semibold text-xs flex items-center justify-between";
                    btn.innerHTML += `<i data-lucide="check-circle" class="w-4 h-4 text-emerald-400 shrink-0"></i>`;
                } else if (idx === index) {
                    // Highlight selected incorrect answer in red
                    btn.className = "w-full bg-red-950/40 border border-red-500/30 text-red-200 text-left p-4 rounded-2xl transition-all font-semibold text-xs flex items-center justify-between";
                    btn.innerHTML += `<i data-lucide="x-circle" class="w-4 h-4 text-red-400 shrink-0"></i>`;
                } else {
                    // Mute unselected choices
                    btn.className = "w-full bg-gray-950/40 border border-gray-900 text-left p-4 rounded-2xl transition-all font-semibold text-xs flex items-center justify-between text-gray-600 opacity-60";
                }
            });

            // Re-render icons injected dynamically.
            window.renderIcons();

            if (index === correctIndex) {
                score++;
                quizCorrectCount.textContent = score;
            }

            // Display explanation and correct answer
            quizExplanationText.textContent = q.explanation;
            const correctAns = q.options[q.answer];
            const answerEl = document.getElementById('quiz-correct-answer');
            if (answerEl) {
                answerEl.textContent = `Correct Answer: ${correctAns}`;
            }
            quizExplanation.classList.remove('hidden');

            // Reveal action footer
            quizNextBtn.classList.remove('hidden');
        }

        quizNextBtn.onclick = () => {
            currentQuestionIndex++;
            if (currentQuestionIndex < questions.length) {
                loadQuestion();
            } else {
                // Show quiz results screen
                quizContainer.classList.add('hidden');
                
                const resultsContainer = document.getElementById('quiz-results-container');
                resultsContainer.classList.remove('hidden');
                
                const successRate = Math.round((score / questions.length) * 100);
                document.getElementById('results-score-percent').textContent = `${successRate}%`;
                document.getElementById('results-correct-fraction').textContent = `${score} / ${questions.length}`;
            }
        };

        // Initialize first question
        loadQuestion();
    }

</script>
@endsection
