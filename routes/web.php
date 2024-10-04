<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Core\MenuController;
use App\Http\Controllers\Core\PermissionController;
use App\Http\Controllers\Core\RoleController;
use App\Http\Controllers\Core\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\CampaignController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\PartnerController;
use App\Http\Controllers\Master\RekeningController;
use App\Http\Controllers\Master\SliderController;
use App\Http\Controllers\Postingan\ArticleController;
use App\Http\Controllers\Postingan\NewsController;
use App\Http\Controllers\Postingan\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Settings\MootaController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Transaction\DonationController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get('tentang-kami', [WelcomeController::class, 'tentangKami'])->name('home.tentang');
Route::get('berita/{slug}', [WelcomeController::class, 'beritaBySlug'])->name('berita.show');
Route::get('berita', [WelcomeController::class, 'berita'])->name('home.berita');
Route::get('literasi/{slug}', [WelcomeController::class, 'literasiBySlug'])->name('literasi.show');
Route::get('literasi', [WelcomeController::class, 'literasi'])->name('home.literasi');
// Route::get('program/produktif/{slug}', [WelcomeController::class, 'programProduktifBySlug'])->name('home.program.produktif.show');
// Route::get('program/produktif', [WelcomeController::class, 'programProduktif'])->name('home.program.produktif');
// Route::get('program/sosial', [WelcomeController::class, 'programSosial'])->name('home.program.sosial');
Route::get('program/{slug}', [WelcomeController::class, 'programBySlug'])->name('programs.show');
Route::get('program', [WelcomeController::class, 'program'])->name('home.program');

Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'googleRedirect'])->name('google.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'googleCallback'])->name('google.callback');

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::prefix('core')->group(function () {
        Route::resource('permissions', PermissionController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::put('menus/reorder/{menu}', [MenuController::class, 'menuOrder'])->name('menus.order');
        Route::resource('menus', MenuController::class);
    });

    Route::prefix('postingan')->group(function () {
        Route::resource('articles', ArticleController::class);
        Route::resource('news', NewsController::class);
        Route::resource('pages', PageController::class);
    });

    Route::prefix('master')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('campaigns', CampaignController::class);
        Route::resource('sliders', SliderController::class);
        Route::resource('partners', PartnerController::class);

        Route::put('rekenings/recomendation/{rekening}', [RekeningController::class, 'recomendation'])->name('rekenings.recomendation');
        Route::put('rekenings/status/{rekening}', [RekeningController::class, 'status'])->name('rekenings.status');
        Route::resource('rekenings', RekeningController::class);
    });

    Route::prefix('transaction')->group(function () {
        Route::resource('donations', DonationController::class);
    });

    Route::prefix('reports')->group(function () {
        Route::get('donations', [ReportController::class, 'donations'])->name('report.donations');
        Route::get('donaturs', [ReportController::class, 'donaturs'])->name('report.donaturs');
    });

    Route::prefix('moota')->group(function () {
        Route::get('rekenings', [MootaController::class, 'rekening'])->name('moota.rekening');
    });

    Route::prefix('settings')->group(function () {
        Route::post('ckeditor/upload', [SettingsController::class, 'ckEditorUpload'])->name('settings.ckeditor');
        Route::post('website/logo', [SettingsController::class, 'updateLogo'])->name('website.logo');
        Route::resource('website', SettingsController::class);
    });
});

Route::get('payments/{notransaksi}', [DonationController::class, 'payments'])->name('donations.payments');
