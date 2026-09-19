<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class LoksewaComprehensiveSyllabusSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedNayabSubba();
        $this->seedSectionOfficer();
        $this->seedNRBOfficer();
        $this->seedNRBAssistantDirector();
        $this->seedConstitutionAndLaw();
        $this->seedComputerSkill();
        $this->seedIQAptitude();
        $this->seedNepalTelecom();
    }

    /* =========================================================================
     * 1. NAYAB SUBBA TAYARI (na.su.)
     * ========================================================================= */
    private function seedNayabSubba(): void
    {
        $course = Course::where('slug', 'nayab-subba-tayari')->first();
        if (! $course) {
            return;
        }

        // Module 1: GK
        $m1 = Module::updateOrCreate(
            ['course_id' => $course->id, 'slug' => 'nasu-pratham-patra-gk'],
            [
                'title' => 'Pratham Patra: Samanya Gyan (General Knowledge)',
                'order' => 1,
                'is_published' => true,
                'description' => 'Comprehensive General Knowledge syllabus covering Nepal Geography, History, Governance, Culture, Economy, and International Affairs.',
                'key_points' => "• Focus on Physical & Political Geography of Nepal\n• Historical Eras: Ancient Lichhavi, Medieval Malla & Modern Shah Rule\n• Key Constitutional Articles & International Organizations (UN, SAARC, BIMSTEC)",
                'notes' => 'Complete theoretical syllabus notes for Nayab Subba 1st Paper GK examination.',
            ]
        );

        $this->createLessonWithQuizzes($m1, 'Physical Geography of Nepal & Climate', 'nasu-gk-geography-nepal', 1, [
            [
                'question' => 'What is the total geographical area of Nepal?',
                'options' => ['147,181 sq km', '147,516 sq km', '147,850 sq km', '148,181 sq km'],
                'answer' => 0,
                'hint' => 'Think of the official figure measured at 147,181 square kilometers.',
                'explanation' => 'Nepal has an area of 147,181 sq. km (56,827 sq. mi), extending roughly 885 km east-west and 193 km north-south.',
            ],
            [
                'question' => 'Which is the highest peak in the Mahabharat mountain range?',
                'options' => ['Sailung', 'Saileshwor', 'Sailung Peak', 'Phulchoki'],
                'answer' => 3,
                'hint' => 'Located on the southern rim of Kathmandu Valley at an elevation of 2,782 meters.',
                'explanation' => 'Phulchoki (2,782 m) is the highest peak in the Mahabharat Range (Lesser Himalayas) around Kathmandu Valley.',
            ],
            [
                'question' => 'Which river is known as the "Sorrow of Bihar" after flowing from Nepal into India?',
                'options' => ['Gandaki', 'Karnali', 'Koshi', 'Mahakali'],
                'answer' => 2,
                'hint' => 'This 7-tributary river is Nepal largest river by volume.',
                'explanation' => 'The Koshi River causes frequent seasonal flooding in Bihar, earning it the epithet "Sorrow of Bihar".',
            ],
            [
                'question' => 'What percentage of Nepal total land area is occupied by the Terai region?',
                'options' => ['Approx 17%', 'Approx 23%', 'Approx 35%', 'Approx 68%'],
                'answer' => 0,
                'hint' => 'It occupies slightly less than one-fifth of the national territory.',
                'explanation' => 'The Terai ecological belt occupies approximately 17% of Nepal total area, while Hills occupy ~68% and Mountains ~15%.',
            ],
            [
                'question' => 'Which lake is situated at the highest altitude in Nepal?',
                'options' => ['Rara Lake', 'Shey Phoksundo Lake', 'Tilicho / Kajin Sara Lake', 'Gosaikunda'],
                'answer' => 2,
                'hint' => 'Kajin Sara in Manang is recorded at 5,200m, while Tilicho is at 4,919m.',
                'explanation' => 'Tilicho Lake (4,919 m) and newly surveyed Kajin Sara Lake (5,200 m) in Manang district hold the record for highest altitude lakes.',
            ],
            [
                'question' => 'Which district of Nepal touches both India and China?',
                'options' => ['Taplejung & Darchula', 'Jhapa & Kanchanpur', 'Solukhumbu & Mustang', 'Rasuwa & Humla'],
                'answer' => 0,
                'hint' => 'One is in the extreme East and the other is in the extreme Far-West.',
                'explanation' => 'Taplejung (Eastern border) and Darchula (Western border) are the two districts sharing borders with both India and China.',
            ],
            [
                'question' => 'Which pass connects Nepal (Mustang) with Tibet (China)?',
                'options' => ['Kodari Pass', 'Korala Pass', 'Kimathanka Pass', 'Rasuwagadhi Pass'],
                'answer' => 1,
                'hint' => 'Located in Upper Mustang at an altitude of 4,660 meters.',
                'explanation' => 'Korala Pass in Upper Mustang connects Nepal with Tibet, China, serving as a historical trade route.',
            ],
            [
                'question' => 'What is the standard time of Nepal based on, and how far ahead of GMT is it?',
                'options' => ['Mt. Gaurishankar (86°15\' E) & GMT +5:45', 'Mt. Everest (86°55\' E) & GMT +5:30', 'Mt. Annapurna & GMT +6:00', 'Mt. Manaslu & GMT +5:15'],
                'answer' => 0,
                'hint' => 'Based on Gaurishankar meridian, implemented on 2042 BS Baisakh 1.',
                'explanation' => 'Nepal Standard Time (NST) is calculated based on Mt. Gaurishankar meridian (86°15\' East Longitude), exactly GMT +5 hours 45 minutes.',
            ],
            [
                'question' => 'Which is the largest glacier in Nepal?',
                'options' => ['Khumbu Glacier', 'Ngozumpa Glacier', 'Langtang Glacier', 'Yalung Glacier'],
                'answer' => 1,
                'hint' => 'Located below Cho Oyu in the Everest region, spanning 36 kilometers.',
                'explanation' => 'Ngozumpa Glacier is Nepal longest glacier (36 km), while Khumbu is the highest glacier.',
            ],
            [
                'question' => 'Which national park of Nepal is recognized as a UNESCO World Heritage Natural Site?',
                'options' => ['Bardia National Park', 'Chitwan National Park & Sagarmatha National Park', 'Rara National Park', 'Shey Phoksundo National Park'],
                'answer' => 1,
                'hint' => 'One in the lowlands established in 1973, and one in the Himalayas established in 1976.',
                'explanation' => 'Chitwan National Park (enlisted 1984) and Sagarmatha National Park (enlisted 1979) are both UNESCO World Natural Heritage Sites.',
            ],
        ]);

        $this->createLessonWithQuizzes($m1, 'History of Modern Nepal & Unification', 'nasu-gk-history-nepal', 2, [
            [
                'question' => 'On which date did Prithvi Narayan Shah conquer Kathmandu Valley (Kantipur)?',
                'options' => ['1825 BS Ashwin 13 (Indra Jatra)', '1815 BS Baisakh 1', '1831 BS Magh 1', '1801 BS Chaitra 25'],
                'answer' => 0,
                'hint' => 'Conquered during the night festival of Indra Jatra in 1825 BS.',
                'explanation' => 'King Prithvi Narayan Shah conquered Kantipur on 1825 BS Ashwin 13 during the Indra Jatra festival.',
            ],
            [
                'question' => 'Who was the reigning King of Bhaktapur during the unification of Kathmandu Valley?',
                'options' => ['Jaya Prakash Malla', 'Ranajit Malla', 'Tej Narsingh Malla', 'Yaksha Malla'],
                'answer' => 1,
                'hint' => 'He was the godfather/mit-father of Prithvi Narayan Shah.',
                'explanation' => 'Ranajit Malla was the last Malla King of Bhaktapur before it was annexed to the unified kingdom in 1826 BS.',
            ],
            [
                'question' => 'The historic Treaty of Sugauli was signed in which year between Nepal and the British East India Company?',
                'options' => ['1814 AD', '1816 AD (March 4)', '1846 AD', '1857 AD'],
                'answer' => 1,
                'hint' => 'Concluded the Anglo-Nepalese War of 1814–1816.',
                'explanation' => 'The Sugauli Treaty was ratified on 4 March 1816 AD, demarcating the Mechi and Mahakali boundary rivers of Nepal.',
            ],
            [
                'question' => 'Who was the Nepalese commander who fiercely defended the Nalapani fort against British forces?',
                'options' => ['Amar Singh Thapa', 'Balbhadra Kunwar', 'Bhakti Thapa', 'Kalu Pande'],
                'answer' => 1,
                'hint' => 'Known for his heroic defense of Khalanga (Nalapani) fort with only 600 soldiers.',
                'explanation' => 'Captain Balbhadra Kunwar led the heroic resistance at the Battle of Nalapani in 1814 AD.',
            ],
            [
                'question' => 'The Kot Massacre (Kot Parva), which established Rana rule in Nepal, occurred on which date?',
                'options' => ['1903 BS Ashwin 2', '1907 BS Falgun 7', '1882 BS Baisakh 1', '1911 BS Poush 1'],
                'answer' => 0,
                'hint' => 'Took place in the royal court of Hanuman Dhoka on 14 September 1846 AD.',
                'explanation' => 'The Kot Massacre took place on 1903 BS Ashwin 2 (14 Sept 1846 AD), leading to the rise of Jung Bahadur Rana as Prime Minister.',
            ],
            [
                'question' => 'Who is recognized as the "Father of Education" among the Rana Prime Ministers of Nepal?',
                'options' => ['Jung Bahadur Rana', 'Dev Shumsher Rana', 'Chandra Shumsher Rana', 'Juddha Shumsher Rana'],
                'answer' => 1,
                'hint' => 'He established numerous Bhasha Pathshalas and initiated Gorkhapatra publication.',
                'explanation' => 'Dev Shumsher Rana established over 150 primary schools (Bhasha Pathshala) and initiated Gorkhapatra in 1958 BS.',
            ],
            [
                'question' => 'When was Tribhuvan University, the first university of Nepal, established?',
                'options' => ['2007 BS', '2013 BS', '2016 BS (1959 AD)', '2028 BS'],
                'answer' => 2,
                'hint' => 'Established in Kirtipur in 2016 BS during the reign of King Mahendra.',
                'explanation' => 'Tribhuvan University was established on 2016 BS Ashad 11 (1959 AD) under the Tribhuvan University Act.',
            ],
            [
                'question' => 'Which historical commission promulgated the Muluki Ain of 1910 BS?',
                'options' => ['Bhimsen Thapa Council', 'Jung Bahadur Rana Administration', 'Chandra Shumsher Commission', 'Ranodip Singh Ministry'],
                'answer' => 1,
                'hint' => 'Introduced after Jung Bahadur return from his tour of Europe and Britain.',
                'explanation' => 'Jung Bahadur Rana enacted the first codified legal system of Nepal, the Muluki Ain, in 1910 BS (1854 AD).',
            ],
            [
                'question' => 'When was Nepal declared a Federal Democratic Republic by the First Constituent Assembly?',
                'options' => ['2063 BS Baisakh 11', '2065 BS Jestha 15 (28 May 2008)', '2072 BS Ashwin 3', '2062 BS Mangsir 7'],
                'answer' => 1,
                'hint' => 'Decided in the historic first meeting of the Constituent Assembly on Jestha 15.',
                'explanation' => 'The first Constituent Assembly formally abolished the 240-year-old monarchy and declared Nepal a Republic on 2065 BS Jestha 15.',
            ],
            [
                'question' => 'Who was the first elected Prime Minister of Nepal after the 2015 BS General Elections?',
                'options' => ['Matrika Prasad Koirala', 'B.P. Koirala (Bishweshwar Prasad Koirala)', 'Tanka Prasad Acharya', 'K.I. Singh'],
                'answer' => 1,
                'hint' => 'Led the Nepali Congress to a two-thirds majority in Nepal first democratic parliamentary elections.',
                'explanation' => 'B.P. Koirala became the first democratically elected Prime Minister of Nepal on 2016 BS Jestha 13 (May 1959).',
            ],
        ]);

        // Module 2: IQ
        $m2 = Module::updateOrCreate(
            ['course_id' => $course->id, 'slug' => 'nasu-pratham-patra-iq'],
            [
                'title' => 'Pratham Patra: Samanya Bauddhik Parikshan (General Intelligent Test - IQ)',
                'order' => 2,
                'is_published' => true,
                'description' => 'Verbal, Non-Verbal, Quantitative, and Analytical Intelligence Test syllabus for Nayab Subba.',
                'key_points' => "• Speed & Accuracy in Number & Letter Sequences\n• Visual & Pattern Matrices\n• Logical Deductions & Syllogistic Relations",
                'notes' => 'Complete step-by-step techniques and shortcuts for Nayab Subba IQ section.',
            ]
        );

        $this->createLessonWithQuizzes($m2, 'Number & Letter Series Patterns', 'nasu-iq-series-patterns', 1, [
            [
                'question' => 'Find the missing number: 3, 7, 15, 31, 63, ?',
                'options' => ['95', '115', '127', '129'],
                'answer' => 2,
                'hint' => 'Each number is multiplied by 2 and increased by 1: (x * 2) + 1.',
                'explanation' => 'The rule is (2n + 1): 3*2+1=7, 7*2+1=15, 15*2+1=31, 31*2+1=63, 63*2+1=127.',
            ],
            [
                'question' => 'Find the missing number in the sequence: 2, 6, 12, 20, 30, 42, ?',
                'options' => ['52', '56', '60', '64'],
                'answer' => 1,
                'hint' => 'Notice the pattern of consecutive products: 1*2, 2*3, 3*4, 4*5, 5*6, 6*7, 7*8.',
                'explanation' => 'Differences are +4, +6, +8, +10, +12, +14. So 42 + 14 = 56 (or 7 * 8 = 56).',
            ],
            [
                'question' => 'Find the next term in the letter series: B, D, G, K, P, ?',
                'options' => ['U', 'V', 'W', 'X'],
                'answer' => 1,
                'hint' => 'Alphabet positions increase by +2, +3, +4, +5, +6.',
                'explanation' => 'B(2) +2 = D(4), D(4) +3 = G(7), G(7) +4 = K(11), K(11) +5 = P(16), P(16) +6 = V(22).',
            ],
            [
                'question' => 'If TEACHER is coded as VGCEJGT, how is CHILDREN coded in that same code?',
                'options' => ['EJKNFTGP', 'EJKNFHTP', 'EJKNFTFP', 'EJKNEGHP'],
                'answer' => 0,
                'hint' => 'Each letter is shifted forward by 2 positions (+2).',
                'explanation' => 'C(+2)=E, H(+2)=J, I(+2)=K, L(+2)=N, D(+2)=F, R(+2)=T, E(+2)=G, N(+2)=P -> EJKNFTGP.',
            ],
            [
                'question' => 'Find the odd one out from the given numbers: 27, 64, 125, 144, 216, 343',
                'options' => ['27', '64', '144', '343'],
                'answer' => 2,
                'hint' => 'Look for perfect cubes (n^3) versus a perfect square only.',
                'explanation' => '27=3^3, 64=4^3, 125=5^3, 216=6^3, 343=7^3 are all perfect cubes. 144 is only 12^2, not a perfect cube.',
            ],
            [
                'question' => 'Complete the series: 4, 9, 25, 49, 121, 169, ?',
                'options' => ['196', '225', '289', '361'],
                'answer' => 2,
                'hint' => 'Squares of consecutive prime numbers: 2^2, 3^2, 5^2, 7^2, 11^2, 13^2, 17^2.',
                'explanation' => 'The series consists of prime numbers squared: 2, 3, 5, 7, 11, 13, 17 -> 17^2 = 289.',
            ],
            [
                'question' => 'A man walks 5 km South, turns left and walks 3 km, then turns left and walks 5 km. In which direction is he from the starting point?',
                'options' => ['North', 'South', 'East', 'West'],
                'answer' => 2,
                'hint' => 'Trace his vertical and horizontal displacement on a cardinal grid.',
                'explanation' => 'He moves 5 km South, then 3 km East, then 5 km North. His net displacement is 3 km East.',
            ],
            [
                'question' => 'Introducing a boy, a woman said, "His mother is the only daughter of my mother." How is the woman related to the boy?',
                'options' => ['Sister', 'Aunt', 'Mother', 'Grandmother'],
                'answer' => 2,
                'hint' => 'The only daughter of the woman\'s mother is the woman herself.',
                'explanation' => 'The only daughter of the woman\'s mother is the woman herself; hence, she is the boy\'s Mother.',
            ],
            [
                'question' => 'In a row of 35 students, Ramesh is 17th from the left end. What is his position from the right end?',
                'options' => ['18th', '19th', '20th', '21st'],
                'answer' => 1,
                'hint' => 'Use the ranking formula: (Total - Left Position) + 1.',
                'explanation' => 'Position from Right = Total - Left + 1 = 35 - 17 + 1 = 19th.',
            ],
            [
                'question' => 'If "+" means multiplication, "-" means division, "*" means addition, and "/" means subtraction, solve: 20 - 4 + 3 * 6 / 2',
                'options' => ['17', '19', '21', '23'],
                'answer' => 1,
                'hint' => 'Substitute signs first according to the rule, then follow BODMAS: (20 / 4 * 3) + 6 - 2.',
                'explanation' => 'Substitute signs: 20 / 4 * 3 + 6 - 2 = (5 * 3) + 6 - 2 = 15 + 6 - 2 = 19.',
            ],
        ]);

        // Module 3: Office Management
        $m3 = Module::updateOrCreate(
            ['course_id' => $course->id, 'slug' => 'nasu-dosro-patra-prashasan'],
            [
                'title' => 'Dosro Patra: Samanya Prashasan ra Karyalaya Byawasthapan',
                'order' => 3,
                'is_published' => true,
                'description' => 'Administrative principles, office filing, secretarial protocols, citizen charters, and public accounting.',
                'key_points' => "• Office procedures (Darta, Chalani, Tippani, File Indexing)\n• Civil Service Act 2049 & Code of Ethics\n• Public Procurement, Audit Systems & Good Governance Act 2064",
                'notes' => 'Comprehensive subjective & objective study notes for 2nd Paper.',
            ]
        );

        $this->createLessonWithQuizzes($m3, 'Public Administration & Civil Service System', 'nasu-admin-principles', 1, [
            [
                'question' => 'Who is regarded as the "Father of Modern Public Administration"?',
                'options' => ['Max Weber', 'Woodrow Wilson', 'Luther Gulick', 'Henri Fayol'],
                'answer' => 1,
                'hint' => 'Former US President who authored "The Study of Administration" in 1887.',
                'explanation' => 'Woodrow Wilson is considered the Father of Public Administration following his seminal 1887 essay distinguishing politics from administration.',
            ],
            [
                'question' => 'Under the Civil Service Act 2049, what is the maximum probationary period for a female employee newly appointed to civil service?',
                'options' => ['6 Months', '1 Year', '2 Years', 'No probation'],
                'answer' => 0,
                'hint' => 'Females have a 6-month probation period, while males have 1 year.',
                'explanation' => 'Under Section 10 of the Civil Service Act 2049, probation is 6 months for female employees and 1 year for male employees.',
            ],
            [
                'question' => 'What is the standard archival retention period for "Ka" (Class A) government records according to Record Preservation Rules?',
                'options' => ['5 Years', '10 Years', '20 Years', 'Permanent (Sadhainbhari)'],
                'answer' => 3,
                'hint' => 'Treaties, boundary maps, and supreme state documents are kept forever.',
                'explanation' => 'Class "Ka" (Category A) government documents are of permanent national importance and are preserved permanently.',
            ],
            [
                'question' => 'Which section of a formal Tippani (Executive Note) contains the final administrative decision by the authorized officer?',
                'options' => ['Fact & Context Section', 'Rules & Legal Reference', 'Opinion / Recommendation', 'Nirnaya (Final Order / Approval)'],
                'answer' => 3,
                'hint' => 'The authorizing signature that validates the administrative action.',
                'explanation' => 'A Tippani concludes with the "Nirnaya" (Executive Decision/Order) written and sealed by the competent approving authority.',
            ],
            [
                'question' => 'Under the Right to Information Act 2064, within how many hours must information concerning a person\'s life and liberty be provided?',
                'options' => ['12 Hours', '24 Hours', '48 Hours', '7 Days'],
                'answer' => 1,
                'hint' => 'Urgent life-threatening queries must be answered within 1 day.',
                'explanation' => 'Section 7(4) of the RTI Act 2064 mandates that information directly related to an individual\'s life or liberty must be provided within 24 hours.',
            ],
            [
                'question' => 'What is the statutory percentage of total seats allocated for open competition and inclusive reservation under Civil Service Act 2049?',
                'options' => ['50% Open & 50% Reserved', '55% Open & 45% Reserved', '60% Open & 40% Reserved', '70% Open & 30% Reserved'],
                'answer' => 1,
                'hint' => '45% is set aside for inclusive groups (Women 33%, Adibasi Janajati 27%, Madhesi 22%, Dalit 9%, Differently Abled 5%, Backward Area 4%).',
                'explanation' => 'The Civil Service Act allocates 55% of posts to Open Competition and 45% to Inclusive Reservation clusters.',
            ],
            [
                'question' => 'Which accounting code system is officially utilized for government expenditures across all public offices in Nepal?',
                'options' => ['SAP Financials', 'CGAS (Computerized Government Accounting System)', 'QuickBooks Gov', 'Oracle Treasury'],
                'answer' => 1,
                'hint' => 'Developed and monitored under the Financial Comptroller General Office (FCGO).',
                'explanation' => 'CGAS (Computerized Government Accounting System) is the mandatory public accounting platform implemented by FCGO Nepal.',
            ],
            [
                'question' => 'According to the Good Governance Act 2064, what is mandatory for all service-providing public agencies to display at their office entrance?',
                'options' => ['Annual Budget Sheet', 'Citizen Charter (Nagarik Bada-patra)', 'Staff Attendance Register', 'Audit Report'],
                'answer' => 1,
                'hint' => 'Details the services, required documents, fees, timeframe, and responsible official.',
                'explanation' => 'Section 25 of the Good Governance Act 2064 mandates the prominent placement of a Citizen Charter (Nagarik Bada-patra) in every public office.',
            ],
            [
                'question' => 'Who conducts the final statutory financial audit of all government ministries, departments, and constitutional bodies in Nepal?',
                'options' => ['Auditor General of Nepal (Maha Lekhaparikshak)', 'Financial Comptroller General Office (Mahalekha Niyantrak)', 'Ministry of Finance', 'CIAA'],
                'answer' => 0,
                'hint' => 'Constitutional body established under Part 22, Article 240 of the Constitution.',
                'explanation' => 'The Auditor General of Nepal (OAGN) holds constitutional authority under Article 241 to conduct the final audit of all state bodies.',
            ],
            [
                'question' => 'Under the Public Procurement Act 2063, what is the standard threshold for sealed quotation procurement for goods in Nepal?',
                'options' => ['Up to Rs 5 Lakhs', 'Rs 20 Lakhs to Rs 1 Crore', 'Above Rs 5 Crore', 'Up to Rs 1 Lakh only'],
                'answer' => 1,
                'hint' => 'Purchases between 20 Lakhs and 1 Crore generally require sealed quotations (or tenders above thresholds).',
                'explanation' => 'Procurement Rules outline specific thresholds: direct purchase up to Rs 5 Lakhs, sealed quotations up to Rs 20 Lakhs, and open national bidding above specified limits.',
            ],
        ]);

        // Module 4: Constitution & Law
        $m4 = Module::updateOrCreate(
            ['course_id' => $course->id, 'slug' => 'nasu-tesro-patra-samvidhan-kanoon'],
            [
                'title' => 'Tesro Patra: Samvidhan, Kanoon ra Nyaya Prashasan',
                'order' => 4,
                'is_published' => true,
                'description' => 'Constitution of Nepal 2072, Fundamental Rights, Legal Frameworks, Judicial System, and Local Governance.',
                'key_points' => "• Constitution of Nepal 2072 (Parts 1 to 35, Schedules 1 to 9)\n• Muluki Civil & Criminal Codes\n• Local Government Operation Act 2074",
                'notes' => 'Detailed legal analysis, case laws, and statutory articles for 3rd Paper.',
            ]
        );

        $this->createLessonWithQuizzes($m4, 'Constitution of Nepal 2072 Key Articles', 'nasu-constitution-core-articles', 1, [
            [
                'question' => 'How many Parts, Articles, and Schedules are there in the Constitution of Nepal 2072?',
                'options' => ['30 Parts, 300 Articles, 7 Schedules', '35 Parts, 308 Articles, 9 Schedules', '32 Parts, 295 Articles, 8 Schedules', '36 Parts, 315 Articles, 10 Schedules'],
                'answer' => 1,
                'hint' => 'Contains 35 Parts and 308 Articles promulgated on 2072 Ashwin 3.',
                'explanation' => 'The Constitution of Nepal comprises 35 Parts, 308 Articles, and 9 Schedules.',
            ],
            [
                'question' => 'Which Article of the Constitution of Nepal guarantees the "Right to Equality"?',
                'options' => ['Article 16', 'Article 17', 'Article 18', 'Article 20'],
                'answer' => 2,
                'hint' => 'Follows the Right to Live with Dignity (Art 16) and Right to Freedom (Art 17).',
                'explanation' => 'Article 18 guarantees the Right to Equality, ensuring no citizen shall be discriminated against based on origin, religion, race, sex, caste, or ideology.',
            ],
            [
                'question' => 'Under Article 17 of the Constitution, how many specific fundamental freedoms are guaranteed to citizens?',
                'options' => ['4 Freedoms', '5 Freedoms', '6 Freedoms', '8 Freedoms'],
                'answer' => 2,
                'hint' => 'Freedom of opinion/expression, peaceful assembly, association, movement, residence, and profession/business.',
                'explanation' => 'Article 17(2) guarantees 6 specific freedoms: expression, peaceful assembly, forming unions/associations, movement across Nepal, residence, and practicing any occupation.',
            ],
            [
                'question' => 'According to the Constitution, within how many months of receiving a Bill must the President certify it (except Money Bills)?',
                'options' => ['7 Days', '15 Days', '30 Days', '45 Days'],
                'answer' => 1,
                'hint' => 'The President has a 15-day constitutional deadline under Article 111/113.',
                'explanation' => 'Article 113 stipulates that the President shall certify a bill within 15 days of its submission, or return it for reconsideration within that period.',
            ],
            [
                'question' => 'Which Schedule of the Constitution defines the Exclusive Powers of Local Level Governments (Gaunpalika / Nagarpalika)?',
                'options' => ['Schedule 5', 'Schedule 6', 'Schedule 7', 'Schedule 8'],
                'answer' => 3,
                'hint' => 'Schedule 5 is Federal, Schedule 6 is Provincial, Schedule 7 is Concurrent Fed-Prov, Schedule 8 is Local.',
                'explanation' => 'Schedule 8 lists the 22 exclusive powers and jurisdictions of Local Governments in Nepal.',
            ],
            [
                'question' => 'What is the mandatory retirement age for the Chief Justice and Supreme Court Justices of Nepal?',
                'options' => ['58 Years', '60 Years', '63 Years', '65 Years'],
                'answer' => 3,
                'hint' => 'Supreme Court judges serve until age 65, while High Court judges retire at 63.',
                'explanation' => 'Article 129(5) states that the Chief Justice and Judges of the Supreme Court hold office until the age of 65 years.',
            ],
            [
                'question' => 'Who chairs the Constitutional Council (Samvidhanik Parishad) of Nepal?',
                'options' => ['President of Nepal', 'Prime Minister of Nepal', 'Chief Justice of Nepal', 'Speaker of the House of Representatives'],
                'answer' => 1,
                'hint' => 'The head of the Federal Executive chairs the Council under Article 284.',
                'explanation' => 'Under Article 284, the Prime Minister chairs the Constitutional Council, which recommends appointments to constitutional organs.',
            ],
            [
                'question' => 'Under which Article can the Supreme Court issue extraordinary constitutional writs (Habeas Corpus, Mandamus, Certiorari, Prohibition, Quo Warranto)?',
                'options' => ['Article 133', 'Article 144', 'Article 150', 'Article 217'],
                'answer' => 0,
                'hint' => 'Article 133 is for Supreme Court, while Article 144 is for High Courts.',
                'explanation' => 'Article 133 confers extraordinary jurisdiction upon the Supreme Court to issue writs for the enforcement of fundamental rights.',
            ],
            [
                'question' => 'Which constitutional body is responsible for conducting fair examinations to recruit civil servants and security personnel in Nepal?',
                'options' => ['Public Service Commission (Lok Sewa Aayog)', 'CIAA', 'National Human Rights Commission', 'Election Commission'],
                'answer' => 0,
                'hint' => 'Constitutional body under Part 23, Article 242.',
                'explanation' => 'The Public Service Commission (Lok Sewa Aayog) conducts competitive examinations for selection to civil service and public entities under Article 243.',
            ],
            [
                'question' => 'According to Article 48 of the Constitution of Nepal, how many fundamental duties of citizens are specified?',
                'options' => ['3 Duties', '4 Duties', '5 Duties', '7 Duties'],
                'answer' => 1,
                'hint' => 'Safeguard nationality, abide by constitution, render compulsory state service, protect public property.',
                'explanation' => 'Article 48 outlines 4 fundamental duties: safeguarding nationality/sovereignty, abiding by the Constitution, rendering compulsory service when required, and protecting public property.',
            ],
        ]);
    }

    /* =========================================================================
     * 2. SECTION OFFICER TAYARI (Shakha Adhikrit)
     * ========================================================================= */
    private function seedSectionOfficer(): void
    {
        $course = Course::where('slug', 'section-officer-tayari')->first();
        if (! $course) {
            return;
        }

        // Module 1: GK & AAT
        $m1 = Module::updateOrCreate(
            ['course_id' => $course->id, 'slug' => 'officer-pratham-patra-gk-aat'],
            [
                'title' => 'Pratham Patra: Administrative Aptitude Test (GK & AAT)',
                'order' => 1,
                'is_published' => true,
                'description' => 'General Knowledge, Analytical Reasoning, Quantitative Evaluation, and Critical Decision-Making for Section Officer aspirants.',
                'key_points' => "• World Geopolitics, UN Treaties & Climate Conventions\n• Analytical Problem Solving & Critical Reasoning\n• Constitutional Jurisprudence & Public Policy",
                'notes' => 'Complete theoretical and analytical notes for Section Officer 1st Paper.',
            ]
        );

        $this->createLessonWithQuizzes($m1, 'Global Governance, Treaties & Diplomacy', 'officer-gk-global-governance', 1, [
            [
                'question' => 'In which year was the United Nations (UN) founded in San Francisco?',
                'options' => ['1942 AD', '1945 AD (October 24)', '1948 AD', '1950 AD'],
                'answer' => 1,
                'hint' => 'Established immediately following the conclusion of World War II.',
                'explanation' => 'The United Nations was officially established on 24 October 1945 upon ratification of the UN Charter.',
            ],
            [
                'question' => 'When did Nepal gain official membership to the United Nations?',
                'options' => ['1950 AD', '1955 AD (December 14)', '1960 AD', '1965 AD'],
                'answer' => 1,
                'hint' => 'Admitted as part of the "package deal" with 15 other nations.',
                'explanation' => 'Nepal became a member of the United Nations on 14 December 1955 AD during the 10th UN General Assembly.',
            ],
            [
                'question' => 'Which international agreement adopted the 17 Sustainable Development Goals (SDGs) targeting 2030?',
                'options' => ['Kyoto Protocol 1997', 'Paris Climate Agreement 2015', 'UN Resolution 70/1 (Agenda 2030)', 'Rio Earth Summit 1992'],
                'answer' => 2,
                'hint' => 'Adopted in September 2015 by 193 UN member states.',
                'explanation' => 'UN Resolution 70/1 adopted "Transforming our world: the 2030 Agenda for Sustainable Development" featuring 17 SDGs and 169 targets.',
            ],
            [
                'question' => 'Where is the permanent Secretariat of the South Asian Association for Regional Cooperation (SAARC) located?',
                'options' => ['New Delhi, India', 'Islamabad, Pakistan', 'Kathmandu, Nepal', 'Dhaka, Bangladesh'],
                'answer' => 2,
                'hint' => 'Inaugurated in Kathmandu in January 1987.',
                'explanation' => 'The SAARC Secretariat is headquartered in Kathmandu, Nepal, inaugurated on 16 January 1987.',
            ],
            [
                'question' => 'What is the main objective of the Paris Agreement (COP21) regarding global temperature rise?',
                'options' => ['Limit warming well below 2°C, preferably to 1.5°C above pre-industrial levels', 'Reduce temperature by 3°C', 'Maintain current emissions', 'Zero carbon by 2025'],
                'answer' => 0,
                'hint' => 'Focuses on keeping global average temperature rise well below 2°C compared to pre-industrial baselines.',
                'explanation' => 'The 2015 Paris Agreement aims to limit global warming to well below 2°C, pursuing efforts to restrict it to 1.5°C above pre-industrial levels.',
            ],
            [
                'question' => 'Which international financial institution is headquartered in Manila, Philippines?',
                'options' => ['World Bank', 'International Monetary Fund (IMF)', 'Asian Development Bank (ADB)', 'Asian Infrastructure Investment Bank (AIIB)'],
                'answer' => 2,
                'hint' => 'Established in 1966 to foster economic growth and cooperation in Asia-Pacific.',
                'explanation' => 'The Asian Development Bank (ADB) was established in 1966 and is headquartered in Manila, Philippines.',
            ],
            [
                'question' => 'Which treaty established the European Union (EU) and created the foundation for the Euro currency?',
                'options' => ['Treaty of Rome 1957', 'Maastricht Treaty 1992', 'Treaty of Lisbon 2007', 'Treaty of Versailles 1919'],
                'answer' => 1,
                'hint' => 'Signed in the Dutch city of Maastricht in 1992.',
                'explanation' => 'The Maastricht Treaty (signed 1992, effective 1993) created the European Union and paved the way for the Euro.',
            ],
            [
                'question' => 'BIMSTEC (Bay of Bengal Initiative for Multi-Sectoral Technical and Economic Cooperation) was established in which year?',
                'options' => ['1985 AD', '1997 AD (June 6)', '2004 AD', '2014 AD'],
                'answer' => 1,
                'hint' => 'Established via Bangkok Declaration in 1997; Nepal joined in 2004.',
                'explanation' => 'BIMSTEC was founded on 6 June 1997 in Bangkok. Nepal and Bhutan became members in February 2004.',
            ],
            [
                'question' => 'Which article of the UN Charter establishes the right of individual or collective self-defense for member states?',
                'options' => ['Article 2', 'Article 24', 'Article 51', 'Article 99'],
                'answer' => 2,
                'hint' => 'The landmark self-defense provision in Chapter VII.',
                'explanation' => 'Article 51 of Chapter VII of the UN Charter explicitly preserves the inherent right of individual or collective self-defense if an armed attack occurs.',
            ],
            [
                'question' => 'What is the primary judicial organ of the United Nations, and where does it sit?',
                'options' => ['International Criminal Court (Rome)', 'International Court of Justice (Peace Palace, The Hague)', 'European Court of Human Rights (Strasbourg)', 'Permanent Court of Arbitration (Geneva)'],
                'answer' => 1,
                'hint' => 'Composed of 15 judges serving 9-year terms at The Hague, Netherlands.',
                'explanation' => 'The International Court of Justice (ICJ) is the principal judicial organ of the UN, established in 1945 at the Peace Palace in The Hague.',
            ],
        ]);

        // Module 2: Shasan Pranali
        $m2 = Module::updateOrCreate(
            ['course_id' => $course->id, 'slug' => 'officer-dosro-patra-shasan-pranali'],
            [
                'title' => 'Dosro Patra: Shasan Pranali ra Sarbajanik Byawasthapan',
                'order' => 2,
                'is_published' => true,
                'description' => 'New Public Management, Federalism, Public Financial Management, Civil Service Integrity, and Strategic Administration.',
                'key_points' => "• New Public Management (NPM) vs Traditional Bureaucracy\n• Three-tier Federal Governance Coordination in Nepal\n• Performance-Based Management, Integrity & Digital Transformation",
                'notes' => 'Detailed administrative mechanisms and governance analysis for 2nd Paper.',
            ]
        );

        $this->createLessonWithQuizzes($m2, 'New Public Management Concepts & Public Policy', 'officer-npm-governance-concepts', 1, [
            [
                'question' => 'Which core concept best distinguishes New Public Management (NPM) from classical Weberian bureaucracy?',
                'options' => ['Strict hierarchical rule compliance', 'Citizen-centric service delivery, performance metrics, and results-based accountability', 'Lifelong tenure security without appraisals', 'Centralized rule-bound budgeting'],
                'answer' => 1,
                'hint' => 'Emphasizes market mechanisms, customer orientation, decentralization, and measuring outputs.',
                'explanation' => 'NPM shifts the focus from rigid procedural compliance to efficiency, outcomes, customer satisfaction, and performance-based management.',
            ],
            [
                'question' => 'Who authored the influential 1992 book "Reinventing Government" that catalyzed global NPM reforms?',
                'options' => ['David Osborne & Ted Gaebler', 'Max Weber & Karl Marx', 'F.W. Taylor & Henry Fayol', 'Herbert Simon & Chester Barnard'],
                'answer' => 0,
                'hint' => 'They proposed "catalytic government that steers rather than rows".',
                'explanation' => 'David Osborne and Ted Gaebler popularized NPM doctrines in their 1992 book "Reinventing Government: How the Entrepreneurial Spirit is Transforming the Public Sector".',
            ],
            [
                'question' => 'What does the term "Fiscal Federalism" specifically entail in Nepal\'s governance system?',
                'options' => ['Total centralization of all revenue in Kathmandu', 'Equitable distribution of tax powers, revenue sharing, fiscal equalization grants, and conditional transfers among Federal, Provincial, and Local tiers', 'Privatization of public banks', 'Elimination of provincial budgets'],
                'answer' => 1,
                'hint' => 'Guided by the National Natural Resources and Fiscal Commission (NNRFC) under Article 250.',
                'explanation' => 'Fiscal federalism divides taxation powers and distributes resources among Federal, Provincial, and Local levels through 4 constitutional grants: Equalization, Conditional, Matching, and Special grants.',
            ],
            [
                'question' => 'Under Nepal\'s Intergovernmental Fiscal Arrangement Act 2074, what percentage of VAT and Domestic Excise Duty is shared with Provincial and Local levels?',
                'options' => ['70% Federal, 15% Provincial, 15% Local', '50% Federal, 25% Provincial, 25% Local', '80% Federal, 10% Provincial, 10% Local', '100% Federal'],
                'answer' => 0,
                'hint' => 'The Federal Government retains 70%, while Provinces and Local units each receive 15%.',
                'explanation' => 'Section 6 of the Intergovernmental Fiscal Arrangement Act distributes Value Added Tax (VAT) and Domestic Excise revenue: 70% Federal, 15% Provincial, and 15% Local Governments.',
            ],
            [
                'question' => 'What is the primary function of the National Natural Resources and Fiscal Commission (NNRFC) in Nepal?',
                'options' => ['Conduct criminal investigations', 'Determine the formula-based allocation of revenue sharing and fiscal grants among federal, provincial, and local governments', 'Draft parliamentary legislation', 'Direct military defense'],
                'answer' => 1,
                'hint' => 'Constitutional body under Part 26, Article 250.',
                'explanation' => 'NNRFC determines the equitable distribution formula for internal revenue and equalization grants across all three tiers of government.',
            ],
            [
                'question' => 'Which of the following is a classic component of "Public Financial Management (PFM)" in civil governance?',
                'options' => ['Medium Term Expenditure Framework (MTEF)', 'Line-item input-only budgeting without reviews', 'Unregistered cash disbursements', 'Elimination of internal auditing'],
                'answer' => 0,
                'hint' => 'A 3-year rolling expenditure plan linking periodic plans with annual budgets.',
                'explanation' => 'The Medium Term Expenditure Framework (MTEF) is an essential PFM tool that bridges long-term national policy priorities with annual national budgets.',
            ],
            [
                'question' => 'In policy analysis, what does "Incrementalism" (formulated by Charles Lindblom) refer to?',
                'options' => ['Radical revolutionary overhaul of all institutions', 'Policy making through small, sequential adjustments to existing policies ("muddling through")', 'Algorithmic computer-automated governance', 'Top-down military dictatorship directives'],
                'answer' => 1,
                'hint' => 'Described as "the science of muddling through" rather than rational-comprehensive planning.',
                'explanation' => 'Charles Lindblom\'s Incremental Model posits that public policy decisions are made through gradual, step-by-step modifications of existing baseline policies.',
            ],
            [
                'question' => 'What is the constitutional quorum required for the Federal Parliament of Nepal to conduct official voting on a legislative bill?',
                'options' => ['One-fourth (25%) of total members', 'One-third (33%) of total members', 'Simple majority (50% + 1)', 'Two-thirds (66.6%) of members'],
                'answer' => 0,
                'hint' => 'Article 94 requires the presence of at least 25% of the total house membership.',
                'explanation' => 'Under Article 94 of the Constitution, unless otherwise provided, no decision shall be made unless at least one-fourth (25%) of total members are present.',
            ],
            [
                'question' => 'Which anti-corruption index published annually by Transparency International ranks global corruption perceptions?',
                'options' => ['Human Development Index (HDI)', 'Corruption Perceptions Index (CPI)', 'Global Peace Index (GPI)', 'Ease of Doing Business Index'],
                'answer' => 1,
                'hint' => 'Measures public sector corruption perception on a score from 0 (highly corrupt) to 100 (very clean).',
                'explanation' => 'Transparency International publishes the annual Corruption Perceptions Index (CPI) ranking countries worldwide.',
            ],
            [
                'question' => 'Under the Good Governance Act 2064, who is designated as the Chief Administrative Officer responsible for ministry-level execution?',
                'options' => ['Cabinet Secretary (Mukhya Sachiv)', 'Secretary of the concerned Ministry (Sachiv)', 'Joint Secretary (Saha-Sachiv)', 'Under Secretary (Upa-Sachiv)'],
                'answer' => 1,
                'hint' => 'The administrative head of each federal ministry holding accounting officer responsibility.',
                'explanation' => 'The Secretary of the Ministry serves as the chief administrative and accounting officer responsible for executive implementation under the Good Governance Act.',
            ],
        ]);
    }

    /* =========================================================================
     * 3. NEPAL RASTRA BANK (NRB) OFFICER TAYARI
     * ========================================================================= */
    private function seedNRBOfficer(): void
    {
        $course = Course::where('slug', 'nrb-officer-tayari')->first();
        if (! $course) {
            return;
        }

        $m1 = Module::updateOrCreate(
            ['course_id' => $course->id, 'slug' => 'nrb-officer-micro-macro-economics'],
            [
                'title' => 'Module 1: Economics (Micro & Macroeconomics)',
                'order' => 1,
                'is_published' => true,
                'description' => 'Demand & supply analysis, market structures, Keynesian & classical macroeconomic models, inflation, monetary transmission, and international trade.',
                'key_points' => "• Price Elasticity of Demand & Supply\n• GDP Calculation Methods (Expenditure, Income, Output)\n• IS-LM Model, Phillips Curve & Monetary Policy Transmission",
                'notes' => 'Comprehensive analytical economics notes for NRB Officer examination.',
            ]
        );

        $this->createLessonWithQuizzes($m1, 'Demand Elasticity, Market Equilibrium & Pricing', 'nrb-econ-demand-elasticity', 1, [
            [
                'question' => 'When the percentage change in quantity demanded is exactly equal to the percentage change in price, elasticity is called:',
                'options' => ['Perfect elasticity (Ed = infinity)', 'Unitary elasticity (Ed = 1)', 'Inelastic demand (Ed < 1)', 'Perfectly inelastic (Ed = 0)'],
                'answer' => 1,
                'hint' => 'A 10% price reduction leads to exactly a 10% increase in quantity demanded.',
                'explanation' => 'Unitary elasticity occurs when price elasticity of demand (|Ed|) equals 1, meaning total revenue remains constant when price changes.',
            ],
            [
                'question' => 'Which of the following describes an "Inferior Good" in economic consumer theory?',
                'options' => ['Demand increases as consumer income rises', 'Demand decreases as consumer income rises (Negative Income Elasticity)', 'Demand is unresponsive to price', 'A luxury commodity with positive elasticity'],
                'answer' => 1,
                'hint' => 'When people get wealthier, they buy less of this low-cost alternative.',
                'explanation' => 'Inferior goods have a negative income elasticity of demand (Ey < 0); as real income increases, consumers substitute them with superior goods.',
            ],
            [
                'question' => 'In a perfectly competitive market, what is the shape of the individual firm\'s demand curve?',
                'options' => ['Downwards sloping', 'Perfect horizontal line at the market price (P = MR = AR)', 'Vertical line', 'U-shaped'],
                'answer' => 1,
                'hint' => 'Firms are price-takers and can sell any quantity at the prevailing market price.',
                'explanation' => 'Because individual firms in perfect competition are price-takers, their demand curve is infinitely elastic (horizontal) where P = AR = MR.',
            ],
            [
                'question' => 'According to the Classical Quantity Theory of Money (Fisher\'s Equation: MV = PT), if money supply (M) doubles while V and T remain constant, what happens to the price level (P)?',
                'options' => ['Price level halves', 'Price level doubles proportionally', 'Price level remains unchanged', 'Velocity decreases'],
                'answer' => 1,
                'hint' => 'Direct and proportional relationship between money supply and general price level.',
                'explanation' => 'Fisher\'s Equation of Exchange posits that changes in the money supply cause direct, equi-proportional changes in the general price level.',
            ],
            [
                'question' => 'What is the formula for calculating Gross Domestic Product (GDP) using the Expenditure Approach?',
                'options' => ['GDP = C + I + G + (X - M)', 'GDP = Wages + Rents + Interests + Profits', 'GDP = Total Output - Intermediate Consumption', 'GDP = Exports - Imports + Subsidies'],
                'answer' => 0,
                'hint' => 'Sum of Consumption (C), Investment (I), Government spending (G), and Net Exports (X - M).',
                'explanation' => 'The expenditure approach computes GDP as: GDP = Consumption (C) + Gross Investment (I) + Government Purchases (G) + Net Exports (X - M).',
            ],
            [
                'question' => 'What economic phenomenon is characterized by high inflation occurring simultaneously with economic stagnation and high unemployment?',
                'options' => ['Deflation', 'Reflation', 'Stagflation', 'Hyperinflation'],
                'answer' => 2,
                'hint' => 'A portmanteau of "stagnation" and "inflation" (first witnessed in 1970s oil shocks).',
                'explanation' => 'Stagflation occurs when an economy experiences stagnant economic growth, high unemployment, and rapidly rising price inflation simultaneously.',
            ],
            [
                'question' => 'In macroeconomics, what does the "IS" curve in the IS-LM model represent?',
                'options' => ['Equilibrium in the money and financial asset market', 'Equilibrium in the goods and services market (Investment = Saving)', 'Labor market equilibrium', 'Balance of payments equilibrium'],
                'answer' => 1,
                'hint' => 'IS stands for Investment and Saving.',
                'explanation' => 'The IS curve depicts combinations of interest rates and output levels where aggregate goods market output equals aggregate demand (I = S).',
            ],
            [
                'question' => 'What does the original Phillips Curve depict in short-run macroeconomic theory?',
                'options' => ['Direct relationship between taxes and government revenue', 'Inverse relationship between rate of inflation and unemployment rate', 'Relationship between income inequality and economic growth', 'Relationship between money supply and exchange rates'],
                'answer' => 1,
                'hint' => 'Lower unemployment is associated with higher wage/price inflation in the short run.',
                'explanation' => 'A.W. Phillips identified a historical inverse tradeoff: when unemployment is low, inflation tends to be high, and vice versa.',
            ],
            [
                'question' => 'What is "Base Money" or "High-Powered Money" (Reserve Money - M0) composed of in central banking?',
                'options' => ['Currency in circulation + Commercial bank deposits at the Central Bank', 'Total savings deposits in private banks', 'Government bonds held by citizens', 'Gold reserves only'],
                'answer' => 0,
                'hint' => 'Monetary base created directly by the central bank (Currency + Bank Reserves).',
                'explanation' => 'Reserve Money (M0) consists of currency in circulation outside the central bank plus bank reserves deposited with the central bank.',
            ],
            [
                'question' => 'What is "Gresham\'s Law" in monetary economics?',
                'options' => ['Good money drives out bad money', '"Bad money drives out good money" when legal tender laws fix their exchange rates', 'Money supply determines real output', 'Low interest rates always create inflation'],
                'answer' => 1,
                'hint' => 'If two currencies circulate with the same nominal face value, people hoard the more valuable commodity.',
                'explanation' => 'Gresham\'s Law states that if coins of differing intrinsic metal value are legally given equal exchange value, undervalued ("bad") money circulates while overvalued ("good") money is hoarded.',
            ],
        ]);
    }

    /* =========================================================================
     * 4. NRB ASSISTANT DIRECTOR TAYARI
     * ========================================================================= */
    private function seedNRBAssistantDirector(): void
    {
        $course = Course::where('slug', 'nrb-assistant-director-tayari')->first();
        if (! $course) {
            return;
        }

        $m1 = Module::updateOrCreate(
            ['course_id' => $course->id, 'slug' => 'nrb-ad-banking-laws-regulations'],
            [
                'title' => 'Module 1: Banking Laws, Directives & Regulatory Framework',
                'order' => 1,
                'is_published' => true,
                'description' => 'NRB Act 2058, BAFIA 2073, FERA 2019, Unified Directives, AML/CFT Act, and Basel III Standards.',
                'key_points' => "• NRB Act 2058 Objectives & Autonomy (Section 4)\n• BAFIA 2073 Licensing, Classification & Governance\n• Unified Directives: Capital Adequacy, NPL Classification & Loan Loss Provisioning",
                'notes' => 'Complete legal & statutory analysis for NRB Assistant Director.',
            ]
        );

        $this->createLessonWithQuizzes($m1, 'NRB Act 2058 & BAFIA 2073 Governance', 'nrb-ad-legal-framework', 1, [
            [
                'question' => 'Under Section 4 of the Nepal Rastra Bank Act 2058, what is the primary statutory objective of NRB?',
                'options' => ['Maximize commercial banking profits', 'Maintain price and balance of payments stability, ensure financial sector stability, and develop a secure payment system', 'Direct political governance of fiscal policy', 'Fix foreign stock prices'],
                'answer' => 1,
                'hint' => 'Core central banking mandate: price stability, financial stability, payment systems.',
                'explanation' => 'NRB Act 2058 Section 4 establishes price stability, external sector stability, financial sector resilience, and reliable electronic payment systems as core objectives.',
            ],
            [
                'question' => 'Who appoints the Governor of Nepal Rastra Bank, and for what term length under NRB Act 2058?',
                'options' => ['President of Nepal for 6 years', 'Government of Nepal, Council of Ministers for a term of 5 years (renewable once)', 'Parliamentary Hearing Committee for 4 years', 'Ministry of Finance for 3 years'],
                'answer' => 1,
                'hint' => 'Appointed by Cabinet on recommendation of a 3-member committee for a 5-year tenure.',
                'explanation' => 'Under Section 15 of NRB Act 2058, the Government of Nepal (Cabinet) appoints the Governor for a tenure of 5 years.',
            ],
            [
                'question' => 'How many members constitute the Board of Directors of Nepal Rastra Bank under Section 14 of the NRB Act?',
                'options' => ['5 Members', '7 Members', '9 Members', '11 Members'],
                'answer' => 1,
                'hint' => 'Governor (Chair), Finance Secretary, 2 Deputy Governors, and 3 appointed expert Directors.',
                'explanation' => 'NRB Board of Directors consists of 7 members: Governor (Chair), Finance Secretary, two Deputy Governors, and three non-executive directors from economic/banking fields.',
            ],
            [
                'question' => 'Under the Bank and Financial Institutions Act (BAFIA) 2073, commercial banks are categorized as which class of institution?',
                'options' => ['"Ka" (Class A) Commercial Banks', '"Kha" (Class B) Development Banks', '"Ga" (Class C) Finance Companies', '"Gha" (Class D) Microfinance Institutions'],
                'answer' => 0,
                'hint' => 'Top tier banking institutions with comprehensive full-service banking powers.',
                'explanation' => 'BAFIA 2073 classifies licensed BFIs into 4 tiers: Class "A" (Commercial Banks), Class "B" (Development Banks), Class "C" (Finance Companies), and Class "D" (Microfinance).',
            ],
            [
                'question' => 'According to NRB Unified Directives, what is the loan loss provision required for a "Good" (Pass) performing loan?',
                'options' => ['1.20% (or current 1.25% as per updated prudential norms)', '5.0%', '25.0%', '100.0%'],
                'answer' => 0,
                'hint' => 'General loan loss provisioning for standard performing loans.',
                'explanation' => 'Performing loans with no overdue days require standard general loan loss provisioning (1.20% to 1.25% under updated NRB prudential directives).',
            ],
            [
                'question' => 'Under NRB Prudential Directives, a loan with principal or interest overdue for more than 90 days up to 180 days is classified as:',
                'options' => ['Good / Pass Loan', 'Substandard Loan', 'Doubtful Loan', 'Loss Loan (Bad Debt)'],
                'answer' => 1,
                'hint' => 'Requires a mandatory 25% loan loss provisioning.',
                'explanation' => 'Non-Performing Loans (NPL) are classified as: Substandard (overdue >90 to 180 days, 25% provision), Doubtful (>180 to 365 days, 50% provision), and Loss (>365 days, 100% provision).',
            ],
            [
                'question' => 'What is the minimum Capital Adequacy Ratio (CAR) under Basel III Capital Framework required for commercial banks in Nepal?',
                'options' => ['6.0% Total Capital', '8.5% Core Capital & 11.0% Total Capital (including Capital Conservation Buffer)', '15.0% Total Capital', '20.0% Total Capital'],
                'answer' => 1,
                'hint' => 'Requires minimum Tier 1 Core Capital of 6% + CCB (2.5%) and Total Capital of 11%.',
                'explanation' => 'NRB Basel III guidelines mandate a minimum Common Equity Tier 1 (CET1) of 4.5%, Tier 1 of 6%, Total Capital of 8.5%, plus a 2.5% Capital Conservation Buffer = 11.0% total CAR.',
            ],
            [
                'question' => 'Under BAFIA 2073, what is the maximum continuous tenure allowed for a Chief Executive Officer (CEO) of a commercial bank?',
                'options' => ['1 term of 3 years', '2 consecutive terms of up to 4 years each (maximum 8 years)', 'Unlimited tenures', '10 years'],
                'answer' => 1,
                'hint' => 'Section 29 limits a CEO to a maximum of two 4-year terms.',
                'explanation' => 'BAFIA Section 29 restricts the CEO of a licensed BFI to a maximum appointment of two consecutive terms of up to 4 years each.',
            ],
            [
                'question' => 'Which unit functioning within Nepal Rastra Bank serves as the national financial intelligence agency for AML/CFT enforcement?',
                'options' => ['Banking Supervision Department', 'Financial Information Unit (FIU-Nepal)', 'Foreign Exchange Department', 'Internal Audit Department'],
                'answer' => 1,
                'hint' => 'Operates independently under the Anti-Money Laundering Act 2064 to receive and analyze Suspicious Transaction Reports (STRs).',
                'explanation' => 'Financial Information Unit (FIU-Nepal), established under Section 9 of the AML Act 2064, is the national central agency for receiving, analyzing, and disseminating STRs and TTRs.',
            ],
            [
                'question' => 'Under Foreign Exchange Regulation Act 2019, who holds the exclusive statutory authority to regulate, license, and inspect foreign exchange dealers in Nepal?',
                'options' => ['Ministry of Finance', 'Nepal Rastra Bank', 'Department of Customs', 'Commercial Banks Association'],
                'answer' => 1,
                'hint' => 'The central bank manages national foreign exchange reserves and licenses money changers.',
                'explanation' => 'Nepal Rastra Bank is the sole regulatory authority governing foreign exchange operations, licensing money exchangers/remittance agencies, and managing foreign reserves.',
            ],
        ]);
    }

    /* =========================================================================
     * 5. NEPAL CONSTITUTION & LAW
     * ========================================================================= */
    private function seedConstitutionAndLaw(): void
    {
        $course = Course::where('slug', 'nepal-constitution-ra-kanun')->first();
        if (! $course) {
            return;
        }

        $m1 = Module::updateOrCreate(
            ['course_id' => $course->id, 'slug' => 'constitution-law-framework-2072'],
            [
                'title' => 'Module 1: Constitutional Law & Fundamental Rights in Nepal',
                'order' => 1,
                'is_published' => true,
                'description' => 'Constitutional history, Preamble, Fundamental Rights (Articles 16-48), Directive Principles, Federal Legislature, Executive, and Judiciary.',
                'key_points' => "• Constitutional Sovereignty, Rule of Law & Republican Framework\n• 31 Fundamental Rights & Constitutional Remedies (Article 46/133)\n• Federal Power Devolution across Federal, Provincial & Local Lists",
                'notes' => 'Exhaustive constitutional law syllabus notes for competitive legal examinations.',
            ]
        );

        $this->createLessonWithQuizzes($m1, 'Fundamental Rights & Constitutional Remedies', 'const-fundamental-rights-remedies', 1, [
            [
                'question' => 'How many specific Fundamental Rights are enshrined in Part 3 of the Constitution of Nepal 2072?',
                'options' => ['21 Rights', '27 Rights', '31 Rights (Articles 16 to 46)', '35 Rights'],
                'answer' => 2,
                'hint' => 'Spans Articles 16 (Right to live with dignity) through 46 (Right to constitutional remedies).',
                'explanation' => 'Part 3 of the Constitution of Nepal guarantees 31 fundamental rights under Articles 16 to 46.',
            ],
            [
                'question' => 'Which Article of the Constitution guarantees the "Right to Constitutional Remedies"?',
                'options' => ['Article 16', 'Article 27', 'Article 32', 'Article 46'],
                'answer' => 3,
                'hint' => 'Described by constitutional jurists as the "heart and soul" that makes all other rights enforceable.',
                'explanation' => 'Article 46 guarantees the Right to Constitutional Remedies, allowing citizens to move the Supreme Court under Article 133 or High Court under Article 144.',
            ],
            [
                'question' => 'Which Article establishes the "Right to Information" (Suchana ko Hak) as a Fundamental Right?',
                'options' => ['Article 25', 'Article 27', 'Article 28', 'Article 31'],
                'answer' => 1,
                'hint' => 'Guarantees the right to demand and receive information on any matter of public interest.',
                'explanation' => 'Article 27 states: "Every citizen shall have the right to demand and receive information on any matter of his or her interest or of public interest."',
            ],
            [
                'question' => 'Which writ is issued by the Supreme Court to command an unlawfully detained person to be produced before the court?',
                'options' => ['Mandamus (Paramesh)', 'Habeas Corpus (Bandi Pratyakshikaran)', 'Certiorari (Utpreshan)', 'Quo Warranto (Adhikar Prichha)'],
                'answer' => 1,
                'hint' => 'Latin for "that you have the body" to protect personal liberty against illegal detention.',
                'explanation' => 'Habeas Corpus is the premier writ safeguarding personal liberty, requiring the detaining authority to produce the arrested individual in court.',
            ],
            [
                'question' => 'Which writ is issued to an inferior court or quasi-judicial body quashing an order passed without jurisdiction?',
                'options' => ['Certiorari (Utpreshan)', 'Prohibition (Pratishedh)', 'Mandamus (Paramesh)', 'Quo Warranto (Adhikar Prichha)'],
                'answer' => 0,
                'hint' => 'Corrective writ that calls up and quashes illegal decisions.',
                'explanation' => 'Certiorari quashes decisions rendered by subordinate courts or administrative tribunals that act without jurisdiction or violate principles of natural justice.',
            ],
            [
                'question' => 'What is the constitutional process required to amend the Constitution of Nepal under Article 274?',
                'options' => ['Simple majority in House of Representatives', 'Two-thirds (2/3) majority of the total existing members in both Houses of Federal Parliament', 'Presidential ordinance only', 'Unanimous cabinet decree'],
                'answer' => 1,
                'hint' => 'Requires a two-thirds supermajority in both House of Representatives and National Assembly.',
                'explanation' => 'Article 274 mandates that an amendment bill must be passed by at least a two-thirds majority of the total existing members in each House of Federal Parliament.',
            ],
            [
                'question' => 'Under Article 168 of the Constitution, what is the primary basis for appointing the Prime Minister of Nepal?',
                'options' => ['Leader of the parliamentary party commanding a clear majority in the House of Representatives', 'Senior-most member of parliament', 'Chief Justice recommendation', 'Elected by the National Assembly'],
                'answer' => 0,
                'hint' => 'Article 168(1) gives first priority to the single party with a clear majority of seats in HoR.',
                'explanation' => 'Article 168(1) specifies that the President shall appoint the parliamentary party leader of the political party commanding a majority in the House of Representatives as PM.',
            ],
            [
                'question' => 'How many members comprise the House of Representatives (Pratinidhi Sabha) of Nepal?',
                'options' => ['205 Members', '240 Members', '275 Members (165 FPTP + 110 Proportional)', '330 Members'],
                'answer' => 2,
                'hint' => '165 directly elected from single-member constituencies and 110 elected through countrywide PR.',
                'explanation' => 'Under Article 84, the House of Representatives consists of 275 members: 165 elected through First-Past-The-Post (60%) and 110 through Proportional Representation (40%).',
            ],
            [
                'question' => 'How many members comprise the National Assembly (Rastriya Sabha), and what is their term length?',
                'options' => ['59 Members serving 6-year staggered terms (1/3 retiring every 2 years)', '60 Members serving 5 years', '75 Members serving 4 years', '50 Members permanent'],
                'answer' => 0,
                'hint' => '56 elected from 7 provinces (8 from each) and 3 nominated by the President; permanent house with 6-year terms.',
                'explanation' => 'Under Article 86, the National Assembly is a permanent house of 59 members with a 6-year tenure, where one-third of members retire every two years.',
            ],
            [
                'question' => 'Which Schedule of the Constitution enumerates the Concurrent (Shared) Powers of the Federation, Provinces, and Local levels?',
                'options' => ['Schedule 5', 'Schedule 7', 'Schedule 8', 'Schedule 9'],
                'answer' => 3,
                'hint' => 'The final schedule containing the 15-item concurrent jurisdiction of all three government tiers.',
                'explanation' => 'Schedule 9 lists the Concurrent Powers of the Federation, Province, and Local levels (e.g., cooperatives, education, health, agriculture, services).',
            ],
        ]);
    }

    /* =========================================================================
     * 6. COMPUTER SKILL PARIKSHA
     * ========================================================================= */
    private function seedComputerSkill(): void
    {
        $course = Course::where('slug', 'computer-sip-pariksha')->first();
        if (! $course) {
            return;
        }

        $m1 = Module::updateOrCreate(
            ['course_id' => $course->id, 'slug' => 'computer-office-os-productivity'],
            [
                'title' => 'Module 1: Operating Systems, MS Office & Nepali Typing',
                'order' => 1,
                'is_published' => true,
                'description' => 'Practical & theoretical computer syllabus covering Windows OS, Word, Excel, PowerPoint, Nepali Unicode, and Internet security.',
                'key_points' => "• MS Word Shortcuts, Mail Merge & Tab Leaders\n• MS Excel VLOOKUP, IF, SUMIF, Pivot Tables & Data Validation\n• Nepali Unicode Romanized/Traditional & Cyber Safety",
                'notes' => 'Complete step-by-step practical guides for PSC Computer Skill Test.',
            ]
        );

        $this->createLessonWithQuizzes($m1, 'MS Word, Excel & Productivity Shortcuts', 'comp-ms-word-excel-mastery', 1, [
            [
                'question' => 'What is the default file extension for Microsoft Word 2016/2019/365 documents?',
                'options' => ['.doc', '.docx', '.txt', '.rtf'],
                'answer' => 1,
                'hint' => 'Introduced with XML-based formatting standard in Office 2007.',
                'explanation' => 'Modern Microsoft Word documents are saved with the XML-based `.docx` file format extension.',
            ],
            [
                'question' => 'Which keyboard shortcut in MS Word is used to create a "Page Break" instantly?',
                'options' => ['Ctrl + Enter', 'Shift + Enter', 'Alt + Enter', 'Ctrl + Shift + Enter'],
                'answer' => 0,
                'hint' => 'Hold Control and tap the Return/Enter key.',
                'explanation' => 'Pressing `Ctrl + Enter` immediately inserts a hard page break at the current cursor location in MS Word.',
            ],
            [
                'question' => 'Which Excel formula correctly adds the values in cells from A1 through A10 only if they are greater than 50?',
                'options' => ['=SUM(A1:A10, ">50")', '=SUMIF(A1:A10, ">50")', '=IF(A1:A10>50, SUM())', '=COUNTIF(A1:A10, 50)'],
                'answer' => 1,
                'hint' => 'Uses the conditional SUMIF function with range and criteria arguments.',
                'explanation' => '`=SUMIF(A1:A10, ">50")` evaluates the range A1:A10 and sums only the cells satisfying the ">50" condition.',
            ],
            [
                'question' => 'In MS Excel, what symbol must precede every mathematical formula or function?',
                'options' => ['#', '@', '=', '+'],
                'answer' => 2,
                'hint' => 'The equal sign tells Excel that the text is a formula to calculate.',
                'explanation' => 'All Excel formulas and functions must begin with an equal sign (`=`).',
            ],
            [
                'question' => 'What is the function of "Mail Merge" in Microsoft Word?',
                'options' => ['Send emails without an internet connection', 'Create personalized letters, certificates, or envelopes in bulk by linking a template with a database/spreadsheet', 'Merge multiple Word documents into a PDF', 'Compress file size'],
                'answer' => 1,
                'hint' => 'Used by public offices to print hundreds of customized exam admission cards or letters at once.',
                'explanation' => 'Mail Merge combines a standard Word document template with a structured data source (Excel/Access) to generate individualized outputs in bulk.',
            ],
            [
                'question' => 'Which Excel feature summarizes large datasets dynamically without altering original source rows, allowing multidimensional grouping?',
                'options' => ['Data Validation', 'Pivot Table', 'Conditional Formatting', 'Goal Seek'],
                'answer' => 1,
                'hint' => 'Found under the Insert tab; allows drag-and-drop multidimensional summaries.',
                'explanation' => 'A PivotTable is an interactive data analysis tool that calculates, summarizes, and groups large tables of data.',
            ],
            [
                'question' => 'In Excel cell referencing, what does placing a dollar sign ($) before a column or row (e.g. $A$1) achieve?',
                'options' => ['Converts the cell value into US Dollars', 'Creates an Absolute Reference that does not change when copied to other cells', 'Hides the cell formula', 'Deletes the cell contents'],
                'answer' => 1,
                'hint' => 'Locks the reference so it stays fixed regardless of copying direction.',
                'explanation' => 'The dollar sign (`$`) locks the column and/or row reference, creating an absolute cell address (e.g., `$A$1`).',
            ],
            [
                'question' => 'What is the official encoding standard used for standardizing Nepali characters across all digital devices and the web?',
                'options' => ['ASCII', 'Preeti TrueType Font', 'Unicode (UTF-8)', 'Kantipur Font'],
                'answer' => 2,
                'hint' => 'Universal character encoding (Nepali Unicode Romanized/Traditional).',
                'explanation' => 'Unicode (UTF-8) provides a unique code point for every character regardless of platform, operating system, or application.',
            ],
            [
                'question' => 'In MS PowerPoint, which view displays thumbnail versions of all slides simultaneously for easy rearranging?',
                'options' => ['Normal View', 'Slide Sorter View', 'Reading View', 'Notes Page View'],
                'answer' => 1,
                'hint' => 'Enables quick drag-and-drop reordering of all slides in the deck.',
                'explanation' => 'Slide Sorter View displays all presentation slides as horizontally arranged thumbnails, ideal for organizing sequence and applying transitions.',
            ],
            [
                'question' => 'Which network protocol securely encrypts web browsing sessions to prevent eavesdropping and data tampering?',
                'options' => ['HTTP', 'HTTPS (SSL/TLS)', 'FTP', 'Telnet'],
                'answer' => 1,
                'hint' => 'Indicated by the padlock icon and port 443 in modern browsers.',
                'explanation' => 'HTTPS (Hypertext Transfer Protocol Secure) encrypts communication between the web browser and server using Transport Layer Security (TLS/SSL).',
            ],
        ]);
    }

    /* =========================================================================
     * 7. IQ & GENERAL APTITUDE
     * ========================================================================= */
    private function seedIQAptitude(): void
    {
        $course = Course::where('slug', 'baudhik-parikshan-iq-aptitude')->first();
        if (! $course) {
            return;
        }

        $m1 = Module::updateOrCreate(
            ['course_id' => $course->id, 'slug' => 'iq-verbal-logical-reasoning'],
            [
                'title' => 'Module 1: Verbal & Logical Reasoning Masterclass',
                'order' => 1,
                'is_published' => true,
                'description' => 'Verbal analogies, classification, syllogisms, blood relations, direction sense, seating arrangement, and critical deduction.',
                'key_points' => "• Word & Semantic Analogies\n• Family Tree & Blood Relations Algorithms\n• Direction Vectors, Distances & Seating Logic",
                'notes' => 'Master logical reasoning formulas and speed shortcuts.',
            ]
        );

        $this->createLessonWithQuizzes($m1, 'Verbal Analogies, Logic & Deduction', 'iq-verbal-analogies-logic', 1, [
            [
                'question' => 'Doctor : Stethoscope :: Sculptor : ?',
                'options' => ['Chisel', 'Anvil', 'Palette', 'Pen'],
                'answer' => 0,
                'hint' => 'Identify the primary instrument/tool used by the professional in their craft.',
                'explanation' => 'A doctor uses a stethoscope as a primary diagnostic tool; a sculptor uses a chisel to carve sculptures.',
            ],
            [
                'question' => 'If CLOCK is coded as KCOLC, how is STEPS coded?',
                'options' => ['SPETS', 'SPSET', 'SPETS', 'STEPZ'],
                'answer' => 0,
                'hint' => 'The letters of the original word are written in reverse sequence.',
                'explanation' => 'The coding rule reverses the entire word: S-T-E-P-S reversed is S-P-E-T-S.',
            ],
            [
                'question' => 'Pointing to a photograph, Rohit said, "She is the daughter of my grandfather\'s only son." How is the girl in the photograph related to Rohit?',
                'options' => ['Mother', 'Sister', 'Cousin', 'Daughter'],
                'answer' => 1,
                'hint' => 'Rohit\'s grandfather\'s only son is Rohit\'s father; the daughter of Rohit\'s father is his...',
                'explanation' => 'Grandfather\'s only son = Rohit\'s father. The daughter of Rohit\'s father is Rohit\'s Sister.',
            ],
            [
                'question' => 'Statements: All mangoes are golden. No golden things are sour. Conclusion: No mangoes are sour.',
                'options' => ['Conclusion follows logically', 'Conclusion does not follow', 'Partially follows', 'Cannot be determined'],
                'answer' => 0,
                'hint' => 'Since all mangoes belong to the golden category, and no golden item can be sour, mangoes cannot be sour.',
                'explanation' => 'By standard syllogistic deduction: Mangoes ⊂ Golden, and Golden ∩ Sour = ∅. Therefore Mangoes ∩ Sour = ∅ (Conclusion follows).',
            ],
            [
                'question' => 'A boy walks 10 meters North, turns right and walks 10 meters, then turns right again and walks 10 meters. How far is he from his starting point?',
                'options' => ['10 meters', '20 meters', '30 meters', '0 meters'],
                'answer' => 0,
                'hint' => 'The vertical movements (+10 North and -10 South) cancel out, leaving only horizontal displacement.',
                'explanation' => 'Vertical position: +10 - 10 = 0. Horizontal position: 10 meters East. Total distance from origin = 10 meters.',
            ],
            [
                'question' => 'In a class of 45 students, Sita ranks 11th from the top. What is her rank from the bottom?',
                'options' => ['34th', '35th', '36th', '37th'],
                'answer' => 1,
                'hint' => 'Apply ranking formula: (Total - Top Rank) + 1.',
                'explanation' => 'Rank from Bottom = Total - Top + 1 = 45 - 11 + 1 = 35th.',
            ],
            [
                'question' => 'Which number replaces the question mark (?) in the matrix: [ [2, 3, 5], [4, 5, 9], [6, 7, ?] ]?',
                'options' => ['11', '12', '13', '14'],
                'answer' => 2,
                'hint' => 'Row logic: The third column is the sum of the first two columns (Row 1: 2+3=5, Row 2: 4+5=9).',
                'explanation' => 'In each row, Column 1 + Column 2 = Column 3. For row 3: 6 + 7 = 13.',
            ],
            [
                'question' => 'If 1st January 2024 was a Monday, what day of the week was 31st January 2024?',
                'options' => ['Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'answer' => 1,
                'hint' => 'Difference is 30 days. Divide 30 by 7 to find the odd days (30 mod 7 = 2).',
                'explanation' => '30 days / 7 = 4 weeks and 2 odd days. Monday + 2 days = Wednesday.',
            ],
            [
                'question' => 'Find the missing number in the sequence: 1, 8, 27, 64, 125, ?',
                'options' => ['196', '216', '256', '343'],
                'answer' => 1,
                'hint' => 'Cubes of consecutive integers: 1^3, 2^3, 3^3, 4^3, 5^3, 6^3.',
                'explanation' => 'The sequence is n^3: 1^3=1, 2^3=8, 3^3=27, 4^3=64, 5^3=125, 6^3=216.',
            ],
            [
                'question' => 'A can complete a piece of work in 10 days, and B can complete it in 15 days. Working together, in how many days will they finish the work?',
                'options' => ['5 Days', '6 Days', '8 Days', '9 Days'],
                'answer' => 1,
                'hint' => 'Combined rate = (1/10 + 1/15) = (3+2)/30 = 5/30 = 1/6.',
                'explanation' => 'Combined 1-day work = 1/10 + 1/15 = 1/6. Therefore, together they will finish the work in 6 days.',
            ],
        ]);
    }

    /* =========================================================================
     * 8. NEPAL TELECOM TAYARI
     * ========================================================================= */
    private function seedNepalTelecom(): void
    {
        $course = Course::where('slug', 'nepal-telecom-tayari')->first();
        if (! $course) {
            return;
        }

        $m1 = Module::updateOrCreate(
            ['course_id' => $course->id, 'slug' => 'ntc-telecommunication-networks'],
            [
                'title' => 'Module 1: Telecommunication Networks, Cellular & Optical Systems',
                'order' => 1,
                'is_published' => true,
                'description' => 'Telecommunication switching, GSM/LTE/5G mobile architectures, Optical FTTH, IP Routing, and Nepal Telecommunications Act 2053.',
                'key_points' => "• Mobile Generations: 2G GSM, 3G UMTS, 4G LTE, 5G NR Architectures\n• Optical Fiber Transmission (WDM, GPON/FTTH)\n• Nepal Telecommunications Act 2053 & NTA Regulation",
                'notes' => 'Complete technical and regulatory study notes for Nepal Telecom recruitment examinations.',
            ]
        );

        $this->createLessonWithQuizzes($m1, 'Cellular Mobile Systems & Optical Fiber Networks', 'ntc-cellular-optical-systems', 1, [
            [
                'question' => 'In GSM mobile communication architecture, which network element stores the primary permanent subscription information and subscriber location data?',
                'options' => ['Visitor Location Register (VLR)', 'Home Location Register (HLR)', 'Equipment Identity Register (EIR)', 'Base Transceiver Station (BTS)'],
                'answer' => 1,
                'hint' => 'The permanent central database containing SIM details, IMSI, and authentication keys.',
                'explanation' => 'Home Location Register (HLR) is the central database that contains details of each mobile phone subscriber authorized to use the GSM core network.',
            ],
            [
                'question' => 'What is the main transmission technology utilized in 4G LTE mobile downlink communication to prevent multipath fading?',
                'options' => ['CDMA', 'OFDMA (Orthogonal Frequency Division Multiple Access)', 'TDMA', 'Pure FM'],
                'answer' => 1,
                'hint' => 'Splits wideband channels into hundreds of narrow orthogonal subcarriers.',
                'explanation' => 'LTE downlink employs OFDMA (Orthogonal Frequency Division Multiple Access), which provides high spectral efficiency and robust resistance to multipath fading.',
            ],
            [
                'question' => 'What optical wavelength band is predominantly utilized for long-distance single-mode fiber optic transmission due to minimal attenuation?',
                'options' => ['850 nm', '1310 nm & 1550 nm', '650 nm', '980 nm'],
                'answer' => 1,
                'hint' => '1550 nm corresponds to the lowest optical loss (attenuation ~0.2 dB/km) in silica glass fibers.',
                'explanation' => '1310 nm (zero-dispersion window) and 1550 nm (lowest-attenuation window ~0.2 dB/km) are the standard wavelengths for single-mode optical fiber communications.',
            ],
            [
                'question' => 'In GPON (Gigabit Passive Optical Network) architecture used in FTTH, what device splits optical signals to multiple subscriber premises without requiring electrical power?',
                'options' => ['Optical Line Terminal (OLT)', 'Passive Optical Splitter', 'Optical Network Unit (ONU)', 'Ethernet Switch'],
                'answer' => 1,
                'hint' => 'Unpowered optical component that splits laser power into 1:32 or 1:64 customer fibers.',
                'explanation' => 'Passive Optical Splitters are unpowered optical devices that divide optical signals from one feeder fiber to multiple distribution fibers (typically 1:32 or 1:64 splits).',
            ],
            [
                'question' => 'Under the Nepal Telecommunications Act 2053, which regulatory body is empowered to allocate radio frequency spectrum and license telecom operators in Nepal?',
                'options' => ['Ministry of Communication and Information Technology', 'Nepal Telecommunications Authority (NTA)', 'Nepal Telecom (NTC)', 'Radio Nepal'],
                'answer' => 1,
                'hint' => 'Autonomous regulatory authority established under Section 3 of the Telecom Act 2053.',
                'explanation' => 'Nepal Telecommunications Authority (NTA) is the autonomous regulatory body established under the Telecommunications Act 2053 to regulate telecommunications services.',
            ],
            [
                'question' => 'Which standard IP addressing format uses 128-bit addresses to provide virtually unlimited unique network addresses?',
                'options' => ['IPv4', 'IPv6', 'MAC Address (48-bit)', 'Subnet Mask'],
                'answer' => 1,
                'hint' => 'Next-generation IP protocol replacing 32-bit IPv4.',
                'explanation' => 'IPv6 uses a 128-bit address space, allowing 2^128 (approx 3.4 x 10^38) unique IP addresses.',
            ],
            [
                'question' => 'What does "SIM" stand for in mobile telecommunications?',
                'options' => ['Subscriber Identity Module', 'System Information Memory', 'Satellite Interface Module', 'Secure Internet Mechanism'],
                'answer' => 0,
                'hint' => 'Smart card integrated circuit storing international mobile subscriber identity (IMSI).',
                'explanation' => 'SIM stands for Subscriber Identity Module, which securely stores the IMSI number and its related cryptographic keys.',
            ],
            [
                'question' => 'In networking, at which layer of the OSI 7-layer model do IP Routers primarily operate?',
                'options' => ['Layer 1 (Physical)', 'Layer 2 (Data Link)', 'Layer 3 (Network Layer)', 'Layer 4 (Transport Layer)'],
                'answer' => 2,
                'hint' => 'Responsible for packet forwarding, routing tables, and logical IP addressing.',
                'explanation' => 'Routers operate at Layer 3 (Network Layer) of the OSI model, determining the best path to forward data packets across interconnected networks.',
            ],
            [
                'question' => 'What is the full form of VoLTE in modern cellular voice communications?',
                'options' => ['Voice over Long Term Evolution', 'Variable Optical Line Termination Equipment', 'Visual Online Live Telephony Engine', 'Virtual Open LTE'],
                'answer' => 0,
                'hint' => 'High-definition voice calling delivered over 4G LTE data networks.',
                'explanation' => 'VoLTE stands for Voice over Long-Term Evolution, enabling HD voice calls over 4G LTE networks without dropping down to legacy 2G/3G networks.',
            ],
            [
                'question' => 'Which fund, established under the Nepal Telecommunications Act 2053, is utilized to expand broadband connectivity in rural and remote areas of Nepal?',
                'options' => ['Universal Service Obligation Fund / Rural Telecommunication Development Fund (RTDF)', 'National Telecom Reserve Fund', 'Postal Savings Fund', 'Digital Nepal Equity Fund'],
                'answer' => 0,
                'hint' => 'Telecom operators contribute 2% of their annual gross income to this fund.',
                'explanation' => 'Section 30 of the Telecom Act establishes the Rural Telecommunications Development Fund (RTDF), financed by a 2% levy on telecom operators\' gross revenues to build rural broadband infrastructure.',
            ],
        ]);
    }

    /* =========================================================================
     * HELPER METHOD: Creates or updates a lesson with verified 10 quiz questions
     * ========================================================================= */
    private function createLessonWithQuizzes(Module $module, string $title, string $slug, int $order, array $quizzes): void
    {
        Lesson::updateOrCreate(
            ['module_id' => $module->id, 'slug' => $slug],
            [
                'title' => $title,
                'order' => $order,
                'type' => 'text',
                'duration_minutes' => 25,
                'is_published' => true,
                'content' => "<h3>{$title}</h3><p>Comprehensive syllabus study material for <strong>{$module->title}</strong>. Review key concepts, legal frameworks, and take the 10-question practice quiz below.</p>",
                'quiz_questions' => $quizzes,
            ]
        );
    }
}
