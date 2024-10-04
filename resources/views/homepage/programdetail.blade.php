@extends('layouts.home')

@section('content')

<div class="container p-4">
    <div class="row">
        <div class="col-md-12">
            {{ Breadcrumbs::render('program-detail', $program) }}
        </div>
        <div class="col-md-12">
            <!-- <div class="card mx-auto">
                <div class="row no-gutters">
                    <div class="col-md-3">
                        <img class="img-fluid" src="{{ asset($program->feature_image != 'images.png' ? 'storage/' . $program->feature_image : 'images/placeholder.jpg') }}" alt="{{ $program->name }}">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold pb-3">{{ $program->name }}</h5>
                            <div class="card-text">{!! $program->excerpt !!}</div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="card text-dark">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ asset($program->feature_image != 'images.png' ? 'storage/' . $program->feature_image : 'images/placeholder.jpg') }}" class="card-img" alt=" {{ $program->title }}">
                    </div>
                    <div class="col-md-8 card-body d-flex flex-column justify-content-center">
                        <h5 class="card-title mb-3 font-weight-bold">{{ $program->name }}</h5>
                        <div class="card-text">{!! $program->excerpt !!}</div>
                        <div class="d-flex justify-content-between mt-3 border-top pt-2">
                            <span>Terkumpul</span>
                            <span class="font-weight-bold">Rp 10.000.000</span>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="card">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="donasi-tab" data-toggle="tab" data-target="#donasi" type="button" role="tab" aria-controls="donasi" aria-selected="false">Berdonasi</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link " id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Deskripsi</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="donatur-tab" data-toggle="tab" data-target="#donatur" type="button" role="tab" aria-controls="donatur" aria-selected="false">Donatur</button>
                    </li>
                </ul>
                <div class="card-body tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                        {!! $program->description !!}
                    </div>
                    <div class="tab-pane fade" id="donatur" role="tabpanel" aria-labelledby="donatur-tab">
                        Comming Soon
                    </div>
                    <div class="tab-pane fade show active" id="donasi" role="tabpanel" aria-labelledby="donasi-tab">
                        <form method="POST" id="formDonationCreate" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="campaign_id" value="{{ $program->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nominal">Isi Nominal</label>
                                        <input type="text" class="form-control" id="nominal" name="amount">
                                    </div>
                                    <div class="form-group">
                                        <label for="rekomendasinominal">Rekomendasi Nominal</label>
                                        <div class="d-flex flex-column justify-content-between">
                                            <button type="button" onclick="changeNominal(250000)" class="btn btn-outline-primary btn-block">Rp. 250.000</button>
                                            <button type="button" onclick="changeNominal(500000)" class="btn btn-outline-primary btn-block">Rp. 500.000</button>
                                            <button type="button" onclick="changeNominal(1000000)" class="btn btn-outline-primary btn-block">Rp. 1.000.000</button>
                                            <button type="button" onclick="changeNominal(2000000)" class="btn btn-outline-primary btn-block">Rp. 2.000.000</button>
                                            <button type="button" onclick="changeNominal(5000000)" class="btn btn-outline-primary btn-block">Rp. 5.000.000</button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="rekening_id">Metode Pembayaran</label>
                                        <select name="rekening_id" id="rekening_id" class="form-control"></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="handphone">Handphone</label>
                                        <input type="text" class="form-control" id="handphone" name="phone">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Doa dan Harapan</label>
                                        <textarea name="description" id="description" rows="5" placeholder="Tulis pesan dan doa" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary btn-block" onclick="$(this).submit()">Lanjut Pembayaran</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        $(document).ready(function() {
            ajaxRequest({
                url: `{{ route('rekenings.index') }}`,
            }).done((response) => {
                setDataSelect({
                    tagid: '#rekening_id',
                    data: response.data.map((item) => {
                        return {
                            id: item.id,
                            text: item.bank,
                        }
                    }),
                    placeholder: 'Select Rekening',
                })
            })

            $('#nominal').on('keyup', function() {
                $(this).val(formatNumber($(this).val()));
            })

            function formatNumber(num) {
                return numeral(num).format('0,0');
            }

            $('#formDonationCreate').ajaxForm({
                url: `{{ route('donations.store') }}`,
                type: 'POST',
                resetForm: true,
                beforeSubmit: function(formData) {
                    return true;
                },
                success: function(result) {
                    Toast.fire({
                        icon: 'success',
                        title: result.message
                    })

                    window.location.href = `/payments/${result.data.no_transaksi}`
                },
                error: function(errors) {
                    Toast.fire({
                        icon: 'error',
                        title: errors.responseJSON.message,
                    })
                }
            });
        })
    </script>

    @endsection