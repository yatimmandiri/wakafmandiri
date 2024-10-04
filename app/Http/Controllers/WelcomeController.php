<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Campaign;
use App\Models\News;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Settings;
use App\Models\Slider;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Wakaf Mandiri',
            'sliders' => Slider::all(),
            'partners' => Partner::all(),
            'beritas' => News::latest()->paginate(5),
            'programs' => Campaign::latest()->paginate(5),
        ];

        return view('homepage.welcome', $data);
    }

    public function tentangKami()
    {
        $data = [
            'pageTitle' => 'Tentang Kami',
            'page' => Page::find(1),
        ];

        return view('homepage.tentang', $data);
    }

    public function berita()
    {
        $data = [
            'pageTitle' => 'Berita',
            'beritas' => News::latest()->paginate(2),
        ];

        return view('homepage.berita', $data);
    }

    public function beritaBySlug($slug)
    {
        $data = [
            'pageTitle' => 'Berita',
            'berita' => News::where('slug', $slug)->first(),
            'related' => News::whereNot('slug', $slug)->limit(5)->get(),
        ];

        return view('homepage.beritadetail', $data);
    }

    public function program()
    {
        $data = [
            'pageTitle' => 'Program',
            'programs' => Campaign::latest()->paginate(9),
        ];

        return view('homepage.program', $data);
    }

    public function programBySlug($slug)
    {
        $data = [
            'pageTitle' => 'Program Produktif',
            'program' => Campaign::where('slug', $slug)->first(),
            'related' => Campaign::whereNot('slug', $slug)->limit(5)->get(),
        ];

        return view('homepage.programdetail', $data);
    }

    // public function programProduktif()
    // {
    //     $data = [
    //         'pageTitle' => 'Program Produktif',
    //         'programs' => Campaign::paginate(9),
    //     ];

    //     return view('homepage.program', $data);
    // }

    // public function programSosial()
    // {
    //     $data = [
    //         'pageTitle' => 'Program Sosial',
    //         'programs' => Campaign::paginate(6),
    //     ];

    //     return view('homepage.program', $data);
    // }

    public function literasi()
    {
        $data = [
            'pageTitle' => 'Literasi',
            'beritas' => Article::latest()->paginate(2),
        ];

        return view('homepage.article', $data);
    }

    public function literasiBySlug($slug)
    {
        $data = [
            'pageTitle' => 'Article',
            'berita' => Article::where('slug', $slug)->first(),
            'related' => Article::whereNot('slug', $slug)->limit(5)->get(),
        ];

        return view('homepage.articledetail', $data);
    }

    public function programProduktifBySlug($slug)
    {
        $data = [
            'pageTitle' => 'Program Produktif',
            'program' => Campaign::where('slug', $slug)->first(),
            'related' => Campaign::whereNot('slug', $slug)->limit(5)->get(),
        ];

        return view('homepage.programdetail', $data);
    }
}
