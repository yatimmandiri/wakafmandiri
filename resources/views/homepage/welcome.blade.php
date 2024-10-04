@extends('layouts.home')

@section('content')

<div class="swiper sliders">
    <div class="swiper-wrapper">
        @foreach ($sliders as $slider)
        <div class="swiper-slide" id="slider-item">
            <img src="{{ asset('storage/'. $slider->images) }}" class="w-100 h-25" alt="{{ $slider->name }}">
        </div>
        @endforeach
    </div>
    <div class="swiper-pagination"></div>
</div>

<div class="container-fluid row p-4">
    <div class="col-md-12 text-center p-4">
        <h1 class="font-weight-bold">Sustainable Living</h1>
        <h5>Mendorong Tercapainya Kehidupan Berkelanjutan Untuk Kemandirian Yatim Dhuafa</h5>
    </div>
    <div class="col-md-12">
        <div class="separator-with-text">
            <span>Program Wakaf Mandiri</span>
        </div>
        <div class="programs swiper">
            <div class="swiper-wrapper">
                @foreach ($programs as $program)
                <div class="swiper-slide" id="program-item">
                    <a href="{{ route('programs.show', $program->slug) }}" class="card text-dark">
                        <img src="{{ asset($program->feature_image != 'images.png' ? 'storage/' . $program->feature_image : 'images/placeholder.jpg') }}" class="card-img" style="height: 200px;" alt=" {{ $program->title }}">
                        <div class="card-body row text-sm">
                            <h5 class="col-md-12 card-title font-weight-bold limited-text">{{ $program->name }}</h5>
                            <div class="col-md-12 mt-2">
                                {{ $program->excerpt }}
                            </div>
                            <div class="col-md-12 d-flex justify-content-between mt-3 border-top pt-2">
                                <span>Terkumpul</span>
                                <span class="font-weight-bold">Rp 10.000.000</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="separator-with-text">
            <span>Berita Wakaf Mandiri</span>
        </div>
        <div class="beritas swiper">
            <div class="swiper-wrapper">
                @foreach ($beritas as $article)
                <div class="swiper-slide" id="berita-item">
                    <a href="{{ route('berita.show', $article->slug) }}" class="card text-dark">
                        <img src="{{ asset($article->images != 'images.png' ? 'storage/' . $article->images : 'images/placeholder.jpg') }}" class="card-img" style="height: 200px;" alt=" {{ $article->title }}">
                        <div class="card-body text-sm d-flex justify-content-start align-items-start flex-column" style="min-height: 170px; align-items: center">
                            <h5 class="card-title font-weight-bold limited-text">{{ $article->title }}</h5>
                            <div class="card-text limited-text mt-3">{{ $article->excerpt }}</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="separator-with-text">
            <span>Mitra Wakaf Mandiri</span>
        </div>
        <div class="partners swiper">
            <div class="swiper-wrapper">
                @foreach ($partners as $partner)
                <div class="swiper-slide" id="partner-item">
                    <img src="{{ asset('storage/'. $partner->logo) }}" class="img-fluid w-75 h-75" alt="{{ $partner->logo }}">
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>

<script type="module">
    const sliders = new Swiper('.sliders', {
        slidesPerView: 1,
        spaceBetween: 10,
    });

    const beritas = new Swiper('.beritas', {
        slidesPerView: 1,
        spaceBetween: 10,
        autoplay: true,
        loop: true,
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 10,
            },
        },
    });

    const programs = new Swiper('.programs', {
        slidesPerView: 1,
        spaceBetween: 10,
        autoplay: true,
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 10,
            },
        },
    });

    const partners = new Swiper('.partners', {
        autoplay: true,
        slidesPerView: 3,
        spaceBetween: 10,
        breakpoints: {
            768: {
                slidesPerView: 5,
            },
            1024: {
                slidesPerView: 8,
            },
        },
    });
</script>

@endsection