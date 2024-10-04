@extends('layouts.home')

@section('content')

<div class="container p-4">
    <div class="row">
        <div class="col-md-12">
            {{ Breadcrumbs::render('program') }}
        </div>
        @foreach ($programs as $program)
        <div class="col-md-3">
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
    <div class="d-flex justify-content-center">
        {{$programs->links()}}
    </div>
</div>
</div>

@endsection