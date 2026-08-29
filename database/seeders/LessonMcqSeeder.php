<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonMcqSeeder extends Seeder
{
    public function run(): void
    {
        $created = 0;
        $updated = 0;

        foreach ($this->questionSets() as $lessonSlug => $questions) {
            $lesson = Lesson::where('slug', $lessonSlug)
                ->where('type', '!=', 'quiz')
                ->with('chapter.lessons')
                ->first();

            if (! $lesson) {
                continue;
            }

            $quiz = Lesson::firstOrNew(['slug' => 'mcq-'.$lesson->slug]);
            $isNew = ! $quiz->exists;

            $quiz->fill([
                'chapter_id' => $lesson->chapter_id,
                'title' => 'MCQ Practice: '.$lesson->title,
                'type' => 'quiz',
                'content' => json_encode($questions, JSON_UNESCAPED_UNICODE),
                'order' => $isNew ? $lesson->chapter->lessons()->max('order') + 1 : $quiz->order,
                'is_published' => true,
            ]);
            $quiz->save();

            $isNew ? $created++ : $updated++;
        }

        $this->command?->info("Lesson MCQs seeded: {$created} created, {$updated} updated.");
    }

    private function questionSets(): array
    {
        return [
            'physical-geography-of-nepal' => [
                [
                    'question' => 'Which statement best describes Nepal’s location?',
                    'options' => ['An island country in South Asia', 'A landlocked country between China and India', 'A coastal state on the Bay of Bengal', 'A plateau country east of Bhutan'],
                    'answer' => 1,
                    'explanation' => 'Nepal is a landlocked South Asian country with China to the north and India to the south, east, and west.',
                ],
                [
                    'question' => 'Which ecological region of Nepal lies along the southern plains?',
                    'options' => ['Himalayan region', 'Mid-hill region', 'Tarai region', 'Trans-Himalayan region'],
                    'answer' => 2,
                    'explanation' => 'The Tarai is the low, flat southern belt of Nepal.',
                ],
                [
                    'question' => 'Which river is listed among Nepal’s perennial Himalayan-origin rivers?',
                    'options' => ['Koshi', 'Bagmati only', 'Kamala only', 'Kankai only'],
                    'answer' => 0,
                    'explanation' => 'Koshi is one of Nepal’s major perennial rivers that drains southward from the Himalayan system.',
                ],
                [
                    'question' => 'What is the jointly announced latest height of Mount Everest?',
                    'options' => ['8,848.00 m', '8,848.86 m', '8,850.00 m', '8,586.00 m'],
                    'answer' => 1,
                    'explanation' => 'Nepal and China jointly announced Mount Everest’s height as 8,848.86 meters in 2020.',
                ],
                [
                    'question' => 'Which pair of valleys is commonly associated with Nepal’s mid-hill region?',
                    'options' => ['Kathmandu and Pokhara', 'Biratnagar and Janakpur', 'Kechana and Kakarbhitta', 'Mustang and Dolpo only'],
                    'answer' => 0,
                    'explanation' => 'Kathmandu and Pokhara valleys lie in the mid-hill region north of the Mahabharat range.',
                ],
            ],
            'official-nayab-subba-syllabus-pdf' => [
                [
                    'question' => 'What should a candidate do first after receiving the Nayab Subba syllabus?',
                    'options' => ['Memorize only current affairs', 'Map topics by paper and marks weight', 'Skip objective sections', 'Read only model answers'],
                    'answer' => 1,
                    'explanation' => 'A syllabus is most useful when topics are mapped by paper, marks, and priority before study begins.',
                ],
                [
                    'question' => 'Which section is commonly tested in the first-paper objective preparation?',
                    'options' => ['General Knowledge and IQ', 'Interview dress code only', 'Only accounting vouchers', 'Only foreign policy essays'],
                    'answer' => 0,
                    'explanation' => 'Nayab Subba first-paper preparation commonly includes GK and IQ/objective aptitude topics.',
                ],
                [
                    'question' => 'Why should candidates print or save the official syllabus?',
                    'options' => ['To replace all textbooks', 'To track coverage and avoid off-syllabus study', 'To avoid practice questions', 'To skip revision'],
                    'answer' => 1,
                    'explanation' => 'The official syllabus keeps preparation aligned with examinable areas.',
                ],
                [
                    'question' => 'Which study habit best supports syllabus-based preparation?',
                    'options' => ['Random reading without notes', 'Topic checklist with repeated revision', 'Studying only one subject', 'Avoiding past patterns'],
                    'answer' => 1,
                    'explanation' => 'A checklist plus scheduled revision helps ensure each syllabus topic is covered.',
                ],
                [
                    'question' => 'What is the main purpose of a syllabus PDF in this LMS?',
                    'options' => ['Entertainment reading', 'Course planning and preparation tracking', 'Replacing login credentials', 'Changing course prerequisites'],
                    'answer' => 1,
                    'explanation' => 'The syllabus PDF supports course planning and helps students track exam preparation scope.',
                ],
            ],
            'verbal-analogy-and-series-methods' => [
                [
                    'question' => 'Find the next term: C, F, I, L, ?',
                    'options' => ['M', 'N', 'O', 'P'],
                    'answer' => 2,
                    'explanation' => 'The sequence increases by three letters each time: C, F, I, L, O.',
                ],
                [
                    'question' => 'If A = 1 and Z = 26, what is the reverse-position value of B?',
                    'options' => ['2', '24', '25', '26'],
                    'answer' => 2,
                    'explanation' => 'In reverse alphabet position, Z = 1, Y = 2, and B = 25.',
                ],
                [
                    'question' => 'Complete the analogy: Book : Reading :: Pen : ?',
                    'options' => ['Writing', 'Running', 'Cooking', 'Measuring'],
                    'answer' => 0,
                    'explanation' => 'A book is used for reading; a pen is used for writing.',
                ],
                [
                    'question' => 'If CAT is coded as DBU, which rule is used?',
                    'options' => ['Each letter moves one step forward', 'Each letter moves one step backward', 'Letters are reversed', 'Only vowels change'],
                    'answer' => 0,
                    'explanation' => 'C->D, A->B, and T->U, so every letter advances by one position.',
                ],
                [
                    'question' => 'Which pattern is most likely in A, E, I, O, ?',
                    'options' => ['Consonants', 'Prime numbers', 'English vowels', 'Months'],
                    'answer' => 2,
                    'explanation' => 'A, E, I, O, U are the common English vowels.',
                ],
            ],
            'objectives-and-functions-of-nrb' => [
                [
                    'question' => 'Which law defines the objectives and functions of Nepal Rastra Bank?',
                    'options' => ['Companies Act', 'Nepal Rastra Bank Act, 2058', 'Civil Service Act', 'Public Procurement Act'],
                    'answer' => 1,
                    'explanation' => 'The Nepal Rastra Bank Act, 2058 establishes NRB and states its objectives and functions.',
                ],
                [
                    'question' => 'Which section of the NRB Act states the objectives of the Bank?',
                    'options' => ['Section 2', 'Section 4', 'Section 8', 'Section 12'],
                    'answer' => 1,
                    'explanation' => 'Section 4 lists the objectives of Nepal Rastra Bank.',
                ],
                [
                    'question' => 'Which objective is directly related to monetary and foreign exchange policy?',
                    'options' => ['Maintaining price and balance of payment stability', 'Constructing highways', 'Managing schools', 'Issuing citizenship certificates'],
                    'answer' => 0,
                    'explanation' => 'NRB formulates monetary and foreign exchange policies to support price and balance of payment stability.',
                ],
                [
                    'question' => 'Which system is NRB expected to help develop securely and efficiently?',
                    'options' => ['Payment system', 'Road transport system', 'Postal stamp system', 'Land registration system'],
                    'answer' => 0,
                    'explanation' => 'Developing a secure, healthy, and efficient payment system is one objective of NRB.',
                ],
                [
                    'question' => 'In Nepal’s financial sector, NRB primarily acts as which type of institution?',
                    'options' => ['Central bank and regulator', 'Commercial retailer', 'Municipality', 'Insurance broker only'],
                    'answer' => 0,
                    'explanation' => 'NRB is Nepal’s central bank and regulates, supervises, and supports the banking and monetary system.',
                ],
            ],
            'double-entry-system-and-bank-ledgers' => [
                [
                    'question' => 'What is the core rule of the double-entry system?',
                    'options' => ['Only cash transactions are recorded', 'Every transaction has equal debit and credit effects', 'Assets are never recorded', 'Only profit is recorded'],
                    'answer' => 1,
                    'explanation' => 'Double-entry accounting records every transaction with equal debit and credit effects.',
                ],
                [
                    'question' => 'For a bank, customer deposits are usually classified as:',
                    'options' => ['Assets', 'Liabilities', 'Owner drawings', 'Fixed expenses only'],
                    'answer' => 1,
                    'explanation' => 'Customer deposits are liabilities because the bank owes that money to depositors.',
                ],
                [
                    'question' => 'Loans advanced by a bank are generally recorded as:',
                    'options' => ['Assets', 'Liabilities', 'Capital losses', 'Suspense only'],
                    'answer' => 0,
                    'explanation' => 'Loans are assets for a bank because borrowers owe repayment and interest to the bank.',
                ],
                [
                    'question' => 'Which book records account-wise classified transactions?',
                    'options' => ['Ledger', 'Attendance sheet', 'Dispatch register only', 'Minute book only'],
                    'answer' => 0,
                    'explanation' => 'A ledger classifies transactions under their respective accounts.',
                ],
                [
                    'question' => 'Why is equal debit-credit recording important?',
                    'options' => ['It helps detect arithmetic imbalance', 'It removes the need for documents', 'It hides liabilities', 'It prevents audits'],
                    'answer' => 0,
                    'explanation' => 'If debits and credits do not match, it signals an error that needs review.',
                ],
            ],
            'new-public-management-npm-concepts' => [
                [
                    'question' => 'What does New Public Management emphasize most?',
                    'options' => ['Citizen focus, efficiency, and results', 'More paperwork only', 'No performance measurement', 'Abolition of public services'],
                    'answer' => 0,
                    'explanation' => 'NPM emphasizes performance, efficiency, service quality, and citizen/customer orientation.',
                ],
                [
                    'question' => 'Which practice best reflects NPM?',
                    'options' => ['Performance targets for service units', 'No delegation of authority', 'Ignoring service users', 'Only seniority-based decisions'],
                    'answer' => 0,
                    'explanation' => 'Performance targets and measurable results are typical NPM tools.',
                ],
                [
                    'question' => 'Which term is closest to the NPM view of citizens receiving services?',
                    'options' => ['Customers or service users', 'Subjects without rights', 'Internal files only', 'Suppliers only'],
                    'answer' => 0,
                    'explanation' => 'NPM often treats citizens as service users whose satisfaction and outcomes matter.',
                ],
                [
                    'question' => 'Which feature is commonly linked with NPM reforms?',
                    'options' => ['Decentralization of authority', 'Centralizing every minor decision', 'Removing accountability', 'Ending budgeting'],
                    'answer' => 0,
                    'explanation' => 'NPM supports delegation and decentralization to improve responsiveness and performance.',
                ],
                [
                    'question' => 'What is a likely risk if NPM is applied without public accountability?',
                    'options' => ['Equity and public-interest goals may be weakened', 'All corruption automatically ends', 'Laws become unnecessary', 'Citizens stop needing services'],
                    'answer' => 0,
                    'explanation' => 'Efficiency-focused reforms must still protect equity, accountability, and public interest.',
                ],
            ],
            'office-filing-techniques' => [
                [
                    'question' => 'What is the main purpose of office filing?',
                    'options' => ['Systematic storage and easy retrieval of records', 'Destroying all records immediately', 'Avoiding registration', 'Replacing official correspondence'],
                    'answer' => 0,
                    'explanation' => 'Filing arranges records systematically so they can be found and used when needed.',
                ],
                [
                    'question' => 'Which activity supports tracking incoming and outgoing letters?',
                    'options' => ['Registration and dispatch', 'Budget speech', 'Leave approval only', 'Furniture repair'],
                    'answer' => 0,
                    'explanation' => 'Registration and dispatch help track official correspondence movement.',
                ],
                [
                    'question' => 'What does indexing help with in record management?',
                    'options' => ['Finding files quickly by reference', 'Increasing file weight', 'Deleting subject headings', 'Avoiding classification'],
                    'answer' => 0,
                    'explanation' => 'Indexing provides references that make files and records easier to locate.',
                ],
                [
                    'question' => 'Which is a good quality of an office filing system?',
                    'options' => ['Simple, secure, and expandable', 'Secret from all authorized staff', 'Randomly arranged', 'Dependent on memory only'],
                    'answer' => 0,
                    'explanation' => 'A useful filing system should be simple, secure, economical, and able to grow with records.',
                ],
                [
                    'question' => 'Why are modern record systems useful in public offices?',
                    'options' => ['They improve storage, search, backup, and accountability', 'They remove all legal duties', 'They make indexing impossible', 'They prevent transparency'],
                    'answer' => 0,
                    'explanation' => 'Modern record systems help offices manage records efficiently while supporting accountability and retrieval.',
                ],
            ],
        ];
    }
}
