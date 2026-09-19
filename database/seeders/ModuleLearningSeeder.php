<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleLearningSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📚 Populating Course Syllabus PDFs, Modules, and Lessons with Notes, PDFs, and Quizzes with Hints...');

        // 1. Assign Master Syllabus PDF to each Course
        $courses = Course::all();
        foreach ($courses as $course) {
            $course->update([
                'syllabus_pdf' => 'storage/docs/Loksewa_Student_User_Manual.pdf',
            ]);
        }

        // 2. Assign Rich Content, Key Focus Points, PDF Files, and Quizzes with Hints to Modules
        $modules = Module::all();

        $sampleQuizzesByTopic = [
            'constitution' => [
                [
                    'question' => 'नेपालको वर्तमान संविधान अनुसार मौलिक हक सम्बन्धी व्यवस्था कुन भागमा गरिएको छ?',
                    'options' => ['भाग २', 'भाग ३', 'भाग ४', 'भाग ५'],
                    'answer' => 1,
                    'hint' => 'यो भाग धारा १६ देखि धारा ४६ सम्म विस्तृत छ र जम्मा ३१ वटा हकहरू समावेश छन्।',
                    'explanation' => 'नेपालको संविधानको भाग ३ (धारा १६ देखि ४६ सम्म) ३१ वटा मौलिक हकको व्यवस्था गरिएको छ।',
                ],
                [
                    'question' => 'लोक सेवा आयोगको अध्यक्ष तथा सदस्यको पदावधि कति वर्षको हुन्छ?',
                    'options' => ['४ वर्ष', '५ वर्ष', '६ वर्ष', '७ वर्ष'],
                    'answer' => 2,
                    'hint' => 'संवैधानिक निकायका अधिकांश पदाधिकारीहरूको पदावधि नियुक्ति भएको मितिले समान हुन्छ।',
                    'explanation' => 'नेपालको संविधानको धारा २४२ को उपधारा (३) बमोजिम लोक सेवा आयोगका अध्यक्ष र सदस्यको पदावधि ६ वर्षको हुनेछ।',
                ],
                [
                    'question' => 'नेपालको संविधानमा कति भाग, धारा र अनुसूचीहरू रहेका छन्?',
                    'options' => ['३५ भाग, ३०८ धारा, ९ अनुसूची', '३० भाग, २५० धारा, ७ अनुसूची', '३२ भाग, ३०० धारा, ८ अनुसूची', '३५ भाग, ३१० धारा, १० अनुसूची'],
                    'answer' => 0,
                    'hint' => 'संविधान २०७२ असोज ३ गते जारी भएको हो, जसमा कुल ३०८ धारा रहेका छन्।',
                    'explanation' => 'नेपालको संविधानमा जम्मा ३५ भाग, ३०८ धारा र ९ वटा अनुसूचीहरू समावेश गरिएका छन्।',
                ],
            ],
            'gk' => [
                [
                    'question' => 'विश्वको सबैभन्दा अग्लो स्थानमा रहेको ताल कुन हो?',
                    'options' => ['रारा ताल', 'तिलिचो ताल', 'फेवा ताल', 'शे-फोक्सुण्डो ताल'],
                    'answer' => 1,
                    'hint' => 'यो ताल मनाङ जिल्लामा ४,९१९ मिटर उचाइमा अवस्थित छ।',
                    'explanation' => 'मनाङ जिल्लामा रहेको तिलिचो ताल समुद्र सतहबाट ४,९१९ मिटरको उचाइमा रहेको विश्वकै अग्लो स्थानको ताल मानिन्छ।',
                ],
                [
                    'question' => 'सगरमाथाको नयाँ उचाइ (८,८४८.८६ मिटर) कहिले घोषणा गरिएको थियो?',
                    'options' => ['२०७६ मंसिर २३', '२०७७ मंसिर २३', '२०७८ मंसिर २३', '२०७५ मंसिर २३'],
                    'answer' => 1,
                    'hint' => 'नेपाल र चीन सरकारले संयुक्त नापजाँच गरी सन् २०२० डिसेम्बर ८ (२०७७ मंसिर २३) मा सार्वजनिक गरेका थिए।',
                    'explanation' => 'नेपाल र चीनको संयुक्त प्राविधिक टोलीले नापजाँच गरी २०७७ मंसिर २३ गते सगरमाथाको नयाँ उचाइ ८,८४८.८६ मिटर घोषणा गरेको हो।',
                ],
                [
                    'question' => 'नेपालको प्रमाणिक समय कुन हिमाललाई आधार मानेर निर्धारण गरिएको छ?',
                    'options' => ['सगरमाथा', 'गौरीशंकर', 'मनास्लु', 'अन्नपूर्ण'],
                    'answer' => 1,
                    'hint' => 'यो दोलखा जिल्लामा पर्ने ८६ डिग्री १५ मिनेट पूर्वी देशान्तरमा आधारित छ।',
                    'explanation' => 'दोलखा जिल्लामा पर्ने गौरीशंकर हिमाल (८६° १५\' पूर्वी देशान्तर) लाई आधार मानी वि.सं. २०४२ वैशाख १ देखि नेपालको प्रमाणिक समय लागु गरिएको हो।',
                ],
            ],
            'iq' => [
                [
                    'question' => 'यदि CAT = 24 र DOG = 26 भए RAT = ?',
                    'options' => ['36', '39', '42', '45'],
                    'answer' => 1,
                    'hint' => 'अंग्रेजी वर्णमालाका अक्षरहरूको क्रम संख्या (R=18, A=1, T=20) जोड्नुहोस्।',
                    'explanation' => 'R(18) + A(1) + T(20) = 39. अक्षरहरूको स्थान मान जोड्दा सही उत्तर प्राप्त हुन्छ।',
                ],
                [
                    'question' => 'क्रम पूरा गर्नुहोस्: 2, 6, 12, 20, 30, ?',
                    'options' => ['40', '42', '44', '46'],
                    'answer' => 1,
                    'hint' => 'संख्याहरू बीचको अन्तर +4, +6, +8, +10, +12 हुँदै बढेको छ (वा 1*2, 2*3, 3*4, 4*5, 5*6, 6*7)।',
                    'explanation' => 'अन्तर: +4, +6, +8, +10, +12. तसर्थ 30 + 12 = 42 (अथवा 6 * 7 = 42)।',
                ],
                [
                    'question' => 'तलका मध्ये नमिल्ने कुन हो? (Odd one out): स्याउ, सुन्तला, आँप, आलु',
                    'options' => ['स्याउ', 'सुन्तला', 'आँप', 'आलु'],
                    'answer' => 3,
                    'hint' => 'अन्य सबै रुखमा फल्ने फलफूल हुन् भने यो जमिनमुनि फल्ने तरकारी हो।',
                    'explanation' => 'आलु जमिनमुनि फल्ने कन्दमूल/तरकारी हो भने अन्य सबै फलफूल हुन्।',
                ],
            ],
        ];

        $topicKeys = array_keys($sampleQuizzesByTopic);

        foreach ($modules as $idx => $mod) {
            $topicKey = $topicKeys[$idx % count($topicKeys)];
            $quizzes = $sampleQuizzesByTopic[$topicKey];

            $mod->update([
                'pdf_file' => 'storage/docs/Loksewa_Student_User_Manual.pdf',
                'key_points' => "• परीक्षा दृष्टिकोणले अति महत्त्वपूर्ण परिभाषाहरू र कानुनी धाराहरू कण्ठ गर्नुहोस्।\n• विगत ५ वर्षका लोकसेवा प्रश्नपत्रहरूको गहन विश्लेषण र पुनरावलोकन गर्नुहोस्।\n• मुख्य तथ्याङ्क, मिति र संशोधनहरूलाई तालिका बनाएर नियमित अभ्यास गर्नुहोस्।\n• वस्तुगत प्रश्नहरूमा समय व्यवस्थापन (प्रति प्रश्न ४५ सेकेन्ड) पालना गर्नुहोस्।",
                'notes' => "यस मोड्युलमा लोकसेवा आयोगको पाठ्यक्रममा आधारित विस्तृत सैद्धान्तिक तथा व्यावहारिक ज्ञान समावेश गरिएको छ।\n\n१. विषयवस्तुको परिचय तथा पृष्ठभूमि\n२. मुख्य संवैधानिक तथा नीतिगत व्यवस्थाहरू\n३. परीक्षा तयारीका लागि ध्यान दिनुपर्ने प्रमुख बुँदाहरू\n४. नमूना प्रश्नोत्तर तथा उत्तर लेखन शैली\n\nविद्यार्थीहरूले माथि उपलब्ध अध्ययन सामग्री (PDF) डाउनलोड गरी नियमित अध्ययन र स्व-मूल्याङ्कन अभ्यास गर्न सक्नुहुन्छ।",
                'quiz_questions' => $quizzes,
            ]);
        }

        // 3. Populate Lessons with notes, PDF, and quizzes
        $lessons = Lesson::all();
        foreach ($lessons as $idx => $lesson) {
            $topicKey = $topicKeys[$idx % count($topicKeys)];
            $quizzes = $sampleQuizzesByTopic[$topicKey];

            if ($lesson->type === 'quiz') {
                $lesson->update([
                    'content' => json_encode($quizzes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                    'attachment_path' => 'storage/docs/Loksewa_Student_User_Manual.pdf',
                ]);
            } else {
                $lesson->update([
                    'attachment_path' => $lesson->attachment_path ?? 'storage/docs/Loksewa_Student_User_Manual.pdf',
                ]);
            }
        }

        $this->command->info('   ✅ Successfully updated modules and lessons with rich PDFs, Notes, and Quizzes with Hints!');
    }
}
