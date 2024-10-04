@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$pageTitle}}</h3>
                <div class="card-tools">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCreateMenu"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table(['class' => 'table table-sm table-hover table-striped'], true) }}
            </div>
        </div>
    </div>
</div>

@include('core.menus.create')
@include('core.menus.edit')
@include('core.menus.show')

{{ $dataTable->scripts() }}

<script type="module">
    $(document).ready(function() {
        var table = $('#menu-table').DataTable()

        table.on('row-reorder', function(e, details, edit) {
            for (var i = 0; i < details.length; i++) {
                var rowId = table.row(details[i].node).data().id;
                var newOrder = table.row(details[i].newPosition).data().order;

                $.ajax({
                    url: `/core/menus/reorder/${table.row(details[i].node).data().id}`,
                    type: 'PUT',
                    data: {
                        order: newOrder
                    },
                    success: function(response) {
                        // Optionally handle success response
                        console.log(`Row ${rowId} reordered successfully.`);
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors
                        console.error(`Error reordering row ${rowId}: ${error}`);
                    }
                })
            }
        });
    })
</script>

@endsection