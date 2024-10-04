@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$pageTitle}}</h3>
            </div>
            <div class="card-body">
                <div class="card card-primary card-outline">
                    <div class="card-body row">
                        <div class="col-lg-4">
                            <label>Tanggal</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control daterange float-right" id="filter_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label>Status</label>
                            <div class="form-group">
                                <select name="status" id="status" class="form-control select2">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                {{ $dataTable->table(['class' => 'table table-sm table-hover table-striped'], true) }}
            </div>
        </div>
    </div>
</div>

{{ $dataTable->scripts() }}

<script type="module">
    $(document).ready(function() {
        setDataSelect({
            tagid: '#status',
            data: [{
                    id: 'Pending',
                    text: 'Pending',
                },
                {
                    id: 'Expired',
                    text: 'Expired',
                },
                {
                    id: 'Success',
                    text: 'Success',
                },
            ],
            placeholder: 'Select Status',
        })

        let table = $('#transaction-table')

        setDateRange({
            idtag: '#filter_date'
        })

        var filterStartDate = $('#filter_date').data().startDate.format('YYYY-MM-DD')
        var filterEndDate = $('#filter_date').data().endDate.format('YYYY-MM-DD')
        var status = $('#status').val()

        table.on('preXhr.dt', function(e, settings, data) {
            data.startDate = filterStartDate;
            data.endDate = filterEndDate;
            data.status = status;
        })

        table.DataTable().ajax.reload()

        $('#status').on('change', function() {
            status = $(this).val();

            table.on('preXhr.dt', function(e, settings, data) {
                data.startDate = filterStartDate;
                data.endDate = filterEndDate;
                data.status = status;
            })

            table.DataTable().ajax.reload()
        })

        $('#filter_date').on('apply.daterangepicker', function(ev, picker) {
            filterStartDate = picker.startDate.format('YYYY-MM-DD')
            filterEndDate = picker.endDate.format('YYYY-MM-DD')

            table.on('preXhr.dt', function(e, settings, data) {
                data.startDate = filterStartDate;
                data.endDate = filterEndDate;
                data.status = status;
            })

            table.DataTable().ajax.reload()
        })
    })
</script>

@endsection