@extends('layouts.home')

@section('content')

<div class="container p-4">
    <div class="row">
        <div class="col-md-9 ">
            <h3 class="text-center pb-2 font-weight-bold">Tentang Kami</h3>
            {!! $page->content !!}
        </div>
        <div class="col-md-3">
            <img src="{{ asset('storage/'. $pengaturan->sertifikat) }}" alt="sertifikat" class="img-fluid pb-3">
            <img src="{{ asset('storage/'. $page->images) }}" alt="feature image" class="img-fluid">
        </div>
    </div>
</div>

@endsection