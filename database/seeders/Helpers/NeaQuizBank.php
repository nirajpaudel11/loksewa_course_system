<?php

namespace Database\Seeders\Helpers;

use App\Models\Course;
use App\Models\Lesson;

class NeaQuizBank
{
    /**
     * Populate exactly 10 questions for every single lesson of NEA Level 4 course.
     */
    public static function attachQuestionsToAllLessons(Course $course): void
    {
        $moduleIds = $course->modules()->pluck('id')->toArray();
        $lessons = Lesson::where(function ($query) use ($moduleIds, $course) {
            $query->whereIn('module_id', $moduleIds)
                ->orWhereHas('chapter.module', function ($q) use ($course) {
                    $q->where('course_id', $course->id);
                });
        })->get();

        foreach ($lessons as $lesson) {
            $questions = self::getQuestionsForLesson($lesson->title);

            // Save to both quiz_questions attribute and content (if quiz type)
            $lesson->quiz_questions = $questions;
            if ($lesson->type === 'quiz') {
                $lesson->content = json_encode($questions, JSON_UNESCAPED_UNICODE);
            }
            $lesson->save();
        }
    }

    public static function getQuestionsForLesson(string $title): array
    {
        $key = strtolower($title);

        if (str_contains($key, 'topographical') || str_contains($key, 'physical features')) {
            return self::qTopography();
        }
        if (str_contains($key, 'climate') || str_contains($key, 'weather dynamics')) {
            return self::qClimate();
        }
        if (str_contains($key, 'natural resources') || str_contains($key, 'conservation')) {
            return self::qResources();
        }
        if (str_contains($key, 'socio-cultural') || str_contains($key, 'heritage')) {
            return self::qSocioCultural();
        }
        if (str_contains($key, 'periodic plan') || str_contains($key, 'planning')) {
            return self::qPeriodicPlan();
        }
        if (str_contains($key, 'drivers of economic') || str_contains($key, 'economic development')) {
            return self::qEconomicDrivers();
        }
        if (str_contains($key, 'solar') || str_contains($key, 'wind energy') || str_contains($key, 'water resources')) {
            return self::qEnergyResources();
        }
        if (str_contains($key, 'hydropower development') || str_contains($key, 'role of nea')) {
            return self::qHydropowerNea();
        }
        if (str_contains($key, 'sustainable development') || str_contains($key, 'population')) {
            return self::qSustainableDev();
        }
        if (str_contains($key, 'pollution control') || str_contains($key, 'climate management')) {
            return self::qPollutionControl();
        }
        if (str_contains($key, 'current affairs') || str_contains($key, 'sports')) {
            return self::qCurrentAffairs();
        }
        if (str_contains($key, 'federalism')) {
            return self::qFederalism();
        }
        if (str_contains($key, 'inclusion') || str_contains($key, 'social justice') || str_contains($key, 'democracy')) {
            return self::qInclusion();
        }
        if (str_contains($key, 'fundamental features') && str_contains($key, 'constitution')) {
            return self::qConstitutionFeatures();
        }
        if (str_contains($key, 'preliminary') || str_contains($key, 'part-1')) {
            return self::qPart1Preliminary();
        }
        if (str_contains($key, 'fundamental rights') || str_contains($key, 'part-3')) {
            return self::qFundamentalRights();
        }
        if (str_contains($key, 'directive principles') || str_contains($key, 'part-4')) {
            return self::qDirectivePrinciples();
        }
        if (str_contains($key, 'constitutional organs') || str_contains($key, 'commissions')) {
            return self::qConstitutionalOrgans();
        }
        if (str_contains($key, 'schedules of the constitution')) {
            return self::qSchedules();
        }
        if (str_contains($key, 'unitary method')) {
            return self::qUnitaryMethod();
        }
        if (str_contains($key, 'percentage') || str_contains($key, 'fraction')) {
            return self::qPercentages();
        }
        if (str_contains($key, 'average') || str_contains($key, 'central tendency')) {
            return self::qAverages();
        }
        if (str_contains($key, 'profit') || str_contains($key, 'interest') || str_contains($key, 'discount')) {
            return self::qProfitInterest();
        }
        if (str_contains($key, 'computer fundamentals') || str_contains($key, 'operating system')) {
            return self::qComputerFundamentals();
        }
        if (str_contains($key, 'word processing') || str_contains($key, 'excel') || str_contains($key, 'powerpoint')) {
            return self::qOfficeApplications();
        }
        if (str_contains($key, 'email') || str_contains($key, 'internet') || str_contains($key, 'cyber security')) {
            return self::qEmailInternet();
        }
        if (str_contains($key, 'double entry') || str_contains($key, 'bookkeeping')) {
            return self::qDoubleEntry();
        }
        if (str_contains($key, 'accounting terminology') || str_contains($key, 'accounting equation')) {
            return self::qAccountingEquation();
        }
        if (str_contains($key, 'capital vs revenue') || str_contains($key, 'bases of accounting')) {
            return self::qCapitalRevenue();
        }
        if (str_contains($key, 'cash book') || str_contains($key, 'petty cash') || str_contains($key, 'subsidiary')) {
            return self::qCashBookPetty();
        }
        if (str_contains($key, 'bank reconciliation') || str_contains($key, 'depreciation')) {
            return self::qBrsDepreciation();
        }
        if (str_contains($key, 'trial balance') || str_contains($key, 'financial reporting')) {
            return self::qTrialBalance();
        }
        if (str_contains($key, 'cost accounting') || str_contains($key, 'inventory valuation') || str_contains($key, 'fifo')) {
            return self::qCostAccounting();
        }
        if (str_contains($key, 'internal control') || str_contains($key, 'auditing systems')) {
            return self::qInternalControl();
        }
        if (str_contains($key, 'banking operations') || str_contains($key, 'instruments') || str_contains($key, 'guarantees')) {
            return self::qBankingGuarantees();
        }
        if (str_contains($key, 'act, 2041') || str_contains($key, 'authority act')) {
            return self::qNeaAct();
        }
        if (str_contains($key, 'employee service terms') || str_contains($key, 'service bylaws')) {
            return self::qEmployeeBylaws();
        }
        if (str_contains($key, 'financial administration') || str_contains($key, 'beruju')) {
            return self::qFinancialBylaws();
        }
        if (str_contains($key, 'theft control') || str_contains($key, 'leakage')) {
            return self::qTheftControl();
        }
        if (str_contains($key, 'distribution bylaws') || str_contains($key, 'tariff')) {
            return self::qDistributionTariff();
        }
        if (str_contains($key, 'retirement funds') || str_contains($key, 'epf') || str_contains($key, 'cit')) {
            return self::qRetirementFunds();
        }
        if (str_contains($key, 'income tax') || str_contains($key, 'tds')) {
            return self::qIncomeTax();
        }
        if (str_contains($key, 'corruption') || str_contains($key, 'integrity')) {
            return self::qAntiCorruption();
        }

        // Generic comprehensive assessment fallback
        return self::qGeneralNeaAssessment();
    }

    private static function qTopography(): array
    {
        return [
            ['question' => 'What is the official total land area of Nepal in square kilometers?', 'options' => ['147,181 sq. km', '147,516 sq. km', '147,984 sq. km', '148,000 sq. km'], 'answer' => 1, 'explanation' => 'The official updated area of Nepal including Limpiyadhura and Lipulekh is 147,516 sq. km.'],
            ['question' => 'What percentage of Nepal\'s total land area is occupied by the Hilly (Pahad) region?', 'options' => ['15%', '68%', '17%', '50%'], 'answer' => 1, 'explanation' => 'The Hilly region covers approximately 68% of Nepal\'s land surface.'],
            ['question' => 'What percentage of Nepal\'s land area is covered by the Himalayan region?', 'options' => ['15%', '68%', '17%', '25%'], 'answer' => 0, 'explanation' => 'The Himalayan region covers approximately 15% of the total land.'],
            ['question' => 'Which is the longest river in Nepal?', 'options' => ['Koshi River', 'Gandaki River', 'Karnali River', 'Bagmati River'], 'answer' => 2, 'explanation' => 'Karnali is the longest river in Nepal with a length of approximately 507 km.'],
            ['question' => 'Which river system has the highest water discharge volume in Nepal?', 'options' => ['Koshi River System', 'Gandaki River System', 'Karnali River System', 'Mahakali River System'], 'answer' => 0, 'explanation' => 'The Koshi River system has the largest water discharge volume.'],
            ['question' => 'What is the official height of Mount Everest (Sagarmatha)?', 'options' => ['8,848.00 m', '8,848.86 m', '8,850.00 m', '8,844.43 m'], 'answer' => 1, 'explanation' => 'The joint measurement announced in 2020 by Nepal and China is 8,848.86 meters.'],
            ['question' => 'The deepest gorge in the world (Dana Gorge / Kali Gandaki Gorge) lies between which two mountain massifs?', 'options' => ['Everest and Lhotse', 'Annapurna and Dhaulagiri', 'Kanchenjunga and Makalu', 'Manaslu and Ganesh Himal'], 'answer' => 1, 'explanation' => 'Dana Gorge lies between the Annapurna and Dhaulagiri mountain ranges.'],
            ['question' => 'What is the lowest altitude point of Nepal?', 'options' => ['Kechana Kalan, Jhapa (58m)', 'Mukhyapatti Musharniya, Dhanusha (59-60m)', 'Birgunj (70m)', 'Janakpur (65m)'], 'answer' => 1, 'explanation' => 'Mukhyapatti Musharniya in Dhanusha / Kechana Kalan in Jhapa represent the lowest points (~58-60m).'],
            ['question' => 'How many peaks above 8,000 meters are located in Nepal?', 'options' => ['6', '8', '10', '14'], 'answer' => 1, 'explanation' => 'Out of the world\'s 14 peaks above 8,000 meters, 8 are located in Nepal.'],
            ['question' => 'Which mountain range lies south of the Mahabharat range in Nepal?', 'options' => ['Greater Himalayas', 'Chure / Siwalik Range', 'Tibetan Plateau', 'Lesser Himalayas'], 'answer' => 1, 'explanation' => 'The Chure (Siwalik) range forms the southernmost mountain belt in Nepal.'],
        ];
    }

    private static function qClimate(): array
    {
        return [
            ['question' => 'What percentage of annual rainfall in Nepal is brought by the Summer Monsoon?', 'options' => ['50%', '60%', '80%', '95%'], 'answer' => 2, 'explanation' => 'Around 80% of total annual rainfall occurs during the Summer Monsoon (June to September).'],
            ['question' => 'From which body of water does the summer monsoon originate before entering Nepal?', 'options' => ['Arabian Sea', 'Bay of Bengal', 'Mediterranean Sea', 'Red Sea'], 'answer' => 1, 'explanation' => 'The summer monsoon enters Nepal from the Bay of Bengal.'],
            ['question' => 'Which direction does the summer monsoon travel across Nepal?', 'options' => ['West to East', 'East to West', 'North to South', 'North-West to South-East'], 'answer' => 1, 'explanation' => 'The monsoon enters from the South-East/East and advances towards the West.'],
            ['question' => 'Winter rainfall in western Nepal is primarily caused by which weather system?', 'options' => ['South-East Monsoon', 'Western Disturbance (Mediterranean Sea)', 'Typhoon circulation', 'Polar vortex'], 'answer' => 1, 'explanation' => 'Western Disturbance originating from the Mediterranean brings winter showers and snow.'],
            ['question' => 'Which district in Nepal receives the lowest annual rainfall due to rain-shadow effect?', 'options' => ['Jhapa', 'Mustang', 'Kaski', 'Ilam'], 'answer' => 1, 'explanation' => 'Mustang and Manang lie in the rain-shadow of the Himalayas and receive very little rainfall (<300mm/yr).'],
            ['question' => 'Which place in Nepal records the highest average annual rainfall?', 'options' => ['Lumle, Kaski', 'Dhangadhi, Kailali', 'Namche Bazaar', 'Dharan, Sunsari'], 'answer' => 0, 'explanation' => 'Lumle (near Pokhara, Kaski) receives over 5,000 mm of annual rainfall.'],
            ['question' => 'Which climatic zone is found at altitudes between 1,200m and 2,100m in Nepal?', 'options' => ['Tropical', 'Warm Temperate', 'Alpine', 'Tundra'], 'answer' => 1, 'explanation' => 'Warm Temperate climate prevails in the mid-hills (1,200m - 2,100m).'],
            ['question' => 'The permanent snowline in Nepal generally starts above which altitude?', 'options' => ['3,000m', '4,000m', '5,000m', '6,500m'], 'answer' => 2, 'explanation' => 'The permanent snowline and Tundra zone in Nepal begins above 5,000 meters.'],
            ['question' => 'What is the climate of the Terai and Inner Terai regions?', 'options' => ['Sub-tropical / Tropical', 'Alpine', 'Temperate', 'Polar'], 'answer' => 0, 'explanation' => 'The Terai has a tropical to sub-tropical climate with hot summers and mild winters.'],
            ['question' => 'During which months does the post-monsoon (Autumn/Sharad) season occur in Nepal?', 'options' => ['March - May', 'June - August', 'October - November', 'December - February'], 'answer' => 2, 'explanation' => 'October to November is the post-monsoon autumn season with clear skies.'],
        ];
    }

    private static function qResources(): array
    {
        return [
            ['question' => 'What percentage of Nepal\'s land area is covered by forest and other wooded land?', 'options' => ['25.4%', '37.0%', '45.31%', '55.0%'], 'answer' => 2, 'explanation' => 'National forest assessments show approximately 45.31% forest and wooded land cover.'],
            ['question' => 'Which is the first national park established in Nepal (1973 AD)?', 'options' => ['Sagarmatha National Park', 'Chitwan National Park', 'Bardiya National Park', 'Langtang National Park'], 'answer' => 1, 'explanation' => 'Chitwan National Park was established in 1973 AD as Nepal\'s first national park.'],
            ['question' => 'Which is the largest National Park in Nepal by surface area?', 'options' => ['Chitwan NP', 'Shey-Phoksundo NP (3,555 sq. km)', 'Makalu Barun NP', 'Bardiya NP'], 'answer' => 1, 'explanation' => 'Shey-Phoksundo National Park (3,555 sq. km) is the largest national park in Nepal.'],
            ['question' => 'Which is the only Hunting Reserve in Nepal?', 'options' => ['Koshi Tappu', 'Parsa', 'Dhorpatan Hunting Reserve', 'Shuklaphanta'], 'answer' => 2, 'explanation' => 'Dhorpatan Hunting Reserve is the sole hunting reserve in Nepal.'],
            ['question' => 'What is the largest Conservation Area in Nepal?', 'options' => ['Annapurna Conservation Area (7,629 sq. km)', 'Kanchenjunga CA', 'Manaslu CA', 'Gaurishankar CA'], 'answer' => 0, 'explanation' => 'Annapurna Conservation Area (ACAP) is the largest conservation area in Nepal.'],
            ['question' => 'Koshi Tappu Wildlife Reserve is globally renowned for protecting which endangered animal?', 'options' => ['Snow Leopard', 'Wild Water Buffalo (Arna)', 'One-horned Rhinoceros', 'Red Panda'], 'answer' => 1, 'explanation' => 'Koshi Tappu is the prime habitat for wild water buffalo (Arna).'],
            ['question' => 'Which mineral deposit is abundantly found and mined at Kharidhunga, Dolakha?', 'options' => ['Gold', 'Magnesite', 'Coal', 'Petroleum'], 'answer' => 1, 'explanation' => 'Kharidhunga has one of South Asia\'s largest high-grade magnesite deposits.'],
            ['question' => 'What is the national flower of Nepal?', 'options' => ['Lotus', 'Rhododendron (Lali Gurans)', 'Marigold', 'Orchid'], 'answer' => 1, 'explanation' => 'Rhododendron Arboreum (Lali Gurans) is the national flower.'],
            ['question' => 'What is the national bird of Nepal?', 'options' => ['Spiny Babbler', 'Danphe (Lophophorus / Impeyan Pheasant)', 'Himalayan Monal', 'Peacock'], 'answer' => 1, 'explanation' => 'Danphe (Lophophorus) is the national bird of Nepal.'],
            ['question' => 'Which tree species found in the Himalayas of Nepal is famous as a natural source for the anti-cancer drug Taxol?', 'options' => ['Yarsagumba', 'Himalayan Yew (Lothsalla)', 'Chir Pine', 'Sissoo'], 'answer' => 1, 'explanation' => 'Himalayan Yew (Taxus wallichiana / Lothsalla) leaves are harvested for Taxol.'],
        ];
    }

    private static function qSocioCultural(): array
    {
        return [
            ['question' => 'According to National Population Census 2078 (2021), what is the total population of Nepal?', 'options' => ['26,494,504', '29,164,578', '30,500,000', '28,500,000'], 'answer' => 1, 'explanation' => 'Census 2078 recorded Nepal\'s population at 29,164,578.'],
            ['question' => 'What was the annual population growth rate recorded in Census 2078?', 'options' => ['1.35%', '0.92%', '2.10%', '0.45%'], 'answer' => 1, 'explanation' => 'The annual exponential population growth rate was 0.92%.'],
            ['question' => 'How many distinct castes and ethnic groups were recorded in Census 2078?', 'options' => ['125', '142', '100', '150'], 'answer' => 1, 'explanation' => 'Census 2078 recorded 142 distinct caste and ethnic communities.'],
            ['question' => 'How many mother tongues were enumerated in Nepal in Census 2078?', 'options' => ['92', '124', '142', '110'], 'answer' => 1, 'explanation' => '124 distinct mother tongues were enumerated in Nepal.'],
            ['question' => 'What percentage of the population speaks Nepali as their mother tongue?', 'options' => ['44.86%', '58.20%', '35.40%', '65.00%'], 'answer' => 0, 'explanation' => 'Nepali is spoken as mother tongue by 44.86% of the population.'],
            ['question' => 'How many monument zones in Kathmandu Valley are inscribed as UNESCO World Heritage sites?', 'options' => ['3', '5', '7', '10'], 'answer' => 2, 'explanation' => 'Kathmandu Valley comprises 7 monument zones (Pashupati, Swayambhu, Bauddha, Changu, 3 Durbar Squares).'],
            ['question' => 'Which festival is the most prominent harvest festival celebrated by the Tharu community in Terai?', 'options' => ['Chhath', 'Maghi', 'Ubhauli', 'Bisket Jatra'], 'answer' => 1, 'explanation' => 'Maghi (Makar Sankranti) is celebrated as the New Year and major festival by the Tharu people.'],
            ['question' => 'Ubhauli and Udhauli festivals are celebrated by which ethnic community in Nepal?', 'options' => ['Gurung', 'Rai and Limbu (Kirat)', 'Newar', 'Sherpa'], 'answer' => 1, 'explanation' => 'Kirat communities (Rai, Limbu, Yakkha, Sunuwar) celebrate Ubhauli and Udhauli.'],
            ['question' => 'Ghewa is the traditional death ritual practiced by which community in Nepal?', 'options' => ['Tamang', 'Brahmin', 'Tharu', 'Maithil'], 'answer' => 0, 'explanation' => 'Ghewa is the sacred funeral ritual of the Tamang community.'],
            ['question' => 'What is the sex ratio (males per 100 females) in Nepal according to Census 2078?', 'options' => ['91.50', '95.59', '98.20', '102.10'], 'answer' => 1, 'explanation' => 'The sex ratio was recorded at 95.59 males per 100 females.'],
        ];
    }

