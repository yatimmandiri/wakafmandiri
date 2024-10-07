@extends('layouts.home')

@section('content')

<div class="container p-4">
    <div class="row">
        <div class="col-md-12">
            Terima Kasih Telah Menyalurkan Wakaf 
        </div>
        <div class="col-md-12">
            <div class="card text-dark">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ asset($campaigns->feature_image != 'images.png' ? 'storage/' . $campaigns->feature_image : 'images/placeholder.jpg') }}" class="card-img" alt=" {{ $campaigns->title }}">
                    </div>
                    <div class="col-md-8 card-body d-flex flex-column justify-content-center">
                        <h5 class="card-title mb-3 font-weight-bold">{{ $campaigns->name }}</h5>
                        <div class="card-text">{!! $campaigns->excerpt !!}</div>
                        <div class="d-flex justify-content-between mt-3 border-top pt-2">
                            <span>Terkumpul</span>
                            <span class="font-weight-bold">Rp 100.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection