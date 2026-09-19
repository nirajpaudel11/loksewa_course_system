<?php $__env->startSection('title', ($course ? $course->title . ' - ' : '') . 'Spaced Repetition Flashcard Review'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-950 text-slate-100 py-8 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Ambient Background Glows -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[500px] bg-emerald-600/10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-[500px] h-[400px] bg-amber-500/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-4xl mx-auto relative z-10">
        <!-- Top Navigation Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-800/80">
            <div class="flex items-center gap-3">
                <a href="<?php echo e($course ? route('courses.details', $course->slug) : route('dashboard')); ?>" 
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-900 border border-slate-700/80 hover:border-slate-600 text-slate-300 hover:text-white text-xs font-semibold transition-all shadow-sm">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span><?php echo e($course ? 'Back to Course' : 'Back to Dashboard'); ?></span>
                </a>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-500/15 border border-amber-500/30 text-amber-300 text-[10px] font-extrabold uppercase tracking-wider">
                        <span>🧠 SM-2 Spaced Repetition</span>
                        <span>&bull;</span>
                        <span>1 MCQ / Lesson</span>
                    </span>
                    <h1 class="text-lg md:text-xl font-black text-white tracking-tight mt-0.5">
                        <?php echo e($course ? $course->title : 'Due Spaced Repetition Reviews'); ?>

                    </h1>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course): ?>
                <div class="flex items-center gap-2 bg-slate-900/90 p-1 rounded-xl border border-slate-800">
                    <a href="<?php echo e(route('courses.flashcards', [$course->slug, 'mode' => 'due'])); ?>" 
                       class="px-3 py-1 text-xs font-bold rounded-lg transition-all <?php echo e($mode === 'due' ? 'bg-amber-500 text-slate-950 shadow-md' : 'text-slate-400 hover:text-white'); ?>">
                        Due Only (<?php echo e($dueCount); ?>)
                    </a>
                    <a href="<?php echo e(route('courses.flashcards', [$course->slug, 'mode' => 'all'])); ?>" 
                       class="px-3 py-1 text-xs font-bold rounded-lg transition-all <?php echo e($mode === 'all' ? 'bg-amber-500 text-slate-950 shadow-md' : 'text-slate-400 hover:text-white'); ?>">
                        All Lessons (<?php echo e($totalCount); ?>)
                    </a>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($flashcards->isEmpty()): ?>
            <!-- Empty State -->
            <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-10 text-center shadow-2xl backdrop-blur-xl">
                <div class="w-16 h-16 rounded-3xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 flex items-center justify-center mx-auto mb-4 text-2xl shadow-lg">
                    ✨
                </div>
                <h3 class="text-xl font-black text-white mb-2">All Caught Up! No Reviews Due</h3>
                <p class="text-sm text-slate-400 max-w-md mx-auto mb-6">
                    You have reviewed all the flashcards scheduled for today. Great job strengthening your long-term memory!
                </p>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course): ?>
                    <div class="flex items-center justify-center gap-3">
                        <a href="<?php echo e(route('courses.flashcards', [$course->slug, 'mode' => 'all'])); ?>" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs transition-all shadow-md">
                            Review All <?php echo e($totalCount); ?> Lessons Anyway
                        </a>
                        <a href="<?php echo e(route('dashboard')); ?>" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs transition-all border border-slate-700">
                            Return to Dashboard
                        </a>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold text-xs transition-all shadow-md">
                        Return to Dashboard
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php else: ?>
            <!-- Flashcard App Container -->
            <div id="flashcardApp" class="space-y-6">
                <!-- Progress Header -->
                <div class="flex items-center justify-between text-xs font-bold text-slate-400 px-1">
                    <span id="cardProgressText">Card 1 of <?php echo e($flashcards->count()); ?></span>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1 text-[11px] text-amber-400">
                            <i data-lucide="zap" class="w-3.5 h-3.5"></i>
                            <span id="reviewedCounter">0 Reviewed</span>
                        </span>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="w-full h-2 bg-slate-800/90 rounded-full overflow-hidden border border-slate-700/50 p-0.5">
                    <div id="progressBar" class="h-full bg-gradient-to-r from-amber-500 to-emerald-400 rounded-full transition-all duration-300" style="width: 0%;"></div>
                </div>

                <!-- Card Flip Stage -->
                <div class="perspective-container relative min-h-[500px] cursor-pointer select-none" id="flashcardElement" onclick="toggleCardFlip()">
                    <!-- Card Inner Wrapper -->
                    <div id="cardInner" class="card-flipper w-full min-h-[500px] relative transition-transform duration-500 preserve-3d">
                        
                        <!-- FRONT SIDE (Question & Options) -->
                        <div class="card-front absolute inset-0 w-full min-h-[500px] bg-slate-900/95 border border-slate-700/80 hover:border-amber-500/50 rounded-3xl p-6 md:p-8 flex flex-col justify-between shadow-2xl backdrop-blur-xl backface-hidden transition-all">
                            <!-- Top Details Area -->
                            <div class="flex-1 flex flex-col">
                                <!-- Top Metadata -->
                                <div class="flex items-center justify-between gap-3 mb-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span id="cardModuleBadge" class="text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-300 border border-slate-700">
                                            Module
                                        </span>
                                        <span id="cardDueBadge" class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                            📅 Due for Review
                                        </span>
                                    </div>
                                    <span class="text-xs text-slate-400 font-medium flex items-center gap-1.5">
                                        <i data-lucide="rotate-3d" class="w-3.5 h-3.5 text-amber-400"></i>
                                        <span>Click Card to Flip</span>
                                    </span>
                                </div>

                                <!-- Lesson Title -->
                                <div class="text-xs font-bold text-amber-400 mb-2 flex items-center gap-1.5">
                                    <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                                    <span id="cardLessonTitle">Lesson Title</span>
                                </div>

                                <!-- Question Text -->
                                <h3 id="cardQuestion" class="text-lg md:text-xl font-extrabold text-white leading-relaxed mb-5">
                                    Loading question...
                                </h3>

                                <!-- MCQ Options List -->
                                <div id="cardOptionsContainer" class="space-y-2.5 flex-1 mb-6">
                                    <!-- Dynamic Options injected by JS -->
                                </div>
                            </div>

                            <!-- Front Footer Action: Shifted downwards with clear spacing -->
                            <div class="pt-5 mt-auto border-t border-slate-800/80 flex items-center justify-end">
                                <button type="button" onclick="event.stopPropagation(); toggleCardFlip();" class="px-5 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs md:text-sm flex items-center gap-2 transition-all shadow-lg shadow-amber-500/20 hover:shadow-amber-500/35 hover:-translate-y-0.5">
                                    <span>Show Answer</span>
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>

                        <!-- BACK SIDE (Answer & Explanation) -->
                        <div class="card-back absolute inset-0 w-full min-h-[500px] bg-slate-900/95 border border-emerald-500/40 rounded-3xl p-6 md:p-8 flex flex-col justify-between shadow-2xl backdrop-blur-xl backface-hidden rotate-y-180 transition-all">
                            <!-- Answer Content Area -->
                            <div class="flex-1 flex flex-col">
                                <!-- Top Metadata -->
                                <div class="flex items-center justify-between gap-3 mb-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                                            ✓ Answer &amp; Explanation
                                        </span>
                                    </div>
                                    <span class="text-xs text-slate-400 font-medium flex items-center gap-1.5">
                                        <i data-lucide="rotate-3d" class="w-3.5 h-3.5 text-emerald-400"></i>
                                        <span>Click Card to Flip Back</span>
                                    </span>
                                </div>

                                <!-- Correct Answer Box -->
                                <div class="p-4 sm:p-5 rounded-2xl bg-emerald-950/60 border border-emerald-500/40 mb-4 shadow-inner">
                                    <div class="text-[11px] font-black uppercase tracking-wider text-emerald-400 mb-1.5 flex items-center gap-1.5">
                                        <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                                        <span>Correct Answer:</span>
                                    </div>
                                    <div id="cardCorrectText" class="text-base md:text-lg font-extrabold text-white leading-relaxed">
                                        Correct option text
                                    </div>
                                </div>

                                <!-- Explanation Box -->
                                <div class="p-4 sm:p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80 flex-1 mb-4">
                                    <div class="text-[11px] font-bold uppercase tracking-wider text-amber-400 mb-2 flex items-center gap-1.5">
                                        <i data-lucide="info" class="w-4 h-4"></i>
                                        <span>Loksewa Exam Context &amp; Explanation:</span>
                                    </div>
                                    <p id="cardExplanation" class="text-xs md:text-sm text-slate-200 leading-relaxed">
                                        Explanation text here...
                                    </p>
                                </div>
                            </div>

                            <!-- Back Footer Action: Shifted downwards with clear spacing -->
                            <div class="pt-5 mt-auto border-t border-slate-800/80 flex items-center justify-between gap-3">
                                <button type="button" onclick="event.stopPropagation(); toggleCardFlip();" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white font-bold text-xs flex items-center gap-1.5 transition-all border border-slate-700">
                                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                                    <span>Flip Back to Question</span>
                                </button>

                                <button type="button" onclick="event.stopPropagation(); nextCard();" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs md:text-sm flex items-center gap-1.5 transition-all shadow-md shadow-emerald-500/20 hover:-translate-y-0.5">
                                    <span>Next Card</span>
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Navigation Controls (No shortcuts bar) -->
                <div class="flex items-center justify-between gap-4 pt-2">
                    <button type="button" onclick="prevCard()" id="prevBtn"
                            class="px-5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-300 font-bold text-xs flex items-center gap-2 transition-all disabled:opacity-30 disabled:pointer-events-none shadow-sm">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                        <span>Previous</span>
                    </button>

                    <button type="button" onclick="nextCard()" id="nextBtn"
                            class="px-5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-300 font-bold text-xs flex items-center gap-2 transition-all shadow-sm">
                        <span>Next</span>
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Completion Summary Modal/Card (Hidden initially) -->
            <div id="completionSummary" class="hidden bg-slate-900/95 border border-emerald-500/40 rounded-3xl p-8 md:p-10 text-center shadow-2xl backdrop-blur-xl">
                <div class="w-20 h-20 rounded-3xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 flex items-center justify-center mx-auto mb-4 text-3xl shadow-xl animate-bounce">
                    🎉
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-black uppercase tracking-wider mb-2">
                    Session Complete!
                </span>
                <h2 class="text-2xl font-black text-white mb-2">Excellent Flashcard Review Session!</h2>
                <p class="text-sm text-slate-400 max-w-lg mx-auto mb-6">
                    You have reviewed all 1 MCQ flashcards extracted from the lessons of this course. Your spaced repetition intervals have been recalibrated.
                </p>

                <div class="grid grid-cols-2 gap-4 max-w-xs mx-auto mb-8">
                    <div class="bg-slate-800/80 p-4 rounded-2xl border border-slate-700 text-center">
                        <div class="text-2xl font-black text-white" id="summaryTotalReviewed">0</div>
                        <div class="text-[10px] uppercase font-bold text-slate-400 mt-1">Cards Reviewed</div>
                    </div>
                    <div class="bg-slate-800/80 p-4 rounded-2xl border border-slate-700 text-center">
                        <div class="text-2xl font-black text-emerald-400">100%</div>
                        <div class="text-[10px] uppercase font-bold text-slate-400 mt-1">Completed</div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-3">
                    <button type="button" onclick="restartReview()" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs transition-all border border-slate-700">
                        🔄 Review Deck Again
                    </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course): ?>
                        <a href="<?php echo e(route('courses.details', $course->slug)); ?>" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs transition-all shadow-md">
                            Continue Course Curriculum
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-black text-xs transition-all shadow-md">
                        Return to Dashboard
                    </a>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<style>
