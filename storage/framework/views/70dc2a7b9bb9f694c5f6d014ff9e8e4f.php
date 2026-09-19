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
        .sys-doc-wrap {
            font-family: inherit;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .sys-doc-tabs {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 0.75rem;
            flex-wrap: wrap;
        }
        .dark .sys-doc-tabs {
            border-bottom-color: #27272a;
        }
        .sys-doc-tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.625rem;
            font-size: 0.875rem;
            font-weight: 700;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .sys-doc-tab-btn-admin-active {
            background: #059669;
            color: #ffffff;
            border-color: #059669;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .sys-doc-tab-btn-student-active {
            background: #0284c7;
            color: #ffffff;
            border-color: #0284c7;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .sys-doc-tab-btn-inactive {
            background: #f1f5f9;
            color: #475569;
            border-color: #e2e8f0;
        }
        .dark .sys-doc-tab-btn-inactive {
            background: #27272a;
            color: #a1a1aa;
            border-color: #3f3f46;
        }
        .sys-doc-tab-btn-inactive:hover {
            background: #e2e8f0;
            color: #1e293b;
        }
        .dark .sys-doc-tab-btn-inactive:hover {
            background: #3f3f46;
            color: #f4f4f5;
        }
        .sys-doc-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 1.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        .dark .sys-doc-card {
            background: #18181b;
            border-color: #27272a;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }
        .sys-doc-header {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 1.5rem;
        }
        @media (min-width: 640px) {
            .sys-doc-header {
                flex-direction: row;
                align-items: center;
            }
        }
        .dark .sys-doc-header {
            border-bottom-color: #27272a;
        }
        .sys-doc-badge {
            display: inline-block;
            padding: 0.25rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 9999px;
            margin-bottom: 0.5rem;
        }
        .sys-doc-badge-emerald {
            background: #ecfdf5;
            color: #065f46;
        }
        .dark .sys-doc-badge-emerald {
            background: rgba(6, 95, 70, 0.3);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .sys-doc-badge-sky {
            background: #f0f9ff;
            color: #0369a1;
        }
        .dark .sys-doc-badge-sky {
            background: rgba(3, 105, 161, 0.3);
            color: #7dd3fc;
            border: 1px solid rgba(14, 165, 233, 0.3);
        }
        .sys-doc-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 0.25rem 0;
        }
        .dark .sys-doc-title {
            color: #f4f4f5;
        }
        .sys-doc-subtitle {
            font-size: 0.8125rem;
            color: #64748b;
            margin: 0;
        }
        .dark .sys-doc-subtitle {
            color: #a1a1aa;
        }
        .sys-doc-download-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.8125rem;
            font-weight: 700;
            color: #ffffff;
            background: #059669;
            border-radius: 0.625rem;
            text-decoration: none;
            transition: background 0.15s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            flex-shrink: 0;
        }
        .sys-doc-download-btn:hover {
            background: #047857;
        }
        .sys-doc-download-btn-sky {
            background: #0284c7;
        }
        .sys-doc-download-btn-sky:hover {
            background: #0369a1;
        }
        .sys-doc-section-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
            border-left: 4px solid #059669;
            padding-left: 0.75rem;
            margin: 1.5rem 0 0.875rem 0;
        }
        .dark .sys-doc-section-title {
            color: #f4f4f5;
            border-left-color: #10b981;
        }
        .sys-doc-section-title-sky {
            border-left-color: #0284c7;
        }
        .dark .sys-doc-section-title-sky {
            border-left-color: #38bdf8;
        }
        .sys-doc-grid-2 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-top: 0.75rem;
        }
        @media (min-width: 768px) {
            .sys-doc-grid-2 {
                grid-template-columns: 1fr 1fr;
            }
        }
        .sys-doc-grid-3 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-top: 0.75rem;
        }
        @media (min-width: 768px) {
            .sys-doc-grid-3 {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        .sys-doc-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 1rem;
        }
        .dark .sys-doc-box {
            background: #1f1f23;
            border-color: #27272a;
        }
        .sys-doc-box-emerald {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 4px solid #16a34a;
        }
        .dark .sys-doc-box-emerald {
            background: rgba(6, 95, 70, 0.2);
            border-color: rgba(16, 185, 129, 0.3);
            border-left-color: #10b981;
        }
        .sys-doc-box-amber {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-left: 4px solid #f59e0b;
        }
        .dark .sys-doc-box-amber {
            background: rgba(180, 83, 9, 0.2);
            border-color: rgba(245, 158, 11, 0.3);
            border-left-color: #f59e0b;
        }
        .sys-doc-formula {
            background: #0f172a;
            color: #38bdf8;
            font-family: monospace;
            font-size: 0.75rem;
            padding: 0.625rem 0.875rem;
            border-radius: 0.5rem;
            margin: 0.5rem 0;
            overflow-x: auto;
        }
        .sys-doc-table-wrap {
            overflow-x: auto;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            margin: 1rem 0;
        }
        .dark .sys-doc-table-wrap {
            border-color: #27272a;
        }
        .sys-doc-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8125rem;
            text-align: left;
        }
        .sys-doc-table th {
            background: #f1f5f9;
            color: #0f172a;
            font-weight: 800;
            padding: 0.625rem 0.875rem;
            border-bottom: 1px solid #cbd5e1;
        }
        .dark .sys-doc-table th {
            background: #27272a;
            color: #f4f4f5;
            border-bottom-color: #3f3f46;
        }
        .sys-doc-table td {
            padding: 0.625rem 0.875rem;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }
        .dark .sys-doc-table td {
            border-bottom-color: #27272a;
            color: #d4d4d8;
        }
        .sys-doc-table tr:nth-child(even) td {
            background: #f8fafc;
        }
        .dark .sys-doc-table tr:nth-child(even) td {
            background: #18181b;
        }
        .sys-doc-num-circle {
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 9999px;
            background: #ecfdf5;
            color: #065f46;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 800;
            margin-right: 0.375rem;
        }
        .dark .sys-doc-num-circle {
            background: rgba(6, 95, 70, 0.4);
            color: #6ee7b7;
        }
        .sys-icon-sm {
            width: 1.15rem;
            height: 1.15rem;
            flex-shrink: 0;
        }
    </style>

    <div x-data="{ activeTab: 'admin' }" class="sys-doc-wrap">
        <!-- Navigation Tabs -->
        <div class="sys-doc-tabs">
            <button 
                type="button"
                @click="activeTab = 'admin'"
                :class="activeTab === 'admin' ? 'sys-doc-tab-btn-admin-active' : 'sys-doc-tab-btn-inactive'"
                class="sys-doc-tab-btn">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-shield-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'sys-icon-sm']); ?>
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
                <span>Admin Operations &amp; Algorithms Guide</span>
            </button>

            <button 
                type="button"
                @click="activeTab = 'student'"
                :class="activeTab === 'student' ? 'sys-doc-tab-btn-student-active' : 'sys-doc-tab-btn-inactive'"
                class="sys-doc-tab-btn">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-academic-cap'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'sys-icon-sm']); ?>
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
                <span>Student / Aspirant User Manual</span>
            </button>
        </div>

        <!-- Admin Manual Tab Content -->
        <div x-show="activeTab === 'admin'" x-transition class="sys-doc-card">
            <div class="sys-doc-header">
                <div>
                    <span class="sys-doc-badge sys-doc-badge-emerald">
                        Official Administrator Guide (Non-Technical &amp; Engineering)
                    </span>
                    <h2 class="sys-doc-title">Administrator Operations, Curriculum Catalog &amp; Algorithms Guide</h2>
                    <p class="sys-doc-subtitle">Step-by-step practical workflows with Loksewa examples, quiz builder tutorial, and plain-English algorithm explanations.</p>
                </div>
                <a href="<?php echo e(asset('storage/docs/Loksewa_Admin_and_Algorithms_Manual.pdf')); ?>" target="_blank" download class="sys-doc-download-btn">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-arrow-down-tray'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'sys-icon-sm']); ?>
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
                    <span>Download Admin Manual (PDF)</span>
                </a>
            </div>

            <!-- Welcome Callout -->
            <div class="sys-doc-box sys-doc-box-emerald" style="margin-bottom: 1.25rem;">
                <h3 style="font-size: 0.95rem; font-weight: 800; margin: 0 0 0.375rem 0; color: #065f46;">👋 Welcome, Loksewa Administrator!</h3>
                <p style="font-size: 0.8125rem; margin: 0; line-height: 1.5;">
                    This manual is written so that <strong>anyone &mdash; even without a technical or computer science background &mdash;</strong> can easily manage courses, publish new study notes, create interactive practice quizzes, and understand how the platform's smart algorithms work behind the scenes.
                </p>
            </div>

            <!-- Section 1: Practical Everyday Workflows -->
            <h3 class="sys-doc-section-title">1. Everyday Operational Workflows (With Real Examples)</h3>
            <div class="sys-doc-grid-2">
                <!-- Workflow 1 -->
                <div class="sys-doc-box">
                    <div style="font-weight: 800; font-size: 0.875rem; margin-bottom: 0.5rem; display: flex; align-items: center;">
                        <span class="sys-doc-num-circle">1</span>
                        How to Create a New Course
                    </div>
                    <ol style="margin: 0; padding-left: 1.25rem; font-size: 0.8125rem; line-height: 1.5;">
                        <li>Click <strong>Course Management &rarr; Courses &rarr; New Course</strong>.</li>
                        <li>Enter <strong>Title</strong> (e.g. <code>बागमती प्रदेश खरिदार तयारी</code>).</li>
                        <li>Enter <strong>Slug</strong> (e.g. <code>bagmati-pradesh-kharidar</code>).</li>
                        <li>Write a brief <strong>Description</strong> of the syllabus.</li>
                        <li>Toggle <strong>Published</strong> to ON when ready for students.</li>
                        <li>Click <strong>Create</strong>.</li>
                    </ol>
                </div>

                <!-- Workflow 2 -->
                <div class="sys-doc-box">
                    <div style="font-weight: 800; font-size: 0.875rem; margin-bottom: 0.5rem; display: flex; align-items: center;">
                        <span class="sys-doc-num-circle">2</span>
                        How to Build Modules &amp; Chapters
                    </div>
                    <ol style="margin: 0; padding-left: 1.25rem; font-size: 0.8125rem; line-height: 1.5;">
                        <li>Open your Course &rarr; scroll to <strong>Modules</strong> &rarr; Click <strong>New Module</strong> (e.g. <em>"पहिलो पत्र: सामान्य ज्ञान"</em>).</li>
                        <li>On that Module row, click <strong>Manage Chapters</strong> &rarr; Click <strong>New Chapter</strong> (e.g. <em>"नेपालको भूगोल र हावापानी"</em>).</li>
                        <li>On the Chapter row, click <strong>Manage Lessons</strong> &rarr; Click <strong>New Lesson</strong>.</li>
                    </ol>
                </div>

                <!-- Workflow 3 -->
                <div class="sys-doc-box">
                    <div style="font-weight: 800; font-size: 0.875rem; margin-bottom: 0.5rem; display: flex; align-items: center;">
                        <span class="sys-doc-num-circle">3</span>
                        Adding Study Notes &amp; PDFs
                    </div>
                    <p style="font-size: 0.8125rem; margin: 0 0 0.5rem 0;">When creating a lesson, select the <strong>Lesson Type</strong>:</p>
                    <ul style="margin: 0; padding-left: 1.25rem; font-size: 0.8125rem; line-height: 1.5;">
                        <li><strong>Structured Text:</strong> Type reading notes directly into the rich text box.</li>
                        <li><strong>PDF Document:</strong> Enter file path (e.g. <code>storage/notes/loksewa/kharidar-gk-notes.pdf</code>) for students to read and download.</li>
                        <li><strong>Video Lesson:</strong> Paste a streaming lecture URL.</li>
                    </ul>
                </div>

                <!-- Workflow 4 -->
                <div class="sys-doc-box">
                    <div style="font-weight: 800; font-size: 0.875rem; margin-bottom: 0.5rem; display: flex; align-items: center;">
                        <span class="sys-doc-num-circle">4</span>
                        Setting Prerequisite Roadmaps
                    </div>
                    <ol style="margin: 0; padding-left: 1.25rem; font-size: 0.8125rem; line-height: 1.5;">
                        <li>Edit a course (e.g. <em>Section Officer Tayari</em>).</li>
                        <li>In <strong>Prerequisites</strong>, select <em>Nayab Subba Tayari</em>.</li>
                        <li>Click <strong>Save</strong>.</li>
                        <li>The interactive graph at <code>/visualizer</code> automatically updates with a roadmap arrow.</li>
                    </ol>
                </div>
            </div>

            <!-- Dynamic Quiz Builder Box -->
            <div class="sys-doc-box sys-doc-box-amber" style="margin-top: 1.25rem;">
                <h3 style="font-size: 0.95rem; font-weight: 800; margin: 0 0 0.375rem 0; color: #b45309;">✍️ How to Create &amp; Edit Multiple-Choice Quizzes (MCQs)</h3>
                <p style="font-size: 0.8125rem; margin: 0 0 0.5rem 0; line-height: 1.5;">You can create dynamic practice tests without touching any code or raw JSON:</p>
                <ol style="margin: 0; padding-left: 1.25rem; font-size: 0.8125rem; line-height: 1.6;">
                    <li>Create a new lesson with <strong>Lesson Type = Dynamic MCQ Quiz</strong>.</li>
                    <li>Scroll down to the <strong>Dynamic MCQ Quiz Questions Builder</strong> section.</li>
                    <li>Click <strong>"Add to quiz_questions"</strong>.</li>
                    <li>Type the question prompt (e.g. <em>"नेपालको कुल क्षेत्रफल कति वर्ग किलोमिटर छ?"</em>).</li>
                    <li>Enter choices: Option A (<code>147,181 sq km</code>), Option B (<code>147,516 sq km</code>), Option C (<code>147,885 sq km</code>), Option D (<code>146,516 sq km</code>).</li>
                    <li>Select <strong>Correct Option</strong> = <code>Option B (Choice 2)</code>.</li>
                    <li>Add a helpful <strong>Loksewa Legal/Syllabus Explanation</strong> for candidate review.</li>
                    <li>Click <strong>Save</strong>. The quiz is immediately live for candidates!</li>
                </ol>
            </div>

            <!-- Section 2: Algorithms Deep Dive -->
            <h3 class="sys-doc-section-title">2. Plain-English Guide to the 6 Smart Algorithms</h3>
            <p style="font-size: 0.8125rem; color: #64748b; margin: 0 0 0.75rem 0;">You can check live algorithm performance anytime in <strong>Reports &rarr; Algorithm Report</strong> (<code>/admin/algorithm-report</code>).</p>
            <div class="sys-doc-grid-2">
                <div class="sys-doc-box">
                    <div style="font-weight: 800; font-size: 0.875rem; margin-bottom: 0.25rem;">1. Prerequisite Sequencing (DAG &amp; Kahn's Algorithm)</div>
                    <div class="sys-doc-formula">In-Degree array &rarr; Queue in_degree == 0 &rarr; Linear topological sort</div>
                    <p style="font-size: 0.8125rem; line-height: 1.5; margin: 0;"><strong>What it does:</strong> Organizes courses like ladder steps so students master foundations first and prevents circular dependency deadlocks.</p>
                </div>

                <div class="sys-doc-box">
                    <div style="font-weight: 800; font-size: 0.875rem; margin-bottom: 0.25rem;">2. Trending Courses (Hacker News Gravity Decay)</div>
                    <div class="sys-doc-formula">Score = (Enrollments - 1) / (Hours_Since_Launch + 2)^1.8</div>
                    <p style="font-size: 0.8125rem; line-height: 1.5; margin: 0;"><strong>What it does:</strong> Ranks courses based on active enrollment surges. Newly opened vacancies trend to the top automatically.</p>
                </div>

                <div class="sys-doc-box">
                    <div style="font-weight: 800; font-size: 0.875rem; margin-bottom: 0.25rem;">3. Peer Recommendations (Jaccard Collaborative Filtering)</div>
                    <div class="sys-doc-formula">Jaccard(A, B) = |Users(A) ∩ Users(B)| / |Users(A) ∪ Users(B)|</div>
                    <p style="font-size: 0.8125rem; line-height: 1.5; margin: 0;"><strong>What it does:</strong> Discovers what courses candidates study together (e.g. Banking students taking NRB Officer + Constitution).</p>
                </div>

                <div class="sys-doc-box">
                    <div style="font-weight: 800; font-size: 0.875rem; margin-bottom: 0.25rem;">4. Syllabus Keyword Matching (TF-IDF Content Similarity)</div>
                    <div class="sys-doc-formula">TF-IDF = TF(t,d) * log(N / DF(t)) | Similarity = cos(θ)</div>
                    <p style="font-size: 0.8125rem; line-height: 1.5; margin: 0;"><strong>What it does:</strong> Solves the cold-start problem. Brand new courses with 0 students get matched by syllabus keywords immediately.</p>
                </div>

                <div class="sys-doc-box">
                    <div style="font-weight: 800; font-size: 0.875rem; margin-bottom: 0.25rem;">5. Smart Memory Retention (SuperMemo SM-2 Engine)</div>
                    <div class="sys-doc-formula">EF' = EF + (0.1 - (5 - q) * (0.08 + (5 - q) * 0.02))</div>
                    <p style="font-size: 0.8125rem; line-height: 1.5; margin: 0;"><strong>What it does:</strong> Calculates individual review intervals so candidates review difficult dates and laws right before memory decays.</p>
                </div>

                <div class="sys-doc-box">
                    <div style="font-weight: 800; font-size: 0.875rem; margin-bottom: 0.25rem;">6. Projected Completion Date (Historical Pacing Extrapolation)</div>
                    <div class="sys-doc-formula">Pace = &Delta;t_actual / &Delta;t_expected | Finish = Now + Remaining * Pace</div>
                    <p style="font-size: 0.8125rem; line-height: 1.5; margin: 0;"><strong>What it does:</strong> Measures each candidate's study velocity and projects their syllabus finish date in real time.</p>
                </div>
            </div>

            <!-- Section 3: Full Course Reference Table -->
            <h3 class="sys-doc-section-title">3. Complete 8-Course Syllabus Summary</h3>
            <div class="sys-doc-table-wrap">
                <table class="sys-doc-table">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Target Post</th>
                            <th>Modules &amp; Content Highlights</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>1. खरिदार तयारी</strong></td>
                            <td>Non-Gazetted 2nd Class</td>
                            <td>GK, Office Management, IQ, Darta/Chalani filing procedures, 4 Quizzes, Official PDF.</td>
                        </tr>
                        <tr>
                            <td><strong>2. नायब सुब्बा तयारी</strong></td>
                            <td>Non-Gazetted 1st Class</td>
                            <td>Paper I GK/IQ, Paper II General Administration, Government Accounting &amp; Beruju, 3 Quizzes.</td>
                        </tr>
                        <tr>
                            <td><strong>3. शाखा अधिकृत तयारी</strong></td>
                            <td>Gazetted 3rd Class</td>
                            <td>AAT Screening (GK/IQ/English), Governance Systems (NPM &amp; Federalism), Contemporary Issues.</td>
                        </tr>
                        <tr>
                            <td><strong>4. NRB Officer तयारी</strong></td>
                            <td>Central Bank Officer</td>
                            <td>Micro/Macroeconomics, GDP, Nepalese Banking System (Classes A-D), Banking Double Entry.</td>
                        </tr>
                        <tr>
                            <td><strong>5. NRB Assistant Director</strong></td>
                            <td>Senior Central Banking</td>
                            <td>NRB Act 2058, BAFIA, FX Regulation, Monetary Policy Corridor, Basel III Capital Adequacy.</td>
                        </tr>
                        <tr>
                            <td><strong>6. नेपालको संविधान र कानून</strong></td>
                            <td>Cross-cutting Legal</td>
                            <td>Constitution 2072 (Parts, Articles, Fundamental Rights 16-46), Good Governance Act 2064, RTI.</td>
                        </tr>
                        <tr>
                            <td><strong>7. कम्प्युटर सीप परीक्षा</strong></td>
                            <td>Practical Proficiency</td>
                            <td>MS Word formatting, MS Excel lookup &amp; formulas, Email etiquette, Nepali Unicode Typing.</td>
                        </tr>
                        <tr>
                            <td><strong>8. बौद्धिक परीक्षण (IQ)</strong></td>
                            <td>Aptitude &amp; Reasoning</td>
                            <td>Verbal Analogy, Number Series, Coding-Decoding, Direction Sense, Blood Relations.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Student Manual Tab Content -->
        <div x-show="activeTab === 'student'" x-transition class="sys-doc-card">
            <div class="sys-doc-header">
                <div>
                    <span class="sys-doc-badge sys-doc-badge-sky">
                        Aspirant &amp; Candidate Guide
                    </span>
                    <h2 class="sys-doc-title">Student / Aspirant User Manual</h2>
                    <p class="sys-doc-subtitle">Step-by-step guidance for Loksewa candidates: course navigation, quizzes, spaced reviews, and pace tracking.</p>
                </div>
                <a href="<?php echo e(asset('storage/docs/Loksewa_Student_User_Manual.pdf')); ?>" target="_blank" download class="sys-doc-download-btn sys-doc-download-btn-sky">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-arrow-down-tray'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'sys-icon-sm']); ?>
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
                    <span>Download Student Manual (PDF)</span>
                </a>
            </div>

            <div class="sys-doc-box" style="background: #f0f9ff; border-color: #bae6fd; margin-bottom: 1.25rem;">
                <h3 style="font-size: 0.95rem; font-weight: 800; margin: 0 0 0.375rem 0; color: #0369a1;">1. Accessing Your Dashboard</h3>
                <p style="font-size: 0.8125rem; margin: 0; line-height: 1.5;">
                    Sign in at <code>/login</code> to open your dashboard at <code>/dashboard</code>. Here you will see active enrollments, overall progress percentages, upcoming SM-2 flashcards, and personalized completion estimates.
                </p>
            </div>

            <h3 class="sys-doc-section-title sys-doc-section-title-sky">2. Navigating Course Curriculum</h3>
            <div class="sys-doc-grid-3">
                <div class="sys-doc-box">
                    <div style="font-weight: 800; font-size: 0.875rem; margin-bottom: 0.25rem;">📑 Modules</div>
                    <p style="font-size: 0.8125rem; margin: 0; line-height: 1.5; color: #64748b;">Broad syllabus papers such as Paper I (General Knowledge &amp; IQ) and Paper II (Governance &amp; Administration).</p>
                </div>
                <div class="sys-doc-box">
                    <div style="font-weight: 800; font-size: 0.875rem; margin-bottom: 0.25rem;">📖 Chapters</div>
                    <p style="font-size: 0.8125rem; margin: 0; line-height: 1.5; color: #64748b;">Thematic subject units like Nepal Geography, Modern Political History, or Constitution 2072.</p>
                </div>
                <div class="sys-doc-box">
                    <div style="font-weight: 800; font-size: 0.875rem; margin-bottom: 0.25rem;">✍️ Lessons &amp; Quizzes</div>
                    <p style="font-size: 0.8125rem; margin: 0; line-height: 1.5; color: #64748b;">Interactive study units with structured notes, official printable PDFs, or objective MCQ assessments.</p>
                </div>
            </div>

            <h3 class="sys-doc-section-title sys-doc-section-title-sky">3. Interactive MCQ Assessment Engine</h3>
            <div class="sys-doc-box">
                <p style="font-size: 0.8125rem; margin: 0; line-height: 1.5;">
                    Practice real examination questions with instant answer evaluation, detailed explanation rationales, and automatic SM-2 score calibration.
                </p>
            </div>
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
<?php /**PATH C:\xampp\htdocs\loksewa_course\resources\views/filament/pages/system-documentation.blade.php ENDPATH**/ ?>