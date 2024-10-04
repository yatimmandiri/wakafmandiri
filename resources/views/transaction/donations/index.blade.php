@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$pageTitle}}</h3>
                <div class="card-tools">
                    <!-- <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCreateDonation"><i class="fa fa-plus"></i></button>
                    <button id="checkStatus" class="btn btn-warning btn-sm"><i class="fa fa-rotate"></i></button> -->
                </div>
            </div>
            <div class="card-body">
                <div class="card card-primary card-outline">
                    <div class="card-body row">
                        <div class="col-lg-4">
                            <label>Status</label>
                            <div class="form-group">
                                <select name="status" id="status" class="form-control select2">
                                    <option value="Pending">Pending</option>
                                    <option value="Success">Success</option>
                                    <option value="Expired">Expired</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label>Program</label>
                            <div class="form-group">
                                <select name="campaigns" id="campaigns" class="form-control select2"></select>
                            </div>
                        </div>
                    </div>
                </div>
                {{ $dataTable->table(['class' => 'table table-sm table-hover table-striped'], true) }}
            </div>
        </div>
    </div>
</div>

@include('transaction.donations.create')
@include('transaction.donations.show')

{{ $dataTable->scripts() }}

<script type="module">
    $(document).ready(function() {
        setDataSelect({
            tagid: '#status',
            placeholder: 'Select Status',
        })

        ajaxRequest({
            url: `/master/campaigns`,
        }).done((campaigns) => {
            setDataSelect({
                tagid: '#campaigns',
                data: campaigns.data.map((item) => {
                    return {
                        id: item.id,
                        text: item.name,
                    }
                }),
                placeholder: 'Select Program',
            })
        })

        let table = $('#donation-table')
        var status = $('#status').val()
        var campaigns = $('#campaigns').val()

        table.on('preXhr.dt', function(e, settings, data) {
            data.status = status;
            data.campaigns = campaigns;
        })

        table.DataTable().ajax.reload()

        $('#status').on('change', function() {
            status = $(this).val();

            table.on('preXhr.dt', function(e, settings, data) {
                data.status = status;
                data.campaigns = campaigns;
            })

            table.DataTable().ajax.reload()
        })

        $('#campaigns').on('change', function() {
            campaigns = $(this).val();

            table.on('preXhr.dt', function(e, settings, data) {
                data.status = status;
                data.campaigns = campaigns;
            })

            table.DataTable().ajax.reload()
        })


    })
</script>

@endsection