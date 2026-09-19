<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class CompleteLoksewaCurriculumSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedKharidarTopup();
        $this->seedNayabSubbaTopup();
        $this->seedSectionOfficer();
        $this->seedNepalTelecom();
        $this->seedNrbOfficer();
        $this->seedNrbAssistantDirector();
        $this->seedNeaCourse();
        $this->seedComputerSip();
    }

    private function seedKharidarTopup(): void
    {
        $course = Course::where('slug', 'kharidar-tayari')->first();
        if (! $course) {
            return;
        }

        // Ensure all lessons in Kharidar have 10 MCQs
        $lessons = Lesson::whereHas('module', fn ($q) => $q->where('course_id', $course->id))->get();
        foreach ($lessons as $lesson) {
            $currentQuestions = is_array($lesson->quiz_questions) ? $lesson->quiz_questions : [];
            if (count($currentQuestions) < 10) {
                $lesson->quiz_questions = $this->generateTopupQuestionsForLesson($lesson->title, $currentQuestions, 10);
                $lesson->save();
            }
        }
    }

    private function seedNayabSubbaTopup(): void
    {
        $course = Course::where('slug', 'nayab-subba-tayari')->first();
        if (! $course) {
            return;
        }

        $lessons = Lesson::whereHas('module', fn ($q) => $q->where('course_id', $course->id))->get();
        foreach ($lessons as $lesson) {
            $currentQuestions = is_array($lesson->quiz_questions) ? $lesson->quiz_questions : [];
            if (count($currentQuestions) < 10) {
                $lesson->quiz_questions = $this->generateTopupQuestionsForLesson($lesson->title, $currentQuestions, 10);
                $lesson->save();
            }
        }
    }

    private function seedSectionOfficer(): void
    {
        $course = Course::firstOrCreate(
            ['slug' => 'section-officer-tayari'],
            [
                'title' => 'Section Officer Tayari (शाखा अधिकृत तयारी)',
                'description' => 'Comprehensive preparation course for Loksewa Section Officer (Gazetted Third Class) covering Administrative Aptitude Test (GK, IQ & English), Governance Systems, Contemporary Issues, and Public Administration.',
                'is_published' => true,
            ]
        );

        $modules = [
            [
                'title' => 'Pratham Patra: Administrative Aptitude Test (GK, IQ & English)',
                'slug' => 'officer-gk-aat',
                'order' => 1,
                'key_points' => "• 100 Objective MCQs (Full Marks: 100, Pass Marks: 45)\n• Negative marking: 20% deduction for wrong answers\n• Focus heavily on General Awareness (50), Aptitude/IQ (30), and English Comprehension (20)",
                'notes' => 'General Awareness covers Geography, History, Culture, Constitution, International Affairs, UN, and Contemporary National & International Events.',
                'lessons' => [
                    [
                        'title' => 'Geography & Environmental Dynamics of Nepal & World',
                        'slug' => 'officer-geography-environment',
                        'order' => 1,
                        'questions' => [
                            ['q' => 'Which is the longest river of Nepal based on river basin length within Nepalese territory?', 'opts' => ['Koshi', 'Gandaki', 'Karnali', 'Mahakali'], 'a' => 2, 'h' => 'Think of the perennial snow-fed river originating from Mount Kailash/Mansarovar basin in Tibet.', 'e' => 'Karnali is the longest river of Nepal measuring 507 km within Nepalese territory.'],
                            ['q' => 'What percentage of the total land area of Nepal is covered by the Himalayan region?', 'opts' => ['15%', '68%', '17%', '25%'], 'a' => 0, 'h' => 'It constitutes the northernmost geographical belt with alpine climate.', 'e' => 'The Himalayan region covers approximately 15% of the total land area of Nepal.'],
                            ['q' => 'Which is the deepest lake in Nepal?', 'opts' => ['Rara Lake', 'Shey Phoksundo Lake', 'Tilicho Lake', 'Gosaikunda'], 'a' => 1, 'h' => 'Located in Dolpa District at an elevation of 3,611 meters.', 'e' => 'Shey Phoksundo Lake in Dolpa is the deepest lake of Nepal with an estimated depth of 145 meters.'],
                            ['q' => 'Mount Everest was officially declared to have a revised height of 8848.86 meters in which year?', 'opts' => ['2018 AD', '2019 AD', '2020 AD', '2021 AD'], 'a' => 2, 'h' => 'Jointly announced by the governments of Nepal and China on December 8, 2020.', 'e' => 'On December 8, 2020 (Mangsir 23, 2077 BS), Nepal and China jointly declared the new height of Sagarmatha as 8848.86 meters.'],
                            ['q' => 'Which strait separates Asia from North America?', 'opts' => ['Strait of Malacca', 'Bering Strait', 'Strait of Gibraltar', 'Bosphorus Strait'], 'a' => 1, 'h' => 'Connects the Chukchi Sea of the Arctic Ocean with the Bering Sea of the Pacific Ocean.', 'e' => 'The Bering Strait connects the Arctic Ocean with the Bering Sea and separates Russia (Asia) from Alaska (North America).'],
                            ['q' => 'The Great Barrier Reef is situated along the coast of which country?', 'opts' => ['Indonesia', 'Australia', 'Brazil', 'South Africa'], 'a' => 1, 'h' => 'Located in the Coral Sea off the coast of Queensland.', 'e' => 'The Great Barrier Reef is the world’s largest coral reef system located in Queensland, Australia.'],
                            ['q' => 'Which layer of the atmosphere contains the protective Ozone layer?', 'opts' => ['Troposphere', 'Stratosphere', 'Mesosphere', 'Thermosphere'], 'a' => 1, 'h' => 'The layer lying directly above the troposphere up to 50 km.', 'e' => 'The ozone layer is concentrated in the Stratosphere, absorbing harmful ultraviolet (UV-B) rays.'],
                            ['q' => 'Which National Park of Nepal was the first to be inscribed in the UNESCO World Heritage Site list?', 'opts' => ['Chitwan National Park', 'Sagarmatha National Park', 'Bardia National Park', 'Langtang National Park'], 'a' => 1, 'h' => 'Inscribed in 1979 for its outstanding natural mountain ecosystem.', 'e' => 'Sagarmatha National Park was inscribed as a UNESCO World Heritage Site in 1979.'],
                            ['q' => 'Ramsar Convention (1971) is primarily dedicated to the conservation of which ecosystem?', 'opts' => ['Tropical Rainforests', 'Wetlands of International Importance', 'Coral Reefs', 'Alpine Glaciers'], 'a' => 1, 'h' => 'Signed in the Iranian city of Ramsar on the Caspian Sea.', 'e' => 'The Ramsar Convention (1971) is an international treaty for the conservation and sustainable use of wetlands.'],
                            ['q' => 'Which district of Nepal is known as the district across the Himalayas (Himal Pari ko Jilla)?', 'opts' => ['Mustang and Manang', 'Dolpa and Mugu', 'Humla and Jumla', 'Solukhumbu and Taplejung'], 'a' => 0, 'h' => 'Located north of the Annapurna mountain range receiving very low monsoon rainfall.', 'e' => 'Mustang and Manang lie in the rain shadow north of the Main Himalayan range and are termed Himal Pari ka Jilla.'],
                        ],
                    ],
                    [
                        'title' => 'History, Culture & Constitutional Development of Nepal',
                        'slug' => 'officer-history-constitution',
                        'order' => 2,
                        'questions' => [
                            ['q' => 'Who was the first King of the Licchavi dynasty to issue inscribed copper coins (Manaank)?', 'opts' => ['Amshuverma', 'Mandev I', 'Shivadev I', 'Narendradev'], 'a' => 1, 'h' => 'Erected the famous Changu Narayan pillar inscription dated 521 BS (464 AD).', 'e' => 'King Mandev I issued Manaank coins and established the Changu Narayan inscription.'],
                            ['q' => 'The treaty of Sugauli between Nepal and the British East India Company was signed in which year?', 'opts' => ['1814 AD', '1815 AD', '1816 AD', '1818 AD'], 'a' => 2, 'h' => 'Ratified in March 1816 ending the Anglo-Nepalese War.', 'e' => 'The Sugauli Treaty was signed on December 2, 1815, and officially ratified on March 4, 1816.'],
                            ['q' => 'Which Rana Prime Minister established the first modern school of Nepal, Durbar High School (1910 BS)?', 'opts' => ['Jung Bahadur Rana', 'Ranodip Singh', 'Bir Shumsher', 'Dev Shumsher'], 'a' => 0, 'h' => 'Established it after his return from his tour of Great Britain and France in 1850 AD.', 'e' => 'Jung Bahadur Rana established Durbar High School in 1910 BS after returning from England.'],
                            ['q' => 'According to the Constitution of Nepal, how many Fundamental Rights are enshrined in Part 3?', 'opts' => ['21 Rights', '27 Rights', '31 Rights', '35 Rights'], 'a' => 2, 'h' => 'Enshrined in Articles 16 through 46.', 'e' => 'The Constitution of Nepal guarantees 31 fundamental rights from Article 16 (Right to live with dignity) to Article 46 (Right to constitutional remedies).'],
                            ['q' => 'Which Article of the Constitution of Nepal provides for the Directive Principles of the State?', 'opts' => ['Article 49', 'Article 50', 'Article 51', 'Article 52'], 'a' => 1, 'h' => 'Part 4 outlines the political, economic, social and international relations objectives.', 'e' => 'Article 50 of the Constitution of Nepal details the Directive Principles of the State.'],
                            ['q' => 'The Constitutional Council of Nepal is headed by which dignitary?', 'opts' => ['President of Nepal', 'Prime Minister', 'Chief Justice', 'Speaker of the House of Representatives'], 'a' => 1, 'h' => 'The executive head of the government of Nepal.', 'e' => 'Under Article 284, the Constitutional Council is chaired by the Prime Minister of Nepal.'],
                            ['q' => 'Who appoints the Auditor General of Nepal as per constitutional provisions?', 'opts' => ['Prime Minister', 'President on recommendation of Constitutional Council', 'Finance Minister', 'Public Accounts Committee'], 'a' => 1, 'h' => 'Constitutional body heads are appointed by the head of state upon recommendation.', 'e' => 'Article 240 specifies that the President appoints the Auditor General on the recommendation of the Constitutional Council.'],
                            ['q' => 'Under the local government operation framework in Nepal, how many local levels (Sthanaya Taha) exist?', 'opts' => ['744', '753', '777', '765'], 'a' => 1, 'h' => 'Comprises 6 Metros, 11 Sub-Metros, 276 Municipalities, and 460 Rural Municipalities.', 'e' => 'Nepal has 753 local levels consisting of 6 Metropolitan, 11 Sub-metropolitan, 276 Urban, and 460 Rural municipalities.'],
                            ['q' => 'Which Commission was created under Article 242 of the Constitution of Nepal for civil service recruitment?', 'opts' => ['Election Commission', 'Public Service Commission (Loksewa Aayog)', 'Commission for the Investigation of Abuse of Authority', 'National Human Rights Commission'], 'a' => 1, 'h' => 'Conducts examinations for selection of suitable candidates to civil service posts.', 'e' => 'Article 242 establishes the Public Service Commission (Lok Sewa Aayog) of Nepal.'],
                            ['q' => 'The Kot Massacre (Kot Parva), which established Rana rule in Nepal, took place on which date?', 'opts' => ['14 September 1846', '12 October 1847', '1 June 1850', '10 January 1858'], 'a' => 0, 'h' => 'Occurred at the royal armory courtyard in Kathmandu.', 'e' => 'The Kot Massacre took place on 14 September 1846 (1903 Ashwin 2 BS), leading to the rise of Jung Bahadur Rana.'],
                        ],
                    ],
                    [
                        'title' => 'International Affairs, UN, SAARC & Global Diplomacy',
                        'slug' => 'officer-global-governance-diplomacy',
                        'order' => 3,
                        'questions' => [
                            ['q' => 'In which year was the United Nations (UN) established?', 'opts' => ['1944 AD', '1945 AD', '1946 AD', '1948 AD'], 'a' => 1, 'h' => 'Charter signed in San Francisco and entered into force on 24 October 1945.', 'e' => 'The UN was officially established on 24 October 1945 with 51 original member states.'],
                            ['q' => 'Nepal became a member state of the United Nations on which date?', 'opts' => ['1950 Dec 14', '1955 Dec 14', '1960 Sept 20', '1962 Jan 1'], 'a' => 1, 'h' => 'Admitted under the package deal resolution in 1955.', 'e' => 'Nepal gained admission to the United Nations on 14 December 1955 (2012 Mangsir 29 BS).'],
                            ['q' => 'How many non-permanent members serve on the UN Security Council at any given time?', 'opts' => ['5 members', '10 members', '15 members', '20 members'], 'a' => 1, 'h' => 'Elected by the General Assembly for two-year terms.', 'e' => 'The UN Security Council consists of 15 members: 5 permanent (P5) and 10 non-permanent members.'],
                            ['q' => 'The SAARC Secretariat is headquartered in which city?', 'opts' => ['New Delhi, India', 'Islamabad, Pakistan', 'Kathmandu, Nepal', 'Dhaka, Bangladesh'], 'a' => 2, 'h' => 'Inaugurated by King Birendra in 1987 in the capital of Nepal.', 'e' => 'The SAARC Secretariat was established in Kathmandu, Nepal on 16 January 1987.'],
                            ['q' => 'BIMSTEC (Bay of Bengal Initiative) was established in 1997 through which declaration?', 'opts' => ['Kathmandu Declaration', 'Bangkok Declaration', 'Colombo Declaration', 'Dhaka Declaration'], 'a' => 1, 'h' => 'Signed in the capital of Thailand in June 1997.', 'e' => 'BIMSTEC was formed on 6 June 1997 through the Bangkok Declaration.'],
                            ['q' => 'The Sustainable Development Goals (SDGs) comprise how many global goals to be achieved by 2030?', 'opts' => ['8 Goals', '12 Goals', '17 Goals', '21 Goals'], 'a' => 2, 'h' => 'Adopted in 2015 replacing the Millennium Development Goals (MDGs).', 'e' => 'The UN 2030 Agenda for Sustainable Development consists of 17 Sustainable Development Goals (SDGs) and 169 targets.'],
                            ['q' => 'Which SDG Goal is specifically dedicated to "Climate Action"?', 'opts' => ['Goal 7', 'Goal 11', 'Goal 13', 'Goal 15'], 'a' => 2, 'h' => 'Calls for urgent action to combat climate change and its impacts.', 'e' => 'SDG 13 is dedicated to "Take urgent action to combat climate change and its impacts".'],
                            ['q' => 'The Paris Climate Agreement was adopted at COP21 in which year?', 'opts' => ['2012 AD', '2015 AD', '2018 AD', '2021 AD'], 'a' => 1, 'h' => 'Adopted by 196 parties in Paris aiming to limit global warming below 2°C.', 'e' => 'The Paris Agreement was adopted on 12 December 2015 at COP21 and entered into force in November 2016.'],
                            ['q' => 'Which organ of the United Nations is the principal judicial organ seated at The Hague, Netherlands?', 'opts' => ['International Criminal Court (ICC)', 'International Court of Justice (ICJ)', 'UN Economic and Social Council', 'UN Secretariat'], 'a' => 1, 'h' => 'Known colloquially as the World Court.', 'e' => 'The International Court of Justice (ICJ) is the principal judicial organ of the UN located at the Peace Palace in The Hague.'],
                            ['q' => 'Nepal has served as an elected non-permanent member of the UN Security Council how many times?', 'opts' => ['Never', '1 time', '2 times', '3 times'], 'a' => 2, 'h' => 'Served two distinct terms in the 20th century (1969-70 and 1988-89).', 'e' => 'Nepal served as a non-permanent member of the UN Security Council twice: 1969-1970 and 1988-1989.'],
                        ],
                    ],
                    [
                        'title' => 'Administrative Aptitude Test (AAT): Verbal & Numerical Reasoning',
                        'slug' => 'officer-aat-reasoning',
                        'order' => 4,
                        'questions' => [
                            ['q' => 'Find the missing number in the series: 3, 7, 15, 31, 63, ?', 'opts' => ['95', '115', '127', '129'], 'a' => 2, 'h' => 'Observe the pattern: each term is 2x + 1 or double the previous number plus 1.', 'e' => 'Pattern is (3*2)+1=7, (7*2)+1=15, (15*2)+1=31, (31*2)+1=63, (63*2)+1=127.'],
                            ['q' => 'In a certain code, "ADMIN" is written as "CEOKP". How is "CIVIL" written in that code?', 'opts' => ['EKXKN', 'EJWJN', 'EKXJN', 'FLXKN'], 'a' => 0, 'h' => 'Each letter is shifted forward by +2 positions in the alphabetical order.', 'e' => 'C+2=E, I+2=K, V+2=X, I+2=K, L+2=N -> EKXKN.'],
                            ['q' => 'If A is the brother of B, B is the daughter of C, and D is the father of A, what is C to D?', 'opts' => ['Sister', 'Wife', 'Mother', 'Daughter'], 'a' => 1, 'h' => 'A and B are siblings; D is their father and C is their mother.', 'e' => 'Since A and B are children of D and C, C must be the wife of D.'],
                            ['q' => 'A train 180 meters long crosses a pole in 9 seconds. What is the speed of the train in km/hr?', 'opts' => ['60 km/hr', '72 km/hr', '80 km/hr', '90 km/hr'], 'a' => 1, 'h' => 'Speed = Distance / Time = 180 / 9 = 20 m/s. Convert m/s to km/hr by multiplying by 18/5.', 'e' => 'Speed = 20 m/s * (18/5) = 72 km/hr.'],
                            ['q' => 'The ratio of ages of Ram and Shyam is 4:5. If the sum of their ages is 45 years, what is Ram’s age?', 'opts' => ['18 years', '20 years', '25 years', '24 years'], 'a' => 1, 'h' => 'Let 4x + 5x = 45 => 9x = 45 => x = 5.', 'e' => 'Ram’s age = 4 * 5 = 20 years.'],
                            ['q' => 'Pointing to a photograph, a woman says: "He is the only son of my mother’s father." How is the man related to the woman?', 'opts' => ['Father', 'Maternal Uncle (Mama)', 'Brother', 'Grandfather'], 'a' => 1, 'h' => 'Mother’s father is grandfather; his only son is maternal uncle.', 'e' => 'The only son of the woman’s maternal grandfather is her maternal uncle (Mama).'],
                            ['q' => 'Which number is odd one out in: 27, 64, 125, 216, 343, 512, 729, 1000, 100?', 'opts' => ['1000', '100', '343', '27'], 'a' => 1, 'h' => 'All other numbers are perfect cubes except this number which is only a square (10^2).', 'e' => '27=3^3, 64=4^3, 125=5^3, 216=6^3, 343=7^3, 512=8^3, 729=9^3, 1000=10^3. 100 is not a perfect cube.'],
                            ['q' => 'A person walks 10 meters North, turns right and walks 15 meters, then turns right again and walks 10 meters. How far is he from the starting point?', 'opts' => ['10 meters', '15 meters', '25 meters', '35 meters'], 'a' => 1, 'h' => 'The North and South movements cancel each other, leaving only the East displacement.', 'e' => 'He is displaced 15 meters directly East from his starting position.'],
                            ['q' => 'If 15 men can complete a public construction project in 20 days, how many days will 25 men take to complete the same work?', 'opts' => ['10 days', '12 days', '14 days', '16 days'], 'a' => 1, 'h' => 'Total work = M1 * D1 = 15 * 20 = 300 man-days. D2 = 300 / 25.', 'e' => 'Days required = (15 * 20) / 25 = 300 / 25 = 12 days.'],
                            ['q' => 'Choose the synonym for "PERSPICACIOUS":', 'opts' => ['Shrewd / Insightful', 'Deceptive', 'Hesitant', 'Stubborn'], 'a' => 0, 'h' => 'Refers to someone having a ready insight and great discernment.', 'e' => 'Perspicacious means having keen mental perception, discernment, and insightful understanding.'],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Dosro Patra: Shasan Pranali (Governance System)',
                'slug' => 'officer-shasan-pranali',
                'order' => 2,
                'key_points' => "• Concepts of State, Government and Governance\n• Constitutionalism, Rule of Law and Democratic Values\n• New Public Management (NPM) and Public Policy Cycle",
                'notes' => 'Governance systems focus on transparency, accountability, citizen charter, e-governance, and administrative reforms in Nepal.',
                'lessons' => [
                    [
                        'title' => 'State, Constitutionalism & Rule of Law in Nepal',
                        'slug' => 'officer-state-constitutionalism',
                        'order' => 1,
                        'questions' => [
                            ['q' => 'Which of the following is considered an essential element of modern Constitutionalism?', 'opts' => ['Absolute executive dominance', 'Limited government power and judicial review', 'Absence of written constitution', 'Single-party rule'], 'a' => 1, 'h' => 'Constitutionalism implies checking arbitrary power and establishing checks and balances.', 'e' => 'Constitutionalism requires limited government, protection of fundamental rights, separation of powers, and judicial review.'],
                            ['q' => 'The concept of "Rule of Law" was classically articulated by which British jurist?', 'opts' => ['A.V. Dicey', 'John Locke', 'Thomas Hobbes', 'Montesquieu'], 'a' => 0, 'h' => 'Authored "Introduction to the Study of the Law of the Constitution" in 1885.', 'e' => 'A.V. Dicey formulated the three principles of the Rule of Law: supremacy of regular law, equality before the law, and predominance of legal spirit.'],
                            ['q' => 'Separation of Powers and Checks and Balances is classically attributed to which political philosopher?', 'opts' => ['Jean-Jacques Rousseau', 'Baron de Montesquieu', 'Karl Marx', 'Max Weber'], 'a' => 1, 'h' => 'Wrote "The Spirit of the Laws" (1748) proposing trias politica.', 'e' => 'Montesquieu articulated the separation of powers among the legislature, executive, and judiciary.'],
                            ['q' => 'Under Nepal’s federal structure, judicial power is exercised through which three-tier court hierarchy?', 'opts' => ['Supreme Court, High Court, District Court', 'Federal Court, Provincial Court, Local Court', 'Supreme Court, Appellate Court, Revenue Tribunal', 'Constitutional Court, Civil Court, Criminal Court'], 'a' => 0, 'h' => 'Defined in Part 11 of the Constitution of Nepal.', 'e' => 'Article 127 establishes three tiers of courts in Nepal: Supreme Court, High Courts, and District Courts.'],
                            ['q' => 'What is the primary role of the Commission for the Investigation of Abuse of Authority (CIAA) under Article 239?', 'opts' => ['Conducting civil service examinations', 'Investigating and prosecuting corruption and improper conduct by public officials', 'Auditing state financial statements', 'Formulating fiscal budget'], 'a' => 1, 'h' => 'Constitutional anti-graft oversight agency of Nepal.', 'e' => 'The CIAA investigates corruption and files charge sheets before the Special Court against public officials committing corruption.'],
                            ['q' => 'Which mechanism empowers citizens to obtain information held in public bodies under Article 27?', 'opts' => ['Right to Privacy', 'Right to Information (RTI)', 'Right to Free Movement', 'Right to Clean Environment'], 'a' => 1, 'h' => 'Enacted under the Right to Information Act 2064 BS.', 'e' => 'Right to Information (Article 27 and RTI Act 2064) ensures transparency by giving citizens the right to demand information from public bodies.'],
                            ['q' => 'In public governance, a "Citizen Charter" (Nagarik Badaapatra) primarily serves to:', 'opts' => ['Collect local taxes', 'Guarantee service delivery standards, fees, timeframe, and redressal mechanisms for citizens', 'Conduct criminal inquiries', 'Manage civil servant promotions'], 'a' => 1, 'h' => 'Displayed publicly at government offices to guarantee service commitments.', 'e' => 'The Citizen Charter outlines the types of public services, required documents, processing timeframe, service fees, and responsible officers.'],
                            ['q' => 'The concept of "Good Governance" promoted by multilateral agencies (World Bank/UNDP) emphasizes which core pillar?', 'opts' => ['Excessive bureaucracy', 'Accountability, Transparency, Rule of Law, and Responsiveness', 'Secrecy in decision making', 'Unlimited discretionary powers'], 'a' => 1, 'h' => 'Focuses on participatory, transparent, accountable, and effective public administration.', 'e' => 'Good Governance rests upon transparency, accountability, participation, predictability, and the rule of law.'],
                            ['q' => 'Which tier of government in Nepal has exclusive legislative authority over local policing, local taxes, and basic education?', 'opts' => ['Federal Government', 'Provincial Government', 'Local Level (Sthanaya Taha)', 'District Coordination Committee'], 'a' => 2, 'h' => 'Listed in Schedule 8 of the Constitution of Nepal.', 'e' => 'Schedule 8 lists 22 exclusive powers of the Local Level, including local taxes, basic education, and local roads.'],
                            ['q' => 'Good Governance (Management and Operation) Act in Nepal was enacted in which Bikram Sambat year?', 'opts' => ['2058 BS', '2064 BS', '2068 BS', '2072 BS'], 'a' => 1, 'h' => 'Enacted alongside the Civil Service regulations reform.', 'e' => 'The Good Governance (Management and Operation) Act 2064 was enacted to make administrative functions people-oriented and transparent.'],
                        ],
                    ],
                    [
                        'title' => 'New Public Management Concepts & Public Policy',
                        'slug' => 'officer-npm-public-policy',
                        'order' => 2,
                        'questions' => [
                            ['q' => 'New Public Management (NPM) emerged as a major administrative paradigm in which decade?', 'opts' => ['1950s', '1960s', '1980s-1990s', '2010s'], 'a' => 2, 'h' => 'Popularized by Christopher Hood and Osborne & Gaebler (Reinventing Government).', 'e' => 'NPM emerged during the 1980s and 1990s emphasizing market principles, efficiency, and customer orientation in public administration.'],
                            ['q' => 'Which doctrine advocates for "Steering rather than Rowing" in public management?', 'opts' => ['Traditional Weberian Bureaucracy', 'Reinventing Government / NPM', 'Classical Management Theory', 'Scientific Management'], 'a' => 1, 'h' => 'Coined by David Osborne and Ted Gaebler in 1992.', 'e' => 'Osborne and Gaebler argued that governments should focus on policy direction and regulation (steering) rather than direct service delivery (rowing).'],
                            ['q' => 'What is the correct sequential order of the Public Policy Cycle?', 'opts' => ['Evaluation -> Implementation -> Formulation -> Agenda Setting', 'Agenda Setting -> Policy Formulation -> Adoption -> Implementation -> Evaluation', 'Implementation -> Adoption -> Agenda Setting -> Evaluation', 'Formulation -> Evaluation -> Agenda Setting -> Adoption'], 'a' => 1, 'h' => 'Starts with identifying societal problems and concludes with assessing policy impact.', 'e' => 'The policy cycle proceeds through Problem Identification/Agenda Setting, Formulation, Adoption/Legitimation, Implementation, and Evaluation.'],
                            ['q' => 'The concept of "Bureaucracy" with hierarchy, division of labor, and impersonality was pioneered by:', 'opts' => ['Henri Fayol', 'Max Weber', 'Frederick Winslow Taylor', 'Elton Mayo'], 'a' => 1, 'h' => 'Prominent German sociologist of the early 20th century.', 'e' => 'Max Weber defined the ideal-type rational-legal bureaucracy characterized by written rules, hierarchy, and merit-based employment.'],
                            ['q' => 'What does the term "Public Private Partnership (PPP)" refer to in infrastructure governance?', 'opts' => ['Privatization of all state assets', 'Contractual collaboration between government and private enterprise for public service delivery/infrastructure financing', 'Banning private firms from bidding', 'State monopoly in telecommunication'], 'a' => 1, 'h' => 'Involves sharing investment, risk, and rewards (e.g. BOT, BOOT models).', 'e' => 'PPP is a long-term contract between a private party and a government entity for providing a public asset or service.'],
                            ['q' => 'In Nepal, which apex body is responsible for periodic national socio-economic planning and policy coordination?', 'opts' => ['Nepal Rastra Bank', 'National Planning Commission (NPC)', 'Public Service Commission', 'Ministry of General Administration'], 'a' => 1, 'h' => 'Chaired by the Prime Minister of Nepal.', 'e' => 'The National Planning Commission (NPC) is the advisory apex body for formulating national development visions, periodic plans, and policies.'],
                            ['q' => 'Which administrative reform principle emphasizes results, outputs, and performance indicators over rigid procedural compliance?', 'opts' => ['Performance-Based Management (PBM)', 'Strict Legal Formalism', 'Traditional Incrementalism', 'Spoils System'], 'a' => 0, 'h' => 'Focuses on measuring outputs, outcomes, and value for money.', 'e' => 'Performance-Based Management aligns organizational activities with target outcomes and measurable indicators.'],
                            ['q' => 'The Right to Information Act 2064 of Nepal requires every public body to designate which official?', 'opts' => ['Chief Accountant', 'Information Officer (Soochana Adhikari)', 'Internal Auditor', 'Public Relations Specialist'], 'a' => 1, 'h' => 'Responsible for receiving information requests and disseminating public data.', 'e' => 'Section 6 of the RTI Act 2064 requires every public agency to designate an Information Officer.'],
                            ['q' => 'What is the primary objective of a "Social Audit" (Samajik Lekhaparikshan) in public projects?', 'opts' => ['Checking financial ledger arithmetic', 'Engaging beneficiaries and community stakeholders to evaluate project transparency, utility, and accountability', 'Conducting criminal court trials', 'Calculating corporate tax liabilities'], 'a' => 1, 'h' => 'Participatory public forum where citizens review public expenditure and performance.', 'e' => 'Social audit is a participatory tool allowing beneficiaries to scrutinize project resources, execution quality, and social impact.'],
                            ['q' => 'Which principle of public procurement under Nepal’s PPA 2063 ensures non-discrimination and best value for money?', 'opts' => ['Direct sole-source purchase without bidding', 'Open competitive bidding with transparency and equal opportunity', 'Secret negotiated contracting', 'Exclusive preference to multinational firms'], 'a' => 1, 'h' => 'Ensures public funds achieve economy, efficiency, and fair competition.', 'e' => 'The Public Procurement Act 2063 mandates open competitive bidding as the standard procurement method for public value.'],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Tesro Patra: Samasamayik Bishayaharoo (Contemporary Issues)',
                'slug' => 'officer-contemporary-issues',
                'order' => 3,
                'key_points' => "• Economic Growth, Public Finance, Taxation and Foreign Aid\n• Environmental Protection, Climate Change Adaptation and Disaster Management\n• Social Inclusivity, Demographic Dividend and Human Capital Development",
                'notes' => 'Analyzes contemporary macroeconomic challenges, climate vulnerability of Nepal, and social equity policies.',
                'lessons' => [
                    [
                        'title' => 'Macroeconomics, Public Finance & Fiscal Federalism in Nepal',
                        'slug' => 'officer-public-finance-federalism',
                        'order' => 1,
                        'questions' => [
                            ['q' => 'Under Nepal’s federal financial system, which constitutional body recommends the formula for revenue sharing and fiscal equalization grants?', 'opts' => ['National Planning Commission', 'National Natural Resources and Fiscal Commission (NNRFC)', 'Nepal Rastra Bank', 'Ministry of Finance'], 'a' => 1, 'h' => 'Established under Article 250 of the Constitution of Nepal.', 'e' => 'The National Natural Resources and Fiscal Commission (NNRFC) determines the distribution of revenue and equalization grants among the three tiers of government.'],
                            ['q' => 'What are the four types of intergovernmental fiscal transfers provided to provincial and local governments in Nepal?', 'opts' => ['Equalization, Conditional, Matching (Samapoork), and Special Grants', 'Loan, Subsidy, Compensation, and Bailout', 'Direct Tax, Indirect Tax, Custom, and VAT', 'Internal, External, Bilateral, and Multilateral'], 'a' => 0, 'h' => 'Defined in the Intergovernmental Fiscal Arrangement Act 2074.', 'e' => 'The four constitutionally recognized grants are Fiscal Equalization (Bittee Samanikaran), Conditional (Shasarta), Matching (Samapoork), and Special (Vishesh) grants.'],
                            ['q' => 'Value Added Tax (VAT) in Nepal is levied at a standard single rate of:', 'opts' => ['10%', '13%', '15%', '18%'], 'a' => 1, 'h' => 'Introduced under the Value Added Tax Act 2052 BS.', 'e' => 'Nepal implemented VAT in 2054 BS (1997 AD) at a standard rate of 13%.'],
                            ['q' => 'Which account is maintained at Nepal Rastra Bank where all federal revenues are deposited and expenditures drawn?', 'opts' => ['Federal Consolidated Fund (Sanchit Kosh)', 'Contingency Fund', 'Emergency Relief Fund', 'Provincial Reserve'], 'a' => 0, 'h' => 'Governed by Article 116 of the Constitution of Nepal.', 'e' => 'Under Article 116, all revenues received by the Government of Nepal form the Federal Consolidated Fund.'],
                            ['q' => 'What does "Medium Term Expenditure Framework (MTEF)" provide in public budgeting?', 'opts' => ['A daily cash register', 'A rolling three-year strategic budgeting framework linking periodic plans with annual budgets', 'A 50-year vision statement', 'A summary of historical debts'], 'a' => 1, 'h' => 'Helps prioritize capital expenditure and project funding over a 3-year horizon.', 'e' => 'MTEF links national development priorities with multi-year fiscal envelopes and budget allocation over three rolling fiscal years.'],
                            ['q' => 'What is the primary measure of a country’s economic output representing total market value of all finished goods and services produced within a year?', 'opts' => ['Gross Domestic Product (GDP)', 'Gross National Happiness', 'Balance of Trade', 'Consumer Price Index'], 'a' => 0, 'h' => 'Macroeconomic aggregate measured by production, income, or expenditure approach.', 'e' => 'GDP measures the monetary value of all final goods and services produced within a nation’s borders during a specific period.'],
                            ['q' => 'When government total expenditures exceed its total revenues (excluding borrowings), the resulting gap is called:', 'opts' => ['Budget Surplus', 'Fiscal Deficit', 'Trade Balance', 'Current Account Surplus'], 'a' => 1, 'h' => 'Financed through domestic and external borrowing.', 'e' => 'A fiscal deficit occurs when government spending surpasses revenue generation, requiring debt financing.'],
                            ['q' => 'Which institution acts as the supreme audit authority in Nepal auditing all government bodies under Article 241?', 'opts' => ['Financial Comptroller General Office (FCGO)', 'Office of the Auditor General (OAG)', 'Revenue Investigation Department', 'Public Accounts Committee'], 'a' => 1, 'h' => 'Submits an annual independent audit report to the President.', 'e' => 'The Office of the Auditor General conducts constitutional financial and compliance audits of all state organs.'],
                            ['q' => 'Which tier of government in Nepal is entitled to collect Property Tax and House Rent Tax (Ghar Bahal Kar)?', 'opts' => ['Federal Government', 'Provincial Government', 'Local Level (Municipalities & Rural Municipalities)', 'Customs Department'], 'a' => 2, 'h' => 'Granted under Schedule 8 of the Constitution.', 'e' => 'Property tax, house rent tax, and land revenue (Malpot) are exclusive local taxes levied by Local Levels.'],
                            ['q' => 'What is the target threshold of inflation control typically specified in Nepal Rastra Bank’s annual Monetary Policy?', 'opts' => ['Around 5.5% - 6.5%', '15% - 20%', 'Below 1%', 'Zero percent'], 'a' => 0, 'h' => 'Aimed at maintaining price stability while supporting target economic growth.', 'e' => 'NRB Monetary Policies generally aim to contain consumer price inflation around 5.5% to 6.5% annually.'],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Chautho Patra: Seva Sambandhi (Service Related Administration & Law)',
                'slug' => 'officer-service-administration',
                'order' => 4,
                'key_points' => "• Civil Service Act 2049 and Civil Service Rules 2050\n• Administrative Law, Delegation of Authority and Discretionary Powers\n• Public Procurement, Financial Procedures and Fiscal Responsibility Act",
                'notes' => 'Service specific legislation, civil servant code of conduct, disciplinary procedures, and official decision-making processes.',
                'lessons' => [
                    [
                        'title' => 'Civil Service Act, Code of Conduct & Administrative Law',
                        'slug' => 'officer-civil-service-act',
                        'order' => 1,
                        'questions' => [
                            ['q' => 'According to the Civil Service Act 2049 of Nepal, what is the mandatory retirement age for civil servants?', 'opts' => ['55 years', '58 years', '60 years', '62 years'], 'a' => 1, 'h' => 'Specified in Section 33 of the Civil Service Act 2049.', 'e' => 'Under Section 33 of the Civil Service Act 2049, civil servants compulsorily retire upon reaching 58 years of age.'],
                            ['q' => 'What is the maximum probation period (Parikshan Kaal) for male and female appointees respectively in civil service?', 'opts' => ['1 year for both', '6 months for male, 1 year for female', '1 year for male, 6 months for female', '2 years for both'], 'a' => 2, 'h' => 'Affirmative action provisions reduce the probation timeframe for women.', 'e' => 'Under Section 10 of the Civil Service Act 2049, the probation period is 6 months for women and 1 year for men.'],
                            ['q' => 'Which of the following is an ordinary departmental punishment (Samanya Sajaaya) under the Civil Service Act?', 'opts' => ['Dismissal from service', 'Withholding of promotion for up to two years or withholding of grade increment', 'Removal from service', 'Criminal imprisonment'], 'a' => 1, 'h' => 'Ordinary punishments include censure, withholding grades, or withholding promotion.', 'e' => 'Section 59 categorizes reprimand (Nasihat) and withholding grade/promotion as ordinary departmental penalties.'],
                            ['q' => 'What proportion of seats are reserved for inclusive groups in open recruitment under the Civil Service Act?', 'opts' => ['33%', '45%', '50%', '55%'], 'a' => 1, 'h' => '55% is filled through open competition while the remaining is distributed among inclusive clusters.', 'e' => 'Section 7(7) allocates 45% of total vacant seats to inclusive categories (Women 33%, Adibasi/Janajati 27%, Madhesi 22%, Dalit 9%, Differently-abled 5%, Backward area 4%).'],
                            ['q' => 'Which writ petition can be issued by the Supreme Court to quash an unlawful administrative order passed without jurisdiction?', 'opts' => ['Habeas Corpus (Bandi Pratyakshikaran)', 'Mandamus (Paramadesh)', 'Certiorari (Utpreshan)', 'Quo Warranto (Adhikar Prichha)'], 'a' => 2, 'h' => 'Issued to quash decisions of inferior tribunals or authorities acting ultra vires.', 'e' => 'Writ of Certiorari (Utpreshan) quashes decisions taken in excess of legal authority or violating natural justice principles.'],
                            ['q' => 'The principle of "Audi Alteram Partem" in administrative natural justice translates to:', 'opts' => ['No one should be a judge in their own cause', 'Hear the other side / no one should be condemned unheard', 'Ignorance of law is no excuse', 'Precedents must be followed'], 'a' => 1, 'h' => 'Mandates providing an opportunity of fair hearing before passing adverse decisions.', 'e' => 'Audi Alteram Partem requires providing fair notice and reasonable opportunity to present one’s defense before administrative action.'],
                            ['q' => 'Delegation of Authority (Adhikar Pratyayojan) in public administration allows an official to delegate:', 'opts' => ['Judicial powers of the constitution', 'Statutory administrative powers to subordinate officers while retaining ultimate accountability', 'The duty to sign original legislation', 'The right to dissolve parliament'], 'a' => 1, 'h' => 'Improves efficiency by permitting subordinates to act on specified administrative matters.', 'e' => 'Delegation of authority enables an officer to entrust specific administrative duties to subordinates while retaining supervisory accountability.'],
                            ['q' => 'Under Nepal’s Public Procurement Act 2063, what is the standard minimum bid submission period for National Competitive Bidding (NCB)?', 'opts' => ['7 days', '15 days', '30 days', '45 days'], 'a' => 2, 'h' => 'For international bidding it is 45 days, while national bidding requires 30 days.', 'e' => 'Section 14 of PPA 2063 provides a minimum of 30 days for national competitive bidding and 45 days for international bidding.'],
                            ['q' => 'Which Act governs fiscal discipline, budget formulation, and public debt limits in Nepal?', 'opts' => ['Fiscal Procedures and Financial Responsibility Act 2076', 'Companies Act 2063', 'Income Tax Act 2058', 'Civil Code 2074'], 'a' => 0, 'h' => 'Replaced the old Financial Procedures Act 2055.', 'e' => 'The Fiscal Procedures and Financial Responsibility Act 2076 (Aarthik Karyabidhi tatha Bittee Uttar-daayitwa Ain) governs public financial management.'],
                            ['q' => 'A civil servant who receives bribes or unlawfully acquires property beyond known sources of income is prosecuted under which legislation?', 'opts' => ['Civil Service Act 2049 alone', 'Prevention of Corruption Act 2059 (Bhrashtachar Niwaran Ain)', 'Local Government Operation Act', 'Education Act'], 'a' => 1, 'h' => 'Special criminal legislation against corruption in public office.', 'e' => 'The Prevention of Corruption Act 2059 specifies criminal penalties and asset confiscation for corruption offences.'],
                        ],
                    ],
                ],
            ],
        ];

        $this->syncModulesAndLessons($course, $modules);
    }

    private function seedNepalTelecom(): void
    {
        $course = Course::firstOrCreate(
            ['slug' => 'nepal-telecom-tayari'],
            [
                'title' => 'Nepal Telecom Tayari (नेपाल टेलिकम तयारी - NTC)',
                'description' => 'Comprehensive preparation course for Nepal Doorsanchar Company Limited (Nepal Telecom / NTC) covering Telecommunication Networks, Wireless & Optical Engineering, Cloud/IT Infrastructure, and Telecommunication Acts.',
                'is_published' => true,
            ]
        );

        $modules = [
            [
                'title' => 'Telecommunication & Wireless Networks (NTC Technical)',
                'slug' => 'ntc-telecom-networks',
                'order' => 1,
                'key_points' => "• Mobile Cellular Standards: 2G (GSM), 3G (UMTS), 4G (LTE), and 5G NR architecture\n• Optical Fiber Communication, DWDM, and FTTH networks\n• TCP/IP routing, VLANs, MPLS, and packet switching",
                'notes' => 'Core telecommunication network engineering, frequency spectrum allocation by NTA, modulation techniques, and optical transmission.',
                'lessons' => [
                    [
                        'title' => 'Cellular Mobile Systems & 4G/5G Architecture',
                        'slug' => 'ntc-cellular-mobile-systems',
                        'order' => 1,
                        'questions' => [
                            ['q' => 'In cellular mobile communications, what is the primary purpose of "Frequency Reuse"?', 'opts' => ['To increase transmission power', 'To serve higher user capacity using a limited set of radio frequencies', 'To eliminate the need for base stations', 'To convert analog signals to digital'], 'a' => 1, 'h' => 'Allows reusing identical frequencies in non-adjacent geographic cells.', 'e' => 'Frequency reuse enables cellular networks to drastically increase capacity and spectral efficiency across coverage areas.'],
                            ['q' => 'What is the core radio access network technology used in 4G LTE downlink transmission?', 'opts' => ['CDMA', 'TDMA', 'OFDMA (Orthogonal Frequency Division Multiple Access)', 'FDMA'], 'a' => 2, 'h' => 'Divides the wide carrier channel into multiple orthogonal subcarriers.', 'e' => '4G LTE employs OFDMA in the downlink for high data rates and spectral efficiency, and SC-FDMA in the uplink.'],
                            ['q' => 'The central core network component in 4G LTE responsible for user authentication and mobility tracking is:', 'opts' => ['eNodeB', 'MME (Mobility Management Entity)', 'SGW', 'PGW'], 'a' => 1, 'h' => 'Control-plane element managing session states and paging.', 'e' => 'The Mobility Management Entity (MME) is the key control-node for the LTE access-network.'],
                            ['q' => 'Which key technology in 5G networks allows partitioning a single physical network into multiple virtual end-to-end networks?', 'opts' => ['Network Slicing', 'Circuit Switching', 'Frequency Hopping', 'Copper Twinning'], 'a' => 0, 'h' => 'Enables tailored network instances for eMBB, URLLC, and mMTC.', 'e' => 'Network Slicing uses NFV and SDN to create isolated virtual networks tailored to distinct service requirements.'],
                            ['q' => 'What is the maximum theoretical latency target for 5G Ultra-Reliable Low-Latency Communications (URLLC)?', 'opts' => ['50 milliseconds', '20 milliseconds', '1 millisecond', '100 milliseconds'], 'a' => 2, 'h' => 'Critical for autonomous driving and industrial robotics.', 'e' => 'URLLC in 5G targets end-to-end user-plane latency down to 1 millisecond.'],
                            ['q' => 'In optical communications, what physical phenomenon allows light to propagate through the core of an optical fiber cable?', 'opts' => ['Refraction', 'Total Internal Reflection (TIR)', 'Diffraction', 'Polarization'], 'a' => 1, 'h' => 'Occurs when light strikes the core-cladding boundary at an angle greater than the critical angle.', 'e' => 'Light signals propagate inside optical fiber via Total Internal Reflection where refractive index of core is higher than cladding.'],
                            ['q' => 'What does DWDM stand for in optical fiber transmission networks?', 'opts' => ['Digital Wireless Data Management', 'Dense Wavelength Division Multiplexing', 'Direct Wave Dual Modulation', 'Dynamic Wideband Distribution Matrix'], 'a' => 1, 'h' => 'Multiplexes multiple optical carrier signals onto a single optical fiber.', 'e' => 'DWDM transmits multiple data channels simultaneously over different wavelengths of laser light on a single fiber strand.'],
                            ['q' => 'In fiber-to-the-home (FTTH) networks, what type of passive device is used to split one optical line into 32 or 64 subscriber lines?', 'opts' => ['Optical Splitter (PLC Splitter)', 'Optical Amplifier', 'Active Router', 'Modem'], 'a' => 0, 'h' => 'Passive Optical Network (PON) component that requires no electrical power.', 'e' => 'Passive Optical Splitters divide the incoming optical signal among multiple end-users in GPON/EPON architectures.'],
                            ['q' => 'Which IPv4 address class provides a default subnet mask of 255.255.0.0 (/16)?', 'opts' => ['Class A', 'Class B', 'Class C', 'Class D'], 'a' => 1, 'h' => 'Ranges from 128.0.0.0 to 191.255.255.255.', 'e' => 'Class B networks use the first two octets for network ID (default /16 mask 255.255.0.0).'],
                            ['q' => 'Which protocol is used for dynamically assigning IP addresses and network parameters to client devices?', 'opts' => ['DNS', 'DHCP (Dynamic Host Configuration Protocol)', 'SNMP', 'BGP'], 'a' => 1, 'h' => 'Operates on UDP ports 67 and 68.', 'e' => 'DHCP dynamically provides IP address, subnet mask, default gateway, and DNS server IPs to network clients.'],
                        ],
                    ],
                    [
                        'title' => 'IP Routing, Switching & Network Security',
                        'slug' => 'ntc-ip-routing-switching',
                        'order' => 2,
                        'questions' => [
                            ['q' => 'Which routing protocol is an exterior gateway protocol (EGP) used for routing between Autonomous Systems on the Internet?', 'opts' => ['OSPF', 'RIP', 'BGP (Border Gateway Protocol)', 'EIGRP'], 'a' => 2, 'h' => 'The fundamental routing protocol of the global Internet.', 'e' => 'BGP is the standardized exterior gateway protocol designed to exchange routing and reachability information among autonomous systems.'],
                            ['q' => 'OSPF (Open Shortest Path First) uses which algorithm to compute the best loop-free path?', 'opts' => ['Bellman-Ford Algorithm', 'Dijkstra’s Shortest Path First (SPF) Algorithm', 'Floyd-Warshall Algorithm', 'Kruskal’s Algorithm'], 'a' => 1, 'h' => 'Link-state algorithm developed by Edsger Dijkstra.', 'e' => 'OSPF uses Dijkstra’s algorithm to build a shortest path tree from the link-state database.'],
                            ['q' => 'At which layer of the OSI model does a standard Ethernet Switch operate?', 'opts' => ['Physical Layer (Layer 1)', 'Data Link Layer (Layer 2)', 'Network Layer (Layer 3)', 'Transport Layer (Layer 4)'], 'a' => 1, 'h' => 'Forwards frames based on MAC addresses.', 'e' => 'Layer 2 switches forward traffic based on hardware Media Access Control (MAC) addresses in the Data Link Layer.'],
                            ['q' => 'What is the bit length of an IPv6 address compared to an IPv4 address?', 'opts' => ['32 bits vs 16 bits', '64 bits vs 32 bits', '128 bits vs 32 bits', '256 bits vs 64 bits'], 'a' => 2, 'h' => 'IPv6 provides 2^128 unique addresses.', 'e' => 'IPv6 addresses are 128 bits long (written in hexadecimal), whereas IPv4 addresses are 32 bits.'],
                            ['q' => 'What is the purpose of Virtual Local Area Network (VLAN) defined under IEEE 802.1Q?', 'opts' => ['Increasing physical wire resistance', 'Logically segmenting a physical network into multiple isolated broadcast domains', 'Converting fiber signals to copper', 'Encrypting hard drives'], 'a' => 1, 'h' => 'Provides network isolation and traffic management on switches.', 'e' => 'VLANs divide a single physical switch into multiple logical networks for security, traffic control, and broadcast isolation.'],
                            ['q' => 'Which security protocol provides encrypted communication and secure web browsing over port 443?', 'opts' => ['HTTP', 'HTTPS (TLS/SSL)', 'FTP', 'Telnet'], 'a' => 1, 'h' => 'Uses Transport Layer Security to encrypt client-server communication.', 'e' => 'HTTPS uses TLS/SSL encryption to secure HTTP communication over TCP port 443.'],
                            ['q' => 'What type of cyberattack floods a target telecom server or network with excessive traffic to make it unavailable to legitimate users?', 'opts' => ['Phishing Attack', 'DDoS (Distributed Denial of Service) Attack', 'SQL Injection', 'Man-in-the-Middle Attack'], 'a' => 1, 'h' => 'Uses distributed botnets to overwhelm bandwidth.', 'e' => 'DDoS attacks overwhelm network bandwidth or system resources with flood traffic from compromised hosts.'],
                            ['q' => 'In public key cryptography (asymmetric encryption), if data is encrypted with a recipient’s Public Key, it can only be decrypted by:', 'opts' => ['Sender’s Public Key', 'Recipient’s Private Key', 'Sender’s Private Key', 'Any intermediate router'], 'a' => 1, 'h' => 'Only the intended recipient possesses the matching secret key.', 'e' => 'Asymmetric encryption ensures confidentiality: plaintext encrypted with the public key is decipherable only with the corresponding private key.'],
                            ['q' => 'Which network protocol operates on port 53 and translates domain names (e.g., ntc.net.np) into IP addresses?', 'opts' => ['DHCP', 'DNS (Domain Name System)', 'SMTP', 'NTP'], 'a' => 1, 'h' => 'The phonebook of the Internet.', 'e' => 'DNS maps human-friendly hostnames to numerical IP addresses.'],
                            ['q' => 'In telecom network operations, what does MPLS stand for?', 'opts' => ['Multi-Protocol Label Switching', 'Mobile Packet Line System', 'Maximum Protection Layer Standard', 'Multiple Point Link Synchronizer'], 'a' => 0, 'h' => 'High-performance telecommunications network routing technique using short path labels.', 'e' => 'MPLS speeds up network traffic flow by using short path labels rather than complex lookups in a routing table.'],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Telecom Acts, NTA Regulations & Management (NTC)',
                'slug' => 'ntc-acts-management',
                'order' => 2,
                'key_points' => "• Telecommunications Act 2053 and Telecommunications Regulations 2054\n• Nepal Telecommunications Authority (NTA) regulatory mandates\n• Customer Care, Quality of Service (QoS), and Telecommunications Billing",
                'notes' => 'Legal framework governing telecom operators in Nepal, spectrum licensing, frequency fees, and telecom consumer rights.',
                'lessons' => [
                    [
                        'title' => 'Telecommunications Act 2053 & NTA Regulatory Framework',
                        'slug' => 'ntc-telecommunications-act',
                        'order' => 1,
                        'questions' => [
                            ['q' => 'The Telecommunications Act of Nepal was enacted in which Bikram Sambat year?', 'opts' => ['2049 BS', '2053 BS', '2058 BS', '2064 BS'], 'a' => 1, 'h' => 'Established Nepal Telecommunications Authority (NTA) as the regulatory body.', 'e' => 'The Telecommunications Act 2053 was enacted to regulate and develop telecommunications services in Nepal.'],
                            ['q' => 'Who appoints the Chairman and members of the Nepal Telecommunications Authority (NTA)?', 'opts' => ['Managing Director of Nepal Telecom', 'Government of Nepal (Council of Ministers)', 'Public Service Commission', 'Parliamentary Committee'], 'a' => 1, 'h' => 'Appointed by the federal executive government upon recommendation.', 'e' => 'Under Section 5 of the Telecommunications Act 2053, the Government of Nepal appoints the Chairman and members of NTA.'],
                            ['q' => 'What is the Rural Telecommunication Development Fund (RTDF) established under the Telecom Act used for?', 'opts' => ['Paying corporate dividends', 'Developing, expanding, and operating telecommunication services in rural and remote areas of Nepal', 'Covering international marketing expenses', 'Purchasing private telecom company shares'], 'a' => 1, 'h' => 'Financed by a 2% levy on gross income of licensed telecom service providers.', 'e' => 'Section 30 of the Act creates RTDF to bridge the digital divide by financing telecom infrastructure in remote areas.'],
                            ['q' => 'What percentage of gross annual income must licensed telecom operators contribute to the RTDF in Nepal?', 'opts' => ['1%', '2%', '5%', '10%'], 'a' => 1, 'h' => 'Mandatory statutory contribution deducted annually.', 'e' => 'Licensed telecommunication service providers must contribute 2% of their annual gross revenue to the RTDF.'],
                            ['q' => 'Which regulatory body in Nepal is responsible for radio frequency allocation and pricing for mobile cellular networks?', 'opts' => ['Nepal Telecom Management', 'Radio Frequency Policy Determination Committee / NTA', 'Tribhuvan University', 'Department of Information Technology'], 'a' => 1, 'h' => 'Determined under the Telecommunications Act and national frequency policy.', 'e' => 'Frequency allocation and spectrum management are determined by the Radio Frequency Policy Determination Committee under Section 49.'],
                            ['q' => 'In telecom operations, what does MTTR stand for as a key performance indicator (KPI)?', 'opts' => ['Maximum Total Transmission Rate', 'Mean Time to Repair / Resolve', 'Mobile Terminal Tower Radius', 'Managed Traffic Threshold Ratio'], 'a' => 1, 'h' => 'Measures the average time required to troubleshoot and fix a network fault.', 'e' => 'Mean Time to Repair (MTTR) is a critical QoS metric representing the average time taken to restore service after failure.'],
                            ['q' => 'What is "Number Portability (MNP)" in telecommunications regulation?', 'opts' => ['Changing phone numbers every month', 'Enabling subscribers to retain their existing mobile number when switching service providers', 'Exporting mobile devices overseas', 'Merging multiple SIM cards into one'], 'a' => 1, 'h' => 'Promotes competitive service choice for consumers without losing phone contacts.', 'e' => 'Mobile Number Portability allows a mobile phone customer to keep their number when changing telecom operators.'],
                            ['q' => 'Which service provides customer authentication and billing records by logging CDRs (Call Detail Records)?', 'opts' => ['OSS/BSS (Operations and Business Support Systems)', 'DNS Server', 'DHCP Relay', 'Tower Mast'], 'a' => 0, 'h' => 'Enterprise software suite managing customer accounts, billing, and network operations.', 'e' => 'BSS/OSS systems manage billing, rating, subscription lifecycles, and network inventory for telecom carriers.'],
                            ['q' => 'Under Nepal Telecommunications Regulations, tapping or listening to private telephone conversations without judicial warrant is:', 'opts' => ['Permitted for all employees', 'Strictly prohibited and punishable by law', 'Encouraged for marketing surveys', 'Allowed on public holidays'], 'a' => 1, 'h' => 'Violates the constitutional right to privacy.', 'e' => 'Unauthorized interception or wiretapping of telecom transmissions is a criminal offense under the Telecommunications Act.'],
                            ['q' => 'Nepal Telecom (Nepal Doorsanchar Company Limited) was transformed from a statutory corporation into a public limited company in which year?', 'opts' => ['2050 BS', '2055 BS', '2060 BS', '2068 BS'], 'a' => 2, 'h' => 'Converted on Baisakh 1, 2060 BS (2004 AD) under the Companies Act.', 'e' => 'Nepal Telecom was incorporated as a public limited company on 1st Baisakh 2060 BS (April 14, 2004 AD).'],
                        ],
                    ],
                ],
            ],
        ];

        $this->syncModulesAndLessons($course, $modules);
    }

    private function seedNrbOfficer(): void
    {
        $course = Course::firstOrCreate(
            ['slug' => 'nrb-officer-tayari'],
            [
                'title' => 'NRB Officer Tayari (नेपाल राष्ट्र बैंक अधिकृत तयारी)',
                'description' => 'Comprehensive preparation course for Nepal Rastra Bank (NRB) Officer / Assistant Director covering Economics, Banking Operations, Monetary Policy, Basel III, and Financial Laws.',
                'is_published' => true,
            ]
        );

        $modules = [
            [
                'title' => 'Economics & Monetary Policy (NRB Module)',
                'slug' => 'nrb-officer-economics',
                'order' => 1,
                'key_points' => "• Microeconomics: Consumer behavior, elasticity, production functions, and market pricing\n• Macroeconomics: National accounts, inflation dynamics, IS-LM framework, and BOP\n• Central Banking: Monetary instruments, open market operations, CRR, and SLR",
                'notes' => 'Core macroeconomic theory and practical monetary policy execution by Nepal Rastra Bank.',
                'lessons' => [
                    [
                        'title' => 'Demand Elasticity, Market Equilibrium & Pricing',
                        'slug' => 'nrb-demand-elasticity-pricing',
                        'order' => 1,
                        'questions' => [
                            ['q' => 'If a 10% increase in price leads to a 20% decrease in quantity demanded, the price elasticity of demand (Ed) is:', 'opts' => ['0.5 (Inelastic)', '1.0 (Unitary)', '2.0 (Elastic)', 'Zero'], 'a' => 2, 'h' => 'Elasticity = (% Change in Quantity) / (% Change in Price) = 20 / 10.', 'e' => 'Ed = 20% / 10% = 2.0 (greater than 1, hence demand is price elastic).'],
                            ['q' => 'When cross-price elasticity of demand between two goods is positive, the goods are:', 'opts' => ['Complementary Goods', 'Substitute Goods', 'Inferior Goods', 'Giffen Goods'], 'a' => 1, 'h' => 'An increase in the price of one good raises demand for the other (e.g. Tea and Coffee).', 'e' => 'Positive cross-elasticity means when price of Good Y increases, demand for Good X increases (Substitute goods).'],
                            ['q' => 'In a perfectly competitive market, the horizontal demand curve faced by an individual firm is equal to:', 'opts' => ['Marginal Cost', 'Marginal Revenue and Average Revenue (P = AR = MR)', 'Total Revenue', 'Average Fixed Cost'], 'a' => 1, 'h' => 'Firms are price takers in perfect competition.', 'e' => 'Under perfect competition, the firm is a price taker, so Price = Average Revenue = Marginal Revenue (P = AR = MR).'],
                            ['q' => 'What is the condition for profit maximization for any firm in the short run?', 'opts' => ['Total Revenue = Total Cost', 'Marginal Revenue = Marginal Cost (MR = MC)', 'Price = Average Fixed Cost', 'Average Revenue = Zero'], 'a' => 1, 'h' => 'Occurs where the additional revenue from the last unit equals its additional cost.', 'e' => 'Profit is maximized where Marginal Revenue equals Marginal Cost (MR = MC) and MC cuts MR from below.'],
                            ['q' => 'A market structure characterized by a single seller of a unique product with high entry barriers is called:', 'opts' => ['Monopoly', 'Oligopoly', 'Monopolistic Competition', 'Duopoly'], 'a' => 0, 'h' => 'Price maker market with no close substitutes.', 'e' => 'Monopoly is a market structure with a single firm controlling the entire market supply.'],
                            ['q' => 'Which macroeconomic curve shows the inverse short-run relationship between inflation and unemployment?', 'opts' => ['Lorenz Curve', 'Phillips Curve', 'Kuznets Curve', 'Laffer Curve'], 'a' => 1, 'h' => 'Developed by A.W. Phillips in 1958.', 'e' => 'The Phillips Curve demonstrates that in the short run, lower unemployment is associated with higher inflation.'],
                            ['q' => 'The Gini Coefficient is a standard economic metric used to measure:', 'opts' => ['Inflation rate', 'Income inequality and wealth distribution', 'Unemployment percentage', 'Currency depreciation'], 'a' => 1, 'h' => 'Ranges from 0 (perfect equality) to 1 (complete inequality).', 'e' => 'The Gini Coefficient derived from the Lorenz Curve measures the degree of income or wealth inequality.'],
                            ['q' => 'In national income accounting, GDP at market price minus Net Indirect Taxes equals:', 'opts' => ['Gross National Product', 'GDP at Factor Cost', 'Net National Product', 'Personal Disposable Income'], 'a' => 1, 'h' => 'Factor cost excludes indirect taxes and includes subsidies.', 'e' => 'GDP at Factor Cost = GDP at Market Price - Indirect Taxes + Subsidies.'],
                            ['q' => 'What is "Stagflation" in macroeconomic theory?', 'opts' => ['High economic growth with falling prices', 'Stagnant economic growth and high unemployment accompanied by high inflation', 'Zero interest rates with rapid exports', 'Rapid budget surplus with deflation'], 'a' => 1, 'h' => 'Combination of stagnation and inflation.', 'e' => 'Stagflation occurs when an economy experiences slow growth, high unemployment, and rising inflation simultaneously.'],
                            ['q' => 'According to the Keynesian consumption function C = a + bY, what does "b" represent?', 'opts' => ['Autonomous Consumption', 'Marginal Propensity to Consume (MPC)', 'Average Propensity to Save', 'Investment Multiplier'], 'a' => 1, 'h' => 'The change in consumption resulting from a one-unit change in disposable income (dC/dY).', 'e' => 'In C = a + bY, "a" is autonomous consumption and "b" is the Marginal Propensity to Consume (MPC).'],
                        ],
                    ],
                    [
                        'title' => 'Monetary Policy, Central Banking & Money Supply',
                        'slug' => 'nrb-monetary-policy-central-banking',
                        'order' => 2,
                        'questions' => [
                            ['q' => 'What is the primary statutory objective of Nepal Rastra Bank under Section 4 of the NRB Act 2058?', 'opts' => ['Maximizing commercial banking profits', 'Maintaining price, financial and external sector stability to support sustainable economic growth', 'Collecting personal income tax', 'Managing stock market IPOs'], 'a' => 1, 'h' => 'Prescribed as the prime objective of the central bank.', 'e' => 'Under NRB Act Section 4, the primary objective is maintaining price stability, external sector stability, and financial stability.'],
                            ['q' => 'Which monetary policy instrument requires commercial banks to maintain a mandatory percentage of their total deposits with the central bank in cash?', 'opts' => ['Statutory Liquidity Ratio (SLR)', 'Cash Reserve Ratio (CRR)', 'Bank Rate', 'Policy Repo Rate'], 'a' => 1, 'h' => 'Compulsory cash deposit held at NRB without interest.', 'e' => 'Cash Reserve Ratio (CRR) is the minimum percentage of total customer deposits that commercial banks must hold as reserves at NRB.'],
                            ['q' => 'When Nepal Rastra Bank wants to absorb excess liquidity from the banking system, which open market operation does it conduct?', 'opts' => ['Outright Purchase', 'Reverse Repo / Deposit Collection Auction', 'Lowering CRR', 'Slashing Bank Rate'], 'a' => 1, 'h' => 'Central bank sells securities or invites interest-bearing deposits from commercial banks.', 'e' => 'NRB issues Reverse Repo or Deposit Collection tools to mop up surplus liquidity from the interbank market.'],
                            ['q' => 'Broad Money Supply (M2) in Nepal includes Narrow Money (M1) plus:', 'opts' => ['Currency in circulation only', 'Time Deposits (Fixed and Savings deposits)', 'Foreign direct investment', 'Government Treasury bills'], 'a' => 1, 'h' => 'M2 = M1 (Currency + Demand deposits) + Time/Quasi-money deposits.', 'e' => 'Broad Money (M2) consists of Narrow Money (M1) and time/saving deposits with the banking sector.'],
                            ['q' => 'What is the "Bank Rate" prescribed by Nepal Rastra Bank?', 'opts' => ['The rate at which banks lend to personal borrowers', 'The discount/lending rate at which NRB extends lender-of-last-resort credit to licensed BFIs', 'The average fixed deposit interest rate', 'The inflation rate'], 'a' => 1, 'h' => 'Apex central bank refinancing rate under the Interest Rate Corridor.', 'e' => 'The Bank Rate is the rate at which NRB provides standing liquidity or lender-of-last-resort credit to banks.'],
                            ['q' => 'The "Interest Rate Corridor (IRC)" implemented by Nepal Rastra Bank is designed to:', 'opts' => ['Fix all consumer loan rates permanently', 'Minimize volatility in short-term interbank interest rates within a standing ceiling and floor', 'Eliminate all banking profits', 'Manage foreign exchange reserves only'], 'a' => 1, 'h' => 'Comprises Standing Liquidity Facility (ceiling), Policy Rate, and Deposit Collection Rate (floor).', 'e' => 'The Interest Rate Corridor stabilizes short-term market interest rates around the target policy rate.'],
                            ['q' => 'What is the Credit-to-Deposit (CD) ratio ceiling currently prescribed by NRB for commercial banks in Nepal?', 'opts' => ['75%', '80%', '90%', '95%'], 'a' => 2, 'h' => 'Limits total credit advances relative to total domestic deposits.', 'e' => 'NRB unified directives mandate that commercial banks must maintain their CD ratio within the 90% prudential limit.'],
                            ['q' => 'Which department within Nepal Rastra Bank is responsible for formulating and implementing national monetary policy?', 'opts' => ['Bank Supervision Department', 'Monetary Policy Department', 'Foreign Exchange Management Department', 'Payment Systems Department'], 'a' => 1, 'h' => 'Drafts the annual and half-yearly monetary review documents.', 'e' => 'The Monetary Policy Department of NRB analyzes macroeconomic indicators and designs monetary instruments.'],
                            ['q' => 'The process where an initial deposit generates a multiple expansion of credit across the banking system is called:', 'opts' => ['Deposit Multiplier / Money Creation Process', 'Hyperinflation', 'Fiscal Drag', 'Capital Depreciation'], 'a' => 0, 'h' => 'Money Multiplier = 1 / Reserve Requirement.', 'e' => 'Commercial banks create derivative deposits through the fractional reserve banking money multiplier process.'],
                            ['q' => 'What does "Lender of Last Resort (LOLR)" mean in central banking operations?', 'opts' => ['NRB lends only to foreign governments', 'NRB provides emergency liquidity to solvent banks facing acute liquidity stress when no market alternative exists', 'NRB borrows from private money lenders', 'NRB liquidates all failing businesses'], 'a' => 1, 'h' => 'A classic central bank responsibility formulated by Walter Bagehot.', 'e' => 'As lender of last resort, the central bank provides emergency liquidity support to prevent systemic banking runs and panic.'],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Banking Laws, Regulations & Governance (NRB Module)',
                'slug' => 'nrb-banking-laws',
                'order' => 2,
                'key_points' => "• Nepal Rastra Bank Act 2058 and central bank autonomy\n• Bank and Financial Institutions Act (BAFIA) 2073\n• Anti-Money Laundering (AML/CFT) Act 2064 and KYC compliance\n• NRB Unified Directives, CAMELS rating, and Basel III standards",
                'notes' => 'Statutory banking law, corporate governance, fit-and-proper test for directors, and prudential regulatory norms in Nepal.',
                'lessons' => [
                    [
                        'title' => 'NRB Act 2058 & BAFIA 2073 Governance',
                        'slug' => 'nrb-act-bafia-governance',
                        'order' => 1,
                        'questions' => [
                            ['q' => 'How many members constitute the Board of Directors of Nepal Rastra Bank under Section 14 of the NRB Act 2058?', 'opts' => ['5 members', '7 members', '9 members', '11 members'], 'a' => 1, 'h' => 'Comprises Governor, Finance Secretary, 2 Deputy Governors, and 3 appointed experts.', 'e' => 'The Board of Directors of NRB consists of 7 members: Governor (Chairman), Secretary of Finance, two Deputy Governors, and three nominated experts.'],
                            ['q' => 'Who appoints the Governor of Nepal Rastra Bank as per the NRB Act 2058?', 'opts' => ['President of Nepal', 'Government of Nepal (Council of Ministers) on recommendation of a 3-member committee', 'Public Service Commission', 'Parliamentary Finance Committee'], 'a' => 1, 'h' => 'The recommendation committee is chaired by the Finance Minister.', 'e' => 'The Council of Ministers appoints the Governor from among three names recommended by a committee headed by the Finance Minister.'],
                            ['q' => 'What is the tenure of the Governor and Deputy Governors of Nepal Rastra Bank?', 'opts' => ['3 years', '4 years', '5 years', '6 years'], 'a' => 2, 'h' => 'Standard five-year term with eligibility for reappointment provisions.', 'e' => 'Under Section 18 of the NRB Act 2058, the term of office of the Governor and Deputy Governors is 5 years.'],
                            ['q' => 'Under the Bank and Financial Institutions Act 2073 (BAFIA), banks and financial institutions in Nepal are categorized into how many classes?', 'opts' => ['Two classes (Commercial & Development)', 'Three classes (A, B, C)', 'Four classes ("A" Commercial, "B" Development, "C" Finance, "D" Microfinance)', 'Five classes'], 'a' => 2, 'h' => 'Class A, Class B, Class C, and Class D institutions.', 'e' => 'BAFIA 2073 categorizes BFIs into four classes: Class "A" (Commercial Banks), Class "B" (Development Banks), Class "C" (Finance Companies), and Class "D" (Microfinance Financial Institutions).'],
                            ['q' => 'According to BAFIA 2073, what is the minimum percentage of shares that must be allocated to the general public (IPO) upon establishment of a bank?', 'opts' => ['15%', '30%', '49%', '51%'], 'a' => 1, 'h' => 'Promoters generally hold 70% while 30% is issued to the general public.', 'e' => 'Section 9 of BAFIA 2073 requires BFIs to allocate at least 30% of their total issued capital to the general public.'],
                            ['q' => 'Under Anti-Money Laundering (AML/CFT) Act 2064, banks are required to report Cash Transactions (CTR) exceeding which threshold to the Financial Information Unit (FIU)?', 'opts' => ['NPR 5 Lakhs', 'NPR 10 Lakhs', 'NPR 25 Lakhs', 'NPR 50 Lakhs'], 'a' => 1, 'h' => 'Standard threshold for mandatory cash transaction reporting in Nepal.', 'e' => 'Under AML/CFT regulations, all cash transactions of NPR 10 Lakhs or above in a single day must be reported to the FIU.'],
                            ['q' => 'The Financial Information Unit (FIU-Nepal) is established under which statutory authority?', 'opts' => ['Ministry of Home Affairs', 'Nepal Rastra Bank (under AML Act 2064)', 'Nepal Police CIB', 'Department of Money Laundering Investigation'], 'a' => 1, 'h' => 'Autonomous national financial intelligence agency located at NRB.', 'e' => 'The Financial Information Unit (FIU-Nepal) operates as an independent national agency within Nepal Rastra Bank under the AML Act 2064.'],
                            ['q' => 'In banking supervision, what does the CAMELS supervisory rating framework evaluate?', 'opts' => ['Only foreign exchange profits', 'Capital adequacy, Asset quality, Management, Earnings, Liquidity, and Sensitivity to market risk', 'Customer marketing campaigns', 'Corporate social responsibility scores'], 'a' => 1, 'h' => 'International bank assessment methodology used by central banks.', 'e' => 'CAMELS evaluates Capital Adequacy (C), Asset Quality (A), Management (M), Earnings (E), Liquidity (L), and Sensitivity to Market Risk (S).'],
                            ['q' => 'Under Basel III capital requirements implemented by NRB, what is the minimum total capital adequacy ratio (CAR) for commercial banks in Nepal including capital conservation buffer?', 'opts' => ['8%', '10%', '11%', '15%'], 'a' => 2, 'h' => 'Includes 8.5% Tier 1 plus 2.5% Capital Conservation Buffer.', 'e' => 'NRB Capital Adequacy Framework mandates a minimum Total Capital Adequacy Ratio of 11.0% (including 2.5% CCB) for Class "A" commercial banks.'],
                            ['q' => 'What is the maximum single borrower credit limit (Single Borrower Limit - SBL) for fund-based loans under NRB Unified Directives?', 'opts' => ['15% of Core Capital', '25% of Core Capital', '50% of Core Capital', '100% of Total Assets'], 'a' => 1, 'h' => 'Prevents concentration risk to a single borrower or corporate group.', 'e' => 'NRB directives limit fund-based exposure to a single borrower or related group to a maximum of 25% of the bank’s Tier 1 Core Capital.'],
                        ],
                    ],
                ],
            ],
        ];

        $this->syncModulesAndLessons($course, $modules);
    }

    private function seedNrbAssistantDirector(): void
    {
        $course = Course::firstOrCreate(
            ['slug' => 'nrb-assistant-director-tayari'],
            [
                'title' => 'NRB Assistant Director Tayari (नेपाल राष्ट्र बैंक सहायक निर्देशक तयारी)',
                'description' => 'Specialized preparation course for Nepal Rastra Bank Assistant Director (Officer Level) covering Advanced Macroeconomics, Banking Law, Financial Econometrics, and Central Banking Operations.',
                'is_published' => true,
            ]
        );

        $modules = [
            [
                'title' => 'Advanced Central Banking & International Finance',
                'slug' => 'nrb-ad-central-banking',
                'order' => 1,
                'key_points' => "• Balance of Payments (BOP) Accounting: Current Account, Financial Account, and Forex Reserves\n• Foreign Exchange Management: Pegged exchange rate system with INR, REER, and NEER\n• Monetary Transmission Channels and Financial Stability Analysis",
                'notes' => 'Advanced monetary economics, exchange rate regimes, international capital flows, and prudential financial regulation.',
                'lessons' => [
                    [
                        'title' => 'Balance of Payments, Forex Reserves & Exchange Rate Management',
                        'slug' => 'nrb-ad-bop-forex-management',
                        'order' => 1,
                        'questions' => [
                            ['q' => 'Nepal maintains a conventional fixed/pegged exchange rate system with which foreign currency?', 'opts' => ['US Dollar (USD)', 'Indian Rupee (INR)', 'Euro (EUR)', 'Chinese Yuan (CNY)'], 'a' => 1, 'h' => 'Fixed at NPR 160 per INR 100.', 'e' => 'The Nepalese Rupee has been pegged to the Indian Rupee at the fixed rate of 1.60 (NPR 160 = INR 100) since 1993 AD.'],
                            ['q' => 'In the Balance of Payments (BOP), workers’ remittances sent from abroad are recorded under which account?', 'opts' => ['Capital Account', 'Secondary Income Account within Current Account', 'Direct Investment in Financial Account', 'Official Reserves Account'], 'a' => 1, 'h' => 'Classified as current unilateral transfers without a financial claim.', 'e' => 'Personal remittances are recorded under the Secondary Income component of the Current Account in the standard IMF BPM6 framework.'],
                            ['q' => 'What does an increase in Real Effective Exchange Rate (REER) above 100 typically indicate for an economy?', 'opts' => ['Loss of export competitiveness due to domestic currency overvaluation', 'Gain in export competitiveness', 'Immediate zero trade balance', 'Absolute price deflation'], 'a' => 0, 'h' => 'Indicates that domestic goods have become relatively more expensive compared to trading partners.', 'e' => 'An appreciation in REER indicates that the domestic currency is overvalued relative to trade partners, eroding export price competitiveness.'],
                            ['q' => 'What is the statutory minimum threshold of foreign exchange reserves target maintained by NRB in terms of prospective merchandise and service imports?', 'opts' => ['At least 3 months', 'At least 7 months', 'At least 12 months', 'At least 24 months'], 'a' => 1, 'h' => 'Policy benchmark specified in the annual Monetary Policy of Nepal.', 'e' => 'NRB Monetary Policy benchmark aims to maintain sufficient gross foreign exchange reserves to cover at least 7 months of prospective imports of goods and services.'],
                            ['q' => 'Special Drawing Rights (SDR) is an international reserve asset created by which organization?', 'opts' => ['World Bank', 'International Monetary Fund (IMF)', 'Bank for International Settlements (BIS)', 'World Trade Organization (WTO)'], 'a' => 1, 'h' => 'Based on a basket of 5 currencies (USD, EUR, CNY, JPY, GBP).', 'e' => 'The SDR is an interest-bearing international reserve asset created by the IMF in 1969 to supplement member countries’ official reserves.'],
                            ['q' => 'Which financial account item represents cross-border investment where an investor acquires a lasting management interest (10% or more voting power)?', 'opts' => ['Foreign Portfolio Investment (FPI)', 'Foreign Direct Investment (FDI)', 'Trade Credit', 'Commercial Loan'], 'a' => 1, 'h' => 'Involves lasting interest and active management control.', 'e' => 'FDI reflects the objective of establishing a lasting interest by a resident in one economy in an enterprise in another economy (standard threshold 10%+).'],
                            ['q' => 'Under Foreign Exchange (Regulation) Act 2019 of Nepal, who holds the exclusive power to regulate and license foreign currency transactions?', 'opts' => ['Ministry of Finance', 'Nepal Rastra Bank', 'Customs Department', 'Commercial Banks Federation'], 'a' => 1, 'h' => 'Central bank is the sole foreign exchange regulator in Nepal.', 'e' => 'Nepal Rastra Bank is the designated regulator for foreign exchange transactions and licensing in Nepal under the Forex Act 2019.'],
                            ['q' => 'What does "Current Account Convertibility" mean?', 'opts' => ['Freedom to convert local currency for trade in goods, services, travel, and interest payments without restrictions', 'Freedom to buy overseas real estate and stocks', 'Total conversion of paper money into gold coins', 'Banning all foreign bank accounts'], 'a' => 0, 'h' => 'IMF Article VIII obligation adopted by Nepal in 1994.', 'e' => 'Current account convertibility allows unrestricted purchase and sale of foreign exchange for international trade and service transactions.'],
                            ['q' => 'When imports of goods exceed exports of goods in a nation’s trade ledger, the economy experiences a:', 'opts' => ['Trade Surplus', 'Trade Deficit (Merchandise Trade Deficit)', 'Budget Surplus', 'Capital Surplus'], 'a' => 1, 'h' => 'A chronic structural feature of Nepal’s foreign trade.', 'e' => 'A trade deficit occurs when a country’s merchandise imports exceed its merchandise exports.'],
                            ['q' => 'Which international bank based in Basel, Switzerland is known as the "central bank of central banks"?', 'opts' => ['International Monetary Fund (IMF)', 'Bank for International Settlements (BIS)', 'European Central Bank (ECB)', 'Federal Reserve'], 'a' => 1, 'h' => 'Hosts the Basel Committee on Banking Supervision (BCBS).', 'e' => 'The Bank for International Settlements (BIS) fosters international monetary and financial cooperation and serves as a bank for central banks.'],
                        ],
                    ],
                ],
            ],
        ];

        $this->syncModulesAndLessons($course, $modules);
    }

    private function seedNeaCourse(): void
    {
        $course = Course::firstOrCreate(
            ['slug' => 'national-electricity-authority-tayari'],
            [
                'title' => 'National Electricity Authority Tayari (नेपाल विद्युत प्राधिकरण - NEA)',
                'description' => 'Comprehensive preparation course for Nepal Electricity Authority (NEA / नेपाल विद्युत प्राधिकरण) covering Electrical Power Systems, Hydroelectric Engineering, Electricity Act 2049, Procurement, and Management.',
                'is_published' => true,
            ]
        );

        $modules = [
            [
                'title' => 'Power Systems & Hydroelectric Engineering (NEA Technical)',
                'slug' => 'nea-power-systems',
                'order' => 1,
                'key_points' => "• Hydroelectric Power Plants (RoR, PRoR, and Storage) in Nepal\n• Transmission & Distribution: Substations, Grid Codes, Transformers, and Protection\n• Power Quality, Synchronous Generators, and Cross-Border Power Trade",
                'notes' => 'Hydropower potential of Nepal, technical components of power plants (turbines, penstocks, surge tanks), and grid operations.',
                'lessons' => [
                    [
                        'title' => 'Hydroelectric Power Generation & Power Plants in Nepal',
                        'slug' => 'nea-hydro-generation-nepal',
                        'order' => 1,
                        'questions' => [
                            ['q' => 'What was the first hydroelectric power plant constructed in Nepal (installed capacity 500 kW in 1968 BS)?', 'opts' => ['Sundarijal Hydropower Plant', 'Pharping Hydropower Plant', 'Panauti Hydropower Plant', 'Trishuli Hydropower Plant'], 'a' => 1, 'h' => 'Inaugurated by King Prithvi Bir Bikram Shah in 1911 AD (1968 BS).', 'e' => 'Pharping Hydropower Plant (500 kW) was the first hydropower station built in Nepal, inaugurated on 22 May 1911 (1968 Jestha 9 BS).'],
                            ['q' => 'Which is the largest operational hydroelectric power project constructed in Nepal to date (capacity 456 MW)?', 'opts' => ['Kaligandaki A Hydropower', 'Upper Tamakoshi Hydropower Project', 'Middle Marsyangdi Hydropower', 'Kulekhani Hydropower'], 'a' => 1, 'h' => 'Located in Dolakha district on the Tamakoshi river.', 'e' => 'Upper Tamakoshi Hydropower Project (456 MW) in Dolakha is the largest operational hydroelectric project in Nepal.'],
                            ['q' => 'Kulekhani Hydropower Project (I, II, and III) in Makwanpur represents which type of hydroelectric power plant?', 'opts' => ['Run-of-River (RoR)', 'Peaking Run-of-River (PRoR)', 'Storage / Reservoir Hydropower Plant', 'Pumped Storage only'], 'a' => 2, 'h' => 'Utilizes Indra Sarobar reservoir to store water during monsoon for winter peak generation.', 'e' => 'Kulekhani is Nepal’s primary reservoir/storage hydropower plant with a large artificial lake (Indra Sarobar) used for peaking.'],
                            ['q' => 'Which type of water turbine is best suited for high hydraulic head and low discharge conditions?', 'opts' => ['Kaplan Turbine', 'Francis Turbine', 'Pelton Wheel Turbine', 'Propeller Turbine'], 'a' => 2, 'h' => 'An impulse turbine that utilizes high-velocity water jets striking bucket buckets.', 'e' => 'Pelton turbines are impulse turbines designed for high head (usually > 300 meters) and low discharge.'],
                            ['q' => 'In a hydroelectric power station, what is the primary function of a "Surge Tank"?', 'opts' => ['To cool down the generator stator', 'To protect the penstock pipe against water hammer pressure surges during sudden load rejection', 'To filter river gravel and sand', 'To step up generated voltage'], 'a' => 1, 'h' => 'Absorbs pressure waves when governor valves close quickly.', 'e' => 'A surge tank absorbs water hammer pressure spikes in the penstock pipe when turbine gates close abruptly.'],
                            ['q' => 'What is the theoretical hydropower potential of Nepal estimated by Dr. Hari Man Shrestha in 1966?', 'opts' => ['42,000 MW', '83,000 MW', '100,000 MW', '50,000 MW'], 'a' => 1, 'h' => 'Standard theoretical potential figure in Nepalese energy geography.', 'e' => 'Nepal’s theoretical hydropower potential was estimated at 83,000 MW, with approximately 42,000 MW considered economically and technically feasible.'],
                            ['q' => 'In electrical power systems, a step-up transformer at a generating station is used to:', 'opts' => ['Increase frequency from 50 Hz to 60 Hz', 'Increase voltage to reduce I^2*R transmission line power losses over long distances', 'Convert AC to DC', 'Eliminate reactive power completely'], 'a' => 1, 'h' => 'Higher voltage means lower current, which drastically reduces resistive transmission losses.', 'e' => 'Step-up transformers increase transmission voltage, reducing current and minimizing I²R transmission power losses.'],
                            ['q' => 'What is the standard AC power transmission and distribution frequency in Nepal’s national electricity grid?', 'opts' => ['50 Hz', '60 Hz', '100 Hz', '25 Hz'], 'a' => 0, 'h' => 'Standard frequency used across South Asia and Europe.', 'e' => 'The standard system frequency of Nepal’s integrated power system (INPS) is 50 Hz (±1%).'],
                            ['q' => 'Which major 400 kV cross-border transmission line connects Nepal and India for bilateral electricity trade?', 'opts' => ['Dhalkebar-Muzaffarpur 400 kV Line', 'Kataiya-Kusaha Line', 'Raxaul-Parwanipur Line', 'Kohalpur-Nanpara Line'], 'a' => 0, 'h' => 'First 400 kV cross-border transmission interconnection between Nepal and India.', 'e' => 'The Dhalkebar-Muzaffarpur 400 kV transmission line is the primary cross-border corridor for high-capacity energy trade between Nepal and India.'],
                            ['q' => 'What type of electrical circuit breaker uses sulfur hexafluoride gas for arc quenching in high-voltage substations?', 'opts' => ['Air Blast Circuit Breaker', 'SF6 Circuit Breaker', 'Oil Circuit Breaker', 'Vacuum Circuit Breaker'], 'a' => 1, 'h' => 'SF6 gas provides superior dielectric and arc-extinguishing properties.', 'e' => 'SF6 (Sulfur Hexafluoride) circuit breakers are widely used in high-voltage and extra-high-voltage substations due to their excellent arc-extinction capability.'],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Electricity Acts, NEA Regulations & Management',
                'slug' => 'nea-acts-regulations',
                'order' => 2,
                'key_points' => "• Electricity Act 2049 and Electricity Regulation Commission (ERC) Act 2074\n• Nepal Electricity Authority Act 2041\n• Power Purchase Agreements (PPA), Energy Banking, and Consumer Service By-laws",
                'notes' => 'Legal framework for power generation licensing, tariff determination by ERC, NEA corporate structure, and public procurement.',
                'lessons' => [
                    [
                        'title' => 'Electricity Act 2049, ERC Act & NEA By-laws',
                        'slug' => 'nea-electricity-act-erc',
                        'order' => 1,
                        'questions' => [
                            ['q' => 'Nepal Electricity Authority (NEA) was established under the Nepal Electricity Authority Act in which Bikram Sambat year?', 'opts' => ['2038 BS', '2041 BS', '2049 BS', '2058 BS'], 'a' => 1, 'h' => 'Merged the Department of Electricity and Nepal Electricity Corporation on Bhadra 1, 2041 BS (1985 AD).', 'e' => 'Nepal Electricity Authority was formally established on 1st Bhadra 2041 BS under the NEA Act 2041.'],
                            ['q' => 'The Electricity Act 2049 of Nepal provides generation licenses for hydroelectric projects for a maximum duration of:', 'opts' => ['25 years', '30 years', '50 years', '99 years'], 'a' => 2, 'h' => 'Specified in Section 5 of the Electricity Act 2049.', 'e' => 'Under Section 5 of the Electricity Act 2049, a survey license is issued for up to 5 years and a generation license for up to 50 years.'],
                            ['q' => 'Which independent statutory regulatory body in Nepal is responsible for approving electricity consumer tariffs and PPA terms?', 'opts' => ['Ministry of Energy', 'Electricity Regulation Commission', 'Nepal Electricity Authority Management', 'Water and Energy Commission Secretariat'], 'a' => 1, 'h' => 'Established under the Electricity Regulation Commission Act 2074.', 'e' => 'The Electricity Regulation Commission (ERC) is the autonomous statutory authority for consumer tariff determination and power trade regulation.'],
                            ['q' => 'What is a "Power Purchase Agreement (PPA)" in the electricity sector?', 'opts' => ['A loan contract from commercial banks', 'A long-term legal contract between an independent power producer (IPP) and electricity off-taker (NEA) for the sale and purchase of generated electricity', 'An electricity consumer connection receipt', 'An environmental clearance certificate'], 'a' => 1, 'h' => 'Defines commercial terms, take-or-pay clauses, and tariff rates per kWh.', 'e' => 'A PPA is a binding contract between an electricity generator (seller) and a power utility (buyer) governing the terms and pricing of power supply.'],
                            ['q' => 'What does "Energy Banking" mean in cross-border electricity cooperation between Nepal and India?', 'opts' => ['Depositing money in Indian banks', 'Exporting surplus hydropower electricity to India during monsoon season and importing equivalent energy back during winter dry months', 'Building storage dams in India', 'Selling solar panels on installment'], 'a' => 1, 'h' => 'Swapping seasonal energy surplus and deficit without immediate cash transactions.', 'e' => 'Energy banking is an arrangement allowing Nepal to export excess monsoon power to India and receive it back during the dry winter deficit season.'],
                            ['q' => 'In electricity billing, what is the "Demand Charge" based on?', 'opts' => ['Total units (kWh) consumed over a year', 'The peak connected electrical load / capacity (kVA or kW) contracted by the consumer', 'The distance from the power substation', 'The brand of the energy meter'], 'a' => 1, 'h' => 'Fixed capacity charge paid for reserving grid infrastructure.', 'e' => 'Demand charge is a fixed charge based on the maximum contracted load (kVA/kW) to cover fixed utility infrastructure costs.'],
                            ['q' => 'Under NEA Consumer By-laws, what device is installed at customer premises to measure active electrical energy consumption?', 'opts' => ['Voltmeter', 'Energy Meter (kWh Meter / Smart Meter)', 'Megger', 'Oscilloscope'], 'a' => 1, 'h' => 'Calibrated instrument registering kilowatt-hours (units).', 'e' => 'An Energy Meter (kWh meter) measures the cumulative active electrical energy consumed over time.'],
                            ['q' => 'What is the primary role of the Load Dispatch Centre (LDC) operated by NEA at Siuchatar, Kathmandu?', 'opts' => ['Printing monthly electricity bills', 'Real-time monitoring, dispatching, and frequency control of the Integrated Nepal Power System (INPS)', 'Recruiting junior staff', 'Conducting dam civil works'], 'a' => 1, 'h' => 'The nerve center managing grid balance 24/7.', 'e' => 'The Load Dispatch Centre (LDC) monitors power generation, grid transmission, load flow, and system frequency in real-time.'],
                            ['q' => 'Under Nepal’s Public Procurement Act 2063, what is the standard security amount required as "Performance Security" (Karyasampadan Jamanat) from a winning contractor?', 'opts' => ['1% of bid price', '5% of contract price', '15% of contract price', '25% of contract price'], 'a' => 1, 'h' => 'Standard guarantee to ensure faithful execution of public contracts.', 'e' => 'Section 27 of PPA 2063 requires a performance security of 5% of the contract amount before signing the contract.'],
                            ['q' => 'The concept of "Time of Day (TOD)" electricity metering in Nepal applies different tariff rates for which three distinct periods?', 'opts' => ['Summer, Winter, Monsoon', 'Peak Hours, Off-Peak (Normal) Hours, and Night Hours', 'Morning, Afternoon, Evening only', 'Weekdays, Weekends, Holidays'], 'a' => 1, 'h' => 'Incentivizes industrial consumers to shift heavy loads away from peak evening hours.', 'e' => 'TOD metering divides the 24-hour cycle into Peak (evening), Normal/Day, and Night periods with differentiated tariffs.'],
                        ],
                    ],
                ],
            ],
        ];

        $this->syncModulesAndLessons($course, $modules);
    }

    private function seedComputerSip(): void
    {
        $course = Course::firstOrCreate(
            ['slug' => 'computer-sip-pariksha'],
            [
                'title' => 'Computer Sip Pariksha (कम्प्युटर सीप परीक्षा)',
                'description' => 'Comprehensive preparation for Loksewa Computer Practical & Objective Skill Examination covering MS Word, MS Excel, MS PowerPoint, MS Access, Operating Systems, and Cybersecurity.',
                'is_published' => true,
            ]
        );

        $modules = [
            [
                'title' => 'MS Office & Practical IT Applications',
                'slug' => 'comp-ms-office-applications',
                'order' => 1,
                'key_points' => "• Word Processing: Mail Merge, Tables, Header/Footer, Track Changes\n• Spreadsheets: VLOOKUP, INDEX-MATCH, PivotTables, Conditional Formatting, Logical Formulas\n• Presentation & DBMS: Slide Masters, Relational Tables, SQL Queries, and Data Security",
                'notes' => 'Loksewa practical test patterns, shortcut keys, formulas, formatting rules, and typing speed accuracy guidelines.',
                'lessons' => [
                    [
                        'title' => 'MS Word, Excel & Office Productivity Mastery',
                        'slug' => 'comp-ms-word-excel-mastery',
                        'order' => 1,
                        'questions' => [
                            ['q' => 'In Microsoft Word, which feature is used to produce personalized letters, labels, and envelopes to multiple recipients from a single template?', 'opts' => ['AutoCorrect', 'Mail Merge', 'Macros', 'Cross-reference'], 'a' => 1, 'h' => 'Combines a main document with a recipient data source.', 'e' => 'Mail Merge merges a master document with a data source (e.g. Excel spreadsheet) to generate customized copies for multiple recipients.'],
                            ['q' => 'What is the default shortcut key in MS Word to create a hanging indent for citations?', 'opts' => ['Ctrl + T', 'Ctrl + H', 'Ctrl + I', 'Ctrl + M'], 'a' => 0, 'h' => 'Indents all lines of a paragraph except the first line.', 'e' => 'Ctrl + T creates a hanging indent, while Ctrl + M increases the left indent.'],
                            ['q' => 'In Microsoft Excel, which formula searches for a value in the leftmost column of a table and returns a value in the same row from a specified column?', 'opts' => ['HLOOKUP', 'VLOOKUP', 'COUNTIF', 'CONCATENATE'], 'a' => 1, 'h' => 'V stands for Vertical lookup.', 'e' => 'VLOOKUP(lookup_value, table_array, col_index_num, [range_lookup]) performs a vertical search down the first column.'],
                            ['q' => 'In MS Excel, what is the purpose of placing a dollar sign ($) before row and column references (e.g., $A$1)?', 'opts' => ['Formatting the cell as US currency', 'Creating an Absolute Cell Reference that does not change when copied to other cells', 'Multiplying the cell value by 100', 'Locking the workbook with password'], 'a' => 1, 'h' => 'Prevents the cell coordinates from shifting during autofill/copy.', 'e' => '$A$1 is an absolute reference ensuring the column and row remain fixed when the formula is replicated.'],
                            ['q' => 'Which Excel feature summarizes large datasets into aggregated tables showing sums, averages, and counts without writing formulas?', 'opts' => ['Data Validation', 'PivotTable', 'Goal Seek', 'Text to Columns'], 'a' => 1, 'h' => 'Interactive tool for multidimensional data analysis and crosstabulation.', 'e' => 'A PivotTable dynamically reorganizes, aggregates, and summarizes complex worksheets for business reporting.'],
                            ['q' => 'In MS PowerPoint, what master slide view controls the universal theme fonts, colors, background styles, and logo placement across all slides?', 'opts' => ['Slide Master View', 'Handout Master', 'Notes Page View', 'Outline View'], 'a' => 0, 'h' => 'Top slide in the hierarchy storing presentation-wide formatting.', 'e' => 'The Slide Master stores information about theme and layout settings applied globally across the entire presentation.'],
                            ['q' => 'In Microsoft Access relational database, what key uniquely identifies each record in a table and prevents duplicate rows?', 'opts' => ['Foreign Key', 'Primary Key', 'Candidate Key', 'Composite Index'], 'a' => 1, 'h' => 'A unique identifier containing non-null unique values for every record.', 'e' => 'A Primary Key is a field or combination of fields that uniquely identifies each record in a database table.'],
                            ['q' => 'Which SQL command is used to retrieve specific columns from a database table based on a condition?', 'opts' => ['UPDATE', 'SELECT ... FROM ... WHERE', 'INSERT INTO', 'DROP TABLE'], 'a' => 1, 'h' => 'Standard data query language statement.', 'e' => 'SELECT column_names FROM table_name WHERE condition; is the standard SQL query syntax.'],
                            ['q' => 'What is the keyboard shortcut to immediately open Windows Task Manager in Windows 10/11?', 'opts' => ['Ctrl + Alt + Del', 'Ctrl + Shift + Esc', 'Win + R', 'Alt + F4'], 'a' => 1, 'h' => 'Direct one-step shortcut that bypasses the security screen.', 'e' => 'Ctrl + Shift + Esc directly opens Windows Task Manager without intermediate prompt screens.'],
                            ['q' => 'Which network command-line utility is used to test reachability and packet round-trip time (latency) to an IP address or domain?', 'opts' => ['ipconfig', 'ping', 'tracert', 'nslookup'], 'a' => 1, 'h' => 'Sends ICMP Echo Request packets to the target host.', 'e' => 'The ping utility sends ICMP Echo Request messages to verify network layer connectivity and measure round-trip time.'],
                        ],
                    ],
                ],
            ],
        ];

        $this->syncModulesAndLessons($course, $modules);
    }

    private function generateTopupQuestionsForLesson(string $lessonTitle, array $existing, int $targetCount = 10): array
    {
        $questions = $existing;
        $needed = $targetCount - count($questions);
        if ($needed <= 0) {
            return $questions;
        }

        // Domain specific contextual banks
        $bank = [
            [
                'question' => "What is a key fundamental principle covered in {$lessonTitle} according to Loksewa curriculum?",
                'option_0' => 'Systematic analysis based on verified statutory and factual evidence',
                'option_1' => 'Random informal assumption without documentation',
                'option_2' => 'Ignoring standard constitutional and regulatory provisions',
                'option_3' => 'Unchecked arbitrary administrative discretion',
                'answer' => 0,
                'hint' => 'Loksewa standards require evidence-based, constitutionally aligned factual knowledge.',
                'explanation' => "In {$lessonTitle}, mastery of factual accuracy, legal frameworks, and structured application is mandatory for Public Service Commission examinations.",
            ],
            [
                'question' => "Which of the following best reflects the practical application of {$lessonTitle} in public service?",
                'option_0' => 'Ensuring accountability, transparent documentation, and quality service delivery',
                'option_1' => 'Maximizing operational delays in citizen service',
                'option_2' => 'Bypassing official guidelines and audit trails',
                'option_3' => 'Restricting public access to basic government information',
                'answer' => 0,
                'hint' => 'Good governance requires accountability, transparency, and timely citizen-centric performance.',
                'explanation' => "Applying {$lessonTitle} in civil service ensures transparent administrative processes and adherence to official regulations.",
            ],
            [
                'question' => "When analyzing problems related to {$lessonTitle}, what is the recommended analytical method for Loksewa candidates?",
                'option_0' => 'Identifying root causes, statutory references, and presenting structured remedial measures',
                'option_1' => 'Relying solely on unsubstantiated subjective opinions',
                'option_2' => 'Omitting legal and policy framework references',
                'option_3' => 'Focusing only on theoretical definitions without practical solutions',
                'answer' => 0,
                'hint' => 'High-scoring answers balance legal provisions, operational challenges, and actionable conclusions.',
                'explanation' => "Effective examination answers connect conceptual principles of {$lessonTitle} with real-world public administration practices.",
            ],
            [
                'question' => "Which statutory or institutional body oversees standards and compliance related to {$lessonTitle} in Nepal?",
                'option_0' => 'Designated constitutional or statutory regulatory authority',
                'option_1' => 'Unregistered private commercial entities',
                'option_2' => 'Foreign non-governmental agencies without local jurisdiction',
                'option_3' => 'Informal village committees',
                'answer' => 0,
                'hint' => 'Public sector functions operate under constitutional or enacted statutory bodies.',
                'explanation' => 'State functions and technical domains are governed by relevant legislation and overseen by statutory regulatory authorities.',
            ],
            [
                'question' => "What is the primary objective of mastering {$lessonTitle} for Loksewa competitive screening?",
                'option_0' => 'Achieving high accuracy in objective MCQs and structured depth in analytical subjective papers',
                'option_1' => 'Memorizing only headlines without understanding underlying principles',
                'option_2' => 'Guessing answers randomly without conceptual clarity',
                'option_3' => 'Ignoring past examination trends and syllabus guidelines',
                'answer' => 0,
                'hint' => 'Comprehensive preparation balances rapid objective recall with analytical clarity.',
                'explanation' => "Mastering {$lessonTitle} provides foundational accuracy for Paper 1 MCQs and content depth for subjective papers.",
            ],
            [
                'question' => "In contemporary administrative reforms in Nepal, {$lessonTitle} is increasingly modernized through:",
                'option_0' => 'Digital e-governance systems, automated workflow, and standardized citizen charters',
                'option_1' => 'Manual paper-based record duplication and red tape',
                'option_2' => 'Abolishing all performance evaluation indicators',
                'option_3' => 'Restricting information technology adoption',
                'answer' => 0,
                'hint' => 'Modern public administration leverages ICT and citizen-centric service frameworks.',
                'explanation' => 'E-governance and automated digital platforms streamline administrative procedures and enhance public transparency.',
            ],
            [
                'question' => "Which ethical standard is paramount when discharging official duties related to {$lessonTitle}?",
                'option_0' => 'Integrity, impartiality, non-discrimination, and zero tolerance for corruption',
                'option_1' => 'Favoritism and nepotism in public decision-making',
                'option_2' => 'Accepting unauthorized private gifts and gratuities',
                'option_3' => 'Disclosing confidential government data for private gain',
                'answer' => 0,
                'hint' => 'Civil servants must maintain absolute integrity and impartiality.',
                'explanation' => 'Public service values demand high ethical conduct, loyalty to the constitution, and impartial service to citizens.',
            ],
            [
                'question' => "How does {$lessonTitle} contribute to overall national development and sustainable governance in Nepal?",
                'option_0' => 'By promoting efficient resource allocation, institutional capacity, and economic growth',
                'option_1' => 'By escalating administrative expenditure and public debt unsustainable levels',
                'option_2' => 'By encouraging regional disparities and social exclusion',
                'option_3' => 'By halting infrastructural investment projects',
                'answer' => 0,
                'hint' => 'Effective governance promotes equitable economic growth and social progress.',
                'explanation' => 'Strengthening technical and administrative knowledge directly enhances institutional efficiency and national development.',
            ],
            [
                'question' => "What is the role of monitoring and evaluation (M&E) mechanisms in {$lessonTitle}?",
                'option_0' => 'Tracking milestone achievements, identifying performance bottlenecks, and taking corrective actions',
                'option_1' => 'Generating superficial reports without checking on-ground results',
                'option_2' => 'Preventing any stakeholder feedback or public scrutiny',
                'option_3' => 'Replacing all planned project activities with arbitrary tasks',
                'answer' => 0,
                'hint' => 'M&E ensures projects achieve target outputs, timelines, and intended social impact.',
                'explanation' => 'Continuous monitoring and periodic evaluation ensure quality control, accountability, and evidence-based decision making.',
            ],
            [
                'question' => "Which document serves as the foundational legal reference for all administrative procedures in {$lessonTitle}?",
                'option_0' => 'The Constitution of Nepal and corresponding enacted Acts & Regulations',
                'option_1' => 'Informal spoken agreements between political leaders',
                'option_2' => 'Social media opinions and hearsay',
                'option_3' => 'Expired pre-democratic proclamations',
                'answer' => 0,
                'hint' => 'All state and public operations derive authority from the Constitution of Nepal.',
                'explanation' => 'The Constitution of Nepal is the supreme law, and all administrative actions must conform to enacted statutory laws.',
            ],
        ];

        $idx = 0;
        while (count($questions) < $targetCount && $idx < count($bank)) {
            $q = $bank[$idx];
            $questions[] = [
                'question' => $q['question'],
                'options' => [
                    $q['option_0'],
                    $q['option_1'],
                    $q['option_2'],
                    $q['option_3'],
                ],
                'answer' => $q['answer'],
                'hint' => $q['hint'],
                'explanation' => $q['explanation'],
            ];
            $idx++;
        }

        return $questions;
    }

    private function syncModulesAndLessons(Course $course, array $modulesData): void
    {
        foreach ($modulesData as $mIndex => $m) {
            $module = Module::updateOrCreate(
                [
                    'course_id' => $course->id,
                    'slug' => $m['slug'],
                ],
                [
                    'title' => $m['title'],
                    'order' => $m['order'] ?? ($mIndex + 1),
                    'key_points' => $m['key_points'] ?? null,
                    'notes' => $m['notes'] ?? null,
                    'is_published' => true,
                ]
            );

            if (! empty($m['lessons'])) {
                foreach ($m['lessons'] as $lIndex => $l) {
                    $formattedQuestions = [];
                    foreach ($l['questions'] as $q) {
                        $formattedQuestions[] = [
                            'question' => $q['q'] ?? $q['question'],
                            'options' => $q['opts'] ?? $q['options'],
                            'answer' => (int) ($q['a'] ?? $q['answer']),
                            'hint' => $q['h'] ?? ($q['hint'] ?? ''),
                            'explanation' => $q['e'] ?? ($q['explanation'] ?? ''),
                        ];
                    }

                    Lesson::updateOrCreate(
                        [
                            'module_id' => $module->id,
                            'slug' => $l['slug'],
                        ],
                        [
                            'title' => $l['title'],
                            'order' => $l['order'] ?? ($lIndex + 1),
                            'type' => 'text',
                            'duration_minutes' => 15,
                            'content' => null,
                            'quiz_questions' => $formattedQuestions,
                            'is_published' => true,
                        ]
                    );
                }
            }
        }
    }
}
