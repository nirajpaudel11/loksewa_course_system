<?php $__env->startSection('title', 'Analytics | Loksewa LMS'); ?>
<?php $__env->startSection('header', 'Learning Analytics'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto py-6">
    <div class="text-center mb-10">
        <div class="w-16 h-16 bg-emerald-50 rounded-3xl flex items-center justify-center text-emerald-600 mx-auto mb-4 shadow-sm">
            <i data-lucide="bar-chart-3" class="w-8 h-8"></i>
        </div>
        <h3 class="text-3xl font-black text-gray-900 mb-2 tracking-tight">Your Real-Time Learning Analytics</h3>
        <p class="text-gray-500 text-sm max-w-lg mx-auto">Track your study velocity, pacing forecast, and completion rate calculated in real time.</p>
    </div>
    
    <!-- Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Enrolled Courses</p>
            <p class="text-3xl font-black text-gray-900"><?php echo e($totalEnrollments); ?></p>
            <p class="text-xs text-gray-400 mt-1">Active syllabus tracks</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Completion Rate</p>
            <p class="text-3xl font-black text-emerald-600"><?php echo e($completionRate); ?>%</p>
            <div class="w-full bg-gray-100 h-1.5 rounded-full mt-3 overflow-hidden">
                <div class="bg-emerald-500 h-full transition-all duration-1000" style="width: <?php echo e($completionRate); ?>%"></div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Lessons Finished</p>
            <p class="text-3xl font-black text-gray-900"><?php echo e($completedLessonsCount); ?></p>
            <p class="text-xs text-gray-400 mt-1">Completed study items</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Pace Multiplier</p>
            <p class="text-3xl font-black text-sky-600"><?php echo e(number_format($paceMultiplier ?? 1.0, 2)); ?>×</p>
            <p class="text-xs text-gray-400 mt-1">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($paceMultiplier ?? 1.0) < 0.9): ?>
                    🚀 Fast track speed
                <?php elseif(($paceMultiplier ?? 1.0) <= 1.1): ?>
                    ⏱️ Standard baseline
                <?php else: ?>
                    📚 Deliberate speed
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Pacing Breakdown Table -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($enrolledPacing) && count($enrolledPacing) > 0): ?>
        <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h4 class="text-lg font-black text-gray-900">Course Pacing &amp; Estimated Readiness</h4>
                    <p class="text-xs text-gray-400">Projected completion date based on your historical learning velocity</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-gray-100 text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-3 px-4">Course</th>
                            <th class="py-3 px-4">Lessons Done</th>
                            <th class="py-3 px-4">Remaining</th>
                            <th class="py-3 px-4 text-right">Projected Finish Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $enrolledPacing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="py-4 px-4 font-bold text-gray-900"><?php echo e($p['course']->title); ?></td>
                                <td class="py-4 px-4 text-gray-600"><?php echo e($p['completed_lessons']); ?> / <?php echo e($p['total_lessons']); ?></td>
                                <td class="py-4 px-4 text-gray-600"><?php echo e($p['remaining_lessons']); ?> lessons</td>
                                <td class="py-4 px-4 text-right font-bold">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($p['remaining_lessons'] === 0): ?>
                                        <span class="text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">Completed 🎉</span>
                                    <?php elseif($p['predicted_date']): ?>
                                        <span class="text-sky-700 bg-sky-50 px-3 py-1 rounded-full border border-sky-200"><?php echo e($p['predicted_date']->format('M d, Y')); ?></span>
                                    <?php else: ?>
                                        <span class="text-gray-400">Calibrating...</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="text-center">
        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 inline-flex items-center gap-2 text-xs text-emerald-800 font-medium">
            <i data-lucide="sparkles" class="w-4 h-4 text-emerald-600 shrink-0"></i>
            <span>Your pacing metrics are recalculated in real time whenever you complete a lesson or quiz.</span>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.lms', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\loksewa_course\resources\views/frontend/analytics.blade.php ENDPATH**/ ?>