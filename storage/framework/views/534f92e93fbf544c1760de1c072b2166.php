<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Courses | Loksewa Path</title>
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
                <a href="<?php echo e(route('landing')); ?>" class="landing-nav-link">Home</a>
                <a href="<?php echo e(route('login')); ?>" class="landing-btn landing-btn-light">Sign In</a>
                <a href="<?php echo e(route('register')); ?>" class="landing-btn landing-btn-primary">Sign Up</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="public-page-hero">
            <div class="max-w-7xl mx-auto px-6">
                <p class="landing-kicker">Course catalog</p>
                <h1>Browse Loksewa preparation paths.</h1>
                <p>Preview available courses before signing in. Sign in when you are ready to enroll, track progress, and continue lessons.</p>

                <form action="<?php echo e(url('/catalog')); ?>" method="GET" class="public-search">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    <input type="text" name="search" value="<?php echo e($search ?? ''); ?>" placeholder="Search courses by title or topic">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search): ?>
                        <a href="<?php echo e(url('/catalog')); ?>" aria-label="Clear search"><i data-lucide="x" class="w-4 h-4"></i></a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </form>
            </div>
        </section>

        <section class="landing-section landing-section-soft">
            <div class="max-w-7xl mx-auto px-6">
                <div class="landing-course-grid">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <article class="landing-course-card">
                            <div class="landing-course-media">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course->thumbnail): ?>
                                    <img src="<?php echo e(Str::startsWith($course->thumbnail, 'http') ? $course->thumbnail : Storage::url($course->thumbnail)); ?>" alt="<?php echo e($course->title); ?>">
                                <?php else: ?>
                                    <div class="landing-course-fallback"><?php echo e(strtoupper(substr($course->title, 0, 1))); ?></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="landing-course-body">
                                <div class="landing-course-meta">
                                    <i data-lucide="book-open" class="w-3 h-3"></i>
                                    Public Preview
                                </div>
                                <h3><?php echo e($course->title); ?></h3>
                                <p><?php echo e(Str::limit($course->description, 130)); ?></p>
                                <a href="<?php echo e(route('courses.details', $course->slug)); ?>">
                                    View course
                                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </article>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="public-empty">
                            <i data-lucide="search-x" class="w-12 h-12"></i>
                            <h2>No courses found</h2>
                            <p>Try a different search term or return to the full catalog.</p>
                            <a href="<?php echo e(url('/catalog')); ?>" class="landing-btn landing-btn-primary">Clear Search</a>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="mt-8">
                    <?php echo e($courses->links()); ?>

                </div>
            </div>
        </section>
    </main>

    <script src="<?php echo e(asset('js/icons.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\loksewa_course\resources\views/frontend/public-catalog.blade.php ENDPATH**/ ?>