<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            ['name' => 'view-settings'],
            ['name' => 'create-settings'],
            ['name' => 'update-settings'],
            ['name' => 'delete-settings'],
        ])->each(fn($permission) => Permission::create($permission)->syncRoles(['Administrators']));

        Settings::create([
            'name' => 'Wakaf Mandiri',
            'address' => 'Jl. Raya Sarirogo No.1, Sari Rogo, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur',
            'phone' => '081-24972-6800',
            'email' => 'wakaf@yatimmandiri.org',
            'handphone' => '081-24972-6800',
            'facebook' => 'https://www.facebook.com/wakafmandiri',
            'instagram' => 'https://www.instagram.com/wakafmandiriorg',
            'youtube' => 'https://www.youtube.com/channel/UCXA3KPl8gQ7vCfswi1JKoPw',
            'description' => 'WAKAF MANDIRI adalah lembaga wakaf nasional yang berkhidmat meningkatkan kesejahteraan masyarakat, khususnya yatim dan dhuafa, dengan menggalang dan mengelola sumberdaya wakaf secara produktif, profesional dan amanah.',
        ]);
    }
}
