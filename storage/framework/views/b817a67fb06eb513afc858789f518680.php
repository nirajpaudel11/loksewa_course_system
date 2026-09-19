<?php $__env->startSection('title', 'Course Catalog | Loksewa LMS'); ?>
<?php $__env->startSection('header', 'Catalog'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Explore Catalog</h3>
                <p class="text-gray-500">Discover your next passion from our curated list of professional courses.</p>
            </div>

            <form action="<?php echo e(url('/catalog')); ?>" method="GET" class="relative">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                <input type="text" name="search" value="<?php echo e($search ?? ''); ?>" placeholder="Search courses..."
                    class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none w-full md:w-64 transition-all shadow-sm">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search): ?>
                    <a href="<?php echo e(url('/catalog')); ?>"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i data-lucide="x" class="w-3 h-3"></i>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div
                    class="group bg-white rounded-2xl border border-gray-200 overflow-hidden hover:border-emerald-200 transition-all hover:shadow-2xl hover:shadow-emerald-50 shadow-sm flex flex-col">
                    <div class="h-52 overflow-hidden relative">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course->thumbnail): ?>
                            <img src="<?php echo e(Str::startsWith($course->thumbnail, 'http') ? $course->thumbnail : Storage::url($course->thumbnail)); ?>" alt="<?php echo e($course->title); ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <?php else: ?>
                            <div class="w-full h-full bg-emerald-50 text-emerald-700 flex items-center justify-center font-black text-4xl">
                                <?php echo e(strtoupper(substr($course->title, 0, 1))); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                            <a href="<?php echo e(url('/courses/' . $course->slug)); ?>"
                                class="w-full bg-white text-gray-900 py-3 rounded-xl font-bold text-center text-sm shadow-xl">
                                View Course Details
                            </a>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div
                            class="flex items-center gap-2 text-emerald-600 text-[10px] font-black uppercase tracking-tighter mb-2">
                            <i data-lucide="book-open" class="w-3 h-3"></i>
                            Open Access Course
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-3 leading-tight"><?php echo e($course->title); ?></h4>
                        <p class="text-gray-500 text-sm mb-6 leading-relaxed flex-1">
                            <?php echo e(Str::limit($course->description, 120)); ?>

                        </p>
                        <div class="flex items-center justify-end pt-4 border-t border-gray-50">
                            <i data-lucide="chevron-right"
                                class="w-4 h-4 text-emerald-500 opacity-0 group-hover:opacity-100 transition-all"></i>
                        </div>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="col-span-full py-20 text-center bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                    <i data-lucide="search-x" class="w-12 h-12 text-gray-300 mx-auto mb-4"></i>
                    <h4 class="text-lg font-bold text-gray-900 mb-2">No courses found</h4>
                    <p class="text-gray-500 mb-6">We couldn't find anything matching "<?php echo e($search); ?>".</p>
                    <a href="<?php echo e(url('/catalog')); ?>" class="text-emerald-600 font-bold hover:underline">Clear Search</a>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="mt-8">
            <?php echo e($courses->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.lms', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\loksewa_course\resources\views/frontend/catalog.blade.php ENDPATH**/ ?>