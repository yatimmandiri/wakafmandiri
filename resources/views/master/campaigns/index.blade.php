@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$pageTitle}}</h3>
                <div class="card-tools">
                    <a href="{{  route('campaigns.create') }}">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="card card-primary card-outline">
                    <div class="card-body row">
                        <div class="col-lg-4">
                            <label>Status</label>
                            <div class="form-group">
                                <select name="status" id="status" class="form-control select2">
                                    <option value="Y">Actived</option>
                                    <option value="N">Deactived</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label>Categories</label>
                            <div class="form-group">
                                <select name="categories" id="categories" class="form-control select2">
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
        ajaxRequest({
            url: `/master/categories`,
        }).done((categories) => {
            setDataSelect({
                tagid: '#categories',
                data: categories.data.map((item) => {
                    return {
                        id: item.id,
                        text: item.name,
                    }
                }),
                placeholder: 'Select Categories',
            })
        })

        setDataSelect({
            tagid: '#status',
            placeholder: 'Select Status',
        })

        let table = $('#campaign-table')
        var status = $('#status').val()
        var categories = $('#categories').val()

        table.on('preXhr.dt', function(e, settings, data) {
            data.status = status;
            data.categories = categories;
        })

        table.DataTable().ajax.reload()

        $('#status').on('change', function() {
            status = $(this).val();

            table.on('preXhr.dt', function(e, settings, data) {
                data.categories = categories;
                data.status = status;
            })

            table.DataTable().ajax.reload()
        })

        $('#categories').on('change', function() {
            categories = $(this).val();

            table.on('preXhr.dt', function(e, settings, data) {
                data.categories = categories;
                data.status = status;
            })

            table.DataTable().ajax.reload()
        })

    })
</script>

@endsection