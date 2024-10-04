@extends('layouts.home')

@section('content')

<div class="container p-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <img src="{{ asset($berita->images != 'images.png' ? 'storage/' . $berita->images : 'images/placeholder.jpg') }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold pb-3">{{ $berita->title }}</h5>
                    <div class="card-text">{!! $berita->content !!}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <legend class="text-sm font-weight-bold">Berita Terkait</legend>
                    <ul class="text-sm">
                        @foreach ($related as $item)
                        <li><a href="{{ route('literasi.show', $item->slug) }}">{{ $item->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection