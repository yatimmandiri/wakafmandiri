<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            ['name' => 'view-menu'],
            ['name' => 'create-menu'],
            ['name' => 'update-menu'],
            ['name' => 'delete-menu'],
        ])->each(fn($permission) => Permission::create($permission)->syncRoles(['Administrators']));

        collect([
            [
                'name' => 'Dashboard',
                'link' => '/dashboard',
                'icon' => 'fas fa-tachometer-alt nav-icons',
                'parent' => 0,
                'order' => 1
            ],
            [
                'name' => 'System Core',
                'link' => '#',
                'icon' => 'fab fa-codepen nav-icons',
                'parent' => 0,
                'order' => 2
            ],
            [
                'name' => 'Permission',
                'link' => '/core/permissions',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 2,
                'order' => 3
            ],
            [
                'name' => 'Roles',
                'link' => '/core/roles',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 2,
                'order' => 4
            ],
            [
                'name' => 'Menu',
                'link' => '/core/menus',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 2,
                'order' => 5
            ],
            [
                'name' => 'Management Users',
                'link' => '/core/users',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 2,
                'order' => 6
            ],
        ])->each(fn($menu) => Menu::create($menu)->roles()->sync(1));

        collect([
            [
                'name' => 'Postingan',
                'link' => '#',
                'icon' => 'fas fa-newspaper nav-icons',
                'parent' => 0,
                'order' => 7
            ],
            [
                'name' => 'Berita',
                'link' => '/postingan/news',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 7,
                'order' => 8
            ],
            [
                'name' => 'Artikel',
                'link' => '/postingan/articles',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 7,
                'order' => 9
            ],
            [
                'name' => 'Pages',
                'link' => '/postingan/pages',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 7,
                'order' => 10
            ],
        ])->each(fn($menu) => Menu::create($menu)->roles()->sync([1, 2]));

        collect([
            [
                'name' => 'Master Data',
                'link' => '#',
                'icon' => 'fas fa-database nav-icons',
                'parent' => 0,
                'order' => 11
            ],
            [
                'name' => 'Categories',
                'link' => '/master/categories',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 11,
                'order' => 12,
            ],
            [
                'name' => 'Campaigns',
                'link' => '/master/campaigns',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 11,
                'order' => 13,
            ],
            [
                'name' => 'Rekening',
                'link' => '/master/rekenings',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 11,
                'order' => 14,
            ],
            [
                'name' => 'Slider',
                'link' => '/master/sliders',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 11,
                'order' => 15,
            ],
            [
                'name' => 'Partnership',
                'link' => '/master/partners',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 11,
                'order' => 16,
            ],
            [
                'name' => 'Transaction',
                'link' => '#',
                'icon' => 'fas fa-shopping-cart nav-icons',
                'parent' => 0,
                'order' => 17
            ],
            [
                'name' => 'Donation',
                'link' => '/transaction/donations',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 17,
                'order' => 18,
            ],
            [
                'name' => 'Report',
                'link' => '#',
                'icon' => 'fas fa-print nav-icons',
                'parent' => 0,
                'order' => 19
            ],
            [
                'name' => 'Donation',
                'link' => '/reports/donations',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 19,
                'order' => 20,
            ],
            [
                'name' => 'Data Donatur',
                'link' => '/reports/donaturs',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 19,
                'order' => 21,
            ],
        ])->each(fn($menu) => Menu::create($menu)->roles()->sync([1, 2]));

        collect([
            [
                'name' => 'Settings',
                'link' => '#',
                'icon' => 'fas fa-cogs nav-icons',
                'parent' => 0,
                'order' => 22
            ],
            [
                'name' => 'Website',
                'link' => '/settings/website',
                'icon' => 'fas fa-chevron-right nav-icons',
                'parent' => 22,
                'order' => 23
            ],
        ])->each(fn($menu) => Menu::create($menu)->roles()->sync([1, 2]));
    }
}
