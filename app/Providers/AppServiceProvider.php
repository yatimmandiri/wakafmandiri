<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Settings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Yajra\DataTables\Html\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Builder::useVite();

        View::composer('*', function ($view) {
            $menu = Menu::where('parent', 0)
                ->orderBy('order', 'asc')
                ->get();

            $data['menus'] = $menu;
            $data['pengaturan'] = Settings::find(1);

            $view->with($data);
        });
    }
}
