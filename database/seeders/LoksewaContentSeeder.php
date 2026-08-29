<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoksewaContentSeeder extends Seeder
{
    public function run(): void
    {
        // Clear old curriculum data for Loksewa courses to avoid duplicates
        $courseIds = [1, 2, 3, 4, 5];
        $modules = Module::whereIn('course_id', $courseIds)->get();
        foreach ($modules as $module) {
            $chapters = Chapter::where('module_id', $module->id)->get();
            foreach ($chapters as $chapter) {
                // Also clear progress for lessons in this chapter
                $lessonIds = Lesson::where('chapter_id', $chapter->id)->pluck('id');
                LessonProgress::whereIn('lesson_id', $lessonIds)->delete();
                Lesson::where('chapter_id', $chapter->id)->delete();
            }
            $module->chapters()->delete();
        }
        Module::whereIn('course_id', $courseIds)->delete();

        // Reset enrollment progress for these courses (new lesson IDs after re-seed)
        Enrollment::whereIn('course_id', $courseIds)->update([
            'progress_percentage' => 0,
            'status' => 'active',
        ]);

        // 1. NAYAB SUBBA TAYARI
        $nayabSubba = Course::find(1);
        if ($nayabSubba) {
            $nayabSubba->update([
                'description' => 'Complete preparation course for Nayab Subba covering General Knowledge (GK), IQ, and General Administration.',
                'level' => 'intermediate',
            ]);

            // Module 1
            $m1 = Module::create([
                'course_id' => $nayabSubba->id,
                'title' => 'First Paper: General Knowledge (GK)',
                'slug' => Str::slug('First Paper: General Knowledge (GK)'),
                'order' => 1,
            ]);

            $chap1 = Chapter::create([
                'module_id' => $m1->id,
                'title' => 'Geography and History of Nepal',
                'slug' => Str::slug('Geography and History of Nepal'),
                'order' => 1,
            ]);

            Lesson::create([
                'chapter_id' => $chap1->id,
                'title' => 'Physical Geography of Nepal',
                'slug' => 'physical-geography-of-nepal',
                'type' => 'text',
                'attachment_path' => 'storage/notes/Sample questions.pdf',
                'content' => '<h3>Physical Divisions of Nepal</h3><p>Nepal is divided into three main ecological regions:</p><ul><li><strong>Himalayan Region:</strong> Covers 15% of the total land area. It lies in the north and ranges from 3,000m to 8,848.86m altitude.</li><li><strong>Hilly Region:</strong> Covers 68% of the total land area. It lies in the middle and contains valleys like Kathmandu and Pokhara.</li><li><strong>Terai Region:</strong> Covers 17% of the total land area. It lies in the south and is the agricultural breadbasket of Nepal.</li></ul><h3>Major Rivers and Water Resources</h3><p>Nepal is highly rich in water resources, divided into three major river systems:</p><ol><li><strong>Koshi River System:</strong> The largest river system in Nepal (eastern part).</li><li><strong>Gandaki River System:</strong> The deepest river system (central part).</li><li><strong>Karnali River System:</strong> The longest river system (western part).</li></ol>',
                'order' => 1,
                'is_published' => true,
            ]);

            Lesson::create([
                'chapter_id' => $chap1->id,
                'title' => 'Official Nayab Subba Syllabus PDF',
                'slug' => 'official-nayab-subba-syllabus-pdf',
                'type' => 'pdf',
                'attachment_path' => 'storage/notes/Sample questions.pdf',
                'content' => 'Download and print the official Loksewa syllabus for Nayab Subba to plan your learning journey.',
                'order' => 2,
                'is_published' => true,
            ]);

            $gkQuiz = [
                [
                    'question' => 'What percentage of Nepal\'s total land area is covered by the Hilly Region?',
                    'options' => ['15%', '68%', '17%', '50%'],
                    'answer' => 1,
                    'explanation' => 'The Hilly Region covers approximately 68% of Nepal\'s total land area, consisting of several valleys, basins, and low mountain ranges.',
                ],
                [
                    'question' => 'Which is the longest river system in Nepal?',
                    'options' => ['Koshi', 'Gandaki', 'Karnali', 'Bagmati'],
                    'answer' => 2,
                    'explanation' => 'The Karnali River is the longest river system in Nepal, flowing from the Himalayas of Tibet down to India.',
                ],
                [
                    'question' => 'What is the exact height of Mount Everest as agreed by Nepal and China in 2020?',
                    'options' => ['8848 meters', '8848.48 meters', '8848.86 meters', '8850 meters'],
                    'answer' => 2,
                    'explanation' => 'The officially recognized and measured height of Mount Everest is 8848.86 meters.',
                ],
            ];

            Lesson::create([
                'chapter_id' => $chap1->id,
                'title' => 'Geography GK Assessment',
                'slug' => 'geography-gk-assessment',
                'type' => 'quiz',
                'content' => json_encode($gkQuiz),
                'order' => 3,
                'is_published' => true,
            ]);

            // Module 2
            $m2 = Module::create([
                'course_id' => $nayabSubba->id,
                'title' => 'First Paper: Intelligence Quotient (IQ)',
                'slug' => Str::slug('First Paper: Intelligence Quotient (IQ)'),
                'order' => 2,
            ]);

            $chap2 = Chapter::create([
                'module_id' => $m2->id,
                'title' => 'Numerical and Verbal Reasoning',
                'slug' => Str::slug('Numerical and Verbal Reasoning'),
                'order' => 1,
            ]);

            Lesson::create([
                'chapter_id' => $chap2->id,
                'title' => 'Verbal Analogy and Series Methods',
                'slug' => 'verbal-analogy-and-series-methods',
                'type' => 'text',
                'content' => '<h3>Understanding Verbal Series</h3><p>Verbal series questions test your ability to recognize logical patterns in letter structures, word formations, and conceptual sequences. Here are the core methods to solve them quickly:</p><ul><li><strong>Letter Spacing:</strong> Check the intervals between letters (e.g., A, C, E, G, ... has an interval of +2).</li><li><strong>Reverse Positions:</strong> Remember the alphabetical ranking from both ends (A=1, Z=26; Z=1, A=26).</li><li><strong>Vowel-Consonant Patterns:</strong> Some series switch strictly based on English vowels (A, E, I, O, U).</li></ul>',
                'order' => 1,
                'is_published' => true,
            ]);

            $iqQuiz = [
                [
                    'question' => 'Find the next term in the series: B, D, F, H, ?',
                    'options' => ['I', 'J', 'K', 'L'],
                    'answer' => 1,
                    'explanation' => 'The series advances by skipping one letter each time (+2 interval). After H, skipping I gives J.',
                ],
                [
                    'question' => 'If LION is coded as MJPO, how is TIGER coded?',
                    'options' => ['UJHFS', 'UKHFS', 'UJGFS', 'UIHFS'],
                    'answer' => 0,
                    'explanation' => 'Each letter in the word is shifted forward by one position (+1). T->U, I->J, G->H, E->F, R->S.',
                ],
            ];

            Lesson::create([
                'chapter_id' => $chap2->id,
                'title' => 'IQ Mini Test',
                'slug' => 'iq-mini-test',
                'type' => 'quiz',
                'content' => json_encode($iqQuiz),
                'order' => 2,
                'is_published' => true,
            ]);
        }

        // 2. NEPAL RASTRA BANK (ASSISTANT DIRECTOR)
        $nrbAd = Course::find(2);
        if ($nrbAd) {
            $nrbAd->update([
                'description' => 'Premium syllabus covering Macroeconomics, Nepalese Financial System, Banking Laws, and Corporate Governance.',
                'level' => 'advanced',
            ]);

            $m1 = Module::create([
                'course_id' => $nrbAd->id,
                'title' => 'Banking Laws & Economics',
                'slug' => Str::slug('Banking Laws & Economics'),
                'order' => 1,
            ]);

            $chap1 = Chapter::create([
                'module_id' => $m1->id,
                'title' => 'Nepal Rastra Bank Act, 2058',
                'slug' => Str::slug('Nepal Rastra Bank Act, 2058'),
                'order' => 1,
            ]);

            Lesson::create([
                'chapter_id' => $chap1->id,
                'title' => 'Objectives and Functions of NRB',
                'slug' => 'objectives-and-functions-of-nrb',
                'type' => 'text',
                'content' => '<h3>Objectives of NRB (Section 4)</h3><p>According to Section 4 of the NRB Act, 2058, the central bank is established with the following primary objectives:</p><ul><li>To formulate and manage necessary monetary and foreign exchange policies to maintain price stability and balance of payment stability.</li><li>To promote stability and healthy growth of banking and financial sectors.</li><li>To develop a secure, healthy, and efficient payment system.</li></ul><h3>Core Functions of NRB</h3><p>NRB acts as the supervisor, regulator, bank of banks, and financial advisor to the Government of Nepal.</p>',
                'order' => 1,
                'is_published' => true,
            ]);

            $lawQuiz = [
                [
                    'question' => 'Under which section of the Nepal Rastra Bank Act, 2058 are the objectives of the Bank defined?',
                    'options' => ['Section 3', 'Section 4', 'Section 5', 'Section 10'],
                    'answer' => 1,
                    'explanation' => 'Section 4 of the Nepal Rastra Bank Act, 2058 explicitly defines the objectives of the central bank.',
                ],
            ];

            Lesson::create([
                'chapter_id' => $chap1->id,
                'title' => 'NRB Act Section 4 Quiz',
                'slug' => 'nrb-act-section-4-quiz',
                'type' => 'quiz',
                'content' => json_encode($lawQuiz),
                'order' => 2,
                'is_published' => true,
            ]);
        }

        // 3. NEPAL RASTRA BANK (OFFICER)
        $nrbO = Course::find(3);
        if ($nrbO) {
            $nrbO->update([
                'description' => 'Comprehensive course for Officer level preparation, highlighting Accounting, Management, IT, and Commercial Banking.',
                'level' => 'advanced',
            ]);

            $m1 = Module::create([
                'course_id' => $nrbO->id,
                'title' => 'Financial Accounting & Banking',
                'slug' => Str::slug('Financial Accounting & Banking'),
                'order' => 1,
            ]);

            $chap1 = Chapter::create([
                'module_id' => $m1->id,
                'title' => 'Banking Accounting Principles',
                'slug' => Str::slug('Banking Accounting Principles'),
                'order' => 1,
            ]);

            Lesson::create([
                'chapter_id' => $chap1->id,
                'title' => 'Double Entry System and Bank Ledgers',
                'slug' => 'double-entry-system-and-bank-ledgers',
                'type' => 'text',
                'content' => '<h3>Double Entry System in Banking</h3><p>Every transaction in a bank involves a debit and a credit of equal amounts. A bank ledger records client deposits as liabilities (since the bank owes that money) and loans advanced as assets (since they generate interest income).</p>',
                'order' => 1,
                'is_published' => true,
            ]);
        }

        // 4. SECTION OFFICER
        $secOff = Course::find(4);
        if ($secOff) {
            $secOff->update([
                'description' => 'Ultimate syllabus preparation guide for Gazetted Third Class Section Officer position in administrative service.',
                'level' => 'advanced',
            ]);

            $m1 = Module::create([
                'course_id' => $secOff->id,
                'title' => 'Second Paper: Governance System',
                'slug' => Str::slug('Second Paper: Governance System'),
                'order' => 1,
            ]);

            $chap1 = Chapter::create([
                'module_id' => $m1->id,
                'title' => 'Concepts of Governance and Administration',
                'slug' => Str::slug('Concepts of Governance and Administration'),
                'order' => 1,
            ]);

            Lesson::create([
                'chapter_id' => $chap1->id,
                'title' => 'New Public Management (NPM) Concepts',
                'slug' => 'new-public-management-npm-concepts',
                'type' => 'text',
                'content' => '<h3>New Public Management (NPM)</h3><p>New Public Management is an approach to running public service organizations that is used in government and public sector institutions. It emphasizes market orientation, efficiency, customer focus, and decentralization of authority.</p>',
                'order' => 1,
                'is_published' => true,
            ]);
        }

        // 5. KHARIDAR
        $kharidar = Course::find(5);
        if ($kharidar) {
            $kharidar->update([
                'description' => 'Complete preparation course for Kharidar level focusing on general knowledge, office procedures, and job knowledge.',
                'level' => 'beginner',
            ]);

            $m1 = Module::create([
                'course_id' => $kharidar->id,
                'title' => 'Office Management and Work Procedures',
                'slug' => Str::slug('Office Management and Work Procedures'),
                'order' => 1,
            ]);

            $chap1 = Chapter::create([
                'module_id' => $m1->id,
                'title' => 'Filing Systems and Record Management',
                'slug' => Str::slug('Filing Systems and Record Management'),
                'order' => 1,
            ]);

            Lesson::create([
                'chapter_id' => $chap1->id,
                'title' => 'Office Filing Techniques',
                'slug' => 'office-filing-techniques',
                'type' => 'text',
                'content' => '<h3>What is Filing?</h3><p>Filing is the process of arranging and storing records in a systematic, orderly manner so they can be easily retrieved when needed. In Nepalese government offices, filing ensures transparency, audit compliance, and memory retention of administrative actions.</p>',
                'order' => 1,
                'is_published' => true,
            ]);
        }

        // Seed Course Prerequisites for Graph Traversal Visualizer
        DB::table('course_prerequisites')->truncate();

        $kharidar = Course::find(5);
        $subba = Course::find(1);
        $officer = Course::find(4);
        $nrbOfficer = Course::find(3);
        $nrbAd = Course::find(2);

        if ($subba && $kharidar) {
            $subba->prerequisites()->attach($kharidar->id);
        }
        if ($officer && $subba) {
            $officer->prerequisites()->attach($subba->id);
        }
        if ($nrbOfficer && $kharidar) {
            $nrbOfficer->prerequisites()->attach($kharidar->id);
        }
        if ($nrbAd && $officer) {
            $nrbAd->prerequisites()->attach($officer->id);
        }
        if ($nrbAd && $nrbOfficer) {
            $nrbAd->prerequisites()->attach($nrbOfficer->id);
        }

        $this->call(LessonMcqSeeder::class);
    }
}
