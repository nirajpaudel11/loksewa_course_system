<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

class SystemDocumentationPdfService
{
    private static bool $autoloadRegistered = false;

    public function __construct()
    {
        self::ensureAutoload();
    }

    private static function ensureAutoload(): void
    {
        if (self::$autoloadRegistered) {
            return;
        }

        $cpdfPath = base_path('vendor/dompdf/dompdf/lib/Cpdf.php');
        if (file_exists($cpdfPath) && ! class_exists('Dompdf\Cpdf', false)) {
            require_once $cpdfPath;
        }

        spl_autoload_register(function ($class) {
            $prefixes = [
                'Dompdf\\' => base_path('vendor/dompdf/dompdf/src/'),
                'FontLib\\' => base_path('vendor/dompdf/php-font-lib/src/FontLib/'),
                'Svg\\' => base_path('vendor/dompdf/php-svg-lib/src/Svg/'),
                'Sabberworm\\CSS\\' => base_path('vendor/sabberworm/php-css-parser/src/'),
                'Barryvdh\\DomPDF\\' => base_path('vendor/barryvdh/laravel-dompdf/src/'),
            ];

            foreach ($prefixes as $prefix => $baseDir) {
                $len = strlen($prefix);
                if (strncmp($prefix, $class, $len) !== 0) {
                    continue;
                }

                $relativeClass = substr($class, $len);
                $file = $baseDir.str_replace('\\', '/', $relativeClass).'.php';

                if (file_exists($file)) {
                    require_once $file;

                    return;
                }
            }
        });

        self::$autoloadRegistered = true;
    }

    public function generateAll(): array
    {
        $docsDir = public_path('storage/docs');
        if (! is_dir($docsDir)) {
            mkdir($docsDir, 0755, true);
        }

        $adminPdfPath = $docsDir.'/Loksewa_Admin_and_Algorithms_Manual.pdf';
        $studentPdfPath = $docsDir.'/Loksewa_Student_User_Manual.pdf';

        $this->renderPdf($this->getAdminManualHtml(), $adminPdfPath);
        $this->renderPdf($this->getStudentManualHtml(), $studentPdfPath);

        return [
            'admin_pdf' => $adminPdfPath,
            'student_pdf' => $studentPdfPath,
        ];
    }

    private function renderPdf(string $html, string $outputPath): void
    {
        $options = new Options;
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        file_put_contents($outputPath, $dompdf->output());
    }