    private static function qPeriodicPlan(): array
    {
        return [
            ['question' => 'In which year BS was periodic planning first introduced in Nepal with the 1st Five-Year Plan?', 'options' => ['2007 BS', '2013 BS', '2019 BS', '2028 BS'], 'answer' => 1, 'explanation' => 'The First Five-Year Plan began in 2013 BS under PM Tanka Prasad Acharya.'],
            ['question' => 'What is the main slogan/theme of the 16th Periodic Plan of Nepal (2081/82 - 2085/86)?', 'options' => ['Prosperous Nepal, Happy Nepali', 'Good Governance, Social Justice, and Prosperity', 'Sustainable Energy for All', 'Inclusive Industrialization'], 'answer' => 1, 'explanation' => 'The core theme of the 16th Plan is "Good Governance, Social Justice, and Prosperity".'],
            ['question' => 'Who serves as the ex-officio Chairperson of the National Planning Commission (NPC) of Nepal?', 'options' => ['Finance Minister', 'Governor of NRB', 'Prime Minister', 'Vice-Chairman of NPC'], 'answer' => 2, 'explanation' => 'The Prime Minister of Nepal is the ex-officio Chairperson of the NPC.'],
            ['question' => 'What is the target year for Nepal to graduate from the Least Developed Country (LDC) category?', 'options' => ['2024', '2026', '2030', '2035'], 'answer' => 1, 'explanation' => 'Nepal is scheduled for graduation from LDC status by December 2026.'],
            ['question' => 'Which long-term vision document guides Nepal\'s periodic plans towards 2100 BS?', 'options' => ['Vision 2020', 'National Vision 2100 BS', 'SDG Roadmap 2030', 'Plan 2050'], 'answer' => 1, 'explanation' => 'The 25-year Long-term Vision 2100 BS sets targets for a high-income developed nation.'],
            ['question' => 'What is the annual economic growth (GDP) rate targeted by the 16th Periodic Plan?', 'options' => ['4.5%', '7.0% - 7.5%', '10.5%', '12.0%'], 'answer' => 1, 'explanation' => 'The 16th Plan targets an average economic growth rate of 7.0% to 7.5%.'],
            ['question' => 'What is the target for electricity generation capacity under recent medium-term energy plans?', 'options' => ['2,500 MW', '5,000 MW+', '1,000 MW', '3,000 MW'], 'answer' => 1, 'explanation' => 'Plans aim to exceed 5,000 MW to 10,000 MW generation capacity in the medium term.'],
            ['question' => 'Which institution in Nepal is responsible for approving the final draft of periodic plans?', 'options' => ['Parliament alone', 'National Development Council (Rashtriya Bikas Parishad)', 'Nepal Rastra Bank', 'Ministry of Finance'], 'answer' => 1, 'explanation' => 'The National Development Council approves the guidelines and draft periodic plans.'],
            ['question' => 'How many periodic plans (including 3-year interim plans) has Nepal completed to date?', 'options' => ['10', '12', '15', '18'], 'answer' => 2, 'explanation' => 'Nepal has implemented 15 periodic plans and is currently in the 16th Plan.'],
            ['question' => 'The concept of Gender Responsive Budgeting (GRB) was formally institutionalized in Nepal in which fiscal year?', 'options' => ['FY 2050/51', 'FY 2064/65', 'FY 2072/73', 'FY 2078/79'], 'answer' => 1, 'explanation' => 'Gender Responsive Budgeting was institutionalized starting FY 2064/65.'],
        ];
    }

    private static function qEconomicDrivers(): array
    {
        return [
            ['question' => 'What is the approximate contribution of the Agriculture sector to Nepal\'s GDP?', 'options' => ['10%', '24%', '50%', '65%'], 'answer' => 1, 'explanation' => 'Agriculture contributes approximately 24% to Nepal\'s Gross Domestic Product.'],
            ['question' => 'Approximately what percentage of Nepal\'s total labor force is employed in agriculture?', 'options' => ['20%', '40%', '60%+', '85%'], 'answer' => 2, 'explanation' => 'Over 60% of Nepal\'s population depends on agriculture for employment.'],
            ['question' => 'What is the approximate share of worker remittances in Nepal\'s national GDP?', 'options' => ['5%', '10%', '22% - 25%', '50%'], 'answer' => 2, 'explanation' => 'Remittances contribute between 22% to 25% of Nepal\'s GDP.'],
            ['question' => 'Where is Nepal\'s first Special Economic Zone (SEZ) located and operationalized?', 'options' => ['Biratnagar', 'Bhairahawa', 'Simara', 'Surkhet'], 'answer' => 1, 'explanation' => 'Bhairahawa SEZ in Rupandehi is Nepal\'s first operational Special Economic Zone.'],
            ['question' => 'Which cash crop is known as "Black Gold" in the eastern hilly districts of Nepal?', 'options' => ['Large Cardamom (Alainchi)', 'Ginger', 'Tea', 'Coffee'], 'answer' => 0, 'explanation' => 'Large cardamom (Alainchi) is prized as black gold due to high export earnings.'],
            ['question' => 'What is the full form of CTEVT, the apex body for technical vocational training in Nepal?', 'options' => ['Council for Technical Education and Vocational Training', 'Central Technical Education and Village Training', 'Committee for Technology and Education Vocational Trade', 'Center for Trade and Vocational Technology'], 'answer' => 0, 'explanation' => 'CTEVT stands for Council for Technical Education and Vocational Training.'],
            ['question' => 'Which international airport is the third international gateway operational in Nepal?', 'options' => ['TIA Kathmandu', 'Gautam Buddha International Airport (GBIA)', 'Pokhara International Airport (PIA)', 'Biratnagar Airport'], 'answer' => 2, 'explanation' => 'Pokhara International Airport is the 3rd international airport in Nepal.'],
            ['question' => 'What is the prime objective of the Prime Minister Employment Program (PMEP)?', 'options' => ['Providing 100 days of guaranteed wage employment to unemployed citizens', 'Free overseas work visas', 'Industrial subsidies', 'Higher education scholarships'], 'answer' => 0, 'explanation' => 'PMEP guarantees a minimum of 100 days of basic employment to listed unemployed citizens.'],
            ['question' => 'Which sector is considered the primary engine for industrial power transition in Nepal?', 'options' => ['Hydropower / Clean Energy', 'Coal mining', 'Diesel import', 'Handloom'], 'answer' => 0, 'explanation' => 'Clean hydropower is the critical foundation for replacing fossil fuels and industrial growth.'],
            ['question' => 'What is the main statutory regulatory body for insurance companies in Nepal?', 'options' => ['SEBON', 'Nepal Insurance Authority (Bima Pradhikaran)', 'Nepal Rastra Bank', 'Ministry of Industry'], 'answer' => 1, 'explanation' => 'Nepal Insurance Authority (formerly Bima Samiti) regulates the insurance sector.'],
        ];
    }

    private static function qEnergyResources(): array
    {
        return [
            ['question' => 'Who conducted the pioneer research estimating Nepal\'s theoretical hydropower potential at 83,000 MW?', 'options' => ['Dr. Hari Man Shrestha (1966)', 'Kul Man Ghising', 'Dr. Dilli Raman Regmi', 'B.P. Koirala'], 'answer' => 0, 'explanation' => 'Dr. Hari Man Shrestha calculated the 83,000 MW potential in his 1966 PhD thesis in Moscow.'],
            ['question' => 'What is the estimated technically and economically feasible hydropower potential of Nepal?', 'options' => ['20,000 MW', '42,000 MW', '83,000 MW', '100,000 MW'], 'answer' => 1, 'explanation' => 'Approximately 42,000 MW is considered economically and technically viable.'],
            ['question' => 'Which is the first hydropower plant constructed in Nepal (500 KW, 1968 BS)?', 'options' => ['Sundarijal', 'Pharping Hydropower', 'Panauti', 'Kulekhani'], 'answer' => 1, 'explanation' => 'Pharping (Chandrajyoti) was established in 1968 BS (1911 AD) with 500 KW capacity.'],
            ['question' => 'Which is the largest operational storage/reservoir hydropower project in Nepal?', 'options' => ['Kulekhani (I, II, III)', 'Kaligandaki A', 'Upper Tamakoshi', 'Marsyangdi'], 'answer' => 0, 'explanation' => 'Kulekhani reservoir project (total 106 MW) is Nepal\'s key storage project for peak winter load.'],
            ['question' => 'What is the generation capacity of Upper Tamakoshi Hydropower Project?', 'options' => ['144 MW', '456 MW', '60 MW', '700 MW'], 'answer' => 1, 'explanation' => 'Upper Tamakoshi located in Dolakha has a capacity of 456 MW (Peaking RoR).'],
            ['question' => 'What is the capacity of the grid-connected solar power project installed by NEA in Nuwakot?', 'options' => ['5 MW', '10 MW', '25 MW', '50 MW'], 'answer' => 2, 'explanation' => 'Nuwakot Solar Project built by NEA has a capacity of 25 MW.'],
            ['question' => 'On average, how many sunny days per year does Nepal enjoy for solar power harvesting?', 'options' => ['150 days', '200 days', '300 days', '365 days'], 'answer' => 2, 'explanation' => 'Nepal receives approximately 300 sunny days per year.'],
            ['question' => 'Which agency is responsible for promoting decentralized renewable energy (solar, mini-grid, biogas) in rural Nepal?', 'options' => ['AEPC (Alternative Energy Promotion Centre)', 'NOC', 'NTC', 'NEA alone'], 'answer' => 0, 'explanation' => 'AEPC promotes off-grid renewable energy technologies.'],
            ['question' => 'Which transmission voltage line connects Dhalkebar (Nepal) and Muzaffarpur (India) for cross-border power trade?', 'options' => ['66 kV', '132 kV', '220 kV', '400 kV'], 'answer' => 3, 'explanation' => 'The Dhalkebar-Muzaffarpur cross-border line operates at 400 kV.'],
            ['question' => 'What type of hydropower plant generates power directly from natural river flow without large seasonal water reservoirs?', 'options' => ['Run-of-River (RoR)', 'Reservoir / Storage', 'Nuclear', 'Pumped Storage'], 'answer' => 0, 'explanation' => 'Run-of-River (RoR) plants utilize the instantaneous river flow.'],
        ];
    }

    private static function qHydropowerNea(): array
    {
        return [
            ['question' => 'On which date was Nepal Electricity Authority (NEA) formally established?', 'options' => ['1984 Jan 1', '2041 Poush 1', '2042 Bhadra 1 (Aug 16, 1985)', '2046 Chaitra 30'], 'answer' => 2, 'explanation' => 'NEA was founded on Bhadra 1, 2042 BS by merging the Electricity Department and Corporation.'],
            ['question' => 'Who serves as the Member Secretary of the Board of Directors of NEA?', 'options' => ['Energy Secretary', 'Managing Director of NEA', 'Finance Joint Secretary', 'Auditor General'], 'answer' => 1, 'explanation' => 'The Managing Director (MD) of NEA acts as the Member Secretary of the Board.'],
            ['question' => 'What is the full form of IPP in the context of power generation in Nepal?', 'options' => ['Independent Power Producer', 'Integrated Power Plan', 'Internal Public Project', 'International Power Program'], 'answer' => 0, 'explanation' => 'IPP stands for Independent Power Producer.'],
            ['question' => 'What does PPA stand for in electricity transactions?', 'options' => ['Power Purchase Agreement', 'Public Policy Act', 'Power Project Allocation', 'Primary Power Authority'], 'answer' => 0, 'explanation' => 'PPA stands for Power Purchase Agreement between NEA and power generators.'],
            ['question' => 'Which independent commission regulates electricity tariffs and consumer standards in Nepal?', 'options' => ['SEBON', 'Electricity Regulatory Commission (ERC)', 'NEA Board', 'CIAA'], 'answer' => 1, 'explanation' => 'The Electricity Regulatory Commission (ERC) regulates tariffs and sector competition.'],
            ['question' => 'What model is commonly used where private developers build, operate, and transfer hydro projects to the government after 30-35 years?', 'options' => ['BOOT (Build-Own-Operate-Transfer)', 'Turnkey Contract', 'Outsourcing', 'Franchise'], 'answer' => 0, 'explanation' => 'BOOT is the standard concession framework for private hydro projects in Nepal.'],
            ['question' => 'Where is the National Load Dispatch Centre (NLDC) of NEA located?', 'options' => ['Ratnapark, Kathmandu', 'Siuchatar, Kathmandu', 'Bhaktapur', 'Hetauda'], 'answer' => 1, 'explanation' => 'The central NLDC for grid operations is located at Siuchatar, Kathmandu.'],
            ['question' => 'Which company is the electricity trading subsidiary established by NEA for national and cross-border power commerce?', 'options' => ['Nepal Power Exchange Ltd (NPEL)', 'NEA Engineering Company', 'Nepal Electricity Power Trading Company (NEPTC / PTCN)', 'Rastriya Prasaran Grid Company'], 'answer' => 2, 'explanation' => 'NEA formed PTCN/trading subsidiaries to engage in bilateral and regional electricity trade.'],
            ['question' => 'Nepal recently signed a tripartite agreement to export 40 MW of electricity to which third country via the Indian grid?', 'options' => ['Bhutan', 'Bangladesh', 'Sri Lanka', 'Maldives'], 'answer' => 1, 'explanation' => 'Nepal signed a historic tripartite deal to export 40 MW power to Bangladesh.'],
            ['question' => 'Approximately what percentage of grid-connected generation capacity in Nepal is contributed by private IPPs?', 'options' => ['10%', '25%', 'Over 60%', '95%'], 'answer' => 2, 'explanation' => 'Private IPPs now own and generate over 60% of Nepal\'s grid electricity.'],
        ];
    }

    private static function qSustainableDev(): array
    {
        return [
            ['question' => 'How many Sustainable Development Goals (SDGs) were adopted by the UN for the 2016-2030 agenda?', 'options' => ['8 Goals', '12 Goals', '17 Goals', '21 Goals'], 'answer' => 2, 'explanation' => 'The 2030 Agenda comprises 17 Sustainable Development Goals (SDGs) and 169 targets.'],
            ['question' => 'Which SDG goal specifically targets "Affordable and Clean Energy"?', 'options' => ['SDG 3', 'SDG 7', 'SDG 11', 'SDG 13'], 'answer' => 1, 'explanation' => 'SDG Goal 7 is dedicated to ensuring access to affordable, reliable, sustainable clean energy.'],
            ['question' => 'Which SDG goal focuses on "Climate Action"?', 'options' => ['SDG 6', 'SDG 9', 'SDG 13', 'SDG 15'], 'answer' => 2, 'explanation' => 'SDG 13 calls for urgent action to combat climate change and its impacts.'],
            ['question' => 'What does the acronym GLOF represent in Himalayan environmental studies?', 'options' => ['Global Land Organization Forum', 'Glacial Lake Outburst Flood', 'Geographical Level Overflow', 'Greenhouse Layer Ozone Factor'], 'answer' => 1, 'explanation' => 'GLOF stands for Glacial Lake Outburst Flood.'],
            ['question' => 'Which famous glacial lake in Dolakha district had its water level lowered to prevent catastrophic outburst?', 'options' => ['Rara Lake', 'Tsho Rolpa', 'Tilicho Lake', 'Phewa Lake'], 'answer' => 1, 'explanation' => 'Tsho Rolpa glacial lake was siphoned and controlled to reduce severe GLOF hazard.'],
            ['question' => 'What is the highest altitude lake in Nepal?', 'options' => ['Rara Lake', 'Tilicho Lake (4,919m) / Kajin Sara', 'Shey Phoksundo', 'Gosaikunda'], 'answer' => 1, 'explanation' => 'Tilicho Lake (4,919m) and Kajin Sara Lake in Manang are the highest altitude lakes.'],
            ['question' => 'What is the primary greenhouse gas emitted by fossil fuel combustion?', 'options' => ['Oxygen', 'Carbon Dioxide (CO2)', 'Argon', 'Nitrogen'], 'answer' => 1, 'explanation' => 'Carbon Dioxide (CO2) is the primary greenhouse gas contributing to global warming.'],
            ['question' => 'What is the target year set by Nepal in its NDC to achieve Net-Zero greenhouse gas emissions?', 'options' => ['2030', '2040', '2045', '2060'], 'answer' => 2, 'explanation' => 'Nepal committed to reaching Net-Zero greenhouse emissions by 2045.'],
            ['question' => 'What is the Ramsar Convention primarily dedicated to protecting?', 'options' => ['Mountain Peaks', 'Wetlands of International Importance', 'Forest Fire Control', 'Desertification'], 'answer' => 1, 'explanation' => 'The Ramsar Convention protects critical wetlands and waterfowl habitats.'],
            ['question' => 'How many wetlands in Nepal are listed as Ramsar Sites (e.g., Koshi Tappu, Gokyo, Rara, Mai Pokhari)?', 'options' => ['4', '7', '10', '15'], 'answer' => 2, 'explanation' => 'Nepal has 10 internationally designated Ramsar wetland sites.'],
        ];
    }

    private static function qPollutionControl(): array
    {
        return [
            ['question' => 'Under the Environment Protection Act 2076, what does EIA stand for?', 'options' => ['Environmental Impact Assessment', 'Energy Inspection Authority', 'Economic Improvement Agency', 'Ecological Integrity Act'], 'answer' => 0, 'explanation' => 'EIA stands for Environmental Impact Assessment.'],
            ['question' => 'What does IEE stand for in environmental project clearances in Nepal?', 'options' => ['Initial Environmental Examination', 'Internal Energy Evaluation', 'International Ecology Entry', 'Integrated Environmental Entity'], 'answer' => 0, 'explanation' => 'IEE stands for Initial Environmental Examination.'],
            ['question' => 'What minimum downstream environmental flow is typically required in river diversion hydro projects in Nepal?', 'options' => ['2%', '5%', '10%', '25%'], 'answer' => 2, 'explanation' => 'Guidelines mandate releasing at least 10% of minimum monthly river discharge downstream.'],
            ['question' => 'What is the target share of electric passenger vehicles sales in Nepal by 2030 under the NDC?', 'options' => ['25%', '50%', '90%', '100%'], 'answer' => 2, 'explanation' => 'Nepal\'s 2nd NDC targets 90% of private passenger vehicle sales to be electric by 2030.'],
            ['question' => 'Which air pollutant index measures particulate matter smaller than 2.5 microns?', 'options' => ['PM2.5', 'CO2 Index', 'UV Index', 'pH Index'], 'answer' => 0, 'explanation' => 'PM2.5 measures microscopic particulate matter deeply inhalable into the lungs.'],
            ['question' => 'What is the compensatory tree plantation ratio enforced when trees are felled for development projects in Nepal?', 'options' => ['1:1', '1:5', '1:10 (or 1:25 historically)', '1:50'], 'answer' => 2, 'explanation' => 'Regulations mandate planting and nurturing 10 (previously 25) saplings for every tree cut.'],
            ['question' => 'Which ministry is the apex government entity for environmental policies and climate change in Nepal?', 'options' => ['Ministry of Forests and Environment (MoFE)', 'Ministry of Energy', 'Ministry of Industry', 'Ministry of Home Affairs'], 'answer' => 0, 'explanation' => 'MoFE is responsible for national environmental protection and climate policies.'],
            ['question' => 'What is the international fund created under the UNFCCC to support developing nations in climate adaptation called?', 'options' => ['Green Climate Fund (GCF)', 'World Bank Trust', 'IMF Climate Facility', 'Asian Development Bank Fund'], 'answer' => 0, 'explanation' => 'The Green Climate Fund (GCF) provides climate mitigation and adaptation financing.'],
            ['question' => 'Which landmark international climate agreement was adopted in 2015 to limit global temperature rise below 1.5°C / 2°C?', 'options' => ['Kyoto Protocol', 'Paris Climate Agreement (COP21)', 'Montreal Protocol', 'Rio Declaration'], 'answer' => 1, 'explanation' => 'The Paris Climate Agreement was adopted at COP21 in Paris in 2015.'],
            ['question' => 'Which substance was phased out globally under the Montreal Protocol to protect the Ozone layer?', 'options' => ['Carbon dioxide', 'Chlorofluorocarbons (CFCs)', 'Nitrogen gas', 'Methane'], 'answer' => 1, 'explanation' => 'CFCs and ozone-depleting substances were regulated under the Montreal Protocol.'],
        ];
    }

