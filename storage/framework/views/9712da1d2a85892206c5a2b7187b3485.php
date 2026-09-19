<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($course->title); ?> | Loksewa Path</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('images/logo-icon.svg')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>
<body class="bg-gray-50 text-gray-900">
    <header class="landing-header">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="<?php echo e(route('landing')); ?>" class="landing-brand flex items-center gap-2.5">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Loksewa LMS" style="width: 36px; height: 36px; border-radius: 10px; object-fit: cover; box-shadow: 0 2px 8px rgba(5, 150, 105, 0.25);">
                <span class="font-black text-slate-900 tracking-tight">Loksewa Path</span>
            </a>
            <nav class="flex items-center gap-3">
                <a href="<?php echo e(url('/catalog')); ?>" class="landing-nav-link">Courses</a>
                <a href="<?php echo e(route('login')); ?>" class="landing-btn landing-btn-light">Sign In</a>
                <a href="<?php echo e(route('register')); ?>" class="landing-btn landing-btn-primary">Sign Up</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="public-course-hero">
            <div class="max-w-7xl mx-auto px-6 public-course-hero-grid">
                <div>
                    <a href="<?php echo e(url('/catalog')); ?>" class="landing-inline-link">
                        <i data-lucide="chevron-right" class="w-4 h-4 public-back-icon"></i>
                        Back to catalog
                    </a>
                    <p class="landing-kicker-dark mt-8">Course preview</p>
                    <h1><?php echo e($course->title); ?></h1>
                    <p><?php echo e($course->description ?: 'Preview this Loksewa preparation course, then sign in to enroll and continue lessons.'); ?></p>
                    <div class="landing-actions">
                        <a href="<?php echo e(route('login')); ?>" class="landing-btn landing-btn-primary landing-btn-lg">Sign In to Start</a>
                        <a href="<?php echo e(route('register')); ?>" class="landing-btn landing-btn-light landing-btn-lg">Create Account</a>
                        <a href="<?php echo e(url('/catalog')); ?>" class="landing-btn landing-btn-dark landing-btn-lg">Browse More</a>
                    </div>
                </div>

                <aside class="public-course-summary">
                    <div>
                        <span><?php echo e($course->modules->count()); ?></span>
                        <p>Modules</p>
                    </div>
                    <div>
                        <span><?php echo e($course->modules->sum(fn ($module) => $module->chapters->count())); ?></span>
                        <p>Chapters</p>
                    </div>
                    <div>
                        <span><?php echo e($course->modules->sum(fn ($module) => $module->chapters->sum(fn ($chapter) => $chapter->lessons->count()))); ?></span>
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $course->modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <article class="public-module-preview">
                                <h3><?php echo e($module->title); ?></h3>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $module->chapters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="public-chapter-preview">
                                        <h4><?php echo e($chapter->title); ?></h4>
                                        <ul>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $chapter->lessons->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <li>
                                                    <i data-lucide="book-open" class="w-4 h-4"></i>
                                                    <span><?php echo e($lesson->title); ?></span>
                                                </li>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </ul>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </article>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <div class="public-empty">
                                <i data-lucide="calendar" class="w-12 h-12"></i>
                                <h2>Curriculum coming soon</h2>
                                <p>This preparation path is being updated.</p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <aside class="public-signin-panel">
                    <h2>Ready to study?</h2>
                    <p>Create an account or sign in to enroll, open lessons, complete quizzes, and track your preparation progress.</p>
                    <div class="flex flex-col gap-2.5 mt-4">
                        <a href="<?php echo e(route('register')); ?>" class="landing-btn landing-btn-primary landing-btn-lg">Create Student Account</a>
                        <a href="<?php echo e(route('login')); ?>" class="landing-btn landing-btn-light landing-btn-lg">Student Sign In</a>
                    </div>
                </aside>
            </div>
        </section>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedCourses->isNotEmpty()): ?>
            <section class="landing-section landing-section-soft">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="landing-section-heading">
                        <div>
                            <p class="landing-kicker-dark">Related courses</p>
                            <h2 class="landing-section-title">Continue exploring similar preparation paths.</h2>
                        </div>
                    </div>
                    <div class="landing-course-grid">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $relatedCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <article class="landing-course-card">
                                <div class="landing-course-media">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($related->thumbnail): ?>
                                        <img src="<?php echo e(Str::startsWith($related->thumbnail, 'http') ? $related->thumbnail : Storage::url($related->thumbnail)); ?>" alt="<?php echo e($related->title); ?>">
                                    <?php else: ?>
                                        <div class="landing-course-fallback"><?php echo e(strtoupper(substr($related->title, 0, 1))); ?></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="landing-course-body">
                                    <div class="landing-course-meta">Related</div>
                                    <h3><?php echo e($related->title); ?></h3>
                                    <p><?php echo e(Str::limit($related->description, 120)); ?></p>
                                    <a href="<?php echo e(route('courses.details', $related->slug)); ?>">
                                        View course
                                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </article>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </main>

    <script src="<?php echo e(asset('js/icons.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\loksewa_course\resources\views/frontend/public-course-details.blade.php ENDPATH**/ ?>