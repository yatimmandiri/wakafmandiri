<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuFront;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuFrontSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // collect([
        //     [
        //         'name' => 'Menu Front',
        //         'link' => '/menus-front',
        //         'icon' => 'fas fa-chevron-right nav-icons',
        //         'parent' => 2,
        //         'order' => 1
        //     ]
        // ])->each(fn($menu) => Menu::create($menu)->roles()->sync(1));

        // collect([
        //     [
        //         'name' => 'Home',
        //         'link' => '#',
        //         'icon' => 'fas fa-tachometer-alt nav-icons',
        //         'parent' => 0,
        //         'order' => 1
        //     ],
        //     [
        //         'name' => 'Tentang Kami',
        //         'link' => '#',
        //         'icon' => 'fab fa-codepen nav-icons',
        //         'parent' => 0,
        //         'order' => 2
        //     ],
        //     [
        //         'name' => 'Program',
        //         'link' => '#',
        //         'icon' => 'fas fa-chevron-right nav-icons',
        //         'parent' => 0,
        //         'order' => 3
        //     ],
        //     [
        //         'name' => 'Berita',
        //         'link' => '#',
        //         'icon' => 'fas fa-chevron-right nav-icons',
        //         'parent' => 0,
        //         'order' => 4
        //     ],
        //     [
        //         'name' => 'Literasi',
        //         'link' => '#',
        //         'icon' => 'fas fa-chevron-right nav-icons',
        //         'parent' => 0,
        //         'order' => 5
        //     ],
        //     [
        //         'name' => 'E-Magazine',
        //         'link' => '#',
        //         'icon' => 'fas fa-chevron-right nav-icons',
        //         'parent' => 0,
        //         'order' => 6
        //     ],
        // ])->each(fn($menu) => MenuFront::create($menu));
    }
}