    private static function qCurrentAffairs(): array
    {
        return [
            ['question' => 'Which literary award is considered the most prestigious annual prize for Nepali literature?', 'options' => ['Madan Puraskar', 'Sajha Puraskar', 'Gorkha Dakshina Bahu', 'Prabal Janasewa'], 'answer' => 0, 'explanation' => 'Madan Puraskar is the highest literary honor for outstanding books in Nepali.'],
            ['question' => 'Jagadamba Shree Puraskar is awarded for what achievement?', 'options' => ['Lifetime contribution to Nepali language, art, and literature', 'Best single novel', 'Science invention', 'Sports excellence'], 'answer' => 0, 'explanation' => 'Jagadamba Shree honors lifetime dedicated service to the Nepali language and culture.'],
            ['question' => 'What is the highest civilian state honor awarded by the President of Nepal?', 'options' => ['Nepal Ratna', 'Mahaujjwal Rastradeep', 'Suprabal Janasewashree', 'Gorkha Dakshin Bahu'], 'answer' => 0, 'explanation' => 'Nepal Ratna is the highest civilian decoration of Nepal.'],
            ['question' => 'In which sports discipline did Nepal qualify and play in the ICC T20 World Cups (2014 & 2024)?', 'options' => ['Football', 'Cricket', 'Volleyball', 'Basketball'], 'answer' => 1, 'explanation' => 'The National Cricket Team of Nepal competed in the 2014 and 2024 ICC Men\'s T20 World Cups.'],
            ['question' => 'What is the national sport of Nepal designated by the government in 2074 BS?', 'options' => ['Football', 'Dandi Biyo', 'Volleyball', 'Cricket'], 'answer' => 2, 'explanation' => 'Volleyball was officially declared the national sport of Nepal in Jestha 2074 BS.'],
            ['question' => 'Who is known as the "Mahakavi" (Great Poet) of Nepali literature?', 'options' => ['Bhanubhakta Acharya', 'Laxmi Prasad Devkota', 'Madhav Prasad Ghimire', 'Motiram Bhatta'], 'answer' => 1, 'explanation' => 'Laxmi Prasad Devkota is revered as Mahakavi (author of Muna Madan, Shakuntala).'],
            ['question' => 'Who is honored as the "Aadi Kavi" (First Poet) of Nepali literature for translating Ramayana into Nepali?', 'options' => ['Bhanubhakta Acharya', 'Laxmi Prasad Devkota', 'Lekhnath Paudyal', 'Balkrishna Sama'], 'answer' => 0, 'explanation' => 'Bhanubhakta Acharya translated the Ramayana into accessible rhythmic Nepali verse.'],
            ['question' => 'Who is known as the "Rashtrakavi" (National Poet) of Nepal?', 'options' => ['Madhav Prasad Ghimire', 'Bhairav Aryal', 'Parijat', 'Bhupi Sherchan'], 'answer' => 0, 'explanation' => 'Madhav Prasad Ghimire was bestowed the title of Rashtrakavi.'],
            ['question' => 'Which famous novel by Parijat won the Madan Puraskar in 2022 BS?', 'options' => ['Siris Ko Phool (The Blue Mimosa)', 'Muna Madan', 'Seto Bagh', 'Gauri'], 'answer' => 0, 'explanation' => 'Siris Ko Phool by female writer Parijat won the Madan Puraskar in 2022 BS.'],
            ['question' => 'What is the current base currency peg relationship between Nepalese Rupee (NPR) and Indian Rupee (INR)?', 'options' => ['100 INR = 160 NPR (Fixed Peg)', '100 INR = 150 NPR', '100 INR = 175 NPR', 'Floating market rate'], 'answer' => 0, 'explanation' => 'The Nepalese Rupee is pegged to the Indian Rupee at 1 INR = 1.60 NPR (100 INR = 160 NPR).'],
        ];
    }

    private static function qFederalism(): array
    {
        return [
            ['question' => 'How many Provinces are established in Nepal under the Constitution of Nepal 2072?', 'options' => ['5 Provinces', '7 Provinces', '9 Provinces', '14 Provinces'], 'answer' => 1, 'explanation' => 'The Constitution established 7 federal provinces.'],
            ['question' => 'How many total Local Levels (Sthaniya Tah) exist in Nepal?', 'options' => ['500', '753', '777', '1,000'], 'answer' => 1, 'explanation' => 'Nepal has exactly 753 local level local governments.'],
            ['question' => 'How many Metropolitan Cities (Mahanagarpalika) are there in Nepal?', 'options' => ['4', '6', '11', '14'], 'answer' => 1, 'explanation' => 'Nepal has 6 Metropolitan Cities (Kathmandu, Lalitpur, Pokhara, Bharatpur, Biratnagar, Birgunj).'],
            ['question' => 'How many Sub-Metropolitan Cities (Upa-Mahanagarpalika) are in Nepal?', 'options' => ['8', '11', '15', '22'], 'answer' => 1, 'explanation' => 'There are 11 Sub-Metropolitan Cities.'],
            ['question' => 'How many total Municipalities (Nagarpalika) are in Nepal?', 'options' => ['276', '460', '753', '300'], 'answer' => 0, 'explanation' => 'Nepal has 276 urban Municipalities (Nagarpalika).'],
            ['question' => 'How many Rural Municipalities (Gaunpalika) are there in Nepal?', 'options' => ['276', '460', '500', '753'], 'answer' => 1, 'explanation' => 'Nepal has 460 Rural Municipalities (Gaunpalika).'],
            ['question' => 'How many total wards are there across all 753 local levels in Nepal?', 'options' => ['3,500', '5,200', '6,743', '7,530'], 'answer' => 2, 'explanation' => 'There are 6,743 ward units in Nepal.'],
            ['question' => 'Which Article of the Constitution defines the principles of inter-governmental relations in Nepal?', 'options' => ['Article 56', 'Article 100', 'Article 232', 'Article 300'], 'answer' => 2, 'explanation' => 'Article 232 specifies relations based on Cooperation, Co-existence, and Coordination.'],
            ['question' => 'Which council headed by the Prime Minister resolves political disputes between Federation and Provinces?', 'options' => ['Inter-Provincial Council (Article 234)', 'Judicial Council', 'Constitutional Council', 'National Security Council'], 'answer' => 0, 'explanation' => 'Article 234 establishes the Inter-Provincial Council.'],
            ['question' => 'Which constitutional commission recommends equalisation grants and revenue distribution among the three tiers?', 'options' => ['National Natural Resources and Fiscal Commission (NNRFC)', 'Auditor General', 'Public Service Commission', 'Election Commission'], 'answer' => 0, 'explanation' => 'NNRFC (Part 26, Article 250) determines inter-governmental fiscal transfers.'],
        ];
    }

    private static function qInclusion(): array
    {
        return [
            ['question' => 'Which Article of the Constitution of Nepal guarantees the "Right to Social Justice"?', 'options' => ['Article 18', 'Article 24', 'Article 42', 'Article 48'], 'answer' => 2, 'explanation' => 'Article 42 guarantees the Right to Social Justice based on proportional inclusion.'],
            ['question' => 'What percentage of civil service/public enterprise open vacancy seats is reserved for inclusion groups in Nepal?', 'options' => ['33%', '45%', '50%', '55%'], 'answer' => 1, 'explanation' => '45% of total vacant seats are reserved for targeted inclusive clusters.'],
            ['question' => 'Out of the 45% reserved quota in public employment, what percentage is allocated for women?', 'options' => ['22%', '27%', '33%', '50%'], 'answer' => 2, 'explanation' => '33% of the reserved quota is strictly earmarked for women.'],
            ['question' => 'What percentage is allocated to Adivasi Janajati from the reserved cluster?', 'options' => ['15%', '22%', '27%', '33%'], 'answer' => 2, 'explanation' => '27% of the reserved quota is allocated to Adivasi Janajati.'],
            ['question' => 'What percentage is allocated to Madhesi cluster from the 45% reservation?', 'options' => ['10%', '22%', '27%', '33%'], 'answer' => 1, 'explanation' => '22% is allocated to the Madhesi cluster.'],
            ['question' => 'What percentage of the reserved quota is allocated to Dalit candidates?', 'options' => ['5%', '9%', '15%', '20%'], 'answer' => 1, 'explanation' => '9% is allocated to Dalit candidates.'],
            ['question' => 'Which electoral system combines First-Past-The-Post (FPTP) and Proportional Representation (PR) in Nepal?', 'options' => ['Parallel Mixed Electoral System', 'Single Transferable Vote', 'Majority Runoff', 'Pure Proportional System'], 'answer' => 0, 'explanation' => 'Nepal uses a Mixed Electoral System (60% FPTP and 40% PR in House of Representatives).'],
            ['question' => 'What minimum percentage of women representation is constitutionally mandated in Federal and Provincial Parliaments?', 'options' => ['25%', '33% (One-third)', '40%', '50%'], 'answer' => 1, 'explanation' => 'The Constitution mandates at least 33% female representation in federal and provincial legislatures.'],
            ['question' => 'Which commission was established to protect the rights and identity of Indigenous Nationalities in Nepal?', 'options' => ['National Women Commission', 'National Inclusion Commission', 'Indigenous Nationalities Commission', 'Tharu Commission'], 'answer' => 2, 'explanation' => 'The Indigenous Nationalities Commission is a constitutional body under Part 27.'],
            ['question' => 'Which Article of the Constitution prohibits untouchability and caste discrimination in public and private life?', 'options' => ['Article 16', 'Article 24', 'Article 32', 'Article 40'], 'answer' => 1, 'explanation' => 'Article 24 prohibits untouchability and caste-based discrimination.'],
        ];
    }

    private static function qConstitutionFeatures(): array
    {
        return [
            ['question' => 'On which exact date was the Constitution of Nepal 2072 promulgated?', 'options' => ['2072 Bhadra 1', '2072 Ashwin 3 (Sept 20, 2015)', '2072 Kartik 1', '2073 Baishakh 1'], 'answer' => 1, 'explanation' => 'Promulgated on Ashwin 3, 2072 BS by President Dr. Ram Baran Yadav on behalf of the Constituent Assembly.'],
            ['question' => 'How many Parts, Articles, and Schedules are in the Constitution of Nepal?', 'options' => ['25 Parts, 200 Articles, 5 Schedules', '35 Parts, 308 Articles, 9 Schedules', '30 Parts, 250 Articles, 7 Schedules', '38 Parts, 320 Articles, 10 Schedules'], 'answer' => 1, 'explanation' => 'The constitution consists of 35 Parts, 308 Articles, and 9 Schedules.'],
            ['question' => 'According to Article 1 of the Constitution, what is the fundamental law of the land?', 'options' => ['Act of Parliament', 'The Constitution itself', 'Supreme Court Precedent', 'Civil Code'], 'answer' => 1, 'explanation' => 'The Constitution is the fundamental law; inconsistent laws are void.'],
            ['question' => 'Where is state sovereignty vested under Article 2 of the Constitution of Nepal?', 'options' => ['In the President', 'In the Prime Minister', 'In the Nepali People', 'In Parliament'], 'answer' => 2, 'explanation' => 'Article 2 vests sovereignty and state power inherently in the Nepali people.'],
            ['question' => 'What is the form of government established under Article 74 of the Constitution?', 'options' => ['Presidential system', 'Multi-party, competitive federal democratic republican parliamentary system', 'Monarchical system', 'Unitary assembly system'], 'answer' => 1, 'explanation' => 'Article 74 establishes a parliamentary system based on pluralism and competitive multi-party democracy.'],
            ['question' => 'How many members make up the House of Representatives (Pratinidhi Sabha) in Federal Parliament?', 'options' => ['205', '240', '275 (165 FPTP + 110 PR)', '334'], 'answer' => 2, 'explanation' => 'The House of Representatives has 275 members (165 elected via FPTP, 110 via PR).'],
            ['question' => 'How many members comprise the National Assembly (Rastriya Sabha)?', 'options' => ['50', '59 (56 elected from 7 provinces + 3 nominated by President)', '65', '75'], 'answer' => 1, 'explanation' => 'National Assembly consists of 59 members.'],
            ['question' => 'What is the total strength of the Federal Parliament of Nepal (Lower + Upper House)?', 'options' => ['275', '334 (275 + 59)', '601', '350'], 'answer' => 1, 'explanation' => 'Total Federal Parliament membership is 334 (275 + 59).'],
            ['question' => 'Which special bench in the Supreme Court is created under Article 137 to adjudicate constitutional disputes?', 'options' => ['Full Bench', 'Constitutional Bench', 'Commercial Bench', 'Administrative Bench'], 'answer' => 1, 'explanation' => 'The Constitutional Bench comprises the Chief Justice and 4 senior judges.'],
            ['question' => 'What majority in both houses of Federal Parliament is required to amend the Constitution (Article 274)?', 'options' => ['Simple majority', 'Two-thirds (2/3rd) majority of total existing members', 'Three-fourths majority', 'Unanimous vote'], 'answer' => 1, 'explanation' => 'Article 274 requires a two-thirds majority in each house to pass constitutional amendments.'],
        ];
    }

    private static function qPart1Preliminary(): array
    {
        return [
            ['question' => 'Which Article of the Constitution defines the State of Nepal?', 'options' => ['Article 1', 'Article 2', 'Article 4', 'Article 7'], 'answer' => 2, 'explanation' => 'Article 4 defines Nepal as an independent, indivisible, sovereign, secular, federal democratic republican state.'],
            ['question' => 'According to Article 6, what are the languages of the nation in Nepal?', 'options' => ['Only Nepali', 'Nepali and English', 'All mother tongues spoken in Nepal', 'Sanskrit and Nepali'], 'answer' => 2, 'explanation' => 'Article 6 states all mother tongues spoken in Nepal are the languages of the nation.'],
            ['question' => 'Which language and script is designated as the official working language of the Federal Government (Article 7)?', 'options' => ['Nepali language in Devanagari script', 'Nepali and Maithili', 'Nepali and English', 'Roman Nepali'], 'answer' => 0, 'explanation' => 'Article 7(1) specifies Nepali in Devanagari script as the official language.'],
            ['question' => 'Which Schedule of the Constitution provides the mathematical and geometric specifications of the National Flag?', 'options' => ['Schedule 1', 'Schedule 2', 'Schedule 3', 'Schedule 4'], 'answer' => 0, 'explanation' => 'Schedule 1 details the geometry and proportions of the National Flag.'],
            ['question' => 'Which Schedule contains the lyrics and notation of the National Anthem of Nepal?', 'options' => ['Schedule 1', 'Schedule 2', 'Schedule 3', 'Schedule 5'], 'answer' => 1, 'explanation' => 'Schedule 2 contains the National Anthem text.'],
            ['question' => 'Who wrote the lyrics of the current National Anthem ("Sayaun Thunga Phool Ka...")?', 'options' => ['Amber Gurung', 'Byakul Maila (Pradeep Kumar Rai)', 'Madhav Ghimire', 'Laxmi Prasad Devkota'], 'answer' => 1, 'explanation' => 'Byakul Maila penned the lyrics; music was composed by late Amber Gurung.'],
            ['question' => 'What is the national animal of Nepal according to Article 9?', 'options' => ['Rhino', 'Cow (Gai)', 'Snow Leopard', 'Tiger'], 'answer' => 1, 'explanation' => 'The Cow (Gai) is declared the national animal.'],
            ['question' => 'What is the national color of Nepal mentioned in the Constitution?', 'options' => ['Crimson (Simrik)', 'Navy Blue', 'Golden Yellow', 'Green'], 'answer' => 0, 'explanation' => 'Crimson (Simrik) is the official national color.'],
            ['question' => 'Which Article declares matters of national interest including sovereignty, territorial integrity, and prosperity?', 'options' => ['Article 3', 'Article 5', 'Article 8', 'Article 10'], 'answer' => 1, 'explanation' => 'Article 5 lists the core components of national interest.'],
            ['question' => 'Which part of the Constitution deals with Citizenship provisions (Articles 10 to 15)?', 'options' => ['Part 1', 'Part 2', 'Part 3', 'Part 4'], 'answer' => 1, 'explanation' => 'Part 2 contains citizenship provisions (Citizenship by descent, naturalization, non-resident citizenship).'],
        ];
    }

    private static function qFundamentalRights(): array
    {
        return [
            ['question' => 'How many Fundamental Rights are guaranteed in Part 3 of the Constitution of Nepal?', 'options' => ['21', '25', '31', '35'], 'answer' => 2, 'explanation' => 'There are 31 Fundamental Rights provided from Article 16 to Article 46.'],
            ['question' => 'Which Article guarantees the "Right to live with dignity"?', 'options' => ['Article 16', 'Article 17', 'Article 18', 'Article 20'], 'answer' => 0, 'explanation' => 'Article 16 guarantees the right to live with dignity (no death penalty allowed).'],
            ['question' => 'Which Article protects the "Right to Freedom" including expression, movement, and assembly?', 'options' => ['Article 16', 'Article 17', 'Article 19', 'Article 25'], 'answer' => 1, 'explanation' => 'Article 17 outlines the fundamental freedoms.'],
            ['question' => 'Which Article guarantees the "Right to Information" from public bodies?', 'options' => ['Article 19', 'Article 27', 'Article 30', 'Article 33'], 'answer' => 1, 'explanation' => 'Article 27 provides every citizen the right to demand and receive information on public matters.'],
            ['question' => 'Which Article protects the "Right to Clean Environment"?', 'options' => ['Article 25', 'Article 30', 'Article 35', 'Article 44'], 'answer' => 1, 'explanation' => 'Article 30 guarantees the right to a clean and healthy environment with victim compensation.'],
            ['question' => 'Under Article 31, basic education is constitutionally declared to be:', 'options' => ['Optional and paid', 'Compulsory and free', 'Privatized', 'Higher level only'], 'answer' => 1, 'explanation' => 'Basic education is compulsory and free; secondary education is free.'],
            ['question' => 'Which Article provides the "Right of the Consumer" to quality goods, services, and compensation for damages?', 'options' => ['Article 36', 'Article 40', 'Article 44', 'Article 46'], 'answer' => 2, 'explanation' => 'Article 44 guarantees consumer rights to quality supplies and compensation.'],
            ['question' => 'Which Article guarantees the "Right to Constitutional Remedies" via writ petitions?', 'options' => ['Article 46', 'Article 48', 'Article 50', 'Article 55'], 'answer' => 0, 'explanation' => 'Article 46 provides constitutional remedies through Supreme Court (Art 133) and High Court (Art 144).'],
            ['question' => 'Which writ is issued to produce a person unlawfully detained before the court?', 'options' => ['Mandamus', 'Habeas Corpus (Bandi Pratyakshikaran)', 'Quo Warranto', 'Prohibition'], 'answer' => 1, 'explanation' => 'Habeas Corpus is issued to release an illegally detained person.'],
            ['question' => 'Which Article specifies the fundamental "Duties of Citizens"?', 'options' => ['Article 45', 'Article 48', 'Article 52', 'Article 54'], 'answer' => 1, 'explanation' => 'Article 48 outlines 4 key duties of citizens.'],
        ];
    }

