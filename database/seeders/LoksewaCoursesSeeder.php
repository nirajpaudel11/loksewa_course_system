<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Database\Seeders\Helpers\PdfGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoksewaCoursesSeeder extends Seeder
{
    private string $pdfBasePath;

    public function run(): void
    {
        $this->pdfBasePath = public_path('storage/notes/loksewa');

        $this->command->info('📚 Seeding 8 Loksewa Courses...');

        $courses = $this->createCourses();
        $this->seedPrerequisites($courses);
        $this->generatePdfs();

        $totalModules = Module::count();
        $totalChapters = Chapter::count();
        $totalLessons = Lesson::count();

        $this->command->info("   ✅ {$totalModules} modules, {$totalChapters} chapters, {$totalLessons} lessons created");
    }

    private function createCourses(): array
    {
        $courses = [];

        // ─── 1. KHARIDAR ──────────────────────────────────
        $courses['kharidar'] = $this->createCourseWithContent(
            title: 'Kharidar Tayari',
            slug: 'kharidar-tayari',
            description: 'Complete preparation course for Kharidar (Non-Gazetted Second Class) position under Nepal Public Service Commission. Covers General Knowledge, IQ & Aptitude, Office Management, and Job Knowledge with objective and subjective exam preparation.',
            level: 'beginner',
            modules: $this->getKharidarModules(),
        );

        // ─── 2. NAYAB SUBBA ──────────────────────────────
        $courses['nayab_subba'] = $this->createCourseWithContent(
            title: 'Nayab Subba Tayari',
            slug: 'nayab-subba-tayari',
            description: 'Comprehensive Nayab Subba (Non-Gazetted First Class) preparation covering General Knowledge, Intelligence Quotient, General Administration, and Accounting. Designed for the integrated examination system of Lok Sewa Aayog.',
            level: 'intermediate',
            modules: $this->getNayabSubbaModules(),
        );

        // ─── 3. SECTION OFFICER ──────────────────────────
        $courses['section_officer'] = $this->createCourseWithContent(
            title: 'Section Officer Tayari',
            slug: 'section-officer-tayari',
            description: 'Advanced preparation for Section Officer (Gazetted Third Class) covering Governance Systems, Contemporary Issues, Administrative Law, and Public Service Delivery. Includes AAT screening test preparation with GK, IQ, and English sections.',
            level: 'advanced',
            modules: $this->getSectionOfficerModules(),
        );

        // ─── 4. NRB OFFICER ─────────────────────────────
        $courses['nrb_officer'] = $this->createCourseWithContent(
            title: 'NRB Officer Tayari',
            slug: 'nrb-officer-tayari',
            description: 'Nepal Rastra Bank Officer (Third Class) exam preparation covering Macroeconomics, Microeconomics, Nepalese Banking System, Financial Accounting, and Banking Operations. Focus on monetary policy, fiscal policy, and central banking functions.',
            level: 'advanced',
            modules: $this->getNrbOfficerModules(),
        );

        // ─── 5. NRB ASSISTANT DIRECTOR ───────────────────
        $courses['nrb_ad'] = $this->createCourseWithContent(
            title: 'NRB Assistant Director Tayari',
            slug: 'nrb-assistant-director-tayari',
            description: 'Premium preparation course for NRB Assistant Director position covering Banking Law & Regulations, Monetary Policy Tools, Corporate Governance, Capital Adequacy, Foreign Exchange Regulation, and advanced macroeconomic analysis.',
            level: 'advanced',
            modules: $this->getNrbAdModules(),
        );

        // ─── 6. CONSTITUTION & LAW ──────────────────────
        $courses['constitution'] = $this->createCourseWithContent(
            title: 'Nepal Constitution ra Kanun',
            slug: 'nepal-constitution-ra-kanun',
            description: 'Cross-cutting course covering the Constitution of Nepal 2072, Good Governance Act 2064, Right to Information Act, Civil Service Act, and administrative law. Essential for all Loksewa exam positions from Kharidar to Section Officer.',
            level: 'intermediate',
            modules: $this->getConstitutionModules(),
        );

        // ─── 7. COMPUTER SKILL TEST ─────────────────────
        $courses['computer'] = $this->createCourseWithContent(
            title: 'Computer Sip Pariksha',
            slug: 'computer-sip-pariksha',
            description: 'Practical computer skill test preparation covering MS Word, MS Excel, MS PowerPoint, Email & Internet usage, Nepali Unicode typing, and data entry. Required for all Loksewa positions as part of the final examination stage.',
            level: 'beginner',
            modules: $this->getComputerModules(),
        );

        // ─── 8. IQ & APTITUDE ───────────────────────────
        $courses['iq'] = $this->createCourseWithContent(
            title: 'Baudhik Parikshan (IQ & Aptitude)',
            slug: 'baudhik-parikshan-iq-aptitude',
            description: 'Comprehensive IQ and aptitude test preparation covering Verbal Reasoning, Numerical Reasoning, Logical Reasoning, Coding-Decoding, Blood Relations, Direction Sense, and Venn Diagrams. Foundation course for all Loksewa objective examinations.',
            level: 'beginner',
            modules: $this->getIqModules(),
        );

        return $courses;
    }

    private function createCourseWithContent(string $title, string $slug, string $description, string $level, array $modules): Course
    {
        $defaultThumbnails = [
            'kharidar-tayari' => 'course-thumbnails/01M18FVD47T77TN568HT702AJ5.jpg',
            'nayab-subba-tayari' => 'course-thumbnails/01M18FY1HJGT73TVVDGKSMK6VQ.jpg',
            'section-officer-tayari' => 'course-thumbnails/01M18FZRMP2H3N5T3CX61JRD9S.jpg',
            'nrb-officer-tayari' => 'course-thumbnails/01M18G0T0GSTDYC58G8FKZ120P.jpg',
            'nrb-assistant-director-tayari' => 'course-thumbnails/01M18G1RY0J106PPD2KX2B0BF5.jpg',
            'nepal-constitution-ra-kanun' => 'course-thumbnails/nepal-constitution.jpg',
            'computer-sip-pariksha' => 'course-thumbnails/01M18G9505CSZHDENPZ0SNJNWA.jpeg',
            'baudhik-parikshan-iq-aptitude' => 'course-thumbnails/iq-aptitude.jpg',
            'nea-level-4' => 'course-thumbnails/01M1HF09AQXHBQ6XGJQDRS2TE6.jpg',
        ];

        $course = Course::create([
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'level' => $level,
            'thumbnail' => $defaultThumbnails[$slug] ?? null,
            'is_published' => true,
        ]);

        foreach ($modules as $mIdx => $moduleData) {
            $module = Module::create([
                'course_id' => $course->id,
                'title' => $moduleData['title'],
                'slug' => Str::slug($moduleData['title']).'-'.$course->id,
                'description' => $moduleData['description'] ?? null,
                'order' => $mIdx + 1,
                'is_published' => true,
            ]);

            foreach ($moduleData['chapters'] as $cIdx => $chapterData) {
                $chapter = Chapter::create([
                    'module_id' => $module->id,
                    'title' => $chapterData['title'],
                    'slug' => Str::slug($chapterData['title']).'-'.$module->id,
                    'description' => $chapterData['description'] ?? null,
                    'order' => $cIdx + 1,
                    'is_published' => true,
                ]);

                foreach ($chapterData['lessons'] as $lIdx => $lessonData) {
                    Lesson::create([
                        'chapter_id' => $chapter->id,
                        'title' => $lessonData['title'],
                        'slug' => Str::slug($lessonData['title']).'-'.$chapter->id,
                        'type' => $lessonData['type'],
                        'content' => $lessonData['content'] ?? null,
                        'attachment_path' => $lessonData['attachment_path'] ?? null,
                        'video_url' => $lessonData['video_url'] ?? null,
                        'order' => $lIdx + 1,
                        'duration_minutes' => $lessonData['duration_minutes'] ?? 15,
                        'is_published' => true,
                    ]);
                }
            }
        }

        return $course;
    }

    // ═══════════════════════════════════════════════════════════════
    // KHARIDAR MODULES
    // ═══════════════════════════════════════════════════════════════
    private function getKharidarModules(): array
    {
        return [
            [
                'title' => 'Samanya Gyan (General Knowledge)',
                'description' => 'First Paper: Objective GK section covering Nepal geography, history, science, and current affairs.',
                'chapters' => [
                    [
                        'title' => 'Nepal ko Bhugol ra Itihas',
                        'lessons' => [
                            ['title' => 'Physical Geography of Nepal', 'type' => 'text', 'content' => '<h3>Physical Divisions of Nepal</h3><p>Nepal is divided into three main ecological regions based on altitude and terrain:</p><ul><li><strong>Himalayan Region (Himal):</strong> Covers approximately 15% of total land area, lies above 4,877m altitude. Contains 8 of the world\'s 14 peaks above 8,000m including Mount Everest (Sagarmatha, 8,848.86m). Key features: permanent snow, glaciers, high-altitude lakes (Tilicho, Rara). Sparse human settlement. Districts include Solukhumbu, Dolpa, Humla, Mustang.</li><li><strong>Hilly Region (Pahad):</strong> Covers approximately 68% of total land area. Altitude ranges from 610m to 4,877m. Contains the Mahabharat range, Chure hills, and fertile inter-mountain valleys like Kathmandu Valley, Pokhara Valley, and Dang Valley. Most populated region with major urban centers.</li><li><strong>Terai Region (Madhesh):</strong> Covers approximately 17% of total land area. Flat alluvial plains along the southern border with India. Known as the granary of Nepal — produces majority of rice, wheat, sugarcane. Major cities: Biratnagar, Birgunj, Janakpur, Nepalgunj, Dhangadhi.</li></ul><h3>Major Rivers</h3><p>Nepal has three major river systems, all tributaries of the Ganges:</p><ol><li><strong>Koshi River System:</strong> Largest by volume. Seven tributaries (Saptakoshi). Origin in Tibet and eastern Nepal Himalayas.</li><li><strong>Gandaki River System:</strong> Contains the Kaligandaki — one of the deepest gorges in the world. Seven tributaries including Trishuli, Marsyangdi, Seti.</li><li><strong>Karnali River System:</strong> Longest river in Nepal (507km). Originates near Lake Mansarovar in Tibet. Western Nepal\'s lifeline.</li></ol>'],
                            ['title' => 'History of Modern Nepal', 'type' => 'text', 'content' => '<h3>Unification of Nepal</h3><p>King Prithvi Narayan Shah of Gorkha unified scattered kingdoms into modern Nepal between 1743-1775 AD. Key conquests included Nuwakot (1744), Kirtipur (1766), and Kathmandu Valley (1768-69).</p><h3>Shah Dynasty and Rana Rule</h3><p>After the Shah dynasty established rule, Jung Bahadur Rana seized power in the Kot Massacre of 1846, beginning 104 years of Rana autocracy (1846-1951). The Rana regime was hereditary, with the post of Prime Minister passing within the Rana family.</p><h3>Democratic Movements</h3><ul><li><strong>1951 Revolution:</strong> King Tribhuvan, with support from the Nepali Congress and India, overthrew Rana rule. Multi-party democracy introduced.</li><li><strong>1960 Royal Coup:</strong> King Mahendra dissolved parliament and introduced the Panchayat system — a partyless system of governance lasting 30 years.</li><li><strong>1990 Jana Andolan I:</strong> People\'s movement restored multi-party democracy. Constitution of Nepal 1990 promulgated.</li><li><strong>2006 Jana Andolan II:</strong> 19-day movement ended the royal autocracy of King Gyanendra. Led to Comprehensive Peace Accord, Constituent Assembly, and the abolition of monarchy in 2008.</li><li><strong>2015 Constitution:</strong> Constitution of Nepal 2072 BS promulgated — establishing Nepal as a federal democratic republic with 7 provinces.</li></ul>'],
                            ['title' => 'Geography & History Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'What percentage of Nepal\'s total land area is covered by the Hilly Region?', 'options' => ['15%', '68%', '17%', '50%'], 'answer' => 1, 'explanation' => 'The Hilly Region covers approximately 68% of Nepal\'s total land area.'],
                                ['question' => 'Which is the longest river system in Nepal?', 'options' => ['Koshi', 'Gandaki', 'Karnali', 'Bagmati'], 'answer' => 2, 'explanation' => 'Karnali is the longest river in Nepal at approximately 507km.'],
                                ['question' => 'In which year was the Rana regime overthrown?', 'options' => ['1946', '1951', '1960', '1990'], 'answer' => 1, 'explanation' => 'The 1951 revolution ended 104 years of Rana autocracy.'],
                                ['question' => 'Who unified the scattered kingdoms into modern Nepal?', 'options' => ['Jung Bahadur Rana', 'King Tribhuvan', 'King Prithvi Narayan Shah', 'King Mahendra'], 'answer' => 2, 'explanation' => 'King Prithvi Narayan Shah of Gorkha unified Nepal between 1743-1775 AD.'],
                                ['question' => 'What is the exact height of Mount Everest?', 'options' => ['8,848.00 m', '8,848.86 m', '8,850.00 m', '8,586.00 m'], 'answer' => 1, 'explanation' => 'Nepal and China jointly announced 8,848.86 meters in 2020.'],
                            ])],
                        ],
                    ],
                    [
                        'title' => 'Bigyan ra Prabidhi (Science & Technology)',
                        'lessons' => [
                            ['title' => 'Basic Science for Kharidar', 'type' => 'text', 'content' => '<h3>Physics Fundamentals</h3><p>Key concepts frequently tested in Loksewa exams:</p><ul><li><strong>Newton\'s Laws of Motion:</strong> First law (inertia), Second law (F=ma), Third law (action-reaction)</li><li><strong>Energy:</strong> Kinetic energy, Potential energy, Conservation of energy. Nepal\'s hydropower potential of 83,000 MW (economically feasible: 42,000 MW)</li><li><strong>Light:</strong> Reflection, refraction, dispersion, total internal reflection</li></ul><h3>Biology Basics</h3><ul><li>Cell structure: Nucleus, mitochondria, chloroplast, cell membrane</li><li>Blood groups: A, B, AB, O and Rh factor</li><li>Vitamins and deficiency diseases: A (night blindness), B1 (beriberi), C (scurvy), D (rickets)</li></ul><h3>Nepal\'s IT Development</h3><ul><li>NTC established 1913 BS for telecommunications</li><li>Internet introduced to Nepal in 1994</li><li>E-governance initiatives: Nagarik App, MeroKitta, online tax filing</li></ul>'],
                            ['title' => 'Science Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'What is Nepal\'s total hydropower potential?', 'options' => ['42,000 MW', '83,000 MW', '50,000 MW', '100,000 MW'], 'answer' => 1, 'explanation' => 'Nepal has a total hydropower potential of approximately 83,000 MW.'],
                                ['question' => 'Deficiency of Vitamin C causes which disease?', 'options' => ['Beriberi', 'Rickets', 'Scurvy', 'Night Blindness'], 'answer' => 2, 'explanation' => 'Vitamin C deficiency causes Scurvy.'],
                                ['question' => 'When was internet introduced to Nepal?', 'options' => ['1990', '1994', '2000', '1985'], 'answer' => 1, 'explanation' => 'Internet was first introduced to Nepal in 1994.'],
                            ])],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Karyalaya Byawasthapan (Office Management)',
                'description' => 'Second Paper: Office procedures, filing, record management, and correspondence.',
                'chapters' => [
                    [
                        'title' => 'Karyalaya Byawastha ra Karyabidhi',
                        'lessons' => [
                            ['title' => 'Office Filing and Record Management', 'type' => 'text', 'content' => '<h3>Filing System in Government Offices</h3><p>Filing is the systematic arrangement and storage of official documents for easy retrieval. Under the Good Governance Act 2064, every government office must maintain proper filing systems.</p><h3>Types of Filing</h3><ul><li><strong>Alphabetical Filing:</strong> Files arranged by name or subject alphabetically</li><li><strong>Numerical Filing:</strong> Files assigned numbers and arranged sequentially</li><li><strong>Chronological Filing:</strong> Files arranged by date of receipt or creation</li><li><strong>Subject Filing:</strong> Files grouped by topic or department (most common in Nepal government)</li></ul><h3>Registration and Dispatch</h3><p>Chalani (dispatch) and Darta (registration) are the backbone of Nepali government office administration:</p><ul><li><strong>Darta:</strong> Registration of incoming letters/documents with date, sender, subject, and action taken</li><li><strong>Chalani:</strong> Dispatch register for outgoing correspondence with reference number, date, and recipient</li></ul>'],
                            ['title' => 'Letter Writing and Correspondence', 'type' => 'text', 'content' => '<h3>Official Letter Format (Sarkari Patra)</h3><p>Government letters follow a standard format as prescribed by the Good Governance Act:</p><ol><li><strong>Header:</strong> Office name, address, reference number</li><li><strong>Date:</strong> Written in Bikram Sambat (BS) calendar format</li><li><strong>Subject Line (Bishaya):</strong> Brief summary of letter content</li><li><strong>Salutation:</strong> Appropriate greeting based on recipient rank</li><li><strong>Body (Byahora):</strong> Main content in formal Nepali</li><li><strong>Closing:</strong> Signature, name, designation, and office seal</li></ol><h3>Types of Government Letters</h3><ul><li>Patrachar (General correspondence)</li><li>Pratibedan (Report)</li><li>Tippani (Office note/memo)</li><li>Pragati Pratibedan (Progress report)</li></ul>'],
                            ['title' => 'Kharidar Syllabus PDF', 'type' => 'pdf', 'content' => 'Official Lok Sewa Aayog Kharidar syllabus and exam pattern overview.', 'attachment_path' => 'storage/notes/loksewa/kharidar-gk-notes.pdf'],
                            ['title' => 'Office Management Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'What is the Nepali term for dispatch register?', 'options' => ['Darta', 'Chalani', 'Tippani', 'Pragati'], 'answer' => 1, 'explanation' => 'Chalani is the dispatch register for outgoing correspondence.'],
                                ['question' => 'What is the main purpose of office filing?', 'options' => ['Destroying records', 'Systematic storage and easy retrieval', 'Avoiding audits', 'Reducing staff'], 'answer' => 1, 'explanation' => 'Filing arranges records systematically for easy retrieval when needed.'],
                                ['question' => 'Under which Act must government offices maintain proper filing?', 'options' => ['Civil Service Act', 'Good Governance Act 2064', 'Companies Act', 'Banking Act'], 'answer' => 1, 'explanation' => 'The Good Governance Act 2064 mandates proper record keeping in government offices.'],
                                ['question' => 'Which filing system is most common in Nepal government offices?', 'options' => ['Alphabetical', 'Numerical', 'Subject Filing', 'Random'], 'answer' => 2, 'explanation' => 'Subject filing, where files are grouped by topic, is most commonly used.'],
                            ])],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Samanya Buddhi Parikshan (IQ Test)',
                'description' => 'First Paper: Objective aptitude and reasoning section.',
                'chapters' => [
                    [
                        'title' => 'Number and Letter Series',
                        'lessons' => [
                            ['title' => 'Number Series Methods', 'type' => 'text', 'content' => '<h3>Common Number Patterns</h3><p>Number series questions appear in every Loksewa objective exam. Master these patterns:</p><ul><li><strong>Arithmetic Sequence:</strong> Constant difference between terms (e.g., 3, 7, 11, 15 → difference of 4)</li><li><strong>Geometric Sequence:</strong> Constant ratio between terms (e.g., 2, 6, 18, 54 → ratio of 3)</li><li><strong>Square Series:</strong> Terms are perfect squares (1, 4, 9, 16, 25...)</li><li><strong>Fibonacci Pattern:</strong> Each term is sum of two preceding terms (1, 1, 2, 3, 5, 8, 13...)</li><li><strong>Alternating Series:</strong> Two interleaved series (1, 10, 2, 20, 3, 30...)</li></ul>'],
                            ['title' => 'IQ Practice Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'Find the next term: 2, 6, 18, 54, ?', 'options' => ['108', '162', '72', '216'], 'answer' => 1, 'explanation' => 'Geometric series with ratio 3: 54 x 3 = 162.'],
                                ['question' => 'Find the next term: 1, 4, 9, 16, ?', 'options' => ['20', '25', '24', '36'], 'answer' => 1, 'explanation' => 'Series of perfect squares: 1, 4, 9, 16, 25.'],
                                ['question' => 'If APPLE is coded as BQQMF, how is CAT coded?', 'options' => ['DBU', 'DCU', 'DAT', 'CBU'], 'answer' => 0, 'explanation' => 'Each letter shifts forward by 1: C→D, A→B, T→U.'],
                            ])],
                        ],
                    ],
                ],
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════════
    // NAYAB SUBBA MODULES
    // ═══════════════════════════════════════════════════════════════
    private function getNayabSubbaModules(): array
    {
        return [
            [
                'title' => 'Pahilo Patra: Samanya Gyan',
                'description' => 'First Paper: General Knowledge covering Nepal and world affairs.',
                'chapters' => [
                    [
                        'title' => 'Nepal ko Rajnaitik Itihas',
                        'lessons' => [
                            ['title' => 'Political History from Unification to Republic', 'type' => 'text', 'content' => '<h3>Key Political Milestones</h3><ul><li><strong>1768-69:</strong> Prithvi Narayan Shah conquers Kathmandu Valley</li><li><strong>1814-16:</strong> Anglo-Nepal War (Treaty of Sugauli — Nepal loses significant territory)</li><li><strong>1846:</strong> Kot Massacre — Jung Bahadur Rana seizes power</li><li><strong>1950-51:</strong> Democratic revolution ends Rana rule</li><li><strong>1959:</strong> First general election (B.P. Koirala becomes PM)</li><li><strong>1960:</strong> Royal coup by King Mahendra, Panchayat system introduced</li><li><strong>1990:</strong> Jana Andolan I restores multi-party democracy</li><li><strong>1996-2006:</strong> Maoist insurgency (People\'s War)</li><li><strong>2006:</strong> Jana Andolan II, Comprehensive Peace Accord</li><li><strong>2008:</strong> Nepal declared Federal Democratic Republic (monarchy abolished)</li><li><strong>2015:</strong> Constitution of Nepal 2072 promulgated with 7 provinces</li></ul>'],
                            ['title' => 'Nepal Political History Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'When was Nepal declared a Federal Democratic Republic?', 'options' => ['2006', '2008', '2015', '1990'], 'answer' => 1, 'explanation' => 'Nepal was declared a Federal Democratic Republic in 2008 after the first Constituent Assembly meeting.'],
                                ['question' => 'Which treaty did Nepal sign after the Anglo-Nepal War?', 'options' => ['Treaty of Sagauli', 'Treaty of Sugauli', 'Treaty of Versailles', 'Treaty of Kathmandu'], 'answer' => 1, 'explanation' => 'The Treaty of Sugauli (1816) ended the Anglo-Nepal War.'],
                                ['question' => 'How many provinces does Nepal have under the 2015 Constitution?', 'options' => ['5', '6', '7', '14'], 'answer' => 2, 'explanation' => 'The Constitution of Nepal 2072 divides the country into 7 provinces.'],
                                ['question' => 'Who was Nepal\'s first elected Prime Minister?', 'options' => ['Matrika Prasad Koirala', 'B.P. Koirala', 'Girija Prasad Koirala', 'Tanka Prasad Acharya'], 'answer' => 1, 'explanation' => 'B.P. Koirala became Nepal\'s first democratically elected Prime Minister in 1959.'],
                            ])],
                        ],
                    ],
                    [
                        'title' => 'Samsamayik Ghatanakram',
                        'lessons' => [
                            ['title' => 'Current Affairs Framework for Loksewa', 'type' => 'text', 'content' => '<h3>How to Prepare Current Affairs</h3><p>Current affairs typically carry 15-25 marks in Loksewa objective papers. Systematic preparation strategy:</p><ul><li><strong>Monthly Review:</strong> Track major national events, appointments, policy changes from Gorkhapatra</li><li><strong>Economic Indicators:</strong> GDP growth rate, inflation, remittance figures, trade balance, fiscal budget highlights</li><li><strong>International:</strong> Nepal\'s relations with India, China, UN activities, SDG progress</li><li><strong>Awards & Achievements:</strong> National and international awards to Nepali citizens</li></ul><h3>Key Organizations</h3><ul><li>SAARC (HQ: Kathmandu), BIMSTEC, UN agencies in Nepal</li><li>ADB, World Bank, IMF involvement in Nepal</li><li>Nepal\'s membership in international organizations</li></ul>'],
                            ['title' => 'Nayab Subba Syllabus PDF', 'type' => 'pdf', 'content' => 'Complete Nayab Subba syllabus overview with paper-wise topic breakdown.', 'attachment_path' => 'storage/notes/loksewa/nayab-subba-gk-notes.pdf'],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Pahilo Patra: Buddhi Parikshan (IQ)',
                'description' => 'First Paper: Intelligence Quotient section for Nayab Subba exam.',
                'chapters' => [
                    [
                        'title' => 'Verbal and Non-Verbal Reasoning',
                        'lessons' => [
                            ['title' => 'Verbal Analogy and Series', 'type' => 'text', 'content' => '<h3>Verbal Analogy Techniques</h3><p>Verbal analogy questions test your ability to identify relationships between word pairs:</p><ul><li><strong>Synonym/Antonym:</strong> Happy : Sad :: Hot : Cold</li><li><strong>Part-Whole:</strong> Wheel : Car :: Key : Keyboard</li><li><strong>Cause-Effect:</strong> Rain : Flood :: Drought : Famine</li><li><strong>Tool-Function:</strong> Pen : Writing :: Knife : Cutting</li><li><strong>Worker-Workplace:</strong> Teacher : School :: Doctor : Hospital</li></ul><h3>Letter Series Patterns</h3><ul><li>Skip patterns: A, C, E, G (skip 1)</li><li>Reverse patterns: Z, Y, X, W (decrement)</li><li>Mixed: AB, CD, EF (pair increment)</li></ul>'],
                            ['title' => 'Nayab Subba IQ Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'Complete: Doctor : Hospital :: Teacher : ?', 'options' => ['Clinic', 'School', 'Office', 'Library'], 'answer' => 1, 'explanation' => 'A doctor works in a hospital; a teacher works in a school.'],
                                ['question' => 'Find the next term: B, D, F, H, ?', 'options' => ['I', 'J', 'K', 'L'], 'answer' => 1, 'explanation' => 'The series skips one letter: B(+2)=D(+2)=F(+2)=H(+2)=J.'],
                                ['question' => 'If LION is coded as MJPO, how is BEAR coded?', 'options' => ['CFBS', 'CFAS', 'DCBS', 'CEBR'], 'answer' => 0, 'explanation' => 'Each letter shifts +1: B→C, E→F, A→B, R→S = CFBS.'],
                                ['question' => 'Odd one out: Rose, Lily, Oak, Jasmine', 'options' => ['Rose', 'Lily', 'Oak', 'Jasmine'], 'answer' => 2, 'explanation' => 'Oak is a tree; the rest are flowers.'],
                            ])],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Dosro Patra: Samanya Prashashan',
                'description' => 'Second Paper: General Administration and Accounting.',
                'chapters' => [
                    [
                        'title' => 'Prashasanik Byawastha',
                        'lessons' => [
                            ['title' => 'Principles of Public Administration', 'type' => 'text', 'content' => '<h3>Public Administration in Nepal</h3><p>Public administration is the implementation of government policy and management of public programs. Key concepts for Nayab Subba exam:</p><ul><li><strong>Bureaucracy (Max Weber):</strong> Hierarchical organization, formal rules, merit-based recruitment, impersonal relationships, career service</li><li><strong>POSDCORB (Luther Gulick):</strong> Planning, Organizing, Staffing, Directing, Coordinating, Reporting, Budgeting — the 7 functions of administration</li><li><strong>Line and Staff:</strong> Line agencies execute policy directly (ministries, departments); Staff agencies provide support (PSC, OPMCM)</li></ul><h3>Nepal\'s Administrative Structure</h3><ul><li>Federal: Ministries, Departments, Constitutional Bodies</li><li>Provincial: Provincial Ministries, Provincial Service Commission</li><li>Local: Metropolitan City, Sub-Metropolitan, Municipality, Rural Municipality</li></ul>'],
                            ['title' => 'Public Administration Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'Who proposed the POSDCORB framework?', 'options' => ['Max Weber', 'Luther Gulick', 'Woodrow Wilson', 'F.W. Taylor'], 'answer' => 1, 'explanation' => 'Luther Gulick proposed POSDCORB as 7 functions of administration.'],
                                ['question' => 'Which level of government includes Rural Municipalities?', 'options' => ['Federal', 'Provincial', 'Local', 'District'], 'answer' => 2, 'explanation' => 'Rural Municipalities (Gaunpalika) are part of the Local level government.'],
                                ['question' => 'What does the "S" in POSDCORB stand for?', 'options' => ['Supervising', 'Staffing', 'Scheduling', 'Strategizing'], 'answer' => 1, 'explanation' => 'S stands for Staffing — recruiting and managing personnel.'],
                            ])],
                        ],
                    ],
                    [
                        'title' => 'Lekha ra Aarthik Byawasthapan',
                        'lessons' => [
                            ['title' => 'Basic Accounting for Nayab Subba', 'type' => 'text', 'content' => '<h3>Government Accounting Basics</h3><p>Understanding government accounting is essential for Nayab Subba level. Key concepts:</p><ul><li><strong>Double Entry System:</strong> Every transaction has equal debit and credit effects</li><li><strong>Fiscal Year:</strong> Nepal\'s fiscal year runs from Shrawan 1 to Ashadh end (mid-July to mid-July)</li><li><strong>Budget Categories:</strong> Revenue budget (current expenditure) and Capital budget (development expenditure)</li><li><strong>Revenue Sources:</strong> Tax revenue (income tax, VAT, customs duty) and Non-tax revenue (fees, fines, royalties)</li></ul><h3>Key Financial Terms</h3><ul><li><strong>Beruju (Audit Irregularity):</strong> Unauthorized or irregular expenditure found during audit</li><li><strong>Farchyaut (Settlement):</strong> Process of settling audit observations</li></ul>'],
                            ['title' => 'Nayab Subba Admin Notes PDF', 'type' => 'pdf', 'content' => 'Nayab Subba administration and accounting study notes.', 'attachment_path' => 'storage/notes/loksewa/nayab-subba-admin-notes.pdf'],
                        ],
                    ],
                ],
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════════
    // SECTION OFFICER MODULES
    // ═══════════════════════════════════════════════════════════════
    private function getSectionOfficerModules(): array
    {
        return [
            [
                'title' => 'AAT Screening Preparation',
                'description' => 'Administrative Aptitude Test — 100 MCQs covering GK (50), IQ (30), English (20).',
                'chapters' => [
                    [
                        'title' => 'General Awareness (50 marks)',
                        'lessons' => [
                            ['title' => 'Nepal Affairs & Current Events', 'type' => 'text', 'content' => '<h3>Key Topics for AAT General Awareness</h3><p>The AAT screening test has 50 MCQs on general awareness. Focus areas:</p><ul><li><strong>Nepal Geography:</strong> 7 provinces, 77 districts, major mountains, rivers, national parks, conservation areas</li><li><strong>Constitutional Provisions:</strong> Fundamental rights, DPSP, state structure, constitutional bodies</li><li><strong>National Symbols:</strong> National flag (only non-rectangular), national anthem, national flower (rhododendron), national bird (Danphe/Impeyan Pheasant), national animal (cow)</li><li><strong>Important Dates:</strong> Democracy Day (Falgun 7), Republic Day (Jestha 15), Constitution Day (Ashoj 3)</li></ul>'],
                            ['title' => 'English Competence for AAT', 'type' => 'text', 'content' => '<h3>English Section (20 marks)</h3><p>The English section tests basic language competence:</p><ul><li><strong>Grammar:</strong> Tenses, subject-verb agreement, articles, prepositions</li><li><strong>Vocabulary:</strong> Synonyms, antonyms, one-word substitutions</li><li><strong>Comprehension:</strong> Short passage reading with inference questions</li><li><strong>Error Correction:</strong> Identify grammatical errors in sentences</li></ul><h3>Common Pitfalls</h3><ul><li>Confusing affect/effect, principal/principle, stationery/stationary</li><li>Subject-verb agreement with collective nouns</li><li>Correct use of conditional sentences (If + past, would + base form)</li></ul>'],
                            ['title' => 'AAT Screening Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'How many districts does Nepal currently have?', 'options' => ['72', '75', '77', '80'], 'answer' => 2, 'explanation' => 'Nepal has 77 districts across 7 provinces.'],
                                ['question' => 'What is Nepal\'s national bird?', 'options' => ['Peacock', 'Danphe', 'Eagle', 'Sparrow'], 'answer' => 1, 'explanation' => 'Danphe (Impeyan Pheasant/Himalayan Monal) is Nepal\'s national bird.'],
                                ['question' => 'Constitution Day of Nepal falls on which BS date?', 'options' => ['Falgun 7', 'Jestha 15', 'Ashoj 3', 'Baisakh 1'], 'answer' => 2, 'explanation' => 'Constitution Day is celebrated on Ashoj 3 (September 20, 2015 was when it was promulgated).'],
                                ['question' => 'Choose the correct sentence:', 'options' => ['He don\'t know nothing', 'Neither the students nor the teacher were present', 'Neither the students nor the teacher was present', 'He doesn\'t knows'], 'answer' => 2, 'explanation' => 'With neither...nor, the verb agrees with the nearest subject (teacher - singular).'],
                            ])],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Dosro Patra: Shasan Pranali',
                'description' => 'Paper II: State governance, constitution, law, public service, resource management.',
                'chapters' => [
                    [
                        'title' => 'Shasan ra Sushasan',
                        'lessons' => [
                            ['title' => 'New Public Management Concepts', 'type' => 'text', 'content' => '<h3>New Public Management (NPM)</h3><p>NPM is an approach to running public service organizations that emphasizes market orientation and efficiency:</p><ul><li><strong>Key Principles:</strong> Customer/citizen orientation, performance measurement, decentralization, competition, results-based management</li><li><strong>NPM vs Traditional:</strong> Traditional bureaucracy is rule-based; NPM is results-based. Traditional is centralized; NPM decentralizes authority.</li><li><strong>Criticism:</strong> May reduce equity, weaken accountability, commercialize public services</li></ul><h3>Good Governance Principles (UNDP)</h3><ol><li>Participation</li><li>Rule of Law</li><li>Transparency</li><li>Responsiveness</li><li>Consensus Orientation</li><li>Equity and Inclusiveness</li><li>Effectiveness and Efficiency</li><li>Accountability</li></ol>'],
                            ['title' => 'Federalism in Nepal', 'type' => 'text', 'content' => '<h3>Federal Structure Under Constitution 2072</h3><p>Nepal adopted a three-tier federal system:</p><h3>Division of Powers</h3><ul><li><strong>Federal Exclusive List (Schedule 5):</strong> Defense, foreign affairs, central banking, currency, customs, international trade</li><li><strong>Provincial Exclusive List (Schedule 6):</strong> Provincial police, provincial public service, state highways, provincial statistics</li><li><strong>Local Exclusive List (Schedule 8):</strong> Local taxes, local markets, FM radio, basic health services, local roads</li><li><strong>Concurrent List (Schedule 7 & 9):</strong> Education, health, agriculture, labor law, social security</li></ul><h3>Seven Provinces</h3><ol><li>Koshi Pradesh (Capital: Biratnagar)</li><li>Madhesh Pradesh (Capital: Janakpur)</li><li>Bagmati Pradesh (Capital: Hetauda)</li><li>Gandaki Pradesh (Capital: Pokhara)</li><li>Lumbini Pradesh (Capital: Deukhuri)</li><li>Karnali Pradesh (Capital: Birendranagar)</li><li>Sudurpashchim Pradesh (Capital: Godawari)</li></ol>'],
                            ['title' => 'Section Officer Governance Notes PDF', 'type' => 'pdf', 'content' => 'Comprehensive governance and administration notes for Section Officer exam.', 'attachment_path' => 'storage/notes/loksewa/section-officer-governance-notes.pdf'],
                            ['title' => 'Governance System Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'Which approach emphasizes results-based management in public service?', 'options' => ['Traditional Bureaucracy', 'New Public Management', 'Socialism', 'Feudalism'], 'answer' => 1, 'explanation' => 'NPM emphasizes results, performance measurement, and customer orientation.'],
                                ['question' => 'How many items are in the UNDP Good Governance principles?', 'options' => ['5', '6', '8', '10'], 'answer' => 2, 'explanation' => 'UNDP identifies 8 characteristics of good governance.'],
                                ['question' => 'Which schedule of Nepal\'s Constitution contains the Federal Exclusive List?', 'options' => ['Schedule 4', 'Schedule 5', 'Schedule 6', 'Schedule 7'], 'answer' => 1, 'explanation' => 'Schedule 5 contains the Federal Exclusive List of powers.'],
                                ['question' => 'What is the capital of Gandaki Pradesh?', 'options' => ['Pokhara', 'Biratnagar', 'Janakpur', 'Hetauda'], 'answer' => 0, 'explanation' => 'Pokhara is the capital of Gandaki Pradesh.'],
                            ])],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Tesro Patra: Samsamayik Bishaya',
                'description' => 'Paper III: Contemporary social, economic, developmental, and environmental issues.',
                'chapters' => [
                    [
                        'title' => 'Arthik ra Samajik Mudda',
                        'lessons' => [
                            ['title' => 'Development Challenges of Nepal', 'type' => 'text', 'content' => '<h3>Key Development Issues</h3><ul><li><strong>Poverty:</strong> Multidimensional poverty index (MPI), poverty line, targeted programs (Karnali employment program)</li><li><strong>Remittance Economy:</strong> Remittance accounts for ~25% of GDP. Over 4 million Nepali workers abroad. Challenges: brain drain, dependency, lack of productive investment</li><li><strong>SDGs in Nepal:</strong> 17 Sustainable Development Goals — Nepal aims to graduate from LDC status by 2026. Key challenges in SDG 1 (poverty), SDG 4 (education), SDG 5 (gender equality)</li><li><strong>Climate Change:</strong> Nepal is highly vulnerable — glacial lake outburst floods (GLOF), changing monsoon patterns, biodiversity loss</li></ul>'],
                            ['title' => 'Contemporary Issues Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'What percentage of Nepal\'s GDP comes from remittance?', 'options' => ['About 10%', 'About 15%', 'About 25%', 'About 40%'], 'answer' => 2, 'explanation' => 'Remittance contributes approximately 25% of Nepal\'s GDP.'],
                                ['question' => 'How many SDGs are there?', 'options' => ['12', '15', '17', '20'], 'answer' => 2, 'explanation' => 'There are 17 Sustainable Development Goals adopted by the UN in 2015.'],
                                ['question' => 'What does GLOF stand for?', 'options' => ['Global Lake Overflow Force', 'Glacial Lake Outburst Flood', 'General Land Observation Framework', 'Green Lake Observation Facility'], 'answer' => 1, 'explanation' => 'GLOF stands for Glacial Lake Outburst Flood — a major climate risk for Nepal.'],
                            ])],
                        ],
                    ],
                ],
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════════
    // NRB OFFICER MODULES
    // ═══════════════════════════════════════════════════════════════
    private function getNrbOfficerModules(): array
    {
        return [
            [
                'title' => 'Economics: Micro & Macro',
                'description' => 'Core economics for NRB Officer covering microeconomics and macroeconomics.',
                'chapters' => [
                    [
                        'title' => 'Microeconomics Fundamentals',
                        'lessons' => [
                            ['title' => 'Demand, Supply and Market Equilibrium', 'type' => 'text', 'content' => '<h3>Law of Demand</h3><p>The law of demand states that, ceteris paribus, as the price of a good increases, the quantity demanded decreases. The demand curve slopes downward from left to right.</p><h3>Determinants of Demand</h3><ul><li>Price of the good, Income of consumers, Price of related goods (substitutes/complements), Tastes and preferences, Population, Expectations of future prices</li></ul><h3>Elasticity</h3><ul><li><strong>Price Elasticity of Demand (PED):</strong> % change in Qd / % change in P. Elastic (>1), Inelastic (<1), Unitary (=1)</li><li><strong>Income Elasticity:</strong> Normal goods (positive), Inferior goods (negative)</li><li><strong>Cross Elasticity:</strong> Substitutes (positive), Complements (negative)</li></ul><h3>Market Structures</h3><ul><li>Perfect Competition: Many firms, homogeneous product, free entry/exit</li><li>Monopoly: Single seller, unique product, barriers to entry</li><li>Monopolistic Competition: Many firms, differentiated products</li><li>Oligopoly: Few dominant firms, interdependence</li></ul>'],
                            ['title' => 'Macroeconomics: GDP and National Income', 'type' => 'text', 'content' => '<h3>National Income Accounting</h3><p>Three methods of measuring GDP:</p><ol><li><strong>Production/Output Method:</strong> Sum of value added at each stage of production across all sectors</li><li><strong>Income Method:</strong> Sum of all factor incomes — wages, rent, interest, profit</li><li><strong>Expenditure Method:</strong> GDP = C + I + G + (X - M) where C=Consumption, I=Investment, G=Government spending, X=Exports, M=Imports</li></ol><h3>Key Concepts</h3><ul><li><strong>Nominal vs Real GDP:</strong> Nominal uses current prices; Real adjusts for inflation using base year prices</li><li><strong>GDP Deflator:</strong> (Nominal GDP / Real GDP) × 100</li><li><strong>IS-LM Model:</strong> IS curve shows equilibrium in goods market; LM curve shows equilibrium in money market. Their intersection determines equilibrium interest rate and output.</li></ul><h3>Nepal\'s Economy</h3><ul><li>GDP growth rate: ~5-6% (target), Agriculture: ~25% of GDP, Services: ~55%, Industry: ~15%</li><li>Major trading partner: India (over 60% of trade)</li></ul>'],
                            ['title' => 'Economics Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'What does the expenditure method formula for GDP represent?', 'options' => ['C + I - G + X', 'C + I + G + (X - M)', 'C - I + G + M', 'C + I + G - X'], 'answer' => 1, 'explanation' => 'GDP = Consumption + Investment + Government Spending + Net Exports (Exports - Imports).'],
                                ['question' => 'If PED > 1, demand is:', 'options' => ['Perfectly inelastic', 'Inelastic', 'Elastic', 'Unitary'], 'answer' => 2, 'explanation' => 'When price elasticity of demand is greater than 1, demand is elastic.'],
                                ['question' => 'What is Nepal\'s largest sector by GDP contribution?', 'options' => ['Agriculture', 'Services', 'Industry', 'Mining'], 'answer' => 1, 'explanation' => 'The services sector contributes approximately 55% of Nepal\'s GDP.'],
                                ['question' => 'Which model determines equilibrium interest rate and output simultaneously?', 'options' => ['AD-AS Model', 'IS-LM Model', 'Solow Model', 'Phillips Curve'], 'answer' => 1, 'explanation' => 'The IS-LM model determines simultaneous equilibrium in both goods and money markets.'],
                            ])],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Banking & Financial System',
                'description' => 'Nepalese banking system, financial markets, and banking operations.',
                'chapters' => [
                    [
                        'title' => 'Nepal ko Banking Pranali',
                        'lessons' => [
                            ['title' => 'Structure of Nepalese Banking System', 'type' => 'text', 'content' => '<h3>Banking Hierarchy in Nepal</h3><p>Nepal Rastra Bank (NRB) classifies Banks and Financial Institutions (BFIs) into categories:</p><ul><li><strong>Class A — Commercial Banks:</strong> Currently 20+ commercial banks (after mergers). Examples: Nepal Bank Ltd (oldest, est. 1937), Rastriya Banijya Bank, Nabil Bank, Nepal Investment Bank</li><li><strong>Class B — Development Banks:</strong> Focus on development finance, smaller capital requirements</li><li><strong>Class C — Finance Companies:</strong> Accept deposits, provide consumer and hire-purchase loans</li><li><strong>Class D — Microfinance:</strong> Target rural poor, group lending methodology</li></ul><h3>Key Banking Ratios</h3><ul><li><strong>Capital Adequacy Ratio (CAR):</strong> Minimum 11% for commercial banks</li><li><strong>Cash Reserve Ratio (CRR):</strong> Set by NRB, currently around 3-4%</li><li><strong>Statutory Liquidity Ratio (SLR):</strong> Minimum liquid assets maintained</li><li><strong>Credit-to-Deposit Ratio (CD Ratio):</strong> Maximum 90% for commercial banks</li></ul>'],
                            ['title' => 'NRB Officer Economics Notes PDF', 'type' => 'pdf', 'content' => 'Economics and banking study notes for NRB Officer exam.', 'attachment_path' => 'storage/notes/loksewa/nrb-officer-economics-notes.pdf'],
                            ['title' => 'Banking System Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'What is the minimum Capital Adequacy Ratio for commercial banks in Nepal?', 'options' => ['8%', '10%', '11%', '15%'], 'answer' => 2, 'explanation' => 'NRB requires a minimum CAR of 11% for commercial banks.'],
                                ['question' => 'Which is the oldest bank in Nepal?', 'options' => ['Rastriya Banijya Bank', 'Nepal Bank Limited', 'Nabil Bank', 'Agriculture Development Bank'], 'answer' => 1, 'explanation' => 'Nepal Bank Limited, established in 1937 (1994 BS), is Nepal\'s oldest bank.'],
                                ['question' => 'What is the maximum CD ratio for commercial banks?', 'options' => ['80%', '85%', '90%', '95%'], 'answer' => 2, 'explanation' => 'NRB has set the maximum Credit-to-Deposit ratio at 90%.'],
                            ])],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Financial Accounting',
                'description' => 'Accounting principles, financial statements, and bank accounting.',
                'chapters' => [
                    [
                        'title' => 'Banking Accounting Principles',
                        'lessons' => [
                            ['title' => 'Double Entry System in Banking', 'type' => 'text', 'content' => '<h3>Double Entry System</h3><p>Every bank transaction involves a debit and credit of equal amounts:</p><ul><li><strong>Deposits received:</strong> Debit Cash/Bank → Credit Customer Deposit (Liability)</li><li><strong>Loan disbursed:</strong> Debit Loan Account (Asset) → Credit Customer Account</li><li><strong>Interest earned:</strong> Debit Customer Loan A/C → Credit Interest Income (Revenue)</li><li><strong>Interest paid:</strong> Debit Interest Expense → Credit Customer Deposit A/C</li></ul><h3>Bank Financial Statements</h3><ul><li><strong>Balance Sheet:</strong> Assets = Liabilities + Capital. Banks show deposits as liabilities and loans as assets.</li><li><strong>Income Statement:</strong> Interest income - Interest expense = Net Interest Income. Plus non-interest income minus operating expenses.</li><li><strong>NPA (Non-Performing Assets):</strong> Loans where principal or interest is overdue by 90+ days. Classified as Substandard, Doubtful, or Loss.</li></ul>'],
                            ['title' => 'Accounting Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'Customer deposits are classified as what on a bank\'s balance sheet?', 'options' => ['Assets', 'Liabilities', 'Revenue', 'Capital'], 'answer' => 1, 'explanation' => 'Customer deposits are liabilities because the bank owes that money to depositors.'],
                                ['question' => 'A loan becomes NPA after how many days overdue?', 'options' => ['30 days', '60 days', '90 days', '120 days'], 'answer' => 2, 'explanation' => 'A loan is classified as Non-Performing Asset when overdue for 90+ days.'],
                            ])],
                        ],
                    ],
                ],
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════════
    // NRB ASSISTANT DIRECTOR MODULES
    // ═══════════════════════════════════════════════════════════════
    private function getNrbAdModules(): array
    {
        return [
            [
                'title' => 'Banking Laws & Regulations',
                'description' => 'Core banking legislation and regulatory framework for NRB AD.',
                'chapters' => [
                    [
                        'title' => 'NRB Act 2058 and BAFIA',
                        'lessons' => [
                            ['title' => 'Nepal Rastra Bank Act 2058', 'type' => 'text', 'content' => '<h3>Objectives of NRB (Section 4)</h3><p>The Nepal Rastra Bank Act, 2058 establishes NRB with the following objectives:</p><ol><li>Formulate and manage monetary and foreign exchange policies to maintain price stability and balance of payment stability</li><li>Promote stability and healthy growth of banking and financial sector</li><li>Develop a secure, healthy, and efficient payment system</li></ol><h3>Key Functions of NRB</h3><ul><li><strong>Monetary Policy:</strong> Determines money supply, interest rates, and credit conditions</li><li><strong>Banker\'s Bank:</strong> Lender of last resort, clearinghouse for inter-bank transactions</li><li><strong>Government\'s Banker:</strong> Manages government accounts, issues government bonds</li><li><strong>Regulator & Supervisor:</strong> Licenses, regulates, and supervises all BFIs</li><li><strong>Foreign Exchange Management:</strong> Manages foreign exchange reserves, determines exchange rate policy</li></ul><h3>BAFIA (Bank and Financial Institution Act)</h3><p>The BAFIA provides the legal framework for licensing, operation, regulation, and inspection of banks and financial institutions in Nepal. It classifies BFIs into four categories (A, B, C, D) with different capital and operational requirements.</p>'],
                            ['title' => 'Foreign Exchange Regulation', 'type' => 'text', 'content' => '<h3>Foreign Exchange Regulation Act, 2058</h3><p>Key provisions governing foreign exchange in Nepal:</p><ul><li><strong>Exchange Rate:</strong> NRB determines and maintains the exchange rate. Nepali Rupee is pegged to Indian Rupee at 1.6:1 (floating against other currencies)</li><li><strong>Current Account Convertibility:</strong> Foreign exchange freely available for trade and services</li><li><strong>Capital Account Controls:</strong> Restrictions on foreign investment, capital outflows, external borrowing</li><li><strong>Authorized Dealers:</strong> Only NRB-licensed banks can deal in foreign exchange</li></ul><h3>Anti-Money Laundering</h3><p>Asset (Money) Laundering Prevention Act, 2064 requires BFIs to:</p><ul><li>Implement KYC (Know Your Customer) procedures</li><li>Report suspicious transactions to Financial Information Unit (FIU)</li><li>Maintain transaction records for 5+ years</li></ul>'],
                            ['title' => 'NRB AD Banking Law Notes PDF', 'type' => 'pdf', 'content' => 'Banking law and regulation study notes for NRB Assistant Director exam.', 'attachment_path' => 'storage/notes/loksewa/nrb-ad-banking-law-notes.pdf'],
                            ['title' => 'Banking Law Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'Under which section of NRB Act 2058 are the objectives defined?', 'options' => ['Section 2', 'Section 4', 'Section 8', 'Section 12'], 'answer' => 1, 'explanation' => 'Section 4 of the NRB Act 2058 defines the objectives of Nepal Rastra Bank.'],
                                ['question' => 'What is the peg rate between NPR and INR?', 'options' => ['1:1', '1.4:1', '1.6:1', '2:1'], 'answer' => 2, 'explanation' => 'The Nepali Rupee is pegged to Indian Rupee at 1.6 NPR = 1 INR.'],
                                ['question' => 'How many categories of BFIs are there under BAFIA?', 'options' => ['2', '3', '4', '5'], 'answer' => 2, 'explanation' => 'BAFIA classifies BFIs into 4 categories: A (Commercial), B (Development), C (Finance), D (Microfinance).'],
                                ['question' => 'For how long must BFIs maintain transaction records under AML Act?', 'options' => ['1 year', '3 years', '5 years', '10 years'], 'answer' => 2, 'explanation' => 'The AML Act requires maintaining records for at least 5 years.'],
                            ])],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Monetary Policy & Central Banking',
                'description' => 'Monetary policy tools, implementation, and central banking functions.',
                'chapters' => [
                    [
                        'title' => 'Monetary Policy Instruments',
                        'lessons' => [
                            ['title' => 'NRB Monetary Policy Tools', 'type' => 'text', 'content' => '<h3>Monetary Policy Instruments of NRB</h3><p>NRB uses various tools to control money supply, credit, and inflation:</p><h3>Quantitative Tools</h3><ul><li><strong>Cash Reserve Ratio (CRR):</strong> Percentage of deposits that banks must hold as cash with NRB. Increase CRR → tighter liquidity</li><li><strong>Bank Rate:</strong> Rate at which NRB lends to commercial banks. Higher bank rate → discourage borrowing → reduce money supply</li><li><strong>Open Market Operations (OMO):</strong> Buying/selling government securities. NRB buys → injects liquidity; NRB sells → absorbs liquidity</li><li><strong>Standing Liquidity Facility (SLF):</strong> Emergency overnight lending to banks against collateral</li></ul><h3>Qualitative Tools</h3><ul><li><strong>Margin Requirements:</strong> Minimum down payment for loans against securities</li><li><strong>Credit Ceiling/Rationing:</strong> Limits on total credit or sector-specific lending</li><li><strong>Moral Suasion:</strong> NRB advises/persuades banks informally</li><li><strong>Priority Sector Lending:</strong> Mandated lending to agriculture, energy, SMEs</li></ul>'],
                            ['title' => 'Capital Adequacy Framework', 'type' => 'text', 'content' => '<h3>Basel Framework in Nepal</h3><p>NRB follows Basel III standards for capital adequacy:</p><ul><li><strong>Tier 1 Capital (Core):</strong> Common equity, retained earnings — minimum 7% of Risk-Weighted Assets</li><li><strong>Tier 2 Capital (Supplementary):</strong> Subordinated debt, general provisions — up to 4%</li><li><strong>Total CAR:</strong> Minimum 11% (Tier 1 + Tier 2)</li></ul><h3>Corporate Governance</h3><p>NRB Directives on corporate governance for BFIs:</p><ul><li>Board composition: Maximum 7 members, including independent directors</li><li>CEO tenure: Maximum 4 years, renewable once</li><li>Audit Committee: Mandatory, headed by independent director</li><li>Risk Management Committee: Separate from audit committee</li><li>Fit and Proper test for directors and CEOs</li></ul>'],
                            ['title' => 'NRB AD Monetary Policy Notes PDF', 'type' => 'pdf', 'content' => 'Monetary policy tools and corporate governance study notes.', 'attachment_path' => 'storage/notes/loksewa/nrb-ad-monetary-policy-notes.pdf'],
                            ['title' => 'Monetary Policy Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'What happens when NRB increases CRR?', 'options' => ['Liquidity increases', 'Liquidity decreases', 'No effect', 'Inflation increases'], 'answer' => 1, 'explanation' => 'Higher CRR means banks must hold more reserves, reducing lendable funds and liquidity.'],
                                ['question' => 'What is the minimum total CAR requirement for commercial banks in Nepal?', 'options' => ['8%', '10%', '11%', '13%'], 'answer' => 2, 'explanation' => 'NRB requires a minimum total Capital Adequacy Ratio of 11%.'],
                                ['question' => 'Open Market Operations involve buying/selling what?', 'options' => ['Foreign currency only', 'Government securities', 'Gold reserves', 'Corporate bonds only'], 'answer' => 1, 'explanation' => 'OMO involves buying/selling government securities to manage liquidity.'],
                            ])],
                        ],
                    ],
                ],
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════════
    // CONSTITUTION & LAW MODULES
    // ═══════════════════════════════════════════════════════════════
    private function getConstitutionModules(): array
    {
        return [
            [
                'title' => 'Nepal ko Samvidhan 2072',
                'description' => 'Detailed study of the Constitution of Nepal 2072.',
                'chapters' => [
                    [
                        'title' => 'Constitutional Framework',
                        'lessons' => [
                            ['title' => 'Constitution Structure and Preamble', 'type' => 'text', 'content' => '<h3>Constitution of Nepal 2072 (2015)</h3><p>The Constitution of Nepal was promulgated on Ashoj 3, 2072 BS (September 20, 2015) by the second Constituent Assembly. It is the supreme law of Nepal.</p><h3>Structure</h3><ul><li><strong>Parts:</strong> 35 parts</li><li><strong>Articles:</strong> 308 articles</li><li><strong>Schedules:</strong> 9 schedules (power distribution, provincial boundaries, etc.)</li></ul><h3>Preamble Highlights</h3><p>The preamble declares Nepal as:</p><ul><li>An independent, indivisible, sovereign nation</li><li>A secular state (Dharmanirapeksha)</li><li>An inclusive, democratic, socialism-oriented state</li><li>A federal democratic republic</li></ul><h3>Key Features</h3><ol><li>Sovereignty vested in the people</li><li>Three-tier federal structure (Federal, Provincial, Local)</li><li>Bicameral parliament at federal level (Pratinidhi Sabha + Rashtriya Sabha)</li><li>Comprehensive fundamental rights (31 types)</li><li>Independent judiciary with Constitutional Bench</li><li>Constitutional commissions for oversight</li></ol>'],
                            ['title' => 'Fundamental Rights Under Constitution', 'type' => 'text', 'content' => '<h3>Fundamental Rights (Part 3, Articles 16-46)</h3><p>The Constitution guarantees 31 fundamental rights:</p><ul><li><strong>Right to live with dignity (Art 16):</strong> No person shall be deprived of life except in accordance with law</li><li><strong>Right to freedom (Art 17):</strong> Expression, assembly, movement, profession, information</li><li><strong>Right to equality (Art 18):</strong> No discrimination based on origin, religion, race, caste, gender</li><li><strong>Right to communication (Art 19):</strong> No censorship, no closure of media</li><li><strong>Right to justice (Art 20):</strong> Access to courts, free legal aid for indigent</li><li><strong>Right against torture (Art 22):</strong> No cruel, inhuman, or degrading treatment</li><li><strong>Right to property (Art 25):</strong> Right to acquire, enjoy, and dispose of property</li><li><strong>Right to education (Art 31):</strong> Free and compulsory basic education</li><li><strong>Right to health (Art 35):</strong> Basic healthcare as fundamental right</li><li><strong>Right to employment (Art 33):</strong> Right to choose employment, fair labor conditions</li></ul><h3>Enforcement</h3><p>Fundamental rights are enforceable through the Supreme Court (Article 133) and High Courts (Article 144) through writs of habeas corpus, mandamus, certiorari, prohibition, and quo warranto.</p>'],
                            ['title' => 'Constitution 2072 Notes PDF', 'type' => 'pdf', 'content' => 'Constitution of Nepal 2072 key features and article-wise study notes.', 'attachment_path' => 'storage/notes/loksewa/constitution-2072-notes.pdf'],
                            ['title' => 'Constitution Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'How many articles are in the Constitution of Nepal 2072?', 'options' => ['252', '280', '308', '395'], 'answer' => 2, 'explanation' => 'The Constitution of Nepal 2072 has 308 articles.'],
                                ['question' => 'How many fundamental rights are guaranteed?', 'options' => ['18', '24', '31', '35'], 'answer' => 2, 'explanation' => 'The Constitution guarantees 31 fundamental rights.'],
                                ['question' => 'Which article guarantees the Right to Equality?', 'options' => ['Article 16', 'Article 17', 'Article 18', 'Article 20'], 'answer' => 2, 'explanation' => 'Article 18 guarantees the Right to Equality.'],
                                ['question' => 'How many schedules are in the Constitution?', 'options' => ['5', '7', '9', '12'], 'answer' => 2, 'explanation' => 'The Constitution has 9 schedules covering power distribution, boundaries, etc.'],
                            ])],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Sushasan Ain ra Suchana ko Hak',
                'description' => 'Good Governance Act 2064 and Right to Information Act.',
                'chapters' => [
                    [
                        'title' => 'Sushasan Ain 2064',
                        'lessons' => [
                            ['title' => 'Good Governance Act 2064 Key Provisions', 'type' => 'text', 'content' => '<h3>Good Governance (Management and Operation) Act, 2064</h3><p>This Act aims to make public administration responsive, accountable, transparent, and participatory.</p><h3>Key Provisions</h3><ul><li><strong>Citizen\'s Charter (Section 25):</strong> Every public body must display a charter showing services offered, required documents, fees, time limit, and responsible officer</li><li><strong>Grievance Handling:</strong> Complaints must be acknowledged within 3 days and resolved within 15 days</li><li><strong>Decision Timeline:</strong> Officers must make decisions within 3 days unless complex matters require more time</li><li><strong>Public Hearing:</strong> Development projects must conduct public hearings and social audits</li><li><strong>Reward & Punishment:</strong> Provisions for rewarding outstanding public servants and punishing corruption</li></ul><h3>Right to Information Act, 2064</h3><ul><li>Every citizen has the right to seek information from public bodies</li><li>Information must be provided within 15 days (or 7 days if it concerns life/liberty)</li><li>National Information Commission oversees implementation</li><li>Proactive disclosure: Public bodies must publish organizational structure, budget, programs, and decisions</li></ul>'],
                            ['title' => 'Good Governance Act Notes PDF', 'type' => 'pdf', 'content' => 'Good Governance Act 2064 and Right to Information study notes.', 'attachment_path' => 'storage/notes/loksewa/good-governance-act-notes.pdf'],
                            ['title' => 'Good Governance Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'Within how many days must a complaint be acknowledged under Good Governance Act?', 'options' => ['1 day', '3 days', '7 days', '15 days'], 'answer' => 1, 'explanation' => 'Complaints must be acknowledged within 3 days.'],
                                ['question' => 'What must every public body display under Section 25?', 'options' => ['Annual report', 'Citizen\'s Charter', 'Staff photo', 'Budget only'], 'answer' => 1, 'explanation' => 'Section 25 mandates a Citizen\'s Charter showing services, fees, timeline, and responsible officer.'],
                                ['question' => 'Under RTI Act, information must be provided within how many days?', 'options' => ['3 days', '7 days', '15 days', '30 days'], 'answer' => 2, 'explanation' => 'Information must be provided within 15 days (7 days if concerning life/liberty).'],
                            ])],
                        ],
                    ],
                ],
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════════
    // COMPUTER SKILL TEST MODULES
    // ═══════════════════════════════════════════════════════════════
    private function getComputerModules(): array
    {
        return [
            [
                'title' => 'MS Office Applications',
                'description' => 'Microsoft Word, Excel, and PowerPoint for computer skill test.',
                'chapters' => [
                    [
                        'title' => 'MS Word Essentials',
                        'lessons' => [
                            ['title' => 'Document Formatting in MS Word', 'type' => 'text', 'content' => '<h3>MS Word Skills for Loksewa Computer Test</h3><p>The computer skill test evaluates practical ability to use office software:</p><h3>Document Formatting</h3><ul><li><strong>Font formatting:</strong> Bold, Italic, Underline, Font size, Font color, Strikethrough</li><li><strong>Paragraph formatting:</strong> Alignment (left, center, right, justify), Line spacing, Indentation, Bullets and numbering</li><li><strong>Page Setup:</strong> Margins, Orientation (portrait/landscape), Paper size, Columns</li><li><strong>Headers & Footers:</strong> Page numbers, Date, Custom text</li></ul><h3>Essential Shortcuts</h3><ul><li>Ctrl+B (Bold), Ctrl+I (Italic), Ctrl+U (Underline)</li><li>Ctrl+S (Save), Ctrl+P (Print), Ctrl+Z (Undo)</li><li>Ctrl+C (Copy), Ctrl+V (Paste), Ctrl+X (Cut)</li><li>Ctrl+A (Select All), Ctrl+F (Find), Ctrl+H (Replace)</li></ul>'],
                            ['title' => 'MS Excel Basics', 'type' => 'text', 'content' => '<h3>MS Excel for Loksewa</h3><p>Excel questions commonly test formulas and data management:</p><h3>Essential Formulas</h3><ul><li><strong>SUM:</strong> =SUM(A1:A10) — adds values in range</li><li><strong>AVERAGE:</strong> =AVERAGE(B1:B10) — calculates mean</li><li><strong>COUNT:</strong> =COUNT(C1:C10) — counts numeric cells</li><li><strong>MAX/MIN:</strong> =MAX(D1:D10) / =MIN(D1:D10)</li><li><strong>IF:</strong> =IF(A1>50, "Pass", "Fail") — conditional logic</li><li><strong>VLOOKUP:</strong> =VLOOKUP(lookup_value, table, col_index, FALSE)</li></ul><h3>Cell References</h3><ul><li><strong>Relative:</strong> A1 (changes when copied)</li><li><strong>Absolute:</strong> $A$1 (stays fixed when copied)</li><li><strong>Mixed:</strong> $A1 or A$1 (partially fixed)</li></ul>'],
                            ['title' => 'Computer Skill Test Notes PDF', 'type' => 'pdf', 'content' => 'MS Office and computer skill test preparation notes.', 'attachment_path' => 'storage/notes/loksewa/computer-skill-test-notes.pdf'],
                            ['title' => 'MS Office Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'What is the shortcut for Undo in MS Word?', 'options' => ['Ctrl+Y', 'Ctrl+Z', 'Ctrl+U', 'Ctrl+X'], 'answer' => 1, 'explanation' => 'Ctrl+Z is the universal shortcut for Undo.'],
                                ['question' => 'Which Excel formula calculates the average of a range?', 'options' => ['=SUM()', '=AVERAGE()', '=MEAN()', '=AVG()'], 'answer' => 1, 'explanation' => '=AVERAGE() calculates the arithmetic mean of a range.'],
                                ['question' => 'What does $A$1 represent in Excel?', 'options' => ['Relative reference', 'Absolute reference', 'Mixed reference', 'External reference'], 'answer' => 1, 'explanation' => '$A$1 is an absolute reference — it stays fixed when the formula is copied.'],
                            ])],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Internet, Email & Typing',
                'description' => 'Internet usage, email skills, and Nepali Unicode typing.',
                'chapters' => [
                    [
                        'title' => 'Email and Internet Skills',
                        'lessons' => [
                            ['title' => 'Email Etiquette and Internet Usage', 'type' => 'text', 'content' => '<h3>Email Skills for Government Service</h3><ul><li><strong>Email Components:</strong> To, CC, BCC, Subject, Body, Attachment</li><li><strong>CC vs BCC:</strong> CC (Carbon Copy) — recipients visible to all. BCC (Blind Carbon Copy) — recipients hidden from others</li><li><strong>Professional Email Format:</strong> Formal greeting, clear subject line, concise body, professional closing, signature with designation</li></ul><h3>Internet and E-governance</h3><ul><li><strong>Key Protocols:</strong> HTTP/HTTPS (web), SMTP (sending email), POP3/IMAP (receiving email), FTP (file transfer)</li><li><strong>Nepal E-governance:</strong> Nagarik App, MeroKitta, Company Registration online, PAN/VAT online, e-Passport</li><li><strong>Digital Nepal Framework:</strong> Government initiative for digital infrastructure, e-services, digital payments</li></ul>'],
                            ['title' => 'Nepali Unicode Typing', 'type' => 'text', 'content' => '<h3>Nepali Unicode Typing</h3><p>Nepali Unicode typing is a required skill for government offices:</p><ul><li><strong>Traditional Layout:</strong> Based on Romanized Nepali — type Roman characters that convert to Devanagari</li><li><strong>Preeti vs Unicode:</strong> Preeti is a legacy font-based system; Unicode is the standard for web and cross-platform compatibility</li><li><strong>Key Resources:</strong> Unicode.org.np, Nepali Unicode converter tools</li><li><strong>Practice Tip:</strong> Aim for minimum 25 words per minute (WPM) in Nepali typing</li></ul>'],
                            ['title' => 'Email & Internet Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'What does BCC stand for in email?', 'options' => ['Basic Carbon Copy', 'Blind Carbon Copy', 'Bulk Carbon Copy', 'Binary Carbon Copy'], 'answer' => 1, 'explanation' => 'BCC stands for Blind Carbon Copy — recipients are hidden from others.'],
                                ['question' => 'Which protocol is used for sending emails?', 'options' => ['HTTP', 'FTP', 'SMTP', 'POP3'], 'answer' => 2, 'explanation' => 'SMTP (Simple Mail Transfer Protocol) is used for sending emails.'],
                            ])],
                        ],
                    ],
                ],
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════════
    // IQ & APTITUDE MODULES
    // ═══════════════════════════════════════════════════════════════
    private function getIqModules(): array
    {
        return [
            [
                'title' => 'Verbal Reasoning',
                'description' => 'Verbal analogy, series, coding-decoding, and word patterns.',
                'chapters' => [
                    [
                        'title' => 'Sabdik Tarka (Verbal Reasoning)',
                        'lessons' => [
                            ['title' => 'Analogy and Classification', 'type' => 'text', 'content' => '<h3>Verbal Analogy Types</h3><p>Analogies test your ability to identify relationships between concepts:</p><ul><li><strong>Synonym pairs:</strong> Big : Large :: Small : Tiny</li><li><strong>Antonym pairs:</strong> Hot : Cold :: Tall : Short</li><li><strong>Part : Whole:</strong> Page : Book :: Brick : Wall</li><li><strong>Worker : Tool:</strong> Carpenter : Hammer :: Painter : Brush</li><li><strong>Animal : Young:</strong> Horse : Foal :: Dog : Puppy</li><li><strong>Male : Female:</strong> King : Queen :: Actor : Actress</li></ul><h3>Classification (Odd One Out)</h3><p>Strategy: Find the common property shared by 3 items but not the 4th. Check for category, size, function, or nature.</p>'],
                            ['title' => 'Coding-Decoding Methods', 'type' => 'text', 'content' => '<h3>Coding-Decoding Patterns</h3><p>These questions test pattern recognition with letter/number codes:</p><h3>Common Coding Types</h3><ul><li><strong>Letter Shift:</strong> Each letter moves forward/backward by fixed positions. Example: CAT→DBU (+1 shift)</li><li><strong>Reverse Coding:</strong> Word is reversed. Example: COME→EMOC</li><li><strong>Position-Based:</strong> Letters replaced by their alphabet position numbers. A=1, B=2... Z=26</li><li><strong>Symbol Coding:</strong> Each letter assigned a unique symbol</li></ul><h3>Tips for Quick Solving</h3><ol><li>First identify the pattern by comparing encoded and original</li><li>Check if it\'s a simple shift (+1, +2, -1, -2)</li><li>Look for reversal patterns</li><li>Check if vowels and consonants are treated differently</li></ol>'],
                            ['title' => 'IQ Aptitude Notes PDF', 'type' => 'pdf', 'content' => 'IQ and aptitude test preparation notes with solved examples.', 'attachment_path' => 'storage/notes/loksewa/iq-aptitude-notes.pdf'],
                            ['title' => 'Verbal Reasoning Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'Complete: Painter : Brush :: Writer : ?', 'options' => ['Canvas', 'Pen', 'Book', 'Color'], 'answer' => 1, 'explanation' => 'A painter uses a brush; a writer uses a pen (worker:tool analogy).'],
                                ['question' => 'If GAME is coded as HBNF, what is the coding rule?', 'options' => ['+1 shift', '+2 shift', '-1 shift', 'Reverse'], 'answer' => 0, 'explanation' => 'G→H(+1), A→B(+1), M→N(+1), E→F(+1). Each letter shifts forward by 1.'],
                                ['question' => 'Odd one out: Apple, Mango, Carrot, Banana', 'options' => ['Apple', 'Mango', 'Carrot', 'Banana'], 'answer' => 2, 'explanation' => 'Carrot is a vegetable; the rest are fruits.'],
                                ['question' => 'Horse : Foal :: Cat : ?', 'options' => ['Cub', 'Kitten', 'Puppy', 'Calf'], 'answer' => 1, 'explanation' => 'A young horse is a foal; a young cat is a kitten.'],
                            ])],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Numerical Reasoning',
                'description' => 'Number series, mathematical reasoning, and data interpretation.',
                'chapters' => [
                    [
                        'title' => 'Sankhya Shreni ra Ganit',
                        'lessons' => [
                            ['title' => 'Number Series Advanced Patterns', 'type' => 'text', 'content' => '<h3>Advanced Number Series</h3><p>Beyond basic arithmetic and geometric series, Loksewa tests these patterns:</p><ul><li><strong>Difference Series:</strong> Take differences between consecutive terms. If differences form a pattern, use it. Example: 1, 3, 7, 13, 21 → differences: 2, 4, 6, 8 (increasing by 2)</li><li><strong>Product Series:</strong> Each term is previous term multiplied by increasing factor. Example: 2, 6, 24, 120 → ×3, ×4, ×5</li><li><strong>Mixed Operations:</strong> Alternating +, ×, +, × pattern. Example: 1, 3, 6, 18, 21, 63 → (+2, ×2, +12, ×2...)</li><li><strong>Prime Number Series:</strong> 2, 3, 5, 7, 11, 13, 17, 19, 23...</li></ul><h3>Quick Calculation Tricks</h3><ul><li>Multiplication by 11: 23×11 = 253 (put sum of digits in middle)</li><li>Square of numbers ending in 5: 35² = 1225 (3×4=12, append 25)</li><li>Percentage shortcuts: 25% = ÷4, 12.5% = ÷8, 33.33% = ÷3</li></ul>'],
                            ['title' => 'Logical Reasoning Notes PDF', 'type' => 'pdf', 'content' => 'Logical and numerical reasoning study notes with shortcuts.', 'attachment_path' => 'storage/notes/loksewa/logical-reasoning-notes.pdf'],
                            ['title' => 'Numerical Reasoning Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'Find the next: 1, 3, 7, 13, 21, ?', 'options' => ['28', '31', '25', '27'], 'answer' => 1, 'explanation' => 'Differences: 2, 4, 6, 8, so next difference is 10. 21+10=31.'],
                                ['question' => 'What is 35 squared?', 'options' => ['1125', '1225', '1025', '1325'], 'answer' => 1, 'explanation' => 'Numbers ending in 5: 3×4=12, append 25 → 1225.'],
                                ['question' => 'Find the next prime number after 17:', 'options' => ['18', '19', '20', '21'], 'answer' => 1, 'explanation' => '19 is the next prime after 17 (18=2×9, 19 is prime).'],
                                ['question' => 'What is 25% of 480?', 'options' => ['100', '120', '140', '96'], 'answer' => 1, 'explanation' => '25% = divide by 4. 480 ÷ 4 = 120.'],
                            ])],
                        ],
                    ],
                    [
                        'title' => 'Direction and Blood Relations',
                        'lessons' => [
                            ['title' => 'Direction Sense and Blood Relations', 'type' => 'text', 'content' => '<h3>Direction Sense Test</h3><p>Direction problems require mentally tracking movements on a compass:</p><ul><li><strong>Cardinal Directions:</strong> North, South, East, West</li><li><strong>Ordinal Directions:</strong> NE, NW, SE, SW</li><li><strong>Key Rules:</strong> Left turn from North = West; Right turn from North = East. Opposite of NE = SW.</li><li><strong>Shadow Tricks:</strong> Morning shadow falls West (sun in East); Evening shadow falls East (sun in West); No shadow at noon</li></ul><h3>Blood Relations</h3><p>Blood relation problems test family tree navigation:</p><ul><li><strong>Core Relations:</strong> Father, Mother, Brother, Sister, Son, Daughter, Husband, Wife</li><li><strong>Extended:</strong> Uncle/Aunt (Kaka, Mama, Phupu, Maiju), Nephew/Niece, Grandfather/Grandmother</li><li><strong>Strategy:</strong> Draw a family tree diagram with male (♂) and female (♀) symbols. Use + for marriage and vertical lines for parent-child.</li></ul>'],
                            ['title' => 'Direction & Relations Quiz', 'type' => 'quiz', 'content' => json_encode([
                                ['question' => 'If you face North and turn left, which direction do you face?', 'options' => ['East', 'West', 'South', 'Northeast'], 'answer' => 1, 'explanation' => 'Left turn from North leads to West.'],
                                ['question' => 'If A is B\'s father, and B is C\'s brother, what is A to C?', 'options' => ['Uncle', 'Father', 'Grandfather', 'Brother'], 'answer' => 1, 'explanation' => 'If A is B\'s father and B is C\'s brother, then A is also C\'s father.'],
                                ['question' => 'In the morning, your shadow falls in which direction?', 'options' => ['East', 'West', 'North', 'South'], 'answer' => 1, 'explanation' => 'In the morning, the sun is in the East, so shadows fall to the West.'],
                            ])],
                        ],
                    ],
                ],
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════════
    // PREREQUISITES
    // ═══════════════════════════════════════════════════════════════
    private function seedPrerequisites(array $courses): void
    {
        DB::table('course_prerequisites')->truncate();

        $edges = [
            ['kharidar', 'nayab_subba'],
            ['nayab_subba', 'section_officer'],
            ['kharidar', 'iq'],
            ['kharidar', 'computer'],
            ['nayab_subba', 'constitution'],
            ['constitution', 'nrb_officer'],
            ['nrb_officer', 'nrb_ad'],
            ['section_officer', 'nrb_ad'],
        ];

        foreach ($edges as [$prereqKey, $courseKey]) {
            if (isset($courses[$prereqKey]) && isset($courses[$courseKey])) {
                $courses[$courseKey]->prerequisites()->attach($courses[$prereqKey]->id);
            }
        }

        $this->command->info('   ✅ 8 prerequisite edges seeded (valid DAG)');
    }

    // ═══════════════════════════════════════════════════════════════
    // PDF GENERATION (Using barryvdh/laravel-dompdf via PdfGenerator)
    // ═══════════════════════════════════════════════════════════════
    private function generatePdfs(): void
    {
        $pdfs = [
            'kharidar-gk-notes' => [
                'title' => 'Kharidar - General Knowledge & Nepal Studies',
                'subtitle' => 'Comprehensive Study Notes for PSC Non-Gazetted 2nd Class Examination',
                'html' => '
                    <h2>1. Physical & Ecological Geography of Nepal</h2>
                    <p>Nepal is a landlocked nation located along the southern slopes of the central Himalayas. It extends 885 km east-west and 145-241 km north-south, covering an area of 147,516 sq. km.</p>
                    <table>
                        <tr><th>Ecological Region</th><th>Land Area %</th><th>Altitude Range</th><th>Key Characteristics & Districts</th></tr>
                        <tr><td><strong>Himalayan (Himal)</strong></td><td>15%</td><td>Above 3,000m to 8,848.86m</td><td>16 districts, cold alpine climate, sparse vegetation, peaks including Mt. Everest, Kanchenjunga, Lhotse, Makalu.</td></tr>
                        <tr><td><strong>Hilly (Pahad)</strong></td><td>68%</td><td>600m to 3,000m</td><td>Midland valleys (Kathmandu, Pokhara), Mahabharat & Chure ranges, temperate climate, major population center.</td></tr>
                        <tr><td><strong>Terai (Madhesh)</strong></td><td>17%</td><td>60m to 600m</td><td>Fertile alluvial plains, granary of Nepal, tropical/subtropical climate, high agricultural productivity.</td></tr>
                    </table>

                    <h2>2. Major River Systems & Hydropower Potential</h2>
                    <ul>
                        <li><strong>Koshi River System (Saptakoshi):</strong> Largest river system in Nepal by discharge. 7 major tributaries (Sun Koshi, Tama Koshi, Dudh Koshi, Indrawati, Likhu, Arun, Tamor). Drains eastern Nepal.</li>
                        <li><strong>Gandaki River System (Saptagandaki):</strong> Deepest river basin (Kaligandaki Gorge is the deepest in the world). 7 tributaries (Kaligandaki, Trishuli, Budhigandaki, Marsyangdi, Seti, Madi, Daraudi).</li>
                        <li><strong>Karnali River System:</strong> Longest river within Nepal (507 km). Originates from Lake Mansarovar region in Tibet. Lifeline of Western Nepal.</li>
                    </ul>
                    <div class="highlight-box">
                        <strong>Hydropower Facts:</strong> Total theoretical potential is estimated at 83,000 MW, with approximately 42,000 MW being technically and economically viable.
                    </div>

                    <h2>3. Milestones of Modern Nepali History</h2>
                    <table>
                        <tr><th>Year (AD / BS)</th><th>Historical Milestone</th><th>Significance</th></tr>
                        <tr><td>1768-69 AD (1825-26 BS)</td><td>Unification of Kathmandu Valley</td><td>King Prithvi Narayan Shah unified fragmented principalities.</td></tr>
                        <tr><td>1816 AD (1872 BS)</td><td>Treaty of Sugauli</td><td>Ended the Anglo-Nepalese War; defined modern international borders.</td></tr>
                        <tr><td>1846 AD (1903 BS)</td><td>Kot Massacre (Kot Parva)</td><td>Jung Bahadur Rana established 104-year hereditary Rana regime.</td></tr>
                        <tr><td>1951 AD (2007 BS)</td><td>Falgun 7 Revolution</td><td>Overthrew Rana autocracy; introduced multi-party democracy.</td></tr>
                        <tr><td>1990 AD (2046 BS)</td><td>Jana Andolan I</td><td>Restored multi-party democracy with constitutional monarchy.</td></tr>
                        <tr><td>2008 AD (2065 BS)</td><td>Abolition of Monarchy</td><td>First Constituent Assembly declared Nepal a Federal Democratic Republic.</td></tr>
                        <tr><td>2015 AD (2072 BS)</td><td>Constitution Promulgation</td><td>September 20, 2015 (Ashoj 3, 2072 BS) — 7 federal provinces created.</td></tr>
                    </table>
                ',
            ],
            'kharidar-office-mgmt-notes' => [
                'title' => 'Kharidar - Office Management & Procedures',
                'subtitle' => 'Official Working Procedures, Records Management, and Administrative Drafting',
                'html' => '
                    <h2>1. Concept and Importance of Office Management</h2>
                    <p>In public administration, an office acts as the nerve center where policies are translated into public services. Effective office management ensures efficiency, transparency, citizen satisfaction, and audit compliance.</p>

                    <h2>2. Filing System & Record Keeping</h2>
                    <p>Filing is the systematic preservation of documents so that they can be easily traced and retrieved when needed.</p>
                    <ul>
                        <li><strong>Subject Filing:</strong> Files categorized by administrative topics (most common in Nepali civil offices).</li>
                        <li><strong>Alphabetical & Numerical Filing:</strong> Systematic tracking using alphabets or serialized index numbers.</li>
                        <li><strong>Chronological Filing:</strong> Records arranged sequentially by date of creation or receipt.</li>
                    </ul>

                    <h2>3. Darta & Chalani Procedures</h2>
                    <table>
                        <tr><th>Procedure</th><th>Meaning</th><th>Key Elements Recorded</th></tr>
                        <tr><td><strong>Darta (Registration)</strong></td><td>Recording all incoming official letters and petitions.</td><td>Darta number, Date received, Sender name/office, Subject, Attached documents, Assigned branch.</td></tr>
                        <tr><td><strong>Chalani (Dispatch)</strong></td><td>Recording all outgoing correspondence.</td><td>Chalani number, Date dispatched, Recipient name/office, Subject, Mode of transmission, Signature of dispatch clerk.</td></tr>
                    </table>

                    <h2>4. Official Note (Tippani) Writing</h2>
                    <p>Tippani is an administrative memo prepared by a subordinate officer presenting facts, relevant laws, previous precedents, and alternative solutions for decision-making by a higher authority.</p>
                    <div class="key-point">
                        <strong>Rule:</strong> Tippani must be objective, concise, cite specific legal clauses, and offer clear recommendations without bias.
                    </div>
                ',
            ],
            'nayab-subba-gk-notes' => [
                'title' => 'Nayab Subba - General Studies & Governance Overview',
                'subtitle' => 'Integrated First Paper Study Material for Public Service Commission Examination',
                'html' => '
                    <h2>1. Constitutional & Administrative Evolution of Nepal</h2>
                    <p>Nepal has promulgated seven constitutions in its history: 2004, 2007, 2015, 2019 (Panchayat), 2047, 2063 (Interim), and 2072 (Current Federal Constitution).</p>
                    
                    <h2>2. Administrative Tiers of the Federal State</h2>
                    <table>
                        <tr><th>Level</th><th>Executive Body</th><th>Legislative Body</th><th>Key Jurisdictions</th></tr>
                        <tr><td><strong>Federal</strong></td><td>Government of Nepal (Cabinet)</td><td>Federal Parliament (House of Reps + National Assembly)</td><td>Defense, foreign relations, central currency/banking, national highways.</td></tr>
                        <tr><td><strong>Provincial (7)</strong></td><td>Provincial Council of Ministers</td><td>Provincial Assembly (Pradesh Sabha)</td><td>Provincial police, state civil service, provincial taxation, state projects.</td></tr>
                        <tr><td><strong>Local (753)</strong></td><td>Municipality / Rural Municipality Executive</td><td>Municipal / Village Assembly</td><td>Basic health & education, local taxes, drinking water, local disaster management.</td></tr>
                    </table>

                    <h2>3. Current Affairs & Socio-Economic Indicators</h2>
                    <ul>
                        <li><strong>Economic Structure:</strong> Services contribute ~55% of GDP, Agriculture ~25%, and Industry ~15%.</li>
                        <li><strong>Remittance:</strong> Accounts for approximately 25% of national GDP, sustaining consumption and foreign exchange reserves.</li>
                        <li><strong>International Membership:</strong> UN (admitted Dec 14, 1955), SAARC (founding member, HQ Kathmandu), BIMSTEC, WTO (admitted 2004).</li>
                    </ul>
                ',
            ],
            'nayab-subba-iq-notes' => [
                'title' => 'Nayab Subba - General Mental Ability & Reasoning (IQ)',
                'subtitle' => 'Techniques, Shortcuts, and Pattern Identification for Verbal and Numerical Aptitude',
                'html' => '
                    <h2>1. Verbal Reasoning & Analogy Analysis</h2>
                    <p>Aptitude testing assesses logical deductive reasoning, pattern recognition, and conceptual relationships under time constraints.</p>
                    <ul>
                        <li><strong>Relationship Categories:</strong> Worker & Tool (Surgeon : Scalpel), Cause & Effect (Deforestation : Landslide), Whole & Part (Clock : Hands).</li>
                        <li><strong>Coding-Decoding Methods:</strong> Fixed numerical displacement (+1, +2, -3), reverse positional substitution (A=26, Z=1), or vowel/consonant modular shifts.</li>
                    </ul>

                    <h2>2. Number & Alphabetical Series Shortcuts</h2>
                    <div class="highlight-box">
                        <strong>Formula for Arithmetic Progression:</strong> Sum of first n natural numbers = n(n + 1) / 2.<br>
                        <strong>Sum of Squares:</strong> n(n + 1)(2n + 1) / 6.
                    </div>
                    <table>
                        <tr><th>Pattern Type</th><th>Example Series</th><th>Logic / Rule</th></tr>
                        <tr><td>Difference of Differences</td><td>2, 5, 10, 17, 26, ? (Answer: 37)</td><td>Differences are 3, 5, 7, 9, 11 (consecutive odd numbers).</td></tr>
                        <tr><td>Geometric Multiplier</td><td>3, 6, 18, 72, 360, ? (Answer: 2160)</td><td>Multipliers are x2, x3, x4, x5, x6.</td></tr>
                        <tr><td>Alternating Dual Series</td><td>1, 10, 3, 20, 5, 30, ? (Answer: 7)</td><td>Odd positions increment by +2; even positions increment by +10.</td></tr>
                    </table>
                ',
            ],
            'nayab-subba-admin-notes' => [
                'title' => 'Nayab Subba - General Administration & Financial Procedures',
                'subtitle' => 'Civil Service Ethics, Government Accounting, and Financial Administration',
                'html' => '
                    <h2>1. Public Administration & Bureaucracy Fundamentals</h2>
                    <p>Public administration is the execution of public laws and policies. Max Weber outlined the characteristics of ideal bureaucracy: hierarchical command, written documentation, specialized jurisdiction, merit-based career tenure, and impersonal rule application.</p>

                    <h2>2. Government Accounting Principles</h2>
                    <ul>
                        <li><strong>Fiscal Cycle:</strong> Runs from Shrawan 1 to Ashadh end (mid-July to mid-July).</li>
                        <li><strong>Single Treasury Account (TSA):</strong> All government receipts and expenditures flow through the Treasury Single Account managed by Financial Comptroller General Office (FCGO).</li>
                        <li><strong>Beruju (Audit Observations):</strong> Financial transactions carried out contrary to prevailing laws, without proper authorization, or lacking required supporting documents.</li>
                    </ul>

                    <h2>3. Civil Service Code of Conduct</h2>
                    <p>Under the Civil Service Act, civil servants must maintain:</p>
                    <ul>
                        <li>Punctuality, regularity, and discipline</li>
                        <li>Political neutrality and impartiality</li>
                        <li>Strict confidentiality of state secrets</li>
                        <li>Prohibition on accepting gifts, gratification, or taking secondary commercial employment without permission</li>
                    </ul>
                ',
            ],
            'section-officer-governance-notes' => [
                'title' => 'Section Officer - Governance System & Statecraft',
                'subtitle' => 'Paper II: Modern Public Management, Administrative Federalism, and Accountability',
                'html' => '
                    <h2>1. New Public Management (NPM) Paradigm</h2>
                    <p>Originating in the 1980s, NPM revolutionized traditional public administration by incorporating private-sector management principles into government operations.</p>
                    <table>
                        <tr><th>Dimension</th><th>Traditional Public Administration</th><th>New Public Management (NPM)</th></tr>
                        <tr><td><strong>Primary Focus</strong></td><td>Strict compliance with rules and procedures</td><td>Achieving measurable results and outcomes</td></tr>
                        <tr><td><strong>Citizen View</strong></td><td>Passive subjects / applicants</td><td>Customers / empowered service recipients</td></tr>
                        <tr><td><strong>Organizational Structure</strong></td><td>Rigid, centralized hierarchies</td><td>Decentralized, autonomous agency units</td></tr>
                        <tr><td><strong>Accountability</strong></td><td>Procedural and hierarchical</td><td>Performance-based and contractual</td></tr>
                    </table>

                    <h2>2. The 8 Principles of Good Governance (UNDP Framework)</h2>
                    <ol>
                        <li><strong>Participation:</strong> Citizen involvement in policy formulation and decision-making.</li>
                        <li><strong>Rule of Law:</strong> Fair legal frameworks enforced impartially.</li>
                        <li><strong>Transparency:</strong> Information is freely accessible and understandable.</li>
                        <li><strong>Responsiveness:</strong> Institutions serve all stakeholders within reasonable timeframes.</li>
                        <li><strong>Consensus Orientation:</strong> Mediation of differing interests to reach broad societal agreement.</li>
                        <li><strong>Equity and Inclusiveness:</strong> All members feel they have a stake in society.</li>
                        <li><strong>Effectiveness and Efficiency:</strong> Optimal resource utilization meeting public needs.</li>
                        <li><strong>Accountability:</strong> Public and private entities are answerable to the public.</li>
                    </ol>
                ',
            ],
            'section-officer-contemporary-issues-notes' => [
                'title' => 'Section Officer - Contemporary Issues & Development Challenges',
                'subtitle' => 'Paper III: Economic Policies, SDGs, and Environmental Resilience in Nepal',
                'html' => '
                    <h2>1. Sustainable Development Goals (SDGs) & LDC Graduation</h2>
                    <p>Nepal has committed to achieving the 17 UN Sustainable Development Goals by 2030 and graduating from the Least Developed Country (LDC) category by 2026.</p>
                    <div class="highlight-box">
                        <strong>Three Criteria for LDC Graduation:</strong>
                        <ol>
                            <li>Gross National Income (GNI) per capita</li>
                            <li>Human Assets Index (HAI) — nutrition, health, school enrollment, literacy</li>
                            <li>Economic & Environmental Vulnerability Index (EVI) — natural disasters, export instability</li>
                        </ol>
                    </div>

                    <h2>2. Remittance Economy & Labor Migration Dynamics</h2>
                    <p>Foreign employment provides vital livelihood support but brings economic vulnerabilities such as Dutch Disease (currency appreciation hampering export competitiveness), agricultural land abandonment, and loss of skilled human capital.</p>

                    <h2>3. Climate Change & Disaster Risk Reduction</h2>
                    <p>Nepal ranks among the most climate-vulnerable countries due to fragile Himalayan geology. Key priorities include mitigating Glacial Lake Outburst Floods (GLOFs), preserving the Chure range, and expanding clean renewable energy exports.</p>
                ',
            ],
            'section-officer-admin-law-notes' => [
                'title' => 'Section Officer - Administrative Law & Jurisprudence',
                'subtitle' => 'Principles of Natural Justice, Judicial Review, and Constitutional Writs',
                'html' => '
                    <h2>1. Principles of Natural Justice</h2>
                    <p>Fundamental legal rules protecting citizens against arbitrary executive decisions:</p>
                    <ul>
                        <li><strong>Nemo Judex In Causa Sua:</strong> No person shall be a judge in their own cause (Rule against bias).</li>
                        <li><strong>Audi Alteram Partem:</strong> Hear the other side (Right to fair notice and opportunity to present defense before adverse action).</li>
                        <li><strong>Speaking Orders (Reasoned Decisions):</strong> Administrative bodies must state the reasons behind their decisions.</li>
                    </ul>

                    <h2>2. Extraordinary Jurisdiction of Higher Courts (Writs)</h2>
                    <table>
                        <tr><th>Writ</th><th>Latin Meaning</th><th>Purpose / Application</th></tr>
                        <tr><td><strong>Habeas Corpus</strong></td><td>You have the body</td><td>Release of individuals illegally detained by executive or private bodies.</td></tr>
                        <tr><td><strong>Mandamus</strong></td><td>We command</td><td>Compelling a public official to perform a mandatory statutory duty.</td></tr>
                        <tr><td><strong>Certiorari</strong></td><td>To be informed</td><td>Quashing decisions of inferior courts or tribunals that exceeded jurisdiction.</td></tr>
                        <tr><td><strong>Prohibition</strong></td><td>To forbid</td><td>Preventing a lower body from continuing illegal or unauthorized proceedings.</td></tr>
                        <tr><td><strong>Quo Warranto</strong></td><td>By what authority</td><td>Challenging an individual\'s legal right to hold a public office.</td></tr>
                    </table>
                ',
            ],
            'nrb-officer-economics-notes' => [
                'title' => 'NRB Officer - Macroeconomics & Banking Systems',
                'subtitle' => 'Comprehensive Economic Theories, National Accounting, and Central Banking',
                'html' => '
                    <h2>1. National Income Accounting & GDP Measurement</h2>
                    <p>Gross Domestic Product (GDP) measures the total monetary value of all finished goods and services produced within a country in a specific time period.</p>
                    <ul>
                        <li><strong>Expenditure Method:</strong> GDP = C + I + G + (X - M) where C=Consumption, I=Investment, G=Government purchases, X=Exports, M=Imports.</li>
                        <li><strong>Income Method:</strong> Sum of compensation of employees, gross operating surplus, gross mixed income, and taxes less subsidies on production.</li>
                        <li><strong>Output / Value Added Method:</strong> Gross value of output minus value of intermediate consumption across all economic sectors.</li>
                    </ul>

                    <h2>2. The IS-LM Framework</h2>
                    <p>The IS-LM model describes the simultaneous equilibrium of goods and money markets:</p>
                    <ul>
                        <li><strong>IS Curve (Goods Market):</strong> Represents combinations of interest rates and output where Investment equals Savings (I = S). Slopes downward.</li>
                        <li><strong>LM Curve (Money Market):</strong> Represents combinations where Money Demand equals Money Supply (L = M). Slopes upward.</li>
                        <li><strong>Equilibrium:</strong> The intersection point determines the equilibrium interest rate (r*) and national output (Y*).</li>
                    </ul>

                    <h2>3. Classification of Financial Institutions in Nepal</h2>
                    <table>
                        <tr><th>Class</th><th>Category</th><th>Minimum Paid-up Capital</th><th>Core Authorized Functions</th></tr>
                        <tr><td><strong>Class A</strong></td><td>Commercial Banks</td><td>NPR 8 Billion</td><td>Full banking, foreign exchange, trade financing (LC/Guarantees), underwriting.</td></tr>
                        <tr><td><strong>Class B</strong></td><td>Development Banks</td><td>NPR 2.5 Billion (National)</td><td>Development loans, retail deposits, project finance.</td></tr>
                        <tr><td><strong>Class C</strong></td><td>Finance Companies</td><td>NPR 800 Million (National)</td><td>Hire-purchase, leasing, term deposits, consumer finance.</td></tr>
                        <tr><td><strong>Class D</strong></td><td>Microfinance Institutions</td><td>NPR 100-200 Million</td><td>Collateral-free group loans, rural micro-savings, poverty alleviation.</td></tr>
                    </table>
                ',
            ],
            'nrb-officer-banking-notes' => [
                'title' => 'NRB Officer - Banking Operations & Prudential Directives',
                'subtitle' => 'Credit Management, Asset Classification, and Non-Performing Assets (NPA)',
                'html' => '
                    <h2>1. Loan Classification & Provisioning Norms (NRB Directives)</h2>
                    <table>
                        <tr><th>Loan Category</th><th>Overdue Period</th><th>Required Loan Loss Provision</th></tr>
                        <tr><td><strong>Pass (Good)</strong></td><td>Overdue up to 1 month</td><td>1.25% (or as mandated by latest directive)</td></tr>
                        <tr><td><strong>Watchlist</strong></td><td>Overdue 1 to 3 months</td><td>5%</td></tr>
                        <tr><td><strong>Substandard (NPA)</strong></td><td>Overdue 3 to 6 months</td><td>25%</td></tr>
                        <tr><td><strong>Doubtful (NPA)</strong></td><td>Overdue 6 months to 1 year</td><td>50%</td></tr>
                        <tr><td><strong>Loss (NPA)</strong></td><td>Overdue over 1 year or defaulted</td><td>100%</td></tr>
                    </table>

                    <h2>2. Key Prudential Ratios</h2>
                    <ul>
                        <li><strong>Credit-to-Deposit (CD) Ratio:</strong> Maximum limit set at 90% to prevent over-leveraging and maintain liquidity.</li>
                        <li><strong>Capital Adequacy Ratio (CAR):</strong> Commercial banks must maintain a minimum Total CAR of 11% (with Common Equity Tier 1 at least 7%).</li>
                        <li><strong>Cash Reserve Ratio (CRR):</strong> Mandatory reserve ratio held as cash with NRB (typically 4% for commercial banks).</li>
                        <li><strong>Statutory Liquidity Ratio (SLR):</strong> Minimum 12% in liquid assets and government securities.</li>
                    </ul>
                ',
            ],
            'nrb-ad-banking-law-notes' => [
                'title' => 'NRB Assistant Director - Banking Law & Regulatory Framework',
                'subtitle' => 'Nepal Rastra Bank Act 2058, BAFIA 2073, and Anti-Money Laundering Regulations',
                'html' => '
                    <h2>1. Nepal Rastra Bank Act, 2058 (2002)</h2>
                    <p>Section 4 of the NRB Act states the foundational objectives of Nepal\'s central bank:</p>
                    <ol>
                        <li>To formulate and manage monetary and foreign exchange policies to maintain price and balance of payments stability for sustainable economic development.</li>
                        <li>To promote stability and healthy growth of banking and financial systems.</li>
                        <li>To develop and supervise a secure, healthy, and efficient payment system.</li>
                    </ol>

                    <h2>2. Bank and Financial Institutions Act (BAFIA), 2073</h2>
                    <p>Provides the comprehensive legal regime governing incorporation, licensing, board governance, mergers and acquisitions, capital structure, and liquidation of BFIs in Nepal.</p>
                    <ul>
                        <li><strong>Board Composition:</strong> Maximum 7 directors, including at least one independent director possessing required expertise.</li>
                        <li><strong>Tenure Limitation:</strong> Directors and CEOs can serve a maximum of two consecutive terms (4 years per term).</li>
                    </ul>

                    <h2>3. Anti-Money Laundering (AML/CFT) Framework</h2>
                    <p>Regulated by the Asset (Money) Laundering Prevention Act, 2064 and NRB Directive 19:</p>
                    <ul>
                        <li><strong>KYC / CDD:</strong> Mandatory Customer Due Diligence, enhanced due diligence for Politically Exposed Persons (PEPs).</li>
                        <li><strong>STR / TTR Reporting:</strong> Suspicious Transaction Reports (STR) and Threshold Transaction Reports (TTR for amounts >= 1 Million NPR) must be filed with the Financial Information Unit (FIU-Nepal).</li>
                        <li><strong>Record Retention:</strong> All customer identification and transaction records must be retained for at least 5 years following account closure.</li>
                    </ul>
                ',
            ],
            'nrb-ad-monetary-policy-notes' => [
                'title' => 'NRB Assistant Director - Monetary Policy Formulation & Instruments',
                'subtitle' => 'Central Bank Policy Stance, Transmission Channels, and Exchange Rate Policy',
                'html' => '
                    <h2>1. Monetary Policy Instruments of Nepal Rastra Bank</h2>
                    <table>
                        <tr><th>Instrument Category</th><th>Specific Tool</th><th>Mechanism of Action</th></tr>
                        <tr><td rowspan="3"><strong>Direct Instruments</strong></td><td>Interest Rate Corridor (IRC)</td><td>Sets policy rate, repo rate, and standing liquidity facility ceiling.</td></tr>
                        <tr><td>Statutory Cash Reserves (CRR)</td><td>Fixes mandatory non-interest earning reserves deposited at NRB.</td></tr>
                        <tr><td>Statutory Liquidity Ratio (SLR)</td><td>Enforces minimum holding of government bonds and treasury bills.</td></tr>
                        <tr><td rowspan="3"><strong>Indirect / Market Tools</strong></td><td>Open Market Operations (OMO)</td><td>Outright purchase/sale of bonds and repo/reverse repo auctions.</td></tr>
                        <tr><td>Standing Liquidity Facility (SLF)</td><td>Short-term emergency borrowing window for commercial banks.</td></tr>
                        <tr><td>Foreign Exchange Swap Auctions</td><td>Managing foreign exchange liquidity without distorting domestic base money.</td></tr>
                    </table>

                    <h2>2. Exchange Rate Peg Regime</h2>
                    <p>Nepal maintains a conventional fixed peg of the Nepali Rupee to the Indian Rupee at a fixed rate of NPR 160 per INR 100 (1.6 : 1). This provides a nominal monetary anchor, mitigating currency volatility given that India accounts for two-thirds of Nepal\'s foreign trade.</p>
                ',
            ],
            'nrb-ad-corporate-governance-notes' => [
                'title' => 'NRB Assistant Director - Corporate Governance & Risk Management',
                'subtitle' => 'Board Oversight, Basel III Risk Management, and Prudential Supervisory Framework',
                'html' => '
                    <h2>1. Corporate Governance Directives for BFIs</h2>
                    <p>NRB Unified Directives enforce rigorous governance standards to eliminate conflict of interest and safeguard public deposits:</p>
                    <ul>
                        <li><strong>Separation of Ownership & Management:</strong> Significant shareholders cannot hold managerial or operational positions without regulatory approval.</li>
                        <li><strong>Audit Committee:</strong> Mandatory board-level committee chaired by an independent director.</li>
                        <li><strong>Risk Management Committee:</strong> Dedicated oversight committee overseeing credit, liquidity, market, and operational risks.</li>
                    </ul>

                    <h2>2. Basel III Three-Pillar Framework</h2>
                    <ol>
                        <li><strong>Pillar 1 — Minimum Capital Requirements:</strong> Credit risk (Standardized Approach), Market risk, and Operational risk capital buffers.</li>
                        <li><strong>Pillar 2 — Supervisory Review Process (ICAAP):</strong> Internal Capital Adequacy Assessment Process evaluating residual risks and stress test resilience.</li>
                        <li><strong>Pillar 3 — Market Discipline:</strong> Mandatory quarterly public disclosures of capital structure, NPAs, and risk exposures.</li>
                    </ol>
                ',
            ],
            'constitution-2072-notes' => [
                'title' => 'Constitution of Nepal 2072 - Essential Legal Digest',
                'subtitle' => 'Comprehensive Summary of 35 Parts, 308 Articles, and 9 Schedules',
                'html' => '
                    <h2>1. Overview and Structural Framework</h2>
                    <p>Promulgated by the Constituent Assembly on September 20, 2015 (Ashoj 3, 2072 BS), the Constitution of Nepal 2072 is the supreme law of the land.</p>

                    <h2>2. Fundamental Rights (Part 3, Articles 16-46)</h2>
                    <p>Guarantees 31 distinct fundamental rights, making it one of the most progressive human rights charters in South Asia:</p>
                    <table>
                        <tr><th>Article</th><th>Fundamental Right</th><th>Key Scope & Guarantee</th></tr>
                        <tr><td>Art 16</td><td>Right to Live with Dignity</td><td>No law shall provide for the death penalty.</td></tr>
                        <tr><td>Art 17</td><td>Right to Freedom</td><td>Freedom of opinion, assembly, association, movement, occupation.</td></tr>
                        <tr><td>Art 18</td><td>Right to Equality</td><td>Equality before law; no discrimination based on gender, caste, religion.</td></tr>
                        <tr><td>Art 19</td><td>Right to Communication</td><td>No prior censorship; publication medium shall not be closed or seized.</td></tr>
                        <tr><td>Art 25</td><td>Right to Property</td><td>Right to acquire, own, transfer, and dispose of property.</td></tr>
                        <tr><td>Art 27</td><td>Right to Information</td><td>Right to seek and receive information on public interest matters.</td></tr>
                        <tr><td>Art 31</td><td>Right to Education</td><td>Free and compulsory education up to basic level; free up to secondary.</td></tr>
                        <tr><td>Art 35</td><td>Right to Health Care</td><td>Basic health services free of charge from the state.</td></tr>
                    </table>

                    <h2>3. Constitutional Commissions (Part 21-27)</h2>
                    <p>Established as independent oversight bodies: Commission for the Investigation of Abuse of Authority (CIAA), Auditor General, Public Service Commission (PSC), Election Commission, National Human Rights Commission (NHRC), National Natural Resources and Fiscal Commission (NNRFC), National Women Commission, Indigenous Nationalities Commission, and Madhesi Commission.</p>
                ',
            ],
            'good-governance-act-notes' => [
                'title' => 'Good Governance & Right to Information Acts',
                'subtitle' => 'Administrative Accountability, Citizen Charter, and Transparency Laws',
                'html' => '
                    <h2>1. Good Governance (Management & Operation) Act, 2064</h2>
                    <p>Enacted to make public administration result-oriented, corruption-free, transparent, and accountable to sovereign citizens.</p>
                    <ul>
                        <li><strong>Citizen\'s Charter (Section 25):</strong> Every government office must prominently display a Citizen\'s Charter specifying service names, required documents, processing fees, decision timelines, and designated responsible officers.</li>
                        <li><strong>Public Hearing (Section 30):</strong> Mandatory public hearings for local development projects and service delivery evaluation.</li>
                        <li><strong>Grievance Redressal (Section 31):</strong> Complaint box and officer assigned; acknowledgment within 3 days and resolution within 15 days.</li>
                    </ul>

                    <h2>2. Right to Information (RTI) Act, 2064</h2>
                    <ul>
                        <li><strong>Information Officer:</strong> Every public body must designate an Information Officer to facilitate citizen access.</li>
                        <li><strong>Timeline:</strong> Information must be provided within 15 days of application (or within 24 hours if it concerns individual life and liberty).</li>
                        <li><strong>Appellate Authority:</strong> Appeals go to the head of office, and further to the independent National Information Commission (NIC).</li>
                    </ul>
                ',
            ],
            'computer-skill-test-notes' => [
                'title' => 'Computer Skill Test - Practical Handbook',
                'subtitle' => 'MS Word, MS Excel Formulas, Windows Navigation, and Unicode Nepali Typing',
                'html' => '
                    <h2>1. Word Processing (MS Word) Competencies</h2>
                    <ul>
                        <li><strong>Document Formatting:</strong> Page margins (A4, 1 inch margins), orientation, line spacing (1.15 / 1.5), paragraph indentations, drop caps, header/footer page numbering.</li>
                        <li><strong>Tables & Objects:</strong> Inserting tables, cell merging, splitting, border customization, watermarks, and mail merge.</li>
                        <li><strong>Keyboard Shortcuts:</strong> Ctrl+S (Save), Ctrl+P (Print), Ctrl+F (Find), Ctrl+H (Replace), Ctrl+K (Hyperlink), Ctrl+Z/Y (Undo/Redo).</li>
                    </ul>

                    <h2>2. Spreadsheet (MS Excel) Functions & Data Analysis</h2>
                    <table>
                        <tr><th>Function Category</th><th>Formula Syntax</th><th>Practical Application</th></tr>
                        <tr><td><strong>Sum & Average</strong></td><td>=SUM(B2:B20), =AVERAGE(C2:C20)</td><td>Aggregating financial expenditure and calculating average scores.</td></tr>
                        <tr><td><strong>Conditional Logic</strong></td><td>=IF(D2>=40, "Pass", "Fail")</td><td>Automated grading and status evaluation.</td></tr>
                        <tr><td><strong>Lookup</strong></td><td>=VLOOKUP(lookup_val, range, col, FALSE)</td><td>Retrieving salary or employee data by ID reference.</td></tr>
                        <tr><td><strong>Counting</strong></td><td>=COUNTIF(E2:E50, ">1000")</td><td>Counting records satisfying specific conditions.</td></tr>
                    </table>

                    <h2>3. Nepali Unicode Typing</h2>
                    <p>Public Service Commission computer tests require proficiency in Nepali Unicode typing (Romanized or Traditional layout) aiming for a minimum speed of 25+ words per minute with 95%+ accuracy.</p>
                ',
            ],
            'iq-aptitude-notes' => [
                'title' => 'IQ & Aptitude - Complete Problem Solving Toolkit',
                'subtitle' => 'Verbal, Non-Verbal, Logical Deduction, and Mathematical Reasoning Methods',
                'html' => '
                    <h2>1. Logical & Relational Reasoning</h2>
                    <ul>
                        <li><strong>Blood Relations:</strong> Deciphering generational hierarchies. Standard notation: [=] for marriage, [|] for descent, [+] for male, [-] for female.</li>
                        <li><strong>Direction Sense Test:</strong> 8-point compass navigation. Right turn from North leads to East; right turn from East leads to South. Pythagorean theorem for shortest distance (h² = p² + b²).</li>
                        <li><strong>Venn Diagrams & Set Logic:</strong> Visual deduction of categorical syllogisms (All A are B, Some B are C).</li>
                    </ul>

                    <h2>2. Numerical Reasoning Shortcuts</h2>
                    <div class="highlight-box">
                        <strong>Percentage & Profit/Loss:</strong> Selling Price = Cost Price x (100 + Profit%) / 100.<br>
                        <strong>Speed, Time & Distance:</strong> Speed = Distance / Time. To convert km/h to m/s, multiply by 5/18.
                    </div>
                ',
            ],
            'logical-reasoning-notes' => [
                'title' => 'Logical Reasoning & Analytical Thinking',
                'subtitle' => 'Matrix Reasoning, Figure Classification, and Critical Deduction',
                'html' => '
                    <h2>1. Non-Verbal & Matrix Reasoning</h2>
                    <p>Analyzes geometric transitions across rotation (clockwise / counter-clockwise 45°, 90°, 180°), reflection, element addition/deletion, and symmetry.</p>

                    <h2>2. Critical Thinking & Statement-Conclusion Logic</h2>
                    <ul>
                        <li><strong>Premise Validity:</strong> Assume given statements are 100% true, regardless of real-world facts.</li>
                        <li><strong>Definite vs Probable Conclusions:</strong> A conclusion must strictly and necessarily follow from the premises without external assumptions.</li>
                    </ul>
                ',
            ],
        ];

        foreach ($pdfs as $filename => $doc) {
            $pdf = new PdfGenerator;
            $pdf->setTitle($doc['title']);
            $pdf->setSubtitle($doc['subtitle']);
            $pdf->setHtmlContent($doc['html']);
            $pdf->save("{$this->pdfBasePath}/{$filename}.pdf");
        }

        $this->command->info('   ✅ '.count($pdfs).' high-quality researched study PDFs generated with DomPDF');
    }
}