.perspective-container {
    perspective: 1200px;
}
.preserve-3d {
    transform-style: preserve-3d;
}
.backface-hidden {
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
}
.rotate-y-180 {
    transform: rotateY(180deg);
}
.is-flipped {
    transform: rotateY(180deg);
}
</style>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($flashcards->isNotEmpty()): ?>
<script>
const flashcards = <?php echo json_encode($flashcards->values(), 15, 512) ?>;
let currentIndex = 0;
let isFlipped = false;
let reviewedCardIds = new Set();

const cardInner = document.getElementById('cardInner');
const cardProgressText = document.getElementById('cardProgressText');
const progressBar = document.getElementById('progressBar');
const cardLessonTitle = document.getElementById('cardLessonTitle');
const cardModuleBadge = document.getElementById('cardModuleBadge');
const cardDueBadge = document.getElementById('cardDueBadge');
const cardQuestion = document.getElementById('cardQuestion');
const cardOptionsContainer = document.getElementById('cardOptionsContainer');
const cardCorrectText = document.getElementById('cardCorrectText');
const cardExplanation = document.getElementById('cardExplanation');
const reviewedCounter = document.getElementById('reviewedCounter');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

function renderCard(index) {
    if (index >= flashcards.length) {
        showCompletionSummary();
        return;
    }

    const card = flashcards[index];
    isFlipped = false;
    cardInner.classList.remove('is-flipped');

    // Update Header
    cardProgressText.innerText = `Card ${index + 1} of ${flashcards.length}`;
    const pct = Math.round(((index) / flashcards.length) * 100);
    progressBar.style.width = `${pct}%`;

    // Metadata
    cardLessonTitle.innerText = card.lesson_title;
    cardModuleBadge.innerText = card.module_title;
    if (card.is_due) {
        cardDueBadge.classList.remove('hidden');
    } else {
        cardDueBadge.classList.add('hidden');
    }

    // Question
    cardQuestion.innerText = card.question;

    // Options
    cardOptionsContainer.innerHTML = '';
    const letters = ['A', 'B', 'C', 'D'];
    if (card.options && Array.isArray(card.options)) {
        card.options.forEach((opt, idx) => {
            const optBtn = document.createElement('div');
            optBtn.className = 'flex items-center gap-3 p-3.5 rounded-2xl bg-slate-800/60 border border-slate-700/60 hover:border-amber-500/50 hover:bg-slate-800 transition-all cursor-pointer';
            optBtn.innerHTML = `
                <span class="w-6 h-6 rounded-lg bg-slate-700/80 text-slate-300 font-bold text-xs flex items-center justify-center shrink-0">
                    ${letters[idx] || (idx + 1)}
                </span>
                <span class="text-xs md:text-sm text-slate-200 font-medium">${opt}</span>
            `;
            optBtn.onclick = (e) => {
                e.stopPropagation();
                toggleCardFlip();
            };
            cardOptionsContainer.appendChild(optBtn);
        });
    }

    // Back side
    cardCorrectText.innerText = card.correct_text;
    cardExplanation.innerText = card.explanation;

    // Record review in background if not recorded yet
    if (!reviewedCardIds.has(card.lesson_id)) {
        reviewedCardIds.add(card.lesson_id);
        reviewedCounter.innerText = `${reviewedCardIds.size} Reviewed`;

        fetch(`/lessons/${card.lesson_id}/rate-review`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quality: 4 })
        }).catch(err => console.error('Failed to update SM-2 progress', err));
    }

    // Buttons
    prevBtn.disabled = (index === 0);
    lucide.createIcons();
}