    private static function qDirectivePrinciples(): array
    {
        return [
            ['question' => 'Which Part of the Constitution sets out Directive Principles, Policies, and Obligations of the State?', 'options' => ['Part 2', 'Part 3', 'Part 4 (Articles 49-55)', 'Part 5'], 'answer' => 2, 'explanation' => 'Part 4 covers Directive Principles, Policies, and Obligations.'],
            ['question' => 'Can provisions contained in Part 4 (Directive Principles) be enforced or challenged directly in a court of law (Article 55)?', 'options' => ['Yes, fully justiciable like fundamental rights', 'No question shall be raised in any court (non-justiciable)', 'Only with Prime Minister\'s permission', 'Only in the Supreme Court full bench'], 'answer' => 1, 'explanation' => 'Article 55 states Part 4 provisions are non-justiciable in court.'],
            ['question' => 'Which Article lays down the overarching Directive Principles of the State (Political, Socio-cultural, Economic & International)?', 'options' => ['Article 49', 'Article 50', 'Article 51', 'Article 53'], 'answer' => 1, 'explanation' => 'Article 50 defines the 4 core directive principles.'],
            ['question' => 'How many broad areas of State Policies are outlined under Article 51 of the Constitution?', 'options' => ['6 categories', '10 categories', '13 categories (Clause a to m)', '20 categories'], 'answer' => 2, 'explanation' => 'Article 51 contains 13 sub-clauses covering state policies.'],
            ['question' => 'Under Article 51(g), what is the priority for developing energy and water resources in Nepal?', 'options' => ['Exclusive foreign privatization', 'Priority to domestic investment, multi-purpose river planning, and environmental conservation', 'Banning all hydropower', 'Exporting all energy without domestic electrification'], 'answer' => 1, 'explanation' => 'Article 51(g) mandates prioritizing domestic investment and sustainable conservation.'],
            ['question' => 'Which Article outlines the general Responsibilities and Obligations of the State?', 'options' => ['Article 48', 'Article 50', 'Article 52', 'Article 55'], 'answer' => 2, 'explanation' => 'Article 52 defines the state\'s fundamental obligations.'],
            ['question' => 'To whom does the Government of Nepal submit its annual report regarding the implementation of Directive Principles (Article 53)?', 'options' => ['To the President of Nepal', 'To the Chief Justice', 'To the Federal Parliament Speaker alone', 'To the President, who causes it to be submitted to Parliament'], 'answer' => 3, 'explanation' => 'Article 53 requires submitting the report to the President, which is placed before Parliament.'],
            ['question' => 'Under Article 54, what parliamentary mechanism monitors the progressive realization of Part 4 provisions?', 'options' => ['A dedicated Joint Parliamentary Committee', 'Public Accounts Committee alone', 'Judicial Council', 'CIAA'], 'answer' => 0, 'explanation' => 'Article 54 provides for a joint committee of Parliament to monitor implementation.'],
            ['question' => 'What is the constitutional economic policy model promoted under Article 50 and 51?', 'options' => ['Pure free market without state intervention', 'Three-pillar economy (Public, Private, and Cooperatives)', 'Centrally planned command economy', 'Strict feudal monopoly'], 'answer' => 1, 'explanation' => 'Nepal\'s constitution promotes a three-pillar economic model (Public, Private, Cooperative).'],
            ['question' => 'What principle guides Nepal\'s international relations under Article 50(4)?', 'options' => ['Military alliance', 'UN Charter, Non-alignment, Panchasheel, international law, and world peace', 'Expansionism', 'Isolationism'], 'answer' => 1, 'explanation' => 'Foreign policy is guided by Panchasheel, non-alignment, and the UN Charter.'],
        ];
    }

    private static function qConstitutionalOrgans(): array
    {
        return [
            ['question' => 'Which Part of the Constitution provides for the Commission for the Investigation of Abuse of Authority (CIAA)?', 'options' => ['Part 19', 'Part 21 (Articles 238-239)', 'Part 22', 'Part 23'], 'answer' => 1, 'explanation' => 'Part 21 covers CIAA composition and investigatory powers.'],
            ['question' => 'What is the tenure of the Chief Commissioner and Commissioners of CIAA?', 'options' => ['4 years', '5 years', '6 years', '7 years'], 'answer' => 2, 'explanation' => 'The term of office is 6 years from appointment date (max age limit: 65).'],
            ['question' => 'Which Article mandates the Auditor General to audit accounts of Public Enterprises like NEA?', 'options' => ['Article 239', 'Article 241', 'Article 243', 'Article 246'], 'answer' => 1, 'explanation' => 'Article 241 mandates the Auditor General to audit government offices and 50%+ state-owned entities.'],
            ['question' => 'Which Part establishes the Public Service Commission (Lok Sewa Aayog)?', 'options' => ['Part 20', 'Part 21', 'Part 23 (Articles 242-244)', 'Part 25'], 'answer' => 2, 'explanation' => 'Part 23 governs the Public Service Commission.'],
            ['question' => 'Which body is constitutionally required to conduct written examinations for recruitment in Public Enterprises like NEA?', 'options' => ['Ministry of Energy', 'Public Service Commission (Lok Sewa Aayog)', 'Private Agency', 'Trade Union'], 'answer' => 1, 'explanation' => 'Article 243 mandates PSC to conduct recruitment examinations for public enterprises.'],
            ['question' => 'Which Part establishes the Election Commission of Nepal?', 'options' => ['Part 22', 'Part 24 (Articles 245-247)', 'Part 26', 'Part 28'], 'answer' => 1, 'explanation' => 'Part 24 governs the Election Commission.'],
            ['question' => 'Which Part establishes the National Human Rights Commission (NHRC)?', 'options' => ['Part 21', 'Part 24', 'Part 26 (Articles 248-249)', 'Part 27'], 'answer' => 2, 'explanation' => 'Part 26 establishes NHRC.'],
            ['question' => 'Who heads the Constitutional Council that recommends heads of constitutional organs in Nepal?', 'options' => ['President of Nepal', 'Prime Minister', 'Chief Justice', 'Speaker of House of Representatives'], 'answer' => 1, 'explanation' => 'Article 284 establishes the Constitutional Council headed by the Prime Minister.'],
            ['question' => 'Constitutional body heads can be removed from office prior to tenure expiry through which process?', 'options' => ['Impeachment (Mahabhiyog) passed by 2/3rd majority in House of Representatives', 'Simple cabinet decision', 'Presidential decree alone', 'Supreme Court administrative order'], 'answer' => 0, 'explanation' => 'Article 101 provides for impeachment by a two-thirds majority in the House of Representatives.'],
            ['question' => 'To whom does the Auditor General submit the annual national audit report?', 'options' => ['Directly to the President of Nepal', 'To the Prime Minister', 'To the Chief Justice', 'To the CIAA'], 'answer' => 0, 'explanation' => 'The Auditor General submits the annual report to the President under Article 241.'],
        ];
    }

    private static function qSchedules(): array
    {
        return [
            ['question' => 'How many Schedules are attached to the Constitution of Nepal?', 'options' => ['5', '7', '9', '12'], 'answer' => 2, 'explanation' => 'There are 9 Schedules defining state symbols and power divisions.'],
            ['question' => 'Which Schedule contains the exclusive legislative and executive powers of the Federal Government (35 subjects)?', 'options' => ['Schedule 4', 'Schedule 5', 'Schedule 6', 'Schedule 7'], 'answer' => 1, 'explanation' => 'Schedule 5 lists the 35 exclusive federal powers.'],
            ['question' => 'Which Schedule lists the 21 exclusive powers of Provincial Governments?', 'options' => ['Schedule 5', 'Schedule 6', 'Schedule 7', 'Schedule 8'], 'answer' => 1, 'explanation' => 'Schedule 6 contains the 21 exclusive provincial matters.'],
            ['question' => 'Which Schedule lists the Concurrent Powers of the Federation and Province (25 subjects)?', 'options' => ['Schedule 5', 'Schedule 6', 'Schedule 7', 'Schedule 9'], 'answer' => 2, 'explanation' => 'Schedule 7 details the concurrent federal-provincial powers.'],
            ['question' => 'Which Schedule lists the 22 exclusive powers of Local Governments (Municipalities/Rural Municipalities)?', 'options' => ['Schedule 6', 'Schedule 7', 'Schedule 8', 'Schedule 9'], 'answer' => 2, 'explanation' => 'Schedule 8 details local government exclusive powers.'],
            ['question' => 'Which Schedule lists the Concurrent Powers of Federation, Province, and Local Level (15 subjects)?', 'options' => ['Schedule 5', 'Schedule 7', 'Schedule 8', 'Schedule 9'], 'answer' => 3, 'explanation' => 'Schedule 9 lists the 15 concurrent subjects among all three levels.'],
            ['question' => 'Which Schedule lists the names of Districts grouped under each of the 7 Provinces?', 'options' => ['Schedule 2', 'Schedule 3', 'Schedule 4', 'Schedule 5'], 'answer' => 2, 'explanation' => 'Schedule 4 lists the districts in each province.'],
            ['question' => 'Mega transmission electricity grids and central power generation fall under which Schedule?', 'options' => ['Schedule 5 (Federal List)', 'Schedule 6 (Provincial List)', 'Schedule 8 (Local List)', 'Schedule 4'], 'answer' => 0, 'explanation' => 'Mega power and high-voltage transmission networks fall under Schedule 5.'],
            ['question' => 'Micro-hydro projects and local electricity distribution services fall under which Schedule?', 'options' => ['Schedule 5', 'Schedule 6', 'Schedule 8 (Local Level List)', 'Schedule 1'], 'answer' => 2, 'explanation' => 'Micro-hydro and local distribution are listed in Schedule 8.'],
            ['question' => 'In case of a conflict between a Federal law and a Provincial law on a Schedule 7 concurrent matter, which law prevails?', 'options' => ['Provincial Law', 'Federal Law (to the extent of inconsistency)', 'Both are cancelled', 'Local Law'], 'answer' => 1, 'explanation' => 'Article 57(5) states Federal law prevails over inconsistent provincial/local laws.'],
        ];
    }

    private static function qUnitaryMethod(): array
    {
        return [
            ['question' => 'If 15 energy meters cost Rs. 45,000, what is the cost of 24 energy meters?', 'options' => ['Rs. 60,000', 'Rs. 72,000', 'Rs. 80,000', 'Rs. 90,000'], 'answer' => 1, 'explanation' => 'Unit cost = 45,000 / 15 = Rs. 3,000. For 24 meters = 24 * 3,000 = Rs. 72,000.'],
            ['question' => 'If 8 technicians can install a transmission section in 12 days, how many days will 6 technicians take?', 'options' => ['14 days', '16 days', '18 days', '20 days'], 'answer' => 1, 'explanation' => 'Total work = 8 * 12 = 96 worker-days. Days for 6 technicians = 96 / 6 = 16 days.'],
            ['question' => 'If 5 office clerks can type 100 documents in 4 hours, how many documents can 8 clerks type in 4 hours?', 'options' => ['120', '140', '160', '200'], 'answer' => 2, 'explanation' => '1 clerk types 100 / 5 = 20 documents. 8 clerks type 8 * 20 = 160 documents.'],
            ['question' => 'A vehicle consumes 12 liters of petrol to travel 180 km. How many liters are needed for 300 km?', 'options' => ['18 liters', '20 liters', '22 liters', '25 liters'], 'answer' => 1, 'explanation' => 'Mileage = 180 / 12 = 15 km/liter. Petrol for 300 km = 300 / 15 = 20 liters.'],
            ['question' => 'If 20 workers build a wall in 15 days, how many extra workers are required to complete it in 10 days?', 'options' => ['5 workers', '10 workers', '15 workers', '30 workers'], 'answer' => 1, 'explanation' => 'Total worker-days = 20 * 15 = 300. Workers needed for 10 days = 300 / 10 = 30. Extra needed = 30 - 20 = 10.'],
            ['question' => 'If 3 machines produce 450 electrical switches in 5 hours, how many switches will 1 machine produce in 1 hour?', 'options' => ['15', '25', '30', '45'], 'answer' => 2, 'explanation' => 'Output per machine in 5 hrs = 450 / 3 = 150. Output per machine in 1 hr = 150 / 5 = 30.'],
            ['question' => 'If the monthly electricity bill for 250 units is Rs. 2,250, what is the cost of 400 units at the same uniform rate?', 'options' => ['Rs. 3,200', 'Rs. 3,600', 'Rs. 4,000', 'Rs. 4,200'], 'answer' => 1, 'explanation' => 'Rate per unit = 2,250 / 250 = Rs. 9. For 400 units = 400 * 9 = Rs. 3,600.'],
            ['question' => 'If 12 men or 18 women can do a piece of work in 14 days, in how many days can 8 men and 16 women do it?', 'options' => ['7 days', '9 days', '10 days', '12 days'], 'answer' => 1, 'explanation' => '12 Men = 18 Women => 1 Man = 1.5 Women. 8 Men + 16 Women = 12 + 16 = 28 Women. Days = (18 * 14) / 28 = 9 days.'],
            ['question' => 'A pipe fills a reservoir tank in 6 hours. What fraction of the tank does it fill in 2 hours?', 'options' => ['1/2', '1/3', '1/4', '2/5'], 'answer' => 1, 'explanation' => 'Fraction filled in 2 hours = 2 / 6 = 1/3.'],
            ['question' => 'If 10 men take 20 days to complete a job working 6 hours a day, how many days will 15 men take working 8 hours a day?', 'options' => ['8 days', '10 days', '12 days', '15 days'], 'answer' => 1, 'explanation' => 'Total man-hours = 10 * 20 * 6 = 1200. Days = 1200 / (15 * 8) = 1200 / 120 = 10 days.'],
        ];
    }

    private static function qPercentages(): array
    {
        return [
            ['question' => 'What is 35% of Rs. 80,000?', 'options' => ['Rs. 24,000', 'Rs. 28,000', 'Rs. 30,000', 'Rs. 32,000'], 'answer' => 1, 'explanation' => '35% of 80,000 = (35/100) * 80,000 = Rs. 28,000.'],
            ['question' => 'Convert the fraction 3/8 into a percentage:', 'options' => ['30.5%', '37.5%', '42.5%', '45.0%'], 'answer' => 1, 'explanation' => '(3/8) * 100% = 37.5%.'],
            ['question' => 'If a quantity increases from 400 to 500, what is the percentage increase?', 'options' => ['20%', '25%', '30%', '50%'], 'answer' => 1, 'explanation' => 'Increase = 100. Percentage increase = (100 / 400) * 100% = 25%.'],
            ['question' => 'If an employee salary of Rs. 40,000 is increased by 15%, what is the new salary?', 'options' => ['Rs. 44,000', 'Rs. 46,000', 'Rs. 48,000', 'Rs. 50,000'], 'answer' => 1, 'explanation' => 'New salary = 40,000 * 1.15 = Rs. 46,000.'],
            ['question' => 'What percentage of 2.5 kg is 250 grams?', 'options' => ['5%', '10%', '15%', '25%'], 'answer' => 1, 'explanation' => '2.5 kg = 2,500g. (250 / 2,500) * 100% = 10%.'],
            ['question' => 'If 20% of a number is 160, what is the original number?', 'options' => ['640', '800', '900', '1,000'], 'answer' => 1, 'explanation' => 'Number = 160 / 0.20 = 800.'],
            ['question' => 'Simplify the fraction addition: 1/4 + 2/3 = ?', 'options' => ['3/7', '7/12', '11/12', '5/12'], 'answer' => 2, 'explanation' => 'LCM = 12. (3 + 8)/12 = 11/12.'],
            ['question' => 'Subtract 3/5 from 7/10: 7/10 - 3/5 = ?', 'options' => ['1/10', '2/5', '4/5', '1/2'], 'answer' => 0, 'explanation' => '7/10 - 6/10 = 1/10.'],
            ['question' => 'In an office of 120 employees, 45% are female. How many male employees work there?', 'options' => ['54', '66', '70', '72'], 'answer' => 1, 'explanation' => 'Male % = 55%. Males = 0.55 * 120 = 66.'],
            ['question' => 'If the price of electricity is reduced by 10% and consumption increases by 10%, what is the net revenue change?', 'options' => ['No change', '1% decrease', '1% increase', '2% decrease'], 'answer' => 1, 'explanation' => 'Net change = (-10 + 10 - (10*10)/100)% = -1% (1% decrease).'],
        ];
    }

    private static function qAverages(): array
    {
        return [
            ['question' => 'Find the average of the numbers: 12, 18, 24, 30, and 36:', 'options' => ['22', '24', '26', '28'], 'answer' => 1, 'explanation' => 'Sum = 120. Average = 120 / 5 = 24.'],
            ['question' => 'The average of 6 numbers is 25. If one number is excluded, the average becomes 22. What was the excluded number?', 'options' => ['35', '40', '42', '45'], 'answer' => 1, 'explanation' => 'Total of 6 = 150. Total of 5 = 110. Excluded number = 150 - 110 = 40.'],
            ['question' => 'The average monthly salary of 10 employees is Rs. 30,000. When the officer\'s salary is added, the average becomes Rs. 33,000. What is the officer\'s salary?', 'options' => ['Rs. 50,000', 'Rs. 60,000', 'Rs. 63,000', 'Rs. 70,000'], 'answer' => 2, 'explanation' => 'Total 10 = 300,000. Total 11 = 363,000. Officer salary = 363,000 - 300,000 = Rs. 63,000.'],
            ['question' => 'The average of first 50 natural numbers (1, 2, 3, ... 50) is:', 'options' => ['25.0', '25.5', '26.0', '50.0'], 'answer' => 1, 'explanation' => 'Average = (n + 1) / 2 = 51 / 2 = 25.5.'],
            ['question' => 'A batsman scores 45, 62, 78, 85, and 0 in 5 innings. What is his batting average?', 'options' => ['54', '67.5', '50', '60'], 'answer' => 0, 'explanation' => 'Sum = 270. Average = 270 / 5 = 54.'],
            ['question' => 'Find the average of all prime numbers between 10 and 25 (11, 13, 17, 19, 23):', 'options' => ['15.4', '16.6', '17.0', '18.2'], 'answer' => 1, 'explanation' => 'Sum = 11 + 13 + 17 + 19 + 23 = 83. Average = 83 / 5 = 16.6.'],
            ['question' => 'In a class of 30 boys and 20 girls, average weight of boys is 50 kg and girls is 40 kg. What is the class average weight?', 'options' => ['44 kg', '45 kg', '46 kg', '48 kg'], 'answer' => 2, 'explanation' => 'Total weight = (30 * 50) + (20 * 40) = 1500 + 800 = 2300 kg. Average = 2300 / 50 = 46 kg.'],
            ['question' => 'The average age of 4 family members is 28 years. If a child aged 3 is added, what is the new average age?', 'options' => ['21 years', '23 years', '25 years', '26 years'], 'answer' => 1, 'explanation' => 'Sum = 4 * 28 = 112. New sum = 112 + 3 = 115. New average = 115 / 5 = 23 years.'],
            ['question' => 'The average of 5 consecutive odd integers starting from x is:', 'options' => ['x + 2', 'x + 4', 'x + 5', 'x + 6'], 'answer' => 1, 'explanation' => 'Numbers: x, x+2, x+4, x+6, x+8. Average is the middle term: x + 4.'],
            ['question' => 'If the average temperature of Monday, Tuesday, and Wednesday was 32°C, and total of Mon and Tue was 60°C, what was Wednesday\'s temperature?', 'options' => ['32°C', '34°C', '36°C', '38°C'], 'answer' => 2, 'explanation' => 'Total 3 days = 3 * 32 = 96°C. Wed = 96 - 60 = 36°C.'],
        ];
    }

