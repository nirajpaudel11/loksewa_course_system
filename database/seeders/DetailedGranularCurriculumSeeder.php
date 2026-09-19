<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class DetailedGranularCurriculumSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedGranularNasu();
        $this->seedGranularSectionOfficer();
        $this->seedGranularNRBOfficer();
        $this->seedGranularNRBAD();
        $this->seedGranularConstitutionLaw();
        $this->seedGranularComputerSkill();
        $this->seedGranularIQAptitude();
        $this->seedGranularTelecom();
    }

    private function cleanCourseModules(string $slug): ?Course
    {
        $course = Course::where('slug', $slug)->first();
        if (! $course) {
            return null;
        }

        $modules = Module::where('course_id', $course->id)->get();
        foreach ($modules as $m) {
            Lesson::where('module_id', $m->id)->delete();
            $m->delete();
        }

        return $course;
    }

    private function addLesson(Module $module, string $title, string $slug, int $order, string $briefContent, array $quizzes): void
    {
        Lesson::create([
            'module_id' => $module->id,
            'title' => $title,
            'slug' => $slug,
            'order' => $order,
            'type' => 'text',
            'duration_minutes' => 20,
            'is_published' => true,
            'content' => $briefContent,
            'quiz_questions' => $quizzes,
        ]);
    }

    /* =========================================================================
     * 1. NAYAB SUBBA TAYARI
     * ========================================================================= */
    private function seedGranularNasu(): void
    {
        $course = $this->cleanCourseModules('nayab-subba-tayari');
        if (! $course) {
            return;
        }

        // Module 1: Samanya Gyan (GK)
        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Samanya Gyan (General Knowledge)',
            'slug' => 'nasu-samanya-gyan',
            'order' => 1,
            'is_published' => true,
            'description' => 'Comprehensive General Knowledge syllabus covering Nepal Geography, History, Culture, Universe, Science, and International Organizations.',
            'key_points' => "• Physical & Political Geography of Nepal\n• Historical Eras from Lichhavi to Republic\n• Science, Environment & UN / SAARC",
            'notes' => 'Detailed syllabus study notes for Nayab Subba GK Paper.',
        ]);

        $this->addLesson($m1, 'Physical Geography of Nepal', 'nasu-physical-geography-nepal', 1, 'Focus on Nepal Geography, ecological zones, borders, rivers, lakes, passes, and national parks.', [
            ['question' => 'What is the total area of Nepal in square kilometers?', 'options' => ['147,181 sq km', '147,516 sq km', '148,181 sq km', '147,000 sq km'], 'answer' => 0, 'hint' => 'Official figure: 147,181 sq km.', 'explanation' => 'Nepal has an area of 147,181 sq km (56,827 sq mi).'],
            ['question' => 'Which is the highest peak in the Mahabharat mountain range?', 'options' => ['Sailung', 'Phulchoki (2,782 m)', 'Chandragiri', 'Daman'], 'answer' => 1, 'hint' => 'Located in Lalitpur district.', 'explanation' => 'Phulchoki (2,782 m) is the highest elevation of the Mahabharat range.'],
            ['question' => 'Which river in Nepal is known as the "Sorrow of Bihar"?', 'options' => ['Gandaki', 'Koshi', 'Karnali', 'Mahakali'], 'answer' => 1, 'hint' => 'Largest river of Nepal by water volume.', 'explanation' => 'The Koshi River causes seasonal flooding in Bihar, India.'],
            ['question' => 'What percentage of Nepal\'s land area is covered by the Terai ecological region?', 'options' => ['Approx 17%', 'Approx 25%', 'Approx 35%', 'Approx 68%'], 'answer' => 0, 'hint' => 'Occupies less than one-fifth of the national territory.', 'explanation' => 'Terai accounts for ~17%, Hills ~68%, and Mountains ~15%.'],
            ['question' => 'Which lake in Nepal is located at the highest altitude?', 'options' => ['Rara Lake', 'Shey Phoksundo Lake', 'Tilicho / Kajin Sara Lake', 'Gosaikunda'], 'answer' => 2, 'hint' => 'Located in Manang district above 4,900 meters.', 'explanation' => 'Tilicho Lake (4,919 m) and Kajin Sara (5,200 m) in Manang hold highest elevation records.'],
            ['question' => 'Which two districts of Nepal touch both India and China?', 'options' => ['Taplejung & Darchula', 'Jhapa & Kanchanpur', 'Solukhumbu & Mustang', 'Rasuwa & Humla'], 'answer' => 0, 'hint' => 'One at the eastern end and one at the western end.', 'explanation' => 'Taplejung (East) and Darchula (Far-West) border both neighboring countries.'],
            ['question' => 'Which mountain pass connects Upper Mustang with Tibet, China?', 'options' => ['Kodari Pass', 'Korala Pass', 'Kimathanka Pass', 'Rasuwagadhi Pass'], 'answer' => 1, 'hint' => 'Located in Upper Mustang at 4,660 meters.', 'explanation' => 'Korala Pass connects Mustang with Tibet, China.'],
            ['question' => 'Nepal Standard Time (NST) is based on which meridian and longitude?', 'options' => ['Mt. Gaurishankar (86°15\' E)', 'Mt. Everest (86°55\' E)', 'Mt. Annapurna (83°45\' E)', 'Mt. Manaslu (84°30\' E)'], 'answer' => 0, 'hint' => 'Calculated from Gaurishankar meridian, GMT +5:45.', 'explanation' => 'NST is calculated from Mt. Gaurishankar (86°15\' E), exact GMT +5:45.'],
            ['question' => 'Which is the longest glacier in Nepal?', 'options' => ['Khumbu Glacier', 'Ngozumpa Glacier (36 km)', 'Langtang Glacier', 'Yalung Glacier'], 'answer' => 1, 'hint' => 'Located below Cho Oyu in the Everest region.', 'explanation' => 'Ngozumpa Glacier (36 km) is Nepal\'s longest glacier.'],
            ['question' => 'Which was established as the first national park of Nepal in 1973 AD (2030 BS)?', 'options' => ['Bardia National Park', 'Chitwan National Park', 'Sagarmatha National Park', 'Rara National Park'], 'answer' => 1, 'hint' => 'Famous for one-horned rhinos.', 'explanation' => 'Chitwan National Park was established in 1973 AD as Nepal\'s first national park.'],
        ]);

        $this->addLesson($m1, 'Geography of World', 'nasu-geography-of-world', 2, 'Focus on Continents, Oceans, Great mountain ranges, Deserts, and Climate belts of the world.', [
            ['question' => 'Which is the largest continent in the world by land area and population?', 'options' => ['Africa', 'Asia', 'North America', 'Europe'], 'answer' => 1, 'hint' => 'Occupies roughly 30% of Earth\'s land area.', 'explanation' => 'Asia is the largest and most populous continent on Earth.'],
            ['question' => 'Which is the deepest oceanic trench in the world?', 'options' => ['Java Trench', 'Mariana Trench (Challenger Deep)', 'Puerto Rico Trench', 'Sunda Trench'], 'answer' => 1, 'hint' => 'Located in the western Pacific Ocean, reaching nearly 11,000 meters.', 'explanation' => 'The Mariana Trench is the deepest oceanic trench on Earth.'],
            ['question' => 'Which is the longest river in the world by length?', 'options' => ['Amazon River', 'Nile River', 'Yangtze River', 'Mississippi River'], 'answer' => 1, 'hint' => 'Flows through northeastern Africa into the Mediterranean Sea (~6,650 km).', 'explanation' => 'The Nile River (6,650 km) is traditionally measured as the longest river.'],
            ['question' => 'Which is the largest hot desert in the world?', 'options' => ['Gobi Desert', 'Sahara Desert', 'Kalahari Desert', 'Arabian Desert'], 'answer' => 1, 'hint' => 'Covers most of North Africa over 9 million sq km.', 'explanation' => 'The Sahara Desert is the largest hot subtropical desert on Earth.'],
            ['question' => 'Which mountain range is the longest continental mountain range on Earth?', 'options' => ['Himalayas', 'Andes Mountains (7,000 km)', 'Rocky Mountains', 'Alps'], 'answer' => 1, 'hint' => 'Runs along the entire western coast of South America.', 'explanation' => 'The Andes Mountain Range spans approximately 7,000 km across South America.'],
            ['question' => 'Which strait separates Asia (Russia) from North America (Alaska)?', 'options' => ['Strait of Gibraltar', 'Bering Strait', 'Strait of Malacca', 'Bosphorus Strait'], 'answer' => 1, 'hint' => 'Connects the Arctic Ocean with the Bering Sea.', 'explanation' => 'The Bering Strait separates Russia from Alaska.'],
            ['question' => 'Which is the largest freshwater lake in the world by surface area?', 'options' => ['Lake Baikal', 'Lake Superior', 'Lake Victoria', 'Caspian Sea'], 'answer' => 1, 'hint' => 'One of the North American Great Lakes.', 'explanation' => 'Lake Superior is the largest freshwater lake by surface area (82,100 sq km).'],
            ['question' => 'Which country has the longest coastline in the world?', 'options' => ['Russia', 'Canada', 'Indonesia', 'Australia'], 'answer' => 1, 'hint' => 'North American country with over 202,000 km of coastline.', 'explanation' => 'Canada has the world\'s longest coastline (over 202,080 km).'],
            ['question' => 'What is the imaginary line at 0 degrees latitude called?', 'options' => ['Prime Meridian', 'Equator', 'Tropic of Cancer', 'Tropic of Capricorn'], 'answer' => 1, 'hint' => 'Divides Earth into Northern and Southern Hemispheres.', 'explanation' => 'The Equator is the 0° parallel of latitude.'],
            ['question' => 'Which continent is known as the "Dark Continent" or the "Plateau Continent"?', 'options' => ['South America', 'Africa', 'Australia', 'Antarctica'], 'answer' => 1, 'hint' => 'Second largest continent containing 54 sovereign nations.', 'explanation' => 'Africa is historically referred to as the Plateau Continent.'],
        ]);

        $this->addLesson($m1, 'General Information of Universe', 'nasu-universe-information', 3, 'Focus on the Solar System, Planets, Stars, Sun, Moon, and Astronomical phenomena.', [
            ['question' => 'Which is the largest planet in our solar system?', 'options' => ['Jupiter', 'Saturn', 'Uranus', 'Neptune'], 'answer' => 0, 'hint' => 'Gas giant with the famous Great Red Spot.', 'explanation' => 'Jupiter is the largest planet with a diameter of ~142,984 km.'],
            ['question' => 'Which planet is known as the "Red Planet"?', 'options' => ['Venus', 'Mars', 'Mercury', 'Jupiter'], 'answer' => 1, 'hint' => 'Due to iron oxide (rust) covering its surface.', 'explanation' => 'Mars appears reddish because of pervasive iron oxide on its surface.'],
            ['question' => 'Which planet is closest in distance to the Sun?', 'options' => ['Venus', 'Mercury', 'Earth', 'Mars'], 'answer' => 1, 'hint' => 'Completes an orbit around the Sun in just 88 Earth days.', 'explanation' => 'Mercury is the innermost and fastest-orbiting planet.'],
            ['question' => 'Which is the brightest planet visible in the night sky, often called the "Morning Star"?', 'options' => ['Mars', 'Venus', 'Jupiter', 'Saturn'], 'answer' => 1, 'hint' => 'Second planet from the Sun with thick reflective sulfuric clouds.', 'explanation' => 'Venus has the highest albedo and is the brightest natural object after the Moon.'],
            ['question' => 'How long does sunlight take to reach the surface of the Earth?', 'options' => ['Approx 8 minutes 20 seconds', 'Approx 5 minutes', 'Approx 12 minutes', 'Instantly'], 'answer' => 0, 'hint' => 'Around 500 seconds travelling at light speed (300,000 km/s).', 'explanation' => 'Sunlight travels ~150 million km in approximately 8 minutes and 20 seconds.'],
            ['question' => 'Which celestial body is the largest known natural satellite of Saturn?', 'options' => ['Ganymede', 'Titan', 'Europa', 'Io'], 'answer' => 1, 'hint' => 'Possesses a dense nitrogen-rich atmosphere and liquid methane lakes.', 'explanation' => 'Titan is Saturn\'s largest moon and the second-largest in the solar system.'],
            ['question' => 'What is the name of the spiral galaxy that contains our Solar System?', 'options' => ['Andromeda Galaxy', 'Milky Way Galaxy (Chhayapath)', 'Whirlpool Galaxy', 'Triangulum Galaxy'], 'answer' => 1, 'hint' => 'Barred spiral galaxy containing 100–400 billion stars.', 'explanation' => 'Our Solar System resides in the Milky Way Galaxy.'],
            ['question' => 'Which planet rotates on its side with an axial tilt of nearly 98 degrees?', 'options' => ['Saturn', 'Uranus', 'Neptune', 'Jupiter'], 'answer' => 1, 'hint' => 'An ice giant tilted almost completely on its orbital plane.', 'explanation' => 'Uranus has an extreme axial tilt of 97.77°, causing it to rotate on its side.'],
            ['question' => 'A Solar Eclipse occurs when:', 'options' => ['Earth comes between Sun and Moon', 'Moon comes between Sun and Earth', 'Sun comes between Earth and Moon', 'Mars aligns with Venus'], 'answer' => 1, 'hint' => 'The Moon blocks sunlight from reaching Earth during New Moon.', 'explanation' => 'A Solar Eclipse happens when the Moon passes directly between the Sun and Earth.'],
            ['question' => 'Halley\'s Comet appears in the inner solar system approximately every:', 'options' => ['50 Years', '75–76 Years', '100 Years', '125 Years'], 'answer' => 1, 'hint' => 'Last seen in 1986, next expected in 2061.', 'explanation' => 'Halley\'s Comet has an orbital period of approximately 75 to 76 years.'],
        ]);

        $this->addLesson($m1, 'History of Nepal', 'nasu-history-of-nepal', 4, 'Focus on Ancient Lichhavi dynasty, Medieval Malla period, Shah unification, and modern political milestones.', [
            ['question' => 'On which date did King Prithvi Narayan Shah conquer Kantipur (Kathmandu)?', 'options' => ['1825 BS Ashwin 13', '1815 BS Baisakh 1', '1831 BS Magh 1', '1801 BS Chaitra 25'], 'answer' => 0, 'hint' => 'Conquered during the Indra Jatra festival.', 'explanation' => 'Kantipur was unified on 1825 BS Ashwin 13 during Indra Jatra.'],
            ['question' => 'Who was the last Malla King of Bhaktapur before unification?', 'options' => ['Jaya Prakash Malla', 'Ranajit Malla', 'Tej Narsingh Malla', 'Yaksha Malla'], 'answer' => 1, 'hint' => 'He was the Mit-father of Prithvi Narayan Shah.', 'explanation' => 'Ranajit Malla was the last Malla ruler of Bhaktapur.'],
            ['question' => 'The Treaty of Sugauli was ratified in which year between Nepal and British India?', 'options' => ['1814 AD', '1816 AD (March 4)', '1846 AD', '1857 AD'], 'answer' => 1, 'hint' => 'Concluded the Anglo-Nepalese War.', 'explanation' => 'Ratified on 4 March 1816 AD, fixing the Mechi and Mahakali boundary rivers.'],
            ['question' => 'Who commanded the heroic defense of Nalapani (Khalanga) fort in 1814?', 'options' => ['Amar Singh Thapa', 'Balbhadra Kunwar', 'Bhakti Thapa', 'Kalu Pande'], 'answer' => 1, 'hint' => 'Fiercely defended with only 600 soldiers.', 'explanation' => 'Captain Balbhadra Kunwar led the resistance at Nalapani.'],
            ['question' => 'The Kot Massacre occurred on which date, ushering in 104 years of Rana rule?', 'options' => ['1903 BS Ashwin 2 (1846 AD)', '1907 BS Falgun 7', '1882 BS Baisakh 1', '1911 BS Poush 1'], 'answer' => 0, 'hint' => '14 September 1846 AD at Hanuman Dhoka.', 'explanation' => 'The Kot Massacre took place on 1903 BS Ashwin 2.'],
            ['question' => 'Who is celebrated as the "Father of Education" among Rana Prime Ministers?', 'options' => ['Jung Bahadur Rana', 'Dev Shumsher Rana', 'Chandra Shumsher Rana', 'Juddha Shumsher Rana'], 'answer' => 1, 'hint' => 'Established over 150 primary schools and Gorkhapatra in 1958 BS.', 'explanation' => 'Dev Shumsher prioritized literacy and published Gorkhapatra.'],
            ['question' => 'When was the first codified Muluki Ain promulgated in Nepal?', 'options' => ['1903 BS', '1910 BS (1854 AD)', '1925 BS', '1950 BS'], 'answer' => 1, 'hint' => 'Introduced by Jung Bahadur Rana after his Europe tour.', 'explanation' => 'Jung Bahadur Rana enacted the Muluki Ain in 1910 BS (1854 AD).'],
            ['question' => 'On which date was Nepal declared a Federal Democratic Republic by the First CA?', 'options' => ['2063 BS Baisakh 11', '2065 BS Jestha 15 (28 May 2008)', '2072 BS Ashwin 3', '2062 BS Mangsir 7'], 'answer' => 1, 'hint' => 'Abolished the 240-year-old monarchy.', 'explanation' => 'The First CA declared Nepal a Republic on 2065 BS Jestha 15.'],
            ['question' => 'Who was the first democratically elected Prime Minister of Nepal in 2016 BS?', 'options' => ['Matrika Prasad Koirala', 'B.P. Koirala', 'Tanka Prasad Acharya', 'K.I. Singh'], 'answer' => 1, 'hint' => 'Elected after the 2015 BS General Elections.', 'explanation' => 'Bishweshwar Prasad Koirala became PM on 2016 BS Jestha 13.'],
            ['question' => 'Which Lichhavi King issued the "Manaank" coin and erected the Changu Narayan inscription in 521 BS?', 'options' => ['King Mandev I', 'King Anshuverma', 'King Narendra Dev', 'King Shiva Dev'], 'answer' => 0, 'hint' => 'The first authenticated historical king of Nepal.', 'explanation' => 'King Mandev I issued Manaank coins and the 464 AD Changu Narayan pillar inscription.'],
        ]);

        $this->addLesson($m1, 'History of World', 'nasu-history-of-world', 5, 'Focus on Ancient Civilizations, Industrial Revolution, French Revolution, First & Second World Wars, and the United Nations.', [
            ['question' => 'Which ancient civilization developed along the Nile River in northeastern Africa?', 'options' => ['Mesopotamian', 'Ancient Egyptian', 'Indus Valley', 'Maya'], 'answer' => 1, 'hint' => 'Famous for Hieroglyphics and the Great Pyramids.', 'explanation' => 'Ancient Egypt flourished along the lower reaches of the Nile River.'],
            ['question' => 'In which country did the Industrial Revolution originate in the mid-18th century?', 'options' => ['France', 'Great Britain', 'Germany', 'United States'], 'answer' => 1, 'hint' => 'Driven by steam engines, coal, iron, and textile mechanization.', 'explanation' => 'The Industrial Revolution began in Great Britain around 1760.'],
            ['question' => 'The French Revolution began in which year with the storming of the Bastille?', 'options' => ['1776 AD', '1789 AD (July 14)', '1804 AD', '1815 AD'], 'answer' => 1, 'hint' => 'Famous for the slogan: Liberty, Equality, Fraternity.', 'explanation' => 'The French Revolution commenced in 1789 with the storming of the Bastille on July 14.'],
            ['question' => 'Which immediate event triggered the outbreak of World War I in 1914?', 'options' => ['Invasion of Poland', 'Assassination of Archduke Franz Ferdinand in Sarajevo', 'Bombing of Pearl Harbor', 'Treaty of Versailles'], 'answer' => 1, 'hint' => 'The Austrian Archduke was assassinated by Gavrilo Princip in June 1914.', 'explanation' => 'The assassination of Archduke Franz Ferdinand on 28 June 1914 sparked World War I.'],
            ['question' => 'The First World War officially ended following the signing of which historic treaty?', 'options' => ['Treaty of Paris', 'Treaty of Versailles (1919)', 'Treaty of Rome', 'Treaty of Vienna'], 'answer' => 1, 'hint' => 'Signed in the Hall of Mirrors in Versailles Palace in June 1919.', 'explanation' => 'The Treaty of Versailles formally concluded World War I on 28 June 1919.'],
            ['question' => 'World War II began in September 1939 when Germany invaded which country?', 'options' => ['France', 'Poland', 'Soviet Union', 'Austria'], 'answer' => 1, 'hint' => 'Triggered Britain and France to declare war on Germany.', 'explanation' => 'Germany\'s invasion of Poland on 1 September 1939 initiated World War II.'],
            ['question' => 'On which two Japanese cities were atomic bombs dropped in August 1945, ending WWII?', 'options' => ['Tokyo & Osaka', 'Hiroshima (Aug 6) & Nagasaki (Aug 9)', 'Kyoto & Yokohama', 'Nagoya & Kobe'], 'answer' => 1, 'hint' => 'Bombed on August 6 and 9, 1945.', 'explanation' => 'Atomic bombs were dropped on Hiroshima on August 6 and Nagasaki on August 9, 1945.'],
            ['question' => 'In which year did the Russian Bolshevik Revolution led by Vladimir Lenin occur?', 'options' => ['1905 AD', '1917 AD (October Revolution)', '1924 AD', '1939 AD'], 'answer' => 1, 'hint' => 'Overthrew the Tsarist autocracy in 1917.', 'explanation' => 'The October Revolution in 1917 established the Soviet state under Bolshevik leadership.'],
            ['question' => 'Who served as the primary leader of India\'s non-violent independence movement against British rule?', 'options' => ['Jawaharlal Nehru', 'Mahatma Gandhi (Mohandas Karamchand Gandhi)', 'Subhas Chandra Bose', 'Bhagat Singh'], 'answer' => 1, 'hint' => 'Pioneered Satyagraha and Ahimsa (non-violence).', 'explanation' => 'Mahatma Gandhi led the nationwide civil disobedience and non-violence movements.'],
            ['question' => 'On which date was the United Nations (UN) Charter officially enforced?', 'options' => ['1945 October 24 (UN Day)', '1948 December 10', '1950 January 1', '1944 June 6'], 'answer' => 0, 'hint' => 'Celebrated globally as United Nations Day.', 'explanation' => 'The UN was formally founded on 24 October 1945 upon ratification of the UN Charter.'],
        ]);

        // Module 2: IQ
        $m2 = Module::create([
            'course_id' => $course->id,
            'title' => 'IQ (Samanya Bauddhik Parikshan)',
            'slug' => 'nasu-iq-bauddhik',
            'order' => 2,
            'is_published' => true,
            'description' => 'Granular lessons for Verbal Analogy, Classification, Number Series, Letter Series, and Coding-Decoding.',
            'key_points' => "• Step-by-Step Logic & Shortcuts\n• Pattern Recognition & Difference Trees\n• Direction Vectors, Alphabet Numbers & Syllogisms",
            'notes' => 'Complete techniques, formulas and shortcuts for Nayab Subba IQ.',
        ]);

        $this->addLesson($m2, 'Analogy', 'nasu-iq-analogy', 1, 'Focus on Verbal & Semantic Analogies, finding exact conceptual, functional, and relational similarities.', [
            ['question' => 'Pen : Write :: Knife : ?', 'options' => ['Cut', 'Shave', 'Sharpen', 'Draw'], 'answer' => 0, 'hint' => 'Primary function of the tool.', 'explanation' => 'A pen is used to write; a knife is used to cut.'],
            ['question' => 'Doctor : Hospital :: Teacher : ?', 'options' => ['School', 'Laboratory', 'Library', 'Court'], 'answer' => 0, 'hint' => 'Primary workplace of the professional.', 'explanation' => 'A doctor works in a hospital; a teacher works in a school.'],
            ['question' => 'Bird : Fly :: Fish : ?', 'options' => ['Walk', 'Swim', 'Crawl', 'Float'], 'answer' => 1, 'hint' => 'Primary mode of locomotion.', 'explanation' => 'Birds fly in air; fish swim in water.'],
            ['question' => 'Nepal : Kathmandu :: France : ?', 'options' => ['London', 'Paris', 'Berlin', 'Rome'], 'answer' => 1, 'hint' => 'Capital city of the nation.', 'explanation' => 'Kathmandu is the capital of Nepal; Paris is the capital of France.'],
            ['question' => 'Eye : See :: Ear : ?', 'options' => ['Hear', 'Taste', 'Smell', 'Touch'], 'answer' => 0, 'hint' => 'Primary sensory function of the organ.', 'explanation' => 'Eyes are for seeing; ears are for hearing.'],
            ['question' => 'Thermometer : Temperature :: Barometer : ?', 'options' => ['Atmospheric Pressure', 'Humidity', 'Rainfall', 'Wind Speed'], 'answer' => 0, 'hint' => 'Physical parameter measured by the instrument.', 'explanation' => 'A barometer measures atmospheric pressure.'],
            ['question' => 'Author : Book :: Sculptor : ?', 'options' => ['Statue', 'Canvas', 'Chisel', 'Museum'], 'answer' => 0, 'hint' => 'The creative product created by the artist.', 'explanation' => 'An author produces a book; a sculptor creates a statue.'],
            ['question' => 'Clock : Time :: Odometer : ?', 'options' => ['Speed', 'Distance', 'Fuel', 'Direction'], 'answer' => 1, 'hint' => 'Device that measures vehicle mileage.', 'explanation' => 'A clock measures time; an odometer measures travel distance.'],
            ['question' => 'Moon : Satellite :: Earth : ?', 'options' => ['Star', 'Planet', 'Galaxy', 'Asteroid'], 'answer' => 1, 'hint' => 'Astronomical classification.', 'explanation' => 'The Moon is a natural satellite; Earth is a planet.'],
            ['question' => 'Taka : Bangladesh :: Yen : ?', 'options' => ['China', 'Japan', 'South Korea', 'Thailand'], 'answer' => 1, 'hint' => 'Official national currency.', 'explanation' => 'Taka is the currency of Bangladesh; Yen is the currency of Japan.'],
        ]);

        $this->addLesson($m2, 'Classification', 'nasu-iq-classification', 2, 'Focus on Odd-One-Out classification by identifying differing semantic, mathematical, and spatial properties.', [
            ['question' => 'Find the odd one out: Apple, Banana, Orange, Potato', 'options' => ['Apple', 'Banana', 'Orange', 'Potato'], 'answer' => 3, 'hint' => 'Identify fruits versus a root vegetable/tuber.', 'explanation' => 'Potato is a root vegetable/tuber; the others are fruits.'],
            ['question' => 'Find the odd number: 13, 17, 19, 21, 23', 'options' => ['13', '17', '21', '23'], 'answer' => 2, 'hint' => 'Check which number is composite (divisible by 3 and 7).', 'explanation' => '21 is composite (3 * 7); all others are prime numbers.'],
            ['question' => 'Find the odd one out: Dog, Cat, Cow, Tiger', 'options' => ['Dog', 'Cat', 'Cow', 'Tiger'], 'answer' => 3, 'hint' => 'Domestic animals versus a wild carnivorous predator.', 'explanation' => 'Tiger is a wild predator; others are domestic animals.'],
            ['question' => 'Find the odd one out: Kathmandu, Pokhara, Thimphu, Biratnagar', 'options' => ['Kathmandu', 'Pokhara', 'Thimphu', 'Biratnagar'], 'answer' => 2, 'hint' => 'Nepalese cities versus a foreign capital city.', 'explanation' => 'Thimphu is the capital of Bhutan; all others are cities in Nepal.'],
            ['question' => 'Find the odd one out: Circle, Square, Triangle, Cube', 'options' => ['Circle', 'Square', 'Triangle', 'Cube'], 'answer' => 3, 'hint' => '2D plane geometric shapes versus a 3D solid figure.', 'explanation' => 'Cube is a 3D three-dimensional shape; others are 2D planar figures.'],
            ['question' => 'Find the odd one out: Copper, Silver, Gold, Plastic', 'options' => ['Copper', 'Silver', 'Gold', 'Plastic'], 'answer' => 3, 'hint' => 'Conductive metals versus a synthetic non-metallic polymer.', 'explanation' => 'Plastic is a non-metal polymer; others are metallic elements.'],
            ['question' => 'Find the odd one out: 64, 125, 216, 144', 'options' => ['64', '125', '216', '144'], 'answer' => 3, 'hint' => 'Check which number is only a square and not a cube.', 'explanation' => '144 is 12^2 (not a cube); 64=4^3, 125=5^3, 216=6^3 are all cubes.'],
            ['question' => 'Find the odd one out: Eye, Ear, Nose, Kidney', 'options' => ['Eye', 'Ear', 'Nose', 'Kidney'], 'answer' => 3, 'hint' => 'External sense organs versus an internal biological organ.', 'explanation' => 'Kidney is an internal visceral organ; others are external sense organs.'],
            ['question' => 'Find the odd one out: January, March, July, November', 'options' => ['January', 'March', 'July', 'November'], 'answer' => 3, 'hint' => 'Count the number of days in each month (31 days vs 30 days).', 'explanation' => 'November has 30 days; January, March, and July have 31 days.'],
            ['question' => 'Find the odd one out: Physics, Chemistry, Biology, History', 'options' => ['Physics', 'Chemistry', 'Biology', 'History'], 'answer' => 3, 'hint' => 'Natural pure sciences versus a social science / humanities subject.', 'explanation' => 'History is a humanities discipline; others are natural sciences.'],
        ]);

        $this->addLesson($m2, 'Number Series', 'nasu-iq-number-series', 3, 'Focus on Arithmetic progressions, geometric jumps, alternating series, and difference trees.', [
            ['question' => 'Find the missing number: 2, 4, 6, 8, ?', 'options' => ['9', '10', '11', '12'], 'answer' => 1, 'hint' => 'Consecutive even numbers increasing by +2.', 'explanation' => '8 + 2 = 10.'],
            ['question' => 'Find the missing number: 3, 6, 12, 24, 48, ?', 'options' => ['72', '84', '96', '108'], 'answer' => 2, 'hint' => 'Each number is multiplied by 2 (geometric progression).', 'explanation' => '48 * 2 = 96.'],
            ['question' => 'Find the missing number: 1, 4, 9, 16, 25, ?', 'options' => ['30', '32', '36', '49'], 'answer' => 2, 'hint' => 'Sequence of consecutive squares: 1^2, 2^2, 3^2, 4^2, 5^2, 6^2.', 'explanation' => '6^2 = 36.'],
            ['question' => 'Find the missing number: 5, 10, 15, 20, 25, ?', 'options' => ['28', '30', '35', '40'], 'answer' => 1, 'hint' => 'Arithmetic series with common difference +5.', 'explanation' => '25 + 5 = 30.'],
            ['question' => 'Find the missing number: 100, 90, 80, 70, ?', 'options' => ['50', '60', '65', '55'], 'answer' => 1, 'hint' => 'Decreasing by -10 each step.', 'explanation' => '70 - 10 = 60.'],
            ['question' => 'Find the missing number: 2, 3, 5, 7, 11, ?', 'options' => ['12', '13', '14', '15'], 'answer' => 1, 'hint' => 'Consecutive prime numbers.', 'explanation' => 'The prime number following 11 is 13.'],
            ['question' => 'Find the missing number: 1, 8, 27, 64, ?', 'options' => ['100', '125', '144', '216'], 'answer' => 1, 'hint' => 'Cubes of integers: 1^3, 2^3, 3^3, 4^3, 5^3.', 'explanation' => '5^3 = 125.'],
            ['question' => 'Find the missing number: 7, 14, 28, 56, ?', 'options' => ['98', '112', '120', '128'], 'answer' => 1, 'hint' => 'Doubling at each step: x * 2.', 'explanation' => '56 * 2 = 112.'],
            ['question' => 'Find the missing number: 10, 15, 22, 31, 42, ?', 'options' => ['53', '55', '57', '60'], 'answer' => 1, 'hint' => 'Differences increase by +2: +5, +7, +9, +11, +13.', 'explanation' => '42 + 13 = 55.'],
            ['question' => 'Find the missing number: 1, 1, 2, 3, 5, 8, 13, ?', 'options' => ['18', '20', '21', '24'], 'answer' => 2, 'hint' => 'Fibonacci sequence: sum of previous two numbers (5 + 8 = 13, 8 + 13 = ?).', 'explanation' => 'Fibonacci rule: 8 + 13 = 21.'],
        ]);

        $this->addLesson($m2, 'Letter Series', 'nasu-iq-letter-series', 4, 'Focus on Alphabet positional values (A=1 ... Z=26), skips, backward positions, and paired series.', [
            ['question' => 'Find the next letter: A, C, E, G, ?', 'options' => ['H', 'I', 'J', 'K'], 'answer' => 1, 'hint' => 'Skipping one letter (+2 positions): A(1), C(3), E(5), G(7).', 'explanation' => 'G(7) + 2 = I(9).'],
            ['question' => 'Find the next letter: Z, Y, X, W, ?', 'options' => ['U', 'V', 'T', 'S'], 'answer' => 1, 'hint' => 'Alphabet counted backward in reverse order.', 'explanation' => 'W minus 1 position is V.'],
            ['question' => 'Find the next letter: B, D, F, H, ?', 'options' => ['I', 'J', 'K', 'L'], 'answer' => 1, 'hint' => 'Even numbered alphabet positions: 2, 4, 6, 8, 10.', 'explanation' => 'Position 10 corresponds to the letter J.'],
            ['question' => 'Find the next letter in the series: A, D, G, J, ?', 'options' => ['K', 'L', 'M', 'N'], 'answer' => 2, 'hint' => 'Advancing by +3 positions each step.', 'explanation' => 'J(10) + 3 = M(13).'],
            ['question' => 'Find the next pair: AZ, BY, CX, ?', 'options' => ['DU', 'DW', 'EV', 'DX'], 'answer' => 1, 'hint' => 'First letter forward (+1), second letter backward (-1).', 'explanation' => 'D is 4th from start, W is 4th from end -> DW.'],
            ['question' => 'Find the next letter: Z, X, V, T, ?', 'options' => ['Q', 'R', 'S', 'P'], 'answer' => 1, 'hint' => 'Decreasing by 2 positions backward: 26, 24, 22, 20, 18.', 'explanation' => '18th position in alphabet is R.'],
            ['question' => 'Find the next letter: A, B, D, G, K, ?', 'options' => ['N', 'O', 'P', 'Q'], 'answer' => 2, 'hint' => 'Differences increase by +1: +1, +2, +3, +4, +5.', 'explanation' => 'K(11) + 5 = P(16).'],
            ['question' => 'Find the next letter: C, F, I, L, O, ?', 'options' => ['P', 'Q', 'R', 'S'], 'answer' => 2, 'hint' => 'Multiples of 3 in the alphabet: 3, 6, 9, 12, 15, 18.', 'explanation' => '18th position is R.'],
            ['question' => 'Find the next letter: E, J, O, T, ?', 'options' => ['W', 'X', 'Y', 'Z'], 'answer' => 2, 'hint' => 'Multiples of 5 (EJOTY mnemonic).', 'explanation' => '25th position is Y.'],
            ['question' => 'Find the next pair: AB, CD, EF, GH, ?', 'options' => ['IJ', 'JK', 'HI', 'IK'], 'answer' => 0, 'hint' => 'Consecutive 2-letter alphabet pairs.', 'explanation' => 'Following GH is IJ.'],
        ]);

        $this->addLesson($m2, 'Coding-Decoding', 'nasu-iq-coding-decoding', 5, 'Focus on Substitution codes, numerical cipher values, positional shifting, and matrix coding.', [
            ['question' => 'If CAT is coded as DBU, how is DOG coded?', 'options' => ['EPH', 'EPG', 'FQH', 'DPH'], 'answer' => 0, 'hint' => 'Shift each letter forward by 1 (+1).', 'explanation' => 'D(+1)=E, O(+1)=P, G(+1)=H -> EPH.'],
            ['question' => 'If BOOK is coded as 2-15-15-11, what is the code for PEN?', 'options' => ['16-5-14', '15-5-14', '16-6-14', '16-5-15'], 'answer' => 0, 'hint' => 'Direct alphabet position numbers: P=16, E=5, N=14.', 'explanation' => 'P(16), E(5), N(14) -> 16-5-14.'],
            ['question' => 'If NEPAL is written as LAPEN in reverse, how is KATHMANDU written?', 'options' => ['UDNAMHTAK', 'UDNMAHTAK', 'UDNAMHAKT', 'UDNMAHKAT'], 'answer' => 0, 'hint' => 'Reverse the letters completely from back to front.', 'explanation' => 'K-A-T-H-M-A-N-D-U reversed is U-D-N-A-M-H-T-A-K.'],
            ['question' => 'In a code, RED is coded as 27 (18+5+4). What is the numerical sum code for BLUE (2+12+21+5)?', 'options' => ['38', '40', '42', '44'], 'answer' => 1, 'hint' => 'Sum the positional values: 2 + 12 + 21 + 5.', 'explanation' => 'B(2) + L(12) + U(21) + E(5) = 40.'],
            ['question' => 'If WATER is coded as YCVGT (+2), what is the code for FIRE?', 'options' => ['HKTG', 'HKTF', 'GJTF', 'HLTG'], 'answer' => 0, 'hint' => 'Add 2 to each letter: F(+2)=H, I(+2)=K, R(+2)=T, E(+2)=G.', 'explanation' => 'F->H, I->K, R->T, E->G = HKTG.'],
            ['question' => 'If WHITE is called BLACK, BLACK is called RED, and RED is called GREEN, what is the color of clear human blood?', 'options' => ['RED', 'GREEN', 'BLACK', 'WHITE'], 'answer' => 1, 'hint' => 'Blood is red, and RED is coded as GREEN.', 'explanation' => 'Blood is red; in this substitution code, RED is called GREEN.'],
            ['question' => 'If MAN = 28 (13+1+14), what is SUN (19+21+14)?', 'options' => ['50', '54', '56', '58'], 'answer' => 1, 'hint' => 'Sum of positions: 19 + 21 + 14.', 'explanation' => 'S(19) + U(21) + N(14) = 54.'],
            ['question' => 'If DELHI is coded as CCIDD, then BOMBAY is coded with which shifting logic?', 'options' => ['Alphabet shift rule', 'Positional shift', 'Pattern code', 'Letter rotation'], 'answer' => 0, 'hint' => 'Each letter is decremented by increasing amounts: -1, -2, -3, -4, -5.', 'explanation' => 'D(-1)=C, E(-2)=C, L(-3)=I, H(-4)=D, I(-5)=D.'],
            ['question' => 'If A=1, B=2, C=3, what is the value of LOKSEWA (12+15+11+19+5+23+1)?', 'options' => ['80', '86', '88', '90'], 'answer' => 1, 'hint' => 'Add: 12 + 15 + 11 + 19 + 5 + 23 + 1.', 'explanation' => '12+15+11+19+5+23+1 = 86.'],
            ['question' => 'If GOLD is coded as HOME (+1), what is COME coded as?', 'options' => ['DONE', 'DOME', 'BONE', 'CONE'], 'answer' => 0, 'hint' => 'C(+1)=D, O=O, M=N, E=E -> DONE.', 'explanation' => 'G(+1)=H, L(+1)=M; so C(+1)=D, M(+1)=N -> DONE.'],
        ]);

        // Module 3: Office Management
        $m3 = Module::create([
            'course_id' => $course->id,
            'title' => 'Karyalaya Byawasthapan (Office Management)',
            'slug' => 'nasu-karyalaya-byawasthapan',
            'order' => 3,
            'is_published' => true,
            'description' => 'Office filing, correspondence, Darta, Chalani, Tippani writing, and Public Procurement.',
            'key_points' => "• Office Operations & Record Preservation\n• Civil Service Act & Regulations\n• Citizen Charter, RTI & Accounting",
            'notes' => 'Complete office administration syllabus notes.',
        ]);

        $this->addLesson($m3, 'Office Management', 'nasu-office-management-core', 1, 'Focus on Office Management principles, definitions, office layout, workflow, and records administration.', [
            ['question' => 'Which of the following is mainly concerned with the systematic arrangement and preservation of office documents?',
                'options' => ['Indexing', 'Filing System (Misil ra Darta)', 'Chalani', 'Tippani'],
                'answer' => 1, 'hint' => 'System of organizing, cataloging, and safely storing official records.',
                'explanation' => 'Filing is the systematic preservation and arrangement of documents so they can be retrieved quickly.'],
            ['question' => 'What is the primary objective of registering incoming official letters in the "Darta Kitab" (Registration Book)?',
                'options' => ['To prove receipt of incoming correspondence and track its administrative handling', 'To destroy old records', 'To calculate postal fees', 'To assign staff leave'],
                'answer' => 0, 'hint' => 'Maintains an official legal entry for every incoming letter or petition.',
                'explanation' => 'Darta creates an official audit trail of incoming letters with date, sender, subject, and serial number.'],
            ['question' => 'What is the register used to record all outgoing letters from an office called in government administration?',
                'options' => ['Darta Register', 'Chalani Register (Dispatch Book)', 'Haziri Register', 'Panchika Register'],
                'answer' => 1, 'hint' => 'Chalani number is stamped on all dispatched documents.',
                'explanation' => 'Chalani Register records outgoing letters, dispatch dates, recipient names, and serial numbers.'],
            ['question' => 'In civil service administration, what is a "Tippani" primarily used for?',
                'options' => ['Issuing public press releases', 'Submitting institutional facts, legal grounds, and opinions upward for executive decision-making', 'Printing citizen identity cards', 'Conducting staff performance reviews'],
                'answer' => 1, 'hint' => 'A structured administrative file note presenting facts and recommendations for higher approval.',
                'explanation' => 'A Tippani is an internal administrative file note initiated by lower staff to seek an authorized decision from higher authorities.'],
            ['question' => 'Under Nepal\'s Record Preservation Rules, how are government records categorized?',
                'options' => ['Class Ka (Permanent), Class Kha (20 yrs), Class Ga (10 yrs), Class Gha (1-5 yrs)', 'Top Secret and Open only', 'Class A, B, C only', '5-year and 10-year only'],
                'answer' => 0, 'hint' => 'Divided into 4 classes: Ka (Permanent), Kha (20 yrs), Ga (10 yrs), Gha (destroyable after 1-5 yrs).',
                'explanation' => 'Government archives classify documents into Ka (Permanent), Kha (20 years), Ga (10 years), and Gha (1 to 5 years).'],
            ['question' => 'Under the Civil Service Act 2049, what is the mandatory age of retirement for civil servants in Nepal?',
                'options' => ['55 Years', '58 Years', '60 Years', '62 Years'],
                'answer' => 1, 'hint' => 'Retirement age under the current 2049 Civil Service Act is 58 years.',
                'explanation' => 'Section 33 of the Civil Service Act 2049 sets the compulsory retirement age at 58 years.'],
            ['question' => 'According to the Good Governance Act 2064, what must a Citizen Charter (Nagarik Bada-patra) contain?',
                'options' => ['Service name, required documents, fee, processing time, responsible officer, and grievance desk', 'Staff salaries only', 'Office expenditure statement only', 'Political manifesto'],
                'answer' => 0, 'hint' => 'Full transparency on service delivery timeframe, fees, and procedures.',
                'explanation' => 'Section 25 mandates that Citizen Charters detail service specifications, fees, timeline, and grievance mechanisms.'],
            ['question' => 'Within how many days must an Information Officer provide requested public information under the RTI Act 2064 (for standard requests)?',
                'options' => ['Immediately or within 15 days', 'Within 30 days', 'Within 60 days', 'Within 90 days'],
                'answer' => 0, 'hint' => 'Immediately if possible, or within a maximum of 15 days.',
                'explanation' => 'Section 7(1) of the RTI Act requires information to be provided immediately or at most within 15 days.'],
            ['question' => 'Which institution conducts the final financial audit of all government entities under Article 241 of the Constitution?',
                'options' => ['Financial Comptroller General Office (FCGO)', 'Auditor General of Nepal (Maha Lekhaparikshak)', 'Ministry of Finance', 'CIAA'],
                'answer' => 1, 'hint' => 'Constitutional body under Part 22.',
                'explanation' => 'The Auditor General conducts final external audits of all constitutional and executive public bodies.'],
            ['question' => 'Under Public Procurement Act 2063, what is the primary method of procurement for large public works?',
                'options' => ['Direct purchase without quotations', 'Open Competitive Bidding (National / International Competitive Bidding - NCB/ICB)', 'Sealed quotation from single vendor', 'Negotiated private contract'],
                'answer' => 1, 'hint' => 'Ensures maximum transparency and value for money through competitive tendering.',
                'explanation' => 'Open competitive bidding is the mandatory standard procurement method under the Public Procurement Act.'],
        ]);
    }

    /* =========================================================================
     * 2. SECTION OFFICER TAYARI
     * ========================================================================= */
    private function seedGranularSectionOfficer(): void
    {
        $course = $this->cleanCourseModules('section-officer-tayari');
        if (! $course) {
            return;
        }

        // Module 1: GK & AAT
        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Pratham Patra: Administrative Aptitude Test (GK & AAT)',
            'slug' => 'officer-gk-aat',
            'order' => 1,
            'is_published' => true,
            'description' => 'General Knowledge, Global Geopolitics, Analytical Reasoning, and Critical Decision-Making for Section Officer.',
            'key_points' => "• World Geopolitics, UN Treaties & Climate Conventions\n• Analytical Problem Solving & Critical Reasoning\n• Constitutional Jurisprudence & Public Policy",
            'notes' => 'Complete theoretical and analytical notes for Section Officer 1st Paper.',
        ]);

        $this->addLesson($m1, 'Global Governance & International Treaties', 'officer-global-governance-diplomacy', 1, 'Focus on the United Nations, specialized agencies, treaties, climate conventions, and multilateral diplomacy.', [
            ['question' => 'On which date was the United Nations (UN) Charter officially signed and ratified?', 'options' => ['1942 AD', '1945 AD (October 24)', '1948 AD', '1950 AD'], 'answer' => 1, 'hint' => 'Celebrated globally as United Nations Day.', 'explanation' => 'The UN was formally founded on 24 October 1945.'],
            ['question' => 'When was Nepal admitted to the United Nations as a member state?', 'options' => ['1950 AD', '1955 AD (December 14)', '1960 AD', '1965 AD'], 'answer' => 1, 'hint' => 'Admitted in December 1955 under the package deal.', 'explanation' => 'Nepal joined the UN on 14 December 1955 AD.'],
            ['question' => 'Which international agreement adopted the 17 Sustainable Development Goals (SDGs 2030)?', 'options' => ['Kyoto Protocol', 'Paris Climate Agreement', 'UN Resolution 70/1 (Agenda 2030)', 'Rio Summit'], 'answer' => 2, 'hint' => 'Adopted in September 2015 with 169 targets.', 'explanation' => 'UN Agenda 2030 adopted the 17 SDGs to be achieved by 2030.'],
            ['question' => 'Where is the permanent Secretariat of SAARC located?', 'options' => ['New Delhi', 'Islamabad', 'Kathmandu, Nepal', 'Dhaka'], 'answer' => 2, 'hint' => 'Headquartered in Tridevi Marg, Kathmandu since 1987.', 'explanation' => 'The SAARC Secretariat is in Kathmandu, Nepal.'],
            ['question' => 'What is the primary target of the Paris Climate Agreement (COP21)?', 'options' => ['Limit warming well below 2°C, preferably to 1.5°C above pre-industrial levels', 'Reduce temperature by 3°C', 'Maintain current emissions', 'Zero carbon by 2025'], 'answer' => 0, 'hint' => 'Aims to keep global warming well below 2°C.', 'explanation' => 'The Paris Agreement aims to limit global temperature rise to well below 2°C, striving for 1.5°C.'],
            ['question' => 'Where is the Asian Development Bank (ADB) headquartered?', 'options' => ['Tokyo', 'Manila, Philippines', 'Beijing', 'Singapore'], 'answer' => 1, 'hint' => 'Headquartered in Mandaluyong, Metro Manila since 1966.', 'explanation' => 'ADB headquarters are in Manila, Philippines.'],
            ['question' => 'Which treaty established the European Union (EU) in 1992?', 'options' => ['Treaty of Rome', 'Maastricht Treaty', 'Treaty of Lisbon', 'Versailles Treaty'], 'answer' => 1, 'hint' => 'Signed in the Dutch city of Maastricht.', 'explanation' => 'The Maastricht Treaty established the European Union.'],
            ['question' => 'In which year was BIMSTEC founded via the Bangkok Declaration?', 'options' => ['1985 AD', '1997 AD (June 6)', '2004 AD', '2014 AD'], 'answer' => 1, 'hint' => 'Founded in 1997; Nepal joined in 2004.', 'explanation' => 'BIMSTEC was founded on 6 June 1997.'],
            ['question' => 'Which article of the UN Charter guarantees the inherent right of individual or collective self-defense?', 'options' => ['Article 2', 'Article 24', 'Article 51', 'Article 99'], 'answer' => 2, 'hint' => 'Chapter VII self-defense provision.', 'explanation' => 'Article 51 explicitly preserves the inherent right of self-defense.'],
            ['question' => 'Where is the International Court of Justice (ICJ) located?', 'options' => ['Geneva', 'The Hague, Netherlands', 'New York', 'Vienna'], 'answer' => 1, 'hint' => 'Principal judicial organ of the UN at Peace Palace.', 'explanation' => 'The ICJ is headquartered in The Hague, Netherlands.'],
        ]);

        // Module 2: Shasan Pranali
        $m2 = Module::create([
            'course_id' => $course->id,
            'title' => 'Dosro Patra: Shasan Pranali (Governance System)',
            'slug' => 'officer-shasan-pranali',
            'order' => 2,
            'is_published' => true,
            'description' => 'New Public Management, Federalism, Public Financial Management, Civil Service Integrity, and Strategic Administration.',
            'key_points' => "• New Public Management (NPM) vs Classical Bureaucracy\n• Three-tier Federal Governance Coordination in Nepal\n• Performance-Based Management, Integrity & Digital Transformation",
            'notes' => 'Detailed governance analysis and administrative reform frameworks.',
        ]);

        $this->addLesson($m2, 'New Public Management Concepts & Public Policy', 'officer-npm-governance-concepts', 1, 'Focus on NPM doctrines, managerial autonomy, performance metrics, and public policy frameworks.', [
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

    /* =========================================================================
     * 3. NRB OFFICER TAYARI
     * ========================================================================= */
    private function seedGranularNRBOfficer(): void
    {
        $course = $this->cleanCourseModules('nrb-officer-tayari');
        if (! $course) {
            return;
        }

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Economics (Micro & Macroeconomics)',
            'slug' => 'nrb-officer-economics',
            'order' => 1,
            'is_published' => true,
            'description' => 'Demand, supply, price elasticity, market structures, national income accounting, inflation, IS-LM, and monetary economics.',
            'key_points' => "• Elasticity of Demand & Supply\n• GDP Calculation Methods (Expenditure, Output, Income)\n• Fisher's Quantity Theory of Money & Keynesian Economics",
            'notes' => 'Complete theoretical and quantitative economics syllabus notes.',
        ]);

        $this->addLesson($m1, 'Demand Elasticity, Market Equilibrium & Pricing', 'nrb-officer-demand-elasticity', 1, 'Focus on Price Elasticity of Demand, Income Elasticity, Cross Elasticity, and Market Equilibrium pricing.', [
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

    /* =========================================================================
     * 4. NRB ASSISTANT DIRECTOR TAYARI
     * ========================================================================= */
    private function seedGranularNRBAD(): void
    {
        $course = $this->cleanCourseModules('nrb-assistant-director-tayari');
        if (! $course) {
            return;
        }

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Banking Laws & Regulations',
            'slug' => 'nrb-ad-banking-laws',
            'order' => 1,
            'is_published' => true,
            'description' => 'NRB Act 2058, BAFIA 2073, FERA 2019, Unified Directives, AML/CFT Act, and Basel III Standards.',
            'key_points' => "• NRB Act 2058 Objectives & Autonomy (Section 4)\n• BAFIA 2073 Licensing, Classification & Governance\n• Unified Directives: Capital Adequacy, NPL Classification & Loan Loss Provisioning",
            'notes' => 'Complete legal & statutory analysis for NRB Assistant Director.',
        ]);

        $this->addLesson($m1, 'NRB Act 2058 & BAFIA 2073 Governance', 'nrb-ad-legal-governance', 1, 'Focus on Central Bank governance, BAFIA licensing classes, NPL classification rules, and Basel III standards.', [
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

    /* =========================================================================
     * 5. NEPAL CONSTITUTION & LAW
     * ========================================================================= */
    private function seedGranularConstitutionLaw(): void
    {
        $course = $this->cleanCourseModules('nepal-constitution-ra-kanun');
        if (! $course) {
            return;
        }

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Nepal ko Samvidhan 2072',
            'slug' => 'nepal-constitution-core-2072',
            'order' => 1,
            'is_published' => true,
            'description' => 'Constitutional history, Preamble, Fundamental Rights (Articles 16-48), Directive Principles, Federal Legislature, Executive, and Judiciary.',
            'key_points' => "• Constitutional Sovereignty, Rule of Law & Republican Framework\n• 31 Fundamental Rights & Constitutional Remedies (Article 46/133)\n• Federal Power Devolution across Federal, Provincial & Local Lists",
            'notes' => 'Exhaustive constitutional law syllabus notes for competitive legal examinations.',
        ]);

        $this->addLesson($m1, 'Fundamental Rights & Constitutional Remedies', 'const-fundamental-rights-remedies', 1, 'Focus on Articles 16 to 48 of the Constitution, Fundamental Rights, Writs (Habeas Corpus, Mandamus, Certiorari), and Amendment procedures.', [
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

    /* =========================================================================
     * 6. COMPUTER SKILL PARIKSHA
     * ========================================================================= */
    private function seedGranularComputerSkill(): void
    {
        $course = $this->cleanCourseModules('computer-sip-pariksha');
        if (! $course) {
            return;
        }

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'MS Office Applications',
            'slug' => 'comp-ms-office-applications',
            'order' => 1,
            'is_published' => true,
            'description' => 'Practical & theoretical computer syllabus covering Windows OS, Word, Excel, PowerPoint, Nepali Unicode, and Internet security.',
            'key_points' => "• MS Word Shortcuts, Mail Merge & Tab Leaders\n• MS Excel VLOOKUP, IF, SUMIF, Pivot Tables & Data Validation\n• Nepali Unicode Romanized/Traditional & Cyber Safety",
            'notes' => 'Complete step-by-step practical guides for PSC Computer Skill Test.',
        ]);

        $this->addLesson($m1, 'MS Word & Excel Productivity', 'comp-word-excel-productivity', 1, 'Focus on MS Word formatting, Mail Merge, Page Breaks, Excel formulas (SUMIF, VLOOKUP), and Pivot Tables.', [
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

    /* =========================================================================
     * 7. IQ & GENERAL APTITUDE
     * ========================================================================= */
    private function seedGranularIQAptitude(): void
    {
        $course = $this->cleanCourseModules('baudhik-parikshan-iq-aptitude');
        if (! $course) {
            return;
        }

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Verbal Reasoning',
            'slug' => 'iq-verbal-reasoning-module',
            'order' => 1,
            'is_published' => true,
            'description' => 'Verbal analogies, classification, syllogisms, blood relations, direction sense, seating arrangement, and critical deduction.',
            'key_points' => "• Word & Semantic Analogies\n• Family Tree & Blood Relations Algorithms\n• Direction Vectors, Distances & Seating Logic",
            'notes' => 'Master logical reasoning formulas and speed shortcuts.',
        ]);

        $this->addLesson($m1, 'Verbal Reasoning & Deduction', 'iq-verbal-reasoning-deduction', 1, 'Focus on verbal analogies, coding-decoding, blood relations, direction sense, and syllogisms.', [
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

    /* =========================================================================
     * 8. NEPAL TELECOM TAYARI
     * ========================================================================= */
    private function seedGranularTelecom(): void
    {
        $course = $this->cleanCourseModules('nepal-telecom-tayari');
        if (! $course) {
            return;
        }

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Telecommunication Networks',
            'slug' => 'ntc-networks-module',
            'order' => 1,
            'is_published' => true,
            'description' => 'Telecommunication switching, GSM/LTE/5G mobile architectures, Optical FTTH, IP Routing, and Nepal Telecommunications Act 2053.',
            'key_points' => "• Mobile Generations: 2G GSM, 3G UMTS, 4G LTE, 5G NR Architectures\n• Optical Fiber Transmission (WDM, GPON/FTTH)\n• Nepal Telecommunications Act 2053 & NTA Regulation",
            'notes' => 'Complete technical and regulatory study notes for Nepal Telecom recruitment examinations.',
        ]);

        $this->addLesson($m1, 'Cellular Mobile Systems & Optical Networks', 'ntc-cellular-mobile-optical', 1, 'Focus on GSM architecture, 4G LTE, optical fiber wavelengths (1310/1550nm), GPON FTTH, and NTA regulatory framework.', [
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
}
