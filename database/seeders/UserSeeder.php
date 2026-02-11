<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Indonesian first names & last names for realistic data generation
     */
    private array $firstNames = [
        'Adi', 'Agus', 'Ahmad', 'Aisyah', 'Aldi', 'Alifah', 'Amelia', 'Andi', 'Andika', 'Angga',
        'Anisa', 'Arif', 'Ayu', 'Bagus', 'Bayu', 'Bima', 'Bunga', 'Cahya', 'Candra', 'Citra',
        'Dani', 'Dea', 'Dedi', 'Deni', 'Dewi', 'Dian', 'Dika', 'Dimas', 'Dina', 'Dwi',
        'Eka', 'Elsa', 'Endang', 'Erna', 'Fadhil', 'Fajar', 'Fani', 'Farhan', 'Fatimah', 'Fauzan',
        'Fikri', 'Fitri', 'Galih', 'Gani', 'Gilang', 'Gunawan', 'Hadi', 'Hafiz', 'Hana', 'Hendra',
        'Heni', 'Heru', 'Icha', 'Ilham', 'Imam', 'Indah', 'Indra', 'Intan', 'Irfan', 'Irma',
        'Jaka', 'Jasmine', 'Johan', 'Joko', 'Juli', 'Karina', 'Kevin', 'Kurnia', 'Laila', 'Lestari',
        'Lina', 'Lukman', 'Luthfi', 'Mada', 'Mahesa', 'Malik', 'Maulana', 'Maya', 'Mega', 'Mila',
        'Mira', 'Muhammad', 'Mulia', 'Nadia', 'Nanda', 'Naomi', 'Naufal', 'Nia', 'Nisa', 'Nova',
        'Novi', 'Nugroho', 'Nur', 'Okta', 'Pandu', 'Prima', 'Putra', 'Putri', 'Rafi', 'Rahma',
        'Rani', 'Rara', 'Ratna', 'Rendi', 'Resa', 'Reza', 'Ridho', 'Rika', 'Rina', 'Rizki',
        'Rizky', 'Rosa', 'Rosalina', 'Sari', 'Sela', 'Sinta', 'Siti', 'Sri', 'Surya', 'Suci',
        'Taufik', 'Teguh', 'Tiara', 'Tika', 'Tri', 'Umi', 'Vina', 'Wahyu', 'Wati', 'Wawan',
        'Widya', 'Wulan', 'Yani', 'Yoga', 'Yuda', 'Yuli', 'Yusuf', 'Zahra', 'Zaki', 'Zulfa',
        'Alya', 'Arya', 'Budi', 'Chandra', 'Danu', 'Eka', 'Farida', 'Gita', 'Hasan', 'Iqbal',
    ];

    private array $lastNames = [
        'Pratama', 'Saputra', 'Wijaya', 'Kusuma', 'Hidayat', 'Permana', 'Nugraha', 'Santoso', 'Setiawan', 'Wibowo',
        'Siregar', 'Nasution', 'Harahap', 'Lubis', 'Panggabean', 'Sitorus', 'Simanjuntak', 'Hutapea', 'Simbolon', 'Manurung',
        'Prasetyo', 'Susanto', 'Suryadi', 'Purnama', 'Ramadhan', 'Firmansyah', 'Kurniawan', 'Hartono', 'Suharto', 'Wicaksono',
        'Putra', 'Putri', 'Ramadhani', 'Handayani', 'Lestari', 'Utami', 'Puspitasari', 'Anggraeni', 'Sulistyo', 'Wulandari',
        'Adriansyah', 'Budiman', 'Cahyadi', 'Darmawan', 'Effendi', 'Firdaus', 'Gunawan', 'Hakim', 'Ibrahim', 'Januardi',
        'Kuswanto', 'Laksmana', 'Maulana', 'Nurhadi', 'Oktavian', 'Pranata', 'Rachman', 'Saputro', 'Tampubolon', 'Utomo',
        'Wahyudi', 'Yusanto', 'Zainal', 'Abdillah', 'Basuki', 'Christianto', 'Damanik', 'Fadilah', 'Ginting', 'Hermawan',
        'Iskandar', 'Junaidi', 'Kartika', 'Lesmana', 'Mahendra', 'Nainggolan', 'Pangestu', 'Raharjo', 'Saragih', 'Tarigan',
        'Aritonang', 'Batubara', 'Dalimunthe', 'Hutabarat', 'Marpaung', 'Pardede', 'Purba', 'Sagala', 'Siahaan', 'Sinaga',
        'Situmorang', 'Tambunan', 'Tobing', 'Arianto', 'Dwiputra', 'Febriano', 'Indraswara', 'Mahardika', 'Pamungkas', 'Waskito',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hashedPassword = Hash::make('password');
        $usedEmails = [];

        $this->command->info('Seeding 500 membership users...');
        $membershipData = $this->generateUsers(500, 'membership', $hashedPassword, $usedEmails);
        User::insert($membershipData);
        $this->command->info('✓ 500 membership users created.');

        $this->command->info('Seeding 500 reguler users...');
        $regulerData = $this->generateUsers(500, 'reguler', $hashedPassword, $usedEmails);
        User::insert($regulerData);
        $this->command->info('✓ 500 reguler users created.');

        $this->command->info('Total: 1000 users seeded successfully!');
    }

    /**
     * Generate user data array
     */
    private function generateUsers(int $count, string $role, string $hashedPassword, array &$usedEmails): array
    {
        $users = [];
        $now = now()->toDateTimeString();

        for ($i = 0; $i < $count; $i++) {
            $firstName = $this->firstNames[array_rand($this->firstNames)];
            $lastName = $this->lastNames[array_rand($this->lastNames)];
            $fullName = $firstName . ' ' . $lastName;

            // Generate unique email: namalengkap + random number @gmail.com
            do {
                $randomNum = rand(100, 99999);
                $emailBase = strtolower(str_replace(' ', '', $fullName));
                $email = $emailBase . $randomNum . '@gmail.com';
            } while (in_array($email, $usedEmails));

            $usedEmails[] = $email;

            $users[] = [
                'name' => $fullName,
                'email' => $email,
                'email_verified_at' => $now,
                'password' => $hashedPassword,
                'role' => $role,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return $users;
    }
}