    private static function qProfitInterest(): array
    {
        return [
            ['question' => 'An electrical item bought for Rs. 4,000 is sold for Rs. 4,800. What is the profit percentage?', 'options' => ['15%', '20%', '25%', '30%'], 'answer' => 1, 'explanation' => 'Profit = 800. Profit % = (800 / 4,000) * 100% = 20%.'],
            ['question' => 'A generator bought for Rs. 50,000 is sold at a loss of 12%. What is the Selling Price?', 'options' => ['Rs. 42,000', 'Rs. 44,000', 'Rs. 46,000', 'Rs. 48,000'], 'answer' => 1, 'explanation' => 'SP = 50,000 * (1 - 0.12) = 50,000 * 0.88 = Rs. 44,000.'],
            ['question' => 'An article with Marked Price Rs. 2,500 is sold with a 15% discount. What is the cash selling price?', 'options' => ['Rs. 2,100', 'Rs. 2,125', 'Rs. 2,150', 'Rs. 2,200'], 'answer' => 1, 'explanation' => 'Discount = 0.15 * 2,500 = Rs. 375. SP = 2,500 - 375 = Rs. 2,125.'],
            ['question' => 'What is the Simple Interest on a principal of Rs. 60,000 at 8% per annum for 3 years?', 'options' => ['Rs. 12,000', 'Rs. 14,400', 'Rs. 16,000', 'Rs. 18,200'], 'answer' => 1, 'explanation' => 'I = (60,000 * 3 * 8) / 100 = Rs. 14,400.'],
            ['question' => 'What is the total maturity amount (Principal + Interest) on Rs. 100,000 at 10% simple interest for 2.5 years?', 'options' => ['Rs. 120,000', 'Rs. 125,000', 'Rs. 130,000', 'Rs. 135,000'], 'answer' => 1, 'explanation' => 'Interest = (100,000 * 2.5 * 10)/100 = Rs. 25,000. Total = 100,000 + 25,000 = Rs. 125,000.'],
            ['question' => 'In how many years will a sum of money double itself at 10% per annum simple interest?', 'options' => ['5 years', '8 years', '10 years', '12 years'], 'answer' => 2, 'explanation' => 'Time T = 100 / R = 100 / 10 = 10 years.'],
            ['question' => 'If Cost Price is Rs. 800 and Loss is 25%, what is the Selling Price?', 'options' => ['Rs. 500', 'Rs. 600', 'Rs. 650', 'Rs. 700'], 'answer' => 1, 'explanation' => 'SP = 800 * 0.75 = Rs. 600.'],
            ['question' => 'A shopkeeper marks an item 30% above cost and offers a 10% discount. What is his net profit percentage?', 'options' => ['15%', '17%', '20%', '22%'], 'answer' => 1, 'explanation' => 'Let CP = 100, MP = 130. SP = 130 * 0.90 = 117. Profit = 17%.'],
            ['question' => 'At what rate percent per annum will Rs. 40,000 yield a simple interest of Rs. 9,600 in 3 years?', 'options' => ['6%', '7.5%', '8%', '10%'], 'answer' => 2, 'explanation' => 'Rate R = (9,600 * 100) / (40,000 * 3) = 960,000 / 120,000 = 8%.'],
            ['question' => 'Two successive discounts of 20% and 10% are equivalent to a single discount of:', 'options' => ['28%', '30%', '32%', '25%'], 'answer' => 0, 'explanation' => 'Equivalent discount = (20 + 10 - (20*10)/100)% = 28%.'],
        ];
    }

    private static function qComputerFundamentals(): array
    {
        return [
            ['question' => 'Which component is considered the "Brain of the Computer"?', 'options' => ['RAM', 'Central Processing Unit (CPU)', 'Hard Disk', 'Motherboard'], 'answer' => 1, 'explanation' => 'The Central Processing Unit (CPU) performs all processing and controls operations.'],
            ['question' => 'Which type of computer memory is volatile and loses its data when power is turned off?', 'options' => ['ROM', 'RAM (Random Access Memory)', 'Hard Disk', 'Flash Drive'], 'answer' => 1, 'explanation' => 'RAM is volatile primary working memory.'],
            ['question' => 'What type of software is an Operating System (e.g., Windows, Linux)?', 'options' => ['System Software', 'Application Software', 'Utility Software', 'Malware'], 'answer' => 0, 'explanation' => 'Operating systems are fundamental System Software.'],
            ['question' => 'Which of the following is an input device used for reading marked objective exam sheets?', 'options' => ['Laser Printer', 'Optical Mark Reader (OMR)', 'Plotter', 'Speaker'], 'answer' => 1, 'explanation' => 'OMR is used to evaluate multiple choice question sheets.'],
            ['question' => 'How many bits make up 1 Byte?', 'options' => ['4 bits', '8 bits', '16 bits', '32 bits'], 'answer' => 1, 'explanation' => '1 Byte = 8 bits. (4 bits = 1 Nibble).'],
            ['question' => 'How many Kilobytes (KB) are in 1 Megabyte (MB)?', 'options' => ['100 KB', '1,000 KB', '1,024 KB', '2,048 KB'], 'answer' => 2, 'explanation' => '1 MB = 1,024 KB (in binary system).'],
            ['question' => 'What does BIOS stand for in computer hardware boot-up?', 'options' => ['Basic Input Output System', 'Binary Integrated Operating System', 'Broadband Internal Optical Sensor', 'Base Instruction Operating Socket'], 'answer' => 0, 'explanation' => 'BIOS stands for Basic Input Output System.'],
            ['question' => 'Which storage drive offers the fastest read/write speeds using flash memory?', 'options' => ['Floppy Disk', 'HDD (Hard Disk Drive)', 'SSD (Solid State Drive)', 'CD-ROM'], 'answer' => 2, 'explanation' => 'SSDs have no moving parts and offer significantly faster read/write speeds than HDDs.'],
            ['question' => 'Which shortcut key combination is commonly used to permanently delete a file in Windows without sending it to Recycle Bin?', 'options' => ['Ctrl + Delete', 'Shift + Delete', 'Alt + Delete', 'Ctrl + Shift + D'], 'answer' => 1, 'explanation' => 'Shift + Delete permanently deletes files.'],
            ['question' => 'Which unit of the CPU coordinates and directs operations of the other computer units?', 'options' => ['ALU (Arithmetic Logic Unit)', 'Control Unit (CU)', 'Registers', 'Cache Memory'], 'answer' => 1, 'explanation' => 'The Control Unit (CU) directs and supervises operations within the CPU.'],
        ];
    }

    private static function qOfficeApplications(): array
    {
        return [
            ['question' => 'Which feature in MS Word is used to create mass personalized letters or notices to multiple recipients?', 'options' => ['Spell Check', 'Mail Merge', 'Track Changes', 'WordArt'], 'answer' => 1, 'explanation' => 'Mail Merge merges a letter template with a recipient database.'],
            ['question' => 'What is the default file extension for documents saved in modern MS Word?', 'options' => ['.txt', '.docx', '.xlsx', '.pptx'], 'answer' => 1, 'explanation' => '.docx is the standard XML-based format for MS Word.'],
            ['question' => 'In MS Excel, which formula symbol must precede every calculation or function?', 'options' => ['@', '#', '=', '$'], 'answer' => 2, 'explanation' => 'All Excel formulas must begin with an equal sign (=).'],
            ['question' => 'Which Excel function calculates the arithmetic average of a specified range of cells?', 'options' => ['=AVG()', '=AVERAGE()', '=MEAN()', '=SUMAVG()'], 'answer' => 1, 'explanation' => '=AVERAGE() calculates the arithmetic mean.'],
            ['question' => 'In MS Excel, what is cell address "C5"?', 'options' => ['Row C, Column 5', 'Column C, Row 5', 'Sheet C, Cell 5', 'Book 5, Page C'], 'answer' => 1, 'explanation' => 'C5 refers to the intersection of Column C and Row 5.'],
            ['question' => 'Which keyboard shortcut initiates a PowerPoint slide show from the very first slide?', 'options' => ['F1', 'F5', 'Shift + F5', 'Ctrl + F5'], 'answer' => 1, 'explanation' => 'F5 starts the presentation from Slide 1.'],
            ['question' => 'What is the shortcut to start a slide show from the currently active slide in PowerPoint?', 'options' => ['F5', 'Shift + F5', 'Ctrl + P', 'Alt + S'], 'answer' => 1, 'explanation' => 'Shift + F5 launches the slide show from the current slide.'],
            ['question' => 'In MS Word, which shortcut key centers the selected text paragraph?', 'options' => ['Ctrl + L', 'Ctrl + C', 'Ctrl + E', 'Ctrl + J'], 'answer' => 2, 'explanation' => 'Ctrl + E centers text (Ctrl+L left aligns, Ctrl+R right aligns, Ctrl+J justifies).'],
            ['question' => 'What is the shortcut key to search/find text within an MS Office document?', 'options' => ['Ctrl + F', 'Ctrl + H', 'Ctrl + S', 'Ctrl + K'], 'answer' => 0, 'explanation' => 'Ctrl + F opens the Find dialog; Ctrl + H opens Find & Replace.'],
            ['question' => 'Which Excel function is used to look up a value in the leftmost column of a table and return a corresponding value from another column?', 'options' => ['=LOOKUP()', '=VLOOKUP()', '=HLOOKUP()', '=INDEX()'], 'answer' => 1, 'explanation' => '=VLOOKUP() performs vertical table searches.'],
        ];
    }

    private static function qEmailInternet(): array
    {
        return [
            ['question' => 'What protocol is used to transmit outgoing email messages across the internet?', 'options' => ['POP3', 'IMAP', 'SMTP (Simple Mail Transfer Protocol)', 'HTTP'], 'answer' => 2, 'explanation' => 'SMTP is the standard protocol for sending outgoing emails.'],
            ['question' => 'Which email protocol downloads messages to a local client and deletes them from the server by default?', 'options' => ['SMTP', 'POP3 (Post Office Protocol 3)', 'IMAP', 'FTP'], 'answer' => 1, 'explanation' => 'POP3 downloads messages locally, while IMAP syncs across multiple devices.'],
            ['question' => 'In an email, what does BCC stand for?', 'options' => ['Blind Carbon Copy', 'Back Carbon Copy', 'Broad Client Communication', 'Basic Contact Code'], 'answer' => 0, 'explanation' => 'BCC stands for Blind Carbon Copy (recipients hidden from others).'],
            ['question' => 'What system translates domain names (e.g. www.nea.org.np) into IP addresses?', 'options' => ['DHCP', 'DNS (Domain Name System)', 'FTP', 'VPN'], 'answer' => 1, 'explanation' => 'DNS resolves domain names into machine-readable IP addresses.'],
            ['question' => 'What does HTTPS stand for, and what indicates security in a web address?', 'options' => ['HyperText Transfer Protocol Secure (SSL/TLS encryption)', 'High Text Technology Protocol Source', 'Hyperlink Transmission Private Service', 'Home Telecom Public Server'], 'answer' => 0, 'explanation' => 'HTTPS encrypts communications using SSL/TLS.'],
            ['question' => 'What is the length of an IPv4 address in bits?', 'options' => ['16 bits', '32 bits', '64 bits', '128 bits'], 'answer' => 1, 'explanation' => 'IPv4 addresses are 32 bits long (IPv6 addresses are 128 bits).'],
            ['question' => 'What is fraudulent email designed to steal passwords or financial credentials called?', 'options' => ['Phishing', 'Spamming', 'Blogging', 'Caching'], 'answer' => 0, 'explanation' => 'Phishing is a social engineering cyberattack masquerading as a trustworthy entity.'],
            ['question' => 'Which Act governs cybercrimes and electronic signatures in Nepal?', 'options' => ['Electronic Transactions Act, 2063 (2008)', 'Telecommunications Act 2053', 'Information Act 2064', 'Banking Act 2064'], 'answer' => 0, 'explanation' => 'The Electronic Transactions Act (ETA 2063) regulates cyber crimes in Nepal.'],
            ['question' => 'What does URL stand for in web browsing?', 'options' => ['Uniform Resource Locator', 'Universal Record Line', 'United Remote Link', 'Uniform Retrieval Language'], 'answer' => 0, 'explanation' => 'URL stands for Uniform Resource Locator.'],
            ['question' => 'What security measure requires entering a one-time code (OTP) in addition to a password?', 'options' => ['Two-Factor Authentication (2FA / MFA)', 'Firewall rule', 'Data compression', 'Proxy server'], 'answer' => 0, 'explanation' => '2FA/MFA provides an extra layer of authentication beyond passwords.'],
        ];
    }

    private static function qDoubleEntry(): array
    {
        return [
            ['question' => 'Who is recognized as the "Father of Modern Accounting" for publishing the double entry principles in 1494?', 'options' => ['Adam Smith', 'Luca Pacioli', 'Alfred Marshall', 'F.W. Taylor'], 'answer' => 1, 'explanation' => 'Italian mathematician Luca Pacioli published the first treatise on double-entry accounting in 1494.'],
            ['question' => 'What is the fundamental rule of double entry bookkeeping regarding every transaction?', 'options' => ['Only cash is recorded', 'Every debit must have an equal and corresponding credit', 'Assets are always equal to profits', 'Only sales are recorded'], 'answer' => 1, 'explanation' => 'Total Debits must always equal Total Credits in every transaction.'],
            ['question' => 'According to traditional accounting rules, what is the rule for Personal Accounts?', 'options' => ['Debit what comes in, Credit what goes out', 'Debit the Receiver, Credit the Giver', 'Debit all expenses, Credit all incomes', 'Debit assets, Credit liabilities'], 'answer' => 1, 'explanation' => 'Personal Account rule: Debit the Receiver, Credit the Giver.'],
            ['question' => 'What is the Golden Rule for Nominal Accounts (Expenses, Incomes, Losses, Gains)?', 'options' => ['Debit the Receiver, Credit the Giver', 'Debit what comes in, Credit what goes out', 'Debit all Expenses and Losses, Credit all Incomes and Gains', 'Credit all assets, Debit all liabilities'], 'answer' => 2, 'explanation' => 'Nominal Account rule: Debit all expenses/losses, Credit all incomes/gains.'],
            ['question' => 'Which of the following is classified as a Real Account?', 'options' => ['Salary Account', 'Ram\'s Account', 'Building / Machinery Account', 'Rent Received Account'], 'answer' => 2, 'explanation' => 'Building and machinery are tangible property (Real Accounts).'],
            ['question' => 'In modern classification, what is the normal balance of an Asset account?', 'options' => ['Debit balance', 'Credit balance', 'Zero balance', 'Neutral balance'], 'answer' => 0, 'explanation' => 'Assets and Expenses have normal Debit balances; increases are debited.'],
            ['question' => 'What is the normal balance of a Liability account?', 'options' => ['Debit balance', 'Credit balance', 'Overdraft balance', 'Contingent balance'], 'answer' => 1, 'explanation' => 'Liabilities, Equity, and Revenue accounts have normal Credit balances.'],
            ['question' => 'The book of original entry where financial transactions are first recorded in chronological order is called:', 'options' => ['Ledger', 'Journal (Goswara Voucher)', 'Trial Balance', 'Balance Sheet'], 'answer' => 1, 'explanation' => 'The Journal is the primary book of original entry.'],
            ['question' => 'The process of transferring journal entries into respective ledger accounts is known as:', 'options' => ['Journalizing', 'Posting (Khatauni)', 'Balancing', 'Auditing'], 'answer' => 1, 'explanation' => 'Posting is transferring journal debit/credit amounts to respective ledger accounts.'],
            ['question' => 'A brief explanatory note written beneath every journal entry explaining the transaction is called:', 'options' => ['Ledger Folio', 'Narration', 'Contra note', 'Voucher index'], 'answer' => 1, 'explanation' => 'Narration explains the background and purpose of the journal entry.'],
        ];
    }

    private static function qAccountingEquation(): array
    {
        return [
            ['question' => 'What is the fundamental Accounting Equation?', 'options' => ['Assets = Liabilities + Capital (Owner\'s Equity)', 'Assets = Liabilities - Capital', 'Capital = Assets + Liabilities', 'Liabilities = Assets + Capital'], 'answer' => 0, 'explanation' => 'The core accounting equation is Assets = Liabilities + Capital.'],
            ['question' => 'If a business entity has total Assets of Rs. 1,500,000 and Liabilities of Rs. 600,000, what is its Capital/Equity?', 'options' => ['Rs. 2,100,000', 'Rs. 900,000', 'Rs. 600,000', 'Rs. 1,500,000'], 'answer' => 1, 'explanation' => 'Capital = Assets - Liabilities = 1,500,000 - 600,000 = Rs. 900,000.'],
            ['question' => 'Purchasing office equipment for Rs. 50,000 in cash affects the accounting equation by:', 'options' => ['Increasing total assets', 'Decreasing total assets', 'Increasing one asset (Equipment) and decreasing another asset (Cash) with no net change in total assets', 'Increasing liabilities'], 'answer' => 2, 'explanation' => 'Equipment increases by 50k and Cash decreases by 50k (total assets remain unchanged).'],
            ['question' => 'Paying staff salaries of Rs. 30,000 in cash impacts the accounting equation by:', 'options' => ['Decreasing Assets (Cash) and decreasing Capital (Expense)', 'Increasing Assets and increasing Liabilities', 'Increasing Liabilities only', 'No change'], 'answer' => 0, 'explanation' => 'Cash decreases by 30k (Asset -30k) and Capital decreases by 30k (Expense -30k).'],
            ['question' => 'What is the term for obligations owed by an enterprise to external third parties (creditors, lenders)?', 'options' => ['Assets', 'Liabilities', 'Capital', 'Retained Earnings'], 'answer' => 1, 'explanation' => 'Liabilities represent legal financial obligations owed to outsiders.'],
            ['question' => 'What is the term for customers from whom payment for goods/services supplied on credit is receivable?', 'options' => ['Creditors', 'Debtors / Accounts Receivable', 'Suppliers', 'Shareholders'], 'answer' => 1, 'explanation' => 'Debtors / Receivables are customers who owe money to the entity.'],
            ['question' => 'What type of asset is Goodwill, Patents, and Computer Software?', 'options' => ['Current Assets', 'Tangible Fixed Assets', 'Intangible Fixed Assets', 'Fictitious Assets'], 'answer' => 2, 'explanation' => 'Goodwill and patents are Intangible Assets possessing economic value without physical substance.'],
            ['question' => 'What are assets that are expected to be converted into cash within one normal operating cycle/year called?', 'options' => ['Fixed Assets', 'Current Assets', 'Non-current Assets', 'Wasting Assets'], 'answer' => 1, 'explanation' => 'Current Assets (cash, inventory, debtors) are liquid within 1 year.'],
            ['question' => 'When electricity revenue is billed to customers on credit, how is the accounting equation affected?', 'options' => ['Assets (Debtors) increase and Equity (Revenue) increases', 'Liabilities increase and Assets decrease', 'Only Cash increases', 'Capital decreases'], 'answer' => 0, 'explanation' => 'Debtors increase (+Asset) and Revenue increases (+Capital).'],
            ['question' => 'What is the expanded accounting equation incorporating revenues and expenses?', 'options' => ['Assets = Liabilities + Capital + Revenues - Expenses - Drawings', 'Assets = Liabilities - Revenues + Expenses', 'Capital = Assets + Liabilities + Expenses', 'Assets + Liabilities = Capital + Profits'], 'answer' => 0, 'explanation' => 'Assets = Liabilities + Beginning Capital + Revenues - Expenses - Drawings.'],
        ];
    }