    private function getCommonCss(): string
    {
        return <<<'CSS'
        @page {
            margin: 38px 32px 38px 32px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 8.8pt;
            line-height: 1.42;
            color: #1e293b;
        }
        .header {
            text-align: center;
            border-bottom: 2.5px solid #0f172a;
            padding-bottom: 9px;
            margin-bottom: 12px;
        }
        .header h1 {
            font-size: 15pt;
            color: #0f172a;
            margin: 0 0 3px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header .subtitle {
            font-size: 9pt;
            color: #0369a1;
            font-style: italic;
        }
        .badge {
            display: inline-block;
            background: #0f766e;
            color: #ffffff;
            padding: 2.5px 8px;
            border-radius: 4px;
            font-size: 7.5pt;
            font-weight: bold;
            margin-top: 4px;
        }
        h2 {
            font-size: 11pt;
            color: #0f172a;
            border-left: 4px solid #0f766e;
            padding-left: 7px;
            margin-top: 13px;
            margin-bottom: 5px;
            background: #f8fafc;
            padding-top: 3px;
            padding-bottom: 3px;
        }
        h3 {
            font-size: 9.5pt;
            color: #0369a1;
            margin-top: 8px;
            margin-bottom: 3px;
        }
        p {
            margin: 3px 0;
            text-align: justify;
        }
        ul, ol {
            margin: 3px 0 5px 12px;
            padding-left: 8px;
        }
        li {
            margin-bottom: 2px;
        }
        .box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 3.5px solid #16a34a;
            padding: 6px 9px;
            margin: 6px 0;
            border-radius: 4px;
            font-size: 8.5pt;
        }
        .example-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-left: 3.5px solid #f59e0b;
            padding: 6px 9px;
            margin: 6px 0;
            border-radius: 4px;
            font-size: 8.5pt;
        }
        .algo-box {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-left: 3.5px solid #0284c7;
            padding: 6px 9px;
            margin: 6px 0;
            border-radius: 4px;
            font-size: 8.5pt;
        }
        .course-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 3.5px solid #0f766e;
            padding: 6px 9px;
            margin: 6px 0;
            border-radius: 4px;
        }
        .formula {
            font-family: 'Courier New', monospace;
            background: #1e293b;
            color: #38bdf8;
            padding: 4px 7px;
            border-radius: 4px;
            display: block;
            margin: 4px 0;
            font-size: 7.8pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0;
            font-size: 8pt;
        }
        table th {
            background: #0f172a;
            color: #ffffff;
            padding: 4px 6px;
            text-align: left;
            font-weight: bold;
        }
        table td {
            border: 1px solid #cbd5e1;
            padding: 3.5px 5px;
        }
        table tr:nth-child(even) td {
            background: #f8fafc;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7pt;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 3px;
        }
        strong { color: #0f172a; }
CSS;
    }

    public function getAdminManualHtml(): string
    {
        $css = $this->getCommonCss();

        $content = <<<'HTML'
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>%%CSS%%</style>
</head>
<body>
<div class="footer">Loksewa LMS &mdash; Administrator User Guide & Operational Manual &mdash; Official Reference</div>
<div class="header">
    <h1>Loksewa Course Management System</h1>
    <div class="subtitle">Complete Administrator Operations, Content Management & Algorithms Guide</div>
    <div class="badge">Non-Technical Administrator & Engineering Reference</div>
</div>

<h2>1. Introduction & Welcome for Administrators</h2>
<p>Welcome to the administrative portal of the <strong>Loksewa Course System</strong>. This platform is designed to manage civil service and banking exam preparation courses for candidates in Nepal (such as Kharidar, Nayab Subba, Section Officer, and Nepal Rastra Bank). As an administrator, you do <strong>not</strong> need any technical or programming knowledge to manage courses, add multiple-choice quizzes, upload study PDFs, or monitor student learning pacing.</p>

<div class="box">
    <strong>Admin Portal Login:</strong><br>
    Visit <code>http://localhost:8000/admin</code> &rarr; Log in with <strong>Email:</strong> <code>admin@loksewa.com</code> & <strong>Password:</strong> <code>admin123</code>.
</div>

<h2>2. Everyday Operational Workflows (Step-by-Step with Examples)</h2>

<h3>Workflow A: How to Create a New Course</h3>
<p>Whenever the Public Service Commission (Lok Sewa Aayog) announces a new curriculum or exam track (e.g. <em>Pradesh 1 Nayab Subba</em> or <em>Bagmati Pradesh Kharidar</em>), follow these steps:</p>
<ol>
    <li>On the left navigation menu, click <strong>Course Management &rarr; Courses</strong>.</li>
    <li>Click the top-right button <strong>"New Course"</strong>.</li>
    <li><strong>Title:</strong> Enter the official name, for example: <code>बागमती प्रदेश खरिदार तयारी</code>.</li>
    <li><strong>Slug:</strong> Auto-fills or type a web-friendly URL, e.g. <code>bagmati-pradesh-kharidar</code>.</li>
    <li><strong>Description:</strong> Write a helpful overview of what the course covers (e.g. <em>"Comprehensive preparation for Bagmati Pradesh Local Level 4th Level General Knowledge & Office Management"</em>).</li>
    <li><strong>Published:</strong> Toggle on (Active) when ready for students to see, or off to keep as a draft.</li>
    <li>Click <strong>"Create"</strong>.</li>
</ol>

<div class="example-box">
    <strong>💡 Practical Example:</strong> To add a specialized math booster course, create a course with Title: <em>"Loksewa Quantitative Aptitude Booster"</em>, Slug: <em>"loksewa-math-booster"</em>, and mark Published as ON. It will immediately appear on the public catalog (<code>/catalog</code>).
</div>

<h3>Workflow B: How to Build Course Curriculum (4-Tier Hierarchy)</h3>
<p>Courses are organized into an easy-to-follow 4-tier structure: <strong>Course &rarr; Modules &rarr; Chapters &rarr; Lessons</strong>.</p>
<table>
    <tr><th>Hierarchy Level</th><th>What it represents</th><th>Real Loksewa Example</th></tr>
    <tr><td><strong>1. Course</strong></td><td>The whole exam preparation program</td><td>Nayab Subba Tayari (Non-Gazetted 1st Class)</td></tr>
    <tr><td><strong>2. Module</strong></td><td>Major examination papers or broad subjects</td><td>Module 1: पहिलो पत्र (सामान्य ज्ञान र बुद्धि परीक्षण)</td></tr>
    <tr><td><strong>3. Chapter</strong></td><td>Specific topics within that subject</td><td>Chapter 1: नेपालको भूगोल र हावापानी (Geography & Climate)</td></tr>
    <tr><td><strong>4. Lesson</strong></td><td>Single study item (Text, PDF note, Quiz, or Video)</td><td>Lesson 1: Major River Systems of Nepal (Text + PDF)</td></tr>
</table>

<ol>
    <li><strong>Add Modules:</strong> Open your Course &rarr; scroll to <strong>Modules</strong> relation table &rarr; Click <strong>"New Module"</strong> (e.g. Title: <em>"पहिलो पत्र: सामान्य ज्ञान"</em>, Order: <em>1</em>).</li>
    <li><strong>Add Chapters:</strong> On the Module row, click <strong>"Manage Chapters"</strong> (or edit the module) &rarr; scroll to <strong>Chapters</strong> table &rarr; Click <strong>"New Chapter"</strong> (e.g. Title: <em>"नेपालको इतिहास र संस्कृति"</em>, Order: <em>1</em>).</li>
    <li><strong>Add Lessons:</strong> On the Chapter row, click <strong>"Manage Lessons"</strong> &rarr; Click <strong>"New Lesson"</strong>.</li>
</ol>

<h3>Workflow C: Adding Different Types of Lessons</h3>
<p>When creating a lesson, you can choose between 4 distinct content formats:</p>
<ul>
    <li><strong>1. Structured Text Notes:</strong> Select <code>Lesson Type = Structured Text Notes</code>. Type or paste your study notes into the content box. Use headings, bullet points, and summary notes.</li>
    <li><strong>2. Printable PDF Document:</strong> Select <code>Lesson Type = PDF Document</code>. In <em>Attachment Path</em>, provide the storage path (e.g. <code>storage/notes/loksewa/kharidar-gk-notes.pdf</code>). Candidates can read and download this PDF directly from their study screen.</li>
    <li><strong>3. Video Lesson:</strong> Select <code>Lesson Type = Video Lesson</code>. Paste a YouTube or Vimeo streaming URL into <em>Video Streaming URL</em>.</li>
    <li><strong>4. Dynamic MCQ Practice Quiz:</strong> See Workflow D below.</li>
</ul>

<h3>Workflow D: How to Build & Edit Dynamic Multiple Choice Quizzes (MCQs)</h3>
<p>You can create interactive practice quizzes without touching any code:</p>
<ol>
    <li>Create a lesson with <strong>Lesson Type = Dynamic MCQ Quiz</strong>.</li>
    <li>Scroll down to the <strong>Dynamic MCQ Quiz Questions Builder</strong> section.</li>
    <li>Click <strong>"Add to quiz_questions"</strong> to create a new question block.</li>
    <li><strong>Question Prompt:</strong> Type the question (e.g., <em>"नेपालको कुल क्षेत्रफल कति वर्ग किलोमिटर छ?"</em>).</li>
    <li><strong>Options (A, B, C, D):</strong>
        <ul>
            <li><strong>Option A:</strong> <code>147,181 sq km</code></li>
            <li><strong>Option B:</strong> <code>147,516 sq km</code></li>
            <li><strong>Option C:</strong> <code>147,885 sq km</code></li>
            <li><strong>Option D:</strong> <code>146,516 sq km</code></li>
        </ul>
    </li>
    <li><strong>Correct Option:</strong> Select <code>Option B (Choice 2)</code>.</li>
    <li><strong>Explanation / Legal Citation:</strong> Write the rationale (e.g., <em>"As per the updated official survey including Lipulekh and Limpiyadhura, the total area of Nepal is 147,516 sq km."</em>).</li>
    <li>Click <strong>"Add to quiz_questions"</strong> again to add Question 2, Question 3, etc. You can reorder questions by dragging them or clone questions with one click.</li>
    <li>Click <strong>"Save"</strong>. The quiz is immediately live for candidates!</li>
</ol>

<h3>Workflow E: Setting Course Prerequisites (Visual Learning Paths)</h3>
<p>To guide students so they don't take advanced courses before finishing foundations (for example, taking Kharidar before Nayab Subba, and Nayab Subba before Section Officer):</p>
<ol>
    <li>Navigate to <strong>Course Management &rarr; Courses &rarr; Edit Course</strong>.</li>
    <li>In the <strong>Prerequisites</strong> multi-select field, select the foundational course(s).</li>
    <li>Click <strong>Save</strong>.</li>
    <li>The interactive graph at <code>http://localhost:8000/visualizer</code> will automatically update with an arrow connecting the two courses, and the system will ensure candidates complete the foundation first.</li>
</ol>

<h3>Workflow F: Managing Users, Passwords & Enrollments</h3>
<ul>
    <li><strong>View Registered Candidates:</strong> Go to <strong>User Management &rarr; Users</strong>. You can search by name or email, see their active learning pace multiplier, and view assigned roles (Admin or User).</li>
    <li><strong>Reset a Student's Password:</strong> Click <strong>Edit</strong> on a user &rarr; type a new password in the password field &rarr; Click <strong>Save</strong>.</li>
    <li><strong>View Real-time Enrollments:</strong> On the main Dashboard, the <em>"Latest Enrollments"</em> table shows recent enrollments with student name, course, and enrollment date.</li>
</ul>

<h2>3. Plain-English Guide to the 6 Smart Algorithms (The Algorithm Report)</h2>
<p>The LMS includes 6 built-in mathematical algorithms that make candidate study effective. Administrators can inspect live performance anytime at <strong>Reports &rarr; Algorithm Report</strong> (<code>/admin/algorithm-report</code>). Here is what each algorithm does in simple terms:</p>

<div class="algo-box">
    <h3>1. Course Prerequisite Roadmaps (DAG & Kahn's Topological Sort)</h3>
    <p><strong>What it does in simple terms:</strong> It organizes courses like steps on a ladder so students know exactly which course to study first, second, and third.</p>
    <p><strong>Why it's the right choice:</strong> In Loksewa, a student who doesn't understand Kharidar office procedures will struggle in Section Officer administrative governance. The algorithm also prevents errors where Course A requires Course B, but Course B accidentally requires Course A (circular deadlock).</p>
    <p><strong>Where you see it:</strong> In the interactive graph at <code>/visualizer</code> and on course enrollment pages.</p>
</div>

<div class="algo-box">
    <h3>2. Trending Courses Leaderboard (Hacker News Gravity Decay)</h3>
    <p><strong>What it does in simple terms:</strong> It ranks popular courses on the homepage and catalog, but gives higher priority to courses that students are enrolling in <em>right now</em> rather than courses from months ago.</p>
    <p><strong>Why it's the right choice:</strong> Loksewa vacancies happen at different times of the year (e.g. Section Officer in winter, Kharidar in spring). When a new vacancy opens, that course immediately trends to the top.</p>
    <p><strong>Where you see it:</strong> The featured courses on the homepage, catalog sorting, and the Algorithm Report trending table.</p>
</div>

<div class="algo-box">
    <h3>3. "Students Also Enrolled In" (Collaborative Filtering)</h3>
    <p><strong>What it does in simple terms:</strong> It looks at what groups of students study together. For instance, if 90% of candidates who take <em>NRB Officer</em> also take <em>Nepal Constitution</em>, it automatically recommends the Constitution course to new NRB students.</p>
    <p><strong>Why it's the right choice:</strong> It creates smart recommendations tailored to career streams (Admin vs. Banking) without admins having to manually connect every course.</p>
    <p><strong>Where you see it:</strong> On course details pages under <em>"Students also enrolled in..."</em>.</p>
</div>

<div class="algo-box">
    <h3>4. Syllabus Keyword Matching (Content-Based Filtering / TF-IDF)</h3>
    <p><strong>What it does in simple terms:</strong> When you publish a brand new course with zero students, the system reads the syllabus keywords and automatically matches it with related courses.</p>
    <p><strong>Why it's the right choice:</strong> Brand new courses don't have enrollment history yet (the "Cold-Start" problem), so text matching ensures they get recommended immediately.</p>
    <p><strong>Where you see it:</strong> Related topic suggestions and curriculum search.</p>
</div>

<div class="algo-box">
    <h3>5. Smart Memory Retention & Flashcards (SuperMemo SM-2)</h3>
    <p><strong>What it does in simple terms:</strong> It tracks how well a candidate remembers difficult dates, constitutional articles, and facts. If a student finds a topic hard, it schedules a review for tomorrow; if easy, it schedules it for next week.</p>
    <p><strong>Why it's the right choice:</strong> Loksewa requires memorizing thousands of facts that candidates easily forget over time (the forgetting curve). SM-2 prompts revisions right before memory fades.</p>
    <p><strong>Where you see it:</strong> The candidate's daily flashcard review queue on their dashboard (<em>Due Today</em>, <em>Upcoming 7 Days</em>) and the difficulty distribution bar in the Algorithm Report.</p>
</div>

<div class="algo-box">
    <h3>6. Projected Exam Completion Date (Learning Pacing)</h3>
    <p><strong>What it does in simple terms:</strong> It measures how fast each student completes lessons and calculates the exact calendar date (e.g. <em>"October 14, 2026"</em>) when they will finish the syllabus.</p>
    <p><strong>Why it's the right choice:</strong> Full-time aspirants study quickly while working professionals study on weekends. Pacing forecasts give every candidate a realistic study deadline before the real exam.</p>
    <p><strong>Where you see it:</strong> On the student dashboard and in the Algorithm Report under <em>"Learning Pacing — Completion Prediction"</em>.</p>
</div>

<h2>4. Complete 8-Course Reference Catalog</h2>
<table>
    <tr><th>#</th><th>Course Title</th><th>Target Exam Post</th><th>Modules & Highlights</th></tr>
    <tr><td>1</td><td><strong>खरिदार तयारी</strong></td><td>Non-Gazetted 2nd Class</td><td>General Knowledge, Office Management, IQ Test, Filing/Darta/Chalani notes, 4 Quizzes, Official PDF.</td></tr>
    <tr><td>2</td><td><strong>नायब सुब्बा तयारी</strong></td><td>Non-Gazetted 1st Class</td><td>Paper I GK, Paper I IQ, Paper II General Administration, Accounting & Beruju procedures, 3 Quizzes.</td></tr>
    <tr><td>3</td><td><strong>शाखा अधिकृत तयारी</strong></td><td>Gazetted 3rd Class</td><td>AAT Screening Test (GK, IQ, English), Governance Systems (NPM & Federalism), Contemporary Issues, 3 Quizzes.</td></tr>
    <tr><td>4</td><td><strong>NRB Officer तयारी</strong></td><td>Central Bank Officer</td><td>Micro/Macroeconomics, GDP, Banking Structure (Classes A, B, C, D), Banking Accounting & NPAs, 3 Quizzes.</td></tr>
    <tr><td>5</td><td><strong>NRB Assistant Director</strong></td><td>Senior Central Banking</td><td>NRB Act 2058, BAFIA, FX Regulation, Monetary Policy Corridor, Basel III Capital Adequacy, 2 Quizzes.</td></tr>
    <tr><td>6</td><td><strong>नेपालको संविधान र कानून</strong></td><td>Cross-cutting Legal</td><td>Constitution of Nepal 2072 (Parts, Articles, Fundamental Rights 16-46), Good Governance Act 2064, RTI, 2 Quizzes.</td></tr>
    <tr><td>7</td><td><strong>कम्प्युटर सीप परीक्षा</strong></td><td>Practical Proficiency</td><td>MS Word formatting, MS Excel lookup & formulas, Email protocols, Nepali Unicode Typing, 2 Quizzes.</td></tr>
    <tr><td>8</td><td><strong>बौद्धिक परीक्षण (IQ)</strong></td><td>Aptitude & Reasoning</td><td>Verbal Analogy, Number Series, Coding-Decoding, Direction Sense, Blood Relations, 3 Quizzes.</td></tr>
</table>

<h2>5. Administrator FAQs & Pro-Tips</h2>
<ul>
    <li><strong>Q: How do I make a course visible to students?</strong><br>Open the course in Filament, check the <code>Published</code> toggle, and click Save.</li>
    <li><strong>Q: How do I update trending scores manually?</strong><br>Go to <strong>Reports &rarr; Algorithm Report</strong> and click the top-right button <strong>"Update Trending Scores"</strong>.</li>
    <li><strong>Q: How do I re-compile the official PDF manuals?</strong><br>Go to <strong>Reports &rarr; System Manuals & Docs</strong> and click <strong>"Re-compile PDFs"</strong>.</li>
</ul>
</body>
</html>
HTML;

        return str_replace('%%CSS%%', $css, $content);
    }

    public function getStudentManualHtml(): string
    {
        $css = $this->getCommonCss();

        return <<<'HTML'
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
        @page {
            margin: 38px 32px 38px 32px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 8.8pt;
            line-height: 1.42;
            color: #1e293b;
        }
        .header {
            text-align: center;
            border-bottom: 2.5px solid #0f172a;
            padding-bottom: 9px;
            margin-bottom: 12px;
        }
        .header h1 {
            font-size: 15pt;
            color: #0f172a;
            margin: 0 0 3px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header .subtitle {
            font-size: 9pt;
            color: #0369a1;
            font-style: italic;
        }
        .badge {
            display: inline-block;
            background: #0f766e;
            color: #ffffff;
            padding: 2.5px 8px;
            border-radius: 4px;
            font-size: 7.5pt;
            font-weight: bold;
            margin-top: 4px;
        }
        h2 {
            font-size: 11pt;
            color: #0f172a;
            border-left: 4px solid #0f766e;
            padding-left: 7px;
            margin-top: 13px;
            margin-bottom: 5px;
            background: #f8fafc;
            padding-top: 3px;
            padding-bottom: 3px;
        }
        h3 {
            font-size: 9.5pt;
            color: #0369a1;
            margin-top: 8px;
            margin-bottom: 3px;
        }
        p {
            margin: 3px 0;
            text-align: justify;
        }
        ul, ol {
            margin: 3px 0 5px 12px;
            padding-left: 8px;
        }
        li {
            margin-bottom: 2px;
        }
        .box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 3.5px solid #16a34a;
            padding: 6px 9px;
            margin: 6px 0;
            border-radius: 4px;
            font-size: 8.5pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0;
            font-size: 8pt;
        }
        table th {
            background: #0f172a;
            color: #ffffff;
            padding: 4px 6px;
            text-align: left;
            font-weight: bold;
        }
        table td {
            border: 1px solid #cbd5e1;
            padding: 3.5px 5px;
        }
        table tr:nth-child(even) td {
            background: #f8fafc;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7pt;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 3px;
        }
        strong { color: #0f172a; }
</style>
</head>
<body>
<div class="footer">Loksewa LMS &mdash; Candidate & Student User Guide &mdash; Public Service Commission Preparation</div>
<div class="header">
    <h1>Loksewa Candidate User Manual</h1>
    <div class="subtitle">Complete Study Guide for Lok Sewa Aayog & Banking Examination Aspirants</div>
    <div class="badge">Candidate Learning Portal Guide</div>
</div>

<h2>1. Welcome to Your Loksewa Study Portal</h2>
<p>This platform provides structured, syllabus-aligned preparation for Public Service Commission (PSC) and Nepal Rastra Bank examinations with smart revision algorithms to help you succeed.</p>

<div class="box">
    <strong>Quick Login Information:</strong><br>
    Visit <code>http://localhost:8000/login</code> &rarr; Log in with your registered student email and password &rarr; Redirects to your personal dashboard at <code>/dashboard</code>.
</div>

<h2>2. Finding & Enrolling in Courses</h2>
<ul>
    <li><strong>Browse All Courses (<code>/catalog</code>):</strong> View all published courses categorized by level: Beginner (Kharidar, Computer Skill, IQ), Intermediate (Nayab Subba, Constitution), and Advanced (Section Officer, NRB Officer).</li>
    <li><strong>Interactive Roadmap Visualizer (<code>/visualizer</code>):</strong> Explore the learning journey graph to see recommended course paths before enrolling.</li>
    <li><strong>Course Details:</strong> Click any course card to inspect the complete list of modules, chapters, estimated duration, and syllabus highlights. Click <strong>"Enroll in Course"</strong> to add it to your dashboard.</li>
</ul>

<h2>3. How to Study Course Content</h2>
<p>Each course is structured into <strong>Modules &rarr; Chapters &rarr; Lessons</strong>:</p>
<table>
    <tr><th>Lesson Format</th><th>How to use it</th><th>Benefit for Aspirants</th></tr>
    <tr><td><strong>Structured Notes</strong></td><td>Read topic summaries on your phone, tablet, or PC.</td><td>Key dates, legal clauses, and summary tables highlighted.</td></tr>
    <tr><td><strong>Printable PDF Notes</strong></td><td>Click to read or download official study notes.</td><td>Print out complete notes for offline study and revision.</td></tr>
    <tr><td><strong>MCQ Practice Quizzes</strong></td><td>Take timed 4-choice practice questions.</td><td>Instant score evaluation with detailed Loksewa legal explanations.</td></tr>
</table>

<h2>4. Daily Revision with Spaced Repetition (Flashcards)</h2>
<p>Loksewa preparation requires memorizing hundreds of dates, names, and constitutional articles. The system includes an intelligent memory engine:</p>
<ul>
    <li><strong>Due Today:</strong> Items you studied previously that are due for a quick revision today so you never forget them.</li>
    <li><strong>Upcoming (7 Days):</strong> Items you will review in the coming week.</li>
    <li><strong>Mastered:</strong> Items where you scored 100% confidence, scheduled weeks apart.</li>
</ul>

<h2>5. Tracking Your Study Pace & Completion Date</h2>
<p>On your student dashboard (<code>/dashboard</code>):</p>
<ul>
    <li><strong>Progress Gauge:</strong> Visual percentage of lessons completed in each enrolled course.</li>
    <li><strong>Personalized Pacing Multiplier:</strong> Shows if you are studying faster or more deliberately than standard baseline.</li>
    <li><strong>Projected Finish Date:</strong> Realistic forecast of when you will complete the syllabus based on your current study speed.</li>
</ul>
</body>
</html>
HTML;
    }
}
