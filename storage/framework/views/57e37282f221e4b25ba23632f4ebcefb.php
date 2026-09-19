<?php $__env->startSection('title', $lesson->title . ' | ' . $course->title); ?>
<?php $__env->startSection('header', 'Lesson Player'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col lg:flex-row gap-8 max-w-7xl mx-auto">
    <!-- Main Player Area -->
    <div class="flex-1 min-w-0">
        <!-- Toast Success Notification -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 animate-pulse">
                <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
                <span class="font-bold text-sm"><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php
            $pdfUrl = null;
            if (!empty($lesson->attachment_path)) {
                if (\Illuminate\Support\Str::startsWith($lesson->attachment_path, ['http://', 'https://'])) {
                    $pdfUrl = $lesson->attachment_path;
                } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($lesson->attachment_path)) {
                    $pdfUrl = \Illuminate\Support\Facades\Storage::url($lesson->attachment_path);
                } elseif (file_exists(public_path($lesson->attachment_path))) {
                    $pdfUrl = asset($lesson->attachment_path);
                } elseif (file_exists(public_path('storage/' . $lesson->attachment_path))) {
                    $pdfUrl = asset('storage/' . $lesson->attachment_path);
                } elseif (\Illuminate\Support\Str::startsWith($lesson->attachment_path, 'storage/')) {
                    $pdfUrl = asset($lesson->attachment_path);
                } else {
                    $pdfUrl = asset('storage/' . $lesson->attachment_path);
                }
            }
        ?>

        <?php
            $quizData = null;
            if (!empty($lesson->quiz_questions) && is_array($lesson->quiz_questions)) {
                $quizData = $lesson->quiz_questions;
            } elseif (!empty($lesson->content)) {
                $decoded = json_decode($lesson->content, true);
                if (is_array($decoded) && isset($decoded[0]['question'])) {
                    $quizData = $decoded;
                }
            }
        ?>

        <!-- 1. VIDEO PLAYER (If Video Lesson) -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lesson->type == 'video' || !empty($lesson->video_url)): ?>
            <?php
                $videoSrc = null;
                if (!empty($lesson->attachment_path)) {
                    if (\Illuminate\Support\Str::startsWith($lesson->attachment_path, ['http://', 'https://'])) {
                        $videoSrc = $lesson->attachment_path;
                    } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($lesson->attachment_path)) {
                        $videoSrc = \Illuminate\Support\Facades\Storage::url($lesson->attachment_path);
                    } elseif (file_exists(public_path($lesson->attachment_path))) {
                        $videoSrc = asset($lesson->attachment_path);
                    } elseif (file_exists(public_path('storage/' . $lesson->attachment_path))) {
                        $videoSrc = asset('storage/' . $lesson->attachment_path);
                    } elseif (\Illuminate\Support\Str::startsWith($lesson->attachment_path, 'storage/')) {
                        $videoSrc = asset($lesson->attachment_path);
                    } else {
                        $videoSrc = asset('storage/' . $lesson->attachment_path);
                    }
                }
            ?>
            <div class="bg-gray-950 rounded-3xl shadow-2xl mb-8 relative border border-gray-800 overflow-hidden">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($lesson->video_url)): ?>
                    <div class="aspect-video w-full">
                        <iframe src="<?php echo e($lesson->video_url); ?>" class="w-full h-full border-0 rounded-3xl" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                    </div>
                <?php elseif($videoSrc): ?>
                    <div class="aspect-video w-full bg-black rounded-3xl overflow-hidden">
                        <video controls controlsList="nodownload" class="w-full h-full object-contain">
                            <source src="<?php echo e($videoSrc); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- 2. HIGH-DEFINITION ATTACHED PDF VIEWER (If PDF Available) -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pdfUrl): ?>
            <div class="bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl mb-8">
                <!-- PDF Top Toolbar -->
                <div class="bg-gray-950/90 backdrop-blur border-b border-gray-800 px-6 py-4 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 flex items-center justify-center shrink-0">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-100 truncate max-w-xs sm:max-w-md"><?php echo e($lesson->title); ?> — Study Document</h4>
                            <span class="text-[10px] text-gray-400 font-medium">Official Printable PDF &bull; Loksewa Syllabus Reference</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="<?php echo e($pdfUrl); ?>" target="_blank" rel="noopener noreferrer" class="px-3.5 py-1.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-200 text-xs font-semibold flex items-center gap-1.5 transition-colors border border-gray-700 shadow-sm" title="Open PDF in Full Tab">
                            <i data-lucide="external-link" class="w-3.5 h-3.5 text-emerald-400"></i>
                            <span>Open Tab</span>
                        </a>
                        <a href="<?php echo e($pdfUrl); ?>" download class="px-4 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold flex items-center gap-1.5 transition-colors shadow-sm">
                            <i data-lucide="download" class="w-3.5 h-3.5"></i>
                            <span>Download PDF</span>
                        </a>
                    </div>
                </div>

                <!-- PDF Embedded Viewport -->
                <div class="w-full h-[600px] md:h-[700px] bg-gray-950 relative">
                    <iframe 
                        src="<?php echo e($pdfUrl); ?>#toolbar=1&navpanes=0&scrollbar=1" 
                        class="w-full h-full border-0" 
                        title="<?php echo e($lesson->title); ?> PDF Document"
                        loading="lazy">
                    </iframe>
                </div>

                <!-- PDF Bottom Quick Action Bar -->
                <div class="bg-gray-950 px-6 py-3 border-t border-gray-800/80 flex flex-wrap items-center justify-between text-xs text-gray-400 gap-2">
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
                        <span>Dedicated Lesson Material for <?php echo e($lesson->title); ?></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-[11px] text-gray-500">Trouble viewing?</span>
                        <a href="<?php echo e($pdfUrl); ?>" target="_blank" class="text-emerald-400 hover:underline font-semibold">Open directly in browser</a>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- 3. INTERACTIVE PRACTICE QUIZ PLAYER (If Quiz Questions Available) -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quizData && count($quizData) > 0): ?>
            <div class="bg-gray-950 rounded-3xl shadow-2xl mb-8 border border-gray-800 overflow-hidden">
                <div id="quiz-container" class="text-white select-none p-6 md:p-8" data-questions="<?php echo e(json_encode($quizData)); ?>">

                    <!-- Quiz Header -->
                    <div class="flex items-center justify-between border-b border-gray-800 pb-4 mb-4">
                        <div>
                            <h4 class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">GK / IQ Practice Quiz</h4>
                            <p class="text-sm font-bold text-gray-200"><?php echo e($lesson->title); ?> — Practice Test</p>
                        </div>
                        <div class="text-right">
                            <p id="quiz-progress-text" class="text-xs font-bold text-gray-400">Question 1 of <?php echo e(count($quizData)); ?></p>
                            <div class="w-24 bg-gray-800 h-1.5 rounded-full overflow-hidden mt-1 ml-auto">
                                <div id="quiz-progress-bar" class="bg-emerald-500 h-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Question -->
                    <div class="mb-4">
                        <h3 id="quiz-question" class="text-base md:text-xl font-bold mb-4 text-gray-100 leading-snug">Loading question...</h3>
                        
                        <!-- Hint Button & Box -->
                        <div id="quiz-hint-wrapper" class="mb-4">
                            <button type="button" onclick="toggleLessonHint()" id="quiz-hint-btn" class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-500/15 border border-amber-400/30 text-amber-300 hover:bg-amber-500/25 rounded-xl text-xs font-bold transition-all shadow-sm">
                                <i data-lucide="lightbulb" class="w-3.5 h-3.5 text-amber-400"></i>
                                <span>Need a Hint? 💡</span>
                            </button>
                            <div id="quiz-hint-box" class="hidden mt-2 p-3 bg-amber-950/40 border border-amber-500/40 rounded-xl text-amber-200 text-xs leading-relaxed flex items-start gap-2">
                                <i data-lucide="info" class="w-4 h-4 text-amber-400 shrink-0 mt-0.5"></i>
                                <span id="quiz-hint-text"></span>
                            </div>
                        </div>

                        <div id="quiz-options" class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                            <!-- Options generated dynamically -->
                        </div>
                    </div>

                    <!-- Explanation / Feedback Box -->
                    <div id="quiz-explanation" class="hidden mb-4 bg-gray-900 border border-gray-800 p-5 rounded-2xl text-sm text-gray-300 space-y-2">
                        <div id="quiz-explanation-text" class="leading-relaxed"></div>
                        <div class="hidden flex items-center gap-2 pt-2 border-t border-gray-800">
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
                    <p class="text-xs text-gray-400 max-w-sm mb-6 mx-auto">Excellent effort! You have completed the practice test for <?php echo e($lesson->title); ?>.</p>

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

                    <form action="<?php echo e(route('lessons.complete', [$course->slug, $lesson->slug])); ?>" method="POST" class="max-w-xs mx-auto">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="quiz_completed" value="1">
                        <input type="hidden" name="quiz_score" id="quiz-final-score-input" value="0">
                        <input type="hidden" name="quiz_total" id="quiz-final-total-input" value="<?php echo e(count($quizData ?? [])); ?>">
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3.5 rounded-2xl font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-emerald-950/40 transition-all">
                            Submit Score &amp; Continue
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


        <!-- Player Actions Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pb-6 border-b border-gray-100">
            <div>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight mb-1"><?php echo e($lesson->title); ?></h1>
                <div class="flex flex-wrap items-center gap-3">
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                        Current Chapter &bull; <?php echo e($lesson->type); ?> lesson
                    </p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($predictedCompletion) && $predictedCompletion): ?>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 border border-emerald-200 text-emerald-800 text-[11px] font-bold rounded-full">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-emerald-600"></i>
                            Est. Course Finish: <?php echo e($predictedCompletion->format('M d, Y')); ?> (<?php echo e(number_format($paceMultiplier ?? 1.0, 2)); ?>× pace)
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($quizData) || count($quizData) === 0): ?>
                <form action="<?php echo e(route('lessons.complete', [$course->slug, $lesson->slug])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-bold flex items-center justify-center gap-2 shadow-xl shadow-emerald-50 transition-all">
                        Complete Lesson
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                    </button>
                </form>
            <?php else: ?>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 font-bold text-xs shadow-sm">
                        <i data-lucide="help-circle" class="w-4 h-4 text-amber-600"></i>
                        <span>Quiz Practice Required (<?php echo e(count($quizData)); ?> MCQs)</span>
                    </span>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                <?php
                    $isJsonContent = !empty($lesson->content) && (str_starts_with(trim($lesson->content), '[') || str_starts_with(trim($lesson->content), '{'));
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isJsonContent && !empty($lesson->content)): ?>
                    <?php echo $lesson->content; ?>

                <?php elseif($quizData && count($quizData) > 0): ?>
                    <div class="not-prose bg-emerald-50/70 border border-emerald-200/80 rounded-2xl p-6 mb-2">
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                                <i data-lucide="help-circle" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-emerald-900 mb-1">Interactive Practice Test Active</h4>
                                <p class="text-xs text-emerald-700 leading-relaxed">
                                    Take the interactive practice quiz above with live score tracking, hints (💡), and instant Loksewa explanation feedback.
                                </p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="not-prose text-center py-6 text-gray-400">
                        <i data-lucide="book-open" class="w-8 h-8 mx-auto text-gray-300 mb-2"></i>
                        <p class="text-sm font-semibold text-gray-600">Overview Notes for <?php echo e($lesson->title); ?></p>
                        <p class="text-xs text-gray-400 mt-1">Review the study materials above or switch to the Syllabus Study Notes tab for key exam focus areas.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Tab Content: Syllabus Study Notes -->
            <div id="tab-notes" class="tab-panel hidden bg-white p-8 rounded-3xl border border-gray-100 shadow-sm leading-relaxed text-gray-600">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($lesson->module?->notes) || !empty($lesson->module?->key_points)): ?>
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Syllabus Key Focus & Study Notes</h4>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($lesson->module?->key_points)): ?>
                        <div class="mb-6 bg-amber-50/80 border border-amber-200/80 rounded-2xl p-5 text-sm text-amber-900 leading-relaxed font-medium">
                            <div class="flex items-center gap-2 mb-2 font-bold text-amber-950">
                                <i data-lucide="pin" class="w-4 h-4 text-amber-600 rotate-45"></i>
                                <span>High Yield Focus Areas</span>
                            </div>
                            <?php echo nl2br(e($lesson->module->key_points)); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($lesson->module?->notes)): ?>
                        <div class="prose prose-emerald max-w-none text-gray-700 leading-relaxed">
                            <?php echo nl2br(e($lesson->module->notes)); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-8 text-gray-400">
                        <i data-lucide="book-open" class="w-10 h-10 mx-auto text-gray-300 mb-2"></i>
                        <h5 class="text-sm font-bold text-gray-700">No Study Notes Attached</h5>
                        <p class="text-xs text-gray-400 max-w-sm mx-auto mt-1">Study notes have not been added or have been removed for this module.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lesson->attachment_path): ?>
                    <!-- PDF Attachment Section -->
                    <div class="mt-6 p-6 bg-emerald-50 border border-emerald-100 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white text-emerald-500 flex items-center justify-center shadow-sm">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-emerald-800">Chapter PDF Notes Available</p>
                                <p class="text-[10px] text-emerald-600">Download for offline reading and revision</p>
                            </div>
                        </div>
                        <a href="<?php echo e(asset($lesson->attachment_path)); ?>" download class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition-all shadow-md flex items-center gap-1.5">
                            <i data-lucide="download" class="w-3.5 h-3.5"></i>
                            Download PDF
                        </a>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                <h5 class="font-bold text-gray-900 truncate"><?php echo e($course->title); ?></h5>
            </div>
            
            <div class="overflow-y-auto max-h-[60vh] p-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $course->modules->sortBy('order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="mb-4">
                        <div class="px-4 py-2 flex items-center justify-between">
                            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest"><?php echo e($module->title); ?></span>
                            <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-500">M<?php echo e($module->order ?? $loop->iteration); ?></span>
                        </div>
                        <?php
                            $moduleLessons = ($module->lessons->isNotEmpty() ? $module->lessons : ($module->chapters->flatMap->lessons))->sortBy('order');
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $moduleLessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php
                                $isCompleted = in_array($l->id, $completedLessonIds);
                                $isCurrent = $l->id == $lesson->id;
                                $isUnlocked = isset($unlockedLessonIds) ? in_array($l->id, $unlockedLessonIds) : ($isCompleted || $isCurrent);
                            ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isUnlocked): ?>
                                <a href="<?php echo e(route('lessons.show', [$course->slug, $l->slug])); ?>" class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all <?php echo e($isCurrent ? 'bg-emerald-50 text-emerald-700 font-bold border border-emerald-200/60 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                                    <span class="flex items-center gap-2.5 truncate">
                                        <span class="w-5 h-5 rounded-lg <?php echo e($isCurrent ? 'bg-emerald-600 text-white' : ($isCompleted ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500')); ?> text-[10px] font-black flex items-center justify-center shrink-0">
                                            <?php echo e($l->order ?? $loop->iteration); ?>

                                        </span>
                                        <i data-lucide="book-open" class="w-3.5 h-3.5 <?php echo e($isCurrent ? 'text-emerald-600' : ($isCompleted ? 'text-emerald-500' : 'text-gray-400')); ?> shrink-0"></i>
                                        <span class="text-xs truncate font-medium"><?php echo e($l->title); ?></span>
                                    </span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isCompleted): ?>
                                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-500 shrink-0" title="Lesson Completed"></i>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </a>
                            <?php else: ?>
                                <div class="flex items-center justify-between px-4 py-3 rounded-2xl text-gray-400 bg-gray-50/50 cursor-not-allowed opacity-75 select-none" title="Complete previous lessons to unlock">
                                    <span class="flex items-center gap-2.5 truncate">
                                        <span class="w-5 h-5 rounded-lg bg-gray-100 text-gray-400 text-[10px] font-bold flex items-center justify-center shrink-0">
                                            <?php echo e($l->order ?? $loop->iteration); ?>

                                        </span>
                                        <i data-lucide="lock" class="w-3.5 h-3.5 text-gray-300 shrink-0"></i>
                                        <span class="text-xs truncate font-normal text-gray-400"><?php echo e($l->title); ?></span>
                                    </span>
                                    <span class="text-[9px] font-extrabold uppercase tracking-wider text-gray-400 px-1.5 py-0.5 bg-gray-100 rounded">Locked</span>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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
    const lessonId = "<?php echo e($lesson->id); ?>";
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

        window.toggleLessonHint = function() {
            const hintBox = document.getElementById('quiz-hint-box');
            if (hintBox) hintBox.classList.toggle('hidden');
        };

        function loadQuestion() {
            if (questions.length === 0) return;

            selectedOptionIndex = null;
            quizNextBtn.classList.add('hidden');
            quizExplanation.classList.add('hidden');

            const q = questions[currentQuestionIndex];
            quizQuestion.textContent = q.question;
            quizProgressText.textContent = `Question ${currentQuestionIndex + 1} of ${questions.length}`;
            quizProgressBar.style.width = `${((currentQuestionIndex) / questions.length) * 100}%`;

            // Hint Setup
            const hintBtn = document.getElementById('quiz-hint-btn');
            const hintBox = document.getElementById('quiz-hint-box');
            const hintText = document.getElementById('quiz-hint-text');
            if (hintBox) hintBox.classList.add('hidden');
            if (q.hint && q.hint.trim() !== '') {
                if (hintBtn) hintBtn.classList.remove('hidden');
                if (hintText) hintText.textContent = q.hint;
            } else {
                if (hintBtn) hintBtn.classList.add('hidden');
            }

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
            const correctIndex = parseInt(q.answer);
            const isUserCorrect = (index === correctIndex);

            // Update all buttons based on correct/incorrect choices
            const buttons = quizOptions.querySelectorAll('button');
            buttons.forEach((btn, idx) => {
                btn.disabled = true;
                btn.classList.remove('hover:border-gray-700');
                
                const optionText = q.options[idx];
                const letter = String.fromCharCode(65 + idx);

                if (idx === index) {
                    if (isUserCorrect) {
                        // User clicked correct answer -> Green with Correct badge
                        btn.className = "w-full bg-emerald-950/80 border-2 border-emerald-500 text-white text-left p-4 rounded-2xl transition-all font-bold text-xs flex items-center justify-between shadow-lg shadow-emerald-950/50";
                        btn.innerHTML = `
                            <span class="flex items-center gap-3">
                                <span class="w-6 h-6 rounded-lg bg-emerald-500 text-slate-950 flex items-center justify-center font-black text-xs shrink-0">${letter}</span>
                                <span class="leading-relaxed text-emerald-100">${optionText}</span>
                            </span>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-500 text-slate-950 text-[10px] font-black tracking-wide shadow-sm shrink-0">
                                ✔ Correct
                            </span>
                        `;
                    } else {
                        // User clicked wrong answer -> Red with Your Answer badge
                        btn.className = "w-full bg-rose-950/80 border-2 border-rose-500 text-white text-left p-4 rounded-2xl transition-all font-bold text-xs flex items-center justify-between shadow-lg shadow-rose-950/50 animate-shake";
                        btn.innerHTML = `
                            <span class="flex items-center gap-3">
                                <span class="w-6 h-6 rounded-lg bg-rose-500 text-white flex items-center justify-center font-black text-xs shrink-0">${letter}</span>
                                <span class="leading-relaxed text-rose-100">${optionText}</span>
                            </span>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-rose-500 text-white text-[10px] font-black tracking-wide shadow-sm shrink-0">
                                ✖ Your Answer
                            </span>
                        `;
                    }
                } else if (!isUserCorrect && idx === correctIndex) {
                    // When user is wrong, ALSO show the correct option in a distinctive red/rose indicator
                    btn.className = "w-full bg-rose-950/40 border-2 border-rose-400 text-rose-100 text-left p-4 rounded-2xl transition-all font-bold text-xs flex items-center justify-between shadow-md shadow-rose-950/30";
                    btn.innerHTML = `
                        <span class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-lg bg-rose-600/80 text-white flex items-center justify-center font-black text-xs shrink-0">${letter}</span>
                            <span class="leading-relaxed text-rose-200">${optionText}</span>
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-rose-500/20 border border-rose-500/60 text-rose-300 text-[10px] font-bold tracking-wide shadow-sm shrink-0">
                            ✔ Correct Answer
                        </span>
                    `;
                } else {
                    // Mute other unselected choices
                    btn.className = "w-full bg-gray-950/40 border border-gray-900 text-left p-4 rounded-2xl transition-all font-medium text-xs flex items-center justify-between text-gray-500 opacity-30";
                    btn.innerHTML = `
                        <span class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-lg bg-gray-800 text-gray-500 flex items-center justify-center font-bold text-xs shrink-0">${letter}</span>
                            <span class="leading-relaxed">${optionText}</span>
                        </span>
                    `;
                }
            });

            if (isUserCorrect) {
                score++;
                quizCorrectCount.textContent = score;

                // For correct answer: Show congratulatory banner and full explanation
                const statusBanner = `<div class="p-2.5 bg-emerald-500/20 border border-emerald-500/40 rounded-xl text-emerald-300 text-xs font-bold flex items-center gap-2 mb-2"><span>✔ Correct! You selected Option ${String.fromCharCode(65 + index)}.</span></div>`;
                const explanationContent = (q.explanation && q.explanation.trim() !== '') ? `<div class="mt-2 text-xs text-gray-300 leading-relaxed"><strong class="text-emerald-400 block mb-1">Loksewa Explanation:</strong>${q.explanation}</div>` : '';
                
                quizExplanationText.innerHTML = statusBanner + explanationContent;
                
                const answerEl = document.getElementById('quiz-correct-answer');
                if (answerEl) {
                    answerEl.parentElement.classList.remove('hidden');
                    answerEl.textContent = `Correct Answer: Option ${String.fromCharCode(65 + correctIndex)} (${q.options[correctIndex]})`;
                }
                quizExplanation.classList.remove('hidden');
            } else {
                // For incorrect answer: Show red banner with correct option and explanation in red style
                const statusBanner = `<div class="p-3 bg-rose-500/20 border border-rose-500/40 rounded-xl text-rose-200 text-xs font-bold flex flex-col gap-1 mb-2">
                    <span class="flex items-center gap-1.5 text-rose-300 font-extrabold">✖ Incorrect Option Selected</span>
                    <span class="text-rose-100 font-medium">Correct Answer is <strong class="text-white underline">Option ${String.fromCharCode(65 + correctIndex)}: ${q.options[correctIndex]}</strong></span>
                </div>`;
                const explanationContent = (q.explanation && q.explanation.trim() !== '') ? `<div class="mt-2 text-xs text-gray-300 leading-relaxed"><strong class="text-rose-400 block mb-1">Loksewa Reference & Explanation:</strong>${q.explanation}</div>` : '';
                
                quizExplanationText.innerHTML = statusBanner + explanationContent;
                
                const answerEl = document.getElementById('quiz-correct-answer');
                if (answerEl) {
                    answerEl.parentElement.classList.remove('hidden');
                    answerEl.textContent = `Correct Answer: Option ${String.fromCharCode(65 + correctIndex)} (${q.options[correctIndex]})`;
                }
                quizExplanation.classList.remove('hidden');
            }

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

                const scoreInput = document.getElementById('quiz-final-score-input');
                if (scoreInput) scoreInput.value = score;
                const totalInput = document.getElementById('quiz-final-total-input');
                if (totalInput) totalInput.value = questions.length;
            }
        };

        // Initialize first question
        loadQuestion();
    }

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.lms', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\loksewa_course\resources\views/frontend/lessons/show.blade.php ENDPATH**/ ?>