function toggleCardFlip() {
    isFlipped = !isFlipped;
    if (isFlipped) {
        cardInner.classList.add('is-flipped');
    } else {
        cardInner.classList.remove('is-flipped');
    }
}

function nextCard() {
    if (currentIndex < flashcards.length - 1) {
        currentIndex++;
        renderCard(currentIndex);
    } else {
        showCompletionSummary();
    }
}

function prevCard() {
    if (currentIndex > 0) {
        currentIndex--;
        renderCard(currentIndex);
    }
}

function showCompletionSummary() {
    document.getElementById('flashcardApp').classList.add('hidden');
    const summary = document.getElementById('completionSummary');
    summary.classList.remove('hidden');

    document.getElementById('summaryTotalReviewed').innerText = reviewedCardIds.size;
    progressBar.style.width = '100%';
    lucide.createIcons();
}

function restartReview() {
    currentIndex = 0;
    reviewedCardIds.clear();
    document.getElementById('completionSummary').classList.add('hidden');
    document.getElementById('flashcardApp').classList.remove('hidden');
    renderCard(0);
}

// Space to flip
document.addEventListener('keydown', (e) => {
    if (document.getElementById('flashcardApp').classList.contains('hidden')) return;

    if (e.code === 'Space') {
        e.preventDefault();
        toggleCardFlip();
    } else if (e.key === 'ArrowRight') {
        nextCard();
    } else if (e.key === 'ArrowLeft') {
        prevCard();
    }
});

// Initial load
document.addEventListener('DOMContentLoaded', () => {
    renderCard(0);
});
</script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.lms', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\loksewa_course\resources\views/frontend/courses/flashcards.blade.php ENDPATH**/ ?>