<x-filament-widgets::widget>
    <style>
        .doc-widget-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
            margin-top: 0.5rem;
        }
        @media (min-width: 768px) {
            .doc-widget-container {
                grid-template-columns: 1fr 1fr;
            }
        }
        .doc-widget-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.25rem;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }
        .dark .doc-widget-card {
            background: #18181b;
            border-color: #27272a;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }
        .doc-widget-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }
        .dark .doc-widget-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
            border-color: #3f3f46;
        }
        .doc-widget-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }
        .doc-badge-emerald {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 9999px;
            background: #ecfdf5;
            color: #065f46;
        }
        .dark .doc-badge-emerald {
            background: rgba(6, 95, 70, 0.3);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .doc-badge-sky {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 9999px;
            background: #f0f9ff;
            color: #0369a1;
        }
        .dark .doc-badge-sky {
            background: rgba(3, 105, 161, 0.3);
            color: #7dd3fc;
            border: 1px solid rgba(14, 165, 233, 0.3);
        }
        .doc-format-label {
            font-size: 0.75rem;
            font-family: monospace;
            color: #64748b;
        }
        .dark .doc-format-label {
            color: #a1a1aa;
        }
        .doc-card-title {
            font-size: 1rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 0.5rem 0;
            line-height: 1.3;
        }
        .dark .doc-card-title {
            color: #f4f4f5;
        }
        .doc-card-desc {
            font-size: 0.8125rem;
            color: #475569;
            line-height: 1.5;
            margin: 0 0 1rem 0;
        }
        .dark .doc-card-desc {
            color: #d4d4d8;
        }
        .doc-action-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-top: 0.875rem;
            border-top: 1px solid #f1f5f9;
        }
        .dark .doc-action-row {
            border-top-color: #27272a;
        }
        .doc-btn-emerald {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.8125rem;
            font-weight: 700;
            color: #ffffff;
            background: #059669;
            border-radius: 0.625rem;
            text-decoration: none;
            transition: all 0.15s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .doc-btn-emerald:hover {
            background: #047857;
        }
        .doc-btn-sky {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.8125rem;
            font-weight: 700;
            color: #ffffff;
            background: #0284c7;
            border-radius: 0.625rem;
            text-decoration: none;
            transition: all 0.15s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .doc-btn-sky:hover {
            background: #0369a1;
        }
        .doc-btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            padding: 0.5rem 0.875rem;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #334155;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 0.625rem;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .dark .doc-btn-secondary {
            color: #e4e4e7;
            background: #27272a;
            border-color: #3f3f46;
        }
        .doc-btn-secondary:hover {
            background: #f8fafc;
            border-color: #94a3b8;
        }
        .dark .doc-btn-secondary:hover {
            background: #3f3f46;
            border-color: #52525b;
        }
        .doc-icon-sm {
            width: 1rem;
            height: 1rem;
            flex-shrink: 0;
        }
    </style>

    <x-filament::section>
        <x-slot name="heading">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <x-heroicon-o-document-duplicate class="doc-icon-sm" style="width: 1.35rem; height: 1.35rem; color: #059669;" />
                <span style="font-size: 1.125rem; font-weight: 800;">System Documentation &amp; Operational Manuals</span>
            </div>
        </x-slot>

        <x-slot name="description">
            Complete official operating guides and mathematical algorithm specifications available in both downloadable PDF format and interactive in-panel reference.
        </x-slot>

        <div class="doc-widget-container">
            <!-- Admin Manual Card -->
            <div class="doc-widget-card">
                <div>
                    <div class="doc-widget-top">
                        <span class="doc-badge-emerald">
                            <x-heroicon-s-shield-check class="doc-icon-sm" />
                            Administrator &amp; Operational Guide
                        </span>
                        <span class="doc-format-label">PDF (~28 KB)</span>
                    </div>
                    <h3 class="doc-card-title">
                        Admin Manual &amp; Algorithms Deep-Dive
                    </h3>
                    <p class="doc-card-desc">
                        Complete non-technical operational manual for course creation, 4-tier curriculum management, dynamic MCQ quiz builder, and mathematical explanations of all <strong>6 Core LMS Algorithms</strong>.
                    </p>
                </div>
                <div class="doc-action-row">
                    <a href="{{ asset('storage/docs/Loksewa_Admin_and_Algorithms_Manual.pdf') }}" target="_blank" download class="doc-btn-emerald">
                        <x-heroicon-m-arrow-down-tray class="doc-icon-sm" />
                        <span>Download Admin PDF</span>
                    </a>
                    <a href="{{ url('/admin/system-documentation') }}" class="doc-btn-secondary">
                        <x-heroicon-m-eye class="doc-icon-sm" />
                        <span>Read In Panel</span>
                    </a>
                </div>
            </div>

            <!-- Student Manual Card -->
            <div class="doc-widget-card">
                <div>
                    <div class="doc-widget-top">
                        <span class="doc-badge-sky">
                            <x-heroicon-s-academic-cap class="doc-icon-sm" />
                            Candidate &amp; Student Portal Guide
                        </span>
                        <span class="doc-format-label">PDF (~12 KB)</span>
                    </div>
                    <h3 class="doc-card-title">
                        Student / Aspirant User Manual
                    </h3>
                    <p class="doc-card-desc">
                        Step-by-step guidance for Loksewa candidates: navigating curriculum papers, high-definition PDF study notes, timed MCQ practice tests, daily SM-2 Spaced Repetition flashcards, and tracking real-time completion predictions.
                    </p>
                </div>
                <div class="doc-action-row">
                    <a href="{{ asset('storage/docs/Loksewa_Student_User_Manual.pdf') }}" target="_blank" download class="doc-btn-sky">
                        <x-heroicon-m-arrow-down-tray class="doc-icon-sm" />
                        <span>Download Student PDF</span>
                    </a>
                    <a href="{{ url('/admin/system-documentation') }}" class="doc-btn-secondary">
                        <x-heroicon-m-eye class="doc-icon-sm" />
                        <span>Read In Panel</span>
                    </a>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
