<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserRolePermissionSeeder::class,
            MenuSeeder::class,
            SettingsSeeder::class,
            PartnerSeeder::class,
            SliderSeeder::class,
            PageSeeder::class,
            RekeningSeeder::class,
            NewsSeeder::class,
            ArticleSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
