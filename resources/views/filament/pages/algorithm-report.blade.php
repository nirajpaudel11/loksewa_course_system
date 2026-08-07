<x-filament-panels::page>

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
        .ar-grid-5 { grid-template-columns: repeat(2, 1fr); }
    }
    @media (min-width: 1024px) {
        .ar-grid-5 { grid-template-columns: repeat(5, 1fr); }
    }

    .ar-grid-2 {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    @media (min-width: 1024px) {
        .ar-grid-2 { grid-template-columns: repeat(2, 1fr); }
    }

    .ar-grid-4 {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (min-width: 640px) {
        .ar-grid-4 { grid-template-columns: repeat(2, 1fr); }
    }
    @media (min-width: 1024px) {
        .ar-grid-4 { grid-template-columns: repeat(4, 1fr); }
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

    .ar-space-y > * + * {
        margin-top: 0.5rem;
    }

    .ar-space-y-lg > * + * {
        margin-top: 1rem;
    }

    .ar-text-center { text-align: center; }
    .ar-text-right { text-align: right; }
    .ar-align-top { vertical-align: top; }

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
    .ar-text-medium { font-weight: 500; }
    .ar-text-semibold { font-weight: 600; }
    .ar-text-bold { font-weight: 700; }
    .ar-font-mono { font-family: ui-monospace, SFMono-Regular, 'Cascadia Code', 'Consolas', monospace; }
    .ar-italic { font-style: italic; }

    /* ---------- Colors (Light) ---------- */
    .ar-color-primary { color: rgb(var(--primary-600)); }
    .ar-color-info { color: rgb(var(--info-600, 59 130 246)); }
    .ar-color-success { color: rgb(var(--success-600, 22 163 74)); }
    .ar-color-warning { color: rgb(var(--warning-600, 217 119 6)); }
    .ar-color-danger { color: rgb(var(--danger-600, 220 38 38)); }

    .ar-color-gray-500 { color: rgb(107 114 128); }
    .ar-color-gray-400 { color: rgb(156 163 175); }
    .ar-color-gray-600 { color: rgb(75 85 99); }
    .ar-color-gray-700 { color: rgb(55 65 81); }
    .ar-color-gray-800 { color: rgb(31 41 55); }

    /* Dark overrides */
    .dark .ar-color-primary { color: rgb(var(--primary-400)); }
    .dark .ar-color-info { color: rgb(var(--info-400, 96 165 250)); }
    .dark .ar-color-success { color: rgb(var(--success-400, 74 222 128)); }
    .dark .ar-color-warning { color: rgb(var(--warning-400, 251 191 36)); }
    .dark .ar-color-danger { color: rgb(var(--danger-400, 248 113 113)); }

    .dark .ar-color-gray-500 { color: rgb(156 163 175); }
    .dark .ar-color-gray-400 { color: rgb(107 114 128); }
    .dark .ar-color-gray-600 { color: rgb(156 163 175); }
    .dark .ar-color-gray-700 { color: rgb(209 213 219); }
    .dark .ar-color-gray-800 { color: rgb(229 231 235); }

    /* Specific semantic text colors */
    .ar-text-primary-700 { color: rgb(var(--primary-700, 29 78 216)); }
    .dark .ar-text-primary-700 { color: rgb(var(--primary-300, 147 197 253)); }

    .ar-text-info-600 { color: rgb(var(--info-600, 37 99 235)); }
    .dark .ar-text-info-600 { color: rgb(var(--info-400, 96 165 250)); }
    .ar-text-info-700 { color: rgb(var(--info-700, 29 78 216)); }
    .dark .ar-text-info-700 { color: rgb(var(--info-300, 147 197 253)); }

    .ar-text-success-700 { color: rgb(var(--success-700, 21 128 61)); }
    .dark .ar-text-success-700 { color: rgb(var(--success-300, 134 239 172)); }

    .ar-text-warning-600 { color: rgb(var(--warning-600, 217 119 6)); }
    .dark .ar-text-warning-600 { color: rgb(var(--warning-400, 251 191 36)); }
    .ar-text-warning-700 { color: rgb(var(--warning-700, 180 83 9)); }
    .dark .ar-text-warning-700 { color: rgb(var(--warning-300, 253 224 71)); }

    .ar-text-danger-600 { color: rgb(var(--danger-600, 220 38 38)); }
    .dark .ar-text-danger-600 { color: rgb(var(--danger-400, 248 113 113)); }
    .ar-text-danger-700 { color: rgb(var(--danger-700, 185 28 28)); }
    .dark .ar-text-danger-700 { color: rgb(var(--danger-300, 252 165 165)); }

    .ar-text-primary-500 { color: rgb(var(--primary-500)); }

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
    .ar-table th.ar-text-right { text-align: right; }
    .ar-table th.ar-text-center { text-align: center; }

    .ar-table tbody tr + tr {
        border-top: 1px solid rgb(243 244 246);
    }
    .dark .ar-table tbody tr + tr {
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
    .ar-dot-success { background: rgb(var(--success-500, 34 197 94)); }
    .ar-dot-warning { background: rgb(var(--warning-500, 245 158 11)); }
    .ar-dot-danger { background: rgb(var(--danger-500, 239 68 68)); }

    /* ---------- Heroicon sizing ---------- */
    .ar-icon-sm { height: 1rem; width: 1rem; }
    .ar-icon-md { height: 1.25rem; width: 1.25rem; }
    .ar-icon-lg { height: 2rem; width: 2rem; }
    .ar-icon-warning { color: rgb(var(--warning-500, 245 158 11)); flex-shrink: 0; }
    .ar-icon-danger-500 { color: rgb(var(--danger-500, 239 68 68)); }
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
    .ar-mb-4 { margin-bottom: 1rem; }
    .ar-mb-3 { margin-bottom: 0.75rem; }
    .ar-ml-auto { margin-left: auto; }
    .ar-mx-auto { margin: 0 auto; }

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
    .ar-gap-2 { gap: 0.5rem; }
    .ar-gap-3 { gap: 0.75rem; }
</style>

    {{-- Overview Stats --}}
    <div class="ar-grid-5">
        <x-filament::section>
            <div class="ar-text-center">
                <div class="ar-stat-value ar-color-primary">{{ $overviewStats['total_courses'] }}</div>
                <div class="ar-stat-label ar-color-gray-500">Total Courses</div>
            </div>
        </x-filament::section>
        <x-filament::section>
            <div class="ar-text-center">
                <div class="ar-stat-value ar-text-info-600">{{ $overviewStats['total_users'] }}</div>
                <div class="ar-stat-label ar-color-gray-500">Total Users</div>
            </div>
        </x-filament::section>
        <x-filament::section>
            <div class="ar-text-center">
                <div class="ar-stat-value ar-text-success-700">{{ $overviewStats['total_enrollments'] }}</div>
                <div class="ar-stat-label ar-color-gray-500">Enrollments</div>
            </div>
        </x-filament::section>
        <x-filament::section>
            <div class="ar-text-center">
                <div class="ar-stat-value ar-text-warning-600">{{ $overviewStats['total_prerequisites'] }}</div>
                <div class="ar-stat-label ar-color-gray-500">Prerequisites</div>
            </div>
        </x-filament::section>
        <x-filament::section>
            <div class="ar-text-center">
                <div class="ar-stat-value ar-text-danger-600">{{ $overviewStats['total_lesson_progress'] }}</div>
                <div class="ar-stat-label ar-color-gray-500">Lesson Progress</div>
            </div>
        </x-filament::section>
    </div>

    {{-- 1. DAG / Graph Algorithms --}}
    <x-filament::section
        icon="heroicon-o-share"
        icon-color="primary"
        collapsible
    >
        <x-slot name="heading">
            Dependency Graph — DAG Validation & Topological Sort
        </x-slot>
        <x-slot name="description">
            Kahn's Algorithm (BFS) · Directed Acyclic Graph
        </x-slot>

        {{-- Status Badge --}}
        <div class="ar-flex-center ar-gap-3 ar-mb-4">
            <span class="ar-text-sm ar-text-medium ar-color-gray-700">DAG Status:</span>
            @if ($dagReport['is_valid'])
                <x-filament::badge color="success" icon="heroicon-o-check-circle">
                    Valid — No Cycles Detected
                </x-filament::badge>
            @else
                <x-filament::badge color="danger" icon="heroicon-o-x-circle">
                    Invalid — Cycle Detected
                </x-filament::badge>
            @endif
            <span class="ar-text-xs ar-color-gray-400 ar-ml-auto">
                {{ $dagReport['total_nodes'] }} nodes · {{ $dagReport['total_edges'] }} edges
            </span>
        </div>

        @if ($dagReport['cycle_error'])
            <div class="ar-alert-danger">
                <div class="ar-alert-danger-inner">
                    <x-heroicon-o-exclamation-triangle class="ar-icon-md ar-icon-danger-500" />
                    <span class="ar-text-sm ar-text-medium ar-text-danger-700">{{ $dagReport['cycle_error'] }}</span>
                </div>
            </div>
        @endif

        <div class="ar-grid-2">
            {{-- Topological Learning Order --}}
            <div>
                <h4 class="ar-heading-sm ar-color-gray-700">
                    <x-heroicon-o-academic-cap class="ar-icon-sm" />
                    Topological Learning Order
                </h4>
                @if (count($dagReport['learning_order']) > 0)
                    <div class="ar-space-y">
                        @foreach ($dagReport['learning_order'] as $index => $course)
                            <div class="ar-list-item">
                                <span class="ar-circle-primary">
                                    {{ $index + 1 }}
                                </span>
                                <span class="ar-text-sm ar-text-medium ar-color-gray-800">{{ $course['title'] }}</span>
                                <span class="ar-text-xs ar-color-gray-400 ar-ml-auto">#{{ $course['id'] }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="ar-box-muted-padded">
                        <p class="ar-text-sm ar-color-gray-500">No valid learning order available.</p>
                    </div>
                @endif
            </div>

            {{-- Dependency Edges --}}
            <div>
                <h4 class="ar-heading-sm ar-color-gray-700">
                    <x-heroicon-o-arrows-right-left class="ar-icon-sm" />
                    Prerequisite Edges
                </h4>
                @if (count($dagReport['edges']) > 0)
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
                                @foreach ($dagReport['edges'] as $edge)
                                    <tr>
                                        <td class="ar-td-name">{{ $edge['from_title'] }}</td>
                                        <td style="text-align:center;">
                                            <x-heroicon-o-arrow-long-right class="ar-icon-md ar-text-primary-500" style="margin:0 auto;" />
                                        </td>
                                        <td class="ar-td-name">{{ $edge['to_title'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="ar-box-muted-padded">
                        <p class="ar-text-sm ar-color-gray-500">No prerequisites configured yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </x-filament::section>

    {{-- 2. Trending Algorithm --}}
    <x-filament::section
        icon="heroicon-o-fire"
        icon-color="danger"
        collapsible
    >
        <x-slot name="heading">
            Trending Algorithm — Gravity Decay Ranking
        </x-slot>
        <x-slot name="description">
            HackerNews-style Time Decay · Gravity = {{ $trendingReport['gravity_factor'] }}
        </x-slot>

        <div class="ar-flex-wrap ar-mb-4">
            <div class="ar-stat-box-danger">
                <span class="ar-stat-label-xs ar-text-danger-600">30-Day Enrollments</span>
                <span class="ar-stat-value-xl ar-text-danger-700">{{ $trendingReport['recent_enrollments_30d'] }}</span>
            </div>
            <div class="ar-box-muted">
                <span class="ar-stat-label-xs ar-color-gray-500">Formula</span>
                <code class="ar-text-xs ar-font-mono ar-color-gray-700">{{ $trendingReport['formula'] }}</code>
            </div>
        </div>

        @if ($trendingReport['top_courses']->count() > 0)
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
                        @foreach ($trendingReport['top_courses'] as $index => $course)
                            <tr>
                                <td>
                                    <span class="{{ $index < 3 ? 'ar-circle-danger' : 'ar-circle-muted' }}">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="ar-td-name">{{ $course->title }}</td>
                                <td class="ar-text-right">
                                    <x-filament::badge color="warning">
                                        {{ number_format($course->trending_score, 2) }}
                                    </x-filament::badge>
                                </td>
                                <td class="ar-text-right ar-td-muted ar-text-xs">
                                    {{ $course->created_at?->diffForHumans() ?? 'N/A' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="ar-box-muted-lg">
                <x-heroicon-o-fire class="ar-icon-muted-lg" />
                <p class="ar-text-sm ar-color-gray-500">No trending data available. Run <code class="ar-code-inline">php artisan courses:update-trending</code> to calculate scores.</p>
            </div>
        @endif
    </x-filament::section>

    {{-- 3. Collaborative Filtering --}}
    <x-filament::section
        icon="heroicon-o-user-group"
        icon-color="info"
        collapsible
    >
        <x-slot name="heading">
            Collaborative Filtering — User-Based Recommendations
        </x-slot>
        <x-slot name="description">
            {{ $collaborativeReport['similarity_metric'] }}
        </x-slot>

        <div class="ar-flex-wrap ar-mb-4">
            <div class="ar-stat-box-info">
                <span class="ar-stat-label-xs ar-text-info-600">Users with Enrollments</span>
                <span class="ar-stat-value-xl ar-text-info-700">{{ $collaborativeReport['users_with_enrollments'] }}</span>
            </div>
            <div class="ar-stat-box-warning">
                <span class="ar-stat-label-xs ar-text-warning-600">Cold Start Users</span>
                <span class="ar-stat-value-xl ar-text-warning-700">{{ $collaborativeReport['cold_start_users'] }}</span>
            </div>
        </div>

        @if (count($collaborativeReport['recommendations']) > 0)
            <div class="ar-space-y-lg">
                @foreach ($collaborativeReport['recommendations'] as $rec)
                    <div class="ar-bordered-card">
                        <div class="ar-bordered-card-header">
                            <div class="ar-circle-info">
                                <x-heroicon-o-user class="ar-circle-info-icon" />
                            </div>
                            <div>
                                <span class="ar-text-sm ar-text-semibold ar-color-gray-800">{{ $rec['user']->name }}</span>
                                <span class="ar-text-xs ar-color-gray-400" style="margin-left:0.5rem;">{{ $rec['enrolled_count'] }} enrolled courses</span>
                            </div>
                        </div>
                        <div class="ar-flex-gap-sm">
                            @if ($rec['recommendations']->count() > 0)
                                @foreach ($rec['recommendations'] as $course)
                                    <x-filament::badge color="info" icon="heroicon-o-sparkles">
                                        {{ $course->title }}
                                    </x-filament::badge>
                                @endforeach
                            @else
                                <span class="ar-text-xs ar-color-gray-400 ar-italic">No recommendations generated</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="ar-box-muted-lg">
                <x-heroicon-o-user-group class="ar-icon-muted-lg" />
                <p class="ar-text-sm ar-color-gray-500">No users with enrollments found. Recommendations require enrollment data.</p>
            </div>
        @endif
    </x-filament::section>

    {{-- 4. Content Similarity --}}
    <x-filament::section
        icon="heroicon-o-document-magnifying-glass"
        icon-color="warning"
        collapsible
    >
        <x-slot name="heading">
            Content Similarity — TF-IDF Analysis
        </x-slot>
        <x-slot name="description">
            {{ $contentSimilarityReport['method'] }} · {{ $contentSimilarityReport['tokenization'] }}
        </x-slot>

        @if (count($contentSimilarityReport['similarities']) > 0)
            <div class="ar-table-wrap">
                <table class="ar-table">
                    <thead>
                        <tr>
                            <th>Source Course</th>
                            <th>Similar Courses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contentSimilarityReport['similarities'] as $entry)
                            <tr>
                                <td class="ar-td-name ar-align-top">
                                    <div class="ar-flex-center ar-gap-2">
                                        <x-heroicon-o-document-text class="ar-icon-sm ar-icon-warning" />
                                        {{ $entry['course']->title }}
                                    </div>
                                </td>
                                <td>
                                    @if ($entry['similar_courses']->count() > 0)
                                        <div class="ar-flex-gap-xs">
                                            @foreach ($entry['similar_courses'] as $similar)
                                                <x-filament::badge color="warning" size="sm">
                                                    {{ $similar->title }}
                                                </x-filament::badge>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="ar-text-xs ar-color-gray-400 ar-italic">No similar courses found</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="ar-box-muted-lg">
                <x-heroicon-o-document-magnifying-glass class="ar-icon-muted-lg" />
                <p class="ar-text-sm ar-color-gray-500">No courses available for similarity analysis.</p>
            </div>
        @endif
    </x-filament::section>

    {{-- 5. Spaced Repetition --}}
    <x-filament::section
        icon="heroicon-o-clock"
        icon-color="success"
        collapsible
    >
        <x-slot name="heading">
            Spaced Repetition — SM-2 Algorithm
        </x-slot>
        <x-slot name="description">
            {{ $spacedRepetitionReport['algorithm'] }}
        </x-slot>

        <div class="ar-grid-4">
            <div class="ar-card-danger">
                <div class="ar-stat-value-lg ar-text-danger-700">{{ $spacedRepetitionReport['due_today'] }}</div>
                <div class="ar-text-xs ar-text-danger-600" style="margin-top:0.25rem;">Reviews Due Today</div>
            </div>
            <div class="ar-card-warning">
                <div class="ar-stat-value-lg ar-text-warning-700">{{ $spacedRepetitionReport['upcoming_7d'] }}</div>
                <div class="ar-text-xs ar-text-warning-600" style="margin-top:0.25rem;">Upcoming (7 Days)</div>
            </div>
            <div class="ar-card-info">
                <div class="ar-stat-value-lg ar-text-info-700">{{ $spacedRepetitionReport['avg_easiness'] ?? '—' }}</div>
                <div class="ar-text-xs ar-text-info-600" style="margin-top:0.25rem;">Avg Easiness Factor</div>
            </div>
            <div class="ar-card-success">
                <div class="ar-stat-value-lg ar-text-success-700">{{ $spacedRepetitionReport['total_tracked'] }}</div>
                <div class="ar-text-xs" style="margin-top:0.25rem; color:rgb(var(--success-600, 22 163 74));">Total Tracked</div>
            </div>
        </div>

        {{-- Difficulty Distribution --}}
        <div class="ar-mb-4">
            <h4 class="ar-heading-sm ar-color-gray-700">Difficulty Distribution</h4>
            @php
                $total = $spacedRepetitionReport['difficulty_distribution']['easy']
                       + $spacedRepetitionReport['difficulty_distribution']['medium']
                       + $spacedRepetitionReport['difficulty_distribution']['hard'];
                $easyPct = $total > 0 ? ($spacedRepetitionReport['difficulty_distribution']['easy'] / $total) * 100 : 0;
                $medPct = $total > 0 ? ($spacedRepetitionReport['difficulty_distribution']['medium'] / $total) * 100 : 0;
                $hardPct = $total > 0 ? ($spacedRepetitionReport['difficulty_distribution']['hard'] / $total) * 100 : 0;
            @endphp

            @if ($total > 0)
                <div class="ar-progress-bar">
                    <div class="ar-progress-success" style="width: {{ $easyPct }}%"></div>
                    <div class="ar-progress-warning" style="width: {{ $medPct }}%"></div>
                    <div class="ar-progress-danger" style="width: {{ $hardPct }}%"></div>
                </div>
                <div class="ar-legend ar-text-xs ar-color-gray-500">
                    <span class="ar-legend-item">
                        <span class="ar-legend-dot ar-dot-success"></span>
                        Easy (EF ≥ 2.5): {{ $spacedRepetitionReport['difficulty_distribution']['easy'] }}
                    </span>
                    <span class="ar-legend-item">
                        <span class="ar-legend-dot ar-dot-warning"></span>
                        Medium (1.8–2.5): {{ $spacedRepetitionReport['difficulty_distribution']['medium'] }}
                    </span>
                    <span class="ar-legend-item">
                        <span class="ar-legend-dot ar-dot-danger"></span>
                        Hard (EF < 1.8): {{ $spacedRepetitionReport['difficulty_distribution']['hard'] }}
                    </span>
                </div>
            @else
                <div class="ar-box-muted-padded">
                    <p class="ar-text-sm ar-color-gray-500">No spaced repetition data available yet.</p>
                </div>
            @endif
        </div>

        <div class="ar-box-muted">
            <span class="ar-stat-label-xs ar-color-gray-500">SM-2 Formula</span>
            <code class="ar-text-xs ar-font-mono ar-color-gray-700">{{ $spacedRepetitionReport['formula'] }}</code>
        </div>
    </x-filament::section>

    {{-- 6. Learning Pacing --}}
    <x-filament::section
        icon="heroicon-o-chart-bar"
        icon-color="primary"
        collapsible
    >
        <x-slot name="heading">
            Learning Pacing — Completion Prediction
        </x-slot>
        <x-slot name="description">
            {{ $learningPacingReport['method'] }} · {{ $learningPacingReport['description'] }}
        </x-slot>

        @if (count($learningPacingReport['predictions']) > 0)
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
                        @foreach ($learningPacingReport['predictions'] as $pred)
                            <tr>
                                <td>
                                    <div class="ar-flex-center ar-gap-2">
                                        <div class="ar-circle-primary-sm">
                                            <x-heroicon-o-user class="ar-circle-primary-sm-icon" />
                                        </div>
                                        <span class="ar-td-name">{{ $pred['user_name'] }}</span>
                                    </div>
                                </td>
                                <td class="ar-color-gray-700">{{ $pred['course_title'] }}</td>
                                <td class="ar-text-right">
                                    <x-filament::badge color="{{ $pred['predicted_date'] === 'Insufficient data' ? 'gray' : 'primary' }}">
                                        {{ $pred['predicted_date'] }}
                                    </x-filament::badge>
                                </td>
                                <td class="ar-text-right ar-td-muted">
                                    @if ($pred['pace_multiplier'])
                                        {{ number_format($pred['pace_multiplier'], 2) }}×
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="ar-box-muted-lg">
                <x-heroicon-o-chart-bar class="ar-icon-muted-lg" />
                <p class="ar-text-sm ar-color-gray-500">No learning pacing predictions available. Users need at least 3 completed lessons for prediction.</p>
            </div>
        @endif
    </x-filament::section>

    {{-- Report Metadata Footer --}}
    <div class="ar-footer">
        <span class="ar-text-xs ar-color-gray-400">
            Report generated at {{ now()->format('M d, Y — H:i:s') }}
        </span>
        <div class="ar-footer-meta ar-text-xs ar-color-gray-400">
            <span>6 algorithms analyzed</span>
            <span>·</span>
            <span>Live data</span>
        </div>
    </div>

</x-filament-panels::page>