    private static function qCapitalRevenue(): array
    {
        return [
            ['question' => 'Which of the following is the best example of Capital Expenditure?', 'options' => ['Monthly office rent', 'Purchase and erection of a 33 kV substation power transformer', 'Office stationery purchase', 'Transformer oil refilling'], 'answer' => 1, 'explanation' => 'Purchasing and installing a substation transformer provides long-term operational benefit (>1 yr).'],
            ['question' => 'Where is Revenue Expenditure charged in the annual financial statements?', 'options' => ['Balance Sheet Asset side', 'Profit and Loss Account (Income Statement)', 'Capital Reserves', 'Cash Book Contra'], 'answer' => 1, 'explanation' => 'Revenue expenditures are charged against annual revenue in the Profit & Loss Account.'],
            ['question' => 'Heavy advertising or software development expense whose benefit extends over 3-5 years is known as:', 'options' => ['Deferred Revenue Expenditure', 'Capital Receipt', 'Current Liability', 'Revenue Loss'], 'answer' => 0, 'explanation' => 'Deferred Revenue Expenditure is written off over multiple financial periods.'],
            ['question' => 'Which accounting concept requires transactions to be recorded when earned or incurred regardless of cash settlement?', 'options' => ['Cash Basis', 'Accrual / Mercantile Basis', 'Cost Concept', 'Dual Aspect'], 'answer' => 1, 'explanation' => 'Accrual accounting recognizes revenue when earned and expenses when incurred.'],
            ['question' => 'In Cash Basis of Accounting, when is electricity revenue recorded in the books?', 'options' => ['When the meter is read', 'When the bill is generated', 'Only when cash/online payment is actually received', 'At the end of fiscal year'], 'answer' => 2, 'explanation' => 'Cash basis strictly records transactions upon actual cash receipt/disbursement.'],
            ['question' => 'Which standard accounting framework is followed by public enterprises in Nepal for financial presentation?', 'options' => ['Nepal Financial Reporting Standards (NFRS / NAS)', 'US GAAP exclusively', 'Single Entry code', 'Treasury Code'], 'answer' => 0, 'explanation' => 'Nepal Financial Reporting Standards (NFRS) aligned with IFRS is mandated in Nepal.'],
            ['question' => 'Wages paid for the installation and foundation construction of a new hydro generator are classified as:', 'options' => ['Revenue Expenditure', 'Capital Expenditure (added to the cost of the generator)', 'Deferred Expense', 'Administrative Overhead'], 'answer' => 1, 'explanation' => 'Installation costs directly attributable to bringing an asset to working condition are capitalized.'],
            ['question' => 'Routine servicing and annual repairs of office pickup vehicles are classified as:', 'options' => ['Capital Expenditure', 'Revenue Expenditure', 'Deferred Revenue', 'Capital Loss'], 'answer' => 1, 'explanation' => 'Routine repairs maintain the existing operating condition and are revenue expenses.'],
            ['question' => 'Money received from selling electricity to consumers during normal operations is called:', 'options' => ['Capital Receipt', 'Revenue Receipt', 'Deferred Income', 'Contingent Receipt'], 'answer' => 1, 'explanation' => 'Revenue Receipts arise from core ongoing operating activities.'],
            ['question' => 'Money received from issuing long-term corporate bonds or taking long-term bank loans is classified as:', 'options' => ['Capital Receipt', 'Revenue Receipt', 'Operating Profit', 'Deferred Expense'], 'answer' => 0, 'explanation' => 'Long-term borrowings and share capital are Capital Receipts.'],
        ];
    }

    private static function qCashBookPetty(): array
    {
        return [
            ['question' => 'Which type of Cash Book records cash transactions, bank transactions, and cash discounts on both sides?', 'options' => ['Single Column Cash Book', 'Double Column Cash Book', 'Triple Column Cash Book', 'Petty Cash Book'], 'answer' => 2, 'explanation' => 'Triple Column Cash Book includes Cash, Bank, and Discount columns.'],
            ['question' => 'What is a "Contra Entry" in a Double/Triple Column Cash Book?', 'options' => ['An entry involving both Cash and Bank accounts recorded on opposite sides of the same cash book', 'An entry between two suppliers', 'An error correction note', 'A year-end closing entry'], 'answer' => 0, 'explanation' => 'Contra entries (depositing cash in bank or withdrawing cash for office) affect both cash & bank.'],
            ['question' => 'In an Imprest Petty Cash System, what happens at the end of the reimbursement period?', 'options' => ['The fund is closed', 'The petty cashier is reimbursed the exact amount spent to restore the float', 'The fund is doubled', 'A new cashier is appointed'], 'answer' => 1, 'explanation' => 'Reimbursement equal to total validated expenses restores the petty cash balance to its fixed imprest float.'],
            ['question' => 'Who maintains the Petty Cash Book in an organization?', 'options' => ['Chief Accountant', 'Petty Cashier', 'External Auditor', 'Bank Manager'], 'answer' => 1, 'explanation' => 'The Petty Cashier handles small day-to-day office expenses.'],
            ['question' => 'What is the primary objective of maintaining a Petty Cash Fund?', 'options' => ['To avoid writing bank cheques for small, recurring office expenses (tea, stamps, minor repairs)', 'To hide audit expenses', 'To purchase major equipment', 'To pay staff monthly salaries'], 'answer' => 0, 'explanation' => 'Petty cash prevents administrative bottlenecks from writing cheques for minor expenses.'],
            ['question' => 'What is recorded in a Purchase Book (Subsidiary Ledger)?', 'options' => ['All cash purchases of goods', 'Credit purchases of goods/inventory', 'Purchase of fixed assets on cash', 'All cash payments'], 'answer' => 1, 'explanation' => 'Purchase Book records credit purchases of trading goods/inventory.'],
            ['question' => 'What is recorded in a Sales Book (Subsidiary Ledger)?', 'options' => ['All cash sales', 'Credit sales of goods/services to customers', 'Sale of old fixed assets', 'All revenue receipts'], 'answer' => 1, 'explanation' => 'Sales Book strictly records credit sales of merchandise/services.'],
            ['question' => 'Where are transactions that cannot be entered in any specific subsidiary book recorded?', 'options' => ['Cash Book', 'Journal Proper (General Journal)', 'Bank Ledger', 'Petty Cash Book'], 'answer' => 1, 'explanation' => 'Journal Proper records opening/closing entries, rectifications, and asset credit purchases.'],
            ['question' => 'Which column of the Triple Column Cash Book is not balanced at the end of the period, but simply totaled?', 'options' => ['Cash column', 'Bank column', 'Discount column', 'Date column'], 'answer' => 2, 'explanation' => 'Discount columns are totaled and posted to Discount Allowed (Dr) and Discount Received (Cr) accounts.'],
            ['question' => 'What letter is marked in the L.F. (Ledger Folio) column against a Contra entry in the cash book?', 'options' => ['"P"', '"C"', '"B"', '"J"'], 'answer' => 1, 'explanation' => 'The letter "C" indicates a Contra entry.'],
        ];
    }

    private static function qBrsDepreciation(): array
    {
        return [
            ['question' => 'What is the primary purpose of preparing a Bank Reconciliation Statement (BRS)?', 'options' => ['To calculate corporate tax', 'To reconcile differences between bank balance in Cash Book and balance in Bank Statement/Passbook', 'To calculate asset depreciation', 'To apply for bank loans'], 'answer' => 1, 'explanation' => 'BRS reconciles differences between the organization\'s cash book and bank passbook.'],
            ['question' => 'A cheque of Rs. 15,000 issued to a supplier was not presented to the bank for payment. How is this treated when starting from Cash Book balance in BRS?', 'options' => ['Deducted from Cash Book balance', 'Added to Cash Book balance', 'Ignored completely', 'Multiplied by interest'], 'answer' => 1, 'explanation' => 'Cheques issued but not presented must be Added to the Cash Book balance.'],
            ['question' => 'Bank charges of Rs. 500 debited by the bank were not recorded in the Cash Book. How is this treated in BRS starting from Cash Book balance?', 'options' => ['Deducted from Cash Book balance', 'Added to Cash Book balance', 'Recorded as asset', 'No adjustment'], 'answer' => 0, 'explanation' => 'Bank charges reduce the bank balance and must be Deducted from Cash Book balance.'],
            ['question' => 'What is Depreciation in accounting?', 'options' => ['Increase in asset value due to inflation', 'Systematic allocation of the cost of a tangible fixed asset over its useful life', 'Cash outflow for loan repayment', 'Insurance payment'], 'answer' => 1, 'explanation' => 'Depreciation is the gradual reduction in book value of tangible fixed assets.'],
            ['question' => 'Under the Straight-Line Method (SLM), what is the annual depreciation on a machine costing Rs. 100,000 with scrap value Rs. 10,000 and useful life 5 years?', 'options' => ['Rs. 15,000', 'Rs. 18,000', 'Rs. 20,000', 'Rs. 22,500'], 'answer' => 1, 'explanation' => 'Depreciation = (100,000 - 10,000) / 5 = 90,000 / 5 = Rs. 18,000/year.'],
            ['question' => 'Under the Diminishing / Declining Balance Method, how is depreciation calculated each year?', 'options' => ['On original cost every year', 'At a fixed rate on the opening Written Down Value (Book Value) of the asset', 'On market resale price', 'On replacement cost'], 'answer' => 1, 'explanation' => 'Depreciation is calculated on the reducing book balance (Written Down Value) each year.'],
            ['question' => 'Which tangible asset is generally not depreciated because it does not lose useful life or wear out?', 'options' => ['Building', 'Plant & Machinery', 'Freehold Land', 'Vehicles'], 'answer' => 2, 'explanation' => 'Freehold Land has an unlimited useful economic life and is not depreciated.'],
            ['question' => 'What is the term for writing off the value of Intangible assets like patents or software?', 'options' => ['Depreciation', 'Amortization', 'Depletion', 'Obsolescence'], 'answer' => 1, 'explanation' => 'Amortization refers to the systematic write-off of intangible assets.'],
            ['question' => 'What is the term for the extraction and exhaustion of natural resources (mines, oil wells, quarries)?', 'options' => ['Amortization', 'Depreciation', 'Depletion', 'Devaluation'], 'answer' => 2, 'explanation' => 'Depletion applies to wasting natural assets like mineral mines.'],
            ['question' => 'Where is accumulated depreciation shown in the Balance Sheet?', 'options' => ['As a liability or deducted directly from the gross cost of the respective fixed asset', 'Under Current Assets', 'As Operating Revenue', 'Under Cash & Bank'], 'answer' => 0, 'explanation' => 'Accumulated depreciation is shown as a contra-asset deduction from fixed assets.'],
        ];
    }

    private static function qTrialBalance(): array
    {
        return [
            ['question' => 'What is a Trial Balance?', 'options' => ['A list of all ledger account balances on a specific date to verify arithmetic accuracy of double entry', 'A final legal document', 'A bank document', 'An inventory list'], 'answer' => 0, 'explanation' => 'Trial balance summarizes debit and credit balances to check mathematical accuracy.'],
            ['question' => 'Which accounting error is NOT revealed by a Trial Balance agreement?', 'options' => ['Error of Principle (treating capital expense as revenue)', 'Single-sided posting omission', 'Mathematical addition error in trial balance', 'Posting different amounts on debit and credit'], 'answer' => 0, 'explanation' => 'Error of principle affects debits and credits equally, keeping the trial balance in balance.'],
            ['question' => 'What type of error occurs when a transaction is completely omitted from being recorded in the books?', 'options' => ['Error of Commission', 'Error of Complete Omission', 'Compensating Error', 'Error of Principle'], 'answer' => 1, 'explanation' => 'Error of complete omission leaves both debit and credit unrecorded, so trial balance agrees.'],
            ['question' => 'Which financial statement is prepared to compute the Net Profit or Net Loss for an accounting period?', 'options' => ['Balance Sheet', 'Profit and Loss Account (Income Statement)', 'Trial Balance', 'Cash Book'], 'answer' => 1, 'explanation' => 'The Profit & Loss Account measures operational profitability for the period.'],
            ['question' => 'Which financial statement reveals the financial position (Assets, Liabilities, Equity) on a specific date?', 'options' => ['Trial Balance', 'Profit & Loss Statement', 'Balance Sheet (Statement of Financial Position)', 'Bank Statement'], 'answer' => 2, 'explanation' => 'The Balance Sheet shows assets and liabilities on a specified closing date.'],
            ['question' => 'In a Trading Account, what is the formula to calculate Gross Profit?', 'options' => ['Net Sales - Cost of Goods Sold (COGS)', 'Net Sales + Operating Expenses', 'Total Assets - Liabilities', 'Purchases - Closing Stock'], 'answer' => 0, 'explanation' => 'Gross Profit = Net Sales Revenue - Cost of Goods Sold.'],
            ['question' => 'How is Cost of Goods Sold (COGS) calculated?', 'options' => ['Opening Stock + Net Purchases + Direct Expenses - Closing Stock', 'Sales + Closing Stock', 'Purchases + Indirect Expenses', 'Fixed Costs + Depreciation'], 'answer' => 0, 'explanation' => 'COGS = Opening Stock + Purchases + Direct Factory Expenses - Closing Stock.'],
            ['question' => 'What temporary account is opened when a Trial Balance does not balance at year-end pending investigation of errors?', 'options' => ['Drawings Account', 'Suspense Account', 'Reserve Account', 'Petty Cash Account'], 'answer' => 1, 'explanation' => 'The Suspense Account holds the difference until errors are identified and rectified.'],
            ['question' => 'How are electricity sales revenues collected by NEA branch offices consolidated into the central balance sheet?', 'options' => ['Branch Trial Balances and inter-office accounts are merged and reconciled with Head Office', 'Ignored until 5 years', 'Reported only to banks', 'Branches keep separate private sheets'], 'answer' => 0, 'explanation' => 'Branch trial balances are submitted monthly and consolidated into the corporate accounts.'],
            ['question' => 'Where are prepaid expenses (expenses paid in advance) shown in the Balance Sheet?', 'options' => ['Current Liabilities', 'Current Assets', 'Fixed Assets', 'Long-term Debts'], 'answer' => 1, 'explanation' => 'Prepaid expenses represent future economic benefits and are Current Assets.'],
        ];
    }

    private static function qCostAccounting(): array
    {
        return [
            ['question' => 'What is the primary objective of Cost Accounting?', 'options' => ['Calculating and controlling costs of products, services, and operations to aid managerial decision making', 'Filing income tax alone', 'Calculating dividend for shareholders', 'Managing bank accounts'], 'answer' => 0, 'explanation' => 'Cost accounting ascertains and controls operational costs for management.'],
            ['question' => 'What is the sum of Direct Material, Direct Labor, and Direct Expenses called?', 'options' => ['Prime Cost', 'Works Cost', 'Cost of Production', 'Total Overhead'], 'answer' => 0, 'explanation' => 'Prime Cost = Direct Materials + Direct Labor + Direct Expenses.'],
            ['question' => 'Costs that remain constant in total regardless of changes in electricity production volume are called:', 'options' => ['Variable Costs', 'Fixed Costs (e.g. plant depreciation, permanent salaries)', 'Semi-variable Costs', 'Marginal Costs'], 'answer' => 1, 'explanation' => 'Fixed costs do not fluctuate with output volume within a relevant range.'],
            ['question' => 'Under which inventory valuation method are the earliest received materials assumed to be issued first?', 'options' => ['LIFO', 'FIFO (First-In, First-Out)', 'Simple Average', 'Base Stock'], 'answer' => 1, 'explanation' => 'FIFO issues the oldest inventory stock first; closing stock reflects recent purchase prices.'],
            ['question' => 'In a period of rising prices (inflation), which inventory valuation method results in higher reported net profit?', 'options' => ['FIFO', 'LIFO', 'Weighted Average', 'Depleted Cost'], 'answer' => 0, 'explanation' => 'FIFO charges older, lower costs to production, resulting in higher reported gross profits.'],
            ['question' => 'Under which method is material issue price computed as: Total Cost of Stock / Total Quantity of Stock?', 'options' => ['Simple Average Method', 'Weighted Average Method', 'FIFO', 'LIFO'], 'answer' => 1, 'explanation' => 'The Weighted Average Method divides total stock value by total stock units.'],
            ['question' => 'What document is maintained inside the warehouse attached to the storage rack showing physical inventory quantities?', 'options' => ['Store Ledger', 'Bin Card', 'Purchase Order', 'Journal Voucher'], 'answer' => 1, 'explanation' => 'Bin Cards track physical stock quantities and movements in the warehouse.'],
            ['question' => 'Who maintains the Store Ledger containing both quantities and monetary values of inventory?', 'options' => ['Storekeeper in the warehouse', 'Cost / Finance Accounting Department', 'Auditor General', 'Supplier'], 'answer' => 1, 'explanation' => 'The Cost/Accounts department maintains the monetary Store Ledger.'],
            ['question' => 'What is the optimum order quantity that minimizes total ordering costs and holding/carrying costs called?', 'options' => ['Safety Stock', 'Economic Order Quantity (EOQ)', 'Maximum Stock Level', 'Danger Level'], 'answer' => 1, 'explanation' => 'EOQ is the optimal purchase quantity minimizing total inventory costs.'],
            ['question' => 'What inventory control classification categorizes items based on monetary value (A: High value 70%, B: Medium 20%, C: Low 10%)?', 'options' => ['ABC Analysis', 'VED Analysis', 'FIFO Analysis', 'FSN Analysis'], 'answer' => 0, 'explanation' => 'ABC Analysis controls inventory based on the Pareto value principle.'],
        ];
    }

