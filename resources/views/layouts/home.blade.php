<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset($pengaturan['logo'] != 'logo.png' ? 'storage/' . $pengaturan['logo'] : 'images/AdminLTELogo.png') }}" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top shadow navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset($pengaturan['logo'] != 'logo.png' ? 'storage/' . $pengaturan['logo'] : 'images/AdminLTELogo.png') }}" alt="logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('/')) ? 'active font-weight-bold' : '' }}" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('tentang-kami')) ? 'active font-weight-bold' : '' }}" href="{{ route('home.tentang') }}">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('program')) ? 'active font-weight-bold' : '' }}" href="{{ route('home.program') }}">Program</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('berita')) ? 'active font-weight-bold' : '' }}" href="{{ route('home.berita') }}">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('literasi')) ? 'active font-weight-bold' : '' }}" href="{{ route('home.literasi') }}">Literasi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="baseBackground">
        <div class="row container-fluid mx-auto p-4">
            <div class="col-md-5 row">
                <div class="col-md-2 pr-2 pb-3">
                    <img src="{{ asset($pengaturan['logoWhite'] != 'logoWhite.png' ? 'storage/' . $pengaturan['logoWhite'] : 'images/AdminLTELogo.png') }}" alt="logo" class="img-fluid" width="100" height="100">
                </div>
                <div class="col-md-9 pr-2 pb-3">
                    {!! $pengaturan["description"] ?? '' !!}
                </div>
            </div>
            <div class="d-flex flex-column col-md-4">
                <h6 class="text-orange font-weight-bold">OFFICE:</h6>
                <ul class="list-unstyled">
                    <li>{{$pengaturan["name"] ?? ''}}</li>
                    <li>{{$pengaturan["address"] ?? ''}}</li>
                    <li><i class="fa-solid fa-phone fa-md"></i> &nbsp; {{$pengaturan["phone"] ?? ''}}</li>
                    <li><i class="fa-brands fa-whatsapp fa-md"></i> &nbsp; {{$pengaturan["handphone"] ?? ''}}</li>
                    <li><i class="fa-regular fa-envelope fa-md"></i> &nbsp; {{$pengaturan["email"] ?? ''}}</li>
                </ul>
            </div>
            <div class="col-md-2">
                <h6 class="text-orange font-weight-bold">Social Media</h6>
                <div class="d-flex">
                    <a href="{{ $pengaturan['facebook'] ?? '' }}" class="p-2 mr-2 border border-white rounded-circle">
                        <i class="fa-brands fa-facebook fa-xl text-white"></i>
                    </a>
                    <a href="{{ $pengaturan['twitter'] ?? '' }}" class="p-2 mr-2 border border-white rounded-circle">
                        <i class="fa-brands fa-twitter fa-xl text-white"></i>
                    </a>
                    <a href="{{ $pengaturan['instagram'] ?? '' }}" class="p-2 mr-2 border border-white rounded-circle">
                        <i class="fa-brands fa-instagram fa-xl text-white"></i>
                    </a>
                    <a href="{{ $pengaturan['youtube'] ?? '' }}" class="p-2 mr-2 border border-white rounded-circle">
                        <i class="fa-brands fa-youtube fa-xl text-white"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="bg-dark p-2">
            <div class="text-center">
                <div class="text-muted">Copyright &copy; {{ date('Y') }}. <a href="https://wakafmandiri.org" class="text-muted">Wakaf Mandiri</a>.</div>
            </div>
        </div>
    </footer>
</body>

</html>