<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class FullCurriculumSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Nayab Subba
        $this->cleanAndSeedNasu();

        // 2. Section Officer
        $this->cleanAndSeedSectionOfficer();

        // 3. NRB Officer
        $this->cleanAndSeedNRBOfficer();

        // 4. NRB Assistant Director
        $this->cleanAndSeedNRBAD();

        // 5. Nepal Constitution & Law
        $this->cleanAndSeedConstitutionLaw();

        // 6. Computer Skill Pariksha
        $this->cleanAndSeedComputerSkill();

        // 7. IQ & General Aptitude
        $this->cleanAndSeedIQAptitude();

        // 8. Nepal Telecom
        $this->cleanAndSeedTelecom();
    }

    private function cleanCourse(string $courseSlug): ?Course
    {
        $course = Course::where('slug', $courseSlug)->first();
        if (! $course) {
            return null;
        }

        // Clean existing modules and lessons for this non-Kharidar course
        $modules = Module::where('course_id', $course->id)->get();
        foreach ($modules as $m) {
            Lesson::where('module_id', $m->id)->delete();
            $m->delete();
        }

        return $course;
    }

    /* -------------------------------------------------------------
     * 1. NAYAB SUBBA
     * ------------------------------------------------------------- */
    private function cleanAndSeedNasu(): void
    {
        $course = $this->cleanCourse('nayab-subba-tayari');
        if (! $course) {
            return;
        }

        // Module 1: GK
        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Pratham Patra: Samanya Gyan (General Knowledge)',
            'slug' => 'nasu-pratham-patra-samanya-gyan',
            'order' => 1,
            'is_published' => true,
            'description' => 'Official Loksewa Nayab Subba 1st Paper General Knowledge syllabus.',
            'key_points' => "• Geography of Nepal & Climate Zones\n• History of Modern Nepal & Unification\n• Social, Cultural & International Affairs",
            'notes' => 'Comprehensive theoretical and factual notes for Nayab Subba GK.',
        ]);

        $this->addLesson($m1, 'Physical Geography of Nepal & Ecological Zones', 'nasu-geography-of-nepal', 1, [
            ['question' => 'What is the total geographical area of Nepal?', 'options' => ['147,181 sq km', '147,516 sq km', '148,000 sq km', '147,100 sq km'], 'answer' => 0, 'hint' => 'The official area measured at 147,181 square kilometers.', 'explanation' => 'Nepal has an area of 147,181 sq km, spanning 885 km East-West and 193 km North-South.'],
            ['question' => 'Which is the highest peak in the Mahabharat mountain range?', 'options' => ['Sailung', 'Phulchoki (2,782 m)', 'Chandragiri', 'Daman'], 'answer' => 1, 'hint' => 'Located in Lalitpur district at an altitude of 2,782 meters.', 'explanation' => 'Phulchoki (2,782 m) is the highest elevation point of the Mahabharat range around Kathmandu Valley.'],
            ['question' => 'Which river in Nepal is known as the "Sorrow of Bihar" after entering India?', 'options' => ['Gandaki', 'Koshi River', 'Karnali', 'Mahakali'], 'answer' => 1, 'hint' => 'The largest river of Nepal by water volume.', 'explanation' => 'Koshi River is infamous for massive floods in Bihar, India.'],
            ['question' => 'What percentage of Nepal\'s total area is occupied by the Terai ecological region?', 'options' => ['Approx 17%', 'Approx 25%', 'Approx 35%', 'Approx 68%'], 'answer' => 0, 'hint' => 'Occupies less than one-fifth of the total national land.', 'explanation' => 'Terai occupies ~17%, Hills ~68%, and Mountains ~15% of Nepal\'s geography.'],
            ['question' => 'Which lake in Nepal is located at the highest altitude?', 'options' => ['Rara Lake', 'Shey Phoksundo Lake', 'Tilicho / Kajin Sara Lake', 'Gosaikunda'], 'answer' => 2, 'hint' => 'Located in Manang district above 4,900 meters.', 'explanation' => 'Tilicho Lake (4,919 m) and Kajin Sara Lake (5,200 m) in Manang hold highest elevation records.'],
            ['question' => 'Which two districts of Nepal border both India and China?', 'options' => ['Taplejung & Darchula', 'Jhapa & Kanchanpur', 'Solukhumbu & Mustang', 'Rasuwa & Humla'], 'answer' => 0, 'hint' => 'One at the eastern extremity and one at the western extremity.', 'explanation' => 'Taplejung in the East and Darchula in the Far-West border both India and China.'],
            ['question' => 'Which mountain pass connects Upper Mustang with Tibet, China?', 'options' => ['Kodari Pass', 'Korala Pass', 'Kimathanka Pass', 'Rasuwagadhi Pass'], 'answer' => 1, 'hint' => 'Located in Upper Mustang at 4,660 meters.', 'explanation' => 'Korala Pass connects Mustang with Tibet, China.'],
            ['question' => 'Nepal Standard Time (NST) is based on which meridian and longitude?', 'options' => ['Mt. Gaurishankar (86°15\' E)', 'Mt. Everest (86°55\' E)', 'Mt. Annapurna (83°45\' E)', 'Mt. Manaslu (84°30\' E)'], 'answer' => 0, 'hint' => 'Calculated from Mt. Gaurishankar meridian, GMT +5:45.', 'explanation' => 'Nepal Standard Time is calculated based on Mt. Gaurishankar (86°15\' E), exact GMT +5:45.'],
            ['question' => 'Which is the longest glacier in Nepal?', 'options' => ['Khumbu Glacier', 'Ngozumpa Glacier (36 km)', 'Langtang Glacier', 'Yalung Glacier'], 'answer' => 1, 'hint' => 'Located below Cho Oyu in the Everest region.', 'explanation' => 'Ngozumpa Glacier (36 km) is Nepal\'s longest glacier.'],
            ['question' => 'Which national park was established as the first national park of Nepal in 1973 AD?', 'options' => ['Bardia National Park', 'Chitwan National Park (2030 BS)', 'Sagarmatha National Park', 'Rara National Park'], 'answer' => 1, 'hint' => 'Located in the Terai lowlands, famous for one-horned rhinos.', 'explanation' => 'Chitwan National Park was established in 1973 AD (2030 BS) as Nepal\'s first national park.'],
        ]);

        $this->addLesson($m1, 'History of Modern Nepal & Unification', 'nasu-history-of-nepal', 2, [
            ['question' => 'On which date did Prithvi Narayan Shah conquer Kantipur (Kathmandu)?', 'options' => ['1825 BS Ashwin 13 (Indra Jatra)', '1815 BS Baisakh 1', '1831 BS Magh 1', '1801 BS Chaitra 25'], 'answer' => 0, 'hint' => 'Conquered during the night of Indra Jatra in 1825 BS.', 'explanation' => 'King Prithvi Narayan Shah annexed Kantipur on 1825 BS Ashwin 13.'],
            ['question' => 'Who was the last Malla king of Bhaktapur before unification?', 'options' => ['Jaya Prakash Malla', 'Ranajit Malla', 'Tej Narsingh Malla', 'Yaksha Malla'], 'answer' => 1, 'hint' => 'He was the Mit-father of Prithvi Narayan Shah.', 'explanation' => 'Ranajit Malla was the last Malla ruler of Bhaktapur.'],
            ['question' => 'The Treaty of Sugauli was ratified in which year between Nepal and British India?', 'options' => ['1814 AD', '1816 AD (March 4)', '1846 AD', '1857 AD'], 'answer' => 1, 'hint' => 'Concluded the Anglo-Nepalese War.', 'explanation' => 'The Sugauli Treaty was ratified on 4 March 1816 AD.'],
            ['question' => 'Who was the commander who led the defense of Nalapani (Khalanga) fort against the British?', 'options' => ['Amar Singh Thapa', 'Balbhadra Kunwar', 'Bhakti Thapa', 'Kalu Pande'], 'answer' => 1, 'hint' => 'Fiercely held Khalanga fort with 600 soldiers.', 'explanation' => 'Captain Balbhadra Kunwar commanded the heroic resistance at the Battle of Nalapani in 1814.'],
            ['question' => 'The Kot Massacre occurred on which date in Nepalese history?', 'options' => ['1903 BS Ashwin 2', '1907 BS Falgun 7', '1882 BS Baisakh 1', '1911 BS Poush 1'], 'answer' => 0, 'hint' => 'Occurred on 14 September 1846 AD, bringing Jung Bahadur to power.', 'explanation' => 'The Kot Massacre occurred on 1903 BS Ashwin 2, establishing 104 years of Rana rule.'],
            ['question' => 'Who was the Rana Prime Minister known as the "Father of Education"?', 'options' => ['Jung Bahadur Rana', 'Dev Shumsher Rana', 'Chandra Shumsher Rana', 'Juddha Shumsher Rana'], 'answer' => 1, 'hint' => 'Started over 150 Bhasha Pathshalas and Gorkhapatra in 1958 BS.', 'explanation' => 'Dev Shumsher established primary schools and initiated Gorkhapatra publication.'],
            ['question' => 'When was the historic Muluki Ain first enacted by Jung Bahadur Rana?', 'options' => ['1903 BS', '1910 BS (1854 AD)', '1925 BS', '1950 BS'], 'answer' => 1, 'hint' => 'The first comprehensive written code of Nepal.', 'explanation' => 'Jung Bahadur Rana promulgated the Muluki Ain in 1910 BS (1854 AD).'],
            ['question' => 'When did Nepal officially become a Federal Democratic Republic?', 'options' => ['2063 BS Baisakh 11', '2065 BS Jestha 15 (28 May 2008)', '2072 BS Ashwin 3', '2062 BS Mangsir 7'], 'answer' => 1, 'hint' => 'Abolished the 240-year-old monarchy at the 1st Constituent Assembly meeting.', 'explanation' => 'The First CA declared Nepal a Federal Democratic Republic on 2065 BS Jestha 15.'],
            ['question' => 'Who was the first elected Prime Minister of Nepal?', 'options' => ['Matrika Prasad Koirala', 'B.P. Koirala (Bishweshwar Prasad Koirala)', 'Tanka Prasad Acharya', 'K.I. Singh'], 'answer' => 1, 'hint' => 'Elected after the 2015 BS General Elections.', 'explanation' => 'B.P. Koirala took office as Nepal\'s first elected PM in 2016 BS (1959 AD).'],
            ['question' => 'Which Lichhavi king introduced the first recorded coin of Nepal named "Manaank"?', 'options' => ['King Mandev I', 'King Anshuverma', 'King Narendra Dev', 'King Shiva Dev'], 'answer' => 0, 'hint' => 'Erected the Changu Narayan pillar inscription in 521 BS (464 AD).', 'explanation' => 'King Mandev I issued the Manaank coin and erected the Changu Narayan inscription.'],
        ]);

        // Module 2: IQ
        $m2 = Module::create([
            'course_id' => $course->id,
            'title' => 'Pratham Patra: Samanya Bauddhik Parikshan (General Intelligent Test - IQ)',
            'slug' => 'nasu-pratham-patra-iq',
            'order' => 2,
            'is_published' => true,
            'description' => 'Verbal, Non-Verbal, Quantitative, and Logical IQ syllabus for Nayab Subba.',
            'key_points' => "• Series, Analogies & Coding-Decoding\n• Direction Sense, Ranking & Blood Relations\n• Venn Diagrams & Deductive Logic",
            'notes' => 'Complete techniques, formulas and shortcuts for Nayab Subba IQ.',
        ]);

        $this->addLesson($m2, 'Number & Letter Series Patterns', 'nasu-number-letter-series', 1, [
            ['question' => 'Find the missing number in the series: 3, 7, 15, 31, 63, ?', 'options' => ['95', '115', '127', '129'], 'answer' => 2, 'hint' => 'Pattern: (Number * 2) + 1.', 'explanation' => 'Rule is (2n + 1): 63 * 2 + 1 = 127.'],
            ['question' => 'Find the missing number: 2, 6, 12, 20, 30, 42, ?', 'options' => ['52', '56', '60', '64'], 'answer' => 1, 'hint' => 'Differences are +4, +6, +8, +10, +12, +14.', 'explanation' => '42 + 14 = 56 (or 7 * 8 = 56).'],
            ['question' => 'Find the next letter in the series: B, D, G, K, P, ?', 'options' => ['U', 'V', 'W', 'X'], 'answer' => 1, 'hint' => 'Positions jump by +2, +3, +4, +5, +6.', 'explanation' => 'P(16) + 6 = V(22).'],
            ['question' => 'If CAT is coded as DBU, how is DOG coded in that language?', 'options' => ['EPH', 'DOG', 'FQJ', 'EPG'], 'answer' => 0, 'hint' => 'Shift each letter forward by 1 (+1).', 'explanation' => 'D(+1)=E, O(+1)=P, G(+1)=H -> EPH.'],
            ['question' => 'Find the odd one out: 27, 64, 125, 144, 216, 343', 'options' => ['27', '64', '144', '343'], 'answer' => 2, 'hint' => 'Check which number is NOT a cube of an integer.', 'explanation' => '144 is 12^2 (square), while all others are perfect cubes (3^3, 4^3, 5^3, 6^3, 7^3).'],
            ['question' => 'Complete the sequence: 4, 9, 25, 49, 121, 169, ?', 'options' => ['196', '225', '289', '361'], 'answer' => 2, 'hint' => 'Squares of consecutive prime numbers: 2^2, 3^2, 5^2, 7^2, 11^2, 13^2, 17^2.', 'explanation' => '17^2 = 289.'],
            ['question' => 'A person walks 5 km South, turns left and walks 3 km, then turns left and walks 5 km. Where is he from the starting point?', 'options' => ['North', 'South', '3 km East', '3 km West'], 'answer' => 2, 'hint' => 'Vertical moves cancel out, leaving net eastward move.', 'explanation' => 'Net displacement is 3 km East.'],
            ['question' => 'Introducing a boy, a woman says: "His mother is the only daughter of my mother." How is she related to the boy?', 'options' => ['Sister', 'Aunt', 'Mother', 'Grandmother'], 'answer' => 2, 'hint' => 'The only daughter of the woman\'s mother is herself.', 'explanation' => 'The woman is talking about herself, so she is the boy\'s Mother.'],
            ['question' => 'In a row of 35 students, Ramesh is 17th from the left. What is his position from the right?', 'options' => ['18th', '19th', '20th', '21st'], 'answer' => 1, 'hint' => 'Formula: Total - Left + 1.', 'explanation' => 'Position = 35 - 17 + 1 = 19th.'],
            ['question' => 'If "+" means multiplication, "-" means division, "*" means addition, and "/" means subtraction, solve: 20 - 4 + 3 * 6 / 2', 'options' => ['17', '19', '21', '23'], 'answer' => 1, 'hint' => 'Substitute operators and apply BODMAS.', 'explanation' => '(20 / 4 * 3) + 6 - 2 = 15 + 6 - 2 = 19.'],
        ]);

        // Module 3: Office Management
        $m3 = Module::create([
            'course_id' => $course->id,
            'title' => 'Dosro Patra: Samanya Prashasan ra Karyalaya Byawasthapan',
            'slug' => 'nasu-dosro-patra-prashasan',
            'order' => 3,
            'is_published' => true,
            'description' => 'Administration principles, filing systems, secretarial procedures, citizen charters, and government accounting.',
            'key_points' => "• Office Procedures (Darta, Chalani, Tippani, File Indexing)\n• Civil Service Act 2049 & Code of Ethics\n• Public Procurement, Audit Systems & Good Governance Act 2064",
            'notes' => 'Detailed administrative mechanisms and office management notes.',
        ]);

        $this->addLesson($m3, 'Public Administration & Civil Service System', 'nasu-admin-principles', 1, [
            ['question' => 'Who is recognized as the "Father of Modern Public Administration"?', 'options' => ['Max Weber', 'Woodrow Wilson', 'Luther Gulick', 'Henri Fayol'], 'answer' => 1, 'hint' => 'Former US President who authored the 1887 study on administration.', 'explanation' => 'Woodrow Wilson founded modern public administration in his 1887 essay.'],
            ['question' => 'Under the Civil Service Act 2049, what is the probationary period for a newly appointed female employee?', 'options' => ['6 Months', '1 Year', '2 Years', 'No probation'], 'answer' => 0, 'hint' => 'Females have 6 months probation, while males have 1 year.', 'explanation' => 'Section 10 of the Civil Service Act specifies 6 months for females and 1 year for males.'],
            ['question' => 'What is the retention period for Class "Ka" (Category A) government records?', 'options' => ['5 Years', '10 Years', '20 Years', 'Permanent (Sadhainbhari)'], 'answer' => 3, 'hint' => 'Treaties, boundary maps, and foundational national documents.', 'explanation' => 'Class "Ka" government records are of permanent national value and preserved permanently.'],
            ['question' => 'Which section of a formal Tippani (Executive Note) contains the final administrative order / approval?', 'options' => ['Fact Section', 'Legal Reference', 'Opinion', 'Nirnaya (Final Order / Approval)'], 'answer' => 3, 'hint' => 'The concluding decision signed by the authorized officer.', 'explanation' => 'A Tippani concludes with the "Nirnaya" authorized by the competent executive authority.'],
            ['question' => 'Under the Right to Information Act 2064, within how many hours must information concerning life and liberty be provided?', 'options' => ['12 Hours', '24 Hours', '48 Hours', '7 Days'], 'answer' => 1, 'hint' => 'Urgent life-threatening queries must be answered within 1 day.', 'explanation' => 'Section 7(4) mandates that life/liberty information must be provided within 24 hours.'],
            ['question' => 'What percentage of civil service posts are allocated to open competition and inclusive reservation under Civil Service Act 2049?', 'options' => ['50% Open & 50% Reserved', '55% Open & 45% Reserved', '60% Open & 40% Reserved', '70% Open & 30% Reserved'], 'answer' => 1, 'hint' => '45% is set aside for inclusive clusters.', 'explanation' => '55% is open competition and 45% is reserved for inclusive groups (Women, Janajati, Madhesi, Dalit, etc.).'],
            ['question' => 'Which computerized accounting system is used across all government offices in Nepal?', 'options' => ['SAP Financials', 'CGAS (Computerized Government Accounting System)', 'QuickBooks', 'Tally Prime'], 'answer' => 1, 'hint' => 'Managed under the Financial Comptroller General Office (FCGO).', 'explanation' => 'CGAS is the mandatory accounting platform implemented by FCGO Nepal.'],
            ['question' => 'According to the Good Governance Act 2064, what must all service-providing public agencies display at their office entrance?', 'options' => ['Annual Budget', 'Citizen Charter (Nagarik Bada-patra)', 'Staff Attendance', 'Audit Report'], 'answer' => 1, 'hint' => 'Details services, fees, timeframe, and responsible official.', 'explanation' => 'Section 25 mandates a prominent Citizen Charter in every public office.'],
            ['question' => 'Who conducts the final statutory financial audit of all government entities in Nepal?', 'options' => ['Auditor General of Nepal (Maha Lekhaparikshak)', 'FCGO', 'Ministry of Finance', 'CIAA'], 'answer' => 0, 'hint' => 'Constitutional body under Part 22, Article 240.', 'explanation' => 'The Auditor General conducts the constitutional final audit under Article 241.'],
            ['question' => 'Under Public Procurement Act 2063, what is the standard threshold for sealed quotation procurement for goods in Nepal?', 'options' => ['Up to Rs 5 Lakhs', 'Rs 20 Lakhs to Rs 1 Crore', 'Above Rs 5 Crore', 'Up to Rs 1 Lakh'], 'answer' => 1, 'hint' => 'Purchases within 20 Lakhs to 1 Crore require sealed quotations.', 'explanation' => 'Procurement Rules outline specific thresholds for direct purchase, sealed quotation, and open national bidding.'],
        ]);

        // Module 4: Constitution & Law
        $m4 = Module::create([
            'course_id' => $course->id,
            'title' => 'Tesro Patra: Samvidhan, Kanoon ra Nyaya Prashasan',
            'slug' => 'nasu-tesro-patra-samvidhan-kanoon',
            'order' => 4,
            'is_published' => true,
            'description' => 'Constitution of Nepal 2072, Fundamental Rights, Legal Frameworks, Judicial System, and Local Governance.',
            'key_points' => "• Constitution of Nepal 2072 (35 Parts, 308 Articles, 9 Schedules)\n• Muluki Civil & Criminal Codes\n• Local Government Operation Act 2074",
            'notes' => 'Detailed legal analysis, case laws, and statutory articles for 3rd Paper.',
        ]);

        $this->addLesson($m4, 'Constitution of Nepal 2072 Key Articles', 'nasu-constitution-core-articles', 1, [
            ['question' => 'How many Parts, Articles, and Schedules are there in the Constitution of Nepal 2072?', 'options' => ['30 Parts, 300 Articles, 7 Schedules', '35 Parts, 308 Articles, 9 Schedules', '32 Parts, 295 Articles, 8 Schedules', '36 Parts, 315 Articles, 10 Schedules'], 'answer' => 1, 'hint' => 'Promulgated on 2072 Ashwin 3.', 'explanation' => 'The Constitution contains 35 Parts, 308 Articles, and 9 Schedules.'],
            ['question' => 'Which Article of the Constitution guarantees the "Right to Equality"?', 'options' => ['Article 16', 'Article 17', 'Article 18', 'Article 20'], 'answer' => 2, 'hint' => 'Ensures non-discrimination by origin, religion, race, sex, or caste.', 'explanation' => 'Article 18 guarantees the Right to Equality.'],
            ['question' => 'Under Article 17 of the Constitution, how many specific fundamental freedoms are guaranteed to citizens?', 'options' => ['4 Freedoms', '5 Freedoms', '6 Freedoms', '8 Freedoms'], 'answer' => 2, 'hint' => 'Expression, peaceful assembly, association, movement, residence, and profession.', 'explanation' => 'Article 17(2) guarantees 6 specific fundamental freedoms.'],
            ['question' => 'According to the Constitution, within how many days must the President certify a submitted Bill?', 'options' => ['7 Days', '15 Days', '30 Days', '45 Days'], 'answer' => 1, 'hint' => '15-day constitutional deadline under Article 113.', 'explanation' => 'Article 113 stipulates that the President shall certify a bill within 15 days.'],
            ['question' => 'Which Schedule of the Constitution defines the Exclusive Powers of Local Governments?', 'options' => ['Schedule 5', 'Schedule 6', 'Schedule 7', 'Schedule 8'], 'answer' => 3, 'hint' => 'Schedule 8 contains the 22 exclusive local government powers.', 'explanation' => 'Schedule 8 lists the 22 exclusive powers of Gaunpalika and Nagarpalika.'],
            ['question' => 'What is the mandatory retirement age for Chief Justice and Supreme Court Justices of Nepal?', 'options' => ['58 Years', '60 Years', '63 Years', '65 Years'], 'answer' => 3, 'hint' => 'Supreme Court judges retire at 65, High Court at 63.', 'explanation' => 'Article 129(5) sets the Supreme Court retirement age at 65 years.'],
            ['question' => 'Who chairs the Constitutional Council (Samvidhanik Parishad) of Nepal?', 'options' => ['President of Nepal', 'Prime Minister of Nepal', 'Chief Justice', 'Speaker of HoR'], 'answer' => 1, 'hint' => 'Chaired by the Prime Minister under Article 284.', 'explanation' => 'Article 284 states the PM chairs the Constitutional Council.'],
            ['question' => 'Under which Article can the Supreme Court issue extraordinary constitutional writs?', 'options' => ['Article 133', 'Article 144', 'Article 150', 'Article 217'], 'answer' => 0, 'hint' => 'Article 133 for Supreme Court and Article 144 for High Courts.', 'explanation' => 'Article 133 confers extraordinary jurisdiction to issue writs to enforce fundamental rights.'],
            ['question' => 'Which constitutional body conducts examinations to recruit civil servants in Nepal?', 'options' => ['Public Service Commission (Lok Sewa Aayog)', 'CIAA', 'NHRC', 'Election Commission'], 'answer' => 0, 'hint' => 'Constitutional organ under Part 23, Article 242.', 'explanation' => 'The Public Service Commission conducts competitive examinations under Article 243.'],
            ['question' => 'According to Article 48 of the Constitution, how many fundamental duties of citizens are specified?', 'options' => ['3 Duties', '4 Duties', '5 Duties', '7 Duties'], 'answer' => 1, 'hint' => 'Safeguard nationality, abide by constitution, render service, protect public property.', 'explanation' => 'Article 48 outlines 4 fundamental duties for all citizens.'],
        ]);
    }

    /* -------------------------------------------------------------
     * 2. SECTION OFFICER TAYARI
     * ------------------------------------------------------------- */
    private function cleanAndSeedSectionOfficer(): void
    {
        $course = $this->cleanCourse('section-officer-tayari');
        if (! $course) {
            return;
        }

        // Module 1: GK & AAT
        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Pratham Patra: Administrative Aptitude Test (GK & AAT)',
            'slug' => 'officer-pratham-patra-gk-aat',
            'order' => 1,
            'is_published' => true,
            'description' => 'General Knowledge, Global Geopolitics, Analytical Reasoning, and Critical Decision-Making for Section Officer.',
            'key_points' => "• World Geopolitics, UN Treaties & Climate Conventions\n• Analytical Problem Solving & Critical Reasoning\n• Constitutional Jurisprudence & Public Policy",
            'notes' => 'Complete theoretical and analytical notes for Section Officer 1st Paper.',
        ]);

        $this->addLesson($m1, 'Global Governance, Treaties & Diplomacy', 'officer-global-governance-diplomacy', 1, [
            ['question' => 'In which year was the United Nations (UN) founded?', 'options' => ['1942 AD', '1945 AD (October 24)', '1948 AD', '1950 AD'], 'answer' => 1, 'hint' => 'Established immediately following World War II.', 'explanation' => 'The UN was officially established on 24 October 1945.'],
            ['question' => 'When did Nepal gain official membership to the United Nations?', 'options' => ['1950 AD', '1955 AD (December 14)', '1960 AD', '1965 AD'], 'answer' => 1, 'hint' => 'Admitted as part of the package deal in 1955.', 'explanation' => 'Nepal became a UN member on 14 December 1955 AD.'],
            ['question' => 'Which international agreement adopted the 17 Sustainable Development Goals (SDGs)?', 'options' => ['Kyoto Protocol', 'Paris Agreement', 'UN Resolution 70/1 (Agenda 2030)', 'Rio Summit'], 'answer' => 2, 'hint' => 'Adopted in September 2015 by 193 nations.', 'explanation' => 'UN Agenda 2030 adopted the 17 SDGs with 169 targets.'],
            ['question' => 'Where is the permanent Secretariat of SAARC located?', 'options' => ['New Delhi', 'Islamabad', 'Kathmandu, Nepal', 'Dhaka'], 'answer' => 2, 'hint' => 'Inaugurated in Kathmandu in 1987.', 'explanation' => 'The SAARC Secretariat is headquartered in Kathmandu, Nepal.'],
            ['question' => 'What is the main objective of the Paris Agreement (COP21) regarding global temperature rise?', 'options' => ['Limit warming well below 2°C, pursuing 1.5°C above pre-industrial levels', 'Reduce temperature by 3°C', 'Maintain current emissions', 'Zero carbon by 2025'], 'answer' => 0, 'hint' => 'Aims to keep temperature rise well below 2°C.', 'explanation' => 'The Paris Agreement aims to limit warming to well below 2°C, striving for 1.5°C.'],
            ['question' => 'Which international financial institution is headquartered in Manila, Philippines?', 'options' => ['World Bank', 'IMF', 'Asian Development Bank (ADB)', 'AIIB'], 'answer' => 2, 'hint' => 'Established in 1966 for Asian development.', 'explanation' => 'ADB is headquartered in Manila, Philippines.'],
            ['question' => 'Which treaty established the European Union (EU) and the Euro currency?', 'options' => ['Treaty of Rome', 'Maastricht Treaty 1992', 'Treaty of Lisbon', 'Versailles Treaty'], 'answer' => 1, 'hint' => 'Signed in 1992 in the Netherlands.', 'explanation' => 'The Maastricht Treaty established the European Union in 1992.'],
            ['question' => 'In which year was BIMSTEC founded via the Bangkok Declaration?', 'options' => ['1985 AD', '1997 AD (June 6)', '2004 AD', '2014 AD'], 'answer' => 1, 'hint' => 'Founded in 1997; Nepal joined in 2004.', 'explanation' => 'BIMSTEC was founded on 6 June 1997.'],
            ['question' => 'Which article of the UN Charter establishes the right to individual or collective self-defense?', 'options' => ['Article 2', 'Article 24', 'Article 51', 'Article 99'], 'answer' => 2, 'hint' => 'Chapter VII self-defense provision.', 'explanation' => 'Article 51 explicitly preserves the inherent right of self-defense.'],
            ['question' => 'Where is the International Court of Justice (ICJ) located?', 'options' => ['Geneva', 'The Hague, Netherlands (Peace Palace)', 'New York', 'Vienna'], 'answer' => 1, 'hint' => 'The UN principal judicial organ sitting at Peace Palace.', 'explanation' => 'The ICJ is headquartered in The Hague, Netherlands.'],
        ]);

        // Module 2: Shasan Pranali
        $m2 = Module::create([
            'course_id' => $course->id,
            'title' => 'Dosro Patra: Shasan Pranali ra Sarbajanik Byawasthapan',
            'slug' => 'officer-dosro-patra-shasan-pranali',
            'order' => 2,
            'is_published' => true,
            'description' => 'New Public Management, Federalism, Public Financial Management, Civil Service Integrity, and Strategic Administration.',
            'key_points' => "• New Public Management (NPM) vs Classical Bureaucracy\n• Three-tier Federal Governance Coordination in Nepal\n• Performance-Based Management, Integrity & Digital Transformation",
            'notes' => 'Detailed governance analysis and administrative reform frameworks.',
        ]);

        $this->addLesson($m2, 'New Public Management Concepts & Public Policy', 'officer-npm-governance-concepts', 1, [
            ['question' => 'Which core concept best distinguishes New Public Management (NPM) from classical Weberian bureaucracy?',
                'options' => ['Strict hierarchical rule compliance', 'Citizen-centric service delivery, performance metrics, and results-based accountability', 'Lifelong tenure security without appraisals', 'Centralized rule-bound budgeting'],
                'answer' => 1, 'hint' => 'Focuses on outcomes, customer satisfaction, and efficiency.',
                'explanation' => 'NPM emphasizes results, efficiency, market mechanisms, and citizen-oriented management.'],
            ['question' => 'Who authored the 1992 book "Reinventing Government" that popularized NPM reforms?',
                'options' => ['David Osborne & Ted Gaebler', 'Max Weber & Karl Marx', 'F.W. Taylor & Henry Fayol', 'Herbert Simon'],
                'answer' => 0, 'hint' => 'Proposed catalytic government that steers rather than rows.',
                'explanation' => 'Osborne and Gaebler published "Reinventing Government" in 1992.'],
            ['question' => 'What does "Fiscal Federalism" specifically entail in Nepal\'s governance system?',
                'options' => ['Total centralization of all revenue in Kathmandu', 'Equitable distribution of tax powers, revenue sharing, fiscal equalization grants, and conditional transfers among Federal, Provincial, and Local tiers', 'Privatization of public banks', 'Elimination of provincial budgets'],
                'answer' => 1, 'hint' => 'Guided by the NNRFC under Article 250 of the Constitution.',
                'explanation' => 'Fiscal federalism divides taxation powers and distributes resources among Federal, Provincial, and Local tiers.'],
            ['question' => 'Under Nepal\'s Intergovernmental Fiscal Arrangement Act 2074, what percentage of VAT and Domestic Excise is shared with Provincial and Local levels?',
                'options' => ['70% Federal, 15% Provincial, 15% Local', '50% Federal, 25% Provincial, 25% Local', '80% Federal, 10% Provincial, 10% Local', '100% Federal'],
                'answer' => 0, 'hint' => 'Federal retains 70%, while Province and Local receive 15% each.',
                'explanation' => 'Internal revenue from VAT and Excise is shared: 70% Federal, 15% Provincial, 15% Local.'],
            ['question' => 'What is the primary function of the National Natural Resources and Fiscal Commission (NNRFC)?',
                'options' => ['Conduct criminal investigations', 'Determine formula-based allocation of revenue sharing and fiscal grants among federal, provincial, and local governments', 'Draft legislation', 'Direct military defense'],
                'answer' => 1, 'hint' => 'Constitutional body under Part 26, Article 250.',
                'explanation' => 'NNRFC determines the equitable distribution formula for internal revenue and equalization grants across all three tiers.'],
            ['question' => 'Which of the following is a classic component of "Public Financial Management (PFM)" in civil governance?',
                'options' => ['Medium Term Expenditure Framework (MTEF)', 'Line-item input-only budgeting without reviews', 'Unregistered cash disbursements', 'Elimination of internal auditing'],
                'answer' => 0, 'hint' => 'A 3-year rolling expenditure plan linking periodic plans with annual budgets.',
                'explanation' => 'The Medium Term Expenditure Framework (MTEF) is an essential PFM tool that bridges long-term national policy priorities with annual national budgets.'],
            ['question' => 'In policy analysis, what does "Incrementalism" (formulated by Charles Lindblom) refer to?',
                'options' => ['Radical revolutionary overhaul of all institutions', 'Policy making through small, sequential adjustments to existing policies ("muddling through")', 'Algorithmic computer-automated governance', 'Top-down military dictatorship directives'],
                'answer' => 1, 'hint' => 'Described as "the science of muddling through" rather than rational-comprehensive planning.',
                'explanation' => 'Charles Lindblom\'s Incremental Model posits that public policy decisions are made through gradual, step-by-step modifications of existing baseline policies.'],
            ['question' => 'What is the constitutional quorum required for the Federal Parliament of Nepal to conduct official voting on a legislative bill?',
                'options' => ['One-fourth (25%) of total members', 'One-third (33%) of total members', 'Simple majority (50% + 1)', 'Two-thirds (66.6%) of members'],
                'answer' => 0, 'hint' => 'Article 94 requires the presence of at least 25% of the total house membership.',
                'explanation' => 'Under Article 94 of the Constitution, unless otherwise provided, no decision shall be made unless at least one-fourth (25%) of total members are present.'],
            ['question' => 'Which anti-corruption index published annually by Transparency International ranks global corruption perceptions?',
                'options' => ['Human Development Index (HDI)', 'Corruption Perceptions Index (CPI)', 'Global Peace Index (GPI)', 'Ease of Doing Business Index'],
                'answer' => 1, 'hint' => 'Measures public sector corruption perception on a score from 0 (highly corrupt) to 100 (very clean).',
                'explanation' => 'Transparency International publishes the annual Corruption Perceptions Index (CPI) ranking countries worldwide.'],
            ['question' => 'Under the Good Governance Act 2064, who is designated as the Chief Administrative Officer responsible for ministry-level execution?',
                'options' => ['Cabinet Secretary (Mukhya Sachiv)', 'Secretary of the concerned Ministry (Sachiv)', 'Joint Secretary (Saha-Sachiv)', 'Under Secretary (Upa-Sachiv)'],
                'answer' => 1, 'hint' => 'The administrative head of each federal ministry holding accounting officer responsibility.',
                'explanation' => 'The Secretary of the Ministry serves as the chief administrative and accounting officer responsible for executive implementation under the Good Governance Act.'],
        ]);
    }

    /* -------------------------------------------------------------
     * 3. NRB OFFICER TAYARI
     * ------------------------------------------------------------- */
    private function cleanAndSeedNRBOfficer(): void
    {
        $course = $this->cleanCourse('nrb-officer-tayari');
        if (! $course) {
            return;
        }

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Module 1: Economics (Microeconomics & Macroeconomics)',
            'slug' => 'nrb-officer-economics-micro-macro',
            'order' => 1,
            'is_published' => true,
            'description' => 'Demand & supply elasticity, market structures, national income accounting, inflation dynamics, IS-LM framework, and monetary economics.',
            'key_points' => "• Elasticity of Demand & Supply\n• GDP Calculation Methods (Expenditure, Output, Income)\n• Fisher's Quantity Theory of Money & Keynesian Economics",
            'notes' => 'Complete theoretical and quantitative economics syllabus notes.',
        ]);

        $this->addLesson($m1, 'Demand Elasticity, Market Equilibrium & Pricing', 'nrb-officer-demand-elasticity', 1, [
            ['question' => 'When percentage change in quantity demanded equals percentage change in price, price elasticity of demand (|Ed|) is:', 'options' => ['Perfect elasticity (Ed = infinity)', 'Unitary elasticity (Ed = 1)', 'Inelastic (Ed < 1)', 'Perfectly inelastic (Ed = 0)'], 'answer' => 1, 'hint' => 'Total revenue remains constant when price changes.', 'explanation' => 'Unitary elasticity occurs when |Ed| = 1.'],
            ['question' => 'Which of the following describes an "Inferior Good" in microeconomics?', 'options' => ['Demand rises as income rises', 'Demand falls as consumer income rises (Negative Income Elasticity)', 'Demand is unresponsive to price', 'A luxury commodity'], 'answer' => 1, 'hint' => 'Consumers purchase less of this good as their income rises.', 'explanation' => 'Inferior goods have negative income elasticity of demand (Ey < 0).'],
            ['question' => 'In a perfectly competitive market, what is the shape of an individual firm\'s demand curve?', 'options' => ['Downwards sloping', 'Perfect horizontal line (P = AR = MR)', 'Vertical line', 'U-shaped'], 'answer' => 1, 'hint' => 'Firms are price-takers facing infinite elasticity.', 'explanation' => 'An individual firm in perfect competition faces a horizontal demand curve where P = AR = MR.'],
            ['question' => 'According to Fisher\'s Quantity Theory of Money (MV = PT), doubling M while V and T remain constant causes:', 'options' => ['Price level to halve', 'Price level (P) to double proportionally', 'No change in price', 'Velocity to drop'], 'answer' => 1, 'hint' => 'Direct and proportional relationship between money supply and price level.', 'explanation' => 'Fisher\'s equation dictates that money supply changes produce proportional changes in the price level.'],
            ['question' => 'What is the formula for calculating Gross Domestic Product (GDP) using the Expenditure Approach?', 'options' => ['GDP = C + I + G + (X - M)', 'GDP = Wages + Rents + Interests + Profits', 'GDP = Output - Intermediate Consumption', 'GDP = Exports - Imports'], 'answer' => 0, 'hint' => 'Sum of Consumption, Investment, Government spending, and Net Exports.', 'explanation' => 'Expenditure method: GDP = C + I + G + (X - M).'],
            ['question' => 'What economic term describes high inflation occurring simultaneously with economic stagnation and unemployment?', 'options' => ['Deflation', 'Reflation', 'Stagflation', 'Hyperinflation'], 'answer' => 2, 'hint' => 'Stagnant growth combined with price inflation.', 'explanation' => 'Stagflation is the coexistence of stagnant economic activity and high inflation.'],
            ['question' => 'In the IS-LM model, what does the "IS" curve represent?', 'options' => ['Equilibrium in money market', 'Equilibrium in goods and services market (Investment = Saving)', 'Labor equilibrium', 'Balance of payments equilibrium'], 'answer' => 1, 'hint' => 'IS stands for Investment and Saving in the real goods sector.', 'explanation' => 'The IS curve represents combinations of interest rate and income where goods market is in equilibrium (I = S).'],
            ['question' => 'What does the original Phillips Curve depict in short-run macroeconomics?', 'options' => ['Direct relationship between taxes and growth', 'Inverse relationship between inflation rate and unemployment rate', 'Inequality vs growth', 'Money supply vs exchange rate'], 'answer' => 1, 'hint' => 'Lower unemployment is associated with higher inflation.', 'explanation' => 'Phillips Curve shows the historical inverse tradeoff between inflation and unemployment.'],
            ['question' => 'What is "Base Money" or "Reserve Money" (M0) composed of in central banking?', 'options' => ['Currency in circulation + Commercial bank reserves at the Central Bank', 'Total savings deposits in private banks', 'Government bonds held by citizens', 'Gold reserves only'], 'answer' => 0, 'hint' => 'Monetary base created directly by the central bank.', 'explanation' => 'M0 consists of currency in circulation outside the central bank plus bank reserves deposited with the central bank.'],
            ['question' => 'What is "Gresham\'s Law" in monetary economics?', 'options' => ['Good money drives out bad money', '"Bad money drives out good money" when fixed by legal tender', 'Money supply determines real output', 'Low rates always cause inflation'], 'answer' => 1, 'hint' => 'Overvalued money drives undervalued money out of circulation.', 'explanation' => 'Gresham\'s Law states that if coins of differing intrinsic metal value have equal legal tender, bad money circulates while good money is hoarded.'],
        ]);
    }

    /* -------------------------------------------------------------
     * 4. NRB ASSISTANT DIRECTOR TAYARI
     * ------------------------------------------------------------- */
    private function cleanAndSeedNRBAD(): void
    {
        $course = $this->cleanCourse('nrb-assistant-director-tayari');
        if (! $course) {
            return;
        }

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Module 1: Banking Laws, Directives & Regulatory Framework',
            'slug' => 'nrb-ad-banking-laws-regulations',
            'order' => 1,
            'is_published' => true,
            'description' => 'NRB Act 2058, BAFIA 2073, FERA 2019, Unified Directives, AML/CFT Act, and Basel III Standards.',
            'key_points' => "• NRB Act 2058 Objectives & Autonomy (Section 4)\n• BAFIA 2073 Licensing, Classification & Governance\n• Unified Directives: Capital Adequacy, NPL Classification & Loan Loss Provisioning",
            'notes' => 'Complete legal & statutory analysis for NRB Assistant Director.',
        ]);

        $this->addLesson($m1, 'NRB Act 2058 & BAFIA 2073 Governance', 'nrb-ad-legal-framework', 1, [
            ['question' => 'Under Section 4 of NRB Act 2058, what is the primary statutory objective of NRB?', 'options' => ['Maximize commercial banking profits', 'Maintain price and balance of payments stability, ensure financial sector stability, and develop secure payment systems', 'Direct political governance of fiscal policy', 'Fix foreign stock prices'], 'answer' => 1, 'hint' => 'Price stability, external sector stability, financial sector resilience.', 'explanation' => 'NRB Act 2058 Section 4 establishes price stability and financial stability as core mandates.'],
            ['question' => 'Who appoints the Governor of Nepal Rastra Bank, and for what term length under NRB Act 2058?', 'options' => ['President for 6 years', 'Government of Nepal, Council of Ministers for a term of 5 years', 'Parliamentary Hearing Committee for 4 years', 'Ministry of Finance for 3 years'], 'answer' => 1, 'hint' => 'Appointed by the Cabinet for a 5-year tenure.', 'explanation' => 'Section 15 states the Cabinet appoints the Governor for a 5-year term.'],
            ['question' => 'How many members constitute the Board of Directors of Nepal Rastra Bank?', 'options' => ['5 Members', '7 Members', '9 Members', '11 Members'], 'answer' => 1, 'hint' => 'Governor (Chair), Finance Secretary, 2 Deputy Governors, and 3 appointed expert Directors.', 'explanation' => 'NRB Board of Directors consists of 7 members.'],
            ['question' => 'Under BAFIA 2073, commercial banks are categorized as which class of financial institution?', 'options' => ['"Ka" (Class A) Commercial Banks', '"Kha" (Class B) Development Banks', '"Ga" (Class C) Finance Companies', '"Gha" (Class D) Microfinance'], 'answer' => 0, 'hint' => 'Top tier commercial banks.', 'explanation' => 'BAFIA 2073 categorizes commercial banks as Class "A" institutions.'],
            ['question' => 'According to NRB Unified Directives, what is the loan loss provision required for a "Good" (Pass) performing loan?', 'options' => ['1.20% / 1.25%', '5.0%', '25.0%', '100.0%'], 'answer' => 0, 'hint' => 'Standard general loan loss provisioning for performing loans.', 'explanation' => 'Performing pass loans require standard general loan loss provisioning (~1.20% to 1.25%).'],
            ['question' => 'Under NRB Prudential Directives, a loan with principal or interest overdue for >90 to 180 days is classified as:', 'options' => ['Good / Pass Loan', 'Substandard Loan (Kamal / Kamjor)', 'Doubtful Loan (Shankaspad)', 'Loss Loan (Kharab / Bad Debt)'], 'answer' => 1, 'hint' => 'Requires a mandatory 25% loan loss provisioning.', 'explanation' => 'Loans overdue for 90 to 180 days are classified as Substandard (25% provision).'],
            ['question' => 'What is the minimum Capital Adequacy Ratio (CAR) under Basel III required for commercial banks in Nepal?', 'options' => ['6.0%', '11.0% Total Capital (including 2.5% Capital Conservation Buffer)', '15.0%', '20.0%'], 'answer' => 1, 'hint' => 'Tier 1 of 6% + CCB (2.5%) and Total Capital of 11%.', 'explanation' => 'NRB Basel III guidelines mandate a total CAR of 11.0% (including CCB).'],
            ['question' => 'Under BAFIA 2073, what is the maximum continuous tenure allowed for a CEO of a commercial bank?', 'options' => ['1 term of 3 years', '2 consecutive terms of up to 4 years each (maximum 8 years)', 'Unlimited tenures', '10 years'], 'answer' => 1, 'hint' => 'Section 29 limits a CEO to two 4-year terms.', 'explanation' => 'BAFIA Section 29 restricts bank CEOs to a maximum of two consecutive 4-year terms.'],
            ['question' => 'Which unit in NRB serves as the national financial intelligence agency for AML/CFT enforcement?', 'options' => ['Banking Supervision', 'Financial Information Unit (FIU-Nepal)', 'Foreign Exchange Department', 'Internal Audit'], 'answer' => 1, 'hint' => 'Receives and analyzes Suspicious Transaction Reports (STRs).', 'explanation' => 'FIU-Nepal, established under AML Act 2064, is the national financial intelligence unit.'],
            ['question' => 'Under Foreign Exchange Regulation Act 2019, who holds the exclusive statutory authority to regulate foreign exchange in Nepal?', 'options' => ['Ministry of Finance', 'Nepal Rastra Bank', 'Department of Customs', 'Commercial Banks Association'], 'answer' => 1, 'hint' => 'The central bank regulates foreign exchange and reserves.', 'explanation' => 'NRB is the sole regulatory authority governing foreign exchange in Nepal.'],
        ]);
    }

    /* -------------------------------------------------------------
     * 5. NEPAL CONSTITUTION & LAW
     * ------------------------------------------------------------- */
    private function cleanAndSeedConstitutionLaw(): void
    {
        $course = $this->cleanCourse('nepal-constitution-ra-kanun');
        if (! $course) {
            return;
        }

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Module 1: Constitutional Law & Fundamental Rights in Nepal',
            'slug' => 'constitution-law-framework-2072',
            'order' => 1,
            'is_published' => true,
            'description' => 'Constitutional history, Preamble, Fundamental Rights (Articles 16-48), Directive Principles, Federal Legislature, Executive, and Judiciary.',
            'key_points' => "• Constitutional Sovereignty, Rule of Law & Republican Framework\n• 31 Fundamental Rights & Constitutional Remedies (Article 46/133)\n• Federal Power Devolution across Federal, Provincial & Local Lists",
            'notes' => 'Exhaustive constitutional law syllabus notes for competitive legal examinations.',
        ]);

        $this->addLesson($m1, 'Fundamental Rights & Constitutional Remedies', 'const-fundamental-rights-remedies', 1, [
            ['question' => 'How many specific Fundamental Rights are enshrined in Part 3 of the Constitution of Nepal 2072?', 'options' => ['21 Rights', '27 Rights', '31 Rights (Articles 16 to 46)', '35 Rights'], 'answer' => 2, 'hint' => 'Spans Articles 16 to 46.', 'explanation' => 'Part 3 of the Constitution guarantees 31 fundamental rights.'],
            ['question' => 'Which Article of the Constitution guarantees the "Right to Constitutional Remedies"?', 'options' => ['Article 16', 'Article 27', 'Article 32', 'Article 46'], 'answer' => 3, 'hint' => 'Allows citizens to move courts for enforcement of fundamental rights.', 'explanation' => 'Article 46 guarantees the Right to Constitutional Remedies.'],
            ['question' => 'Which Article establishes the "Right to Information" (Suchana ko Hak) as a Fundamental Right?', 'options' => ['Article 25', 'Article 27', 'Article 28', 'Article 31'], 'answer' => 1, 'hint' => 'Right to demand and receive information on public interest matters.', 'explanation' => 'Article 27 guarantees the Right to Information.'],
            ['question' => 'Which writ is issued by the Supreme Court to command an unlawfully detained person to be produced before the court?', 'options' => ['Mandamus (Paramesh)', 'Habeas Corpus (Bandi Pratyakshikaran)', 'Certiorari (Utpreshan)', 'Quo Warranto (Adhikar Prichha)'], 'answer' => 1, 'hint' => 'Protects personal liberty against illegal detention.', 'explanation' => 'Habeas Corpus orders the detaining authority to produce the arrested individual in court.'],
            ['question' => 'Which writ is issued to an inferior court quashing an order passed without jurisdiction?', 'options' => ['Certiorari (Utpreshan)', 'Prohibition (Pratishedh)', 'Mandamus (Paramesh)', 'Quo Warranto (Adhikar Prichha)'], 'answer' => 0, 'hint' => 'Corrective writ that quashes illegal decisions.', 'explanation' => 'Certiorari quashes decisions rendered by subordinate bodies acting without jurisdiction.'],
            ['question' => 'What is the constitutional process required to amend the Constitution of Nepal under Article 274?', 'options' => ['Simple majority', 'Two-thirds (2/3) majority of the total existing members in both Houses of Federal Parliament', 'Presidential ordinance', 'Cabinet decree'], 'answer' => 1, 'hint' => 'Requires a two-thirds supermajority in both HoR and National Assembly.', 'explanation' => 'Article 274 mandates a two-thirds majority in both Houses of Federal Parliament.'],
            ['question' => 'Under Article 168 of the Constitution, what is the primary basis for appointing the Prime Minister of Nepal?', 'options' => ['Leader of the parliamentary party commanding a majority in the House of Representatives', 'Senior-most MP', 'Chief Justice recommendation', 'Elected by National Assembly'], 'answer' => 0, 'hint' => 'Article 168(1) appoints the majority party leader in HoR.', 'explanation' => 'Article 168(1) designates the majority party leader in HoR as Prime Minister.'],
            ['question' => 'How many members comprise the House of Representatives (Pratinidhi Sabha) of Nepal?', 'options' => ['205 Members', '240 Members', '275 Members (165 FPTP + 110 Proportional)', '330 Members'], 'answer' => 2, 'hint' => '165 FPTP and 110 PR seats.', 'explanation' => 'Article 84 establishes the House of Representatives with 275 members.'],
            ['question' => 'How many members comprise the National Assembly (Rastriya Sabha), and what is their term length?', 'options' => ['59 Members serving 6-year staggered terms', '60 Members serving 5 years', '75 Members serving 4 years', '50 Members permanent'], 'answer' => 0, 'hint' => '59 members with a 6-year tenure, 1/3 retiring every 2 years.', 'explanation' => 'Article 86 establishes the National Assembly with 59 members on 6-year staggered terms.'],
            ['question' => 'Which Schedule of the Constitution enumerates the Concurrent Powers of the Federation, Provinces, and Local levels?', 'options' => ['Schedule 5', 'Schedule 7', 'Schedule 8', 'Schedule 9'], 'answer' => 3, 'hint' => 'The final schedule containing the 15-item concurrent jurisdiction.', 'explanation' => 'Schedule 9 lists the Concurrent Powers of the Federation, Province, and Local levels.'],
        ]);
    }

    /* -------------------------------------------------------------
     * 6. COMPUTER SKILL PARIKSHA
     * ------------------------------------------------------------- */
    private function cleanAndSeedComputerSkill(): void
    {
        $course = $this->cleanCourse('computer-sip-pariksha');
        if (! $course) {
            return;
        }

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Module 1: Operating Systems, MS Office & Nepali Typing',
            'slug' => 'computer-office-os-productivity',
            'order' => 1,
            'is_published' => true,
            'description' => 'Practical & theoretical computer syllabus covering Windows OS, Word, Excel, PowerPoint, Nepali Unicode, and Internet security.',
            'key_points' => "• MS Word Shortcuts, Mail Merge & Tab Leaders\n• MS Excel VLOOKUP, IF, SUMIF, Pivot Tables & Data Validation\n• Nepali Unicode Romanized/Traditional & Cyber Safety",
            'notes' => 'Complete step-by-step practical guides for PSC Computer Skill Test.',
        ]);

        $this->addLesson($m1, 'MS Word, Excel & Productivity Shortcuts', 'comp-ms-word-excel-mastery', 1, [
            ['question' => 'What is the default file extension for Microsoft Word documents?', 'options' => ['.doc', '.docx', '.txt', '.rtf'], 'answer' => 1, 'hint' => 'XML-based format introduced in Office 2007.', 'explanation' => 'Microsoft Word documents use the `.docx` format extension.'],
            ['question' => 'Which keyboard shortcut in MS Word creates a "Page Break" instantly?', 'options' => ['Ctrl + Enter', 'Shift + Enter', 'Alt + Enter', 'Ctrl + Shift + Enter'], 'answer' => 0, 'hint' => 'Hold Control and tap Enter.', 'explanation' => '`Ctrl + Enter` inserts a page break immediately in MS Word.'],
            ['question' => 'Which Excel formula correctly adds values in A1:A10 only if they are greater than 50?', 'options' => ['=SUM(A1:A10, ">50")', '=SUMIF(A1:A10, ">50")', '=IF(A1:A10>50, SUM())', '=COUNTIF(A1:A10, 50)'], 'answer' => 1, 'hint' => 'Uses the conditional SUMIF function.', 'explanation' => '`=SUMIF(A1:A10, ">50")` calculates the sum of cells greater than 50.'],
            ['question' => 'In MS Excel, what symbol must precede every formula or function?', 'options' => ['#', '@', '=', '+'], 'answer' => 2, 'hint' => 'The equal sign indicates a mathematical formula.', 'explanation' => 'All Excel formulas begin with an equal sign (`=`).'],
            ['question' => 'What is the function of "Mail Merge" in Microsoft Word?', 'options' => ['Send offline emails', 'Create personalized letters/envelopes in bulk from a data source', 'Convert documents to PDF', 'Compress file size'], 'answer' => 1, 'hint' => 'Generates customized mass documents using a template and data list.', 'explanation' => 'Mail Merge merges templates with data sources to produce personalized bulk documents.'],
            ['question' => 'Which Excel feature summarizes large datasets dynamically without altering source rows?', 'options' => ['Data Validation', 'Pivot Table', 'Conditional Formatting', 'Goal Seek'], 'answer' => 1, 'hint' => 'Drag-and-drop summary tool under Insert tab.', 'explanation' => 'PivotTables summarize and group complex tables dynamically.'],
            ['question' => 'In Excel cell referencing, what does placing a dollar sign ($) before column/row (e.g. $A$1) achieve?', 'options' => ['Converts to US Dollars', 'Creates an Absolute Reference that does not change when copied', 'Hides formula', 'Deletes cell'], 'answer' => 1, 'hint' => 'Locks cell coordinate reference.', 'explanation' => 'The dollar sign creates an absolute cell reference (e.g., `$A$1`).'],
            ['question' => 'What is the universal encoding standard used for standardizing Nepali characters across all digital devices?', 'options' => ['ASCII', 'Preeti Font', 'Unicode (UTF-8)', 'Kantipur Font'], 'answer' => 2, 'hint' => 'Universal character encoding (Nepali Unicode).', 'explanation' => 'Unicode (UTF-8) provides a universal character set for digital Nepali.'],
            ['question' => 'In MS PowerPoint, which view displays thumbnail versions of all slides simultaneously for easy rearranging?', 'options' => ['Normal View', 'Slide Sorter View', 'Reading View', 'Notes View'], 'answer' => 1, 'hint' => 'Displays horizontally arranged slide thumbnails.', 'explanation' => 'Slide Sorter View lets you view and reorder all slide thumbnails.'],
            ['question' => 'Which network protocol securely encrypts web browsing sessions using TLS/SSL?', 'options' => ['HTTP', 'HTTPS (Port 443)', 'FTP', 'Telnet'], 'answer' => 1, 'hint' => 'Indicated by the padlock icon in browsers.', 'explanation' => 'HTTPS encrypts web traffic using Transport Layer Security (TLS/SSL).'],
        ]);
    }

    /* -------------------------------------------------------------
     * 7. IQ & GENERAL APTITUDE
     * ------------------------------------------------------------- */
    private function cleanAndSeedIQAptitude(): void
    {
        $course = $this->cleanCourse('baudhik-parikshan-iq-aptitude');
        if (! $course) {
            return;
        }

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Module 1: Verbal & Logical Reasoning Masterclass',
            'slug' => 'iq-verbal-logical-reasoning',
            'order' => 1,
            'is_published' => true,
            'description' => 'Verbal analogies, classification, syllogisms, blood relations, direction sense, seating arrangement, and critical deduction.',
            'key_points' => "• Word & Semantic Analogies\n• Family Tree & Blood Relations Algorithms\n• Direction Vectors, Distances & Seating Logic",
            'notes' => 'Master logical reasoning formulas and speed shortcuts.',
        ]);

        $this->addLesson($m1, 'Verbal Analogies, Logic & Deduction', 'iq-verbal-analogies-logic', 1, [
            ['question' => 'Doctor : Stethoscope :: Sculptor : ?', 'options' => ['Chisel', 'Anvil', 'Palette', 'Pen'], 'answer' => 0, 'hint' => 'Primary tool used by the artist.', 'explanation' => 'A doctor uses a stethoscope; a sculptor uses a chisel.'],
            ['question' => 'If CLOCK is coded as KCOLC, how is STEPS coded?', 'options' => ['SPETS', 'SPSET', 'STPES', 'STEPZ'], 'answer' => 0, 'hint' => 'Letters written in reverse order.', 'explanation' => 'S-T-E-P-S in reverse is S-P-E-T-S.'],
            ['question' => 'Pointing to a photo, Rohit says: "She is the daughter of my grandfather\'s only son." Who is she?', 'options' => ['Mother', 'Sister', 'Cousin', 'Daughter'], 'answer' => 1, 'hint' => 'Grandfather\'s only son is Rohit\'s father.', 'explanation' => 'The daughter of Rohit\'s father is Rohit\'s Sister.'],
            ['question' => 'Statements: All mangoes are golden. No golden things are sour. Conclusion: No mangoes are sour.', 'options' => ['Conclusion follows logically', 'Does not follow', 'Partially follows', 'Cannot be determined'], 'answer' => 0, 'hint' => 'Mangoes belong to golden, and golden cannot be sour.', 'explanation' => 'Valid deductive syllogism: Mangoes are golden, so none can be sour.'],
            ['question' => 'A boy walks 10m North, turns right and walks 10m, then turns right and walks 10m. How far is he from the start?', 'options' => ['10 meters', '20 meters', '30 meters', '0 meters'], 'answer' => 0, 'hint' => 'Vertical displacement cancels out (+10 - 10 = 0).', 'explanation' => 'Displacement is 10 meters East from origin.'],
            ['question' => 'In a class of 45 students, Sita ranks 11th from the top. What is her rank from the bottom?', 'options' => ['34th', '35th', '36th', '37th'], 'answer' => 1, 'hint' => 'Formula: Total - Top + 1.', 'explanation' => 'Rank = 45 - 11 + 1 = 35th.'],
            ['question' => 'Which number replaces the question mark in the matrix: [ [2, 3, 5], [4, 5, 9], [6, 7, ?] ]?', 'options' => ['11', '12', '13', '14'], 'answer' => 2, 'hint' => 'Column 1 + Column 2 = Column 3.', 'explanation' => 'In each row: 2+3=5, 4+5=9, 6+7=13.'],
            ['question' => 'If 1st January 2024 was a Monday, what day of the week was 31st January 2024?', 'options' => ['Tuesday', 'Wednesday', 'Thursday', 'Friday'], 'answer' => 1, 'hint' => '30 days difference: 30 mod 7 = 2 odd days.', 'explanation' => 'Monday + 2 days = Wednesday.'],
            ['question' => 'Find the missing number in the sequence: 1, 8, 27, 64, 125, ?', 'options' => ['196', '216', '256', '343'], 'answer' => 1, 'hint' => 'Cubes of consecutive integers: 1^3, 2^3, 3^3, 4^3, 5^3, 6^3.', 'explanation' => '6^3 = 216.'],
            ['question' => 'A can finish a work in 10 days, and B in 15 days. Working together, in how many days will they finish?', 'options' => ['5 Days', '6 Days', '8 Days', '9 Days'], 'answer' => 1, 'hint' => 'Combined 1-day work = 1/10 + 1/15 = 1/6.', 'explanation' => 'Together they finish the work in 6 days.'],
        ]);
    }

    /* -------------------------------------------------------------
     * 8. NEPAL TELECOM TAYARI
     * ------------------------------------------------------------- */
    private function cleanAndSeedTelecom(): void
    {
        $course = $this->cleanCourse('nepal-telecom-tayari');
        if (! $course) {
            return;
        }

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Module 1: Telecommunication Networks, Cellular & Optical Systems',
            'slug' => 'ntc-telecommunication-networks',
            'order' => 1,
            'is_published' => true,
            'description' => 'Telecommunication switching, GSM/LTE/5G mobile architectures, Optical FTTH, IP Routing, and Nepal Telecommunications Act 2053.',
            'key_points' => "• Mobile Generations: 2G GSM, 3G UMTS, 4G LTE, 5G NR Architectures\n• Optical Fiber Transmission (WDM, GPON/FTTH)\n• Nepal Telecommunications Act 2053 & NTA Regulation",
            'notes' => 'Complete technical and regulatory study notes for Nepal Telecom recruitment examinations.',
        ]);

        $this->addLesson($m1, 'Cellular Mobile Systems & Optical Fiber Networks', 'ntc-cellular-optical-systems', 1, [
            ['question' => 'In GSM architecture, which element stores permanent subscription info and subscriber location?', 'options' => ['VLR', 'Home Location Register (HLR)', 'EIR', 'BTS'], 'answer' => 1, 'hint' => 'Central permanent database storing IMSI and keys.', 'explanation' => 'HLR is the permanent subscriber database in GSM networks.'],
            ['question' => 'What transmission technology is used in 4G LTE downlink communication to prevent multipath fading?', 'options' => ['CDMA', 'OFDMA (Orthogonal Frequency Division Multiple Access)', 'TDMA', 'Pure FM'], 'answer' => 1, 'hint' => 'Splits wideband channels into orthogonal subcarriers.', 'explanation' => 'LTE downlink employs OFDMA for high spectral efficiency.'],
            ['question' => 'What optical wavelength has the lowest attenuation (~0.2 dB/km) in single-mode fiber?', 'options' => ['850 nm', '1310 nm & 1550 nm', '650 nm', '980 nm'], 'answer' => 1, 'hint' => '1550 nm corresponds to the lowest loss window.', 'explanation' => '1310 nm and 1550 nm are the standard telecom wavelengths.'],
            ['question' => 'In GPON (FTTH) architecture, what device splits optical signals to multiple subscribers without power?', 'options' => ['OLT', 'Passive Optical Splitter', 'ONU', 'Switch'], 'answer' => 1, 'hint' => 'Unpowered optical splitter component.', 'explanation' => 'Passive Optical Splitters divide signals to multiple subscribers.'],
            ['question' => 'Under Nepal Telecommunications Act 2053, which body allocates frequency spectrum and licenses operators?', 'options' => ['Ministry of Communication', 'Nepal Telecommunications Authority (NTA)', 'Nepal Telecom (NTC)', 'Radio Nepal'], 'answer' => 1, 'hint' => 'Autonomous regulatory authority under Section 3.', 'explanation' => 'NTA is the independent regulatory body for telecom in Nepal.'],
            ['question' => 'Which IP addressing format uses 128-bit addresses?', 'options' => ['IPv4', 'IPv6', 'MAC Address', 'Subnet Mask'], 'answer' => 1, 'hint' => 'Next-generation 128-bit IP addressing.', 'explanation' => 'IPv6 uses a 128-bit address space.'],
            ['question' => 'What does "SIM" stand for in mobile communications?', 'options' => ['Subscriber Identity Module', 'System Information Memory', 'Satellite Interface Module', 'Secure Internet Mechanism'], 'answer' => 0, 'hint' => 'Smart card storing IMSI identity.', 'explanation' => 'SIM stands for Subscriber Identity Module.'],
            ['question' => 'At which layer of the OSI 7-layer model do IP Routers primarily operate?', 'options' => ['Layer 1', 'Layer 2', 'Layer 3 (Network Layer)', 'Layer 4'], 'answer' => 2, 'hint' => 'Responsible for packet forwarding and logical IP routing.', 'explanation' => 'Routers operate at Layer 3 (Network Layer) of the OSI model.'],
            ['question' => 'What does VoLTE stand for in modern mobile communications?', 'options' => ['Voice over Long Term Evolution', 'Variable Optical Line Termination', 'Visual Online Live Telephony', 'Virtual Open LTE'], 'answer' => 0, 'hint' => 'HD voice calling over 4G LTE networks.', 'explanation' => 'VoLTE stands for Voice over Long-Term Evolution.'],
            ['question' => 'Which fund under the Telecom Act 2053 builds broadband infrastructure in rural Nepal using a 2% operator levy?', 'options' => ['Rural Telecommunication Development Fund (RTDF)', 'National Telecom Reserve Fund', 'Postal Savings Fund', 'Digital Nepal Fund'], 'answer' => 0, 'hint' => 'Funded by a 2% levy on operators\' gross revenues.', 'explanation' => 'RTDF finances rural telecommunications expansion in Nepal.'],
        ]);
    }

    private function addLesson(Module $module, string $title, string $slug, int $order, array $quizzes): void
    {
        Lesson::create([
            'module_id' => $module->id,
            'title' => $title,
            'slug' => $slug,
            'order' => $order,
            'type' => 'text',
            'duration_minutes' => 25,
            'is_published' => true,
            'content' => "<h3>{$title}</h3><p>Comprehensive syllabus study material for <strong>{$module->title}</strong>. Review key concepts, legal frameworks, and take the 10-question practice quiz below.</p>",
            'quiz_questions' => $quizzes,
        ]);
    }
}
