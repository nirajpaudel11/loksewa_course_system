<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>


    <style>
        /* ===== Algorithm Report Custom Styles ===== */
        /* Uses Filament's .dark class on ancestor for dark mode */

        /* ---------- Layout Helpers ---------- */
        .ar-grid-5 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (min-width: 640px) {
            .ar-grid-5 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .ar-grid-5 {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        .ar-grid-2 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 1024px) {
            .ar-grid-2 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .ar-grid-4 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (min-width: 640px) {
            .ar-grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .ar-grid-4 {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .ar-flex-center {
            display: flex;
            align-items: center;
        }

        .ar-flex-wrap {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
        }

        .ar-flex-gap-sm {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .ar-flex-gap-xs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.375rem;
        }

        .ar-space-y>*+* {
            margin-top: 0.5rem;
        }

        .ar-space-y-lg>*+* {
            margin-top: 1rem;
        }

        .ar-text-center {
            text-align: center;
        }

        .ar-text-right {
            text-align: right;
        }

        .ar-align-top {
            vertical-align: top;
        }

        /* ---------- Typography ---------- */
        .ar-stat-value {
            font-size: 1.875rem;
            line-height: 2.25rem;
            font-weight: 700;
        }

        .ar-stat-value-lg {
            font-size: 1.5rem;
            line-height: 2rem;
            font-weight: 700;
        }

        .ar-stat-value-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
            font-weight: 700;
        }

        .ar-stat-label {
            font-size: 0.875rem;
            line-height: 1.25rem;
            margin-top: 0.25rem;
        }

        .ar-stat-label-xs {
            font-size: 0.75rem;
            line-height: 1rem;
            margin-top: 0.25rem;
            display: block;
        }

        .ar-heading-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .ar-text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .ar-text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }

        .ar-text-medium {
            font-weight: 500;
        }

        .ar-text-semibold {
            font-weight: 600;
        }

        .ar-text-bold {
            font-weight: 700;
        }

        .ar-font-mono {
            font-family: ui-monospace, SFMono-Regular, 'Cascadia Code', 'Consolas', monospace;
        }

        .ar-italic {
            font-style: italic;
        }

        /* ---------- Colors (Light) ---------- */
        .ar-color-primary {
            color: rgb(var(--primary-600));
        }

        .ar-color-info {
            color: rgb(var(--info-600, 59 130 246));
        }

        .ar-color-success {
            color: rgb(var(--success-600, 22 163 74));
        }

        .ar-color-warning {
            color: rgb(var(--warning-600, 217 119 6));
        }

        .ar-color-danger {
            color: rgb(var(--danger-600, 220 38 38));
        }

        .ar-color-gray-500 {
            color: rgb(107 114 128);
        }

        .ar-color-gray-400 {
            color: rgb(156 163 175);
        }

        .ar-color-gray-600 {
            color: rgb(75 85 99);
        }

        .ar-color-gray-700 {
            color: rgb(55 65 81);
        }

        .ar-color-gray-800 {
            color: rgb(31 41 55);
        }

        /* Dark overrides */
        .dark .ar-color-primary {
            color: rgb(var(--primary-400));
        }

        .dark .ar-color-info {
            color: rgb(var(--info-400, 96 165 250));
        }

        .dark .ar-color-success {
            color: rgb(var(--success-400, 74 222 128));
        }

        .dark .ar-color-warning {
            color: rgb(var(--warning-400, 251 191 36));
        }

        .dark .ar-color-danger {
            color: rgb(var(--danger-400, 248 113 113));
        }

        .dark .ar-color-gray-500 {
            color: rgb(156 163 175);
        }

        .dark .ar-color-gray-400 {
            color: rgb(107 114 128);
        }

        .dark .ar-color-gray-600 {
            color: rgb(156 163 175);
        }

        .dark .ar-color-gray-700 {
            color: rgb(209 213 219);
        }

        .dark .ar-color-gray-800 {
            color: rgb(229 231 235);
        }

        /* Specific semantic text colors */
        .ar-text-primary-700 {
            color: rgb(var(--primary-700, 29 78 216));
        }

        .dark .ar-text-primary-700 {
            color: rgb(var(--primary-300, 147 197 253));
        }

        .ar-text-info-600 {
            color: rgb(var(--info-600, 37 99 235));
        }

        .dark .ar-text-info-600 {
            color: rgb(var(--info-400, 96 165 250));
        }

        .ar-text-info-700 {
            color: rgb(var(--info-700, 29 78 216));
        }

        .dark .ar-text-info-700 {
            color: rgb(var(--info-300, 147 197 253));
        }

        .ar-text-success-700 {
            color: rgb(var(--success-700, 21 128 61));
        }

        .dark .ar-text-success-700 {
            color: rgb(var(--success-300, 134 239 172));
        }

        .ar-text-warning-600 {
            color: rgb(var(--warning-600, 217 119 6));
        }

        .dark .ar-text-warning-600 {
            color: rgb(var(--warning-400, 251 191 36));
        }

        .ar-text-warning-700 {
            color: rgb(var(--warning-700, 180 83 9));
        }

        .dark .ar-text-warning-700 {
            color: rgb(var(--warning-300, 253 224 71));
        }

        .ar-text-danger-600 {
            color: rgb(var(--danger-600, 220 38 38));
        }

        .dark .ar-text-danger-600 {
            color: rgb(var(--danger-400, 248 113 113));
        }

        .ar-text-danger-700 {
            color: rgb(var(--danger-700, 185 28 28));
        }

        .dark .ar-text-danger-700 {
            color: rgb(var(--danger-300, 252 165 165));
        }

        .ar-text-primary-500 {
            color: rgb(var(--primary-500));
        }

        /* ---------- Stat Cards / Colored Boxes ---------- */
        .ar-card-danger {
            border-radius: 0.5rem;
            background: rgb(var(--danger-50, 254 242 242));
            border: 1px solid rgb(var(--danger-200, 254 202 202));
            padding: 1rem;
            text-align: center;
        }

        .dark .ar-card-danger {
            background: rgb(var(--danger-950, 69 10 10) / 0.5);
            border-color: rgb(var(--danger-800, 153 27 27));
        }

        .ar-card-warning {
            border-radius: 0.5rem;
            background: rgb(var(--warning-50, 255 251 235));
            border: 1px solid rgb(var(--warning-200, 253 230 138));
            padding: 1rem;
            text-align: center;
        }

        .dark .ar-card-warning {
            background: rgb(var(--warning-950, 69 26 3) / 0.5);
            border-color: rgb(var(--warning-800, 146 64 14));
        }

        .ar-card-info {
            border-radius: 0.5rem;
            background: rgb(var(--info-50, 239 246 255));
            border: 1px solid rgb(var(--info-200, 191 219 254));
            padding: 1rem;
            text-align: center;
        }

        .dark .ar-card-info {
            background: rgb(var(--info-950, 23 37 84) / 0.5);
            border-color: rgb(var(--info-800, 30 64 175));
        }

        .ar-card-success {
            border-radius: 0.5rem;
            background: rgb(var(--success-50, 240 253 244));
            border: 1px solid rgb(var(--success-200, 187 247 208));
            padding: 1rem;
            text-align: center;
        }

        .dark .ar-card-success {
            background: rgb(var(--success-950, 5 46 22) / 0.5);
            border-color: rgb(var(--success-800, 22 101 52));
        }

        /* Inline stat boxes (smaller, with left-aligned text) */
        .ar-stat-box-danger {
            border-radius: 0.5rem;
            background: rgb(var(--danger-50, 254 242 242));
            border: 1px solid rgb(var(--danger-200, 254 202 202));
            padding: 0.5rem 1rem;
        }

        .dark .ar-stat-box-danger {
            background: rgb(var(--danger-950, 69 10 10) / 0.5);
            border-color: rgb(var(--danger-800, 153 27 27));
        }

        .ar-stat-box-info {
            border-radius: 0.5rem;
            background: rgb(var(--info-50, 239 246 255));
            border: 1px solid rgb(var(--info-200, 191 219 254));
            padding: 0.5rem 1rem;
        }

        .dark .ar-stat-box-info {
            background: rgb(var(--info-950, 23 37 84) / 0.5);
            border-color: rgb(var(--info-800, 30 64 175));
        }

        .ar-stat-box-warning {
            border-radius: 0.5rem;
            background: rgb(var(--warning-50, 255 251 235));
            border: 1px solid rgb(var(--warning-200, 253 230 138));
            padding: 0.5rem 1rem;
        }

        .dark .ar-stat-box-warning {
            background: rgb(var(--warning-950, 69 26 3) / 0.5);
            border-color: rgb(var(--warning-800, 146 64 14));
        }

        /* Gray / neutral boxes */
        .ar-box-muted {
            border-radius: 0.5rem;
            background: rgb(249 250 251);
            border: 1px solid rgb(229 231 235);
            padding: 0.5rem 1rem;
        }

        .dark .ar-box-muted {
            background: rgba(255 255 255 / 0.05);
            border-color: rgba(255 255 255 / 0.1);
        }

        .ar-box-muted-padded {
            border-radius: 0.5rem;
            background: rgb(249 250 251);
            padding: 1rem;
            text-align: center;
        }

        .dark .ar-box-muted-padded {
            background: rgba(255 255 255 / 0.05);
        }

        .ar-box-muted-lg {
            border-radius: 0.5rem;
            background: rgb(249 250 251);
            padding: 1.5rem;
            text-align: center;
        }

        .dark .ar-box-muted-lg {
            background: rgba(255 255 255 / 0.05);
        }

        /* ---------- Error Alert ---------- */
        .ar-alert-danger {
            border-radius: 0.5rem;
            background: rgb(var(--danger-50, 254 242 242));
            border: 1px solid rgb(var(--danger-200, 254 202 202));
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .dark .ar-alert-danger {
            background: rgb(var(--danger-950, 69 10 10) / 0.5);
            border-color: rgb(var(--danger-800, 153 27 27));
        }

        .ar-alert-danger-inner {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ---------- Numbered Circles ---------- */
        .ar-circle-primary {
            display: flex;
            height: 1.75rem;
            width: 1.75rem;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            background: rgb(var(--primary-100, 219 234 254));
            font-size: 0.75rem;
            font-weight: 700;
            color: rgb(var(--primary-700, 29 78 216));
            flex-shrink: 0;
        }

        .dark .ar-circle-primary {
            background: rgb(var(--primary-900, 30 58 138));
            color: rgb(var(--primary-300, 147 197 253));
        }

        .ar-circle-danger {
            display: flex;
            height: 1.75rem;
            width: 1.75rem;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            background: rgb(var(--danger-100, 254 226 226));
            font-size: 0.75rem;
            font-weight: 700;
            color: rgb(var(--danger-700, 185 28 28));
        }

        .dark .ar-circle-danger {
            background: rgb(var(--danger-900, 127 29 29));
            color: rgb(var(--danger-300, 252 165 165));
        }

        .ar-circle-muted {
            display: flex;
            height: 1.75rem;
            width: 1.75rem;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            background: rgb(243 244 246);
            font-size: 0.75rem;
            font-weight: 700;
            color: rgb(75 85 99);
        }

        .dark .ar-circle-muted {
            background: rgb(31 41 55);
            color: rgb(156 163 175);
        }

        .ar-circle-info {
            display: flex;
            height: 2rem;
            width: 2rem;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            background: rgb(var(--info-100, 219 234 254));
            flex-shrink: 0;
        }

        .dark .ar-circle-info {
            background: rgb(var(--info-900, 30 58 138));
        }

        .ar-circle-info-icon {
            height: 1rem;
            width: 1rem;
            color: rgb(var(--info-600, 37 99 235));
        }

        .dark .ar-circle-info-icon {
            color: rgb(var(--info-400, 96 165 250));
        }

        .ar-circle-primary-sm {
            display: flex;
            height: 1.75rem;
            width: 1.75rem;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            background: rgb(var(--primary-100, 219 234 254));
            flex-shrink: 0;
        }

        .dark .ar-circle-primary-sm {
            background: rgb(var(--primary-900, 30 58 138));
        }

        .ar-circle-primary-sm-icon {
            height: 0.875rem;
            width: 0.875rem;
            color: rgb(var(--primary-600));
        }

        .dark .ar-circle-primary-sm-icon {
            color: rgb(var(--primary-400));
        }

        /* ---------- List Items ---------- */
        .ar-list-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-radius: 0.5rem;
            background: rgb(249 250 251);
            padding: 0.625rem 1rem;
            border: 1px solid rgb(243 244 246);
        }

        .dark .ar-list-item {
            background: rgba(255 255 255 / 0.05);
            border-color: rgba(255 255 255 / 0.1);
        }

        /* ---------- Bordered Card ---------- */
        .ar-bordered-card {
            border-radius: 0.5rem;
            border: 1px solid rgb(229 231 235);
            padding: 1rem;
        }

        .dark .ar-bordered-card {
            border-color: rgba(255 255 255 / 0.1);
        }

        .ar-bordered-card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        /* ---------- Tables ---------- */
        .ar-table-wrap {
            overflow-x: auto;
            border-radius: 0.5rem;
            border: 1px solid rgb(229 231 235);
        }

        .dark .ar-table-wrap {
            border-color: rgba(255 255 255 / 0.1);
        }

        .ar-table {
            width: 100%;
            min-width: 100%;
            font-size: 0.875rem;
            line-height: 1.25rem;
            border-collapse: collapse;
        }

        .ar-table thead {
            background: rgb(249 250 251);
        }

        .dark .ar-table thead {
            background: rgba(255 255 255 / 0.05);
        }

        .ar-table th {
            padding: 0.625rem 1rem;
            text-align: left;
            font-weight: 500;
            color: rgb(75 85 99);
        }

        .dark .ar-table th {
            color: rgb(156 163 175);
        }

        .ar-table th.ar-text-right {
            text-align: right;
        }

        .ar-table th.ar-text-center {
            text-align: center;
        }

        .ar-table tbody tr+tr {
            border-top: 1px solid rgb(243 244 246);
        }

        .dark .ar-table tbody tr+tr {
            border-top-color: rgba(255 255 255 / 0.05);
        }

        .ar-table td {
            padding: 0.625rem 1rem;
        }

        .ar-table .ar-td-name {
            color: rgb(31 41 55);
            font-weight: 500;
        }

        .dark .ar-table .ar-td-name {
            color: rgb(229 231 235);
        }

        .ar-table .ar-td-muted {
            color: rgb(107 114 128);
        }

        .dark .ar-table .ar-td-muted {
            color: rgb(156 163 175);
        }

        /* ---------- Progress Bar ---------- */
        .ar-progress-bar {
            display: flex;
            height: 1rem;
            width: 100%;
            overflow: hidden;
            border-radius: 9999px;
            background: rgb(243 244 246);
            margin-bottom: 0.75rem;
        }

        .dark .ar-progress-bar {
            background: rgb(31 41 55);
        }

        .ar-progress-success {
            background: rgb(var(--success-500, 34 197 94));
            transition: all 0.5s;
        }

        .ar-progress-warning {
            background: rgb(var(--warning-500, 245 158 11));
            transition: all 0.5s;
        }

        .ar-progress-danger {
            background: rgb(var(--danger-500, 239 68 68));
            transition: all 0.5s;
        }

        /* ---------- Legend Dots ---------- */
        .ar-legend {
            display: flex;
            justify-content: space-between;
        }

        .ar-legend-item {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .ar-legend-dot {
            height: 0.625rem;
            width: 0.625rem;
            border-radius: 9999px;
            flex-shrink: 0;
        }

        .ar-dot-success {
            background: rgb(var(--success-500, 34 197 94));
        }

        .ar-dot-warning {
            background: rgb(var(--warning-500, 245 158 11));
        }

        .ar-dot-danger {
            background: rgb(var(--danger-500, 239 68 68));
        }

        /* ---------- Heroicon sizing ---------- */
        .ar-icon-sm {
            height: 1rem;
            width: 1rem;
        }

        .ar-icon-md {
            height: 1.25rem;
            width: 1.25rem;
        }

        .ar-icon-lg {
            height: 2rem;
            width: 2rem;
        }

        .ar-icon-warning {
            color: rgb(var(--warning-500, 245 158 11));
            flex-shrink: 0;
        }

        .ar-icon-danger-500 {
            color: rgb(var(--danger-500, 239 68 68));
        }

        .ar-icon-muted-lg {
            height: 2rem;
            width: 2rem;
            color: rgb(209 213 219);
            margin: 0 auto 0.5rem;
        }

        .dark .ar-icon-muted-lg {
            color: rgb(75 85 99);
        }

        /* ---------- Footer ---------- */
        .ar-footer {
            margin-top: 1rem;
            border-radius: 0.5rem;
            background: rgb(249 250 251);
            border: 1px solid rgb(229 231 235);
            padding: 0.75rem 1rem;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
        }

        .dark .ar-footer {
            background: rgba(255 255 255 / 0.05);
            border-color: rgba(255 255 255 / 0.1);
        }

        .ar-footer-meta {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* ---------- Margin helpers ---------- */
        .ar-mb-4 {
            margin-bottom: 1rem;
        }

        .ar-mb-3 {
            margin-bottom: 0.75rem;
        }

        .ar-ml-auto {
            margin-left: auto;
        }

        .ar-mx-auto {
            margin: 0 auto;
        }

        /* ---------- Code inline ---------- */
        .ar-code-inline {
            font-size: 0.75rem;
            font-family: ui-monospace, SFMono-Regular, 'Cascadia Code', 'Consolas', monospace;
            background: rgb(243 244 246);
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
        }

        .dark .ar-code-inline {
            background: rgb(31 41 55);
        }

        /* ---------- Flex gap-2/3 helpers ---------- */
        .ar-gap-2 {
            gap: 0.5rem;
        }

        .ar-gap-3 {
            gap: 0.75rem;
        }
    </style>

    
    <div class="ar-grid-5">
        <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <div class="ar-text-center">
                <div class="ar-stat-value ar-color-primary"><?php echo e($overviewStats['total_courses']); ?></div>
                <div class="ar-stat-label ar-color-gray-500">Total Courses</div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <div class="ar-text-center">
                <div class="ar-stat-value ar-text-info-600"><?php echo e($overviewStats['total_users']); ?></div>
                <div class="ar-stat-label ar-color-gray-500">Total Users</div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <div class="ar-text-center">
                <div class="ar-stat-value ar-text-success-700"><?php echo e($overviewStats['total_enrollments']); ?></div>
                <div class="ar-stat-label ar-color-gray-500">Enrollments</div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <div class="ar-text-center">
                <div class="ar-stat-value ar-text-warning-600"><?php echo e($overviewStats['total_prerequisites']); ?></div>
                <div class="ar-stat-label ar-color-gray-500">Prerequisites</div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <div class="ar-text-center">
                <div class="ar-stat-value ar-text-danger-600"><?php echo e($overviewStats['total_lesson_progress']); ?></div>
                <div class="ar-stat-label ar-color-gray-500">Lesson Progress</div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
    </div>

    
    <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => ['icon' => 'heroicon-o-share','iconColor' => 'primary','collapsible' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-o-share','icon-color' => 'primary','collapsible' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

         <?php $__env->slot('heading', null, []); ?> 
            Dependency Graph — DAG Validation & Topological Sort
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('description', null, []); ?> 
            Kahn's Algorithm (BFS) · Directed Acyclic Graph
         <?php $__env->endSlot(); ?>

        
        <div class="ar-flex-center ar-gap-3 ar-mb-4">
            <span class="ar-text-sm ar-text-medium ar-color-gray-700">DAG Status:</span>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dagReport['is_valid']): ?>
                <?php if (isset($component)) { $__componentOriginal986dce9114ddce94a270ab00ce6c273d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal986dce9114ddce94a270ab00ce6c273d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.badge','data' => ['color' => 'success','icon' => 'heroicon-o-check-circle']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'success','icon' => 'heroicon-o-check-circle']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    Valid — No Cycles Detected
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $attributes = $__attributesOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $component = $__componentOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__componentOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal986dce9114ddce94a270ab00ce6c273d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal986dce9114ddce94a270ab00ce6c273d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.badge','data' => ['color' => 'danger','icon' => 'heroicon-o-x-circle']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'danger','icon' => 'heroicon-o-x-circle']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    Invalid — Cycle Detected
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $attributes = $__attributesOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $component = $__componentOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__componentOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <span class="ar-text-xs ar-color-gray-400 ar-ml-auto">
                <?php echo e($dagReport['total_nodes']); ?> nodes · <?php echo e($dagReport['total_edges']); ?> edges
            </span>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dagReport['cycle_error']): ?>
            <div class="ar-alert-danger">
                <div class="ar-alert-danger-inner">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-exclamation-triangle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ar-icon-md ar-icon-danger-500']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                    <span class="ar-text-sm ar-text-medium ar-text-danger-700"><?php echo e($dagReport['cycle_error']); ?></span>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="ar-grid-2">
            
            <div>
                <h4 class="ar-heading-sm ar-color-gray-700">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-academic-cap'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ar-icon-sm']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                    Topological Learning Order
                </h4>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($dagReport['learning_order']) > 0): ?>
                    <div class="ar-space-y">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $dagReport['learning_order']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="ar-list-item">
                                <span class="ar-circle-primary">
                                    <?php echo e($index + 1); ?>

                                </span>
                                <span class="ar-text-sm ar-text-medium ar-color-gray-800"><?php echo e($course['title']); ?></span>
                                <span class="ar-text-xs ar-color-gray-400 ar-ml-auto">#<?php echo e($course['id']); ?></span>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="ar-box-muted-padded">
                        <p class="ar-text-sm ar-color-gray-500">No valid learning order available.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div>
                <h4 class="ar-heading-sm ar-color-gray-700">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-arrows-right-left'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ar-icon-sm']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                    Prerequisite Edges
                </h4>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($dagReport['edges']) > 0): ?>
                    <div class="ar-table-wrap">
                        <table class="ar-table">
                            <thead>
                                <tr>
                                    <th>Prerequisite</th>
                                    <th class="ar-text-center"></th>
                                    <th>Unlocks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $dagReport['edges']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <tr>
                                        <td class="ar-td-name"><?php echo e($edge['from_title']); ?></td>
                                        <td style="text-align:center;">
                                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-arrow-long-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ar-icon-md ar-text-primary-500','style' => 'margin:0 auto;']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                        </td>
                                        <td class="ar-td-name"><?php echo e($edge['to_title']); ?></td>
                                    </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="ar-box-muted-padded">
                        <p class="ar-text-sm ar-color-gray-500">No prerequisites configured yet.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => ['icon' => 'heroicon-o-fire','iconColor' => 'danger','collapsible' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-o-fire','icon-color' => 'danger','collapsible' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

         <?php $__env->slot('heading', null, []); ?> 
            Trending Algorithm — Gravity Decay Ranking
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('description', null, []); ?> 
            HackerNews-style Time Decay · Gravity = <?php echo e($trendingReport['gravity_factor']); ?>

         <?php $__env->endSlot(); ?>

        <div class="ar-flex-wrap ar-mb-4">
            <div class="ar-stat-box-danger">
                <span class="ar-stat-label-xs ar-text-danger-600">30-Day Enrollments</span>
                <span
                    class="ar-stat-value-xl ar-text-danger-700"><?php echo e($trendingReport['recent_enrollments_30d']); ?></span>
            </div>
            <div class="ar-box-muted">
                <span class="ar-stat-label-xs ar-color-gray-500">Formula</span>
                <code class="ar-text-xs ar-font-mono ar-color-gray-700"><?php echo e($trendingReport['formula']); ?></code>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trendingReport['top_courses']->count() > 0): ?>
            <div class="ar-table-wrap">
                <table class="ar-table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Course</th>
                            <th class="ar-text-right">Trending Score</th>
                            <th class="ar-text-right">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $trendingReport['top_courses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td>
                                    <span class="<?php echo e($index < 3 ? 'ar-circle-danger' : 'ar-circle-muted'); ?>">
                                        <?php echo e($index + 1); ?>

                                    </span>
                                </td>
                                <td class="ar-td-name"><?php echo e($course->title); ?></td>
                                <td class="ar-text-right">
                                    <?php if (isset($component)) { $__componentOriginal986dce9114ddce94a270ab00ce6c273d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal986dce9114ddce94a270ab00ce6c273d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.badge','data' => ['color' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'warning']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                                        <?php echo e(number_format($course->trending_score, 2)); ?>

                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $attributes = $__attributesOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $component = $__componentOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__componentOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
                                </td>
                                <td class="ar-text-right ar-td-muted ar-text-xs">
                                    <?php echo e($course->created_at?->diffForHumans() ?? 'N/A'); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="ar-box-muted-lg">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-fire'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ar-icon-muted-lg']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                <p class="ar-text-sm ar-color-gray-500">No trending data available. Run <code class="ar-code-inline">php
                        artisan courses:update-trending</code> to calculate scores.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => ['icon' => 'heroicon-o-user-group','iconColor' => 'info','collapsible' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-o-user-group','icon-color' => 'info','collapsible' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

         <?php $__env->slot('heading', null, []); ?> 
            Collaborative Filtering — User-Based Recommendations
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('description', null, []); ?> 
            <?php echo e($collaborativeReport['similarity_metric']); ?>

         <?php $__env->endSlot(); ?>

        <div class="ar-flex-wrap ar-mb-4">
            <div class="ar-stat-box-info">
                <span class="ar-stat-label-xs ar-text-info-600">Users with Enrollments</span>
                <span
                    class="ar-stat-value-xl ar-text-info-700"><?php echo e($collaborativeReport['users_with_enrollments']); ?></span>
            </div>
            <div class="ar-stat-box-warning">
                <span class="ar-stat-label-xs ar-text-warning-600">Cold Start Users</span>
                <span
                    class="ar-stat-value-xl ar-text-warning-700"><?php echo e($collaborativeReport['cold_start_users']); ?></span>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($collaborativeReport['recommendations']) > 0): ?>
            <div class="ar-space-y-lg">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $collaborativeReport['recommendations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="ar-bordered-card">
                        <div class="ar-bordered-card-header">
                            <div class="ar-circle-info">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ar-circle-info-icon']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            </div>
                            <div>
                                <span
                                    class="ar-text-sm ar-text-semibold ar-color-gray-800"><?php echo e($rec['user']->name); ?></span>
                                <span class="ar-text-xs ar-color-gray-400"
                                    style="margin-left:0.5rem;"><?php echo e($rec['enrolled_count']); ?> enrolled courses</span>
                            </div>
                        </div>
                        <div class="ar-flex-gap-sm">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rec['recommendations']->count() > 0): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $rec['recommendations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal986dce9114ddce94a270ab00ce6c273d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal986dce9114ddce94a270ab00ce6c273d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.badge','data' => ['color' => 'info','icon' => 'heroicon-o-sparkles']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'info','icon' => 'heroicon-o-sparkles']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                                        <?php echo e($course->title); ?>

                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $attributes = $__attributesOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $component = $__componentOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__componentOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php else: ?>
                                <span class="ar-text-xs ar-color-gray-400 ar-italic">No recommendations generated</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php else: ?>
            <div class="ar-box-muted-lg">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-user-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ar-icon-muted-lg']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                <p class="ar-text-sm ar-color-gray-500">No users with enrollments found. Recommendations require
                    enrollment data.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>

    
    

    
    <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => ['icon' => 'heroicon-o-clock','iconColor' => 'success','collapsible' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-o-clock','icon-color' => 'success','collapsible' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

         <?php $__env->slot('heading', null, []); ?> 
            Spaced Repetition — SM-2 Algorithm
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('description', null, []); ?> 
            <?php echo e($spacedRepetitionReport['algorithm']); ?>

         <?php $__env->endSlot(); ?>

        <div class="ar-grid-4">
            <div class="ar-card-danger">
                <div class="ar-stat-value-lg ar-text-danger-700"><?php echo e($spacedRepetitionReport['due_today']); ?></div>
                <div class="ar-text-xs ar-text-danger-600" style="margin-top:0.25rem;">Reviews Due Today</div>
            </div>
            <div class="ar-card-warning">
                <div class="ar-stat-value-lg ar-text-warning-700"><?php echo e($spacedRepetitionReport['upcoming_7d']); ?></div>
                <div class="ar-text-xs ar-text-warning-600" style="margin-top:0.25rem;">Upcoming (7 Days)</div>
            </div>
            <div class="ar-card-info">
                <div class="ar-stat-value-lg ar-text-info-700"><?php echo e($spacedRepetitionReport['avg_easiness'] ?? '—'); ?>

                </div>
                <div class="ar-text-xs ar-text-info-600" style="margin-top:0.25rem;">Avg Easiness Factor</div>
            </div>
            <div class="ar-card-success">
                <div class="ar-stat-value-lg ar-text-success-700"><?php echo e($spacedRepetitionReport['total_tracked']); ?></div>
                <div class="ar-text-xs" style="margin-top:0.25rem; color:rgb(var(--success-600, 22 163 74));">Total
                    Tracked</div>
            </div>
        </div>

        
        <div class="ar-mb-4">
            <h4 class="ar-heading-sm ar-color-gray-700">Difficulty Distribution</h4>
            <?php
                $total =
                    $spacedRepetitionReport['difficulty_distribution']['easy'] +
                    $spacedRepetitionReport['difficulty_distribution']['medium'] +
                    $spacedRepetitionReport['difficulty_distribution']['hard'];
                $easyPct = $total > 0 ? ($spacedRepetitionReport['difficulty_distribution']['easy'] / $total) * 100 : 0;
                $medPct =
                    $total > 0 ? ($spacedRepetitionReport['difficulty_distribution']['medium'] / $total) * 100 : 0;
                $hardPct = $total > 0 ? ($spacedRepetitionReport['difficulty_distribution']['hard'] / $total) * 100 : 0;
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($total > 0): ?>
                <div class="ar-progress-bar">
                    <div class="ar-progress-success" style="width: <?php echo e($easyPct); ?>%"></div>
                    <div class="ar-progress-warning" style="width: <?php echo e($medPct); ?>%"></div>
                    <div class="ar-progress-danger" style="width: <?php echo e($hardPct); ?>%"></div>
                </div>
                <div class="ar-legend ar-text-xs ar-color-gray-500">
                    <span class="ar-legend-item">
                        <span class="ar-legend-dot ar-dot-success"></span>
                        Easy (EF ≥ 2.5): <?php echo e($spacedRepetitionReport['difficulty_distribution']['easy']); ?>

                    </span>
                    <span class="ar-legend-item">
                        <span class="ar-legend-dot ar-dot-warning"></span>
                        Medium (1.8–2.5): <?php echo e($spacedRepetitionReport['difficulty_distribution']['medium']); ?>

                    </span>
                    <span class="ar-legend-item">
                        <span class="ar-legend-dot ar-dot-danger"></span>
                        Hard (EF < 1.8): <?php echo e($spacedRepetitionReport['difficulty_distribution']['hard']); ?> </span>
                </div>
            <?php else: ?>
                <div class="ar-box-muted-padded">
                    <p class="ar-text-sm ar-color-gray-500">No spaced repetition data available yet.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="ar-box-muted">
            <span class="ar-stat-label-xs ar-color-gray-500">SM-2 Formula</span>
            <code class="ar-text-xs ar-font-mono ar-color-gray-700"><?php echo e($spacedRepetitionReport['formula']); ?></code>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => ['icon' => 'heroicon-o-chart-bar','iconColor' => 'primary','collapsible' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-o-chart-bar','icon-color' => 'primary','collapsible' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

         <?php $__env->slot('heading', null, []); ?> 
            Learning Pacing — Completion Prediction
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('description', null, []); ?> 
            <?php echo e($learningPacingReport['method']); ?> · <?php echo e($learningPacingReport['description']); ?>

         <?php $__env->endSlot(); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($learningPacingReport['predictions']) > 0): ?>
            <div class="ar-table-wrap">
                <table class="ar-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Course</th>
                            <th class="ar-text-right">Predicted Completion</th>
                            <th class="ar-text-right">Pace Multiplier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $learningPacingReport['predictions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pred): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td>
                                    <div class="ar-flex-center ar-gap-2">
                                        <div class="ar-circle-primary-sm">
                                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ar-circle-primary-sm-icon']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                        </div>
                                        <span class="ar-td-name"><?php echo e($pred['user_name']); ?></span>
                                    </div>
                                </td>
                                <td class="ar-color-gray-700"><?php echo e($pred['course_title']); ?></td>
                                <td class="ar-text-right">
                                    <?php if (isset($component)) { $__componentOriginal986dce9114ddce94a270ab00ce6c273d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal986dce9114ddce94a270ab00ce6c273d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.badge','data' => ['color' => ''.e($pred['predicted_date'] === 'Insufficient data' ? 'gray' : 'primary').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => ''.e($pred['predicted_date'] === 'Insufficient data' ? 'gray' : 'primary').'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                                        <?php echo e($pred['predicted_date']); ?>

                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $attributes = $__attributesOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $component = $__componentOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__componentOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
                                </td>
                                <td class="ar-text-right ar-td-muted">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pred['pace_multiplier']): ?>
                                        <?php echo e(number_format($pred['pace_multiplier'], 2)); ?>×
                                    <?php else: ?>
                                        —
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="ar-box-muted-lg">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-chart-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ar-icon-muted-lg']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                <p class="ar-text-sm ar-color-gray-500">No learning pacing predictions available. Users need at least 3
                    completed lessons for prediction.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>

    
    <div class="ar-footer">
        <span class="ar-text-xs ar-color-gray-400">
            Report generated at <?php echo e(now()->format('M d, Y — H:i:s')); ?>

        </span>
        <div class="ar-footer-meta ar-text-xs ar-color-gray-400">
            <span>6 algorithms analyzed</span>
            <span>·</span>
            <span>Live data</span>
        </div>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\loksewa_course\resources\views/filament/pages/algorithm-report.blade.php ENDPATH**/ ?>