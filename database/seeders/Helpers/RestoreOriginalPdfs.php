<?php

namespace Database\Seeders\Helpers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RestoreOriginalPdfs
{
    public static function restore(): void
    {
        self::syncModuleIds();
        self::restoreCourseSyllabi();
        self::restoreLessonPdfsAndQuizzes();
        self::restoreModulePdfsAndQuizzes();

        // Generate clean white-background PDFs for any remaining lessons without PDFs
        app(\App\Services\LessonPdfGeneratorService::class)->generateMissingLessonPdfs();
    }

    /**
     * Ensure all lessons have module_id populated so they appear correctly in Filament Admin.
     */
    public static function syncModuleIds(): void
    {
        $unlinked = Lesson::whereNull('module_id')->whereNotNull('chapter_id')->get();
        foreach ($unlinked as $lesson) {
            $chapter = \App\Models\Chapter::find($lesson->chapter_id);
            if ($chapter && $chapter->module_id) {
                $lesson->update(['module_id' => $chapter->module_id]);
            }
        }
    }

    /**
     * Restore master syllabus PDFs for all courses.
     */
    public static function restoreCourseSyllabi(): void
    {
        $courses = [
            'kharidar-tayari' => 'courses/syllabus/Kharidar Syllabus.pdf',
            'nayab-subba-tayari' => 'courses/syllabus/Nayab Subba Syllabus.pdf',
            'section-officer-tayari' => 'courses/syllabus/01M1GVG10VDPVBNQMDA2YDK6RB.pdf',
            'section-officer' => 'courses/syllabus/01M1GVG10VDPVBNQMDA2YDK6RB.pdf',
            'nea-level-4' => 'courses/syllabus/01M1HEVVM34CWG7B9196YE1MXV.pdf',
            'nepal-telecom-tayari' => 'courses/syllabus/01M1HEVVM34CWG7B9196YE1MXV.pdf',
            'nrb-officer-tayari' => 'courses/syllabus/01M1GVG10VDPVBNQMDA2YDK6RB.pdf',
            'nrb-assistant-director-tayari' => 'courses/syllabus/01M1GVG10VDPVBNQMDA2YDK6RB.pdf',
            'computer-sip-pariksha' => 'courses/syllabus/Kharidar Syllabus.pdf',
        ];

        foreach ($courses as $slug => $syllabusPath) {
            Course::where('slug', $slug)->update(['syllabus_pdf' => $syllabusPath]);
        }

        // For any remaining course without syllabus_pdf
        Course::whereNull('syllabus_pdf')->orWhere('syllabus_pdf', '')->update([
            'syllabus_pdf' => 'courses/syllabus/Kharidar Syllabus.pdf',
        ]);
    }

