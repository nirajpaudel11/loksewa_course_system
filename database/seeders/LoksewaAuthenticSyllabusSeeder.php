<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Database\Seeders\Helpers\NeaQuizBank;
use Database\Seeders\Helpers\RestoreOriginalPdfs;
use Database\Seeders\Helpers\SectionOfficerQuizBank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LoksewaAuthenticSyllabusSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📚 Seeding complete authentic Loksewa curriculum for all courses...');

        $this->seedNayabSubba();
        $this->seedKharidar();
        $this->seedSectionOfficer();
        $this->seedNrbOfficer();
        $this->seedNrbAssistantDirector();
        $this->seedConstitutionAndLaw();
        $this->seedComputerSkill();
        $this->seedIqAptitude();
        $this->seedNeaLevel4();

        // Run full PDF and Quiz recovery
        RestoreOriginalPdfs::restore();

        $this->command->info('✅ All courses, modules, chapters, lessons, notes, PDFs, and quizzes recovered successfully!');
    }

    /**
     * 1. NAYAB SUBBA TAYARI (Comprehensive Syllabus)
     */
    private function seedNayabSubba(): void
    {
        $course = Course::updateOrCreate(
            ['slug' => 'nayab-subba-tayari'],
            [
                'title' => 'Nayab Subba Tayari',
                'description' => 'Comprehensive Nayab Subba (Non-Gazetted First Class) preparation covering General Knowledge, Intelligence Quotient, General Administration, and Government Accounting. Designed for the integrated examination system of Lok Sewa Aayog.',
                'level' => 'intermediate',
                'thumbnail' => 'course-thumbnails/01M18FY1HJGT73TVVDGKSMK6VQ.jpg',
                'syllabus_pdf' => 'courses/syllabus/Nayab Subba Syllabus.pdf',
                'is_published' => true,
            ]
        );

        // Clean old modules for clean structure
        $this->cleanCourseContent($course);

        // ─── Module 1: Pahilo Patra - Samanya Gyan (General Knowledge) ───
        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Pahilo Patra: Samanya Gyan (General Knowledge)',
            'slug' => 'nasu-pahilo-patra-samanya-gyan-' . $course->id,
            'description' => 'Objective General Knowledge covering Nepal & World Geography, History, Socio-Economic Conditions, Environment, International Organizations, and Current Affairs.',
            'key_points' => "• Physical Geography of Nepal: 3 Ecological Belts, 7 Provinces, 753 Local Levels, Major River Systems (Koshi, Gandaki, Karnali)\n• Historical Eras: Ancient Lichhavi, Medieval Malla, Modern Shah Unification & 2015 Constitution\n• Current Affairs: Census 2078 facts, 16th Periodic Plan, LDC graduation, UN & SAARC/BIMSTEC",
            'notes' => 'Detailed theoretical and objective study notes for Nayab Subba 1st Paper GK Examination.',
            'pdf_file' => 'courses/syllabus/Nayab Subba Syllabus.pdf',
            'order' => 1,
            'is_published' => true,
        ]);

        // Chapter 1.1: Geography
        $c1_1 = Chapter::create([
            'module_id' => $m1->id,
            'title' => 'Nepal ra Bishwa ko Bhugol (Geography of Nepal & World)',
            'slug' => 'nasu-geography-nepal-world-' . $m1->id,
            'order' => 1,
            'is_published' => true,
        ]);

        $this->createFullLesson(
            module: $m1,
            chapter: $c1_1,
            title: 'Physical Geography of Nepal & Climate',
            slug: 'physical-geography-of-nepal-5',
            type: 'text',
            order: 1,
            duration: 25,
            content: '<h3>१. नेपालको भौगोलिक अवस्थिति र सिमाना (Geographical Location of Nepal)</h3><p>नेपाल दक्षिण एसियामा अवस्थित भूपरिवेष्ठित (Landlocked) राष्ट्र हो।</p><ul><li><strong>अक्षांश (Latitude):</strong> २६°२२\' उत्तरी अक्षांशदेखि ३०°२७\' उत्तरी अक्षांश (अवस्थिति विस्तार: ४°०५\')</li><li><strong>देशान्तर (Longitude):</strong> ८०°०४\' पूर्वी देशान्तरदेखि ८८°१२\' पूर्वी देशान्तर (अवस्थिति विस्तार: ८°०८\')</li><li><strong>क्षेत्रफल:</strong> १,४७,१८१ वर्ग किलोमिटर (५६,८२७ वर्ग माइल) — विश्वको कुल भूभागको ०.०३% र एसियाको ०.३%।</li><li><strong>लम्बाइ र चौडाइ:</strong> पूर्व-पश्चिम औसत लम्बाइ ८८५ कि.मी., उत्तर-दक्षिण औसत चौडाइ १९३ कि.मी. (अधिकतम २४१ कि.मी., न्यूनतम १४५ कि.मी.)।</li><li><strong>प्रमाणिक समय (Standard Time):</strong> दोलखा जिल्लामा रहेको गौरीशंकर हिमाल (रोल्वालिङ हिमशृङ्खला, ८६°१५\' पूर्वी देशान्तर) लाई आधार मानी २०४२ साल वैशाख १ गतेदेखि लागू गरिएको हो। यो ग्रीनविच मानक समय (GMT) भन्दा ५ घण्टा ४५ मिनेट छिटो छ।</li></ul><h3>२. धरातलीय स्वरूप र भौगोलिक विभाजन (3 Ecological Belts)</h3><ol><li><strong>हिमाली प्रदेश (Himalayan Region):</strong> कुल क्षेत्रफलको करिब १५% भूभाग ओगटेको छ। उचाइ ३,००० मिटरदेखि ८,८४८.८६ मिटरसम्म रहेको छ। विश्वका १४ वटा ८,००० मिटरभन्दा अग्ला हिमालमध्ये ८ वटा नेपालमै पर्दछन् (सगरमाथा, कञ्चनजङ्घा, ल्होत्से, मकालु, चोयु, धौलागिरी, मनास्लु, अन्नपूर्ण)। प्रमुख तालहरू: रारा (मुगु), तिलिचो र कजिन सारा (मनाङ), फोक्सुन्डो (डोल्पा)।</li><li><strong>पहाडी प्रदेश (Hilly Region):</strong> कुल क्षेत्रफलको करिब ६८% भूभाग ओगटेको छ। उचाइ ६०० मिटरदेखि ३,००० मिटरसम्म। महाभारत पर्वत शृङ्खला र चुरे (सिवालिक) पर्वत यसैमा पर्दछन्। काठमाडौं, पोखरा, त्रिशूली, दाङ जस्ता उर्वर उपत्यकाहरू यस प्रदेशका मुख्य केन्द्र हुन्।</li><li><strong>तराई प्रदेश (Terai Region):</strong> कुल क्षेत्रफलको करिब १७% भूभाग ओगटेको छ। उचाइ ६० मिटरदेखि ६०० मिटरसम्म। नेपालको अन्न भण्डारका रूपमा चिनिने यो क्षेत्र समथर जलोढ माटोले बनेको छ। यसलाई खास तराई, भावर प्रदेश र भित्री मधेश गरी ३ भागमा वर्गीकरण गरिन्छ।</li></ol><h3>३. नेपालका प्रमुख नदी प्रणालीहरू (Major River Systems)</h3><ul><li><strong>कोशी नदी प्रणाली (Koshi):</strong> नेपालको सबैभन्दा ठूलो नदी (जलप्रवाहका आधारमा)। ७ सहायक नदीहरू: तमोर, अरुण, सुनकोशी, दुधकोशी, तामाकोशी, भोटेकोशी, इन्द्रावती।</li><li><strong>गण्डकी नदी प्रणाली (Gandaki / Narayani):</strong> नेपालको सबैभन्दा गहिरो नदी (कालीगण्डकी गल्छी विश्वकै गहिरो गल्छी मानिन्छ)। ७ सहायक नदीहरू: त्रिशूली, बुढीगण्डकी, मर्स्याङ्दी, सेती गण्डकी, मादी, कालीगण्डकी, दरौँदी।</li><li><strong>कर्णाली नदी प्रणाली (Karnali):</strong> नेपालको सबैभन्दा लामो नदी (५०७ कि.मी.)। ७ सहायक नदीहरू: हुम्ला कर्णाली, मुगु कर्णाली, ठूली भेरी, सानी भेरी, तिला, बुढीगंगा, सेती।</li></ul>',
            attachmentPath: 'lessons/pdfs/Geography of Nepal_compressed.pdf',
            quizzes: [
                ['question' => 'नेपालको कुल क्षेत्रफल कति रहेको छ?', 'options' => ['१,४७,१८१ वर्ग कि.मी.', '१,४७,५१६ वर्ग कि.मी.', '१,४८,००० वर्ग कि.मी.', '१,४६,१८१ वर्ग कि.मी.'], 'answer' => 0, 'hint' => 'आधिकारिक क्षेत्रफल १,४७,१८१ वर्ग कि.मी. हो।', 'explanation' => 'नेपालको क्षेत्रफल १,४७,१८१ वर्ग किलोमिटर (५६,८२७ वर्ग माइल) रहेको छ।'],
                ['question' => 'नेपालको प्रमाणिक समय कुन हिमाल र देशान्तरलाई आधार मानी निर्धारण गरिएको छ?', 'options' => ['गौरीशंकर हिमाल (८६°१५\' पूर्वी देशान्तर)', 'सगरमाथा (८६°५५\' पूर्वी देशान्तर)', 'अन्नपूर्ण (८३°४५\' पूर्वी देशान्तर)', 'मनास्लु (८४°३०\' पूर्वी देशान्तर)'], 'answer' => 0, 'hint' => 'दोलखा जिल्लाको गौरीशंकर हिमाल, २०४२ वैशाख १ देखि लागू।', 'explanation' => 'दोलखाको गौरीशंकर हिमालको ८६°१५\' पूर्वी देशान्तरलाई आधार बनाई GMT +5:45 निर्धारण गरिएको छ।'],
                ['question' => 'नेपालको सबैभन्दा लामो नदी कुन हो र यसको लम्बाइ कति छ?', 'options' => ['कर्णाली नदी (५०७ कि.मी.)', 'कोशी नदी (७२० कि.मी.)', 'गण्डकी नदी (३३८ कि.मी.)', 'महाकाली नदी (२२३ कि.मी.)'], 'answer' => 0, 'hint' => 'नेपालभित्र ५०७ कि.मी. बग्ने नदी।', 'explanation' => 'नेपालको सबैभन्दा लामो नदी कर्णाली (५०७ कि.मी.) हो भने सबैभन्दा ठूलो कोशी नदी हो।'],
                ['question' => 'नेपालका कतिवटा जिल्लाले भारत र चीन दुवै देशलाई छुन्छन्?', 'options' => ['२ वटा (ताप्लेजुङ र दार्चुला)', '३ वटा (झापा, कञ्चनपुर र हुम्ला)', '४ वटा', '५ वटा'], 'answer' => 0, 'hint' => 'एक पूर्वको अन्तिम र एक सुदूरपश्चिमको अन्तिम जिल्ला।', 'explanation' => 'ताप्लेजुङ (पूर्व) र दार्चुला (पश्चिम) ले भारत र चीन दुवै देशको सिमानालाई छुन्छन्।'],
                ['question' => 'महाभारत पर्वत शृङ्खलाको सबैभन्दा अग्लो डाँडा कुन हो?', 'options' => ['फुल्चोकी (२,७८२ मिटर)', 'चन्द्रागिरि', 'दामन', 'शैलुङ'], 'answer' => 0, 'hint' => 'ललितपुर जिल्लामा अवस्थित २,७८२ मिटर अग्लो डाँडा।', 'explanation' => 'काठमाडौं उपत्यका वरिपरिको महाभारत शृङ्खलाको सबैभन्दा अग्लो बिन्दु ललितपुरको फुल्चोकी (२,७८२ मि.) हो।'],
                ['question' => 'नेपालको सबैभन्दा ठूलो ताल कुन हो?', 'options' => ['रारा ताल (मुगु)', 'शे-फोक्सुन्डो ताल (डोल्पा)', 'तिलिचो ताल (मनाङ)', 'फेवा ताल (कास्की)'], 'answer' => 0, 'hint' => 'मुगु जिल्लामा अवस्थित महेन्द्र ताल पनि भनिने ताल।', 'explanation' => 'रारा ताल (क्षेत्रफल करिब १०.८ वर्ग कि.मी.) नेपालको सबैभन्दा ठूलो ताल हो।'],
                ['question' => 'नेपालको सबैभन्दा गहिरो ताल कुन हो?', 'options' => ['शे-फोक्सुन्डो ताल (१४५ मिटर)', 'रारा ताल (१६७ मिटर)', 'तिलिचो ताल', 'गोसाइँकुण्ड'], 'answer' => 0, 'hint' => 'डोल्पा जिल्लामा अवस्थित काञ्जीरोवा हिमालको काखमा रहेको ताल।', 'explanation' => 'शे-फोक्सुन्डो ताल डोल्पा जिल्लामा अवस्थित छ र यसको गहिराइ १४५ मिटर छ।'],
                ['question' => 'विश्वको सबैभन्दा अग्लो स्थानमा रहेको तिलिचो ताल कति उचाइमा रहेको छ?', 'options' => ['४,९१९ मिटर', '५,२०० मिटर', '४,५०० मिटर', '३,८०० मिटर'], 'answer' => 0, 'hint' => 'मनाङ जिल्लामा ४,९०० मिटरभन्दा माथि अवस्थित।', 'explanation' => 'तिलिचो ताल मनाङ जिल्लामा ४,९१९ मिटरको उचाइमा अवस्थित छ।'],
                ['question' => 'नेपालको पहिलो राष्ट्रिय निकुञ्ज कुन हो र यो कहिले स्थापना भएको हो?', 'options' => ['चितवन राष्ट्रिय निकुञ्ज (वि.सं. २०३०)', 'सगरमाथा राष्ट्रिय निकुञ्ज (वि.सं. २०३२)', 'बर्दिया राष्ट्रिय निकुञ्ज (वि.सं. २०४५)', 'रारा राष्ट्रिय निकुञ्ज (वि.सं. २०३२)'], 'answer' => 0, 'hint' => 'एकसिङ्गे गैँडाका लागि प्रख्यात, सन् १९८४ मा युनेस्को विश्व सम्पदामा सूचीकृत।', 'explanation' => 'चितवन राष्ट्रिय निकुञ्ज वि.सं. २०३० (सन् १९७३) मा नेपालको पहिलो राष्ट्रिय निकुञ्जका रूपमा स्थापना भएको हो।'],
                ['question' => 'सगरमाथाको नयाँ आधिकारिक उचाइ कहिले र कति घोषणा गरियो?', 'options' => ['वि.सं. २०७७ मंसिर २३ (८,८४८.८६ मिटर)', 'वि.सं. २०७५ वैशाख १ (८,८५० मिटर)', 'वि.सं. २०७६ चैत १५ (८,८४८ मिटर)', 'वि.सं. २०७८ असार १० (८,८४९ मिटर)'], 'answer' => 0, 'hint' => 'नेपाल र चीनद्वारा संयुक्त रूपमा ८,८४८.८६ मिटर घोषणा।', 'explanation' => 'नेपाल र चीन सरकारले २०७७ मंसिर २३ गते (8 Dec 2020) सगरमाथाको उचाइ ८,८४८.८६ मिटर घोषणा गरेका हुन्।'],
            ]
        );

        $this->createFullLesson(
            module: $m1,
            chapter: $c1_1,
            title: 'Geography of World & Universe Basics',
            slug: 'geography-of-world-and-universe-5',
            type: 'text',
            order: 2,
            duration: 20,
            content: '<h3>१. सौर्यमण्डल र ब्रह्माण्ड (Solar System & Universe)</h3><p>सूर्य सौर्यमण्डलको केन्द्रमा रहेको मध्यम तारा हो। यसको प्रकाश पृथ्वीसम्म आइपुग्न ८ मिनेट २० सेकेन्ड (करिब ५०० सेकेन्ड) लाग्छ।</p><ul><li><strong>ग्रहहरूको क्रम (सूर्यबाट दूरी अनुसार):</strong> बुध (Mercury), शुक्र (Venus), पृथ्वी (Earth), मंगल (Mars), बृहस्पति (Jupiter), शनि (Saturn), अरुण (Uranus), वरुण (Neptune)।</li><li><strong>विशेषताहरू:</strong> सबैभन्दा ठूलो ग्रह: बृहस्पति; सबैभन्दा चम्किलो/तातो ग्रह: शुक्र (Morning/Evening Star); रातो ग्रह: मंगल; घेरायुक्त सुन्दर ग्रह: शनि (टाइटन उपग्रह); अक्षमा ९८ डिग्री ढल्किएको ग्रह: अरुण।</li></ul><h3>२. विश्वका महादेशहरू (7 Continents)</h3><ol><li><strong>एसिया (Asia):</strong> विश्वको सबैभन्दा ठूलो महादेश (कुल भूभागको करिब ३०%)। सर्वोच्च शिखर सगरमाथा र सबैभन्दा गहिरो ताल बैकाल (रुस) यहीँ पर्दछन्।</li><li><strong>अफ्रिका (Africa):</strong> दोस्रो ठूलो महादेश (Plateau Continent)। विश्वको सबैभन्दा लामो नदी नाइल (६,६५० कि.मी.) र सबैभन्दा ठूलो तातो मरुभूमि सहारा (Sahara Desert) यहीँ पर्दछन्।</li><li><strong>उत्तर अमेरिका (North America):</strong> तेस्रो ठूलो महादेश। सबैभन्दा लामो तटरेखा भएको देश क्यानाडा (२,०२,०८० कि.मी.) र ठूलो ताजा पानीको ताल लेक सुपेरियर।</li><li><strong>दक्षिण अमेरिका (South America):</strong> विश्वको सबैभन्दा लामो एन्डिज पर्वतमाला (७,००० कि.मी.) र जलप्रवाहका आधारमा सबैभन्दा ठूलो नदी अमेजन (Amazon)।</li><li><strong>अन्टार्कटिका (Antarctica):</strong> हिउँले ढाकिएको सेतो महादेश (White Continent)।</li><li><strong>युरोप (Europe):</strong> प्रायद्वीपहरूको प्रायद्वीप (Peninsula of Peninsulas)।</li><li><strong>अस्ट्रेलिया (Australia):</strong> सबैभन्दा सानो महादेश तथा टापु महादेश (Island Continent)।</li></ol>',
            attachmentPath: 'lessons/pdfs/General-Information-about-Universe-Loksewa-PDF_compressed.pdf',
            quizzes: [
                ['question' => 'सौर्यमण्डलको सबैभन्दा ठूलो ग्रह कुन हो?', 'options' => ['बृहस्पति (Jupiter)', 'शनि (Saturn)', 'पृथ्वी (Earth)', 'वरुण (Neptune)'], 'answer' => 0, 'hint' => 'ग्रेट रेड स्पट भएको ग्यास दानव ग्रह।', 'explanation' => 'बृहस्पति सौर्यमण्डलको सबैभन्दा ठूलो ग्रह हो जसको व्यास करिब १,४२,९८४ कि.मी. छ।'],
                ['question' => 'कुन ग्रहलाई "रातो ग्रह" (Red Planet) भनिन्छ?', 'options' => ['मंगल (Mars)', 'शुक्र (Venus)', 'बुध (Mercury)', 'शनि (Saturn)'], 'answer' => 0, 'hint' => 'आइरन अक्साइड (खिया) को बाहुल्यताले रातो देखिने ग्रह।', 'explanation' => 'सतहमा रहेको आइरन अक्साइडको कारण मंगल ग्रह रातो देखिन्छ।'],
                ['question' => 'विश्वको सबैभन्दा लामो नदी कुन हो?', 'options' => ['नाइल नदी (६,६५० कि.मी.)', 'अमेजन नदी', 'याङ्त्से नदी', 'मिसिसिपी नदी'], 'answer' => 0, 'hint' => 'अफ्रिका महादेशमा बग्ने नदी।', 'explanation' => 'अफ्रिकाको नाइल नदी (६,६५० कि.मी.) विश्वको सबैभन्दा लामो नदी हो।'],
                ['question' => 'विश्वको सबैभन्दा गहिरो सामुद्रिक खाल्डो कुन हो?', 'options' => ['मारियाना ट्रेन्च (Mariana Trench)', 'जाभा ट्रेन्च', 'सुन्दा ट्रेन्च', 'पुएर्तो रिको ट्रेन्च'], 'answer' => 0, 'hint' => 'प्रशान्त महासागरमा करिब ११,००० मिटर गहिरो खाल्डो।', 'explanation' => 'प्रशान्त महासागरको मारियाना ट्रेन्च (च्यालेन्जर डिप, करिब १०,९९४ मिटर) विश्वको सबैभन्दा गहिरो बिन्दु हो।'],
                ['question' => 'विश्वको सबैभन्दा लामो पर्वतमाला कुन हो?', 'options' => ['एन्डिज पर्वतमाला (७,००० कि.मी.)', 'हिमालय पर्वतमाला', 'रकी पर्वतमाला', 'आल्प्स पर्वतमाला'], 'answer' => 0, 'hint' => 'दक्षिण अमेरिका महादेशमा अवस्थित।', 'explanation' => 'दक्षिण अमेरिकाको पश्चिमी किनारमा फैलिएको एन्डिज पर्वतमाला (७,००० कि.मी.) विश्वकै लामो हो।'],
                ['question' => 'क्षेत्रफलको आधारमा विश्वको सबैभन्दा ठूलो ताजा पानीको ताल कुन हो?', 'options' => ['सुपेरियर ताल (Lake Superior)', 'बैकाल ताल', 'भिक्टोरिया ताल', 'क्यास्पियन सागर'], 'answer' => 0, 'hint' => 'उत्तर अमेरिकाको ग्रेट लेक्समध्ये एक (८२,१०० वर्ग कि.मी.)।', 'explanation' => 'लेक सुपेरियर ताजा पानीको सबैभन्दा ठूलो ताल हो भने बैकाल सबैभन्दा गहिरो ताजा पानीको ताल हो।'],
                ['question' => 'विश्वको सबैभन्दा लामो समुद्री तटरेखा भएको देश कुन हो?', 'options' => ['क्यानाडा (२,०२,०८० कि.मी.)', 'रुस', 'इन्डोनेसिया', 'अस्ट्रेलिया'], 'answer' => 0, 'hint' => 'उत्तर अमेरिकी देश।', 'explanation' => 'क्यानाडाको तटरेखा विश्वमै सबैभन्दा लामो (२,०२,०८० कि.मी.) छ।'],
                ['question' => 'सूर्यको प्रकाश पृथ्वीसम्म आइपुग्न कति समय लाग्छ?', 'options' => ['करिब ८ मिनेट २० सेकेन्ड', '५ मिनेट', '१२ मिनेट', 'तत्काल'], 'answer' => 0, 'hint' => 'करिब ५०० सेकेन्ड।', 'explanation' => '१५ करोड कि.मी. दूरी प्रकाशको गतिमा पार गर्न करिब ८ मिनेट २० सेकेन्ड लाग्छ।'],
                ['question' => 'शनि ग्रहको सबैभन्दा ठूलो उपग्रह कुन हो?', 'options' => ['टाइटन (Titan)', 'ग्यानिमिड', 'युरोपा', 'फोबोस'], 'answer' => 0, 'hint' => 'बाक्लो वायुमण्डल र तरल मिथेन ताल भएको उपग्रह।', 'explanation' => 'टाइटन शनि ग्रहको सबैभन्दा ठूलो र सौर्यमण्डलको दोस्रो ठूलो उपग्रह हो।'],
                ['question' => 'एसिया र उत्तर अमेरिकालाई छुट्याउने जलसंयोजक (Strait) कुन हो?', 'options' => ['बेरिङ जलसंयोजक (Bering Strait)', 'जिब्राल्टर', 'मलाक्का', 'हर्मुज'], 'answer' => 0, 'hint' => 'रुस र अलास्काको बीचमा रहेको जलडमरूमध्य।', 'explanation' => 'बेरिङ जलसंयोजकले एसिया (रुस) र उत्तर अमेरिका (अमेरिकाको अलास्का) लाई छुट्याउँछ।'],
            ]
        );

        // Chapter 1.2: History of Nepal & World
        $c1_2 = Chapter::create([
            'module_id' => $m1->id,
            'title' => 'Nepal ra Bishwa ko Itihas (History of Nepal & World)',
            'slug' => 'nasu-history-nepal-world-' . $m1->id,
            'order' => 2,
            'is_published' => true,
        ]);

        $this->createFullLesson(
            module: $m1,
            chapter: $c1_2,
            title: 'Political History from Unification to Republic',
            slug: 'political-history-from-unification-to-republic-5',
            type: 'text',
            order: 1,
            duration: 25,
            content: '<h3>१. नेपालको एकीकरण र शाहकालीन इतिहास (Unification of Nepal)</h3><ul><li><strong>वि.सं. १७७९:</strong> राजा पृथ्वीनारायण शाहको जन्म (गोर्खा)। वि.सं. १७९९ मा २० वर्षको उमेरमा गोर्खाको राजा बने।</li><li><strong>वि.सं. १८०१:</strong> नुवाकोट विजय (एकीकरणको पहिलो सफलता)।</li><li><strong>वि.सं. १८२५ असोज १३:</strong> कान्तिपुर (इन्द्रजात्राको दिन) र असोज २५ मा पाटन विजय।</li><li><strong>वि.सं. १८२६ मंसिर १:</strong> भक्तपुर विजय (उपत्यका एकीकरण सम्पन्न)।</li><li><strong>वि.सं. १८३१ माघ १:</strong> ५२ वर्षको उमेरमा नुवाकोटको देवीघाटमा पृथ्वीनारायण शाहको निधन।</li><li><strong>वि.सं. १८७१-७३ (सन् १८१४-१६):</strong> नेपाल-अंग्रेज युद्ध। नालापानीमा बलभद्र कुँवर, जैथकमा अमरसिंह थापा, देउथलमा भक्ति थापाको वीरता।</li><li><strong>सन् १८१६ मार्च ४ (वि.सं. १८७२):</strong> सुगौली सन्धि (Treaty of Sugauli) लागू — नेपालले मेची पूर्व र महाकाली पश्चिमको एक तिहाइ भूभाग गुमायो।</li></ul><h3>२. राणा शासनकाल (१८४६ - १९५१ AD)</h3><ul><li><strong>वि.सं. १९०३ असोज २ (14 Sept 1846):</strong> कोतपर्व — जंगबहादुर राणाद्वारा शक्ति कब्जा गरी १०४ वर्षे जहाँनिया राणा शासनको सूत्रपात।</li><li><strong>वि.सं. १९०३ कात्तिक १२:</strong> भण्डारखाल पर्व; वि.सं. १९०४: अलौ पर्व।</li><li><strong>वि.सं. १९१०:</strong> जंगबहादुरद्वारा पहिलो मुलुकी ऐन जारी।</li><li><strong>वि.सं. १९५८:</strong> देवशमशेरद्वारा गोर्खापत्र प्रकाशन र भाषा पाठशाला स्थापना (शिक्षाका पिता)।</li><li><strong>वि.सं. १९६८:</strong> चन्द्रशमशेरको पालामा पहिलो जनगणना सुरु; वि.सं. १९८० मा दासप्रथा उन्मूलन।</li></ul><h3>३. प्रजातान्त्रिक आन्दोलन र गणतन्त्र (Democratic Movements)</h3><ul><li><strong>वि.सं. २००७ फागुन ७:</strong> १०४ वर्षे राणा शासनको अन्त्य भई प्रजातन्त्र स्थापना (त्रिभुवन राजा, मोहनशमशेर प्रधानमन्त्री)।</li><li><strong>वि.सं. २०१५:</strong> नेपालको पहिलो आम निर्वाचन; वि.सं. २०१६ जेठ १३ मा बिपी कोइराला प्रथम जननिर्वाचित प्रधानमन्त्री बने।</li><li><strong>वि.सं. २०१७ पुस १:</strong> राजा महेन्द्रद्वारा कु गरी पञ्चायती व्यवस्था लागू।</li><li><strong>वि.सं. २०४६:</strong> ऐतिहासिक जनआन्दोलन १ — प्रजातन्त्र पुनर्बहाली र २०४७ को संविधान जारी।</li><li><strong>वि.सं. २०६२/६३:</strong> १९ दिने ऐतिहासिक जनआन्दोलन २ — राजतन्त्रको अन्त्य।</li><li><strong>वि.सं. २०६५ जेठ १५ (28 May 2008):</strong> पहिलो संविधान सभाद्वारा नेपाललाई संघीय लोकतान्त्रिक गणतन्त्र घोषणा।</li><li><strong>वि.सं. २०७२ असोज ३ (20 Sept 2015):</strong> संविधान सभाबाट नेपालको संविधान जारी।</li></ul>',
            attachmentPath: 'lessons/pdfs/HIstory of Nepal.pdf',
            quizzes: [
                ['question' => 'पृथ्वीनारायण शाहले कान्तिपुरमाथि कहिले विजय हासिल गरेका थिए?', 'options' => ['वि.सं. १८२५ असोज १३', 'वि.सं. १८०१ असोज १५', 'वि.सं. १८२६ मंसिर १', 'वि.सं. १८१५ फागुन ७'], 'answer' => 0, 'hint' => 'इन्द्रजात्राको दिन विजय हासिल भएको थियो।', 'explanation' => 'वि.सं. १८२५ असोज १३ गते इन्द्रजात्राको रात पृथ्वीनारायण शाहले कान्तिपुर विजय गरेका थिए।'],
                ['question' => 'कोतपर्व कहिले घटेको थियो, जसबाट राणा शासनको सुरुवात भयो?', 'options' => ['वि.सं. १९०३ असोज २ (14 Sept 1846)', 'वि.सं. १९०७ फागुन ७', 'वि.सं. १९१० पुस १', 'वि.सं. १८८२ वैशाख १'], 'answer' => 0, 'hint' => 'हनुमानढोका कोतमा गगनसिंहको हत्यापछि घटेको हत्याकाण्ड।', 'explanation' => 'वि.सं. १९०३ असोज २ गते कोतपर्व घटेर जंगबहादुर राणा सर्वेसर्वा बनेका थिए।'],
                ['question' => 'नेपाल-अंग्रेज युद्ध अन्त्य गर्ने सुगौली सन्धि कहिले अनुमोदन भएको थियो?', 'options' => ['सन् १८१६ मार्च ४ (वि.सं. १८७२)', 'सन् १८१४ नोभेम्बर १', 'सन् १८४६ सेप्टेम्बर १४', 'सन् १९५० जुलाई ३१'], 'answer' => 0, 'hint' => 'मेची र महाकाली सीमा निर्धारण गर्ने ऐतिहासिक सन्धि।', 'explanation' => 'सन् १८१६ मार्च ४ मा सुगौली सन्धि दुवै पक्षबाट अनुमोदन भई लागू भएको थियो।'],
                ['question' => 'नेपालको पहिलो आम निर्वाचन २०१५ पछि प्रथम जननिर्वाचित प्रधानमन्त्री को बनेका थिए?', 'options' => ['विश्वेश्वरप्रसाद (बिपी) कोइराला', 'मातृकाप्रसाद कोइराला', 'टंकप्रसाद आचार्य', 'डा. के.आई. सिंह'], 'answer' => 0, 'hint' => 'वि.सं. २०१६ जेठ १३ मा प्रधानमन्त्री बनेका नेता।', 'explanation' => 'बिपी कोइराला २०१५ को आम निर्वाचनपछि प्रथम जननिर्वाचित प्रधानमन्त्री बनेका थिए।'],
                ['question' => 'पहिलो संविधान सभाले नेपाललाई कहिले संघीय लोकतान्त्रिक गणतन्त्र घोषणा गर्‍यो?', 'options' => ['वि.सं. २०६५ जेठ १५ (28 May 2008)', 'वि.सं. २०६३ वैशाख ११', 'वि.सं. २०७२ असोज ३', 'वि.सं. २०६२ मंसिर ७'], 'answer' => 0, 'hint' => '२४० वर्षे शाहवंशीय राजतन्त्रको अन्त्य भएको दिन।', 'explanation' => 'वि.सं. २०६५ जेठ १५ गते संविधान सभाको पहिलो बैठकले नेपाललाई गणतन्त्र घोषणा गरेको थियो।'],
                ['question' => 'नेपालमा पहिलो लिखित मुलुकी ऐन कसको पालामा जारी भएको थियो?', 'options' => ['जंगबहादुर राणा (वि.सं. १९१०)', 'रणोद्दीप सिंह', 'चन्द्रशमशेर', 'देवशमशेर'], 'answer' => 0, 'hint' => 'बेलायत भ्रमणपछि जारी गरिएको पहिलो कानुनी संहिता।', 'explanation' => 'वि.सं. १९१० मा जंगबहादुर राणाले पहिलो मुलुकी ऐन जारी गरेका थिए।'],
                ['question' => 'नालापानीको युद्ध (१८१४) मा अंग्रेज फौजविरुद्ध वीरतापूर्वक लड्ने नेपाली कमाण्डर को थिए?', 'options' => ['कप्तान बलभद्र कुँवर', 'अमरसिंह थापा', 'भक्ति थापा', 'कालु पाँडे'], 'answer' => 0, 'hint' => '६०० जनाको सानो फौज लिएर नालापानी गढीको रक्षा गर्ने योद्धा।', 'explanation' => 'कप्तान बलभद्र कुँवरले नालापानी किल्लामा वीरतापूर्वक अंग्रेजसँग लडेका थिए।'],
                ['question' => 'राणा प्रधानमन्त्रीहरूमध्ये कसलाई "शिक्षाका पिता" का रूपमा चिनिन्छ?', 'options' => ['देवशमशेर राणा', 'जंगबहादुर राणा', 'चन्द्रशमशेर', 'पद्मशमशेर'], 'answer' => 0, 'hint' => 'गोर्खापत्र प्रकाशन सुरु गर्ने र भाषा पाठशाला खोल्ने प्रधानमन्त्री।', 'explanation' => 'वि.सं. १९५८ मा गोर्खापत्र प्रकाशन र भाषा पाठशाला खोल्ने देवशमशेर शिक्षाप्रेमी थिए।'],
                ['question' => 'नेपालमा प्रथम जनगणना कहिलेबाट सुरु भएको थियो?', 'options' => ['वि.सं. १९६८ (सन् १९११)', 'वि.सं. १९७८', 'वि.सं. १९५८', 'वि.सं. २००८'], 'answer' => 0, 'hint' => 'चन्द्रशमशेरको शासनकालमा सुरु।', 'explanation' => 'वि.सं. १९६८ मा चन्द्रशमशेरको पालादेखि नेपालमा वैज्ञानिक जनगणना सुरु भएको हो।'],
                ['question' => 'नेपालको वर्तमान संविधान (२०७२) कहिले जारी भएको हो?', 'options' => ['वि.सं. २०७२ असोज ३ गते', 'वि.सं. २०७२ वैशाख १२ गते', 'वि.सं. २०६३ माघ १ गते', 'वि.सं. २०७० मंसिर ४ गते'], 'answer' => 0, 'hint' => 'संविधान सभाबाट जारी भएको नेपालको सातौँ संविधान।', 'explanation' => 'वि.सं. २०७२ असोज ३ गते राष्ट्रपति डा. रामवरण यादवबाट नेपालको संविधान जारी भएको हो।'],
            ]
        );

        // Chapter 1.3: Current Affairs & International Affairs
        $c1_3 = Chapter::create([
            'module_id' => $m1->id,
            'title' => 'Samsamayik Ghatanakram ra Antarrastriya Sambandha (Current Affairs & Global Affairs)',
            'slug' => 'nasu-current-affairs-global-' . $m1->id,
            'order' => 3,
            'is_published' => true,
        ]);

        $this->createFullLesson(
            module: $m1,
            chapter: $c1_3,
            title: 'Current Affairs Framework for Loksewa',
            slug: 'current-affairs-framework-for-loksewa-6',
            type: 'text',
            order: 1,
            duration: 25,
            content: '<h3>१. राष्ट्रिय जनगणना २०७८ का मुख्य नतिजाहरू (Census 2078 Key Data)</h3><ul><li><strong>कुल जनसंख्या:</strong> २,९१,६४,५७८ (पुरुष: ४८.९८%, महिला: ५१.०२%, लैङ्गिक अनुपात: ९५.५९)</li><li><strong>वार्षिक जनसंख्या वृद्धिदर:</strong> ०.९२% (८ दशकयताकै न्यून)</li><li><strong>जनघनत्व:</strong> १९८ जना प्रति वर्ग कि.मी. (सबैभन्दा बढी काठमाडौं: ५,१०८ जना, सबैभन्दा कम मनाङ: ३ जना)</li><li><strong>कुल साक्षरता दर:</strong> ७६.३% (पुरुष: ८३.६%, महिला: ६९.४%)</li><li><strong>सबैभन्दा बढी जनसंख्या भएको प्रदेश:</strong> बागमती प्रदेश (२०.९७%) र जिल्ला: काठमाडौं (२०,४१,५८७ जना)</li><li><strong>सबैभन्दा कम जनसंख्या भएको प्रदेश:</strong> कर्णाली प्रदेश (५.७९%) र जिल्ला: मनाङ (५,६५८ जना)</li><li><strong>मातृभाषा र जातजाति:</strong> १२४ मातृभाषा र १४२ जातजाति दर्ता भएका छन्।</li></ul><h3>२. १६औँ आवधिक योजना (वि.सं. २०८१/८२ - २०८५/८६)</h3><ul><li><strong>सोच (Vision):</strong> "सुशासन, सामाजिक न्याय र समृद्धि" (Good Governance, Social Justice and Prosperity)</li><li><strong>मूल उद्देश्य:</strong> संरचनात्मक रूपान्तरणमार्फत उत्पादकत्व वृद्धि, गुणस्तरीय रोजगारी सिर्जना र सामाजिक न्यायसहितको दिगो आर्थिक विकास हासिल गर्नु।</li><li><strong>एलडीसी (LDC) स्तरोन्नति:</strong> नेपाल सन् २०२६ नोभेम्बरसम्ममा अतिकम विकसित देश (LDC) बाट विकासशील देशमा स्तरोन्नति हुने लक्ष्य रहेको छ।</li></ul><h3>३. क्षेत्रीय तथा अन्तर्राष्ट्रिय संघसंस्थाहरू (Regional & International Orgs)</h3><ul><li><strong>संयुक्त राष्ट्रसंघ (UN):</strong> स्थापना २४ अक्टोबर १९४५ (UN Day)। नेपालले १४ डिसेम्बर १९५५ मा सदस्यता प्राप्त गरेको (Package Deal अन्तर्गत)।</li><li><strong>सार्क (SAARC):</strong> स्थापना ८ डिसेम्बर १९८५ (ढाका)। सचिवालय: काठमाडौं, नेपाल। सदस्य राष्ट्र: ८ (नेपाल, भारत, भुटान, बंगलादेश, पाकिस्तान, श्रीलंका, माल्दिभ्स, अफगानिस्तान)।</li><li><strong>बिम्सटेक (BIMSTEC):</strong> स्थापना ६ जुन १९९७ (बैंकक घोषणापत्र)। सचिवालय: ढाका, बंगलादेश। सदस्य राष्ट्र: ७ (नेपाल, भारत, भुटान, बंगलादेश, म्यान्मार, श्रीलंका, थाइल्याण्ड)। नेपाल सन् २००४ फेब्रुअरी ८ मा सदस्य बनेको।</li><li><strong>दौत्य सम्बन्ध (Diplomatic Ties):</strong> नेपालले विश्वका १८३ भन्दा बढी राष्ट्रहरूसँग कूटनीतिक सम्बन्ध विस्तार गरिसकेको छ।</li></ul>',
            attachmentPath: 'lessons/pdfs/General-Information-about-Universe-Loksewa-PDF_compressed.pdf',
            quizzes: [
                ['question' => 'राष्ट्रिय जनगणना २०७८ अनुसार नेपालको कुल जनसंख्या कति रहेको छ?', 'options' => ['२,९१,६४,५७८ जना', '२,६४,९४,५०४ जना', '३,००,००,००० जना', '२,८५,००,००० जना'], 'answer' => 0, 'hint' => 'करिब २ करोड ९१ लाख ६४ हजार।', 'explanation' => 'राष्ट्रिय जनगणना २०७८ अनुसार नेपालको अन्तिम जनसंख्या २ करोड ९१ लाख ६४ हजार ५ सय ७८ रहेको छ।'],
                ['question' => 'राष्ट्रिय जनगणना २०७८ अनुसार नेपालको वार्षिक जनसंख्या वृद्धिदर कति रहेको छ?', 'options' => ['०.९२%', '१.३५%', '०.५०%', '१.११%'], 'answer' => 0, 'hint' => '१ प्रतिशतभन्दा कम (०.९२%)।', 'explanation' => 'जनगणना २०७८ अनुसार वार्षिक जनसंख्या वृद्धिदर ०.९२ प्रतिशतमा झरेको छ।'],
                ['question' => 'राष्ट्रिय जनगणना २०७८ अनुसार नेपालको कुल साक्षरता दर कति प्रतिशत पुगेको छ?', 'options' => ['७६.३%', '६५.९%', '८०.१%', '७०.०%'], 'answer' => 0, 'hint' => 'पुरुष साक्षरता ८३.६% र महिला साक्षरता ६९.४%।', 'explanation' => '५ वर्ष वा सोभन्दा माथिको कुल साक्षरता दर ७६.३ प्रतिशत पुगेको छ।'],
                ['question' => 'नेपालको १६औँ आवधिक योजना (२०८१/८२ - २०८५/८६) को मूल सोच के रहेको छ?', 'options' => ['सुशासन, सामाजिक न्याय र समृद्धि', 'समृद्ध नेपाल, सुखी नेपाली', 'दिगो विकास र गरिबी निवारण', 'कृषि र औद्योगिक रूपान्तरण'], 'answer' => 0, 'hint' => 'राष्ट्रिय योजना आयोगद्वारा तय गरिएको ३ स्तम्भ।', 'explanation' => '१६औँ योजनाको सोच "सुशासन, सामाजिक न्याय र समृद्धि" रहेको छ।'],
                ['question' => 'नेपाल संयुक्त राष्ट्रसंघ (UN) को सदस्य कहिले बनेको हो?', 'options' => ['सन् १९५५ डिसेम्बर १४', 'सन् १९४५ अक्टोबर २४', 'सन् १९६० सेप्टेम्बर २०', 'सन् १९५० डिसेम्बर १'], 'answer' => 0, 'hint' => 'प्याकेज डिल (Package Deal) अन्तर्गत सदस्यता प्राप्त।', 'explanation' => 'नेपालले १४ डिसेम्बर १९५५ मा संयुक्त राष्ट्रसंघको सदस्यता प्राप्त गरेको हो।'],
                ['question' => 'सार्क (SAARC) को स्थायी सचिवालय कहाँ अवस्थित छ?', 'options' => ['काठमाडौं, नेपाल', 'ढाका, बंगलादेश', 'नयाँ दिल्ली, भारत', 'कोलम्बो, श्रीलंका'], 'answer' => 0, 'hint' => 'वि.सं. २०४३ (सन् १९८७) मा काठमाडौंमा स्थापना भएको।', 'explanation' => 'सार्कको स्थायी सचिवालय काठमाडौं, नेपालमा रहेको छ।'],
                ['question' => 'बिम्सटेक (BIMSTEC) को स्थायी सचिवालय कहाँ अवस्थित छ?', 'options' => ['ढाका, बंगलादेश', 'बैंकक, थाइल्याण्ड', 'काठमाडौं, नेपाल', 'कोलम्बो, श्रीलंका'], 'answer' => 0, 'hint' => 'बंगलादेशको राजधानी।', 'explanation' => 'बिम्सटेकको स्थायी सचिवालय ढाका (बंगलादेश) मा अवस्थित छ।'],
                ['question' => 'नेपाल कहिलेसम्ममा अतिकम विकसित राष्ट्र (LDC) बाट विकासशील राष्ट्रमा स्तरोन्नति हुने लक्ष्य छ?', 'options' => ['सन् २०२६ नोभेम्बर', 'सन् २०३० डिसेम्बर', 'सन् २०२४ जनवरी', 'सन् २०४३ वैशाख'], 'answer' => 0, 'hint' => 'संयुक्त राष्ट्रसंघ महासभाद्वारा पारित समयावधि।', 'explanation' => 'नेपाल सन् २०२६ नोभेम्बरमा विकासशील राष्ट्रमा स्तरोन्नति हुने तालिका छ।'],
                ['question' => 'नेपालमा हाल कतिवटा स्थानीय तहहरू रहेका छन्?', 'options' => ['७५३ वटा (६ महानगर, ११ उपमहानगर, २७६ नगरपालिका, ४६० गाउँपालिका)', '७४४ वटा', '७६० वटा', '७०० वटा'], 'answer' => 0, 'hint' => '६ महानगर र ११ उपमहानगर सहित कुल ७५३।', 'explanation' => 'नेपालको संघीय संरचनामा कुल ७५३ वटा स्थानीय तहहरू रहेका छन्।'],
                ['question' => 'जनगणना २०७८ अनुसार सबैभन्दा बढी जनघनत्व भएको जिल्ला कुन हो?', 'options' => ['काठमाडौं (५,१०८ जना/वर्ग कि.मी.)', 'भक्तपुर', 'ललितपुर', 'झापा'], 'answer' => 0, 'hint' => 'राजधानी जिल्ला।', 'explanation' => 'काठमाडौंमा ५,१०८ जना प्रति वर्ग कि.मी. जनघनत्व रहेको छ भने मनाङमा सबैभन्दा कम ३ जना छ।'],
            ]
        );

        $this->createFullLesson(
            module: $m1,
            chapter: $c1_3,
            title: 'Official Nayab Subba Syllabus PDF',
            slug: 'nayab-subba-syllabus-pdf-6',
            type: 'pdf',
            order: 2,
            duration: 15,
            content: '<p>Official Public Service Commission (Lok Sewa Aayog) comprehensive syllabus PDF document for Nayab Subba (Non-Gazetted First Class - General Administration and Accounting Groups).</p>',
            attachmentPath: 'courses/syllabus/Nayab Subba Syllabus.pdf',
            quizzes: [
                ['question' => 'नायब सुब्बा प्रथम पत्रको सामान्य ज्ञान र बौद्धिक परीक्षण कति पूर्णाङ्कको हुन्छ?', 'options' => ['१०० पूर्णाङ्क (GK ५० प्रश्न र IQ ५० प्रश्न = १०० अङ्क)', '५० पूर्णाङ्क', '२०० पूर्णाङ्क', '७५ पूर्णाङ्क'], 'answer' => 0, 'hint' => '१०० अङ्कको वस्तुगत बहुवैकल्पिक परीक्षा।', 'explanation' => 'प्रथम पत्र १०० पूर्णाङ्कको हुन्छ जसमा GK र IQ का प्रश्नहरू सोधिन्छन्।'],
                ['question' => 'लोकसेवा आयोगको वस्तुगत परीक्षामा गलत उत्तर दिएबापत कति प्रतिशत अङ्क कट्टा गरिन्छ?', 'options' => ['२०% (प्रत्येक गलत उत्तरको ०.२० अङ्क)', '१०%', '२५%', 'नेगेटिभ मार्किङ हुँदैन'], 'answer' => 0, 'hint' => '१ अङ्कको प्रश्नमा ०.२० अङ्क कट्टा।', 'explanation' => 'लोकसेवा आयोगको नियम अनुसार वस्तुगत प्रश्नमा २० प्रतिशत नेगेटिभ मार्किङ गरिन्छ।'],
                ['question' => 'नायब सुब्बाको प्रथम पत्रमा उत्तीर्ण हुन न्यूनतम कति प्रतिशत अङ्क ल्याउनुपर्दछ?', 'options' => ['४०% (४० अङ्क)', '३२%', '५०%', '६०%'], 'answer' => 0, 'hint' => 'सामान्य उत्तीर्ण अङ्क ४० प्रतिशत हो।', 'explanation' => 'लोकसेवा परीक्षामा न्यूनतम उत्तीर्णाङ्क ४० प्रतिशत (४० अङ्क) तोकिएको छ।'],
                ['question' => 'नायब सुब्बा द्वितीय पत्रमा कुन विषयवस्तु समावेश गरिएको हुन्छ?', 'options' => ['समसामयिक अध्ययन तथा सार्वजनिक सेवा व्यवस्थापन (१०० अङ्क)', 'ऐच्छिक अर्थशास्त्र', 'अंग्रेजी भाषा मात्र', 'कम्प्युटर प्रयोगात्मक'], 'answer' => 0, 'hint' => 'कार्यालय व्यवस्थापन, संविधान र प्रशासन।', 'explanation' => 'द्वितीय पत्र समसामयिक अध्ययन तथा सार्वजनिक सेवा व्यवस्थापन विषयक विषयगत १०० पूर्णाङ्कको हुन्छ।'],
                ['question' => 'नायब सुब्बा तृतीय पत्र (प्रशासन समूह) मा कुन विषयको परीक्षा हुन्छ?', 'options' => ['सेवा सम्बन्धी कार्यप्रणाली र कानुन (१०० अङ्क)', 'गणित', 'सामान्य ज्ञान', 'लेखापरीक्षण मात्र'], 'answer' => 0, 'hint' => 'प्रशासनिक कानुन र कार्यविधि।', 'explanation' => 'तृतीय पत्र सेवा समूह सम्बन्धी कार्यप्रणाली र कानुन सम्बन्धी १०० पूर्णाङ्कको विषयगत परीक्षा हुन्छ।'],
            ]
        );

        // ─── Module 2: Pahilo Patra - Buddhi Parikshan (IQ & Aptitude) ───
        $m2 = Module::create([
            'course_id' => $course->id,
            'title' => 'Pahilo Patra: Buddhi Parikshan (IQ & Aptitude)',
            'slug' => 'nasu-pahilo-patra-iq-aptitude-' . $course->id,
            'description' => 'Verbal Reasoning, Numerical Ability, Logical & Analytical Reasoning, Coding-Decoding, and Non-Verbal Matrix for Nayab Subba 1st Paper.',
            'key_points' => "• Verbal Analogy & Classification: Identifying synonym/antonym, tool-function, part-whole patterns\n• Number Series: Arithmetic differences, prime jumps, geometric series, squares & cubes\n• Coding-Decoding: Letter shifts (+1 to +5), reverse alphabet pairs (AZ, BY, CX), and matrix matrices",
            'notes' => 'Complete step-by-step logic, shortcuts, and formulas for Nayab Subba IQ section.',
            'pdf_file' => 'lessons/pdfs/01M1GH7TVYCSV16WJZXKJTD51J.pdf',
            'order' => 2,
            'is_published' => true,
        ]);

        $c2_1 = Chapter::create([
            'module_id' => $m2->id,
            'title' => 'Verbal & Quantitative Reasoning',
            'slug' => 'nasu-verbal-quantitative-' . $m2->id,
            'order' => 1,
            'is_published' => true,
        ]);

        $this->createFullLesson(
            module: $m2,
            chapter: $c2_1,
            title: 'Verbal Analogy and Series Methods',
            slug: 'verbal-analogy-and-series-7',
            type: 'text',
            order: 1,
            duration: 20,
            content: '<h3>१. शाब्दिक समरूपता (Verbal Analogy)</h3><p>सम्बन्ध पहिचान गरी सोही अनुरूप अर्को जोडी पत्ता लगाउने विधि:</p><ul><li><strong>औजार र कार्य (Tool & Function):</strong> कलम : लेख्नु :: चक्कु : काट्नु (Pen : Write :: Knife : Cut)</li><li><strong>व्यक्ति र कार्यस्थल (Worker & Workplace):</strong> शिक्षक : विद्यालय :: चिकित्सक : अस्पताल (Teacher : School :: Doctor : Hospital)</li><li><strong>देश र राजधानी (Country & Capital):</strong> नेपाल : काठमाडौं :: फ्रान्स : पेरिस (Nepal : Kathmandu :: France : Paris)</li><li><strong>देश र मुद्रा (Country & Currency):</strong> बंगलादेश : टाका :: जापान : येन (Bangladesh : Taka :: Japan : Yen)</li><li><strong>यन्त्र र मापन (Instrument & Measurement):</strong> थर्मोमिटर : तापक्रम :: ब्यारोमिटर : वायुमण्डलीय चाप (Thermometer : Temperature :: Barometer : Pressure)</li></ul><h3>२. अक्षर तथा संख्या शृङ्खला (Number & Letter Series)</h3><ul><li><strong>अन्तर शृङ्खला (Difference Series):</strong> २, ५, १०, १७, २६, ? (अन्तर: +३, +५, +७, +९, +११ = ३७)</li><li><strong>वर्ग संख्या शृङ्खला (Square Series):</strong> १, ४, ९, १६, २५, ३६, ? (उत्तर: ४९)</li><li><strong>घन संख्या शृङ्खला (Cube Series):</strong> १, ८, २७, ६४, १२५, ? (उत्तर: २१६)</li><li><strong>अक्षर स्थानान्तरण (Letter Shift):</strong> A(+2)=C, C(+2)=E, E(+2)=G, G(+2)=I</li></ul>',
            attachmentPath: 'lessons/pdfs/Analogy Kharidar.pdf',
            quizzes: [
                ['question' => 'कलम : लेख्नु :: चक्कु : ?', 'options' => ['काट्नु (Cut)', 'छिल्नु', 'बनाउनु', 'चित्र कोर्नु'], 'answer' => 0, 'hint' => 'औजारको मुख्य कार्य।', 'explanation' => 'कलम लेख्न प्रयोग गरिन्छ भने चक्कु काट्न प्रयोग गरिन्छ।'],
                ['question' => 'नेपाल : काठमाडौं :: फ्रान्स : ?', 'options' => ['पेरिस (Paris)', 'लण्डन', 'रोम', 'बर्लिन'], 'answer' => 0, 'hint' => 'देशको राजधानी।', 'explanation' => 'नेपालको राजधानी काठमाडौं हो भने फ्रान्सको राजधानी पेरिस हो।'],
                ['question' => 'शृङ्खला पूरा गर्नुहोस्: २, ६, १८, ५४, ?', 'options' => ['१६२', '१०८', '७२', '२१६'], 'answer' => 0, 'hint' => 'अघिल्लो पदलाई ३ ले गुणन गरिएको छ (५४ × ३)।', 'explanation' => 'गुणोत्तर श्रेणी (Geometric series): २×३=६, ६×३=१८, १८×३=५४, ५४×३=१६२।'],
                ['question' => 'शृङ्खला पूरा गर्नुहोस्: १, ४, ९, १६, २५, ?', 'options' => ['३६', '३०', '४९', '४०'], 'answer' => 0, 'hint' => 'क्रमिक संख्याहरूको वर्ग (६ को वर्ग)।', 'explanation' => '१^२=१, २^२=४, ३^२=९, ४^२=१६, ५^२=२५, ६^२=३६।'],
                ['question' => 'यदि CAT = 24 र DOG = 26 हुन्छ भने BAT = ?', 'options' => ['23', '25', '22', '20'], 'answer' => 0, 'hint' => 'B(2) + A(1) + T(20) = 23।', 'explanation' => 'वर्णमालाको स्थान मान जोड्दा: B=2, A=1, T=20 -> २+१+२० = २३।'],
                ['question' => 'फरक शब्द पत्ता लगाउनुहोस् (Odd One Out): स्याउ, केरा, सुन्तला, आलु', 'options' => ['आलु', 'स्याउ', 'केरा', 'सुन्तला'], 'answer' => 0, 'hint' => 'फलफूल र जमिनमुनि फल्ने तरकारी/कन्दमूल।', 'explanation' => 'आलु तरकारी/कन्दमूल हो भने बाँकी सबै फलफूल हुन्।'],
                ['question' => 'यदि BOOK लाई CPPL कोड गरिन्छ भने READ लाई के कोड गरिन्छ?', 'options' => ['SFBE', 'RFBE', 'SEBE', 'SFBF'], 'answer' => 0, 'hint' => 'प्रत्येक अक्षर १ ले अगाडि बढ्छ (+1): R->S, E->F, A->B, D->E।', 'explanation' => 'प्रत्येक अक्षरमा +१ जोड्दा READ = SFBE बन्दछ।'],
                ['question' => 'ब्यारोमिटर : वायुमण्डलीय चाप :: ओडोमिटर : ?', 'options' => ['दूरी (Distance)', 'गति (Speed)', 'तापक्रम', 'उचाइ'], 'answer' => 0, 'hint' => 'सवारी साधनले पार गरेको दूरी नाप्ने यन्त्र।', 'explanation' => 'ओडोमिटरले सवारी साधनले पार गरेको दूरी नाप्दछ।'],
                ['question' => 'शृङ्खला पूरा गर्नुहोस्: B, D, F, H, ?', 'options' => ['J', 'I', 'K', 'L'], 'answer' => 0, 'hint' => '१ अक्षर छाडेर (+२): B(+2)=D(+2)=F(+2)=H(+2)=J।', 'explanation' => 'वर्णमालामा २-२ को अन्तर छ, त्यसैले H पछि J आउँछ।'],
                ['question' => 'फरक संख्या पत्ता लगाउनुहोस्: १३, १७, १९, २१, २३', 'options' => ['२१', '१३', '१७', '२३'], 'answer' => 0, 'hint' => 'संयुक्त संख्या (३ र ७ ले भाग जाने)।', 'explanation' => '२१ संयुक्त संख्या (३×७) हो भने बाँकी सबै रूढ (Prime) संख्याहरू हुन्।'],
            ]
        );

        $this->createFullLesson(
            module: $m2,
            chapter: $c2_1,
            title: 'Nayab Subba IQ Assessment Quiz',
            slug: 'nayab-subba-iq-quiz-7',
            type: 'quiz',
            order: 2,
            duration: 20,
            content: '<p>Comprehensive Intelligence Quotient (IQ) speed practice test for Nayab Subba 1st Paper screening examination.</p>',
            attachmentPath: 'lessons/pdfs/Number Series Kharidar.pdf',
            quizzes: [
                ['question' => 'चिकित्सक : अस्पताल :: शिक्षक : ?', 'options' => ['विद्यालय (School)', 'पुस्तकालय', 'कार्यालय', 'अदालत'], 'answer' => 0, 'hint' => 'कार्यस्थल सम्बन्ध।', 'explanation' => 'चिकित्सक अस्पतालमा काम गर्छन् भने शिक्षक विद्यालयमा।'],
                ['question' => 'शृङ्खला पूरा गर्नुहोस्: ३, ७, ११, १५, ?', 'options' => ['१९', '१८', '२०', '२१'], 'answer' => 0, 'hint' => '४ को स्थिर अन्तर (+४): १५ + ४ = १९।', 'explanation' => 'समान अन्तर शृङ्खला (Arithmetic difference +4): १५ + ४ = १९।'],
                ['question' => 'यदि FRIEND लाई HUMJTK कोड गरिन्छ भने CANDLE लाई के कोड गरिन्छ?', 'options' => ['EDRIRL', 'DCQHQK', 'ESJFME', 'DEQJQM'], 'answer' => 0, 'hint' => 'प्रत्येक अक्षर २ ले अगाडि बढ्छ (+2)।', 'explanation' => 'C(+2)=E, A(+2)=D, N(+2)=P -> +२ को नियम अनुसार EDRIRL।'],
                ['question' => 'फरक पत्ता लगाउनुहोस्: तामा, चाँदी, सुन, प्लास्टिक', 'options' => ['प्लास्टिक', 'तामा', 'चाँदी', 'सुन'], 'answer' => 0, 'hint' => 'धातु र अधातु/सिन्थेटिक।', 'explanation' => 'प्लास्टिक अधातु पोलिमर हो भने बाँकी सबै धातु हुन्।'],
                ['question' => '५ जना मानिसले एउटा काम १० दिनमा गर्न सक्छन् भने १० जनाले सो काम कति दिनमा सक्लान्?', 'options' => ['५ दिन', '२ दिन', '८ दिन', '१० दिन'], 'answer' => 0, 'hint' => 'जनशक्ति दोब्बर हुँदा दिन आधा हुन्छ (५ × १० ÷ १० = ५)।', 'explanation' => 'काम र समयको ऐकिक नियम अनुसार (५ × १०) ÷ १० = ५ दिन लाग्छ।'],
            ]
        );

        // ─── Module 3: Dosro Patra - Samanya Prashashan (General Administration) ───
        $m3 = Module::create([
            'course_id' => $course->id,
            'title' => 'Dosro Patra: Samanya Prashashan (General Administration)',
            'slug' => 'nasu-dosro-patra-samanya-prashashan-' . $course->id,
            'description' => 'Constitution of Nepal 2072, Good Governance Act 2064, Right to Information, Civil Service Act 2049, Office Procedures, Records & Filing.',
            'key_points' => "• Constitution: Part 3 Fundamental Rights (Articles 16-46), Part 4 Directive Principles, Federal Exec/Leg/Judiciary\n• Good Governance Act 2064: Citizen Charter, Public Hearing, Grievance Handling, Delegated Authority\n• Office Procedures: Darta, Chalani, Tippani drafting, Filing systems, Record retention & Disposal rules",
            'notes' => 'Detailed theoretical and subjective notes for Nayab Subba 2nd Paper Examination.',
            'pdf_file' => 'lessons/pdfs/01M1GMT5P2XRGBP1F95RDKG8PW.pdf',
            'order' => 3,
            'is_published' => true,
        ]);

        $c3_1 = Chapter::create([
            'module_id' => $m3->id,
            'title' => 'Prashasanik Byawastha ra Karyabidhi (Administrative Procedures)',
            'slug' => 'nasu-admin-procedures-' . $m3->id,
            'order' => 1,
            'is_published' => true,
        ]);

        $this->createFullLesson(
            module: $m3,
            chapter: $c3_1,
            title: 'Principles of Public Administration & Office Management',
            slug: 'principles-of-public-administration-8',
            type: 'text',
            order: 1,
            duration: 25,
            content: '<h3>१. सार्वजनिक प्रशासनको अवधारणा र सिद्धान्त (Public Administration Concepts)</h3><p>सार्वजनिक प्रशासन राज्यको नीति, ऐन, नियम तथा कार्यक्रमहरूको प्रभावकारी कार्यान्वयन गर्ने स्थायी संयन्त्र हो।</p><ul><li><strong>काठ प्रणाली (Bureaucracy - Max Weber):</strong> पदसोपान (Hierarchy), कार्यविभाजन, योग्यतामा आधारित छनोट, नियममा आधारित कार्यसञ्चालन, र निर्वैयक्तिकता।</li><li><strong>प्रशासनका कार्यहरू (POSDCORB - Luther Gulick):</strong> Planning (योजना), Organizing (संगठन), Staffing (कर्मचारी व्यवस्था), Directing (निर्देशन), Coordinating (समन्वय), Reporting (प्रतिवेदन), Budgeting (बजेटिङ)।</li><li><strong>सुशासनका आधारस्तम्भहरू (Pillars of Good Governance):</strong> विधिको शासन (Rule of Law), पारदर्शिता (Transparency), उत्तरदायित्व (Accountability), सहभागिता (Participation), प्रभावकारिता र मितव्ययिता।</li></ul><h3>२. कार्यालय कार्यविधि र अभिलेख व्यवस्थापन (Office Procedures & Records)</h3><ul><li><strong>दर्ता (Darta):</strong> कार्यालयमा बाहिरबाट प्राप्त हुने चिठीपत्र, निवेदन तथा कागजातहरूको आधिकारिक विवरण (मिति, पठाउने कार्यालय, पत्र संख्या, विषय आदि) दर्ता किताबमा चढाउने कार्य।</li><li><strong>चलानी (Chalani):</strong> कार्यालयबाट बाहिर पठाइने आधिकारिक पत्र, आदेश वा कागजातहरूलाई चलानी किताबमा दर्ता गरी नम्बर प्रदान गर्ने कार्य।</li><li><strong>टिप्पणी लेखन (Tippani Drafting):</strong> कुनै निर्णय गर्नुपर्ने विषयमा तल्लो तहबाट तथ्य, कानुन, विकल्प र सिफारिस खुलाएर माथिल्लो अधिकारीसमक्ष पेस गरिने लिखित प्रशासनिक प्रस्ताव। टिप्पणीका अङ्गहरू: विषय, पृष्ठभूमि/तथ्य, कानुनी व्यवस्था, समस्या/विकल्प र सिफारिस/राय।</li><li><strong>फाइलिङ (Filing):</strong> भविष्यमा सजिलै खोजेको समयमा फेला पार्न सकिने गरी कागजातहरूलाई नियमबद्ध तरिकाले सुरक्षित राख्ने व्यवस्था। विधिहरू: वर्णानुक्रम (Alphabetical), संख्यात्मक (Numerical), विषयात्मक (Subject-wise), भौगोलिक (Geographical)।</li></ul>',
            attachmentPath: 'lessons/pdfs/Office Management Kharidar.pdf',
            quizzes: [
                ['question' => 'प्रशासनका कार्यहरूलाई जनाउने POSDCORB अवधारणाका प्रतिपादक को हुन्?', 'options' => ['लुथर गुलिक (Luther Gulick)', 'म्याक्स वेबर', 'उड्रो विल्सन', 'एफ. डब्लु. टेलर'], 'answer' => 0, 'hint' => 'प्रशासनिक कार्यका ७ स्तम्भ व्याख्या गर्ने विद्वान्।', 'explanation' => 'लुथर गुलिकले योजनादेखि बजेटसम्मका ७ कार्यलाई POSDCORB नाम दिएका हुन्।'],
                ['question' => 'सरकारी कार्यालयमा बाहिरबाट प्राप्त हुने पत्रहरूलाई औपचारिक रूपमा अभिलेख राख्ने कार्यलाई के भनिन्छ?', 'options' => ['दर्ता (Registration)', 'चलानी (Dispatch)', 'टिप्पणी', 'फाइलिङ'], 'answer' => 0, 'hint' => 'आउने पत्रको प्रारम्भिक अभिलेख।', 'explanation' => 'कार्यालयमा प्राप्त हुने चिठीपत्रलाई दर्ता किताबमा दर्ता नम्बरसहित चढाइन्छ।'],
                ['question' => 'निर्णय प्रक्रियाका लागि तल्लो तहबाट कानुन र तथ्य खुलाएर माथिल्लो तहमा पेस गरिने कागजातलाई के भनिन्छ?', 'options' => ['टिप्पणी (Tippani)', 'प्रतिवेदन', 'चलानी', 'नागरिक वडापत्र'], 'answer' => 0, 'hint' => 'प्रशासनिक निर्णयको आधार पत्र।', 'explanation' => 'निर्णय प्रक्रियाका लागि रायसहित पेस गरिने औपचारिक पत्र टिप्पणी हो।'],
                ['question' => 'सुशासन (व्यवस्थापन तथा सञ्चालन) ऐन, २०६४ अनुसार सार्वजनिक सेवा प्रदायक कार्यालयमा कुन पत्र अनिवार्य राखिनुपर्छ?', 'options' => ['नागरिक वडापत्र (Citizen Charter)', 'विज्ञापन बोर्ड', 'कर्मचारी हाजिरी मात्र', 'आयव्यय विवरण मात्र'], 'answer' => 0, 'hint' => 'सेवाको प्रकार, दस्तुर, समय र जिम्मेवार अधिकारी उल्लेख भएको बोर्ड।', 'explanation' => 'सुशासन ऐनको दफा २५ अनुसार प्रत्येक कार्यालयले नागरिक वडापत्र राख्नु अनिवार्य छ।'],
                ['question' => 'सूचनाको हक सम्बन्धी ऐन, २०६४ अनुसार सूचना माग भएको कति समयभित्र सूचना अधिकारीले सूचना उपलब्ध गराउनुपर्छ?', 'options' => ['१५ दिनभित्र (तत्काल दिन सकिने भए तत्कालै, जीउज्यानको भए २४ घण्टाभित्र)', '३० दिनभित्र', '७ दिनभित्र', '४५ दिनभित्र'], 'answer' => 0, 'hint' => 'सामान्य अवस्थामा १५ दिन र व्यक्तिको जीउज्यानको भए २४ घण्टा।', 'explanation' => 'दफा ७ अनुसार सूचना अधिकारीले १५ दिनभित्र सूचना दिनुपर्छ।'],
            ]
        );

        $this->createFullLesson(
            module: $m3,
            chapter: $c3_1,
            title: 'Basic Accounting and Financial Procedures for Nayab Subba',
            slug: 'basic-accounting-for-nayab-subba-9',
            type: 'text',
            order: 2,
            duration: 25,
            content: '<h3>१. सरकारी लेखा प्रणाली (Government Accounting in Nepal)</h3><p>नेपाल सरकारको नयाँ स्रेस्ता प्रणाली (वि.सं. २०१८ देखि लागू) दोहोरो लेखा प्रणाली (Double Entry System) मा आधारित छ।</p><ul><li><strong>एकल खाता कोष प्रणाली (Treasury Single Account - TSA):</strong> सरकारी कोषको कुशल व्यवस्थापन गर्न महालेखा नियन्त्रक कार्यालय (FCGO) मातहत सबै जिल्लामा कोष तथा लेखा नियन्त्रक कार्यालय (कोलेनिका) मार्फत सञ्चालन गरिने भुक्तानी प्रणाली।</li><li><strong>आर्थिक कार्यविधि तथा वित्तीय उत्तरदायित्व ऐन, २०७६:</strong> सार्वजनिक स्रोतको प्राप्ति, बजेट तर्जुमा, निकासा, खर्च, लेखाङ्कन, आन्तरिक नियन्त्रण र वित्तीय प्रतिवेदनका कानुनी आधारहरू तोक्दछ।</li><li><strong>लेखापरीक्षण (Audit):</strong> आन्तरिक लेखापरीक्षण कोलेनिकाबाट र अन्तिम लेखापरीक्षण संविधानको धारा २४१ अनुसार महालेखा परीक्षक (Auditor General) बाट गरिन्छ।</li></ul><h3>२. सार्वजनिक खरिद र जिन्सी व्यवस्थापन (Public Procurement & Store)</h3><ul><li><strong>सार्वजनिक खरिद ऐन, २०६३:</strong> सार्वजनिक खर्चमा प्रतिस्पर्धा, पारदर्शिता, स्वच्छता र मितव्ययिता कायम गर्न लागू गरिएको कानुन।</li><li><strong>जिन्सी वर्गीकरण:</strong> खर्च भएर जाने जिन्सी मालसामान (Stationery, Fuel) र खर्च भएर नजाने जिन्सी मालसामान (Furniture, Computers, Vehicles)।</li></ul>',
            attachmentPath: 'lessons/pdfs/01M1GQ09MQKDDETESQ6XS9MJXW.pdf',
            quizzes: [
                ['question' => 'नेपालमा सरकारी अन्तिम लेखापरीक्षण कसले गर्दछ?', 'options' => ['महालेखा परीक्षक (Auditor General)', 'कोष तथा लेखा नियन्त्रक कार्यालय', 'अर्थ मन्त्रालय', 'आन्तरिक राजस्व विभाग'], 'answer' => 0, 'hint' => 'संविधानको भाग २२ (धारा २४०-२४१) को संवैधानिक अङ्ग।', 'explanation' => 'नेपालको संविधानको धारा २४१ अनुसार महालेखा परीक्षकले अन्तिम लेखापरीक्षण गर्दछ।'],
                ['question' => 'नेपाल सरकारको सरकारी लेखा प्रणाली कुन सिद्धान्तमा आधारित छ?', 'options' => ['दोहोरो लेखा प्रणाली (Double Entry System)', 'एकहोरो लेखा प्रणाली', 'नगद स्रेस्ता मात्र', 'अनुमानित स्रेस्ता'], 'answer' => 0, 'hint' => 'डेबिट र क्रेडिटको सन्तुलन रहने अन्तर्राष्ट्रिय सिद्धान्त।', 'explanation' => 'नेपालको नयाँ स्रेस्ता प्रणाली दोहोरो लेखा प्रणालीको सिद्धान्तमा आधारित छ।'],
                ['question' => 'एकल खाता कोष प्रणाली (TSA) को मुख्य उद्देश्य के हो?', 'options' => ['सरकारी कोषको वास्तविक समयमा नगद व्यवस्थापन र नियन्त्रण गर्नु', 'कर दर बढाउनु', 'कर्मचारी कटौती गर्नु', 'बजेट रोक्नु'], 'answer' => 0, 'hint' => 'नगद सन्तुलन र पारदर्शिता कायम गर्ने आधुनिक प्रणाली।', 'explanation' => 'TSA ले सरकारी ढुकुटीको दैनिक नगद स्थिति अनुगमन र प्रभावकारी व्यवस्थापन गर्दछ।'],
                ['question' => 'सार्वजनिक खरिद ऐन, २०६३ को मुख्य उद्देश्य के हो?', 'options' => ['प्रतिस्पर्धा, स्वच्छता, पारदर्शिता र मितव्ययिता कायम गर्नु', 'बिना प्रतिस्पर्धा खरिद गर्नु', 'विदेशी कम्पनीलाई मात्र प्राथमिकता दिनु', 'खर्च बढाउनु'], 'answer' => 0, 'hint' => 'सार्वजनिक कोषको अधिकतम सदुपयोग।', 'explanation' => 'सार्वजनिक खरिद ऐनले खरिद प्रक्रियामा खुला प्रतिस्पर्धा र पारदर्शिता सुनिश्चित गर्छ।'],
                ['question' => 'खर्च भएर नजाने जिन्सी सामानको उदाहरण कुन हो?', 'options' => ['कम्प्युटर र फर्निचर', 'कागज र कलम', 'पेट्रोल र डिजेल', 'चिया र खाजा'], 'answer' => 0, 'hint' => 'दीर्घकालीन प्रयोग हुने पुँजीगत वस्तु।', 'explanation' => 'फर्निचर, कम्प्युटर, सवारी साधन खर्च भएर नजाने पुँजीगत जिन्सी सामान हुन्।'],
            ]
        );
    }

    /**
     * 2. KHARIDAR TAYARI
     */
    private function seedKharidar(): void
    {
        $course = Course::updateOrCreate(
            ['slug' => 'kharidar-tayari'],
            [
                'title' => 'Kharidar Tayari',
                'description' => 'Complete preparation course for Kharidar (Non-Gazetted Second Class) position covering General Knowledge, IQ & Aptitude, Office Management, and Work Procedures.',
                'level' => 'beginner',
                'thumbnail' => 'course-thumbnails/01M18FVD47T77TN568HT702AJ5.jpg',
                'syllabus_pdf' => 'courses/syllabus/Kharidar Syllabus.pdf',
                'is_published' => true,
            ]
        );

        $this->cleanCourseContent($course);

        // Module 1: GK
        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Samanya Gyan (General Knowledge)',
            'slug' => 'kharidar-samanya-gyan-' . $course->id,
            'description' => 'First Paper: Objective General Knowledge covering Geography, History, Science, and National Affairs of Nepal.',
            'key_points' => "• Geography of Nepal: Rivers, Mountains, Climate & National Parks\n• History of Nepal: Ancient, Medieval, Shah & Democratic eras\n• General Science: Basic physics, chemistry, biology & environmental conservation",
            'notes' => 'Complete Kharidar First Paper General Knowledge syllabus study notes.',
            'pdf_file' => 'courses/syllabus/Kharidar Syllabus.pdf',
            'order' => 1,
            'is_published' => true,
        ]);

        $c1 = Chapter::create([
            'module_id' => $m1->id,
            'title' => 'Nepal ko Bhugol ra Itihas',
            'slug' => 'kharidar-geography-history-' . $m1->id,
            'order' => 1,
            'is_published' => true,
        ]);

        $this->createFullLesson(
            module: $m1,
            chapter: $c1,
            title: 'Physical Geography of Nepal',
            slug: 'kharidar-physical-geography-nepal',
            type: 'text',
            order: 1,
            duration: 20,
            content: '<h3>नेपालको भूगोल र धरातलीय विभाजन</h3><p>नेपालको कुल क्षेत्रफल १,४७,१८१ वर्ग किलोमिटर छ। भौगोलिक रूपमा हिमाली प्रदेश (१५%), पहाडी प्रदेश (६८%) र तराई प्रदेश (१७%) मा विभाजन गरिएको छ। नेपालका प्रमुख नदी प्रणालीहरू कोशी, गण्डकी र कर्णाली हुन्। कर्णाली नेपालको सबैभन्दा लामो नदी (५०७ कि.मी.) हो।</p>',
            attachmentPath: 'lessons/pdfs/Geography of Nepal_compressed.pdf',
            quizzes: [
                ['question' => 'नेपालको कुल क्षेत्रफल कति छ?', 'options' => ['१,४७,१८१ वर्ग कि.मी.', '१,४७,५१६ वर्ग कि.मी.', '१,४८,००० वर्ग कि.मी.', '१,५०,००० वर्ग कि.मी.'], 'answer' => 0, 'hint' => 'आधिकारिक क्षेत्रफल।', 'explanation' => 'नेपालको क्षेत्रफल १,४७,१८१ वर्ग कि.मी. हो।'],
                ['question' => 'नेपालको सबैभन्दा लामो नदी कुन हो?', 'options' => ['कर्णाली नदी (५०७ कि.मी.)', 'कोशी नदी', 'गण्डकी नदी', 'बागमती नदी'], 'answer' => 0, 'hint' => '५०७ कि.मी. लामो नदी।', 'explanation' => 'कर्णाली नेपालको सबैभन्दा लामो नदी हो।'],
            ]
        );

        $this->createFullLesson(
            module: $m1,
            chapter: $c1,
            title: 'History of Modern Nepal',
            slug: 'kharidar-history-modern-nepal',
            type: 'text',
            order: 2,
            duration: 20,
            content: '<h3>नेपालको आधुनिक इतिहास</h3><p>वि.सं. १७९९ मा पृथ्वीनारायण शाह गोर्खाका राजा बने र एकीकरण अभियान सुरु गरे। वि.सं. १८२५ मा कान्तिपुर विजय भयो। सुगौली सन्धि सन् १८१६ मा सम्पन्न भयो। वि.सं. १९०३ मा कोतपर्वबाट राणा शासन सुरु भयो र वि.सं. २००७ फागुन ७ मा प्रजातन्त्र स्थापना भयो।</p>',
            attachmentPath: 'lessons/pdfs/HIstory of Nepal.pdf',
            quizzes: [
                ['question' => 'पृथ्वीनारायण शाहले कान्तिपुर कहिले विजय गरेका थिए?', 'options' => ['वि.सं. १८२५ असोज १३', 'वि.सं. १८०१', 'वि.सं. १८२६', 'वि.सं. १८३१'], 'answer' => 0, 'hint' => 'इन्द्रजात्राको दिन।', 'explanation' => 'वि.सं. १८२५ असोज १३ मा कान्तिपुर विजय भएको थियो।'],
                ['question' => 'राणा शासनको अन्त्य भई प्रजातन्त्र कहिले स्थापना भयो?', 'options' => ['वि.सं. २००७ फागुन ७', 'वि.सं. २०१७ पुस १', 'वि.सं. २०४६ चैत २६', 'वि.सं. २०६३ वैशाख ११'], 'answer' => 0, 'hint' => 'राष्ट्रिय प्रजातन्त्र दिवस।', 'explanation' => 'वि.सं. २००७ फागुन ७ मा प्रजातन्त्र स्थापना भएको थियो।'],
            ]
        );

        // Module 2: Office Management
        $m2 = Module::create([
            'course_id' => $course->id,
            'title' => 'Karyalaya Byawasthapan (Office Management)',
            'slug' => 'kharidar-karyalaya-byawasthapan-' . $course->id,
            'description' => 'Second Paper: Office procedures, filing, record management, registration, dispatch, and correspondence.',
            'key_points' => "• Office Procedures: Darta (Registration), Chalani (Dispatch), Tippani (Office memo)\n• Filing & Records: Classification, Indexing, Record destruction schedules\n• Public Relations: Citizen Charter, Public Grievance handling",
            'notes' => 'Comprehensive Office Management study notes for Kharidar Second Paper.',
            'pdf_file' => 'lessons/pdfs/Office Management Kharidar.pdf',
            'order' => 2,
            'is_published' => true,
        ]);

        $c2 = Chapter::create([
            'module_id' => $m2->id,
            'title' => 'Karyalaya Karyabidhi ra Abhilekh',
            'slug' => 'kharidar-office-records-' . $m2->id,
            'order' => 1,
            'is_published' => true,
        ]);

        $this->createFullLesson(
            module: $m2,
            chapter: $c2,
            title: 'Office Filing and Record Management',
            slug: 'kharidar-office-filing-record-management',
            type: 'text',
            order: 1,
            duration: 20,
            content: '<h3>कार्यालय फाइलिङ र अभिलेख</h3><p>फाइलिङ भनेको कागजातहरूलाई व्यवस्थित रूपमा भण्डारण गरी आवश्यक पर्दा छिटो फेला पार्ने विधि हो। दर्ता र चलानी सरकारी कार्यालयको प्राथमिक अभिलेख प्रणाली हुन्।</p>',
            attachmentPath: 'lessons/pdfs/Office Management Kharidar.pdf',
            quizzes: [
                ['question' => 'सरकारी कार्यालयबाट बाहिर पठाइने पत्रलाई के भनिन्छ?', 'options' => ['चलानी पत्र (Dispatch)', 'दर्ता पत्र', 'टिप्पणी', 'वडापत्र'], 'answer' => 0, 'hint' => 'चलानी किताबमा दर्ता हुने पत्र।', 'explanation' => 'बाहिर पठाइने पत्रलाई चलानी गरिन्छ।'],
            ]
        );

        // Module 3: IQ Test
        $m3 = Module::create([
            'course_id' => $course->id,
            'title' => 'Samanya Buddhi Parikshan (IQ Test)',
            'slug' => 'kharidar-iq-test-' . $course->id,
            'description' => 'First Paper: Verbal Reasoning, Number Series, Analogies, and Classification.',
            'key_points' => "• Number Series & Arithmetic\n• Verbal Analogy & Coding-Decoding\n• Classification & Direction Sense",
            'notes' => 'Kharidar IQ shortcuts and solved practice questions.',
            'pdf_file' => 'lessons/pdfs/Analogy Kharidar.pdf',
            'order' => 3,
            'is_published' => true,
        ]);

        $c3 = Chapter::create([
            'module_id' => $m3->id,
            'title' => 'Number and Letter Series',
            'slug' => 'kharidar-series-reasoning-' . $m3->id,
            'order' => 1,
            'is_published' => true,
        ]);

        $this->createFullLesson(
            module: $m3,
            chapter: $c3,
            title: 'Number Series and Analogy Methods',
            slug: 'kharidar-number-series-analogy',
            type: 'text',
            order: 1,
            duration: 20,
            content: '<h3>संख्या शृङ्खला र समरूपता</h3><p>संख्या शृङ्खलामा अन्तर, गुणन, वर्ग र घन संख्याको नियम प्रयोग गरिन्छ।</p>',
            attachmentPath: 'lessons/pdfs/Number Series Kharidar.pdf',
            quizzes: [
                ['question' => 'शृङ्खला पूरा गर्नुहोस्: ५, १०, १५, २०, ?', 'options' => ['२५', '२२', '३०', '२४'], 'answer' => 0, 'hint' => '५ को अन्तर (+५)।', 'explanation' => '५ को अन्तरले अर्को संख्या २५ हुन्छ।'],
            ]
        );
    }

    /**
     * 3. SECTION OFFICER TAYARI
     */
    private function seedSectionOfficer(): void
    {
        $seeder = new SectionOfficerCourseSeeder();
        $course = $seeder->seedSectionOfficerCourse();
        SectionOfficerQuizBank::attachQuestionsToAllLessons($course);
    }

    /**
     * 4. NRB OFFICER TAYARI
     */
    private function seedNrbOfficer(): void
    {
        $course = Course::updateOrCreate(
            ['slug' => 'nrb-officer-tayari'],
            [
                'title' => 'NRB Officer Tayari',
                'description' => 'Nepal Rastra Bank Officer (Third Class) preparation covering Macroeconomics, Nepalese Banking System, Financial Accounting, and Banking Operations.',
                'level' => 'advanced',
                'thumbnail' => 'course-thumbnails/01M18G0T0GSTDYC58G8FKZ120P.jpg',
                'syllabus_pdf' => 'courses/syllabus/01M1GVG10VDPVBNQMDA2YDK6RB.pdf',
                'is_published' => true,
            ]
        );

        $this->cleanCourseContent($course);

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Economics: Micro & Macro Fundamentals',
            'slug' => 'nrb-officer-economics-' . $course->id,
            'description' => 'Macroeconomics, Inflation, GDP, Fiscal and Monetary Policy interactions.',
            'key_points' => "• Macroeconomic Indicators: Inflation, GDP Growth, Forex Reserves\n• Monetary Policy: CRR, SLR, Repo, Reverse Repo, Policy Rate\n• NRB Act 2058 & Central Bank Functions",
            'notes' => 'Detailed economics study notes for NRB Officer examination.',
            'pdf_file' => 'courses/syllabus/01M1GVG10VDPVBNQMDA2YDK6RB.pdf',
            'order' => 1,
            'is_published' => true,
        ]);

        $c1 = Chapter::create([
            'module_id' => $m1->id,
            'title' => 'Macroeconomics & Monetary Policy',
            'slug' => 'nrb-macro-monetary-' . $m1->id,
            'order' => 1,
            'is_published' => true,
        ]);

        $this->createFullLesson(
            module: $m1,
            chapter: $c1,
            title: 'Macroeconomic Principles & Central Banking',
            slug: 'nrb-macro-principles-central-banking',
            type: 'text',
            order: 1,
            duration: 25,
            content: '<h3>नेपालको अर्थतन्त्र र मौद्रिक नीति</h3><p>नेपाल राष्ट्र बैंक ऐन, २०५८ को दफा ४ अनुसार मूल्य र शोधनान्तर स्थिरता कायम गर्नु तथा वित्तीय स्थायित्व प्रवर्द्धन गर्नु केन्द्रीय बैंकको मुख्य उद्देश्य हो।</p>',
            attachmentPath: 'lessons/pdfs/01M1HQ484V93105N933755GB8P.pdf',
            quizzes: [
                ['question' => 'नेपाल राष्ट्र बैंक ऐन, २०५८ को कुन दफामा बैंकका उद्देश्यहरू तोकिएका छन्?', 'options' => ['दफा ४', 'दफा ५', 'दफा १०', 'दफा २'], 'answer' => 0, 'hint' => 'मूल्य स्थिरता र वित्तीय स्थायित्व सम्बन्धी दफा।', 'explanation' => 'दफा ४ मा नेपाल राष्ट्र बैंकका प्रमुख उद्देश्यहरू उल्लेख छन्।'],
            ]
        );
    }

    /**
     * 5. NRB ASSISTANT DIRECTOR TAYARI
     */
    private function seedNrbAssistantDirector(): void
    {
        $course = Course::updateOrCreate(
            ['slug' => 'nrb-assistant-director-tayari'],
            [
                'title' => 'NRB Assistant Director Tayari',
                'description' => 'Premium preparation course for NRB Assistant Director covering Banking Regulations, Basel Core Principles, Financial Markets, and Monetary Economics.',
                'level' => 'advanced',
                'thumbnail' => 'course-thumbnails/01M18G1RY0J106PPD2KX2B0BF5.jpg',
                'syllabus_pdf' => 'courses/syllabus/01M1GVG10VDPVBNQMDA2YDK6RB.pdf',
                'is_published' => true,
            ]
        );

        $this->cleanCourseContent($course);

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Banking Laws, BAFIA & Regulatory Framework',
            'slug' => 'nrb-ad-banking-laws-' . $course->id,
            'description' => 'Bank and Financial Institutions Act 2073, NRB Directives, Basel III, AML/CFT.',
            'key_points' => "• BAFIA 2073: Licencing, Capital Requirements, Governance\n• Basel Framework: Capital Adequacy Ratio (CAR), Tier 1 & Tier 2 Capital\n• AML/CFT Act 2064 & Financial Intelligence Unit (FIU)",
            'notes' => 'Comprehensive regulatory notes for NRB Assistant Director.',
            'pdf_file' => 'courses/syllabus/01M1GVG10VDPVBNQMDA2YDK6RB.pdf',
            'order' => 1,
            'is_published' => true,
        ]);

        $c1 = Chapter::create([
            'module_id' => $m1->id,
            'title' => 'Regulatory & Prudential Norms',
            'slug' => 'nrb-ad-prudential-norms-' . $m1->id,
            'order' => 1,
            'is_published' => true,
        ]);

        $this->createFullLesson(
            module: $m1,
            chapter: $c1,
            title: 'Bank and Financial Institutions Act (BAFIA 2073)',
            slug: 'bafia-2073-prudential-framework',
            type: 'text',
            order: 1,
            duration: 25,
            content: '<h3>बैंक तथा वित्तीय संस्था सम्बन्धी ऐन, २०७३ (BAFIA)</h3><p>नेपालमा बैंक तथा वित्तीय संस्थाहरूलाई क, ख, ग, घ वर्गमा वर्गीकरण गरी नियमन गर्ने मूल कानुन बाफिया २०७३ हो।</p>',
            attachmentPath: 'lessons/pdfs/01M1HS96P6GK6BF34EKRS1KZ3T.pdf',
            quizzes: [
                ['question' => 'बैंक तथा वित्तीय संस्था सम्बन्धी ऐन, २०७३ अनुसार वाणिज्य बैंकहरू कुन वर्गमा पर्दछन्?', 'options' => ['"क" वर्ग ("A" Class)', '"ख" वर्ग', '"ग" वर्ग', '"घ" वर्ग'], 'answer' => 0, 'hint' => 'वाणिज्य बैंक।', 'explanation' => 'वाणिज्य बैंकहरू "क" वर्गका वित्तीय संस्था हुन्।'],
            ]
        );
    }

    /**
     * 6. CONSTITUTION AND LAW
     */
    private function seedConstitutionAndLaw(): void
    {
        $course = Course::updateOrCreate(
            ['slug' => 'nepal-constitution-ra-kanun'],
            [
                'title' => 'Nepal Constitution ra Kanun',
                'description' => 'Cross-cutting course covering the Constitution of Nepal 2072, Good Governance Act 2064, Right to Information Act, and administrative jurisprudence.',
                'level' => 'intermediate',
                'thumbnail' => 'course-thumbnails/nepal-constitution.jpg',
                'syllabus_pdf' => 'courses/syllabus/Kharidar Syllabus.pdf',
                'is_published' => true,
            ]
        );

        $this->cleanCourseContent($course);

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Nepal ko Samvidhan 2072 (Constitution of Nepal)',
            'slug' => 'constitution-of-nepal-2072-' . $course->id,
            'description' => 'Preamble, Fundamental Rights, Directive Principles, Constitutional Organs, Federal Structure.',
            'key_points' => "• 35 Parts, 308 Articles, 9 Schedules\n• Fundamental Rights: Articles 16 to 46 (31 Rights)\n• Schedules 5, 6, 7, 8, 9: Exclusive & Concurrent powers",
            'notes' => 'Complete article-wise breakdown and analysis of the Constitution of Nepal 2072.',
            'pdf_file' => 'lessons/pdfs/nea-level-4-21-fundamental-features-of-the-constitution-of-nepal-notes.pdf',
            'order' => 1,
            'is_published' => true,
        ]);

        $c1 = Chapter::create([
            'module_id' => $m1->id,
            'title' => 'Fundamental Rights & Constitutional Organs',
            'slug' => 'constitution-rights-organs-' . $m1->id,
            'order' => 1,
            'is_published' => true,
        ]);

        $this->createFullLesson(
            module: $m1,
            chapter: $c1,
            title: 'Fundamental Rights under Part 3 (Articles 16-46)',
            slug: 'fundamental-rights-part-3-articles-16-46',
            type: 'text',
            order: 1,
            duration: 25,
            content: '<h3>नेपालको संविधान २०७२: मौलिक हकहरू</h3><p>भाग ३ मा धारा १६ देखि ४६ सम्म ३१ वटा मौलिक हकहरूको व्यवस्था गरिएको छ। धारा ४६ मा संवैधानिक उपचारको हक छ। धारा ४७ अनुसार मौलिक हक कार्यान्वयनका लागि ३ वर्षभित्र कानुन बनाउने व्यवस्था थियो।</p>',
            attachmentPath: 'lessons/pdfs/nea-level-4-23-fundamental-rights-and-duties-part-3-articles-16-48-notes.pdf',
            quizzes: [
                ['question' => 'नेपालको संविधान २०७२ को भाग ३ मा कतिवटा मौलिक हकको व्यवस्था छ?', 'options' => ['३१ वटा (धारा १६ देखि ४६)', '२१ वटा', '२५ वटा', '३५ वटा'], 'answer' => 0, 'hint' => 'धारा १६ देखि ४६ सम्म।', 'explanation' => 'संविधानको भाग ३ मा ३१ वटा मौलिक हकहरू व्यवस्था गरिएका छन्।'],
            ]
        );
    }

    /**
     * 7. COMPUTER SKILL PARIKSHA
     */
    private function seedComputerSkill(): void
    {
        $course = Course::updateOrCreate(
            ['slug' => 'computer-sip-pariksha'],
            [
                'title' => 'Computer Sip Pariksha',
                'description' => 'Practical computer skill test preparation covering MS Word, MS Excel, MS PowerPoint, Nepali Unicode typing, and Internet/Email.',
                'level' => 'beginner',
                'thumbnail' => 'course-thumbnails/01M18G9505CSZHDENPZ0SNJNWA.jpeg',
                'syllabus_pdf' => 'courses/syllabus/Kharidar Syllabus.pdf',
                'is_published' => true,
            ]
        );

        $this->cleanCourseContent($course);

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'MS Office Applications & Practical Skills',
            'slug' => 'comp-ms-office-' . $course->id,
            'description' => 'Word Processing, Spreadsheets, Presentation slides, Table formatting.',
            'key_points' => "• MS Word: Formatting, Page layout, Mail merge, Tables\n• MS Excel: Formulas (SUM, AVERAGE, IF, VLOOKUP), Data filtering\n• Nepali Unicode Typing: Traditional & Romanized layouts",
            'notes' => 'Computer skill test practical guidelines and shortcuts.',
            'pdf_file' => 'lessons/pdfs/computer-sip-pariksha-ms-word-excel-office-productivity-mastery-notes.pdf',
            'order' => 1,
            'is_published' => true,
        ]);

        $c1 = Chapter::create([
            'module_id' => $m1->id,
            'title' => 'Word & Excel Practical Skills',
            'slug' => 'word-excel-practical-' . $m1->id,
            'order' => 1,
            'is_published' => true,
        ]);

        $this->createFullLesson(
            module: $m1,
            chapter: $c1,
            title: 'MS Word and Excel Mastery for Loksewa',
            slug: 'ms-word-excel-mastery-loksewa',
            type: 'text',
            order: 1,
            duration: 20,
            content: '<h3>कम्प्युटर सीप परीक्षण (Computer Skill Test)</h3><p>लोकसेवाको अन्तिम चरणमा लिइने कम्प्युटर प्रयोगात्मक परीक्षामा MS Word, Excel, PowerPoint, Web/Email र नेपाली युनिकोड टाइप परीक्षण गरिन्छ।</p>',
            attachmentPath: 'lessons/pdfs/computer-sip-pariksha-ms-word-excel-office-productivity-mastery-notes.pdf',
            quizzes: [
                ['question' => 'MS Word मा कागजात सुरक्षित (Save) गर्ने सर्टकट की कुन हो?', 'options' => ['Ctrl + S', 'Ctrl + C', 'Ctrl + V', 'Ctrl + P'], 'answer' => 0, 'hint' => 'Save सर्टकट।', 'explanation' => 'Ctrl + S ले कागजात सेभ गर्दछ।'],
            ]
        );
    }

    /**
     * 8. IQ & APTITUDE
     */
    private function seedIqAptitude(): void
    {
        $course = Course::updateOrCreate(
            ['slug' => 'baudhik-parikshan-iq-aptitude'],
            [
                'title' => 'Baudhik Parikshan (IQ & Aptitude)',
                'description' => 'Comprehensive IQ and aptitude preparation covering Verbal, Numerical, Logical, Spatial, and Non-Verbal reasoning.',
                'level' => 'beginner',
                'thumbnail' => 'course-thumbnails/iq-aptitude.jpg',
                'syllabus_pdf' => 'courses/syllabus/Kharidar Syllabus.pdf',
                'is_published' => true,
            ]
        );

        $this->cleanCourseContent($course);

        $m1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Verbal & Logical Reasoning Masterclass',
            'slug' => 'iq-verbal-logical-' . $course->id,
            'description' => 'Analogies, Syllogisms, Blood Relations, Direction Sense, Coding-Decoding.',
            'key_points' => "• Step-by-step logic\n• Fast mental shortcuts\n• Practice patterns with instant hints",
            'notes' => 'Master guide to Loksewa IQ questions.',
            'pdf_file' => 'lessons/pdfs/01M1GH7TVYCSV16WJZXKJTD51J.pdf',
            'order' => 1,
            'is_published' => true,
        ]);

        $c1 = Chapter::create([
            'module_id' => $m1->id,
            'title' => 'Reasoning Fundamentals',
            'slug' => 'iq-reasoning-fundamentals-' . $m1->id,
            'order' => 1,
            'is_published' => true,
        ]);

        $this->createFullLesson(
            module: $m1,
            chapter: $c1,
            title: 'Verbal Reasoning & Logical Problem Solving',
            slug: 'verbal-reasoning-logical-problem-solving-iq',
            type: 'text',
            order: 1,
            duration: 20,
            content: '<h3>बौद्धिक परीक्षण (IQ Test) प्रविधिहरू</h3><p>शाब्दिक, संख्यात्मक र अशाब्दिक समस्या समाधानका विधिहरू र सर्टकट सूत्रहरू।</p>',
            attachmentPath: 'lessons/pdfs/01M1GH7TVYCSV16WJZXKJTD51J.pdf',
            quizzes: [
                ['question' => 'शृङ्खला पूरा गर्नुहोस्: ४, ९, १६, २५, ?', 'options' => ['३६', '३०', '४९', '३२'], 'answer' => 0, 'hint' => '६ को वर्ग।', 'explanation' => 'क्रमिक संख्याहरूको वर्ग: ६^२ = ३६।'],
            ]
        );
    }

    /**
     * 9. NEA LEVEL 4
     */
    private function seedNeaLevel4(): void
    {
        $seeder = new NeaLevel4CourseSeeder();
        $course = $seeder->createNeaCourse();
        NeaQuizBank::attachQuestionsToAllLessons($course);
    }

    /**
     * Helper to create full lesson with proper linkage, content, PDF, and quizzes.
     */
    private function createFullLesson(
        Module $module,
        Chapter $chapter,
        string $title,
        string $slug,
        string $type,
        int $order,
        int $duration,
        string $content,
        ?string $attachmentPath,
        array $quizzes
    ): Lesson {
        return Lesson::updateOrCreate(
            ['slug' => $slug],
            [
                'module_id' => $module->id,
                'chapter_id' => $chapter->id,
                'title' => $title,
                'type' => $type,
                'order' => $order,
                'duration_minutes' => $duration,
                'content' => $content,
                'attachment_path' => $attachmentPath,
                'quiz_questions' => $quizzes,
                'is_published' => true,
            ]
        );
    }

    /**
     * Clean existing modules and chapters for fresh syllabus seeding.
     */
    private function cleanCourseContent(Course $course): void
    {
        foreach ($course->modules as $mod) {
            foreach ($mod->chapters as $chap) {
                $chap->lessons()->delete();
                $chap->delete();
            }
            $mod->lessons()->delete();
            $mod->delete();
        }
    }
}
