<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class LoksewaUsersSeeder extends Seeder
{
    /**
     * Seeds 1 Admin and 30 realistic Nepali student users across different demographic and learning profiles.
     */
    public function run(): void
    {
        $this->command->info('👥 Seeding Nepali Student Users & Admin...');

        // Ensure roles exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // 1. Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@loksewa.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('admin123'),
                'learning_pace_multiplier' => 1.0,
            ]
        );
        $admin->syncRoles([$adminRole]);

        // 2. 30 Realistic Nepali Student Users
        $studentsData = [
            // Fresh Aspirants / Beginners (Fast & eager / baseline pace)
            ['name' => 'Aarav Sharma',         'email' => 'aarav.sharma@loksewa.test',      'pace' => 0.8],
            ['name' => 'Bikash Thapa',         'email' => 'bikash.thapa@loksewa.test',      'pace' => 1.0],
            ['name' => 'Chandani Gurung',      'email' => 'chandani.gurung@loksewa.test',   'pace' => 0.6],
            ['name' => 'Deepak Adhikari',      'email' => 'deepak.adhikari@loksewa.test',   'pace' => 1.2],
            ['name' => 'Elina Maharjan',       'email' => 'elina.maharjan@loksewa.test',    'pace' => 0.5],
            ['name' => 'Firoz Magar',          'email' => 'firoz.magar@loksewa.test',       'pace' => 1.1],
            ['name' => 'Gita Basnet',          'email' => 'gita.basnet@loksewa.test',       'pace' => 0.9],
            ['name' => 'Hari Koirala',         'email' => 'hari.koirala@loksewa.test',      'pace' => 1.4],

            // Intermediate NaSu & General Admin Track Aspirants
            ['name' => 'Isha Pandey',          'email' => 'isha.pandey@loksewa.test',       'pace' => 0.7],
            ['name' => 'Jeevan Rai',           'email' => 'jeevan.rai@loksewa.test',        'pace' => 1.0],
            ['name' => 'Kabita Shrestha',      'email' => 'kabita.shrestha@loksewa.test',   'pace' => 0.85],
            ['name' => 'Laxmi Bhatt',          'email' => 'laxmi.bhatt@loksewa.test',       'pace' => 0.75],
            ['name' => 'Manish Tamang',        'email' => 'manish.tamang@loksewa.test',     'pace' => 1.3],
            ['name' => 'Nisha Dhakal',         'email' => 'nisha.dhakal@loksewa.test',      'pace' => 0.65],
            ['name' => 'Om Prasad Poudel',     'email' => 'om.poudel@loksewa.test',         'pace' => 0.95],
            ['name' => 'Prashant KC',          'email' => 'prashant.kc@loksewa.test',       'pace' => 1.05],
            ['name' => 'Puja Bhandari',        'email' => 'puja.bhandari@loksewa.test',     'pace' => 0.8],
            ['name' => 'Ramesh Khatri',        'email' => 'ramesh.khatri@loksewa.test',     'pace' => 1.5],

            // Advanced Officer & Banking Aspirants (High velocity / fast pacers)
            ['name' => 'Sabina Lama',          'email' => 'sabina.lama@loksewa.test',       'pace' => 0.45],
            ['name' => 'Suman Ghimire',        'email' => 'suman.ghimire@loksewa.test',     'pace' => 0.55],
            ['name' => 'Tara Neupane',         'email' => 'tara.neupane@loksewa.test',      'pace' => 0.6],
            ['name' => 'Umesh Bista',          'email' => 'umesh.bista@loksewa.test',       'pace' => 0.7],
            ['name' => 'Vinod Acharya',        'email' => 'vinod.acharya@loksewa.test',     'pace' => 0.5],
            ['name' => 'Yashoda Regmi',        'email' => 'yashoda.regmi@loksewa.test',     'pace' => 0.65],
            ['name' => 'Anil Gautam',          'email' => 'anil.gautam@loksewa.test',       'pace' => 0.8],

            // Seasoned / High Progress Aspirants
            ['name' => 'Bibek Dahal',          'email' => 'bibek.dahal@loksewa.test',       'pace' => 0.4],
            ['name' => 'Charu Silwal',         'email' => 'charu.silwal@loksewa.test',      'pace' => 0.5],
            ['name' => 'Dhurba Pokhrel',       'email' => 'dhurba.pokhrel@loksewa.test',    'pace' => 0.7],
            ['name' => 'Ganesh Silwal',        'email' => 'ganesh.silwal@loksewa.test',     'pace' => 0.6],
            ['name' => 'Hira Karki',           'email' => 'hira.karki@loksewa.test',        'pace' => 0.55],
        ];

        foreach ($studentsData as $student) {
            $user = User::updateOrCreate(
                ['email' => $student['email']],
                [
                    'name' => $student['name'],
                    'password' => Hash::make('password123'),
                    'learning_pace_multiplier' => $student['pace'],
                ]
            );
            $user->syncRoles([$userRole]);
        }

        $this->command->info('   ✅ Created 1 Admin and '.count($studentsData).' Nepali students');
    }
}
