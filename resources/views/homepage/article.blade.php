@extends('layouts.home')

@section('content')

<div class="container p-4">
    <div class="row">
        @foreach ($beritas as $article)
        <div class="col-md-12">
            <a href="{{ route('literasi.show', $article->slug) }}" class="card text-dark">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ asset($article->images != 'images.png' ? 'storage/' . $article->images : 'images/placeholder.jpg') }}" class="card-img" alt=" {{ $article->title }}">
                    </div>
                    <div class="col-md-8 card-body d-flex flex-column justify-content-center">
                        <h5 class="card-title mb-3 font-weight-bold">{{ $article->title }}</h5>
                        <div class="card-text">{!! $article->excerpt !!}</div>
                        <p class="card-text"><small class="text-muted">Last updated at {{$article->updated_at->diffForHumans()}}</small></p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{$beritas->links()}}
    </div>
</div>
</div>

@endsection