    private static function qInternalControl(): array
    {
        return [
            ['question' => 'What is Internal Control in an organization?', 'options' => ['The overall system of financial and operational controls instituted by management to ensure orderly business, safeguard assets, and prevent fraud', 'Government police inspection', 'External audit checks', 'Customer feedback survey'], 'answer' => 0, 'explanation' => 'Internal control is the comprehensive administrative and financial checks established by management.'],
            ['question' => 'What is the arrangement of office duties where the work of one employee is automatically and independently checked by another called?', 'options' => ['Internal Audit', 'Internal Check (आन्तरिक जाँच)', 'Statutory Audit', 'Management Audit'], 'answer' => 1, 'explanation' => 'Internal check distributes tasks so no single person handles a full transaction unchecked.'],
            ['question' => 'Who appoints and conducts the Internal Audit in public entities like Nepal Electricity Authority?', 'options' => ['Auditor General of Nepal', 'NEA Management / Internal Audit Directorate', 'Parliament Public Accounts Committee', 'Public Service Commission'], 'answer' => 1, 'explanation' => 'Internal Audit is established by NEA Management for continuous internal operational review.'],
            ['question' => 'What is the main objective of Statutory / Final Audit (अन्तिम लेखापरीक्षण)?', 'options' => ['To express an independent professional opinion on whether financial statements reflect a True and Fair view', 'To hire and fire employees', 'To prepare daily vouchers', 'To collect unpaid electricity bills'], 'answer' => 0, 'explanation' => 'Final audit provides an independent opinion on the truth and fairness of financial statements.'],
            ['question' => 'Under the Constitution of Nepal, which authority is mandated to conduct final audit of NEA accounts?', 'options' => ['Ministry of Finance Internal Unit', 'Auditor General of Nepal (Article 241)', 'CIAA', 'Commercial Banks'], 'answer' => 1, 'explanation' => 'The Auditor General conducts final audit of government bodies and majority-owned public enterprises.'],
            ['question' => 'What is an "Audit Query / Irregularity" (बेरुजु) in public audit terminology?', 'options' => ['A transaction conducted without following prevailing laws, rules, or budget authorizations, or lacking required supporting documentation', 'A normal cash payment', 'A bank deposit', 'An approved bonus'], 'answer' => 0, 'explanation' => 'Beruju is any transaction inconsistent with legal rules or lacking authorization.'],
            ['question' => 'Which committee of the Federal Parliament examines the annual report of the Auditor General regarding public enterprise irregularities?', 'options' => ['Finance Committee', 'Public Accounts Committee (PAC / सार्वजनिक लेखा समिति)', 'State Affairs Committee', 'Development Committee'], 'answer' => 1, 'explanation' => 'The Public Accounts Committee (PAC) reviews the Auditor General\'s reports.'],
            ['question' => 'What is a voucher in auditing?', 'options' => ['Any documentary evidence (receipt, bill, invoice, contract) supporting the accuracy of a recorded financial transaction', 'A bank debit card', 'A secret note', 'An invitation card'], 'answer' => 0, 'explanation' => 'A voucher is the primary documentary proof supporting a transaction.'],
            ['question' => 'The process of examining documentary evidence in support of entries in the books of account is termed:', 'options' => ['Posting', 'Vouching (भौचर जाँच)', 'Depreciation', 'Reconciliation'], 'answer' => 1, 'explanation' => 'Vouching is regarded as the backbone of auditing.'],
            ['question' => 'What type of audit opinion is issued when the auditor finds the financial statements are true and fair in all material respects without reservations?', 'options' => ['Qualified Opinion', 'Unqualified / Clean Opinion', 'Adverse Opinion', 'Disclaimer of Opinion'], 'answer' => 1, 'explanation' => 'An Unqualified (Clean) Opinion indicates statements are reliable and compliant.'],
        ];
    }

    private static function qBankingGuarantees(): array
    {
        return [
            ['question' => 'Which bank guarantee is submitted by contractors during tendering to ensure they will not withdraw their bid?', 'options' => ['Bid Bond (बोली जमानी - 2% to 3% of bid amount)', 'Performance Bond', 'Advance Payment Guarantee', 'Retention Money Guarantee'], 'answer' => 0, 'explanation' => 'A Bid Bond prevents bidders from withdrawing tenders during bid validity.'],
            ['question' => 'Which bank guarantee is submitted by the winning contractor to ensure satisfactory performance and project completion?', 'options' => ['Bid Bond', 'Performance Security / Performance Bond (typically 5% of contract value)', 'Customs Bond', 'Travel Guarantee'], 'answer' => 1, 'explanation' => 'Performance Security guarantees faithful execution of contract specifications.'],
            ['question' => 'What financial instrument is issued by a buyer\'s bank guaranteeing payment to a foreign supplier upon presentation of specified shipping documents?', 'options' => ['Letter of Credit (LC / प्रतित-पत्र)', 'Promissory Note', 'Treasury Bill', 'Cheque'], 'answer' => 0, 'explanation' => 'A Letter of Credit (LC) is standard in international procurement of equipment and parts.'],
            ['question' => 'Which type of cheque provides the highest payment security and can only be deposited directly into the payee\'s bank account?', 'options' => ['Bearer Cheque', 'Order Cheque', 'Account Payee Crossed Cheque', 'Open Cheque'], 'answer' => 2, 'explanation' => 'Account Payee crossing restricts encashment solely to the designated payee bank account.'],
            ['question' => 'What is a Bank Draft?', 'options' => ['A negotiable instrument drawn by a bank upon itself or another branch, payable on demand to the named payee', 'A loan application', 'A debit card receipt', 'An unapproved cheque'], 'answer' => 0, 'explanation' => 'A Bank Draft is a guaranteed payment instrument issued by a bank.'],
            ['question' => 'What guarantee allows a contractor to receive mobilization advance funds before commencing construction works?', 'options' => ['Bid Bond', 'Advance Payment Guarantee (APG)', 'Defect Liability Bond', 'Customs Guarantee'], 'answer' => 1, 'explanation' => 'An Advance Payment Guarantee secures the mobilization funds released to contractors.'],
            ['question' => 'When is a Performance Guarantee formally released and returned to the contractor?', 'options' => ['Immediately upon contract signing', 'Upon successful project handover, completion of work, and expiry of the Defect Liability Period (DLP)', 'When 50% of the project is done', 'It is never returned'], 'answer' => 1, 'explanation' => 'Performance guarantees are released upon final acceptance and defect liability expiry.'],
            ['question' => 'What is the standard validity period of a commercial bank cheque in Nepal from its date of issue?', 'options' => ['1 month', '3 months', '6 months', '1 year'], 'answer' => 2, 'explanation' => 'Under banking practices in Nepal, cheques remain valid for 6 months from the date of issue.'],
            ['question' => 'What happens when an account holder issues a cheque without having sufficient balance in their bank account?', 'options' => ['Cheque Bounce / Dishonor of Cheque (punishable under Banking Offence and Punishment Act 2064)', 'The bank pays from its reserve', 'The cheque is framed', 'The government covers the sum'], 'answer' => 0, 'explanation' => 'Dishonor of cheques due to insufficient funds is a crime under the Banking Offence Act.'],
            ['question' => 'Who operates the official expenditure bank accounts in NEA branch offices?', 'options' => ['Joint signature of the Office Chief and Finance/Account Officer', 'Office peon alone', 'Auditor General', 'Managing Director alone'], 'answer' => 0, 'explanation' => 'Operational bank accounts require joint signatures of the Office Chief and Account Head.'],
        ];
    }

    private static function qNeaAct(): array
    {
        return [
            ['question' => 'Under which Act of Parliament was Nepal Electricity Authority (NEA) established?', 'options' => ['Electricity Act 2049', 'Nepal Electricity Authority Act, 2041 (1984)', 'Company Act 2063', 'Public Enterprise Act 2030'], 'answer' => 1, 'explanation' => 'NEA was established under the statutory Nepal Electricity Authority Act 2041.'],
            ['question' => 'Who is the ex-officio Chairperson of the Board of Directors of NEA under Section 8 of the Act?', 'options' => ['Managing Director of NEA', 'Minister or State Minister for Energy, Water Resources and Irrigation', 'Secretary of Energy', 'Finance Secretary'], 'answer' => 1, 'explanation' => 'The Minister / State Minister for Energy serves as Board Chairperson.'],
            ['question' => 'How many members comprise the Board of Directors of Nepal Electricity Authority?', 'options' => ['5 members', '7 members', '8 members', '11 members'], 'answer' => 2, 'explanation' => 'Section 8 of the Act specifies an 8-member Board of Directors.'],
            ['question' => 'Who serves as the Member Secretary of the Board of Directors of NEA?', 'options' => ['Energy Joint Secretary', 'Managing Director of NEA', 'Chief Accountant of NEA', 'Legal Officer'], 'answer' => 1, 'explanation' => 'The Managing Director of NEA serves as Member Secretary.'],
            ['question' => 'What is the corporate legal character of NEA under Section 5 of the NEA Act 2041?', 'options' => ['An autonomous body corporate with perpetual succession, its own seal, and power to sue and be sued', 'A temporary government department', 'A private partnership firm', 'A cooperative'], 'answer' => 0, 'explanation' => 'NEA is an autonomous body corporate with perpetual succession and common seal.'],
            ['question' => 'What are the three core statutory functions of NEA under the Act?', 'options' => ['Generation, Transmission, and Distribution of electricity', 'Mining, refining, and selling oil', 'Constructing highways and railways', 'Collecting income tax'], 'answer' => 0, 'explanation' => 'NEA\'s primary mandates are Generation, Transmission, and Distribution of power.'],
            ['question' => 'Who determines and provides the authorized equity capital of Nepal Electricity Authority?', 'options' => ['Private Banks', 'Government of Nepal (GoN)', 'Foreign Investors alone', 'Consumers'], 'answer' => 1, 'explanation' => 'Authorized capital is determined and held by the Government of Nepal.'],
            ['question' => 'Under the NEA Act, in accordance with what principles must NEA maintain its accounts?', 'options' => ['Government cash single entry', 'Commercial double-entry accounting principles', 'Informal single entry', 'No accounts needed'], 'answer' => 1, 'explanation' => 'NEA maintains accounts based on commercial principles and international standards.'],
            ['question' => 'Under Section 28 of the Act, which authority is empowered to audit NEA\'s annual accounts?', 'options' => ['Auditor General of Nepal', 'Private Foreign Company', 'Local Ward Office', 'Energy Department'], 'answer' => 0, 'explanation' => 'Accounts are audited annually by the Auditor General of Nepal.'],
            ['question' => 'Who appoints the Managing Director of Nepal Electricity Authority?', 'options' => ['NEA Employees Union', 'Government of Nepal (Cabinet / Council of Ministers)', 'Auditor General', 'Public Service Commission'], 'answer' => 1, 'explanation' => 'The Government of Nepal (Cabinet) appoints the Managing Director.'],
        ];
    }

    private static function qEmployeeBylaws(): array
    {
        return [
            ['question' => 'How many levels (तह) of employee posts are structured in Nepal Electricity Authority?', 'options' => ['Level 1 to Level 5', 'Level 1 to Level 10', 'Level 1 to Level 12', 'Level 1 to Level 15'], 'answer' => 2, 'explanation' => 'NEA has positions from Level 1 (Helper/Assistant) up to Level 12 (Deputy Managing Director).'],
            ['question' => 'Level 4 in NEA (e.g. Assistant Accountant / Admin Assistant) belongs to which service category?', 'options' => ['Officer Class III', 'Non-Officer / Assistant Level (सहायक स्तर)', 'Executive Level', 'Special Class'], 'answer' => 1, 'explanation' => 'Levels 1 through 5 belong to the Assistant/Non-Officer cadre.'],
            ['question' => 'How many days of paid Casual / Festival Leave (पर्व/भैपरी बिदा) are granted to NEA employees annually?', 'options' => ['6 days', '12 days', '18 days', '30 days'], 'answer' => 1, 'explanation' => '12 days of paid casual/festival leave are provided per calendar year.'],
            ['question' => 'At what rate is Home Leave (घर बिदा) accumulated by permanent NEA employees?', 'options' => ['1 day for every 10 days worked (up to 30 days per year)', '1 day per month', '15 days per year', '45 days per year'], 'answer' => 0, 'explanation' => 'Home leave is earned at 1 day for every 10 days worked (max 30 days/yr, accumulable up to 180 days).'],
            ['question' => 'How many days of paid Sick Leave (बिरामी बिदा) are entitled to NEA employees per year?', 'options' => ['6 days', '12 days', '20 days', '30 days'], 'answer' => 1, 'explanation' => '12 days of paid sick leave are provided annually, which can be accumulated indefinitely.'],
            ['question' => 'What is the duration of paid Maternity Leave entitled to female employees in NEA?', 'options' => ['60 days', '90 days', '98 days', '120 days'], 'answer' => 2, 'explanation' => '98 days of maternity leave are provided in accordance with labor standards.'],
            ['question' => 'Which of the following is classified as a Minor Penalty (सामान्य सजाय) under NEA Employee Bylaws?', 'options' => ['Censure (नसिहत) or withholding grade increment for up to 2 years', 'Dismissal from service', 'Demotion to lower rank', 'Compulsory retirement'], 'answer' => 0, 'explanation' => 'Censure and withholding of annual increments/promotions are Minor Penalties.'],
            ['question' => 'What is the major difference between "Removal from Service" and "Dismissal from Service"?', 'options' => ['No difference', 'Removal allows eligibility for future government employment, whereas Dismissal permanently disqualifies from future public service', 'Dismissal pays full pension', 'Removal has no formal notice'], 'answer' => 1, 'explanation' => 'Dismissal disqualifies the employee from all future public employment.'],
            ['question' => 'What festival allowance is provided to permanent NEA employees during Dashain?', 'options' => ['Rs. 5,000 flat', 'One month basic salary', 'Two months salary', '50% of basic pay'], 'answer' => 1, 'explanation' => 'One month basic salary is provided as Dashain/Festival allowance annually.'],
            ['question' => 'What is the mandatory retirement age for permanent employees in Nepal Electricity Authority?', 'options' => ['55 years', '58 years', '60 years', '65 years'], 'answer' => 1, 'explanation' => 'The standard compulsory retirement age is 58 years (or 30 years service rule as applicable).'],
        ];
    }

    private static function qFinancialBylaws(): array
    {
        return [
            ['question' => 'Who manages the Central Fund (केन्द्रीय कोष) of Nepal Electricity Authority?', 'options' => ['Branch Manager alone', 'Central Accounts Department at NEA Head Office', 'Internal Audit', 'Trade Union'], 'answer' => 1, 'explanation' => 'The Central Accounts Department manages the consolidated central revenue and treasury pool.'],
            ['question' => 'Within how many days of completion of the assigned official work or tour must an Advance (पेश्की) be cleared?', 'options' => ['7 days', '15 to 30 days', '6 months', 'End of fiscal year'], 'answer' => 1, 'explanation' => 'Advances must be settled within 15 to 30 days; overdue advances face deductions with penalties.'],
            ['question' => 'What are the three statutory categories of Audit Irregularities (बेरुजु)?', 'options' => ['Regularizable (नियमित गर्ने), Recoverable (असुली गर्ने), and Advances Remaining (पेश्की बाँकी)', 'Cash, Bank, Ledger', 'Small, Medium, Big', 'Local, Provincial, Federal'], 'answer' => 0, 'explanation' => 'Beruju is categorized into Regularizable, Recoverable, and Unsettled Advances.'],
            ['question' => 'What is Re-appropriation (रकमान्तर) in financial budget administration?', 'options' => ['Transferring unspent budget from one approved budget sub-head to another budget sub-head within authorized limits', 'Stealing budget funds', 'Cancelling total budget', 'Opening a new bank account'], 'answer' => 0, 'explanation' => 'Re-appropriation transfers budget between authorized headings with proper sanction.'],
            ['question' => 'Who is responsible for the custody, record maintenance, and annual physical verification of assets in an NEA office?', 'options' => ['Storekeeper and Office Chief ( जिन्सी संरक्षण तथा बरबुझारथ)', 'Meter reader alone', 'Bank teller', 'Outside customer'], 'answer' => 0, 'explanation' => 'The Office Chief and Store In-charge ensure custody and asset physical verification.'],
            ['question' => 'What procedure is required when an employee holding custody of office assets/files is transferred to another station?', 'options' => ['Handover and Takeover (बरबुझारथ) with formal documentation', 'Throwing old files', 'Taking assets home', 'Leaving without notice'], 'answer' => 0, 'explanation' => 'Formal Barbujharath (handover/takeover) is mandatory upon transfer.'],
            ['question' => 'What is the ceiling for direct procurement of goods without calling competitive quotations in public financial rules?', 'options' => ['Up to Rs. 25,000', 'Up to Rs. 500,000 (as prescribed in Public Procurement Act/Rules)', 'Up to Rs. 1 Crore', 'Unlimited'], 'answer' => 1, 'explanation' => 'Procurement thresholds are governed by the Public Procurement Act and NEA bylaws.'],
            ['question' => 'What type of tender is mandatory for mega procurement works exceeding statutory thresholds?', 'options' => ['Direct purchase', 'Open Competitive Bidding (National / International Competitive Bidding - NCB / ICB)', 'Oral agreement', 'Sealed quotations without publication'], 'answer' => 1, 'explanation' => 'Open competitive bidding with public notice is mandatory for major contracts.'],
            ['question' => 'What is the minimum publication notice period for a National Competitive Bidding (NCB) tender in national daily newspapers?', 'options' => ['7 days', '15 days', '30 days', '60 days'], 'answer' => 2, 'explanation' => 'NCB tenders generally require a minimum 30-day notice period in national daily newspapers.'],
            ['question' => 'What rate of earnest money deposit (Bid Security / Bid Bond) is required from bidders in public procurement?', 'options' => ['0.5%', '2% to 3% of the estimated contract price', '10%', '25%'], 'answer' => 1, 'explanation' => 'Bid security is typically 2% to 3% of the estimated procurement cost.'],
        ];
    }

    private static function qTheftControl(): array
    {
        return [
            ['question' => 'Under Electricity Theft Control Rules 2059, which of the following constitutes electricity theft?', 'options' => ['Direct hooking / tapping into distribution lines without an authorized meter', 'Paying bills on time', 'Requesting a meter test', 'Using LED light bulbs'], 'answer' => 0, 'explanation' => 'Direct hooking or tampering with meter seals constitutes power theft.'],
            ['question' => 'What penalty is levied upon a consumer caught stealing electricity under Electricity Theft Control Rules 2059?', 'options' => ['Total assessed unmetered electricity charge plus 100% fine (शतप्रतिशत जरिवाना)', '25% fine', 'Only written warning', 'No penalty if bill is paid'], 'answer' => 0, 'explanation' => 'The full assessed consumption amount is recovered along with a 100% penalty (double amount).'],
            ['question' => 'How is the quantity of stolen electricity units assessed when tampering or direct tapping is detected?', 'options' => ['Total connected electrical load (KW) multiplied by standard operating hours over a 6-month to 1-year period', 'Random guess', 'Minimum 10 units', 'Zero units'], 'answer' => 0, 'explanation' => 'Assessment is based on connected load capacity, daily hours, and period of unauthorized use.'],
            ['question' => 'What action is taken on the electrical power line immediately upon detecting power theft?', 'options' => ['Immediate line disconnection (लाइन काट्ने)', 'Increasing voltage', 'Giving free power', 'Installing a bigger fuse'], 'answer' => 0, 'explanation' => 'The supply line is disconnected immediately to stop unauthorized usage.'],
            ['question' => 'When can a disconnected power line be reconnected after electricity theft is detected?', 'options' => ['Only after full payment of assessed loss units, 100% fine, and reconnection charges', 'After 24 hours automatically', 'Upon oral request', 'Never'], 'answer' => 0, 'explanation' => 'Reconnection is granted only upon full clearance of assessed dues and penalties.'],
            ['question' => 'What reward is provided to informants providing actionable information leading to the apprehension of power theft?', 'options' => ['Up to 20% of the recovered penalty/fine amount', 'Gold medal', 'Free electricity for lifetime', 'Government job'], 'answer' => 0, 'explanation' => 'The rules provide a cash incentive reward (up to 20% of recovered penalty) to informants.'],
            ['question' => 'Who has the authority to inspect premises and seize electrical equipment used for power theft?', 'options' => ['Authorized NEA Inspection Squad / Officer and accompanying Police personnel', 'Any neighbor', 'Local school teacher', 'Private contractor'], 'answer' => 0, 'explanation' => 'Authorized NEA inspection officers accompanied by police conduct enforcement raids.'],
            ['question' => 'Tampering with CT/PT meter seals and test links in industrial connections is classified as:', 'options' => ['Commercial innovation', 'Severe electrical theft and fraud subject to criminal prosecution', 'Routine maintenance', 'Power saving technique'], 'answer' => 1, 'explanation' => 'CT/PT meter tampering is severe industrial power theft resulting in heavy penalties.'],
            ['question' => 'Supplying electricity to an unauthorized third party outside designated premises without NEA permission is:', 'options' => ['Permitted charity', 'A violation of supply regulations subject to penalty and line cut', 'Encouraged', 'Tax exempt'], 'answer' => 1, 'explanation' => 'Unauthorized sub-distribution is strictly prohibited under distribution rules.'],
            ['question' => 'Under which Act are cases of electrical theft prosecuted?', 'options' => ['Electricity Theft Control Act, 2058 (2002) and Rules 2059', 'Forest Act', 'Land Reform Act', 'Motor Vehicle Act'], 'answer' => 0, 'explanation' => 'Electricity Theft Control Act 2058 and Rules 2059 govern theft offenses and penalties.'],
        ];
    }

