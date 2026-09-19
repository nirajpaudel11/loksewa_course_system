<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Database\Seeders\Helpers\NeaQuizBank;
use Database\Seeders\Helpers\PdfGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NeaLevel4CourseSeeder extends Seeder
{
    private string $pdfBasePath;

    public function run(): void
    {
        $this->pdfBasePath = public_path('storage/notes/loksewa');
        if (! file_exists($this->pdfBasePath)) {
            mkdir($this->pdfBasePath, 0755, true);
        }

        $this->command->info('⚡ Seeding NEA Level 4 (Administration & Accounting) Course...');

        $course = $this->createNeaCourse();
        NeaQuizBank::attachQuestionsToAllLessons($course);
        $this->generateNeaPdfNotes();

        $modulesCount = $course->modules()->count();
        $chaptersCount = Chapter::whereIn('module_id', $course->modules()->pluck('id'))->count();
        $lessonsCount = Lesson::whereIn('module_id', $course->modules()->pluck('id'))->count();

        $this->command->info("   ✅ Created NEA Level 4 Course with {$modulesCount} modules, {$chaptersCount} chapters, {$lessonsCount} lessons (10 MCQs per lesson).");
    }

    public function createNeaCourse(): Course
    {
        // Delete redundant duplicate if present
        $dup = Course::where('slug', 'nea-level-4-administration-accounting')->first();
        if ($dup) {
            foreach ($dup->modules as $mod) {
                foreach ($mod->chapters as $chap) {
                    $chap->lessons()->delete();
                }
                $mod->chapters()->delete();
                $mod->lessons()->delete();
            }
            $dup->modules()->delete();
            $dup->delete();
        }

        // Check if nea-level-4 already exists
        $existing = Course::where('slug', 'nea-level-4')->first();
        $thumbnail = $existing?->thumbnail ?? 'course-thumbnails/01M1HF09AQXHBQ6XGJQDRS2TE6.jpg';
        $syllabusPdf = $existing?->syllabus_pdf ?? null;

        if ($existing) {
            // Clean up existing modules and lessons to re-seed with fresh structure and MCQs
            foreach ($existing->modules as $mod) {
                foreach ($mod->chapters as $chap) {
                    $chap->lessons()->delete();
                }
                $mod->chapters()->delete();
                $mod->lessons()->delete();
            }
            $existing->modules()->delete();
            $course = $existing;
            $course->update([
                'title' => 'Nepal Electricity Authority (NEA) - Level 4 Administration & Accounting',
                'description' => 'Complete preparation course for Nepal Electricity Authority (NEA) Level-4 Administration & Accounting Internal and Open Competitive Examination. Comprehensive curriculum in English covering Paper I (General Knowledge, Constitution of Nepal, General Mathematics & Computer) and Paper II (Accounting, Financial Reporting, Costing, Auditing, NEA Act 2041, Employee Bylaws, Financial Rules, Electricity Theft Control, Tax, and Corruption Prevention).',
                'level' => 'intermediate',
                'thumbnail' => $thumbnail,
                'is_published' => true,
            ]);
        } else {
            $course = Course::create([
                'title' => 'Nepal Electricity Authority (NEA) - Level 4 Administration & Accounting',
                'slug' => 'nea-level-4',
                'description' => 'Complete preparation course for Nepal Electricity Authority (NEA) Level-4 Administration & Accounting Internal and Open Competitive Examination. Comprehensive curriculum in English covering Paper I (General Knowledge, Constitution of Nepal, General Mathematics & Computer) and Paper II (Accounting, Financial Reporting, Costing, Auditing, NEA Act 2041, Employee Bylaws, Financial Rules, Electricity Theft Control, Tax, and Corruption Prevention).',
                'level' => 'intermediate',
                'thumbnail' => $thumbnail,
                'syllabus_pdf' => $syllabusPdf,
                'is_published' => true,
            ]);
        }

        $modules = $this->getModulesData();

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
                        'module_id' => $module->id,
                        'chapter_id' => $chapter->id,
                        'title' => $lessonData['title'],
                        'slug' => Str::slug($lessonData['title']).'-'.$chapter->id,
                        'type' => $lessonData['type'],
                        'content' => $lessonData['content'] ?? null,
                        'attachment_path' => $lessonData['attachment_path'] ?? null,
                        'video_url' => $lessonData['video_url'] ?? null,
                        'order' => $lIdx + 1,
                        'duration_minutes' => $lessonData['duration_minutes'] ?? 20,
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
            // MODULE 1: GENERAL KNOWLEDGE (PAPER I - 50 MARKS)
            // =========================================================================
            [
                'title' => 'General Knowledge (Paper I - 50 Marks)',
                'description' => 'Comprehensive General Knowledge covering Nepal Geography, Climate, Natural Resources, Socio-Cultural Affairs, Periodic Planning, Economic Pillars, Hydropower & Energy, Environment & Climate Change, Current Affairs, Federalism, and Inclusive Governance.',
                'chapters' => [
                    [
                        'title' => '1. Geography, Climate & Natural Resources of Nepal',
                        'description' => 'Physical topography, altitudinal ecological zones, river systems, climate classifications, and natural wealth of Nepal.',
                        'lessons' => [
                            [
                                'title' => '1.1 Topographical Structure and Physical Features of Nepal',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Geographical Overview of Nepal</h3>
<p>Nepal is a landlocked sovereign state in South Asia, located along the southern slopes of the Himalayan mountain ranges between latitudes 26°22\' N to 30°27\' N and longitudes 80°04\' E to 88°12\' E. Total land area is <strong>147,516 sq. km</strong> (incorporating the updated political map including Limpiyadhura, Lipulekh, and Kalapani).</p>

<h3>2. Ecological and Topographical Divisions</h3>
<p>Nepal is divided into three distinct physiographic/ecological regions from north to south:</p>
<ul>
    <li><strong>Himalayan Region (Parbat / Himal):</strong>
        <ul>
            <li>Covers approximately <strong>15%</strong> of the total land surface, with altitudes ranging from 3,000m to 8,848.86m above sea level.</li>
            <li>Home to 8 of the world\'s 14 peaks above 8,000 meters, including Mount Everest (Sagarmatha - 8,848.86m), Kanchenjunga (8,586m), Lhotse (8,516m), Makalu (8,485m), Cho Oyu (8,188m), Dhaulagiri (8,167m), Manaslu (8,163m), and Annapurna I (8,091m).</li>
            <li>Characterized by permanent glaciers, moraines, high-altitude alpine meadows, and permafrost.</li>
        </ul>
    </li>
    <li><strong>Hilly Region (Pahad):</strong>
        <ul>
            <li>Covers approximately <strong>68%</strong> of total land area, with altitudes between 600m and 3,000m.</li>
            <li>Composed of two primary mountain systems: <em>Mahabharat Range</em> (Lesser Himalayas) and <em>Siwalik / Chure Range</em> (Sub-Himalayas).</li>
            <li>Contains fertile inter-montane tectonic valleys (e.g., Kathmandu Valley, Pokhara Valley, Dang Valley).</li>
        </ul>
    </li>
    <li><strong>Terai Region (Madhesh & Inner Terai):</strong>
        <ul>
            <li>Covers approximately <strong>17%</strong> of total area, extending along the southern frontier with altitudes between 60m (Mukhyapatti Musharniya, Dhanusha) and 600m.</li>
            <li>Rich in alluvial soil; known as the "Granary of Nepal" (Annapurna of Nepal) due to high agricultural productivity.</li>
        </ul>
    </li>
</ul>

<h3>3. Major River Basins (Drainage Systems)</h3>
<ol>
    <li><strong>Koshi River System (Eastern Nepal):</strong> Largest river system by water discharge volume. Comprises 7 tributaries (Sunkoshi, Tamakoshi, Dudhkoshi, Indrawati, Bhotekoshi, Arun, Tamor). Originates in Tibet and Eastern Himalayas.</li>
    <li><strong>Gandaki River System (Central Nepal):</strong> Known as Saptagandaki. Includes Trishuli, Budhigandaki, Marsyangdi, Seti Gandaki, Madi, Kaligandaki, and Daraudi. Kaligandaki forms the world\'s deepest gorge (Dana Gorge) between Annapurna and Dhaulagiri.</li>
    <li><strong>Karnali River System (Western Nepal):</strong> Longest river within Nepal (~507 km). Formed by Humla Karnali, Mugu Karnali, Tila, Bheri, and Seti rivers. Originates near Lake Mansarovar.</li>
    <li><strong>Mahakali River System (Far-Western Border):</strong> Forms the western boundary between Nepal and India.</li>
</ol>',
                            ],
                            [
                                'title' => '1.2 Climate of Nepal: Types, Characteristics and Weather Dynamics',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. Factors Influencing Climate in Nepal</h3>
<p>Nepal experiences extraordinary climatic diversity within a narrow north-south span of ~193 km due to sharp altitudinal gradients, topography, and the South Asian summer monsoon.</p>

<h3>2. Five Altitudinal Climatic Zones</h3>
<table border="1" cellpadding="8" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="background-color: #f1f5f9;">
            <th>Climatic Zone</th>
            <th>Altitude Range</th>
            <th>Average Summer Temp</th>
            <th>Characteristics</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Subtropical / Tropical</strong></td>
            <td>Below 1,200m (Terai, Chure, Valleys)</td>
            <td>30°C - 42°C</td>
            <td>Hot, humid summers; mild winters; high monsoon rainfall.</td>
        </tr>
        <tr>
            <td><strong>Warm Temperate</strong></td>
            <td>1,200m - 2,100m (Mid-Hills)</td>
            <td>20°C - 30°C</td>
            <td>Pleasant climate, moderate rainfall; Kathmandu & Pokhara valleys.</td>
        </tr>
        <tr>
            <td><strong>Cool Temperate</strong></td>
            <td>2,100m - 3,300m (High-Hills)</td>
            <td>15°C - 20°C</td>
            <td>Chilly winters with frost and occasional light snow; coniferous forests.</td>
        </tr>
        <tr>
            <td><strong>Alpine</strong></td>
            <td>3,300m - 5,000m (Lower Himalayas)</td>
            <td>10°C - 15°C</td>
            <td>Cold alpine meadows; short growing season; heavy snowfall.</td>
        </tr>
        <tr>
            <td><strong>Tundra / Arctic</strong></td>
            <td>Above 5,000m (Snowline)</td>
            <td>Below 0°C</td>
            <td>Perpetual frost, polar ice caps, rock desert, no vegetation.</td>
        </tr>
    </tbody>
</table>

<h3>3. Monsoon System in Nepal</h3>
<ul>
    <li><strong>Summer Monsoon (South-East):</strong> Enters from Bay of Bengal in early June and lasts until late September. Brings <strong>80% of total annual precipitation</strong>. Rainfall decreases from east to west and south to north.</li>
    <li><strong>Winter Monsoon (Western Disturbance):</strong> Enters from the Mediterranean Sea in December-February. Brings snow to high mountains and light winter showers essential for winter crops (wheat, mustard).</li>
    <li><strong>Rain Shadow Areas:</strong> Trans-Himalayan districts like Mustang and Manang receive very little rainfall (< 300 mm/year) due to the obstruction of the Annapurna and Dhaulagiri ranges.</li>
</ul>',
                            ],
                            [
                                'title' => '1.3 Major Natural Resources and Conservation in Nepal',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. Water Resources</h3>
<p>Nepal possesses over 6,000 rivers, rivulets, and streams with an estimated total run-off volume of 225 billion cubic meters annually. Nepal accounts for approximately 2.27% of global freshwater resources.</p>

<h3>2. Forest Resources</h3>
<p>According to recent Forest Resource Assessments, forests and other wooded land cover approximately <strong>45.31%</strong> of Nepal\'s total land area.</p>
<ul>
    <li><strong>Terai & Siwalik Forests:</strong> Sal (<em>Shorea robusta</em>), Sissoo, Khair, Saj, Semal.</li>
    <li><strong>Mid-Hills Forests:</strong> Pine (Chir pine, Blue pine), Chilaune, Katus, Rhododendron (Lali Gurans - National Flower).</li>
    <li><strong>High Mountain Forests:</strong> Fir, Spruce, Birch (Bhojpatra), Juniper, Himalayan Yew (Lothsalla - source of Taxol).</li>
</ul>

<h3>3. Protected Areas & Biodiversity</h3>
<ul>
    <li><strong>National Parks (12):</strong> Chitwan National Park (First NP, 1973; UNESCO World Heritage Site), Sagarmatha NP (UNESCO Site), Bardiya NP, Langtang NP, Rara NP, Shey-Phoksundo NP (Largest NP - 3,555 sq. km), Makalu Barun NP, Shivapuri Nagarjun NP, Banke NP, Khaptad NP, Shuklaphanta NP, Parsa NP.</li>
    <li><strong>Wildlife Reserves (1):</strong> Koshi Tappu Wildlife Reserve (Ramsar Wetland Site, home to wild water buffalo / Arna).</li>
    <li><strong>Conservation Areas (6):</strong> Annapurna Conservation Area (Largest - 7,629 sq. km), Kanchenjunga CA, Manaslu CA, Gaurishankar CA, Api Nampa CA, Blackbuck (Krishnasar) CA.</li>
    <li><strong>Hunting Reserve (1):</strong> Dhorpatan Hunting Reserve (Famous for Blue Sheep / Naur).</li>
</ul>

<h3>4. Mineral Resources</h3>
<p>Limestone (Chun Dhunga - essential for cement production in Udayapur, Hetauda, Chobhar), Iron ore (Phulchoki, Those), Copper, Zinc, Lead, Mica, Magnesite (Kharidhunga), Semi-precious gemstones (Tourmaline, Ruby, Aquamarine in Ganesh Himal and Sankhuwasabha), and natural gas in Kathmandu Valley.</p>',
                            ],
                        ],
                    ],
                    [
                        'title' => '2. Socio-Economic Development & Periodic Planning',
                        'description' => 'Social systems, cultural heritage, national periodic planning, and drivers of economic development.',
                        'lessons' => [
                            [
                                'title' => '1.4 Socio-Cultural Environment and Heritage of Nepal',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. Demography and Diversity (Census 2078 / 2021)</h3>
<ul>
    <li><strong>Total Population:</strong> 29,164,578 (Female: 51.02%, Male: 48.98%). Annual growth rate: 0.92%.</li>
    <li><strong>Sex Ratio:</strong> 95.59 males per 100 females. Population density: 198 persons/sq. km.</li>
    <li><strong>Castes and Ethnic Groups:</strong> 142 distinct ethnic and caste groups recorded. Major groups: Chhetri (16.45%), Brahman-Hill (11.29%), Magar (6.9%), Tharu (6.2%), Tamang (5.62%), Newar (4.6%).</li>
    <li><strong>Mother Tongues:</strong> 124 languages spoken. Nepali is the official working language spoken by 44.86% as mother tongue, followed by Maithili (11.05%), Bhojpuri (6.24%), Tharu (5.88%), Tamang (4.88%), and Newari (2.96%).</li>
    <li><strong>Religious Harmony:</strong> Hinduism (81.19%), Buddhism (8.21%), Islam (5.09%), Kirat (3.17%), Christianity (1.76%), and Prakriti/others.</li>
</ul>

<h3>2. Cultural and Religious Heritage</h3>
<ul>
    <li><strong>UNESCO Cultural World Heritage Sites:</strong> Kathmandu Valley (7 monument zones: Pashupatinath, Swayambhunath, Boudhanath, Changunarayan, Kathmandu Durbar Square, Patan Durbar Square, Bhaktapur Durbar Square) and Lumbini (Birthplace of Lord Buddha).</li>
    <li><strong>Major Festivals:</strong> Dashain (Bijaya Dashami), Tihar (Deepawali/Chhath), Lhosar (Tamu, Sonam, Gyalpo), Eid, Maghi, Ubhauli/Udhauli, Buddha Jayanti, Teej, Holi, Gaijatra, Bisket Jatra.</li>
    <li><strong>Constitutional Guarantee:</strong> Secularism (Dharma Nirapekshata), freedom to practice religion, conservation of sanatan dharma and religious harmony (Article 4 & 26).</li>
</ul>',
                            ],
                            [
                                'title' => '1.5 Current Periodic Plan of Nepal: Objectives, Targets & Strategies',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Historical Background of Planning in Nepal</h3>
<p>Periodic economic planning in Nepal commenced in <strong>2013 BS (1956 AD)</strong> with the First Five-Year Plan under Prime Minister Tanka Prasad Acharya. The National Planning Commission (NPC) is the apex advisory body for formulating development plans and policies.</p>

<h3>2. The 16th Periodic Plan (FY 2081/82 - 2085/86 / 2024-2029)</h3>
<p>The 16th Plan is centered around the overarching theme: <strong>"Good Governance, Social Justice, and Prosperity" (सुशासन, सामाजिक न्याय र समृद्धि)</strong>.</p>

<h4>Key Objectives:</h4>
<ol>
    <li>Establish structural transformation across production, employment, and public service delivery.</li>
    <li>Achieve high, sustainable, and inclusive economic growth through modernization of agriculture, clean industrial development, and energy expansion.</li>
    <li>Ensure social justice through poverty alleviation, universal social protection, and reduction of economic inequality.</li>
    <li>Smooth transition and sustainable graduation from the Least Developed Country (LDC) category by 2026.</li>
</ol>

<h4>Strategic Pillars & Targets:</h4>
<ul>
    <li><strong>Economic Growth Target:</strong> Targeted annual average GDP growth rate of 7.0% - 7.5%.</li>
    <li><strong>Poverty Reduction:</strong> Reducing absolute poverty below 12% by the end of the plan period.</li>
    <li><strong>Hydropower & Energy Target:</strong> Increasing total electricity installed capacity beyond 5,000 MW, targeting 100% universal electricity access, and expanding cross-border power transmission lines.</li>
    <li><strong>Human Development:</strong> Raising Human Development Index (HDI) above 0.65.</li>
</ul>',
                            ],
                            [
                                'title' => '1.6 Major Drivers of Economic Development in Nepal',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>Key Economic Pillars of Nepal</h3>

<h4>1. Agriculture Sector</h4>
<p>Contributes approximately 24% to GDP and employs over 60% of the workforce. Focus areas include commercialization, irrigation expansion, mechanization, high-value cash crops (tea, cardamom, ginger, coffee), and agro-processing industries.</p>

<h4>2. Industry and Manufacturing</h4>
<p>Contribution to GDP is around 13-14%. Promoted through Special Economic Zones (SEZ in Bhairahawa, Simara), small and medium enterprises (SMEs), export-oriented manufacturing, and cement/steel production.</p>

<h4>3. Tourism Sector</h4>
<p>Major source of foreign exchange and employment. Key products: Trekking, mountaineering (Mountaineering tourism), eco-tourism, cultural pilgrimage (Lumbini, Pashupatinath, Muktinath, Janakpur), adventure sports (rafting, paragliding, bungee jumping).</p>

<h4>4. Human Resources & Foreign Employment</h4>
<p>Remittances account for over 22-25% of national GDP. Shift towards developing skilled technical human resources, vocational training (CTEVT), and domestic employment creation (Prime Minister Employment Program).</p>

<h4>5. Electricity and Energy</h4>
<p>The backbone of industrial transformation. Clean hydropower generation displaces fossil fuels, reduces trade deficits with India, powers electric transportation, and generates export revenues.</p>

<h4>6. Health & Education</h4>
<p>Essential social infrastructure. Expansion of universal basic health coverage, health insurance schemes, technical education, and digital literacy.</p>',
                            ],
                        ],
                    ],
                    [
                        'title' => '3. Energy Resources, Hydropower & NEA Overview',
                        'description' => 'Water, solar, and wind energy potential, hydropower development, NEA mandate, and private sector IPPs.',
                        'lessons' => [
                            [
                                'title' => '1.7 Water Resources, Solar Energy and Wind Energy in Nepal',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Water Resources & Hydro Potential</h3>
<ul>
    <li><strong>Theoretical Potential:</strong> Estimated at <strong>83,000 MW</strong> based on Dr. Hari Man Shrestha\'s 1966 research.</li>
    <li><strong>Technically & Economically Feasible:</strong> Approximately <strong>42,000 MW to 45,000 MW</strong>.</li>
    <li><strong>Run-of-River (RoR) vs Storage (Reservoir) Projects:</strong> Most existing plants are RoR (high generation in monsoon, reduced output in dry winter). Nepal is prioritizing Peaking RoR (PROR) like Upper Tamakoshi (456 MW), Trishuli 3A, and Storage Projects like Kulekhani (60+32+14=106 MW), Budhigandaki (1,200 MW), Dudhkoshi (635 MW), Tanahu (140 MW), and Upper Arun (1,061 MW) for grid stability.</li>
</ul>

<h3>2. Solar Energy Potential</h3>
<ul>
    <li>Nepal receives an average of <strong>300 sunny days per year</strong> with solar radiation averaging 4.5 to 5.5 kWh/m²/day.</li>
    <li>Commercial grid-connected solar plants: Nuwakot Solar Project (25 MW - NEA), Mithila Solar (10 MW), Butwal Solar (8.5 MW).</li>
    <li>Decentralized solar home systems (SHS) installed widely in off-grid rural areas via Alternative Energy Promotion Centre (AEPC).</li>
</ul>

<h3>3. Wind and Biomass Energy</h3>
<ul>
    <li>Wind energy potential estimated at over 3,000 MW in mountainous wind corridors (Mustang, Kagbeni, Ramechhap, Pyuthan).</li>
    <li>Biomass and biogas provide clean cooking alternatives in rural households, reducing fuelwood consumption.</li>
</ul>',
                            ],
                            [
                                'title' => '1.8 Hydropower Development: Role of NEA and Private Sector',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Nepal Electricity Authority (NEA - नेपाल विद्युत प्राधिकरण)</h3>
<p>Established on <strong>Bhadra 1, 2042 BS (August 16, 1985)</strong> under the <em>Nepal Electricity Authority Act, 2041</em> by merging the Department of Electricity, Electricity Corporation, and related development boards.</p>
<h4>Primary Mandates of NEA:</h4>
<ol>
    <li>Generation, transmission, and distribution of electricity throughout Nepal in a reliable, safe, and cost-effective manner.</li>
    <li>Managing the integrated National Power System (INPS) and system operation load dispatch center (LDC).</li>
    <li>Constructing and operating high-voltage transmission backbones (132 kV, 220 kV, 400 kV lines such as Dhalkebar-Muzaffarpur 400 kV cross-border line).</li>
    <li>Entering into Power Purchase Agreements (PPA) with Independent Power Producers (IPPs).</li>
    <li>Rural electrification and smart grid modernization (smart meters, automated sub-stations, underground cabling).</li>
    <li>Cross-border electricity trade with India and Bangladesh via Day-Ahead, Real-Time, and bilateral power markets.</li>
</ol>

<h3>2. Role of the Private Sector (IPPs)</h3>
<ul>
    <li>Private sector power producers contribute over <strong>60%</strong> of Nepal\'s total grid-connected electricity generation capacity.</li>
    <li>IPPAN (Independent Power Producers\' Association, Nepal) represents private developers.</li>
    <li>Build-Own-Operate-Transfer (BOOT) model: Projects are granted generation licenses for 30-35 years, after which ownership reverts to the Government of Nepal in operational condition.</li>
</ul>',
                            ],
                        ],
                    ],
                    [
                        'title' => '4. Environment, Climate Change & Sustainable Development',
                        'description' => 'SDGs, demographic trends, environmental protection measures, pollution control, and climate change management in Nepal.',
                        'lessons' => [
                            [
                                'title' => '1.9 Sustainable Development, Population and Climate Change',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. Sustainable Development Goals (SDGs 2016-2030)</h3>
<p>Adopted by the UN in 2015 comprising 17 Global Goals and 169 targets. Nepal has integrated SDGs into its national periodic plans:</p>
<ul>
    <li><strong>Goal 7 (Affordable and Clean Energy):</strong> Universal access to reliable electricity, expanding renewable energy share.</li>
    <li><strong>Goal 13 (Climate Action):</strong> Integrating climate change measures into national policies and planning.</li>
    <li><strong>Goal 1 (No Poverty), Goal 5 (Gender Equality), Goal 8 (Decent Work & Economic Growth).</strong></li>
</ul>

<h3>2. Climate Vulnerability of Nepal</h3>
<p>Despite contributing less than 0.03% of global greenhouse gas emissions, Nepal is ranked among the most climate-vulnerable countries due to fragile Himalayan topography.</p>
<h4>Key Climate Impacts:</h4>
<ul>
    <li>Accelerated melting of Himalayan glaciers and formation of dangerous glacial lakes (GLOF - Glacial Lake Outburst Floods risk e.g., Tsho Rolpa, Imja).</li>
    <li>Erratic precipitation, flash floods, landslides in hills, and droughts in winter.</li>
    <li>Fluctuations in river discharge impacting seasonal hydropower generation.</li>
</ul>',
                            ],
                            [
                                'title' => '1.10 Environmental Pollution Control and Climate Management in Nepal',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. Legal and Institutional Frameworks</h3>
<ul>
    <li><strong>Environment Protection Act, 2076 (2019) & Rules, 2077:</strong> Mandates Environmental Impact Assessment (EIA), Initial Environmental Examination (IEE), and Environmental Management Plan (EMP) for development projects.</li>
    <li><strong>National Climate Change Policy, 2076:</strong> Framework for climate adaptation, carbon financing, low-carbon development, and disaster resilience.</li>
    <li><strong>Nationally Determined Contributions (Second NDC - 2020):</strong>
        <ul>
            <li>Net-zero greenhouse gas emissions target by <strong>2045</strong>.</li>
            <li>Target to generate 15,000 MW of clean energy by 2030 (including 5-10% mini/micro-hydro, solar, wind, and bio-energy).</li>
            <li>Promoting electric vehicles (EVs) to account for 90% of all private passenger vehicle sales by 2030.</li>
            <li>Maintaining 45% of total land area under forest cover.</li>
        </ul>
    </li>
</ul>

<h3>2. NEA\'s Environmental Commitments</h3>
<ul>
    <li>Installation of EV charging stations across national highway networks.</li>
    <li>Strict adherence to environmental flow (minimum 10% downstream environmental release) in river diversions.</li>
    <li>Reforestation (compensatory plantation at 1:10 or 1:25 ratio for trees felled during transmission line construction).</li>
</ul>',
                            ],
                        ],
                    ],
                    [
                        'title' => '5. National Affairs, Federalism & Democratic Governance',
                        'description' => 'Current events, federal governance architecture, democracy, social inclusion, and GK assessment.',
                        'lessons' => [
                            [
                                'title' => '1.11 Current Affairs of National Importance, Sports, Arts & Literature',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. High-Yield Current Affairs Topics for Exam</h3>
<ul>
    <li><strong>Energy & Infrastructure Milestones:</strong> Operationalization of Pokhara International Airport, Gautam Buddha International Airport (Bhairahawa), transmission line interconnections (Dhalkebar-Muzaffarpur, Butwal-Gorakhpur 400 kV), export of electricity to India (up to 700+ MW approved) and tripartite agreement with Bangladesh for 40 MW power export.</li>
    <li><strong>Prestigious National Honors & Awards:</strong>
        <ul>
            <li><em>Madan Puraskar & Jagadamba Shree:</em> Premier literary honors of Nepal.</li>
            <li><em>Rastriya Pratibha Puraskar:</em> National talent awards across science, art, literature, and social contribution.</li>
            <li><em>Janasewa Shree & Nepal Ratna:</em> Highest civilian state decorations.</li>
        </ul>
    </li>
    <li><strong>Sports Milestones:</strong> Nepal Cricket Team participation in ICC Men\'s T20 World Cup, National Games (Rastriya Khelkud), South Asian Games (SAG) medal tallies, martial arts achievements.</li>
    <li><strong>Evolving Economic Indicators:</strong> Annual budget size, inflation rate, foreign exchange reserves (covering 12+ months of imports), and remittance inflows.</li>
</ul>',
                            ],
                            [
                                'title' => '1.12 Federalism in Nepal: Concept, Meaning and Importance',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. Concept and Rationale of Federalism</h3>
<p>Federalism is a system of governance where constitutional sovereignty and governing authority are divided between a central national government and sub-national constituent units (provinces and local governments).</p>

<h3>2. Evolution of Federalism in Nepal</h3>
<p>Formally institutionalized by the <strong>Constitution of Nepal 2072 (promulgated on Ashwin 3, 2072 / Sept 20, 2015)</strong>, transforming Nepal from a unitary monarchical state into a Federal Democratic Republic (संघीय लोकतान्त्रिक गणतन्त्र नेपाल).</p>

<h3>3. Three Tiers of Government</h3>
<ol>
    <li><strong>Federal Government (संघीय सरकार):</strong> Apex authority handling national defense, foreign affairs, monetary policy, central banking, national highways, mega transmission grids, and inter-provincial matters.</li>
    <li><strong>7 Provincial Governments (प्रदेश सरकार):</strong> Koshi, Madhesh, Bagmati, Gandaki, Lumbini, Karnali, and Sudurpashchim. Handle provincial policing, health services, provincial roads, electricity projects up to specified thresholds.</li>
    <li><strong>753 Local Governments (स्थानीय तह):</strong>
        <ul>
            <li>6 Metropolitan Cities (Mahanagarpalika)</li>
            <li>11 Sub-Metropolitan Cities (Upa-Mahanagarpalika)</li>
            <li>276 Municipalities (Nagarpalika)</li>
            <li>460 Rural Municipalities (Gaunpalika)</li>
            <li>Total 6,743 Wards</li>
        </ul>
    </li>
</ol>

<h3>4. Principles of Inter-governmental Relations (Article 232)</h3>
<p>The relations among the Federation, Provinces, and Local levels are based on the principles of <strong>Cooperation, Co-existence, and Coordination (सहकारिता, सहअस्तित्व र समन्वय)</strong>.</p>',
                            ],
                            [
                                'title' => '1.13 Democracy, Inclusion and Social Justice',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. Principles of Democratic Governance</h3>
<p>Constitutional supremacy, rule of law, periodic competitive elections, multi-party system, independent judiciary, separation of powers, checks and balances, and citizen fundamental freedoms.</p>

<h3>2. Social Inclusion (समावेशीकरण)</h3>
<p>The process of ensuring that marginalized, underprivileged, and disadvantaged groups participate equitably in political decision-making, civil service, and socio-economic life.</p>
<h4>Key Inclusion Mechanisms in Nepal:</h4>
<ul>
    <li><strong>Proportional Representation (समानुपातिक प्रतिनिधित्व):</strong> Mixed electoral system (FPTP + PR) in federal and provincial parliaments.</li>
    <li><strong>Affirmative Action / Reservations in Public Service:</strong> 45% of open competitive vacancies reserved for:
        <ul>
            <li>Women (33%)</li>
            <li>Adivasi Janajati (27%)</li>
            <li>Madhesi (22%)</li>
            <li>Dalit (9%)</li>
            <li>Tharu (5%)</li>
            <li>Muslim (4%)</li>
            <li>Backward Regions & Persons with Disabilities (additional reservations).</li>
        </ul>
    </li>
    <li><strong>Social Justice (Article 42):</strong> Right of socially backward groups to participate in state organs on the basis of the principle of proportional inclusion.</li>
</ul>',
                            ],
                            [
                                'title' => '1.14 General Knowledge Assessment Quiz',
                                'type' => 'quiz',
                                'duration_minutes' => 15,
                                'content' => json_encode([
                                    [
                                        'question' => 'What is the official total land area of Nepal according to the updated administrative map?',
                                        'options' => ['147,181 sq. km', '147,516 sq. km', '147,984 sq. km', '148,000 sq. km'],
                                        'answer' => 1,
                                        'explanation' => 'The official updated area of Nepal including Limpiyadhura and Lipulekh is 147,516 sq. km.',
                                    ],
                                    [
                                        'question' => 'Which is the largest river basin in Nepal by volume of water discharge?',
                                        'options' => ['Gandaki River System', 'Koshi River System', 'Karnali River System', 'Mahakali River System'],
                                        'answer' => 1,
                                        'explanation' => 'Koshi (Saptakoshi) is the largest river system by water discharge volume.',
                                    ],
                                    [
                                        'question' => 'When was Nepal Electricity Authority (NEA) established?',
                                        'options' => ['2039 BS', '2041 BS', '2042 Bhadra 1', '2046 BS'],
                                        'answer' => 2,
                                        'explanation' => 'NEA was formally established on Bhadra 1, 2042 BS (August 16, 1985) under the NEA Act 2041.',
                                    ],
                                    [
                                        'question' => 'What is the economically feasible hydropower potential of Nepal?',
                                        'options' => ['83,000 MW', '42,000 MW', '25,000 MW', '15,000 MW'],
                                        'answer' => 1,
                                        'explanation' => 'Nepal has an estimated 83,000 MW theoretical and approximately 42,000 MW economically feasible hydropower potential.',
                                    ],
                                    [
                                        'question' => 'According to Article 232 of the Constitution of Nepal, on what principles are relations between Federation, Provinces, and Local levels based?',
                                        'options' => ['Hierarchy and Control', 'Cooperation, Co-existence, and Coordination', 'Centralized Command', 'Complete Independence'],
                                        'answer' => 1,
                                        'explanation' => 'Article 232 states that relations between Federation, Provinces, and Local Levels are based on Cooperation, Co-existence, and Coordination.',
                                    ],
                                ]),
                            ],
                        ],
                    ],
                ],
            ],

            // =========================================================================
            // MODULE 2: CONSTITUTION OF NEPAL (PAPER I - 40 MARKS)
            // =========================================================================
            [
                'title' => 'Constitution of Nepal (Paper I - 40 Marks)',
                'description' => 'Detailed study of the Constitution of Nepal (2072 BS) covering Salient Features, Preliminary (Part-1), Fundamental Rights & Duties (Part-3), Directive Principles & State Policies (Part-4), Constitutional Organs (Parts 21, 22, 23, 24, 26), and Schedules 1-9.',
                'chapters' => [
                    [
                        'title' => '1. Fundamental Features & Preliminary Provisions',
                        'description' => 'Promulgation, core constitutional characteristics, preliminary articles, and citizenship provisions.',
                        'lessons' => [
                            [
                                'title' => '2.1 Fundamental Features of the Constitution of Nepal',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Promulgation and Historical Context</h3>
<p>The present Constitution of Nepal was promulgated by the elected Constituent Assembly on <strong>Ashwin 3, 2072 BS (September 20, 2015 AD)</strong>. It is the <strong>7th written constitution</strong> in Nepal\'s constitutional history (preceded by 2004, 2007, 2015, 2019, 2047, and 2063 Interim constitutions).</p>

<h3>2. Salient Characteristics</h3>
<ul>
    <li><strong>Structure:</strong> Comprises <strong>35 Parts, 308 Articles, and 9 Schedules</strong>.</li>
    <li><strong>Sovereignty & State Power (Article 2):</strong> Inherent in the Nepali people.</li>
    <li><strong>Form of State (Article 4):</strong> Nepal is an independent, indivisible, sovereign, secular, inclusive, democratic, socialism-oriented, federal democratic republican state.</li>
    <li><strong>Secularism Defined:</strong> "Secular" means religious and cultural freedom, along with the protection of religion and culture practiced from ancient times (Sanatan Dharma).</li>
    <li><strong>Form of Government (Article 74):</strong> Multi-party, competitive, federal democratic republican parliamentary system of governance based on pluralism.</li>
    <li><strong>Constitutional Supremacy (Article 1):</strong> This Constitution is the fundamental law of Nepal. Any law inconsistent with this Constitution shall, to the extent of such inconsistency, be void.</li>
    <li><strong>Three Tiers of Federation:</strong> Federation, 7 Provinces, and 753 Local Levels.</li>
    <li><strong>Independent Judiciary:</strong> Three-tier court system (Supreme Court, High Courts in 7 provinces, District Courts in 77 districts). Supreme Court has constitutional bench and power of judicial review (Article 133).</li>
</ul>',
                            ],
                            [
                                'title' => '2.2 Preliminary Provisions (Part-1: Articles 1-9)',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>Analysis of Part 1 (Articles 1 - 9)</h3>
<ol>
    <li><strong>Article 1 (Constitution as the Fundamental Law):</strong> Every person must abide by the constitution. Laws in conflict are invalid.</li>
    <li><strong>Article 2 (Sovereignty and State Authority):</strong> The sovereignty and state authority of Nepal are vested in the Nepali people.</li>
    <li><strong>Article 3 (The Nation):</strong> All Nepali people multi-ethnic, multi-lingual, multi-religious, multi-cultural, having common aspirations and united by a bond of allegiance to national independence, integrity, national interest, and prosperity constitute the nation.</li>
    <li><strong>Article 4 (State of Nepal):</strong> Definition of the Federal Democratic Republican state.</li>
    <li><strong>Article 5 (National Interest):</strong> Safeguarding independence, sovereignty, territorial integrity, nationality, freedom, self-respect, border security, economic prosperity.</li>
    <li><strong>Article 6 (Languages of the Nation):</strong> All mother tongues spoken in Nepal are the languages of the nation.</li>
    <li><strong>Article 7 (Official Language):</strong> The Nepali language in Devanagari script is the official working language of Nepal. Provinces may determine one or more languages spoken by majority as provincial official language.</li>
    <li><strong>Article 8 (National Flag):</strong> Crimson color with blue border, two juxtaposed triangular figures with white crescent moon (upper) and 12-rayed white sun (lower). Specification detailed in Schedule 1.</li>
    <li><strong>Article 9 (National Anthem, Coat-of-Arms, Flower, Color, Animal & Bird):</strong>
        <ul>
            <li>National Anthem: <em>"Sayaun Thunga Phool Ka Hami..."</em> (Schedule 2).</li>
            <li>National Emblem / Coat-of-Arms: Detailed in Schedule 3.</li>
            <li>National Flower: Rhododendron (Lali Gurans).</li>
            <li>National Color: Crimson (Simrik).</li>
            <li>National Animal: Cow (Gai).</li>
            <li>National Bird: Danphe (Lophophorus / Impeyan Pheasant).</li>
        </ul>
    </li>
</ol>',
                            ],
                        ],
                    ],
                    [
                        'title' => '2. Fundamental Rights, Duties & State Policies',
                        'description' => 'Comprehensive breakdown of 31 Fundamental Rights, Citizen Duties, Directive Principles, and State Policies.',
                        'lessons' => [
                            [
                                'title' => '2.3 Fundamental Rights and Duties (Part-3: Articles 16-48)',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. The 31 Fundamental Rights (Articles 16 - 46)</h3>
<p>Part 3 guarantees 31 fundamental rights directly enforceable by the Supreme Court and High Courts under Articles 46, 133, and 144:</p>
<ol start="16">
    <li><strong>Art. 16:</strong> Right to live with dignity.</li>
    <li><strong>Art. 17:</strong> Right to freedom (opinion & expression, peaceful assembly, freedom to form associations, freedom to move & reside, practice any occupation/business).</li>
    <li><strong>Art. 18:</strong> Right to equality (no discrimination on ground of religion, race, caste, sex, origin, language).</li>
    <li><strong>Art. 19:</strong> Right to communication (no censorship of press).</li>
    <li><strong>Art. 20:</strong> Right relating to justice (right to be informed of arrest, consult legal practitioner, fair trial, no double jeopardy).</li>
    <li><strong>Art. 21:</strong> Right of victim of crime.</li>
    <li><strong>Art. 22:</strong> Right against torture.</li>
    <li><strong>Art. 23:</strong> Right against preventive detention.</li>
    <li><strong>Art. 24:</strong> Right against untouchability and discrimination.</li>
    <li><strong>Art. 25:</strong> Right relating to property.</li>
    <li><strong>Art. 26:</strong> Right to freedom of religion.</li>
    <li><strong>Art. 27:</strong> Right to information.</li>
    <li><strong>Art. 28:</strong> Right to privacy.</li>
    <li><strong>Art. 29:</strong> Right against exploitation (prohibition of human trafficking, forced labor).</li>
    <li><strong>Art. 30:</strong> Right to clean environment.</li>
    <li><strong>Art. 31:</strong> Right relating to education (free compulsory basic education, free secondary education).</li>
    <li><strong>Art. 32:</strong> Right to language and culture.</li>
    <li><strong>Art. 33:</strong> Right to employment.</li>
    <li><strong>Art. 34:</strong> Right to labor (proper wages, trade union rights).</li>
    <li><strong>Art. 35:</strong> Right relating to health (free basic healthcare, emergency medical services).</li>
    <li><strong>Art. 36:</strong> Right relating to food (food sovereignty).</li>
    <li><strong>Art. 37:</strong> Right to housing.</li>
    <li><strong>Art. 38:</strong> Rights of women (equal lineage rights, reproductive health, property rights).</li>
    <li><strong>Art. 39:</strong> Rights of the child.</li>
    <li><strong>Art. 40:</strong> Rights of Dalit.</li>
    <li><strong>Art. 41:</strong> Rights of senior citizens.</li>
    <li><strong>Art. 42:</strong> Right to social justice (inclusive representation).</li>
    <li><strong>Art. 43:</strong> Right to social security.</li>
    <li><strong>Art. 44:</strong> Rights of the consumer (quality goods/services, compensation).</li>
    <li><strong>Art. 45:</strong> Right against exile.</li>
    <li><strong>Art. 46:</strong> Right to constitutional remedies (Writ petitions: Habeas Corpus, Mandamus, Prohibition, Quo Warranto, Certiorari).</li>
</ol>

<h3>2. Duties of Citizens (Article 48)</h3>
<ul>
    <li>Safeguard nationality, sovereignty, and integrity of Nepal.</li>
    <li>Abide by the Constitution and laws.</li>
    <li>Render compulsory service to the nation when required.</li>
    <li>Protect and preserve public property.</li>
</ul>',
                            ],
                            [
                                'title' => '2.4 Directive Principles, Policies and Obligations of the State (Part-4)',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Nature of Part 4 (Articles 49 - 55)</h3>
<p>Article 55 explicitly states that no question shall be raised in any court as to whether any provision contained in Part-4 has been implemented or not (non-justiciable in court), but they serve as the fundamental guiding principles for governance, legislation, and annual budgeting.</p>

<h3>2. Directive Principles of the State (Article 50)</h3>
<ul>
    <li><strong>Political Objective:</strong> Establish a just system based on democratic values, rule of law, fundamental rights, and federal democratic governance.</li>
    <li><strong>Socio-Cultural Objective:</strong> Build a civilized and egalitarian society by eliminating all forms of discrimination, inequality, and untouchability.</li>
    <li><strong>Economic Objective:</strong> Develop an independent, self-reliant, and socialism-oriented economy through equitable distribution of national income and public, private, and cooperative participation.</li>
    <li><strong>International Relations:</strong> Safeguard national sovereignty and territorial integrity based on the UN Charter, non-alignment, Panchasheel, and international law.</li>
</ul>

<h3>3. Key State Policies (Article 51)</h3>
<ul>
    <li><strong>Policy on Protection, Promotion & Utilization of Natural Resources [Art. 51(g)]:</strong>
        <ul>
            <li>Protection and sustainable utilization of water resources, forests, wildlife, and minerals.</li>
            <li>Priority to domestic investment in hydropower development, multi-purpose river basin planning, and environmental impact mitigation.</li>
            <li>Ensuring local communities benefit equitably from natural resource utilization (royalty sharing).</li>
        </ul>
    </li>
    <li><strong>Policy on Labor and Employment [Art. 51(i)]:</strong>
        <ul>
            <li>Guaranteeing productive employment for all citizens, social security for laborers, elimination of child labor, and safeguarding rights of migrant workers.</li>
        </ul>
    </li>
</ul>

<h3>4. Obligations of the State (Article 52)</h3>
<p>It is the duty of the state to maintain independence, sovereignty, and territorial integrity, protect fundamental rights and human rights, promote rule of law, and achieve sustainable prosperity.</p>',
                            ],
                        ],
                    ],
                    [
                        'title' => '3. Constitutional Organs & Federal Schedules',
                        'description' => 'Constitutional bodies, anti-corruption, audit oversight, PSC, election commission, human rights, and Schedules 1-9.',
                        'lessons' => [
                            [
                                'title' => '2.5 Functions of Constitutional Organs (Parts 21, 22, 23, 24 & 26)',
                                'type' => 'text',
                                'duration_minutes' => 30,
                                'content' => '<h3>1. Commission for the Investigation of Abuse of Authority - CIAA (Part 21: Arts. 238-239)</h3>
<ul>
    <li><strong>Composition:</strong> Chief Commissioner and 4 Commissioners appointed by the President upon recommendation of the Constitutional Council for a term of <strong>6 years</strong> (retirement age: 65).</li>
    <li><strong>Powers & Functions:</strong> Conduct investigations into improper conduct and corruption committed by any person holding public office. File corruption cases in the Special Court (Vishesh Adalat).</li>
</ul>

<h3>2. Auditor General of Nepal (Part 22: Arts. 240-241)</h3>
<ul>
    <li><strong>Appointment & Tenure:</strong> Auditor General appointed by President for a 6-year term.</li>
    <li><strong>Functions:</strong> Audit the accounts of all Federal and Provincial government offices, Courts, Parliament, Armed Forces, Police, and <strong>Corporate Bodies / Public Enterprises wholly or majority (50%+) owned by Government (including Nepal Electricity Authority)</strong> with due regard to regularity, economy, efficiency, effectiveness, and propriety.</li>
    <li>Submits annual audit report to the President (Federal) and Province Chiefs (Provincial).</li>
</ul>

<h3>3. Public Service Commission - PSC / Lok Sewa Aayog (Part 23: Arts. 242-243)</h3>
<ul>
    <li><strong>Composition:</strong> Chairperson and members appointed for 6 years.</li>
    <li><strong>Functions:</strong> Conduct examinations for selection of suitable candidates to civil service posts and <strong>Public Enterprises / Organized Entities (including NEA)</strong>. Consulted on promotions, transfers, and departmental actions.</li>
</ul>

<h3>4. Election Commission of Nepal (Part 24: Arts. 245-247)</h3>
<ul>
    <li>Conducts, supervises, directs, and controls elections for President, Vice-President, Federal Parliament, Provincial Assemblies, and Local Levels, as well as Referendums. Maintains voter registers.</li>
</ul>

<h3>5. National Human Rights Commission - NHRC (Part 26: Arts. 248-249)</h3>
<ul>
    <li>Ensures respect, protection, and promotion of human rights. Investigates human rights violations and recommends compensation and legal prosecution.</li>
</ul>',
                            ],
                            [
                                'title' => '2.6 Schedules of the Constitution (Schedules 1 to 9)',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>Complete Breakdown of the 9 Constitutional Schedules</h3>
<table border="1" cellpadding="8" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="background-color: #f1f5f9;">
            <th>Schedule</th>
            <th>Title & Constitutional Subject Matter</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Schedule 1</strong></td>
            <td>National Flag of Nepal (Method of making flag, geometric proportions, colors).</td>
        </tr>
        <tr>
            <td><strong>Schedule 2</strong></td>
            <td>National Anthem of Nepal (<em>"Sayaun Thunga Phool Ka..."</em>).</td>
        </tr>
        <tr>
            <td><strong>Schedule 3</strong></td>
            <td>Coat-of-Arms / National Emblem of Nepal.</td>
        </tr>
        <tr>
            <td><strong>Schedule 4</strong></td>
            <td>Provinces and Districts included in each of the 7 Provinces.</td>
        </tr>
        <tr>
            <td><strong>Schedule 5</strong></td>
            <td><strong>List of Federal Powers (35 exclusive subjects):</strong> Defense, Foreign affairs, Currency & Banking, National Highways, Central Mega Power Projects & Mega Transmission Grids, Customs.</td>
        </tr>
        <tr>
            <td><strong>Schedule 6</strong></td>
            <td><strong>List of Provincial Powers (21 exclusive subjects):</strong> Provincial police, Provincial health, Provincial roads, Provincial electricity projects.</td>
        </tr>
        <tr>
            <td><strong>Schedule 7</strong></td>
            <td><strong>List of Concurrent Powers of Federation and Province (25 subjects):</strong> Civil & criminal law, Electricity & irrigation regulation, Supply of essential goods, Higher education.</td>
        </tr>
        <tr>
            <td><strong>Schedule 8</strong></td>
            <td><strong>List of Local Level Powers (22 exclusive subjects):</strong> Municipal police, Local tax collection, Basic & secondary education, Basic healthcare, Local roads, Micro-hydro projects.</td>
        </tr>
        <tr>
            <td><strong>Schedule 9</strong></td>
            <td><strong>List of Concurrent Powers of Federation, Province, and Local Level (15 subjects):</strong> Cooperatives, Education, Health, Agriculture, Electricity/water services, Disaster management.</td>
        </tr>
    </tbody>
</table>',
                            ],
                            [
                                'title' => '2.7 Constitution of Nepal Assessment Quiz',
                                'type' => 'quiz',
                                'duration_minutes' => 15,
                                'content' => json_encode([
                                    [
                                        'question' => 'How many Parts, Articles, and Schedules are in the Constitution of Nepal?',
                                        'options' => ['30 Parts, 250 Articles, 7 Schedules', '35 Parts, 308 Articles, 9 Schedules', '32 Parts, 300 Articles, 8 Schedules', '37 Parts, 315 Articles, 9 Schedules'],
                                        'answer' => 1,
                                        'explanation' => 'The Constitution of Nepal 2072 has 35 Parts, 308 Articles, and 9 Schedules.',
                                    ],
                                    [
                                        'question' => 'Which part of the Constitution deals with Fundamental Rights and Duties?',
                                        'options' => ['Part 2', 'Part 3', 'Part 4', 'Part 5'],
                                        'answer' => 1,
                                        'explanation' => 'Part 3 contains Articles 16 to 48 covering 31 Fundamental Rights and Citizen Duties.',
                                    ],
                                    [
                                        'question' => 'Under which Article is the Auditor General mandated to audit Public Enterprises like NEA?',
                                        'options' => ['Article 239', 'Article 241', 'Article 243', 'Article 248'],
                                        'answer' => 1,
                                        'explanation' => 'Article 241 specifies the audit of all government offices and 50%+ government owned corporate bodies by the Auditor General.',
                                    ],
                                    [
                                        'question' => 'Which Schedule contains the exclusive power list of the Federal Government?',
                                        'options' => ['Schedule 4', 'Schedule 5', 'Schedule 6', 'Schedule 7'],
                                        'answer' => 1,
                                        'explanation' => 'Schedule 5 lists 35 exclusive subjects under Federal jurisdiction.',
                                    ],
                                    [
                                        'question' => 'What is the standard tenure of the Chief Commissioner of CIAA?',
                                        'options' => ['4 years', '5 years', '6 years', '7 years'],
                                        'answer' => 2,
                                        'explanation' => 'The tenure of the Chief Commissioner and Commissioners of CIAA is 6 years from the date of appointment.',
                                    ],
                                ]),
                            ],
                        ],
                    ],
                ],
            ],

            // =========================================================================
            // MODULE 3: GENERAL MATHEMATICS & COMPUTER FUNDAMENTALS (PAPER I - 10 MARKS)
            // =========================================================================
            [
                'title' => 'General Mathematics & Computer Fundamentals (Paper I - 10 Marks)',
                'description' => 'Elementary mathematics, numerical problem solving (Unitary method, Percentage, Fraction, Average, Profit & Loss, Interest & Discount) and Computer literacy (Word, Excel, PowerPoint, Email & Internet).',
                'chapters' => [
                    [
                        'title' => '1. Numerical Ability & Business Mathematics',
                        'description' => 'Unitary method, percentages, fractions, averages, profit & loss, discount, and simple interest calculations.',
                        'lessons' => [
                            [
                                'title' => '3.1 Unitary Method and Proportion',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. Concept of Unitary Method</h3>
<p>The unitary method is a technique for solving problems by first finding the value of a single unit (1 item/day/person), and then finding the necessary value by multiplying the single unit value.</p>

<h3>2. Direct vs Inverse Variation</h3>
<ul>
    <li><strong>Direct Proportion:</strong> As one quantity increases, the other increases in the same ratio (e.g., number of electricity units consumed vs total electricity bill amount). Formula: <code>y = kx</code>.</li>
    <li><strong>Inverse / Indirect Proportion:</strong> As one quantity increases, the other decreases proportionally (e.g., number of workers on a transmission line construction project vs days required to complete). Formula: <code>x * y = k</code>.</li>
</ul>

<h3>3. Sample Practical Problems</h3>
<div style="background-color: #f8fafc; padding: 12px; border-left: 4px solid #3b82f6; margin-bottom: 12px;">
    <p><strong>Example 1 (Direct):</strong> If 15 electrical meters cost Rs. 45,000, what will be the cost of 28 electrical meters?</p>
    <p><em>Solution:</em> Cost of 1 meter = 45,000 / 15 = Rs. 3,000. Cost of 28 meters = 28 * 3,000 = <strong>Rs. 84,000</strong>.</p>
</div>
<div style="background-color: #f8fafc; padding: 12px; border-left: 4px solid #10b981;">
    <p><strong>Example 2 (Inverse - Time & Work):</strong> If 12 technicians can string an electric cable section in 10 days, how many days will 8 technicians take to complete the same work?</p>
    <p><em>Solution:</em> 1 technician takes 12 * 10 = 120 days. 8 technicians take 120 / 8 = <strong>15 days</strong>.</p>
</div>',
                            ],
                            [
                                'title' => '3.2 Percentages, Fractions and Decimals',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. Percentages</h3>
<p>Percentage means "per hundred" (out of 100). Represented by symbol <code>%</code>.</p>
<ul>
    <li>Convert Fraction to Percentage: Multiply by 100 (e.g., 3/5 * 100 = 60%).</li>
    <li>Convert Percentage to Fraction: Divide by 100 (e.g., 25% = 25/100 = 1/4).</li>
    <li>Percentage Increase / Decrease = <code>(Change / Original Value) * 100%</code>.</li>
</ul>

<h3>2. Fractions and Operations</h3>
<ul>
    <li><strong>Proper Fraction:</strong> Numerator < Denominator (e.g., 3/7).</li>
    <li><strong>Improper Fraction:</strong> Numerator >= Denominator (e.g., 9/4).</li>
    <li><strong>Mixed Fraction:</strong> Whole number + Proper fraction (e.g., 2 1/4).</li>
    <li><strong>Addition/Subtraction:</strong> Requires finding the Least Common Multiple (LCM) of denominators.</li>
</ul>

<h3>3. Practical Business Math Application</h3>
<p>If NEA reduces transmission distribution system loss from 15.38% to 13.46%, what is the percentage point reduction? Difference = 15.38% - 13.46% = <strong>1.92 percentage points</strong>.</p>',
                            ],
                            [
                                'title' => '3.3 Average (Arithmetic Mean) and Statistical Central Tendency',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. Formula for Average</h3>
<p><code>Average (Mean) = (Sum of all observations) / (Total number of observations)</code></p>
<p><code>Sum of Observations = Average * Total Number</code></p>

<h3>2. Weighted Average</h3>
<p><code>Weighted Mean = Σ(w * x) / Σ(w)</code> where w represents weight/frequency and x represents the data values.</p>

<h3>3. High-Yield Examination Problems</h3>
<div style="background-color: #f8fafc; padding: 12px; border-left: 4px solid #3b82f6;">
    <p><strong>Problem:</strong> The average monthly salary of 10 assistants in an NEA distribution center is Rs. 35,000. When the branch manager\'s salary is added, the average increases to Rs. 38,000. What is the manager\'s salary?</p>
    <p><em>Solution:</em></p>
    <ul>
        <li>Total salary of 10 assistants = 10 * 35,000 = Rs. 350,000.</li>
        <li>Total salary of 11 employees = 11 * 38,000 = Rs. 418,000.</li>
        <li>Manager\'s Salary = 418,000 - 350,000 = <strong>Rs. 68,000</strong>.</li>
    </ul>
</div>',
                            ],
                            [
                                'title' => '3.4 Profit, Loss, Discount and Simple Interest',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Profit and Loss Formulas</h3>
<ul>
    <li><code>Profit = Selling Price (SP) - Cost Price (CP)</code> (when SP > CP)</li>
    <li><code>Loss = Cost Price (CP) - Selling Price (SP)</code> (when CP > SP)</li>
    <li><code>Profit % = (Profit / CP) * 100%</code></li>
    <li><code>Loss % = (Loss / CP) * 100%</code></li>
    <li><code>SP = CP * (1 + Profit% / 100)</code> or <code>SP = CP * (1 - Loss% / 100)</code></li>
</ul>

<h3>2. Marked Price & Discount</h3>
<ul>
    <li><code>Discount Amount = Marked Price (MP) - Selling Price (SP)</code></li>
    <li><code>Discount % = (Discount Amount / MP) * 100%</code></li>
    <li><code>SP = MP * (1 - Discount% / 100)</code></li>
</ul>

<h3>3. Simple Interest</h3>
<ul>
    <li><code>Simple Interest (I) = (P * T * R) / 100</code>
        <ul>
            <li><strong>P:</strong> Principal sum</li>
            <li><strong>T:</strong> Time in years</li>
            <li><strong>R:</strong> Rate of interest per annum (%)</li>
        </ul>
    </li>
    <li><code>Total Amount (A) = Principal (P) + Interest (I)</code></li>
</ul>

<div style="background-color: #f8fafc; padding: 12px; border-left: 4px solid #10b981;">
    <p><strong>Example:</strong> Find the simple interest and total maturity amount on Rs. 80,000 invested at an annual interest rate of 8.5% for 3 years.</p>
    <p><em>Solution:</em> <code>I = (80,000 * 3 * 8.5) / 100 = Rs. 20,400</code>. Total Amount = 80,000 + 20,400 = <strong>Rs. 100,400</strong>.</p>
</div>',
                            ],
                        ],
                    ],
                    [
                        'title' => '2. Computer Literacy & Office Applications',
                        'description' => 'Computer components, Word processing, Spreadsheets (Excel), Presentations (PowerPoint), Email & Internet.',
                        'lessons' => [
                            [
                                'title' => '3.5 Computer Fundamentals and Operating Systems',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. Computer Hardware Architecture</h3>
<ul>
    <li><strong>Input Devices:</strong> Keyboard, Mouse, Scanner, Barcode Reader, Optical Mark Reader (OMR - used in Loksewa checking).</li>
    <li><strong>Central Processing Unit (CPU):</strong> ALU (Arithmetic Logic Unit), CU (Control Unit), and Registers.</li>
    <li><strong>Primary Memory:</strong> RAM (Random Access Memory - volatile), ROM (Read Only Memory - non-volatile containing BIOS/firmware).</li>
    <li><strong>Secondary Storage:</strong> Hard Disk Drive (HDD), Solid State Drive (SSD), Optical discs, Flash drives.</li>
    <li><strong>Output Devices:</strong> Monitor (VDU), Printers (Laser, Inkjet, Dot Matrix), Plotters.</li>
</ul>

<h3>2. Software Classifications</h3>
<ul>
    <li><strong>System Software:</strong> Operating Systems (Windows 10/11, Linux, macOS) managing hardware, CPU scheduling, file storage, and peripheral interfaces.</li>
    <li><strong>Application Software:</strong> Specialized end-user tools (MS Office Suite, Web browsers, ERP accounting software).</li>
    <li><strong>Utility Software:</strong> Antivirus, disk defragmenter, file compression (ZIP, RAR).</li>
</ul>',
                            ],
                            [
                                'title' => '3.6 Office Applications: Word Processing, Excel & PowerPoint',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. MS Word (Word Processing)</h3>
<ul>
    <li>Document creation, formatting (font styles, line spacing, margins, header & footer).</li>
    <li>Tables, page breaks, watermarks, track changes, spell check, and <strong>Mail Merge</strong> (generating mass personalized letters).</li>
    <li>Shortcuts: Ctrl+C (Copy), Ctrl+V (Paste), Ctrl+Z (Undo), Ctrl+Y (Redo), Ctrl+B (Bold), Ctrl+F (Find), Ctrl+H (Replace), Ctrl+S (Save), Ctrl+P (Print).</li>
</ul>

<h3>2. MS Excel (Spreadsheets & Data Analysis)</h3>
<ul>
    <li>Worksheet structure: Rows (numbered 1, 2, 3...) and Columns (lettered A, B, C...). Cell address: e.g., A1, C10.</li>
    <li>Essential Formulas & Functions:
        <ul>
            <li><code>=SUM(A1:A10)</code>: Calculates total sum.</li>
            <li><code>=AVERAGE(B1:B20)</code>: Computes arithmetic mean.</li>
            <li><code>=COUNT(range)</code> and <code>=COUNTA(range)</code>: Counts numeric and non-empty cells.</li>
            <li><code>=IF(logical_test, value_if_true, value_if_false)</code>: Conditional evaluation.</li>
            <li><code>=VLOOKUP(lookup_value, table_array, col_index, [exact_match])</code>: Data search.</li>
        </ul>
    </li>
    <li>Charts (Column, Bar, Pie charts), sorting, filtering, and Pivot Tables.</li>
</ul>

<h3>3. MS PowerPoint (Presentations)</h3>
<ul>
    <li>Slide layouts, slide master, transitions, custom animations, presenter notes, slide show shortcut (F5).</li>
</ul>',
                            ],
                            [
                                'title' => '3.7 Email, Internet and Cyber Security Basics',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. Internet and Networking Protocols</h3>
<ul>
    <li><strong>IP Address:</strong> Unique numerical identifier assigned to every device connected to a network (IPv4: 32-bit, IPv6: 128-bit).</li>
    <li><strong>DNS (Domain Name System):</strong> Translates human-readable domain names (e.g., www.nea.org.np) into IP addresses.</li>
    <li><strong>HTTP / HTTPS:</strong> HyperText Transfer Protocol (HTTPS is secured with SSL/TLS encryption).</li>
    <li><strong>URL (Uniform Resource Locator):</strong> Complete web address specifying location and protocol.</li>
</ul>

<h3>2. Electronic Mail (Email) Protocols & Etiquette</h3>
<ul>
    <li><strong>SMTP (Simple Mail Transfer Protocol):</strong> Protocol used for sending outgoing emails.</li>
    <li><strong>POP3 / IMAP:</strong> Protocols used for receiving and retrieving incoming emails from mail servers.</li>
    <li><strong>Email Fields:</strong> To (primary recipient), CC (Carbon Copy - visible to all), BCC (Blind Carbon Copy - hidden from other recipients), Subject, Attachments.</li>
</ul>

<h3>3. Cyber Security in Public Offices</h3>
<ul>
    <li>Threats: Phishing, malware, viruses, ransomware, trojans, social engineering.</li>
    <li>Protection: Strong passwords, two-factor authentication (2FA), regular backups, licensed antivirus, Electronic Transactions Act (ETA 2063).</li>
</ul>',
                            ],
                            [
                                'title' => '3.8 Mathematics & Computer Assessment Quiz',
                                'type' => 'quiz',
                                'duration_minutes' => 15,
                                'content' => json_encode([
                                    [
                                        'question' => 'If 8 workers complete a job in 12 days, how many days will 6 workers take at the same rate?',
                                        'options' => ['14 days', '16 days', '18 days', '20 days'],
                                        'answer' => 1,
                                        'explanation' => 'Inverse proportion: Total worker-days = 8 * 12 = 96. Days for 6 workers = 96 / 6 = 16 days.',
                                    ],
                                    [
                                        'question' => 'What is the formula to calculate Simple Interest?',
                                        'options' => ['I = P * T * R', 'I = (P * T * R) / 100', 'I = P(1 + R/100)^T', 'I = (P * R) / T'],
                                        'answer' => 1,
                                        'explanation' => 'Simple Interest I = (P * T * R) / 100.',
                                    ],
                                    [
                                        'question' => 'Which protocol is responsible for sending outgoing email messages?',
                                        'options' => ['POP3', 'IMAP', 'SMTP', 'FTP'],
                                        'answer' => 2,
                                        'explanation' => 'SMTP (Simple Mail Transfer Protocol) is used for sending outgoing emails.',
                                    ],
                                    [
                                        'question' => 'What is the keyboard shortcut to start a PowerPoint Slide Show from the beginning?',
                                        'options' => ['F1', 'F5', 'Ctrl+S', 'Alt+F4'],
                                        'answer' => 1,
                                        'explanation' => 'F5 starts the presentation slide show from the beginning.',
                                    ],
                                    [
                                        'question' => 'In MS Excel, which function counts only the cells containing numbers within a range?',
                                        'options' => ['=COUNT()', '=COUNTA()', '=COUNTIF()', '=SUM()'],
                                        'answer' => 0,
                                        'explanation' => '=COUNT() counts cells with numeric values only, whereas =COUNTA() counts all non-empty cells.',
                                    ],
                                ]),
                            ],
                        ],
                    ],
                ],
            ],

            // =========================================================================
            // MODULE 4: ACCOUNTING, FINANCIAL REPORTING & AUDIT (PAPER II - SECTION A - 50 MARKS)
            // =========================================================================
            [
                'title' => 'Service Knowledge: Accounting, Reporting & Audit (Paper II - Section A - 50 Marks)',
                'description' => 'Detailed Accounting Foundations, Double Entry System, Capital & Revenue Expenditure, Books of Accounts, Trial Balance, NEA Financial Reporting, Cost Accounting, Store Management, Internal Control, and Auditing.',
                'chapters' => [
                    [
                        'title' => '1. Fundamental Concepts of Accounting',
                        'description' => 'Bookkeeping, Double Entry principles, Accounting terminology, Accounting Equation, Capital vs Revenue, and Cash vs Accrual.',
                        'lessons' => [
                            [
                                'title' => '4.1 Bookkeeping and Double Entry Accounting System',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Definition of Bookkeeping & Accounting</h3>
<p><strong>Bookkeeping:</strong> The systematic recording of day-to-day financial transactions in the books of original entry in chronological order.</p>
<p><strong>Accounting:</strong> The comprehensive process of identifying, measuring, recording, classifying, summarizing, analyzing, interpreting, and communicating financial information to stakeholders.</p>

<h3>2. Double Entry Bookkeeping System (दोहोरो लेखा प्रणाली)</h3>
<p>First codified by Franciscan friar <strong>Luca Pacioli in 1494 AD</strong> in Venice, Italy ("Father of Accounting").</p>
<h4>Fundamental Rules of Double Entry:</h4>
<ul>
    <li>Every financial transaction affects at least two accounts (one debited, one credited).</li>
    <li>Total Debit Amount must always equal Total Credit Amount (<code>Debit = Credit</code>).</li>
</ul>

<h3>3. Traditional Golden Rules of Accounting</h3>
<table border="1" cellpadding="8" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="background-color: #f1f5f9;">
            <th>Account Category</th>
            <th>Debit Rule</th>
            <th>Credit Rule</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Personal Accounts</strong> (Persons, Firms, Bank, NEA)</td>
            <td>Debit the Receiver</td>
            <td>Credit the Giver</td>
        </tr>
        <tr>
            <td><strong>Real Accounts</strong> (Tangible & Intangible Assets: Cash, Building, Machinery)</td>
            <td>Debit what comes in</td>
            <td>Credit what goes out</td>
        </tr>
        <tr>
            <td><strong>Nominal Accounts</strong> (Expenses, Losses, Incomes, Gains)</td>
            <td>Debit all expenses & losses</td>
            <td>Credit all incomes & gains</td>
        </tr>
    </tbody>
</table>

<h3>4. Modern Classification of Accounts</h3>
<ul>
    <li><strong>Assets & Expenses:</strong> Normal balance is Debit. Increase is Debited (+), Decrease is Credited (-).</li>
    <li><strong>Liabilities, Capital/Equity & Revenues:</strong> Normal balance is Credit. Increase is Credited (+), Decrease is Debited (-).</li>
</ul>',
                            ],
                            [
                                'title' => '4.2 Accounting Terminology and the Accounting Equation',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Key Accounting Terminology</h3>
<ul>
    <li><strong>Assets (सम्पत्ति):</strong> Economic resources owned by the entity that are expected to yield future economic benefits (Current assets: Cash, debtors, inventory; Non-current assets: Plant, transmission lines, land).</li>
    <li><strong>Liabilities (दायित्व):</strong> Present obligations of the enterprise arising from past events, the settlement of which is expected to result in an outflow of resources (Creditors, loans, bank overdraft, unpaid bills).</li>
    <li><strong>Capital / Owner\'s Equity (पुँजी):</strong> The residual interest in the assets of the enterprise after deducting all its liabilities (<code>Equity = Assets - Liabilities</code>).</li>
    <li><strong>Revenues / Income (आम्दानी):</strong> Inflows of economic benefits generated from normal business operations (Electricity sales, meter rent, service connection charges).</li>
    <li><strong>Expenses (खर्च):</strong> Outflows or consumption of assets incurred in the process of generating revenue (Fuel, employee salaries, repairs, interest expense).</li>
    <li><strong>Journal Voucher / Goswara Voucher (गोश्वारा भौचर):</strong> The primary document containing chronological records of financial transactions with debit/credit entries, account codes, and narration.</li>
</ul>

<h3>2. The Fundamental Accounting Equation</h3>
<p style="font-size: 1.15em; font-weight: bold; background-color: #e0f2fe; padding: 10px; border-radius: 6px;">
    Assets = Liabilities + Capital (Owner\'s Equity)
</p>
<p>Expanded Accounting Equation: <code>Assets = Liabilities + Initial Capital + (Revenues - Expenses) - Drawings</code></p>',
                            ],
                            [
                                'title' => '4.3 Capital vs Revenue Expenditure and Bases of Accounting',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. Capital Expenditure vs Revenue Expenditure</h3>
<table border="1" cellpadding="8" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="background-color: #f1f5f9;">
            <th>Feature</th>
            <th>Capital Expenditure (पुँजीगत खर्च)</th>
            <th>Revenue Expenditure (आयगत खर्च)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Definition</strong></td>
            <td>Expenditure incurred to acquire, improve, or extend the useful life of fixed assets.</td>
            <td>Expenditure incurred in the day-to-day operation and maintenance of business.</td>
        </tr>
        <tr>
            <td><strong>Benefit Period</strong></td>
            <td>Yields economic benefits across multiple accounting years (> 1 year).</td>
            <td>Benefit consumed within the current accounting year (<= 1 year).</td>
        </tr>
        <tr>
            <td><strong>Accounting Treatment</strong></td>
            <td>Debited to Asset Account; capitalized in Balance Sheet.</td>
            <td>Debited to Expense Account; charged to Profit & Loss Account.</td>
        </tr>
        <tr>
            <td><strong>Examples</strong></td>
            <td>Purchase of power transformers, construction of substation, transmission line towers.</td>
            <td>Staff salaries, office rent, transformer oil replacement, routine line maintenance.</td>
        </tr>
    </tbody>
</table>

<h3>2. Bases of Accounting</h3>
<ul>
    <li><strong>Cash Basis of Accounting:</strong> Transactions are recorded only when cash is actually received or paid. Accrued incomes and unpaid expenses are ignored. Simple but fails matching principle.</li>
    <li><strong>Accrual / Mercantile Basis of Accounting (प्रोद्भावी लेखा):</strong> Transactions are recognized when they occur (earned or incurred), irrespective of the actual cash flow. Mandated by Nepal Accounting Standards (NAS) / NFRS and NEA financial rules.</li>
</ul>',
                            ],
                        ],
                    ],
                    [
                        'title' => '2. Accounting Records, Reconciliation & Depreciation',
                        'description' => 'Cash Book, Petty Cash Fund (Imprest), Bank Reconciliation, Subsidiary Ledgers, and Depreciation calculation.',
                        'lessons' => [
                            [
                                'title' => '4.4 Books of Accounts, Petty Cash and Subsidiary Ledgers',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Cash Book Types</h3>
<ul>
    <li><strong>Single Column Cash Book:</strong> Records only cash receipts and cash payments.</li>
    <li><strong>Double Column Cash Book:</strong> Contains Cash and Bank columns (or Cash and Discount columns).</li>
    <li><strong>Triple Column Cash Book:</strong> Contains Cash, Bank, and Discount columns on both debit and credit sides. Handles contra entries (depositing cash in bank or withdrawing cash for office use).</li>
</ul>

<h3>2. Petty Cash Fund (सानो नगदी कोष) & Imprest System</h3>
<p>Used to handle minor, recurring office expenses (tea/hospitality, stationery, stamps, local taxi fares) to avoid writing bank cheques for small amounts.</p>
<ul>
    <li><strong>Imprest System:</strong> A fixed advance float (e.g., Rs. 20,000) is provided to the petty cashier. At the end of the period, upon submitting authorized receipts and expense vouchers, the exact amount spent is reimbursed, restoring the fund back to its original float level.</li>
</ul>

<h3>3. Subsidiary Ledgers (सहायक खाता)</h3>
<p>Specialized sub-ledgers maintaining detailed individual accounts: Debtor Ledger (Customer electricity consumption dues), Creditor Ledger (Equipment and contractor payables), and Asset Register.</p>',
                            ],
                            [
                                'title' => '4.5 Bank Reconciliation Statement and Depreciation Accounting',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Bank Reconciliation Statement (BRS - बैंक हिसाब मिलान विवरण)</h3>
<p>A statement prepared periodically by an accountant to reconcile the difference between the bank balance shown in the Cash Book and the balance shown in the Bank Statement / Passbook.</p>
<h4>Causes of Differences:</h4>
<ul>
    <li>Cheques issued but not yet presented for payment in bank (Add to Cash Book balance).</li>
    <li>Cheques deposited but not yet cleared/credited by bank (Deduct from Cash Book balance).</li>
    <li>Direct bank charges, interest debited by bank not recorded in cash book (Deduct).</li>
    <li>Direct collections by bank (customer electricity bill online deposit) not recorded in cash book (Add).</li>
    <li>Errors in recording transactions by office or bank.</li>
</ul>

<h3>2. Depreciation Accounting (ह्रासकट्टी)</h3>
<p>The systematic allocation of the depreciable amount of a tangible fixed asset over its estimated useful economic life due to wear and tear, obsolescence, or passage of time.</p>
<h4>Depreciation Computation Methods:</h4>
<ol>
    <li><strong>Straight-Line Method - SLM (स्थिर किस्ताबन्दी विधि):</strong> Equal amount of depreciation is charged every year.
        <p><code>Annual Depreciation = (Cost of Asset - Estimated Scrap Value) / Useful Life in Years</code></p>
    </li>
    <li><strong>Diminishing / Written Down Value / Declining Balance Method (घट्दो दर ह्रासकट्टी विधि):</strong> Depreciation is calculated at a fixed percentage on the opening book value (Written Down Value) of the asset each year. Depreciation amount decreases year after year.</li>
</ol>',
                            ],
                        ],
                    ],
                    [
                        'title' => '3. Financial Statements & Cost Accounting',
                        'description' => 'Trial balance, NEA financial reporting & consolidation, Profit & Loss, Balance Sheet, Cost concepts, and inventory valuation (FIFO, LIFO, Weighted Average).',
                        'lessons' => [
                            [
                                'title' => '4.6 Trial Balance and Financial Reporting',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Trial Balance (सन्तुलन परीक्षण)</h3>
<p>A schedule of debit and credit balances extracted from all ledger accounts on a specific date to verify the arithmetic accuracy of double-entry postings.</p>
<ul>
    <li><strong>Objectives:</strong> Check arithmetic accuracy, facilitate financial statement preparation, summarize ledger balances.</li>
    <li><strong>Errors not detected by Trial Balance:</strong> Error of principle, error of complete omission, compensating errors, error of commission with balanced amount, error of original entry.</li>
</ul>

<h3>2. Final Financial Statements</h3>
<ul>
    <li><strong>Profit and Loss Account (नाफा नोक्सान हिसाब):</strong> Prepared for an accounting period to determine the Net Profit or Net Loss by matching total revenues against total expenses.</li>
    <li><strong>Balance Sheet (वासलात):</strong> A statement of financial position as of a specific date showing total Assets on one side and Liabilities + Equity on the other side.</li>
</ul>

<h3>3. NEA Operational Offices Financial Reporting & Consolidation</h3>
<p>NEA operates through Regional Offices and Distribution & Consumer Services Centers (DCSCs). Branch offices maintain cash books, revenue ledgers, and expenditure registers, submitting monthly trial balances, bank reconciliations, and budget utilization statements to Central Accounts for consolidation.</p>',
                            ],
                            [
                                'title' => '4.7 Cost Accounting and Store Inventory Valuation',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Cost Accounting Basics</h3>
<p>The specialized branch of accounting dedicated to ascertaining, analyzing, controlling, and optimizing costs of products, services, or projects.</p>
<ul>
    <li><strong>Cost Classification:</strong> Fixed Costs (do not vary with electricity generation volume e.g., plant depreciation), Variable Costs (vary directly e.g., fuel/consumables), Semi-Variable Costs.</li>
    <li><strong>Direct vs Indirect Costs:</strong> Direct material, direct labor, direct expenses (Prime Cost) vs Production, Administrative, and Selling Overheads.</li>
</ul>

<h3>2. Public Procurement & Store Management (सार्वजनिक खरिद र भण्डार व्यवस्थापन)</h3>
<p>Store management ensures uninterrupted supply of materials while minimizing holding costs and preventing pilferage or damage. Maintained via Bin Cards and Store Ledgers.</p>

<h3>3. Material Issue Pricing / Valuation Methods</h3>
<table border="1" cellpadding="8" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="background-color: #f1f5f9;">
            <th>Valuation Method</th>
            <th>Operating Principle</th>
            <th>Impact during Inflation</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>FIFO (First-In, First-Out)</strong></td>
            <td>Oldest inventory purchased is issued first. Closing inventory valued at latest prices.</td>
            <td>Higher reported profit; closing stock reflects current market value.</td>
        </tr>
        <tr>
            <td><strong>LIFO (Last-In, First-Out)</strong></td>
            <td>Most recently acquired goods issued first. Older inventory remains in stock.</td>
            <td>Lower reported profit; tax benefits during rising prices (rarely allowed by NAS).</td>
        </tr>
        <tr>
            <td><strong>Simple Average Method</strong></td>
            <td>Issue price = Sum of unit prices of batches / Number of batches (quantities ignored).</td>
            <td>Simple calculation but distorts cost if lot sizes vary significantly.</td>
        </tr>
        <tr>
            <td><strong>Weighted Average Method</strong></td>
            <td><code>Issue Rate = Total Cost of Available Stock / Total Quantity Available</code></td>
            <td>Smooths price fluctuations; standard method used in NEA store accounting.</td>
        </tr>
    </tbody>
</table>',
                            ],
                        ],
                    ],
                    [
                        'title' => '4. Internal Control, Banking & Auditing Procedures',
                        'description' => 'Internal control, internal audit, statutory audit, bank guarantees, letters of credit (LC), and assessment quiz.',
                        'lessons' => [
                            [
                                'title' => '4.8 Internal Control and Auditing Systems',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Internal Control System (आन्तरिक नियन्त्रण)</h3>
<p>The whole system of financial and operational controls established by management to conduct business smoothly, safeguard assets, ensure data accuracy, and prevent fraud/errors.</p>
<ul>
    <li><strong>Internal Check (आन्तरिक जाँच):</strong> Division of office work among staff such that no single employee handles a transaction from beginning to end without independent verification by another.</li>
    <li><strong>Internal Audit (आन्तरिक लेखापरीक्षण):</strong> An independent appraisal activity established within the organization (e.g., NEA Internal Audit Directorate) to review financial operations, compliance, and internal controls on a continuous basis.</li>
</ul>

<h3>2. Statutory / Final Audit (अन्तिम लेखापरीक्षण)</h3>
<p>An external, independent examination of books of accounts and financial statements conducted by qualified independent auditors (Auditor General of Nepal or designated Chartered Accountants) to express a professional opinion on whether the financial statements present a <strong>true and fair view</strong>.</p>',
                            ],
                            [
                                'title' => '4.9 Banking Operations, Instruments and Guarantees',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. Negotiable Instruments in Commercial Operations</h3>
<ul>
    <li><strong>Cheques:</strong> Bearer cheque, Order cheque, and Crossed cheque (Account Payee - most secure for official government/utility payments).</li>
    <li><strong>Bank Draft:</strong> A financial instrument issued by a bank guaranteeing payment to the payee upon presentation.</li>
    <li><strong>Letter of Credit (LC - प्रतित-पत्र):</strong> A financial commitment letter issued by a buyer\'s bank guaranteeing that payment will be made to the international seller upon delivery of compliant shipping documents (essential in NEA procurement of generators, turbines, cables).</li>
</ul>

<h3>2. Bank Guarantees (बैंक जमानी) in Public Utilities</h3>
<ul>
    <li><strong>Bid Bond (बोली जमानी):</strong> Guarantees that the bidder will not withdraw the tender during the bid validity period and will sign the contract if awarded (typically 2-3% of bid amount).</li>
    <li><strong>Performance Bond (कार्यसम्पादन जमानत):</strong> Guarantees satisfactory performance and completion of the contract according to technical specifications (typically 5% of contract value).</li>
    <li><strong>Advance Payment Guarantee:</strong> Submitted by contractor to claim mobilization advance.</li>
    <li><strong>Release of Guarantee:</strong> Formal release letter issued upon successful contract completion and expiry of defect liability period (DLP).</li>
</ul>',
                            ],
                            [
                                'title' => '4.10 Accounting & Auditing Assessment Quiz',
                                'type' => 'quiz',
                                'duration_minutes' => 15,
                                'content' => json_encode([
                                    [
                                        'question' => 'According to the Golden Rules of accounting, what is the rule for Real Accounts?',
                                        'options' => ['Debit the Receiver, Credit the Giver', 'Debit what comes in, Credit what goes out', 'Debit all expenses, Credit all incomes', 'Debit assets, Credit liabilities'],
                                        'answer' => 1,
                                        'explanation' => 'Real Accounts rule: Debit what comes in, Credit what goes out.',
                                    ],
                                    [
                                        'question' => 'Which financial statement demonstrates the financial position (Assets & Liabilities) of an organization on a specific date?',
                                        'options' => ['Cash Flow Statement', 'Profit & Loss Account', 'Balance Sheet', 'Trial Balance'],
                                        'answer' => 2,
                                        'explanation' => 'The Balance Sheet shows the financial position (Assets, Liabilities, and Equity) on a specific date.',
                                    ],
                                    [
                                        'question' => 'Under which inventory valuation method are the oldest purchased goods assumed to be issued first?',
                                        'options' => ['LIFO', 'Weighted Average', 'FIFO', 'Standard Costing'],
                                        'answer' => 2,
                                        'explanation' => 'FIFO (First-In, First-Out) assumes that the earliest acquired stock is issued first.',
                                    ],
                                    [
                                        'question' => 'What type of bank guarantee is submitted by contractors to ensure satisfactory contract execution?',
                                        'options' => ['Bid Bond', 'Performance Guarantee', 'Travel Bond', 'Customs Guarantee'],
                                        'answer' => 1,
                                        'explanation' => 'Performance Guarantee (Performance Bond) ensures contract completion according to specifications.',
                                    ],
                                    [
                                        'question' => 'Under the Straight-Line Method of depreciation, how is annual depreciation calculated?',
                                        'options' => ['Book Value * Rate', '(Cost - Scrap Value) / Useful Life', 'Cost * Inflation Rate', 'Scrap Value / Useful Life'],
                                        'answer' => 1,
                                        'explanation' => 'Straight-Line Depreciation = (Original Cost - Scrap Value) / Useful Life in Years.',
                                    ],
                                ]),
                            ],
                        ],
                    ],
                ],
            ],

            // =========================================================================
            // MODULE 5: NEA ACTS, BYLAWS & RELEVANT LEGISLATION (PAPER II - SECTION B - 50 MARKS)
            // =========================================================================
            [
                'title' => 'Service Knowledge: NEA Acts, Bylaws & Legislation (Paper II - Section B - 50 Marks)',
                'description' => 'Detailed statutory provisions: Nepal Electricity Authority Act 2041, NEA Employee Service Terms Bylaws, Financial Administration Bylaws, Electricity Theft Control Rules 2059, Retirement Funds (EPF/CIT), Electricity Distribution Bylaws 2078, Income Tax Act 2058 (TDS), and Prevention of Corruption Act 2059.',
                'chapters' => [
                    [
                        'title' => '1. NEA Statutory Framework & Administration',
                        'description' => 'NEA Act 2041, Employee Service Regulations, Financial Administration, budget, advances, and Beruju settlement.',
                        'lessons' => [
                            [
                                'title' => '5.1 Nepal Electricity Authority Act, 2041 (1984)',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>1. Enactment, Scope and Objectives</h3>
<p>The <em>Nepal Electricity Authority Act, 2041</em> was enacted to manage generation, transmission, and distribution of electricity throughout the Kingdom of Nepal in an efficient, safe, and easily accessible manner.</p>

<h3>2. Capital and Corporate Character (Section 4 & 5)</h3>
<ul>
    <li>NEA is a body corporate with perpetual succession, an autonomous seal, power to acquire/dispose of property, and sue or be sued in its corporate name.</li>
    <li>Authorized capital is determined by the Government of Nepal (GoN), with GoN holding equity shares.</li>
</ul>

<h3>3. Board of Directors (Section 8)</h3>
<p>The Board of Directors consists of <strong>8 members</strong>:</p>
<ol>
    <li>Minister / State Minister for Energy, Water Resources and Irrigation - <strong>Chairperson</strong></li>
    <li>Secretary, Ministry of Energy, Water Resources and Irrigation - Member</li>
    <li>Secretary, Ministry of Finance - Member</li>
    <li>One expert appointed from commerce, finance, or power sector - Member</li>
    <li>Two individuals representing agriculture, industry, or consumer groups - Members</li>
    <li>One representative from among non-governmental electricity producers / consumers - Member</li>
    <li>Managing Director (MD) of NEA - <strong>Member Secretary</strong></li>
</ol>

<h3>4. Functions, Duties and Powers (Section 19 & 20)</h3>
<ul>
    <li>Formulate power development plans, construct generation plants, transmission lines, and sub-stations.</li>
    <li>Supply electricity to consumers, fix electricity tariffs with approval of Electricity Regulatory Commission (ERC).</li>
    <li>Maintain accounts in accordance with commercial principles and submit to Auditor General for audit.</li>
</ul>',
                            ],
                            [
                                'title' => '5.2 NEA Employee Service Terms and Conditions Bylaws',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>Key Provisions of NEA Employees Service Bylaws (कर्मचारी सेवा, शर्त विनियमावली)</h3>

<h4>1. Transfer and Promotion (सरुवा, बढुवा तथा पदस्थापन)</h4>
<ul>
    <li><strong>Levels:</strong> Level 1 to Level 12 (Level 1-5 Non-Officer / Assistant, Level 6-10 Officer, Level 11-12 Executive Director / DMD).</li>
    <li><strong>Transfer Principles:</strong> Conducted periodically based on geographical classification of stations (A, B, C, D classes) ensuring staff gain experience across geographic regions.</li>
    <li><strong>Promotion Evaluation:</strong> Based on Performance Appraisal (कार्यसम्पादन मूल्याङ्कन - 40 marks), Seniority (ज्येष्ठता - 30 marks), Academic Qualifications (शैक्षिक योग्यता - 12 marks), Geographical Service in remote stations (भौगोलिक अंक - 16 marks), and Training (2 marks).</li>
</ul>

<h4>2. Leave Regulations (बिदा सम्बन्धी व्यवस्था)</h4>
<ul>
    <li>Casual Leave (पर्व/भैपरी बिदा): 12 days annually with full pay.</li>
    <li>Home Leave (घर बिदा): Earned at 1 day for every 10 days worked (up to 30 days/year); can be accumulated up to 180 days for encashment upon retirement.</li>
    <li>Sick Leave (बिरामी बिदा): 12 days per year with full pay; accumulable without limit.</li>
    <li>Maternity Leave: 98 days for female employees; Paternity Leave: 15 days for male employees.</li>
    <li>Study Leave and Extra-ordinary (Unpaid) Leave provisions.</li>
</ul>

<h4>3. Discipline, Conduct & Penalties (अनुशासन, आचरण र सजाय)</h4>
<ul>
    <li><strong>Minor Penalties:</strong> Censure (नसिहत), withholding of annual grade increment for up to 2 years, withholding of promotion for up to 2 years.</li>
    <li><strong>Major Penalties:</strong> Demotion to a lower post/pay scale, removal from service (eligible for future employment), dismissal from service (disqualified from future government/public employment).</li>
</ul>

<h4>4. Salary, Allowances and Retirement Benefits</h4>
<ul>
    <li>Monthly salary, dearness allowance, Dashain allowance (1 month basic pay), local remote area allowance.</li>
    <li>Pension (निवृत्तिभरण), Gratuity (उपदान), Provident Fund (EPF), Medical Treatment Facility (उपचार सुविधा), and Accidental Insurance.</li>
</ul>',
                            ],
                            [
                                'title' => '5.3 NEA Financial Administration Bylaws',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>Core Provisions of NEA Financial Administration Bylaws (आर्थिक प्रशासन विनियमावली)</h3>

<h4>1. Central Fund and Bank Accounts (केन्द्रीय कोष तथा खाता)</h4>
<ul>
    <li>Central Fund managed by Central Accounts Department at NEA Head Office.</li>
    <li>Revenue collection accounts (No-frills deposit accounts where collection is automatically transferred to Central Pool Account).</li>
    <li>Operating expenditure accounts operated jointly by Chief of Office (Account Head) and Finance Officer.</li>
</ul>

<h4>2. Budget Authorization & Expenditure Release</h4>
<ul>
    <li>Annual budget approved by NEA Board. Budget release occurs quarterly upon submission of expenditure statements and progress reports.</li>
    <li>Re-appropriation (रकम फिर्ता/रकमान्तर): Permitted within stipulated limits and authorized by designated management authorities.</li>
</ul>

<h4>3. Advances Management (पेश्कीका प्रकार तथा फर्छौट)</h4>
<ul>
    <li>Types: Institutional / Operational advance, Employee personal traveling advance (TA/DA advance), Letter of Credit advance, Contractor mobilization advance.</li>
    <li>Advance clearance (फर्छौट): Must be cleared within 15 to 30 days of activity completion; failure leads to deductions from salary with penal interest.</li>
</ul>

<h4>4. Audit Queries / Irregularities (बेरुजु र बेरुजु फर्छौट)</h4>
<ul>
    <li><strong>Beruju Classification:</strong> Regularizable (नियमित गर्ने), Recoverable (असुली गर्ने), and Advances Remaining (पेश्की बाँकी).</li>
    <li>Settlement process: Submitting missing evidence/bills, depositing recovered sums into revenue accounts, seeking Board/Internal audit clearance.</li>
</ul>',
                            ],
                        ],
                    ],
                    [
                        'title' => '2. Electricity Theft Control, Distribution & Tariff Rules',
                        'description' => 'Electricity Leakage Control Rules 2059, Distribution Bylaws 2078, meter reading, locked premise billing, and tariff collection.',
                        'lessons' => [
                            [
                                'title' => '5.4 Electricity Theft Control Rules, 2059 (2002)',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>Key Provisions of Electricity Leakage / Theft Control Rules, 2059 (विद्युत चोरी नियन्त्रण नियमावली)</h3>

<h4>1. Acts Constituting Electricity Theft (विद्युत चोरी मानिने अवस्था)</h4>
<ul>
    <li>Direct tapping/hooking from distribution lines without a registered meter.</li>
    <li>Tampering with meter seals, gear mechanisms, or CT/PT connections to slow down or bypass meter recording.</li>
    <li>Using artificial magnets, electronic bypass gadgets, or reversing meter connections.</li>
    <li>Supplying electricity to unauthorized third parties or using domestic category connection for commercial/industrial purposes without approval.</li>
</ul>

<h4>2. Loss Assessment and Unit Determination (युनिट निर्धारण प्रक्रिया)</h4>
<ul>
    <li>Assessed on the basis of connected load (KW) multiplied by operating hours per day over a period up to <strong>6 months to 1 year</strong>.</li>
    <li>Assessment Formula: <code>Assessment Units = Total Connected Load (KW) * Daily Usage Hours * Days * Utilization Factor</code>.</li>
</ul>

<h4>3. Disconnection & Reconnection</h4>
<ul>
    <li>Power supply disconnected immediately upon detecting theft.</li>
    <li>Reconnection permitted only after payment of total assessed electricity charges + <strong>100% fine/penalty (शतप्रतिशत जरिवाना)</strong> + reconnection fees.</li>
</ul>

<h4>4. Informant Rewards (पुरस्कार सम्बन्धी व्यवस्था)</h4>
<ul>
    <li>Individuals providing concrete information leading to detection and recovery of power theft are eligible for cash reward (up to 20% of recovered fine/amount as per regulations).</li>
</ul>',
                            ],
                            [
                                'title' => '5.5 Electricity Distribution Bylaws, 2078 & Tariff Regulations',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>Provisions of Electricity Distribution Bylaws, 2078 (विद्युत वितरण विनियमावली)</h3>

<h4>1. New Customer Connection (नयाँ ग्राहक कायम गर्ने)</h4>
<ul>
    <li>Submission of application form, citizenship certificate, land ownership certificate (Lalpurja) or lease agreement, house completion certificate/recommendation.</li>
    <li>Feasibility survey, deposit of security deposit (धरौटी) and service connection fee, installation of sealed meter.</li>
</ul>

<h4>2. Meter Reading and Testing (मिटर जाँच र रिडिङ्ग)</h4>
<ul>
    <li>Conducted by designated meter readers according to monthly fixed reading cycles (Group A, B, C, D).</li>
    <li>Testing of defective or fast/slow meters upon customer application using calibrated test benches.</li>
</ul>

<h4>3. Billing During Locked Premises (तालाबन्दीमा हुने बिलिङ्ग)</h4>
<ul>
    <li>If meter premises are locked during reading cycle, minimum monthly service charge / average consumption bill is generated. Adjustment occurs on subsequent physical reading.</li>
</ul>

<h4>4. Tariff Collection & Rebate / Penalty Structure</h4>
<ul>
    <li>Payment within 1st week of bill generation: <strong>Rebate / Discount (e.g., 2-3% discount)</strong>.</li>
    <li>Payment within due date (e.g., up to 22nd day): Net bill amount without penalty.</li>
    <li>Delayed payment beyond due date: Graded fine/surcharge (5% penalty up to 30 days, 10% penalty up to 40 days, 25% penalty beyond 40 days).</li>
    <li>Supply disconnected (Blacklisting & Line Cut) if unpaid beyond 60 days.</li>
</ul>',
                            ],
                        ],
                    ],
                    [
                        'title' => '3. Tax Laws, Retirement Funds & Anti-Corruption',
                        'description' => 'EPF, CIT, Income Tax Act 2058 (TDS provisions), Prevention of Corruption Act 2059, and Final Assessment Quiz.',
                        'lessons' => [
                            [
                                'title' => '5.6 Retirement Funds: EPF and Citizen Investment Trust (CIT)',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>1. Employees Provident Fund - EPF (कर्मचारी सञ्चय कोष)</h3>
<ul>
    <li><strong>Mandatory Contribution:</strong> 10% deducted from employee monthly basic salary + 10% matching contribution by NEA = <strong>Total 20%</strong> deposited monthly in EPF.</li>
    <li><strong>Benefits:</strong> Annual compounding interest, special loan facilities (house loan, education loan), medical insurance support, funeral grants, and lump-sum payment upon retirement.</li>
</ul>

<h3>2. Citizen Investment Trust - CIT (नागरिक लगानी कोष)</h3>
<ul>
    <li>Voluntary / mandatory retirement schemes, gratuity fund management, and defined-benefit pension schemes.</li>
    <li>Provides income tax deduction benefits up to prescribed statutory limits (e.g., 1/3 of taxable income or Rs. 300,000 / Rs. 500,000 as per prevailing Finance Act).</li>
</ul>',
                            ],
                            [
                                'title' => '5.7 Income Tax Act, 2058 & Tax Deducted at Source (TDS)',
                                'type' => 'text',
                                'duration_minutes' => 25,
                                'content' => '<h3>Essential Provisions of Income Tax Act, 2058 (आयकर ऐन)</h3>

<h4>1. Taxation of Remuneration / Employment Income (Section 8)</h4>
<ul>
    <li>Includes basic salary, allowances, overtime pay, Dashain bonus, leave encashment, employer provident fund contributions, and perquisites.</li>
    <li>Progressive slab rates for natural persons (Single vs Married couple slabs: 1% Social Security Tax on initial exemption limit, 10%, 20%, 30%, and 36%/39% super-tax for high brackets).</li>
</ul>

<h4>2. Tax Deductions at Source - TDS (कर कट्टी सम्बन्धी व्यवस्था)</h4>
<table border="1" cellpadding="8" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="background-color: #f1f5f9;">
            <th>Transaction Type</th>
            <th>Applicable TDS Rate</th>
            <th>Type of Withholding</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>House Rent Payment</strong> (Institutional/Office rental)</td>
            <td>10%</td>
            <td>Local level / Inland Revenue</td>
        </tr>
        <tr>
            <td><strong>Interest on Bank Deposits</strong> (Institutional)</td>
            <td>15%</td>
            <td>Adjustable TDS</td>
        </tr>
        <tr>
            <td><strong>Supply of Goods (Contract > Rs. 50 Lakhs)</strong></td>
            <td>1.5%</td>
            <td>Adjustable TDS</td>
        </tr>
        <tr>
            <td><strong>Service Contract / Consultancy Fees</strong></td>
            <td>15% (VAT bill: 1.5% on contract / 15% without PAN)</td>
            <td>Adjustable TDS</td>
        </tr>
        <tr>
            <td><strong>Meeting Allowance / Lecture Fees</strong></td>
            <td>15%</td>
            <td>Final Withholding Tax (अन्तिम कर)</td>
        </tr>
    </tbody>
</table>

<h4>3. Deposit and Reporting of TDS (Section 90)</h4>
<p>All withheld tax must be deposited in the Government Treasury within <strong>25 days</strong> of the following Nepali month, accompanied by e-TDS returns filing via the IRD portal.</p>',
                            ],
                            [
                                'title' => '5.8 Prevention of Corruption Act, 2059 & Public Integrity',
                                'type' => 'text',
                                'duration_minutes' => 20,
                                'content' => '<h3>Key Provisions of Prevention of Corruption Act, 2059 (भ्रष्टाचार निवारण ऐन)</h3>

<h4>1. Major Corruption Offenses (Section 3 - 17)</h4>
<ul>
    <li>Accepting or giving bribery/grafts (रिसवत/घुस लिने दिने).</li>
    <li>Embezzlement, misappropriation, or damage of public property (सरकारी/सार्वजनिक सम्पत्तिको हिनामिना).</li>
    <li>Preparing false official documents, bills, measurement books, or progress reports.</li>
    <li>Illegal enrichment / Unaccounted wealth: Public servant possessing property disproportionate to lawful income sources.</li>
    <li>Leaking confidential tenders, revenue leakage, or manipulating procurement bids.</li>
</ul>

<h4>2. Penal Provisions</h4>
<ul>
    <li>Imprisonment ranging from 3 months to 10+ years depending on the misappropriated amount, along with confiscation of property and equivalent fine.</li>
    <li>Enhanced punishment (additional 3 years) for office chiefs, constitutional post holders, and senior public officials.</li>
</ul>

<h4>3. Surveillance & Reporting</h4>
<ul>
    <li>Mandatory annual submission of Property Declaration (सम्पत्ति विवरण) by every NEA employee within 60 days of fiscal year start (by Bhadra end).</li>
    <li>Investigative powers vested in CIAA and National Vigilance Centre (NVC).</li>
</ul>',
                            ],
                            [
                                'title' => '5.9 NEA Legislation & Governance Assessment Quiz',
                                'type' => 'quiz',
                                'duration_minutes' => 15,
                                'content' => json_encode([
                                    [
                                        'question' => 'Who serves as the Chairperson of the Board of Directors of Nepal Electricity Authority?',
                                        'options' => ['Secretary of Energy', 'Managing Director of NEA', 'Minister / State Minister for Energy', 'Auditor General'],
                                        'answer' => 2,
                                        'explanation' => 'Under Section 8 of the NEA Act 2041, the Minister or State Minister for Energy is the Chairperson of the Board.',
                                    ],
                                    [
                                        'question' => 'What penalty is levied on consumers for electricity theft under Electricity Theft Control Rules?',
                                        'options' => ['25% fine', '50% fine', '100% fine (double the loss amount)', '200% fine'],
                                        'answer' => 2,
                                        'explanation' => 'The total assessed unmetered electricity charge is recovered along with a 100% fine (शतप्रतिशत जरिवाना).',
                                    ],
                                    [
                                        'question' => 'What is the mandatory monthly employee contribution deducted for the Employees Provident Fund (EPF)?',
                                        'options' => ['5%', '10%', '15%', '20%'],
                                        'answer' => 1,
                                        'explanation' => '10% is deducted from basic salary, which is matched by 10% from NEA, totaling 20%.',
                                    ],
                                    [
                                        'question' => 'Within how many days of the end of each month must Withheld Tax (TDS) be deposited to the government treasury?',
                                        'options' => ['7 days', '15 days', '25 days', '30 days'],
                                        'answer' => 2,
                                        'explanation' => 'Under Section 90 of the Income Tax Act, TDS must be deposited within 25 days of the following month.',
                                    ],
                                    [
                                        'question' => 'Within how many days from the start of a fiscal year must public employees submit their annual property declaration?',
                                        'options' => ['30 days', '60 days', '90 days', '120 days'],
                                        'answer' => 1,
                                        'explanation' => 'Under the Prevention of Corruption Act, property declarations must be submitted within 60 days of the fiscal year start.',
                                    ],
                                ]),
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    private function generateNeaPdfNotes(): void
    {
        $filePath = $this->pdfBasePath.'/nea-level4-comprehensive-notes.pdf';

        if (file_exists($filePath)) {
            return;
        }

        try {
            $pdf = new PdfGenerator;
            $pdf->setTitle('Nepal Electricity Authority (NEA) Level 4 Complete Study Notes');
            $pdf->setSubtitle('Administration & Accounting Service - Internal & Open Competitive Examination');
            $pdf->setHtmlContent('
                <h2>Examination Scheme & Syllabus Overview</h2>
                <p><strong>Phase 1: Written Examination (200 Marks)</strong></p>
                <ul>
                    <li><strong>Paper I (100 Marks):</strong> General Knowledge (50 Marks), Constitution of Nepal (40 Marks), General Mathematics & Computer Fundamentals (10 Marks). Objective MCQs: 50 Qs x 1 Mark = 50 Marks; Subjective: 10 Qs x 5 Marks = 50 Marks.</li>
                    <li><strong>Paper II (100 Marks):</strong> Service-Related Knowledge. Section A: Accounting, Costing & Auditing (50 Marks); Section B: NEA Acts, Bylaws, Electricity Theft Control, Tax & Anti-Corruption (50 Marks).</li>
                </ul>
                <hr>
                <h2>Paper I: Core Summary</h2>
                <h3>1. General Knowledge</h3>
                <p>Geography of Nepal (147,516 sq. km, 3 ecological belts: Himal 15%, Pahad 68%, Terai 17%), 5 climatic zones, major river basins (Koshi, Gandaki, Karnali), 83,000 MW hydropower potential (42,000 MW economic), 16th Periodic Plan targets, sustainable development goals (SDGs), and 3-tier federalism.</p>
                <h3>2. Constitution of Nepal (2072)</h3>
                <p>35 Parts, 308 Articles, 9 Schedules. 31 Fundamental rights (Articles 16-46), Directive principles (Art. 50), State policies on natural resources (Art. 51), CIAA (Part 21), Auditor General (Part 22), Public Service Commission (Part 23), and Federal distribution of powers (Schedules 5-9).</p>
                <h3>3. Mathematics & Computer Fundamentals</h3>
                <p>Unitary method, percentage, average, profit/loss, simple interest (I = PTR/100), MS Office (Word, Excel, PowerPoint), email protocols (SMTP/IMAP), and cyber security.</p>
                <hr>
                <h2>Paper II: Service Knowledge Summary</h2>
                <h3>1. Accounting & Financial Management</h3>
                <p>Double entry bookkeeping (Luca Pacioli, 1494), Accounting Equation (Assets = Liabilities + Equity), Cash vs Accrual basis, Cash Book, Petty Cash Imprest system, Bank Reconciliation Statement (BRS), Depreciation (Straight-line vs Declining balance), Trial balance, Final Accounts (P&L, Balance Sheet), Cost accounting, Store inventory valuation (FIFO, LIFO, Weighted Average), Internal control, Internal audit, Statutory audit, Bank Guarantees (Bid bond, Performance bond), and Letters of Credit (LC).</p>
                <h3>2. NEA Legislation & Governance</h3>
                <p>NEA Act 2041 (Board composition, powers, functions), NEA Employee Service Bylaws (Transfers, promotions, leaves, discipline, conduct, salary & retirement benefits), Financial Administration Bylaws (Central fund, budget, advances, Beruju clearance), Electricity Theft Control Rules 2059 (Theft assessment, 100% fine, line disconnection), EPF & CIT retirement funds, Electricity Distribution Bylaws 2078 (Connections, metering, billing), Income Tax Act 2058 (Salary tax, TDS rates, deposit within 25 days), and Prevention of Corruption Act 2059 (Corruption offenses, CIAA investigations, annual property disclosure within 60 days).</p>
            ');
            $pdf->save($filePath);
            $this->command->info('   📄 Generated study notes PDF: nea-level4-comprehensive-notes.pdf');
        } catch (\Throwable $e) {
            $this->command->warn('   ⚠️ PDF generation skipped: '.$e->getMessage());
        }
    }
}
