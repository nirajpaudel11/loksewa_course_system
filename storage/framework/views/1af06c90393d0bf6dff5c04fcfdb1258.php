<?php $__env->startSection('title', $course->title . ' | Loksewa LMS'); ?>
<?php $__env->startSection('header', 'Course Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto">
    <!-- Feedback Alerts -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-sm">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 shrink-0"></i>
            <span class="font-bold text-sm"><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('warning')): ?>
        <div class="mb-8 p-4 bg-amber-50 border border-amber-200 text-amber-900 rounded-2xl flex items-center gap-3 shadow-sm">
            <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-600 shrink-0"></i>
            <span class="font-bold text-sm"><?php echo e(session('warning')); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('info')): ?>
        <div class="mb-8 p-4 bg-sky-50 border border-sky-200 text-sky-900 rounded-2xl flex items-center gap-3 shadow-sm">
            <i data-lucide="info" class="w-5 h-5 text-sky-600 shrink-0"></i>
            <span class="font-bold text-sm"><?php echo e(session('info')); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        <div class="mb-8 p-4 bg-rose-50 border border-rose-200 text-rose-900 rounded-2xl flex items-center gap-3 shadow-sm">
            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600 shrink-0"></i>
            <span class="font-bold text-sm"><?php echo e(session('error')); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-medium text-gray-400 mb-8">
        <a href="<?php echo e(url('/catalog')); ?>" class="hover:text-emerald-600 transition-colors">Catalog</a>
        <i data-lucide="chevron-right" class="w-3 h-3"></i>
        <span class="text-gray-900 font-bold"><?php echo e($course->title); ?></span>
    </nav>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isEnrolled && $enrollment && $enrollment->status === 'rejected'): ?>
        <div class="mb-8 p-4 bg-rose-50 border border-rose-200 text-rose-900 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <i data-lucide="x-circle" class="w-5 h-5"></i>
                </div>
                <div>
                    <h5 class="text-xs font-extrabold text-rose-900 uppercase tracking-wider">Enrollment Notice</h5>
                    <p class="text-xs text-rose-700 mt-0.5">Your enrollment request for this course was rejected by the administrator. Lesson access is currently locked. You can submit a new application below.</p>
                </div>
            </div>
            <form action="<?php echo e(route('courses.enroll', $course->id)); ?>" method="POST" class="shrink-0 w-full sm:w-auto">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-1.5">
                    <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                    <span>Re-apply Now</span>
                </button>
            </form>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Left: Course Info & Modules Content -->
        <div class="flex-1 min-w-0">
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-black text-gray-900 mb-4 tracking-tight leading-tight"><?php echo e($course->title); ?></h1>
                <p class="text-base text-gray-600 leading-relaxed mb-6 max-w-3xl"><?php echo e($course->description); ?></p>
                
                <div class="flex flex-wrap gap-6 py-6 border-y border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <i data-lucide="layers" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Curriculum</p>
                            <p class="text-sm font-bold text-gray-900"><?php echo e($course->modules->count()); ?> Modules</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center text-sky-600">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Course Syllabus</p>
                            <p class="text-sm font-bold text-gray-900"><?php echo e($courseSyllabusUrl ? 'Master PDF Ready' : 'PSC Standard'); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Verification</p>
                            <p class="text-sm font-bold text-gray-900">Admin Approved</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 1. COURSE MASTER SYLLABUS PDF BANNER (Outside Module Content) -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($courseSyllabusUrl): ?>
                <div class="mb-10 p-6 bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-950 text-white rounded-3xl border border-slate-700/80 shadow-xl relative overflow-hidden">
                    <div class="flex items-start gap-4 mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center shrink-0 shadow-inner mt-0.5">
                            <i data-lucide="file-text" class="w-6 h-6"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/30 border border-emerald-400/40 text-[9px] font-extrabold uppercase tracking-widest text-emerald-200 mb-1.5">
                                <span>Master Curriculum PDF</span>
                            </div>
                            <h3 class="text-lg md:text-xl font-black text-white leading-snug">Official Loksewa Course Syllabus</h3>
                            <p class="text-xs md:text-sm text-slate-300 mt-1 leading-relaxed">Complete curriculum specifications, paper structure, and marks distribution.</p>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-slate-700/60 flex flex-wrap items-center gap-3">
                        <a href="<?php echo e($courseSyllabusUrl); ?>" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-100 border border-slate-600 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-sm">
                            <i data-lucide="external-link" class="w-4 h-4 text-emerald-400"></i>
                            <span>Open Syllabus</span>
                        </a>
                        <a href="<?php echo e($courseSyllabusUrl); ?>" download class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-md">
                            <i data-lucide="download" class="w-4 h-4"></i>
                            <span>Download PDF</span>
                        </a>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- COURSE FLASHCARDS (1 MCQ per Lesson) BANNER -->
            <div class="mb-10 p-5 md:p-6 bg-gradient-to-r from-amber-950 via-slate-900 to-slate-900 text-white rounded-3xl border border-amber-500/40 shadow-xl flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/20 border border-amber-500/30 text-amber-400 flex items-center justify-center shrink-0 shadow-inner">
                        <i data-lucide="brain-circuit" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-500/20 border border-amber-400/30 text-[9px] font-extrabold uppercase tracking-widest text-amber-300 mb-1">
                            <span>🧠 Spaced Repetition Flashcards</span>
                            <span>&bull;</span>
                            <span>1 MCQ / Lesson</span>
                        </div>
                        <h3 class="text-base font-black text-white leading-snug">Quick Recall Flashcards Deck</h3>
                        <p class="text-xs text-slate-300">Extracts 1 high-yield MCQ from each lesson of this course to reinforce long-term exam retention.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2.5 shrink-0 w-full md:w-auto justify-end">
                    <a href="<?php echo e(route('courses.flashcards', [$course->slug, 'mode' => 'due'])); ?>" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 rounded-xl font-black text-xs flex items-center gap-1.5 transition-all shadow-md">
                        <i data-lucide="zap" class="w-3.5 h-3.5"></i>
                        <span>Start Flashcard Review</span>
                    </a>
                </div>
            </div>

            <!-- 2. MODULES SECTION (Course -> Modules) -->
            <div class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 tracking-tight">Course Modules &amp; Study Tracks</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Explore syllabus notes, key focus points, module PDFs, and practice quizzes for each module.</p>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->hasRole('admin')): ?>
                        <button onclick="toggleModuleBuilder()" class="text-xs font-bold text-emerald-600 px-3.5 py-1.5 bg-emerald-50 rounded-xl hover:bg-emerald-100 transition-colors">+ Add Module</button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->hasRole('admin')): ?>
                    <div id="module-builder" class="hidden mb-6 p-5 border border-emerald-200 rounded-3xl bg-emerald-50/70 shadow-sm">
                        <form method="POST" action="<?php echo e(route('admin.modules.add', $course)); ?>">
                            <?php echo csrf_field(); ?>
                            <label class="block text-xs font-bold text-emerald-900 uppercase tracking-wider mb-2">New Module Title</label>
                            <div class="flex gap-2">
                                <input type="text" name="title" required class="flex-1 px-4 py-2.5 border border-emerald-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none" placeholder="e.g., Nepal Constitution and Governance" />
                                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs transition-colors">Create Module</button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="space-y-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $course->modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $mod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $quizCount = 0;
                            if (!empty($mod->quiz_questions)) {
                                $rawQ = is_string($mod->quiz_questions) ? json_decode($mod->quiz_questions, true) : $mod->quiz_questions;
                                $quizCount = is_array($rawQ) ? count($rawQ) : 0;
                            }
                            $canAccess = $isEnrolled && $enrollment && in_array($enrollment->status, ['active', 'completed']);
                            $isPending = $isEnrolled && $enrollment && $enrollment->status === 'pending';
                        ?>
                        <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm hover:shadow-md hover:border-emerald-100 transition-all flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2 flex-wrap">
                                    <span class="w-7 h-7 rounded-lg bg-gray-900 text-white flex items-center justify-center text-xs font-black shrink-0">
                                        <?php echo e($index + 1); ?>

                                    </span>
                                    <h4 class="text-lg font-bold text-gray-900 tracking-tight"><?php echo e($mod->title); ?></h4>
                                </div>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mod->description): ?>
                                    <p class="text-xs text-gray-500 line-clamp-2 mb-3 leading-relaxed"><?php echo e($mod->description); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php
                                    $modLessons = $mod->lessons->isNotEmpty() ? $mod->lessons : ($mod->chapters->flatMap->lessons);
                                    $hasPdfLessons = $modLessons->contains(fn($l) => !empty($l->attachment_path));
                                ?>

                                <!-- Module Feature Badges -->
                                <div class="flex items-center gap-2 flex-wrap pt-1">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasPdfLessons): ?>
                                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-rose-700 bg-rose-50 px-2.5 py-0.5 rounded-full border border-rose-200">
                                            <i data-lucide="file-text" class="w-3 h-3 text-rose-500"></i>
                                            Lesson PDF Documents
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mod->key_points): ?>
                                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-800 bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-200">
                                            <i data-lucide="pin" class="w-3 h-3 text-amber-600"></i>
                                            Key Focus Points
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mod->notes): ?>
                                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-sky-800 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200">
                                            <i data-lucide="book-open" class="w-3 h-3 text-sky-600"></i>
                                            Module Overview
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quizCount > 0): ?>
                                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                                            <i data-lucide="help-circle" class="w-3 h-3 text-emerald-600"></i>
                                            Practice Quiz (<?php echo e($quizCount); ?> Qs)
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <!-- Direct Lessons inside this Module -->
                                <?php
                                    $modLessons = $mod->lessons->isNotEmpty() ? $mod->lessons : ($mod->chapters->flatMap->lessons);
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($modLessons->isNotEmpty()): ?>
                                    <div class="mt-4 pt-4 border-t border-gray-100 space-y-2">
                                        <p class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400">Included Lessons (<?php echo e($modLessons->count()); ?>):</p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                             <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $modLessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                 <?php
                                                     $isCompleted = in_array($l->id, $completedLessonIds ?? []);
                                                     $isUnlocked = $canAccess && (isset($unlockedLessonIds) ? in_array($l->id, $unlockedLessonIds) : true);
                                                 ?>
                                                 <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canAccess && $isUnlocked): ?>
                                                     <a href="<?php echo e(route('lessons.show', [$course->slug, $l->slug])); ?>" class="p-2.5 rounded-xl <?php echo e($isCompleted ? 'bg-emerald-50/60 border-emerald-200/80 text-emerald-900' : 'bg-gray-50/80 hover:bg-emerald-50 border-gray-200/60 hover:border-emerald-200 text-gray-700 hover:text-emerald-800'); ?> border flex items-center justify-between text-xs font-semibold transition-all group">
                                                         <span class="flex items-center gap-2 truncate">
                                                             <i data-lucide="book-open" class="w-3.5 h-3.5 <?php echo e($isCompleted ? 'text-emerald-600' : 'text-gray-400 group-hover:text-emerald-600'); ?> shrink-0"></i>
                                                             <span class="truncate"><?php echo e($l->title); ?></span>
                                                         </span>
                                                         <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isCompleted): ?>
                                                             <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600 shrink-0" title="Completed"></i>
                                                         <?php else: ?>
                                                             <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-emerald-600 shrink-0"></i>
                                                         <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                     </a>
                                                 <?php elseif($canAccess && !$isUnlocked): ?>
                                                     <div class="p-2.5 rounded-xl bg-gray-50/50 border border-gray-200/40 flex items-center justify-between text-xs font-medium text-gray-400 select-none" title="Complete previous lessons to unlock">
                                                         <span class="flex items-center gap-2 truncate">
                                                             <i data-lucide="lock" class="w-3.5 h-3.5 text-gray-300 shrink-0"></i>
                                                             <span class="truncate text-gray-400"><?php echo e($l->title); ?></span>
                                                         </span>
                                                         <span class="text-[9px] uppercase font-bold px-1.5 py-0.5 rounded bg-gray-100 text-gray-400">Locked</span>
                                                     </div>
                                                 <?php else: ?>
                                                     <div class="p-2.5 rounded-xl bg-gray-50/50 border border-gray-200/50 flex items-center justify-between text-xs font-medium text-gray-400">
                                                         <span class="flex items-center gap-2 truncate">
                                                             <i data-lucide="lock" class="w-3.5 h-3.5 text-gray-300 shrink-0"></i>
                                                             <span class="truncate"><?php echo e($l->title); ?></span>
                                                         </span>
                                                         <span class="text-[10px] uppercase font-bold text-gray-300"><?php echo e($l->duration_minutes); ?>m</span>
                                                     </div>
                                                 <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                             <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <!-- Action CTA -->
                            <div class="shrink-0 w-full md:w-auto">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canAccess): ?>
                                    <a href="<?php echo e(route('modules.show', [$course->slug, $mod->slug])); ?>" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-gray-900 hover:bg-emerald-600 text-white font-bold text-xs transition-all shadow-sm">
                                        <span>Open Module Hub</span>
                                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                    </a>
                                <?php elseif($isPending): ?>
                                    <span class="w-full md:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold">
                                        <i data-lucide="lock" class="w-3.5 h-3.5 text-amber-600"></i>
                                        <span>Verification Pending</span>
                                    </span>
                                <?php elseif($isEnrolled && $enrollment && $enrollment->status === 'rejected'): ?>
                                    <span class="w-full md:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold">
                                        <i data-lucide="x-circle" class="w-3.5 h-3.5 text-rose-600"></i>
                                        <span>Request Rejected</span>
                                    </span>
                                <?php else: ?>
                                    <span class="w-full md:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-gray-400 text-xs font-bold">
                                        <i data-lucide="lock" class="w-3.5 h-3.5 text-gray-300"></i>
                                        <span>Enroll to Access</span>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="p-10 text-center bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl">
                            <i data-lucide="layers" class="w-10 h-10 text-gray-300 mx-auto mb-3"></i>
                            <p class="text-gray-500 font-medium text-sm">Course modules are currently being prepared for <?php echo e($course->title); ?>.</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Related Courses (Algorithm 2) -->
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-6">Related Preparation Materials</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $relatedCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <a href="<?php echo e(url('/courses/' . $rel->slug)); ?>" class="group block">
                            <div class="aspect-video rounded-2xl overflow-hidden mb-3 border border-gray-100 shadow-sm">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rel->thumbnail): ?>
                                    <img src="<?php echo e(Str::startsWith($rel->thumbnail, 'http') ? $rel->thumbnail : Storage::url($rel->thumbnail)); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="<?php echo e($rel->title); ?>">
                                <?php else: ?>
                                    <div class="w-full h-full bg-emerald-50 text-emerald-700 flex items-center justify-center font-black text-3xl">
                                        <?php echo e(strtoupper(substr($rel->title, 0, 1))); ?>

                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <h6 class="font-bold text-gray-900 group-hover:text-emerald-600 transition-colors leading-tight text-sm"><?php echo e($rel->title); ?></h6>
                        </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right: Action Card -->
        <div class="lg:w-96">
            <div class="bg-white rounded-3xl border border-gray-200 p-8 shadow-2xl shadow-gray-100 sticky top-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-black text-emerald-600 mb-1">Free Access</h2>
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Public Learning Resource</p>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isEnrolled && $enrollment): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($enrollment->status === 'pending'): ?>
                        <div class="space-y-4">
                            <div class="bg-amber-50 p-5 rounded-2xl border border-amber-200 text-center">
                                <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-2.5">
                                    <i data-lucide="clock" class="w-5 h-5"></i>
                                </div>
                                <h5 class="text-amber-900 font-extrabold text-sm mb-1">Verification Pending ⏳</h5>
                                <p class="text-amber-800 text-xs leading-relaxed mb-2">Your enrollment request has been submitted and is awaiting administrator verification.</p>
                                <span class="inline-block px-3 py-1 bg-amber-200/80 text-amber-900 rounded-full text-[11px] font-bold">
                                    Admin Approval Required
                                </span>
                            </div>

                            <button disabled class="w-full block text-center bg-slate-100 border border-slate-200 text-slate-400 py-3.5 rounded-2xl font-bold text-xs cursor-not-allowed">
                                🔒 Content Locked • Awaiting Approval
                            </button>

                            <form action="<?php echo e(route('courses.unenroll', $course->id)); ?>" method="POST" class="mt-2">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full text-center text-gray-400 hover:text-red-500 text-xs font-bold uppercase tracking-wider transition-colors">
                                    Cancel Enrollment Request
                                </button>
                            </form>
                        </div>
                    <?php elseif($enrollment->status === 'rejected'): ?>
                        <div class="space-y-4">
                            <div class="bg-rose-50 p-5 rounded-2xl border border-rose-200 text-center">
                                <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-2.5">
                                    <i data-lucide="x-circle" class="w-5 h-5"></i>
                                </div>
                                <h5 class="text-rose-900 font-extrabold text-sm mb-1">Enrollment Rejected ❌</h5>
                                <p class="text-rose-700 text-xs leading-relaxed mb-2">Your enrollment was not approved by the administrator.</p>
                                <span class="inline-block px-3 py-1 bg-rose-200/80 text-rose-900 rounded-full text-[11px] font-bold">
                                    Access Restricted
                                </span>
                            </div>
                            <form action="<?php echo e(route('courses.enroll', $course->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button class="w-full bg-rose-600 hover:bg-rose-700 text-white py-3.5 rounded-2xl font-bold text-sm transition-all shadow-md flex items-center justify-center gap-2">
                                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                    <span>Re-apply for Enrollment</span>
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <!-- Active / Verified Enrollment -->
                        <div class="space-y-4">
                            <div class="bg-emerald-50 p-5 rounded-2xl border border-emerald-100 text-center">
                                <div class="flex items-center justify-center gap-1.5 text-emerald-800 font-extrabold text-sm mb-2">
                                    <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                                    <span>Verified &amp; Active Student</span>
                                </div>
                                <div class="flex items-center justify-between text-xs font-bold text-emerald-700 mb-1">
                                    <span>Course Progress</span>
                                    <span><?php echo e($progressPercentage ?? 0); ?>%</span>
                                </div>
                                <div class="w-full bg-emerald-200/50 h-2.5 rounded-full overflow-hidden mb-2">
                                    <div class="bg-emerald-600 h-full transition-all duration-1000" style="width: <?php echo e($progressPercentage ?? 0); ?>%"></div>
                                </div>
                                <p class="text-emerald-600 text-[10px] font-semibold uppercase tracking-wider">
                                    <?php echo e(($progressPercentage ?? 0) >= 100 ? 'Course Completed 🎉' : 'Preparation in progress'); ?>

                                </p>
                            </div>
                            <?php 
                                $firstModule = $course->modules->first();
                                $targetUrl = null;
                                if (isset($earliestIncompleteLesson) && $earliestIncompleteLesson) {
                                    $targetUrl = route('lessons.show', [$course->slug, $earliestIncompleteLesson->slug]);
                                } elseif ($firstModule) {
                                    $targetUrl = route('modules.show', [$course->slug, $firstModule->slug]);
                                }
                                $isCourseCompleted = ($progressPercentage ?? 0) >= 100 || ($enrollment->status ?? '') === 'completed';
                            ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($targetUrl): ?>
                                <a href="<?php echo e($targetUrl); ?>" class="w-full block text-center bg-gray-900 hover:bg-black text-white py-4 rounded-2xl font-bold text-base transition-all shadow-xl">
                                    <?php echo e($isCourseCompleted ? 'Review Course Material 📖' : (($progressPercentage ?? 0) > 0 ? 'Resume Learning 🚀' : 'Start Learning 🚀')); ?>

                                </a>
                            <?php else: ?>
                                <div class="bg-gray-50 p-4 rounded-2xl text-center text-xs text-gray-400 italic">No modules available yet.</div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! $isCourseCompleted): ?>
                                <form action="<?php echo e(route('courses.unenroll', $course->id)); ?>" method="POST" class="mt-4">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="w-full text-center text-red-500 hover:text-red-700 text-xs font-bold uppercase tracking-widest transition-colors cursor-pointer">
                                        Unenroll from this course
                                    </button>
                                </form>
                            <?php else: ?>
                                <div class="mt-3 p-3 bg-emerald-50/70 border border-emerald-100 rounded-xl text-center">
                                    <p class="text-[11px] font-bold text-emerald-800 flex items-center justify-center gap-1.5">
                                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600"></i>
                                        Course Completed • Unenrollment Disabled
                                    </p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php else: ?>
                    <form action="<?php echo e(route('courses.enroll', $course->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-bold text-lg transition-all shadow-xl shadow-emerald-100 mb-6">
                            Enroll for Admin Verification
                        </button>
                    </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="space-y-4 pt-8 mt-8 border-t border-gray-100">
                    <h6 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">This path includes:</h6>
                    <div class="flex items-center gap-3 text-sm font-semibold text-gray-600">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500"></i>
                        Official Course Syllabus PDF
                    </div>
                    <div class="flex items-center gap-3 text-sm font-semibold text-gray-600">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500"></i>
                        Module Study PDF Notes
                    </div>
                    <div class="flex items-center gap-3 text-sm font-semibold text-gray-600">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500"></i>
                        Key Points &amp; High-Yield Focus
                    </div>
                    <div class="flex items-center gap-3 text-sm font-semibold text-gray-600">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500"></i>
                        Practice Quizzes with Clues 💡
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleModuleBuilder() {
        const el = document.getElementById('module-builder');
        if (el) el.classList.toggle('hidden');
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.lms', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\loksewa_course\resources\views/frontend/course-details.blade.php ENDPATH**/ ?>