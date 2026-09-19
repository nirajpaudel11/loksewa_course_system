<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Database\Seeders\Helpers\SectionOfficerQuizBank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SectionOfficerCourseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🎓 Seeding Section Officer (Gazetted Third Class) Course with Unified Syllabus...');

        $course = $this->seedSectionOfficerCourse();
        SectionOfficerQuizBank::attachQuestionsToAllLessons($course);

        $modulesCount = $course->modules()->count();
        $chaptersCount = Chapter::whereIn('module_id', $course->modules()->pluck('id'))->count();
        $lessonsCount = Lesson::whereIn('module_id', $course->modules()->pluck('id'))->count();

        $this->command->info("   ✅ Updated Section Officer Course: {$modulesCount} modules, {$chaptersCount} chapters, and {$lessonsCount} lessons (10 MCQs per lesson).");
    }

    public function seedSectionOfficerCourse(): Course
    {
        // Find existing course by slug
        $course = Course::whereIn('slug', ['section-officer-tayari', 'section-officer'])->first();

        $thumbnail = $course?->thumbnail ?? 'course-thumbnails/01M18FZRMP2H3N5T3CX61JRD9S.jpg';

        if ($course) {
            // Clean up existing modules and lessons to replace with comprehensive English curriculum
            foreach ($course->modules as $mod) {
                foreach ($mod->chapters as $chap) {
                    $chap->lessons()->delete();
                }
                $mod->chapters()->delete();
                $mod->lessons()->delete();
            }
            $course->modules()->delete();

            $course->update([
                'title' => 'Section Officer Tayari (Gazetted Third Class)',
                'slug' => 'section-officer-tayari',
                'description' => 'Comprehensive preparation course for Section Officer (Gazetted Third Class - Administration, Foreign Affairs, Audit, and Parliament Services) under the Public Service Commission (Lok Sewa Aayog) Integrated & Unified Examination System. Complete English curriculum covering Stage I (General Awareness, Aptitude Test & Reasoning, English Language Competence) and Stage II (Governance Systems, Contemporary Issues, and Service-Related Administration & Law).',
                'level' => 'advanced',
                'thumbnail' => $thumbnail,
                'is_published' => true,
            ]);
        } else {
            $course = Course::create([
                'title' => 'Section Officer Tayari (Gazetted Third Class)',
                'slug' => 'section-officer-tayari',
                'description' => 'Comprehensive preparation course for Section Officer (Gazetted Third Class - Administration, Foreign Affairs, Audit, and Parliament Services) under the Public Service Commission (Lok Sewa Aayog) Integrated & Unified Examination System. Complete English curriculum covering Stage I (General Awareness, Aptitude Test & Reasoning, English Language Competence) and Stage II (Governance Systems, Contemporary Issues, and Service-Related Administration & Law).',
                'level' => 'advanced',
                'thumbnail' => $thumbnail,
                'is_published' => true,
            ]);
        }

        $modulesData = $this->getModulesData();

        foreach ($modulesData as $mIdx => $moduleData) {
            $module = Module::create([
                'course_id' => $course->id,
                'title' => $moduleData['title'],
                'slug' => Str::slug($moduleData['title']).'-'.$course->id,
                'description' => $moduleData['description'] ?? null,
                'notes' => $moduleData['notes'] ?? null,
                'key_points' => $moduleData['key_points'] ?? null,
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
                        'module_id' => $module->id,
                        'chapter_id' => $chapter->id,
                        'title' => $lessonData['title'],
                        'slug' => Str::slug($lessonData['title']).'-'.$chapter->id,
                        'type' => $lessonData['type'],
                        'content' => $lessonData['content'] ?? null,
                        'order' => $lIdx + 1,
                        'duration_minutes' => $lessonData['duration_minutes'] ?? 25,
                        'is_published' => true,
                    ]);
                }
            }
        }

        return $course;
    }

    private function getModulesData(): array
    {
        return [
            // =========================================================================
            // MODULE 1: PAPER I - GENERAL AWARENESS (PART A - 50 MARKS)
            // =========================================================================
            [
                'title' => 'Paper I: General Awareness (AAT Part A - 50 Marks)',
                'description' => 'Comprehensive General Awareness covering World and Nepal Geography, World History, Nepalese History & Culture, Polity & Governance, Economic Development, Environment & Climate Change, Science & Technology, and International Affairs.',
                'notes' => 'Covers all 8 dimensions of the General Awareness syllabus (Units 1.1 to 1.8) for the Administrative Aptitude Test (AAT).',
                'key_points' => "• Physical, Social & Economic Geography of Nepal and the World\n• Ancient, Medieval & Modern History and Democratic Movements of Nepal\n• Constitution, Governance System & Public Administration Evolution\n• Macroeconomic Planning, Periodic Plans, Sustainable Development & Climate Action\n• Science, Technology, SAARC & Multilateral International Institutions",
                'chapters' => [
                    [
                        'title' => '1. Geography, History, Culture & Governance in General Awareness',
                        'description' => 'Fundamental physical and socio-cultural foundations of Nepal and global civilizations.',
                        'lessons' => [
                            [
                                'title' => '1.1 Physical, Social and Economic Geography of Nepal and the World',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Global Physical Geography</h3>
<p>The Earth\'s surface is divided into 7 continents (Asia, Africa, North America, South America, Antarctica, Europe, Australia) and 5 major oceans (Pacific, Atlantic, Indian, Southern, Arctic). Key atmospheric circulation systems include Trade Winds (blowing between Subtropical Highs and the Equator), Westerlies, and Polar Easterlies. The rotation of the Earth from West to East generates a solar time variation of <strong>4 minutes for every 1 degree of longitude</strong> (15° = 1 hour).</p>

<h3>2. Physiography and River Basins of Nepal</h3>
<p>Total land area: <strong>147,516 sq. km</strong>. Three ecological belts:</p>
<ul>
    <li><strong>Himalayan Region (15%):</strong> Altitudes above 3,000m; 8 peaks exceeding 8,000m (Everest 8,848.86m, Kanchenjunga 8,586m, Lhotse, Makalu, Cho Oyu, Dhaulagiri, Manaslu, Annapurna I).</li>
    <li><strong>Hilly Region (68%):</strong> Altitudes 600m–3,000m; includes Mahabharat and Chure (Siwalik) mountain ranges, and fertile tectonic valleys (Kathmandu, Pokhara, Dang).</li>
    <li><strong>Terai Region (17%):</strong> Alluvial plain along the southern border with India; altitude 58m to 600m; agricultural breadbasket of Nepal.</li>
    <li><strong>Major River Systems:</strong> Koshi (largest discharge), Gandaki (deepest gorge at Dana/Kaligandaki), Karnali (longest at 507 km), and Mahakali (western frontier).</li>
</ul>',
                            ],
                            [
                                'title' => '1.2 World History, Nepalese History, Culture and Socio-Political Evolution',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Landmarks in World History</h3>
<ul>
    <li><strong>Magna Carta (1215 AD):</strong> Foundational charter signed by King John of England establishing supremacy of law over arbitrary royal power.</li>
    <li><strong>Industrial Revolution (c. 1760 AD):</strong> Began in Great Britain, replacing manual craft with steam-powered mechanized factory manufacturing.</li>
    <li><strong>French Revolution (1789 AD):</strong> Intellectual and social revolution inspired by Rousseau, Voltaire, and Montesquieu, enshrining "Liberty, Equality, Fraternity".</li>
    <li><strong>Indian Independence Movement (1919–1947 AD):</strong> Gandhian Era characterized by non-violent mass civil disobedience (Satyagraha).</li>
</ul>

<h3>2. History and Democratic Struggles of Nepal</h3>
<ul>
    <li><strong>Ancient & Medieval Periods:</strong> Kirat dynasty, Lichhavi golden age (Manadeva, Amshuverma), and Malla period in Kathmandu Valley (art, pagoda architecture, woodwork in Bhaktapur).</li>
    <li><strong>Modern Nepal:</strong> Unification by King Prithvi Narayan Shah (1743–1775 AD); Rana autocracy (1846–1951 AD) started by Jung Bahadur Rana after the Kot Massacre.</li>
    <li><strong>Democratic Movements:</strong> Revolution of 2007 BS (overthrow of Rana rule), Jana Andolan I of 2046 BS (multi-party democracy), and Jana Andolan II of 2062/63 BS (19-day movement leading to abolition of monarchy and federal republic).</li>
    <li><strong>Cultural Practices:</strong> 142 ethnic groups, 124 mother tongues, traditional mutual cooperation institutions like Dhikur (Thakali), Parma, and Guthi.</li>
</ul>',
                            ],
                            [
                                'title' => '1.3 Constitution of Nepal, Political Systems and Administrative Evolution',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Constitutional Framework (Constitution of Nepal 2072)</h3>
<p>Promulgated on Ashwin 3, 2072 BS (September 20, 2015 AD) by the Constituent Assembly. Comprises <strong>35 Parts, 308 Articles, and 9 Schedules</strong>.</p>
<ul>
    <li><strong>Sovereignty (Article 2):</strong> Inherent in the Nepali people.</li>
    <li><strong>Form of State (Article 4):</strong> Independent, indivisible, sovereign, secular, inclusive, democratic, socialism-oriented federal democratic republican state.</li>
    <li><strong>31 Fundamental Rights (Articles 16–46):</strong> Right to live with dignity, equality, clean environment, social justice, and constitutional remedies (Writs under Article 133).</li>
    <li><strong>Constitutional Bodies:</strong> CIAA (Part 21), Auditor General (Part 22), Public Service Commission (Part 23), Election Commission (Part 24), National Human Rights Commission (Part 26).</li>
</ul>

<h3>2. Evolution of Nepalese Public Administration</h3>
<p>Progressed from Rana feudal centralized rule (Mauja, Praganna, Jilla) to modern bureaucratic meritocracy post-2007 BS, administrative reform commissions (Buch Commission 2009, Administrative Reform Commission 2048), and three-tier federal governance (Federation, 7 Provinces, 753 Local Levels).</p>',
                            ],
                            [
                                'title' => '1.4 Economic Development, National Planning and Global Integration',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. National Planning in Nepal</h3>
<p>Initiated in 2013 BS (1956 AD). The <strong>16th Periodic Plan (FY 2081/82 – 2085/86)</strong> targets average economic growth of 7.0%–7.5% under the theme <em>"Good Governance, Social Justice, and Prosperity"</em>.</p>

<h3>2. Macroeconomic Fundamentals</h3>
<ul>
    <li><strong>Agriculture:</strong> Employs >60% workforce, contributes ~24% to GDP; priority on commercialization via Agriculture Development Strategy (ADS).</li>
    <li><strong>Remittance Economy:</strong> Inflows equal 22%–25% of GDP, sustaining foreign exchange reserves and private household consumption.</li>
    <li><strong>International Trade & WTO:</strong> Nepal acceded to the World Trade Organization on April 23, 2004; member of BIMSTEC and SAFTA. High merchandise trade deficit managed through remittances and service exports.</li>
</ul>',
                            ],
                            [
                                'title' => '1.5 Sustainable Development, Biodiversity, Climate Change and Environment',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Sustainable Development Goals (SDGs 2016–2030)</h3>
<p>17 Global Goals including SDG 1 (No Poverty), SDG 7 (Clean Energy), SDG 13 (Climate Action), and SDG 16 (Peace, Justice and Strong Institutions). Nepal targets graduating from LDC status by 2026.</p>

<h3>2. Climate Vulnerability and Environmental Action</h3>
<ul>
    <li><strong>Forest Cover:</strong> 45.31% of total national land area maintained as forest and wooded land.</li>
    <li><strong>Protected Areas:</strong> 12 National Parks (Shey-Phoksundo largest, Chitwan first), 1 Wildlife Reserve (Koshi Tappu), 6 Conservation Areas (ACAP largest), 1 Hunting Reserve (Dhorpatan).</li>
    <li><strong>Climate Commitments:</strong> Long-term strategy targeting Net-Zero greenhouse gas emissions by <strong>2045</strong>; disaster preparedness against GLOF risks and Himalayan seismic hazards.</li>
</ul>',
                            ],
                            [
                                'title' => '1.6 Science, Technology, International Relations and Multilateralism',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Science and Innovations</h3>
<p>Breakthroughs in DNA profiling, CRISPR-Cas9 gene editing, satellite remote sensing, renewable energy technologies, and artificial intelligence.</p>

<h3>2. Regional and Multilateral Affairs</h3>
<ul>
    <li><strong>SAARC:</strong> Secretariat in Kathmandu (established 1987); SAARC Tuberculosis Centre in Bhaktapur; SAARC Agriculture Centre in Dhaka; SAARC Energy Centre in Islamabad.</li>
    <li><strong>United Nations & Diplomacy:</strong> Nepal joined the UN on December 14, 1955; top contributor of troops to UN Peacekeeping Operations; foreign policy guided by Non-Alignment (NAM) and Panchasheel.</li>
</ul>',
                            ],
                        ],
                    ],
                ],
            ],

            // =========================================================================
            // MODULE 2: PAPER I - APTITUDE TEST & REASONING (PART B - 30 MARKS)
            // =========================================================================
            [
                'title' => 'Paper I: Aptitude Test & Reasoning (AAT Part B - 30 Marks)',
                'description' => 'Comprehensive aptitude testing covering Verbal Reasoning, Analytical & Logical Ability, Non-Verbal/Spatial Reasoning, Quantitative Arithmetic, and Data Interpretation.',
                'notes' => 'Covers all 5 core sections of Part B (Verbal, Non-Verbal, Quantitative, Mental Ability, and Data Interpretation) for Section Officer.',
                'key_points' => "• Verbal Series, Analogies, Coding-Decoding & Direction Sense\n• Logical Inference, Statement-Assumption, Cause-Effect & Syllogisms\n• Visual & Spatial Non-Verbal Intelligence, Venn Diagrams & Figure Matrices\n• Quantitative Arithmetic, Averages, Ratios, Profit-Loss & Work-Time\n• Tables, Bar Graphs, Pie Charts & Data Sufficiency Problem Solving",
                'chapters' => [
                    [
                        'title' => '1. Verbal, Logical, Quantitative & Spatial Reasoning',
                        'description' => 'Systematic mastery of verbal, analytical, numerical, and visual aptitude problem types.',
                        'lessons' => [
                            [
                                'title' => '2.1 Verbal Reasoning & Logical Problem Solving',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Verbal Series and Pattern Identification</h3>
<p>Analyzing progressive alphabetical, alphanumeric, and contextual sequences (e.g. O, T, T, F, F, S, S, E, N for One, Two, Three...).</p>

<h3>2. Coding-Decoding and Relationship Rules</h3>
<ul>
    <li>Letter shift coding, direct substitution, and reverse alphabet positioning (A=1/Z=26 vs Z=1/A=26).</li>
    <li>Direction and Distance Sense: Navigating cardinal and intercardinal compass directions with Pythagorean displacement calculations.</li>
    <li>Blood Relations & Ranking: Calculating positions from top/bottom using <code>Total = Rank_from_Top + Rank_from_Bottom - 1</code>.</li>
</ul>',
                            ],
                            [
                                'title' => '2.2 Analytical Reasoning, Assertion-Reason and Statement-Inference',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Assertion and Reason Frameworks</h3>
<p>Evaluating whether Assertion (A) and Reason (R) are factually true independently, and whether (R) is the valid causal explanation of (A).</p>

<h3>2. Cause and Effect Relationships</h3>
<p>Distinguishing between direct cause-effect pairs, common underlying causes, and independent coincidental events.</p>

<h3>3. Logical Syllogisms and Deductions</h3>
<p>Evaluating categorical propositions (Universal Affirmative "All", Universal Negative "No", Particular Affirmative "Some", Particular Negative "Some not") using Euler Venn diagrams.</p>',
                            ],
                            [
                                'title' => '2.3 Non-Verbal Reasoning, Spatial & Visual Intelligence',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Spatial Pattern Analysis</h3>
<ul>
    <li><strong>Figure Series & Analogy:</strong> Clockwise/Counter-clockwise rotational increments (45°, 90°, 135°), element addition/deletion, and inversion.</li>
    <li><strong>Mirror & Water Images:</strong> Mirror reflection produces horizontal lateral inversion (left-right swap); Water reflection produces vertical inversion (top-bottom swap).</li>
    <li><strong>Cubes and Dice Folding:</strong> Visualizing unfolded nets where alternate faces are strictly opposite.</li>
    <li><strong>Venn Diagram Representations:</strong> Translating conceptual relationships (e.g. Examinations, Questions, Practice) into intersecting/concentric geometric shapes.</li>
</ul>',
                            ],
                            [
                                'title' => '2.4 Quantitative Aptitude & Numerical Reasoning',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. High-Yield Quantitative Problem Archetypes</h3>
<ul>
    <li><strong>Averages & Weighted Means:</strong> <code>New Average = (Old Total + New Value) / New Count</code>.</li>
    <li><strong>Percentages & Overlaps:</strong> Minimum set intersection formula: <code>Overlap% = SetA% + SetB% - 100%</code>.</li>
    <li><strong>Ratio and Proportion:</strong> Dividing quantities proportionally (e.g. 5:4 ratio with difference 10 -> numbers are 50 and 40).</li>
    <li><strong>Combinatorics in Tournaments:</strong> Total games among n teams in double round-robin = <code>n * (n - 1)</code>.</li>
    <li><strong>Time and Work:</strong> Inverse proportion calculations for worker-day requirements.</li>
</ul>',
                            ],
                            [
                                'title' => '2.5 Data Interpretation & Data Sufficiency',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Interpreting Visual Data Representations</h3>
<ul>
    <li><strong>Tabular Analysis:</strong> Comparing cumulative scores, cut-off thresholds, and percentage distributions.</li>
    <li><strong>Line Graphs & Ratios:</strong> Analyzing Import/Export ratios (I/E < 1 indicates trade surplus where Exports > Imports).</li>
    <li><strong>Pie Charts:</strong> Calculating angular shares: <code>Angle = (Category Value / Total Value) * 360°</code>.</li>
    <li><strong>Data Sufficiency:</strong> Determining whether Statement 1 alone, Statement 2 alone, or both combined are necessary and sufficient to answer a problem.</li>
</ul>',
                            ],
                        ],
                    ],
                ],
            ],

            // =========================================================================
            // MODULE 3: PAPER I - ENGLISH LANGUAGE COMPETENCE (PART C - 20 MARKS)
            // =========================================================================
            [
                'title' => 'Paper I: English Language Competence (AAT Part C - 20 Marks)',
                'description' => 'Comprehensive English competence testing covering Reading Comprehension (5 Marks), Vocabulary Mastery (7 Marks), and Syntactic Ability & Grammar Mechanics (8 Marks).',
                'notes' => 'Designed to assess English proficiency across comprehension passages, contextual vocabulary, idiomatic expressions, and syntactic grammatical rules.',
                'key_points' => "• Reading Comprehension Passages, Inferential Questions & Core Themes\n• Advanced Vocabulary, Single-Word Substitutions, Synonyms & Antonyms\n• Idiomatic Expressions, Phrasal Verbs & Prepositional Collocations\n• Syntactic Concord, Subject-Verb Agreement & Tense Shifts\n• Voice Transformation, Reported Speech & Sentence Variety",
                'chapters' => [
                    [
                        'title' => '1. Reading Comprehension, Vocabulary & Syntax Mastery',
                        'description' => 'High-yield linguistic competence for Loksewa Section Officer examinations.',
                        'lessons' => [
                            [
                                'title' => '3.1 Reading Comprehension & Inferential Analysis',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Critical Reading Strategies for Loksewa</h3>
<ul>
    <li><strong>Skimming:</strong> Rapidly reading opening and closing topic sentences to identify the author\'s central thesis and tone.</li>
    <li><strong>Scanning:</strong> Targeted keyword search to extract specific factual dates, names, figures, and statistical data.</li>
    <li><strong>Inferential Reasoning:</strong> Interpreting implicit meanings, authorial intent, figurative metaphors, and contextual deductions.</li>
</ul>',
                            ],
                            [
                                'title' => '3.2 Advanced English Vocabulary, Synonyms & Antonyms',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Essential Loksewa Vocabulary Categories</h3>
<ul>
    <li><strong>Single Word Substitutions:</strong> Plutocracy (rule by wealthy), Altruist (unselfish helper), Apostate (renounces belief), Possessor (property owner), Orate (formal public address).</li>
    <li><strong>Contextual Nuances:</strong> Ephemeral (transient), Pugnacious (combative), Dysfunctional (impaired function), Fussy vs Easy-going.</li>
    <li><strong>Prefixes and Suffixes:</strong> Deriving noun, verb, and adjective forms systematically.</li>
</ul>',
                            ],
                            [
                                'title' => '3.3 Idiomatic Expressions, Phrasal Verbs & Derivatives',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. High-Yield Phrasal Verbs and Idioms</h3>
<ul>
    <li><strong>Stand up to:</strong> Withstand or resist courageously.</li>
    <li><strong>Bring up:</strong> Rear and educate children; or introduce a topic.</li>
    <li><strong>Call off:</strong> Cancel a scheduled operation.</li>
    <li><strong>Put up with:</strong> Tolerate adverse circumstances.</li>
    <li><strong>Legal Latin Terms:</strong> <em>Bona fide</em> (in good faith), <em>Prima facie</em> (at first sight), <em>De jure / De facto</em>.</li>
</ul>',
                            ],
                            [
                                'title' => '3.4 Syntactic Ability, Subject-Verb Agreement & Tenses',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Core Grammatical Rules</h3>
<ul>
    <li><strong>Proximity Rule in Agreement:</strong> In "Either... or" and "Neither... nor", the verb agrees with the closest subject (e.g. <em>Neither the manager nor the assistants <u>know</u></em>).</li>
    <li><strong>Prepositions of Time:</strong> Use "on" with days/dates (<em>on Tuesday</em>); "at" with festival periods (<em>at Christmas</em>) and clock times; "in" with months/years.</li>
    <li><strong>Modal Expressions:</strong> "Had better" takes bare infinitive (<em>They had better <u>stop</u> smoking</em>).</li>
    <li><strong>Gerund Verbs:</strong> "Have trouble / difficulty" takes gerund (<em>trouble <u>remembering</u> password</em>).</li>
</ul>',
                            ],
                            [
                                'title' => '3.5 Sentence Transformations, Voice, Speech & Grammar Mechanics',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Transformations and Mechanics</h3>
<ul>
    <li><strong>Active to Passive Voice:</strong> <em>The electric shock damaged the computer disk</em> -> <em>The computer disk was damaged by the electric shock</em>.</li>
    <li><strong>Direct to Indirect Speech:</strong> Reporting verb tense shifts and pronoun realignments.</li>
    <li><strong>Conditionals:</strong> First conditional (Present in if-clause -> Will in main clause); Third conditional (Past Perfect -> Would have + Past Participle).</li>
    <li><strong>Parallelism and Modifiers:</strong> Avoiding dangling modifiers and maintaining balanced syntactic series.</li>
</ul>',
                            ],
                        ],
                    ],
                ],
            ],

            // =========================================================================
            // MODULE 4: PAPER II - GOVERNANCE SYSTEMS (MAIN EXAM - 100 MARKS)
            // =========================================================================
            [
                'title' => 'Paper II: Governance Systems (Main Examination - 100 Marks)',
                'description' => 'Subjective analytical study of State & Governance, Constitutionalism, Federalism, Public Administration, Ethics, Integrity, E-Governance, and Public Policy.',
                'notes' => 'Detailed study for Stage II Written Examination (10 Questions x 10 Marks = 100 Marks).',
                'key_points' => "• Constitutional Supremacy, Rule of Law & Separation of Powers\n• Federal Governance & Inter-Governmental Relations (Article 232)\n• Public Administration Principles & New Public Management (NPM)\n• Civil Service Ethics, Public Accountability, RTI & Anti-Corruption\n• E-Governance Infrastructure, Nagarik App & Public Policy Formulation",
                'chapters' => [
                    [
                        'title' => '1. State, Federalism, Public Administration & Policy Governance',
                        'description' => 'Comprehensive governance concepts and administrative frameworks.',
                        'lessons' => [
                            [
                                'title' => '4.1 State, Nation-Building, Constitutionalism and Democratic Values',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Elements of the State and Constitutionalism</h3>
<p>The sovereign state comprises Population, Territory, Government, and Sovereignty. Constitutionalism enforces limited government under the rule of law, protecting fundamental freedoms against tyranny.</p>

<h3>2. Separation of Powers and Checks & Balances</h3>
<p>Formulated by Montesquieu in 1748. The Legislative enacts laws, Executive enforces policies, and Judiciary interprets laws while reviewing constitutionality under judicial review.</p>',
                            ],
                            [
                                'title' => '4.2 Federal Governance & Inter-Governmental Relations in Nepal',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. The Three Tiers of Federalism</h3>
<p>Federation, 7 Provinces, and 753 Local Levels operating under Article 232 principles: <strong>Cooperation, Co-existence, and Coordination</strong>.</p>

<h3>2. Fiscal Federalism and Institutional Coordination</h3>
<p>National Natural Resources and Fiscal Commission (NNRFC) allocates Fiscal Equalisation, Conditional, Matching, and Special grants. Inter-Provincial Council (Article 234) addresses political coordination disputes.</p>',
                            ],
                            [
                                'title' => '4.3 Public Administration, Civil Service & Administrative Reform',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Public Administration Paradigms</h3>
<ul>
    <li><strong>Weberian Bureaucracy:</strong> Rational-legal authority, specialization, hierarchy, and impersonal written rules.</li>
    <li><strong>New Public Management (NPM):</strong> Results-oriented management, performance indicators, efficiency, and customer satisfaction.</li>
    <li><strong>Administrative Neutrality:</strong> Impartial, non-partisan execution of government policies by career civil servants.</li>
</ul>',
                            ],
                            [
                                'title' => '4.4 Ethics, Integrity, Public Accountability and Anti-Corruption',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Ethical Values in Public Service</h3>
<p>Integrity, transparency, accountability, and avoiding Conflict of Interest. Citizen oversight through Social Audits and Public Hearings.</p>

<h3>2. Right to Information and Anti-Graft Architecture</h3>
<p>RTI Act 2064 mandates information disclosure within 15 days (24 hours for life/liberty). CIAA (Part 21) prosecutes corruption in the Special Court.</p>',
                            ],
                            [
                                'title' => '4.5 E-Governance, Public Policy Formulation and Service Delivery',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Electronic Governance and Digital Service Delivery</h3>
<p>Digital Nepal Framework, Nagarik App, LMBIS/SUTRA public budgeting, and e-GP procurement portal.</p>

<h3>2. Public Policy Cycle</h3>
<p>Problem Identification -> Policy Formulation -> Legislative Adoption -> Field Implementation -> Monitoring and Impact Evaluation.</p>',
                            ],
                        ],
                    ],
                ],
            ],

            // =========================================================================
            // MODULE 5: PAPER III - CONTEMPORARY ISSUES (MAIN EXAM - 100 MARKS)
            // =========================================================================
            [
                'title' => 'Paper III: Contemporary Issues (Main Examination - 100 Marks)',
                'description' => 'Subjective analytical study of Social Inclusion, Macroeconomic Management, Sectoral Growth, Climate & Disaster Resilience, National Security, and Foreign Policy.',
                'notes' => 'Detailed study for Stage II Written Examination (10 Questions x 10 Marks = 100 Marks).',
                'key_points' => "• Proportional Inclusion, Social Justice & Demographic Dividend\n• Fiscal & Monetary Policy, Public Debt & Medium-Term Expenditure Framework (MTEF)\n• Commercial Agriculture, Tourism Branding & Green Hydropower Export\n• Disaster Risk Reduction (NDRRMA), Climate Adaptation & Build Back Better\n• Non-Aligned Foreign Policy, Panchasheel, Economic Diplomacy & UN Peacekeeping",
                'chapters' => [
                    [
                        'title' => '1. Socio-Economic, Environmental & Geopolitical Issues',
                        'description' => 'In-depth contemporary national and global development challenges.',
                        'lessons' => [
                            [
                                'title' => '5.1 Social Justice, Inclusion, Human Rights and Demographic Dynamics',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Social Justice and Inclusion</h3>
<p>Article 42 guarantees proportional inclusion. 45% reservation in public employment for Women (33%), Adivasi Janajati (27%), Madhesi (22%), Dalit (9%), Tharu (5%), and Muslim (4%).</p>

<h3>2. Harnessing Demographic Dividend</h3>
<p>Mobilizing the youth working-age population through quality technical education, health insurance, and domestic productive employment.</p>',
                            ],
                            [
                                'title' => '5.2 Macroeconomic Management, Public Finance and Resource Mobilization',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Public Financial Management</h3>
<p>Budget presentation on Jestha 15 (Article 119). Medium-Term Expenditure Framework (MTEF), single 13% VAT, Treasury Single Account (TSA), and debt sustainability.</p>

<h3>2. Macroeconomic Stability</h3>
<p>Managing balance of payments (BoP), foreign currency reserves, curbing inflation, and addressing merchandise trade deficits.</p>',
                            ],
                            [
                                'title' => '5.3 Sectoral Economic Growth: Agriculture, Industry, Tourism & Energy',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Productive Sector Engines</h3>
<ul>
    <li><strong>Agriculture:</strong> Commercialization via ADS 2015–2035, high-value organic cash crops, and irrigation expansion.</li>
    <li><strong>Industry & Trade:</strong> Special Economic Zones (SEZs), One-Stop Service Centre, and Geographical Indications (GI).</li>
    <li><strong>Tourism & Hydropower:</strong> Ecotourism branding via NTB, clean energy transition, cross-border electricity trade with India and Bangladesh.</li>
</ul>',
                            ],
                            [
                                'title' => '5.4 Climate Vulnerability, Disaster Management and Green Economy',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Disaster Risk Reduction and Management</h3>
<p>NDRRMA under Disaster Management Act 2074. Implementing the Sendai Framework, multi-hazard early warning systems, and <em>Build Back Better</em> reconstruction.</p>

<h3>2. Climate Adaptation and Finance</h3>
<p>Green Climate Fund (GCF) access, Nationally Determined Contributions (NDC) 2045 net-zero target, and international Loss & Damage mechanisms.</p>',
                            ],
                            [
                                'title' => '5.5 National Security, Geopolitics and Foreign Policy of Nepal',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Foundational Foreign Policy Principles</h3>
<p>Panchasheel, Non-Aligned Movement (NAM), UN Charter, and sovereign equality. Economic diplomacy to expand trade, FDI, and tourism.</p>

<h3>2. Geopolitical Balances and Global Peace</h3>
<p>Balanced transit and connectivity diplomacy with India and China; top contribution to UN Peacekeeping Missions (UNPKOs).</p>',
                            ],
                        ],
                    ],
                ],
            ],

            // =========================================================================
            // MODULE 6: PAPER IV - SERVICE RELATED ADMINISTRATION & LAW (MAIN EXAM - 100 MARKS)
            // =========================================================================
            [
                'title' => 'Paper IV: Service Related Administration, Law & Management (Main Exam - 100 Marks)',
                'description' => 'Detailed study of Civil Service Legislation, Administrative Law, Public Procurement, Financial Procedures, Fiscal Responsibility, and Official Office Management.',
                'notes' => 'Detailed study for Stage II Written Examination (10 Questions x 10 Marks = 100 Marks).',
                'key_points' => "• Civil Service Act 2049, Appointments, Leaves, Promotions & Penalties\n• Administrative Law, Principles of Natural Justice & Ultra Vires Doctrine\n• Public Procurement Act 2063, e-GP, Bid Securities & Contract Management\n• Financial Procedures & Fiscal Responsibility Act 2076 and Beruju Settlement\n• Official Note (Tippani) Drafting, Darta/Chalani & Cabinet Proposals",
                'chapters' => [
                    [
                        'title' => '1. Civil Service Law, Administrative Jurisprudence & Office Procedures',
                        'description' => 'Statutory laws and practical administrative management for civil servants.',
                        'lessons' => [
                            [
                                'title' => '6.1 Civil Service Act & Rules in Nepal',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Provisions of Civil Service Act 2049</h3>
<ul>
    <li><strong>Ranks:</strong> Gazetted (Special, 1st, 2nd, 3rd Class / Section Officer) and Non-Gazetted.</li>
    <li><strong>Probation:</strong> 6 months for females, 1 year for males.</li>
    <li><strong>Leaves:</strong> Casual leave (12 days), Home leave (1 day per 10 days worked, max 180 days encashable), Sick leave (12 days), Maternity (98 days).</li>
    <li><strong>Retirement & Pension:</strong> Compulsory retirement at 58 years; pension formula = <code>(Years of Service * Last Basic Salary) / 50</code>.</li>
</ul>',
                            ],
                            [
                                'title' => '6.2 Administrative Law, Delegation of Authority and Discretionary Powers',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Principles of Natural Justice</h3>
<p><em>Audi Alteram Partem</em> (Hear the other side) and <em>Nemo Judex in Causa Sua</em> (No one should be a judge in their own cause).</p>

<h3>2. Ultra Vires and Delegation</h3>
<p>Actions exceeding legal authority are <em>ultra vires</em> and void. Powers delegated cannot be sub-delegated without explicit statutory sanction.</p>',
                            ],
                            [
                                'title' => '6.3 Public Procurement Management & Contract Administration',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Public Procurement Act 2063</h3>
<ul>
    <li><strong>Default Method:</strong> Open Competitive Bidding via e-GP portal (PPMO).</li>
    <li><strong>Guarantees:</strong> Bid Security (2%–3% of estimate), Performance Security (5% of contract value).</li>
    <li><strong>Notice Periods:</strong> 30 days for National Competitive Bidding (NCB), 45 days for International Competitive Bidding (ICB).</li>
</ul>',
                            ],
                            [
                                'title' => '6.4 Financial Procedures & Fiscal Responsibility Legislation',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Fiscal Accountability (Act 2076)</h3>
<p>Accounting Officer (Ministry Secretary) holds primary financial responsibility. District operations overseen by DTCO (कोलेनिका) and FCGO (मलेकनिका).</p>

<h3>2. Audit Queries / Beruju Settlement</h3>
<p>Beruju categorized into Regularizable, Recoverable, and Unsettled Advances, reviewed by the Public Accounts Committee (PAC).</p>',
                            ],
                            [
                                'title' => '6.5 Office Management, Decision Making and Official Correspondence',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Official Decision-Making via Tippani (टिप्पणी)</h3>
<p>Structured administrative note analyzing facts, legal rules, precedents, and options, leading to an actionable recommendation.</p>

<h3>2. Office Records and Communications</h3>
<p>Darta (incoming mail registration), Chalani (outgoing mail dispatch), Cabinet proposals, circulars, and statutory document retention schedules.</p>',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
