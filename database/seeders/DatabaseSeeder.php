<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Dentist;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Account
        $admin = User::firstOrCreate(
            ['email' => 'admin@dental.com'],
            [
                'name' => 'Dr. Clinic Director',
                'phone' => '09170000001',
                'role' => 'admin',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Dentists
        $dentist1User = User::firstOrCreate(
            ['email' => 'sarah@dental.com'],
            [
                'name' => 'Sarah Jenkins',
                'phone' => '09170000002',
                'role' => 'dentist',
                'password' => Hash::make('password123'),
            ]
        );
        $dentist1 = Dentist::firstOrCreate(
            ['user_id' => $dentist1User->id],
            ['specialization' => 'Orthodontics & Braces']
        );

        $dentist2User = User::firstOrCreate(
            ['email' => 'mark@dental.com'],
            [
                'name' => 'Mark Villanueva',
                'phone' => '09170000003',
                'role' => 'dentist',
                'password' => Hash::make('password123'),
            ]
        );
        $dentist2 = Dentist::firstOrCreate(
            ['user_id' => $dentist2User->id],
            ['specialization' => 'General Dentistry & Surgery']
        );

        $dentist3User = User::firstOrCreate(
            ['email' => 'alicia@dental.com'],
            [
                'name' => 'Alicia Tan',
                'phone' => '09170000004',
                'role' => 'dentist',
                'password' => Hash::make('password123'),
            ]
        );
        $dentist3 = Dentist::firstOrCreate(
            ['user_id' => $dentist3User->id],
            ['specialization' => 'Pediatric & Cosmetic Dentistry']
        );

        // 3. Dental Services
        $servicesData = [
            [
                'name' => 'Routine Dental Cleaning (Prophylaxis)',
                'description' => 'Professional scaling and polishing to remove plaque, tartar, and surface stains for optimal oral health.',
                'price' => 1200.00,
                'duration_minutes' => 45,
                'is_active' => true,
            ],
            [
                'name' => 'Tooth Extraction',
                'description' => 'Safe and gentle removal of problematic, severely decayed, or impacted teeth.',
                'price' => 1500.00,
                'duration_minutes' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Tooth Restoration / Dental Filling',
                'description' => 'Composite tooth-colored resin filling to restore chipped or decayed teeth with a natural finish.',
                'price' => 1800.00,
                'duration_minutes' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Braces Consultation & Adjustment',
                'description' => 'Comprehensive orthodontic evaluation, wire tightening, and alignment adjustment.',
                'price' => 2000.00,
                'duration_minutes' => 45,
                'is_active' => true,
            ],
            [
                'name' => 'Teeth Whitening Procedure',
                'description' => 'Advanced in-clinic laser teeth whitening for an instantly brighter, radiant smile.',
                'price' => 4500.00,
                'duration_minutes' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Root Canal Therapy',
                'description' => 'Specialized endodontic procedure to treat infected tooth pulp and save the natural tooth.',
                'price' => 6500.00,
                'duration_minutes' => 90,
                'is_active' => true,
            ],
        ];

        foreach ($servicesData as $data) {
            Service::firstOrCreate(['name' => $data['name']], $data);
        }

        // 4. Sample Patient and Bookings
        $patient = User::firstOrCreate(
            ['email' => 'art546321@gmail.com'],
            [
                'name' => 'Art Dela Cruz',
                'phone' => '09171234567',
                'role' => 'patient',
                'password' => Hash::make('password123'),
            ]
        );

        $firstService = Service::first();

        Appointment::firstOrCreate(
            [
                'patient_id' => $patient->id,
                'scheduled_at' => Carbon::tomorrow()->setHour(10)->setMinute(0)->setSecond(0),
            ],
            [
                'dentist_id' => $dentist1->id,
                'service_id' => $firstService->id,
                'status' => 'scheduled',
                'notes' => 'Routine checkup and mild sensitivity on left side.',
            ]
        );
    }
}