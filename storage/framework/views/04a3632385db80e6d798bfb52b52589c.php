<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Loksewa LMS</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('images/logo-icon.svg')); ?>">
    
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950 flex items-center justify-center min-h-screen p-4 text-slate-900">
    <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-100 shadow-2xl w-full max-w-md relative overflow-hidden">
        <!-- Accent Top Bar -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600"></div>

        <!-- Branding Logo -->
        <div class="text-center mb-8 pt-2">
            <a href="<?php echo e(route('landing')); ?>" class="inline-block hover:scale-105 transition-transform">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Loksewa LMS Logo" class="w-16 h-16 rounded-2xl object-cover mx-auto mb-3 shadow-xl shadow-emerald-500/25 ring-2 ring-emerald-500/30">
            </a>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Loksewa Path</h1>
            <p class="text-slate-400 text-xs font-semibold mt-1">Sign in to your aspirant learning portal</p>
        </div>

        <form action="<?php echo e(url('/login')); ?>" method="POST" class="space-y-5">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                <div class="relative">
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-rose-500 text-xs font-bold mt-1.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-rose-500 text-xs font-bold mt-1.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3.5 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-emerald-600/30 flex items-center justify-center gap-2">
                <span>Sign In to Dashboard</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-slate-100 text-center space-y-2">
            <p class="text-xs text-slate-500 font-medium">
                Don't have an account? 
                <a href="<?php echo e(route('register')); ?>" class="text-emerald-600 hover:text-emerald-700 font-bold underline decoration-2 underline-offset-2">Sign Up here</a>
            </p>
            <div>
                <a href="<?php echo e(route('landing')); ?>" class="inline-block mt-2 text-xs text-slate-400 hover:text-slate-600 font-medium">&larr; Back to Home</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined' && lucide.createIcons) lucide.createIcons();
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\loksewa_course\resources\views/auth/login.blade.php ENDPATH**/ ?>