    /**
     * Restore all lesson PDFs and comprehensive quizzes.
     */
    public static function restoreLessonPdfsAndQuizzes(): void
    {
        // 1. Gather all existing physical PDF files in lessons/pdfs
        $pdfDir = public_path('storage/lessons/pdfs');
        $availablePdfs = [];
        if (File::isDirectory($pdfDir)) {
            $files = File::files($pdfDir);
            foreach ($files as $file) {
                $availablePdfs[] = $file->getFilename();
            }
        }

        // Specific high-priority exact mappings
        $specificPdfs = [
            // Section Officer
            '1.1' => 'lessons/pdfs/01M1HHSDW36QY0A93YZ2RTZ3YA.pdf',
            '1.2' => 'lessons/pdfs/01M1HHXNTWRQ8Z6GCMPF4ZTD3R.pdf',
            '1.3' => 'lessons/pdfs/01M1HJ1DZQPV8BC899JXXX2HA7.pdf',
            '1.4' => 'lessons/pdfs/01M1HJ5W9WJEV4BMR8S5ADP2C2.pdf',
            '1.5' => 'lessons/pdfs/01M1HJCQNFGVWDFVR975YM5A9S.pdf',
            '1.6' => 'lessons/pdfs/01M1HJHFPZHRY7HFHTW9C35VGD.pdf',

            // Nayab Subba & Kharidar core
            'Universe' => 'lessons/pdfs/General-Information-about-Universe-Loksewa-PDF_compressed.pdf',
            'Geography of World' => 'lessons/pdfs/01M1GG34XZX29EA3AWDWHPPXXE.pdf',
            'Geography of Nepal' => 'lessons/pdfs/Geography of Nepal_compressed.pdf',
            'History of World' => 'lessons/pdfs/History-of-World-GK-PDF-Notes_compressed.pdf',
            'History of Nepal' => 'lessons/pdfs/HIstory of Nepal.pdf',
            'Verbal Reasoning' => 'lessons/pdfs/01M1GH7TVYCSV16WJZXKJTD51J.pdf',
            'Quantitative Reasoning' => 'lessons/pdfs/01M1GHP33S7KX41B7EZ2GN1DMK.pdf',
            'Non-Verbal Reasoning' => 'lessons/pdfs/01M1GJFVGNG2WF9T9B19TCKXZ6.pdf',
            'Geographical, Social and Economic Condition of Nepal' => 'lessons/pdfs/01M1GMJMQ1AWNHVAB1YV3CAFMP.pdf',
            'Constitutional System and Government' => 'lessons/pdfs/01M1GMT5P2XRGBP1F95RDKG8PW.pdf',
            'Public Service Operation and Management' => 'lessons/pdfs/01M1GPTVP61VZ6FM93Q03XHXAR.pdf',
            'Office Operations and Organizational Behavior' => 'lessons/pdfs/01M1GNH4V3AJKZ0HN777K0B6R6.pdf',
            'Administration and Management' => 'lessons/pdfs/01M1GPWTF70K20Z6NV8X5THE03.pdf',
            'Legal Provisions Related to Public Service Management' => 'lessons/pdfs/01M1GQ09MQKDDETESQ6XS9MJXW.pdf',
            'Analogy' => 'lessons/pdfs/Analogy Kharidar.pdf',
            'Classification' => 'lessons/pdfs/Classification Kharidar.pdf',
            'Number Series' => 'lessons/pdfs/Number Series Kharidar.pdf',
            'Letter Series' => 'lessons/pdfs/Letter Series Kharidar.pdf',
            'Coding' => 'lessons/pdfs/Coding Decoding Kharidar.pdf',
            'Office Management' => 'lessons/pdfs/Office Management Kharidar.pdf',
        ];

        $lessons = Lesson::with('module.course')->get();

        foreach ($lessons as $lesson) {
            $courseSlug = $lesson->course?->slug ?? '';
            $lessonTitle = $lesson->title;
            $lessonSlug = $lesson->slug;

            // ─── A. RESTORE ATTACHMENT PDF ───
            $matchedPdf = null;

            // 1. Check specific mapping
            foreach ($specificPdfs as $keyword => $pdfPath) {
                if (stripos($lessonTitle, $keyword) !== false || stripos($lessonSlug, $keyword) !== false) {
                    $matchedPdf = $pdfPath;
                    break;
                }
            }

            // 2. Check course-prefixed PDF matches in availablePdfs
            if (! $matchedPdf && $courseSlug) {
                $cleanCoursePrefix = Str::slug($courseSlug);
                $cleanLessonSlug = Str::slug($lessonSlug);

                foreach ($availablePdfs as $pdfName) {
                    $lowerPdf = strtolower($pdfName);
                    if (str_starts_with($lowerPdf, $cleanCoursePrefix) && (
                        str_contains($lowerPdf, $cleanLessonSlug) ||
                        str_contains($lowerPdf, Str::slug(substr($lessonTitle, 0, 20)))
                    )) {
                        $matchedPdf = 'lessons/pdfs/'.$pdfName;
                        break;
                    }
                }
            }

            // 3. Check general keywords in availablePdfs
            if (! $matchedPdf) {
                $words = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9 ]/', '', $lessonTitle)));
                $words = array_filter($words, fn ($w) => strlen($w) > 4);

                foreach ($availablePdfs as $pdfName) {
                    $lowerPdf = strtolower($pdfName);
                    foreach ($words as $word) {
                        if (str_contains($lowerPdf, $word)) {
                            $matchedPdf = 'lessons/pdfs/'.$pdfName;
                            break 2;
                        }
                    }
                }
            }

            // 4. Default fallback if still missing: generate or assign notes PDF
            if (! $matchedPdf) {
                if (str_contains($courseSlug, 'kharidar')) {
                    $matchedPdf = 'notes/loksewa/kharidar-gk-notes.pdf';
                } elseif (str_contains($courseSlug, 'subba')) {
                    $matchedPdf = 'notes/loksewa/nayab-subba-gk-notes.pdf';
                } elseif (str_contains($courseSlug, 'officer')) {
                    $matchedPdf = 'notes/loksewa/constitution-2072-notes.pdf';
                } elseif (str_contains($courseSlug, 'nea')) {
                    $matchedPdf = 'lessons/pdfs/Geography of Nepal_compressed.pdf';
                } else {
                    $matchedPdf = 'notes/loksewa/good-governance-act-notes.pdf';
                }
            }

            $lesson->attachment_path = $matchedPdf;

            // ─── B. RESTORE QUIZZES ───
            $questions = is_array($lesson->quiz_questions) ? $lesson->quiz_questions : [];

            // If empty or less than 5 questions, restore from authentic quiz banks
            if (count($questions) < 5) {
                if (str_contains($courseSlug, 'nea')) {
                    $questions = NeaQuizBank::getQuestionsForLesson($lessonTitle);
                } elseif (str_contains($courseSlug, 'officer')) {
                    $questions = SectionOfficerQuizBank::getQuestionsForLesson($lessonTitle);
                } else {
                    $questions = self::generateAuthenticQuestions($lessonTitle, $courseSlug);
                }
            }

            $lesson->quiz_questions = $questions;
            if ($lesson->type === 'quiz' || empty($lesson->content)) {
                $lesson->content = json_encode($questions, JSON_UNESCAPED_UNICODE);
            }

            $lesson->save();
        }
    }

    /**
     * Restore module PDFs and module quizzes.
     */
    public static function restoreModulePdfsAndQuizzes(): void
    {
        $modules = Module::with(['course', 'lessons'])->get();

        foreach ($modules as $module) {
            // Set module pdf_file from primary lesson attachment if empty
            if (empty($module->pdf_file)) {
                $primaryLesson = $module->lessons()->whereNotNull('attachment_path')->where('attachment_path', '!=', '')->first();
                if ($primaryLesson) {
                    $module->pdf_file = $primaryLesson->attachment_path;
                } else {
                    $module->pdf_file = $module->course?->syllabus_pdf ?? 'courses/syllabus/Kharidar Syllabus.pdf';
                }
            }

            // Aggregate lesson quiz questions into module quiz questions if empty
            if (empty($module->quiz_questions) || (is_array($module->quiz_questions) && count($module->quiz_questions) < 5)) {
                $aggregatedQuestions = [];
                foreach ($module->lessons as $lesson) {
                    if (is_array($lesson->quiz_questions)) {
                        foreach ($lesson->quiz_questions as $q) {
                            $aggregatedQuestions[] = $q;
                            if (count($aggregatedQuestions) >= 15) {
                                break 2;
                            }
                        }
                    }
                }

                if (empty($aggregatedQuestions)) {
                    $aggregatedQuestions = self::generateAuthenticQuestions($module->title, $module->course?->slug ?? '');
                }

                $module->quiz_questions = $aggregatedQuestions;
            }

            $module->save();
        }
    }

    /**
     * Generate 10 rich, authentic Loksewa MCQs for any lesson topic.
     */
    private static function generateAuthenticQuestions(string $topic, string $courseSlug): array
    {
        return [
            [
                'question' => "According to the Public Service Commission (Lok Sewa Aayog) curriculum for {$topic}, which principle is fundamental to administrative efficiency in Nepal?",
                'options' => [
                    'Adherence to rule of law, transparency, and timely citizen service delivery',
                    'Discretionary authority without audit oversight or judicial review',
                    'Frequent unplanned bureaucratic structural realignments',
                    'Centralized decision-making omitting subordinate consultation',
                ],
                'answer' => 0,
                'explanation' => "The Good Governance (Management & Operation) Act 2064 mandates rule of law, accountability, citizen charters, and public grievance redressal for {$topic}.",
                'hint' => 'Focus on statutory good governance principles.',
            ],
            [
                'question' => "In the context of {$topic}, what is the statutory timeline stipulated under the Right to Information (RTI) Act 2064 for providing requested public information?",
                'options' => [
                    'Within 15 days of receiving the application (24 hours for life/liberty)',
                    'Within 45 days upon approval from the appellate secretary',
                    'Within 60 working days excluding national public holidays',
                    'Indefinite based on departmental convenience and workload',
                ],
                'answer' => 0,
                'explanation' => 'Section 7 of the RTI Act 2064 requires the Information Officer to provide information within 15 days, or within 24 hours if related to human life and personal liberty.',
                'hint' => 'Standard statutory period for information officers in Nepal.',
            ],
            [
                'question' => "Which constitutional organ in Nepal is empowered to investigate corruption and abuse of public authority regarding {$topic}?",
                'options' => [
                    'Commission for the Investigation of Abuse of Authority (CIAA)',
                    'National Natural Resources and Fiscal Commission (NNRFC)',
                    'Judicial Council of Nepal (Nyaya Parishad)',
                    'National Planning Commission (Rashtriya Yojana Aayog)',
                ],
                'answer' => 0,
                'explanation' => 'Part 21, Article 239 of the Constitution of Nepal 2072 designates the CIAA to investigate corruption and improper conduct by public officials.',
                'hint' => 'Part 21 constitutional anti-graft body.',
            ],
            [
                'question' => 'Under the Constitution of Nepal, what tier of government holds residual powers (अवशिष्ट अधिकार) not listed in the exclusive or concurrent schedules?',
                'options' => [
                    'Federal Level (संघीय सरकार)',
                    'Provincial Level (प्रदेश सरकार)',
                    'Local Level (स्थानीय तह)',
                    'District Coordination Committee (जिल्ला समन्वय समिति)',
                ],
                'answer' => 0,
                'explanation' => 'Article 58 specifies that residual powers not mentioned in Schedules 5, 6, 7, 8, or 9 belong exclusively to the Federation.',
                'hint' => 'Article 58 constitutional jurisdiction.',
            ],
            [
                'question' => 'In Nepali public financial management, what document serves as the primary instrument for recording all official revenues and expenditures?',
                'options' => [
                    'Government Accounting System (New Accounting System - लेखा प्रणाली)',
                    'Memorandum of Association and Articles of Incorporation',
                    'Ad-hoc Petty Voucher Register without treasury single account',
                    'Private Ledger without Comptroller General approval',
                ],
                'answer' => 0,
                'explanation' => 'Financial Procedures and Fiscal Responsibility Act 2076 mandates standardized treasury single account (TSA) double-entry bookkeeping.',
                'hint' => 'Standardized TSA public accounting framework.',
            ],
            [
                'question' => 'Which of the following is an essential element of official correspondence (सरकारी पत्राचार) in Nepali administration?',
                'options' => [
                    'Darta number, Chalani number, official seal, date in BS, and designated signatory',
                    'Informal handwriting without file number or department code',
                    'Verbal instruction without written documentation in the registry',
                    'Unstamped letter without authorized dispatch registration',
                ],
                'answer' => 0,
                'explanation' => 'Official government letters require formal Chalani dispatch numbering, subject classification, official seals, and proper administrative hierarchy.',
                'hint' => 'Formal Darta-Chalani and office management rules.',
            ],
            [
                'question' => "What is the primary objective of periodic national development plans (आवधिक योजना) in Nepal concerning {$topic}?",
                'options' => [
                    'Achieving sustainable economic growth, poverty alleviation, and social justice',
                    'Increasing unilateral foreign commercial debt dependencies',
                    'Restricting provincial and local capital infrastructure allocations',
                    'Eliminating performance-based monitoring indicators',
                ],
                'answer' => 0,
                'explanation' => 'Periodic national plans set macroscopic GDP targets, SDGs alignment, infrastructure prioritization, and human development indices.',
                'hint' => 'National Planning Commission developmental vision.',
            ],
            [
                'question' => 'What is the official minimum passing score requirement for Loksewa preliminary objective screenings in Nepal?',
                'options' => [
                    '40% of total aggregate marks',
                    '50% with negative marking of 50%',
                    '32% with no negative marking',
                    '60% of total aggregate marks',
                ],
                'answer' => 0,
                'explanation' => 'Public Service Commission exam rules set 40% as the minimum qualifying score with 20% negative deduction for incorrect objective answers.',
                'hint' => 'Standard PSC pass threshold.',
            ],
            [
                'question' => 'Under the Civil Service Act and Rules, what is the standard probationary period (परीक्षण काल) for newly appointed male and female civil servants?',
                'options' => [
                    '6 months for females, 1 year for males',
                    '1 year for females, 2 years for males',
                    '2 years for both males and females',
                    'No probationary period required',
                ],
                'answer' => 0,
                'explanation' => 'Section 16 of the Civil Service Act 2049 stipulates 6 months probation for female officers and 1 year for male officers.',
                'hint' => 'Section 16 affirmative action probation rule.',
            ],
            [
                'question' => "In Loksewa examination strategy for {$topic}, how are negative marks deducted for each wrong answer in multiple-choice questions?",
                'options' => [
                    '20% (0.20 marks per 1 mark question) is deducted for each incorrect answer',
                    '50% (0.50 marks per 1 mark question) is deducted',
                    'No negative marking is applied in preliminary screening',
                    'Full 1 mark is deducted for each incorrect attempt',
                ],
                'answer' => 0,
                'explanation' => 'Loksewa standard multiple choice exams deduct 20% of the question weight for each incorrect option selected.',
                'hint' => 'PSC 20% penalty rule for negative marking.',
            ],
        ];
    }
}
