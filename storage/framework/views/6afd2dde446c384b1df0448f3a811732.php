<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loksewa Path | Preparation Courses</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('images/logo-icon.svg')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>
<body class="bg-gray-50 text-gray-900">
    <?php
        $heroCourse = $courses->first();
        $heroImage = $heroCourse?->thumbnail
            ? (Str::startsWith($heroCourse->thumbnail, 'http') ? $heroCourse->thumbnail : Storage::url($heroCourse->thumbnail))
            : null;
    ?>

    <header class="landing-header">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="<?php echo e(route('landing')); ?>" class="landing-brand flex items-center gap-2.5">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Loksewa LMS" style="width: 36px; height: 36px; border-radius: 10px; object-fit: cover; box-shadow: 0 2px 8px rgba(5, 150, 105, 0.25);">
                <span class="font-black text-slate-900 tracking-tight">Loksewa Path</span>
            </a>
            <nav class="flex items-center gap-3">
                <a href="<?php echo e(url('/catalog')); ?>" class="landing-nav-link">Courses</a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="landing-btn landing-btn-dark">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="landing-btn landing-btn-light">Sign In</a>
                    <a href="<?php echo e(route('register')); ?>" class="landing-btn landing-btn-primary">Sign Up</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <section class="landing-hero" <?php if($heroImage): ?> style="background-image: linear-gradient(90deg, rgba(7, 18, 29, .92), rgba(7, 18, 29, .72), rgba(7, 18, 29, .28)), url('<?php echo e($heroImage); ?>')" <?php endif; ?>>
            <div class="landing-hero-inner">
                <p class="landing-kicker">Nepal public service preparation</p>
                <h1 class="landing-title">Prepare for Loksewa with a clear course path.</h1>
                <p class="landing-subtitle">
                    Browse structured preparation tracks, preview lessons and quizzes, then sign in to continue with progress tracking and recommendations.
                </p>
                <div class="landing-actions">
                    <a href="<?php echo e(route('register')); ?>" class="landing-btn landing-btn-primary landing-btn-lg">Create an Account</a>
                    <a href="<?php echo e(route('login')); ?>" class="landing-btn landing-btn-light landing-btn-lg">Student Sign In</a>
                    <a href="<?php echo e(url('/catalog')); ?>" class="landing-btn landing-btn-dark landing-btn-lg">Browse Courses</a>
                </div>
            </div>
        </section>

        <section class="landing-stats">
            <div class="max-w-7xl mx-auto px-6 landing-stats-grid">
                <div>
                    <p class="landing-stat-number"><?php echo e($stats['total_courses']); ?></p>
                    <p class="landing-stat-label">Published courses</p>
                </div>
                <div>
                    <p class="landing-stat-number"><?php echo e($stats['total_lessons']); ?></p>
                    <p class="landing-stat-label">Lessons and quizzes</p>
                </div>
                <div>
                    <p class="landing-stat-number"><?php echo e($stats['total_students']); ?></p>
                    <p class="landing-stat-label">Registered students</p>
                </div>
            </div>
        </section>

        <section class="landing-section">
            <div class="max-w-7xl mx-auto px-6">
                <div class="landing-section-heading">
                    <div>
                        <p class="landing-kicker-dark">How learning works</p>
                        <h2 class="landing-section-title">Move from syllabus to practice without losing context.</h2>
                    </div>
                    <a href="<?php echo e(url('/catalog')); ?>" class="landing-inline-link">
                        Explore catalog
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <div class="landing-steps">
                    <div class="landing-step">
                        <span class="landing-step-icon"><i data-lucide="book-open" class="w-5 h-5"></i></span>
                        <h3>Choose a path</h3>
                        <p>Start from published courses matched to Loksewa preparation levels and subject areas.</p>
                    </div>
                    <div class="landing-step">
                        <span class="landing-step-icon"><i data-lucide="check-circle" class="w-5 h-5"></i></span>
                        <h3>Complete lessons</h3>
                        <p>Study ordered modules, chapters, lesson content, PDFs, and quizzes in one place.</p>
                    </div>
                    <div class="landing-step">
                        <span class="landing-step-icon"><i data-lucide="bar-chart-3" class="w-5 h-5"></i></span>
                        <h3>Track progress</h3>
                        <p>After sign in, your dashboard reveals enrollments, completion status, and next courses.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="landing-section landing-section-soft">
            <div class="max-w-7xl mx-auto px-6">
                <div class="landing-section-heading">
                <div>
                        <p class="landing-kicker-dark">Featured courses</p>
                        <h2 class="landing-section-title">Preview preparation paths before signing in.</h2>
                </div>
                    <a href="<?php echo e(url('/catalog')); ?>" class="landing-inline-link">
                    View full catalog
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            </div>

                <div class="landing-course-grid">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <article class="landing-course-card">
                            <div class="landing-course-media">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course->thumbnail): ?>
                                    <img src="<?php echo e(Str::startsWith($course->thumbnail, 'http') ? $course->thumbnail : Storage::url($course->thumbnail)); ?>" alt="<?php echo e($course->title); ?>">
                            <?php else: ?>
                                    <div class="landing-course-fallback">
                                    <?php echo e(strtoupper(substr($course->title, 0, 1))); ?>

                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                            <div class="landing-course-body">
                                <div class="landing-course-meta">
                                <i data-lucide="book-open" class="w-3 h-3"></i>
                                Open Access
                            </div>
                                <h3><?php echo e($course->title); ?></h3>
                                <p><?php echo e(Str::limit($course->description, 125)); ?></p>
                                <a href="<?php echo e(route('courses.details', $course->slug)); ?>">
                                View course
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </article>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="col-span-full bg-white border border-gray-200 rounded-2xl p-10 text-center">
                        <p class="text-gray-500 font-medium">Courses will appear here after they are published.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </section>
    </main>

    <script src="<?php echo e(asset('js/icons.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\loksewa_course\resources\views/frontend/landing.blade.php ENDPATH**/ ?>