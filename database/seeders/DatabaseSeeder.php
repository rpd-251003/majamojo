<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Game;
use App\Models\Voucher;
use App\Models\Event;
use App\Models\SuperDeal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@majamojo.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Membership User',
            'email' => 'membership@majamojo.com',
            'password' => Hash::make('password'),
            'role' => 'membership',
        ]);

        User::create([
            'name' => 'Reguler User',
            'email' => 'reguler@majamojo.com',
            'password' => Hash::make('password'),
            'role' => 'reguler',
        ]);

        $game1 = Game::create([
            'name' => 'Mobile Legends',
            'status' => true,
        ]);

        $game2 = Game::create([
            'name' => 'PUBG Mobile',
            'status' => true,
        ]);

        $game3 = Game::create([
            'name' => 'Free Fire',
            'status' => true,
        ]);

        Voucher::create([
            'game_id' => $game1->id,
            'promo_code' => 'MLBB2024',
            'type' => 'all',
            'description' => 'Diskon 20% untuk semua user',
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'external_link' => 'https://example.com/mlbb',
            'status' => true,
        ]);

        Voucher::create([
            'game_id' => $game2->id,
            'promo_code' => 'PUBGMEM2024',
            'type' => 'membership_only',
            'description' => 'Khusus member - Diskon 30%',
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'external_link' => 'https://example.com/pubg',
            'status' => true,
        ]);

        Event::create([
            'game_id' => $game1->id,
            'title' => 'ML Anniversary Event',
            'description' => 'Perayaan anniversary Mobile Legends dengan berbagai hadiah menarik',
            'banner_image' => null,
            'start_date' => now(),
            'end_date' => now()->addDays(15),
            'external_link' => 'https://example.com/ml-event',
            'status' => true,
        ]);

        SuperDeal::create([
            'game_id' => $game3->id,
            'banner_image' => null,
            'description' => 'Special deal untuk diamond Free Fire',
            'game_name' => 'Free Fire',
            'price' => 99000,
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'external_link' => 'https://example.com/ff-deal',
            'status' => true,
        ]);
    }
}