    private static function qDistributionTariff(): array
    {
        return [
            ['question' => 'Under Electricity Distribution Bylaws 2078, what documents are required for a new domestic customer connection?', 'options' => ['Application form, citizenship certificate, land ownership certificate (Lalpurja) or house completion certificate', 'Passport only', 'No documents needed', 'Bank loan agreement only'], 'answer' => 0, 'explanation' => 'Citizenship and proof of land/house ownership or authorized tenancy are required.'],
            ['question' => 'How is billing handled when a customer meter premise is locked during the monthly reading cycle?', 'options' => ['Minimum monthly charge / average historical consumption is billed, with adjustments made on subsequent actual reading', 'Free power for that month', 'Line cut immediately', 'Account deleted'], 'answer' => 0, 'explanation' => 'Average/minimum billing is recorded during locked premises and adjusted later.'],
            ['question' => 'What rebate/discount is provided to electricity consumers who pay their bills within the first week of bill generation?', 'options' => ['2% to 3% rebate / discount on energy charges', '50% discount', 'No discount', 'Rs. 1,000 cash back'], 'answer' => 0, 'explanation' => 'NEA offers an early payment rebate (e.g., 2% discount within first 7 days).'],
            ['question' => 'What happens if a consumer delays paying the electricity bill beyond the normal due date (e.g., beyond 22-30 days)?', 'options' => ['Graded surcharge/penalty (5%, 10%, 25%) is added to the bill', 'The bill is waived', 'Interest is paid to the consumer', 'The bill amount decreases'], 'answer' => 0, 'explanation' => 'Progressive penalty surcharges (5% to 25%) are applied for delayed bill settlements.'],
            ['question' => 'After how many days of continuous non-payment of electricity bills is the consumer line subject to disconnection?', 'options' => ['15 days', '30 days', '60 days (2 months overdue)', '1 year'], 'answer' => 2, 'explanation' => 'Electricity lines are disconnected after 60 days of non-payment of dues.'],
            ['question' => 'What fee is deposited by a consumer as financial security before a new meter is energized?', 'options' => ['Security Deposit (धरौटी)', 'Advance tax', 'Donation', 'Customs duty'], 'answer' => 0, 'explanation' => 'A refundable Security Deposit is collected from consumers upon new connection.'],
            ['question' => 'What device is installed by NEA to record electricity consumption at customer premises?', 'options' => ['Energy Meter (Single-phase / Three-phase Smart / Electronic Meter)', 'Transformer', 'Inverter', 'Capacitor bank'], 'answer' => 0, 'explanation' => 'Electronic/Smart Energy Meters accurately record kilowatt-hour (kWh) units.'],
            ['question' => 'What is the standard unit of measurement of electrical energy consumption on consumer bills?', 'options' => ['Kilowatt-hour (kWh / 1 Unit = 1,000 Watt-hours)', 'Volt', 'Ampere', 'Horsepower'], 'answer' => 0, 'explanation' => '1 Unit of electricity equals 1 Kilowatt-Hour (1 kWh).'],
            ['question' => 'What tariff system charges different electricity rates based on peak, off-peak, and normal hours of the day?', 'options' => ['Time of Day (TOD) Tariff', 'Flat rate tariff', 'Free tariff', 'Emergency tariff'], 'answer' => 0, 'explanation' => 'TOD (Time-of-Day) metering charges higher rates during peak evening hours.'],
            ['question' => 'When is a customer electricity ledger record permanently cancelled (लगत खारेज)?', 'options' => ['Upon customer request, building demolition, or prolonged non-payment and non-reconnection after blacklisting', 'Every year', 'When meter reader changes', 'During monsoon'], 'answer' => 0, 'explanation' => 'Customer registration is cancelled upon formal request or failure to settle blacklisted dues.'],
        ];
    }

    private static function qRetirementFunds(): array
    {
        return [
            ['question' => 'What percentage is mandatorily deducted from an NEA permanent employee\'s monthly basic salary for the Employees Provident Fund (EPF)?', 'options' => ['5%', '10%', '15%', '20%'], 'answer' => 1, 'explanation' => '10% is deducted from basic pay, matched by 10% from NEA, totaling 20% deposited monthly in EPF.'],
            ['question' => 'What matching contribution is made by Nepal Electricity Authority towards employee EPF monthly?', 'options' => ['5%', '10%', '15%', '20%'], 'answer' => 1, 'explanation' => 'NEA provides an equal 10% matching employer contribution.'],
            ['question' => 'What is the full form of CIT in Nepal\'s retirement financial institutions?', 'options' => ['Citizen Investment Trust (नागरिक लगानी कोष)', 'Central Income Treasury', 'Commercial Insurance Trust', 'Credit Information Trade'], 'answer' => 0, 'explanation' => 'CIT stands for Citizen Investment Trust (Nagarik Lagani Kosh).'],
            ['question' => 'What is the maximum allowable income tax deduction for contributions to EPF / CIT and Social Security under prevailing tax rules?', 'options' => ['Rs. 100,000', 'Rs. 300,000 or 1/3rd of taxable income (whichever is lower, or up to 5 Lakhs for SSF)', 'Rs. 1,000,000', 'Unlimited'], 'answer' => 1, 'explanation' => 'Tax deductions apply up to 1/3rd of assessable income or statutory ceilings (Rs. 300,000 / 500,000).'],
            ['question' => 'What lump-sum retirement benefit is paid to employees who do not qualify for pension based on their total service years?', 'options' => ['Gratuity (उपदान)', 'Overtime pay', 'Leave encashment only', 'Travel grant'], 'answer' => 0, 'explanation' => 'Gratuity is a lump-sum separation payment calculated based on service duration.'],
            ['question' => 'How many years of minimum permanent service in NEA is generally required to be eligible for regular monthly Pension?', 'options' => ['10 years', '15 years', '20 years', '25 years'], 'answer' => 2, 'explanation' => '20 years of continuous permanent service is standard for defined-benefit pension eligibility.'],
            ['question' => 'What financial assistance loans are available to contributors from EPF and CIT?', 'options' => ['Special housing loans, education loans, and 80-90% contributor advance loans', 'Stock market speculation loans', 'Gambling loans', 'Foreign visa loans'], 'answer' => 0, 'explanation' => 'Contributors can access subsidized housing, education, and special fund loans.'],
            ['question' => 'Under contributory pension systems, what happens to accumulated retirement fund balances upon retirement?', 'options' => ['Paid as monthly annuity or lump-sum withdrawal with interest', 'Donated to government', 'Forfeited', 'Divided among coworkers'], 'answer' => 0, 'explanation' => 'Accumulated fund balances with interest are paid out or converted to monthly annuities.'],
            ['question' => 'Is interest earned on EPF and CIT deposits credited annually and compounded?', 'options' => ['Yes, credited annually and compounded into contributor principal accounts', 'No interest is paid', 'Interest is paid only in cash', 'Interest is deducted'], 'answer' => 0, 'explanation' => 'EPF and CIT compound interest annually into the employee account.'],
            ['question' => 'What death insurance/funeral grant is provided by EPF to the families of deceased active contributors?', 'options' => ['Funeral and accidental term insurance grants as per EPF regulations', 'No grant', 'Salary for 10 years', 'House handover'], 'answer' => 0, 'explanation' => 'EPF provides statutory accidental death insurance and funeral support grants.'],
        ];
    }

    private static function qIncomeTax(): array
    {
        return [
            ['question' => 'Under which Act of Parliament is direct income taxation governed in Nepal?', 'options' => ['Customs Act 2064', 'Income Tax Act, 2058 (2002)', 'VAT Act 2052', 'Excise Act 2058'], 'answer' => 1, 'explanation' => 'The Income Tax Act 2058 (2002 AD) governs all income and withholding taxes in Nepal.'],
            ['question' => 'What is the applicable TDS rate on House Rent paid to individuals or institutions for office leases?', 'options' => ['1.5%', '5%', '10%', '15%'], 'answer' => 2, 'explanation' => 'House rent TDS is 10% (collected by local governments or tax authorities).'],
            ['question' => 'What TDS rate applies on meeting allowances (बैठक भत्ता) paid to board members or committee participants?', 'options' => ['5%', '10%', '15% (Final Withholding Tax)', '25%'], 'answer' => 2, 'explanation' => 'Meeting allowance TDS is 15% and is treated as Final Withholding Tax.'],
            ['question' => 'What is the TDS rate on payments made for supply of goods under contracts exceeding Rs. 50 Lakhs?', 'options' => ['1.5%', '5%', '10%', '13%'], 'answer' => 0, 'explanation' => 'TDS on procurement contracts exceeding Rs. 50 Lakhs is 1.5%.'],
            ['question' => 'Within how many days of the end of each Nepali month must withheld tax (TDS) be deposited into the Government Treasury?', 'options' => ['7 days', '15 days', '25 days (Section 90)', '30 days'], 'answer' => 2, 'explanation' => 'Under Section 90 of the Income Tax Act, TDS must be deposited within 25 days of the following month.'],
            ['question' => 'What electronic portal maintained by the Inland Revenue Department (IRD) is used to file monthly TDS returns?', 'options' => ['e-TDS System / IRD Integrated Tax System', 'Nagrik App only', 'NEA internal website', 'Nepal Post portal'], 'answer' => 0, 'explanation' => 'Withholding agents must submit monthly returns via the IRD e-TDS portal.'],
            ['question' => 'What rate of Social Security Tax (SST) is levied on the initial basic income exemption slab of natural persons?', 'options' => ['1%', '5%', '10%', '15%'], 'answer' => 0, 'explanation' => '1% Social Security Tax is levied on the first income exemption slab of employment income.'],
            ['question' => 'What is the mandatory 9-digit tax identification number required for businesses, employees, and taxpayers in Nepal?', 'options' => ['PAN (Permanent Account Number)', 'VAT number', 'NIN', 'Passport ID'], 'answer' => 0, 'explanation' => 'PAN is the unique 9-digit Permanent Account Number issued by IRD.'],
            ['question' => 'Which of the following is considered a Final Withholding Payment where no further income tax filing is needed?', 'options' => ['Bank interest on personal savings and meeting allowances', 'Monthly basic salary', 'Business profit', 'Commercial house rent'], 'answer' => 0, 'explanation' => 'Interest on individual bank deposits and meeting allowances are final withholding taxes.'],
            ['question' => 'What is the consequence of failing to deduct and deposit TDS within the statutory 25-day deadline?', 'options' => ['Interest surcharge (15% per annum) and statutory late penalty under the Income Tax Act', 'No consequence', 'Income tax cancellation', 'Free bonus'], 'answer' => 0, 'explanation' => 'Delays attract statutory penal interest and fines under Sections 117-119 of the Income Tax Act.'],
        ];
    }

    private static function qAntiCorruption(): array
    {
        return [
            ['question' => 'Under which Act are corruption offenses and anti-graft enforcement governed in Nepal?', 'options' => ['Civil Service Act', 'Prevention of Corruption Act, 2059 (2002)', 'Police Act', 'Good Governance Act'], 'answer' => 1, 'explanation' => 'The Prevention of Corruption Act 2059 governs corruption offenses and penalties.'],
            ['question' => 'Within how many days from the start of a fiscal year must every public servant submit their annual Property Declaration (सम्पत्ति विवरण)?', 'options' => ['30 days', '60 days (by end of Bhadra)', '90 days', '180 days'], 'answer' => 1, 'explanation' => 'Property declarations must be submitted within 60 days of the start of the fiscal year.'],
            ['question' => 'To which specialized court does the CIAA file corruption and bribery cases for trial in Nepal?', 'options' => ['District Court', 'Special Court (विशेष अदालत)', 'High Court', 'Arbitration Tribunal'], 'answer' => 1, 'explanation' => 'Corruption cases are tried at the Special Court under the Special Court Act.'],
            ['question' => 'Which institution under the Office of the Prime Minister conducts administrative surveillance and vigilance to prevent corruption?', 'options' => ['National Vigilance Centre (NVC / राष्ट्रिय सतर्कता केन्द्र)', 'Election Commission', 'Auditor General', 'Supreme Court'], 'answer' => 0, 'explanation' => 'The National Vigilance Centre conducts anti-corruption vigilance in public offices.'],
            ['question' => 'What penalty is prescribed when a public official is convicted of acquiring disproportionate / unaccounted illegal assets?', 'options' => ['Confiscation of illegal assets, fine of equivalent amount, and imprisonment', 'Small oral reprimand', 'Promotion transfer', 'Salary bonus'], 'answer' => 0, 'explanation' => 'Illegal assets are confiscated in full, along with imprisonment and fines.'],
            ['question' => 'Under Section 15 of the Act, what penalty applies to public servants who prepare false government bills or fake measurement books?', 'options' => ['Imprisonment and fine based on severity of offense', 'Reward', 'No punishment', 'Overtime allowance'], 'answer' => 0, 'explanation' => 'Falsifying official government documents or measurement books is a criminal offense.'],
            ['question' => 'Are both the bribe giver and the bribe taker held criminally liable under the Prevention of Corruption Act?', 'options' => ['Yes, both giving and accepting bribes are criminal offenses subject to imprisonment and fine', 'Only the giver is guilty', 'Only the taker is guilty', 'Neither is guilty'], 'answer' => 0, 'explanation' => 'Both demanding/accepting and offering bribes are punishable offenses.'],
            ['question' => 'What enhanced punishment applies if corruption is committed by an Office Chief or senior executive?', 'options' => ['Additional imprisonment up to 3 years over standard penalty', 'Penalty is halved', 'No penalty', 'Transferred to headquarters'], 'answer' => 0, 'explanation' => 'Office chiefs and senior officials face enhanced imprisonment sentences.'],
            ['question' => 'What happens to a public official against whom the CIAA files a formal corruption case in the Special Court?', 'options' => ['Automatically suspended from official position until court verdict', 'Given a promotion', 'Sent on foreign tour', 'Made board director'], 'answer' => 0, 'explanation' => 'The public servant is placed under automatic suspension upon case filing in court.'],
            ['question' => 'What fundamental principle of public administration is promoted by the Good Governance Act 2064?', 'options' => ['Transparency, Accountability, Rule of Law, and Quality Public Service Delivery', 'Bureaucratic secrecy', 'Delaying customer service', 'Eliminating records'], 'answer' => 0, 'explanation' => 'The Good Governance Act mandates transparency, accountability, and citizen-friendly service.'],
        ];
    }

    private static function qGeneralNeaAssessment(): array
    {
        return [
            ['question' => 'What is the primary statutory responsibility of Nepal Electricity Authority (NEA)?', 'options' => ['Generation, Transmission, and Distribution of electricity across Nepal', 'Road construction', 'Mining coal', 'Operating domestic airlines'], 'answer' => 0, 'explanation' => 'NEA manages generation, transmission, and distribution of electricity throughout Nepal.'],
            ['question' => 'When was Nepal Electricity Authority (NEA) established in Bikram Sambat?', 'options' => ['2041 Poush 1', '2042 Bhadra 1', '2046 Baishakh 1', '2050 Chaitra 30'], 'answer' => 1, 'explanation' => 'NEA was formally founded on Bhadra 1, 2042 BS under the NEA Act 2041.'],
            ['question' => 'What is the full mark score of Phase 1 Written Examination for NEA Level 4?', 'options' => ['100 Marks', '200 Marks (Paper I: 100 + Paper II: 100)', '300 Marks', '50 Marks'], 'answer' => 1, 'explanation' => 'The written exam comprises 200 marks (Paper I 100 marks + Paper II 100 marks).'],
            ['question' => 'What is the pass mark percentage required in each paper of the written exam?', 'options' => ['32%', '40%', '50%', '60%'], 'answer' => 1, 'explanation' => '40 marks out of 100 is the minimum pass mark for each paper.'],
            ['question' => 'Negative marking in Loksewa multiple choice objective questions is deducted at what rate for wrong answers?', 'options' => ['10%', '20% (0.2 marks per 1 mark question)', '33%', '50%'], 'answer' => 1, 'explanation' => '20% marks are deducted for every incorrect MCQ answer.'],
            ['question' => 'What is the theoretical hydropower potential of Nepal?', 'options' => ['42,000 MW', '83,000 MW', '100,000 MW', '20,000 MW'], 'answer' => 1, 'explanation' => 'Theoretical hydropower potential is 83,000 MW (economically feasible ~42,000 MW).'],
            ['question' => 'Which constitutional organ conducts the recruitment exams for NEA Level 4 posts?', 'options' => ['Public Service Commission (Lok Sewa Aayog)', 'Ministry of Energy', 'Tribhuvan University', 'Private Board'], 'answer' => 0, 'explanation' => 'The Public Service Commission conducts selection examinations for public enterprises.'],
            ['question' => 'What is the fundamental accounting equation?', 'options' => ['Assets = Liabilities + Capital', 'Assets = Liabilities - Capital', 'Capital = Liabilities + Revenues', 'Profit = Assets + Cash'], 'answer' => 0, 'explanation' => 'Assets = Liabilities + Owner\'s Equity.'],
            ['question' => 'Under the Constitution of Nepal, how many fundamental rights are guaranteed in Part 3?', 'options' => ['21', '25', '31', '35'], 'answer' => 2, 'explanation' => '31 Fundamental Rights are guaranteed from Article 16 to Article 46.'],
            ['question' => 'What penalty is levied on power theft under Electricity Theft Control Rules 2059?', 'options' => ['Assessed loss amount plus 100% fine (शतप्रतिशत जरिवाना)', '25% fine', 'Written warning only', 'No fine'], 'answer' => 0, 'explanation' => 'Assessed unmetered consumption is recovered along with a 100% fine.'],
        ];
    }
}
