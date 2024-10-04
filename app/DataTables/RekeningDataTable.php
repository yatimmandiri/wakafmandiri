<?php

namespace App\DataTables;

use App\Models\Rekening;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RekeningDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->editColumn('updated_at', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->editColumn('icon', function ($row) {
                $icon = '';

                if ($row->icon != '' || $row->icon != null) {
                    $link = Storage::url($row->icon);
                    $icon = '<img src="' . $link . '" class="img-responsive" width="50" alt="icon" />';
                }

                return $icon;
            })
            ->editColumn('recomendation', function ($row) {
                $status = 'Not recomendation';
                $color = 'bg-secondary';

                if ($row->recomendation == 'Y') {
                    $status = 'Recomendation';
                    $color = 'bg-success';
                }

                return '<span class="badge rounded-pill ' . $color . '" onClick="recomendationConfirmation({
                active: ' . "'" . $row->recomendation . "'"  . ',
                tableId: ' . "'#rekening-table'" . ',
                methods: ' . "'PUT'" . ',
                url: ' . "'/master/rekenings/recomendation/" . $row->id . "'" . ',
            })">' . $status . '</span>';
            })
            ->addColumn('status', function ($row) {
                $status = 'Not Active';
                $color = 'bg-secondary';

                if ($row->status == 'Y') {
                    $status = 'Active';
                    $color = 'bg-success';
                }

                return '<span class="badge rounded-pill ' . $color . '" onClick="activeConfirmation({
                    active: ' . "'" . $row->status . "'"  . ',
                    tableId: ' . "'#rekening-table'" . ',
                    methods: ' . "'PUT'" . ',
                    url: ' . "'/master/rekenings/status/" . $row->id . "'" . ',
                })">' . $status . '</span>';
            })
            ->addColumn('action', function ($row) {
                $btnInfo = '<button class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#modalInfoRekening" data-id="' . $row->id . '"> <i class="fas fa-info-circle"></i> </button> ';
                $btnEdit = '<button class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#modalUpdateRekening" data-id="' . $row->id . '"> <i class="fas fa-edit"></i> </button> ';
                $btnDelete = '<button onClick="deleteConfirm(' . "'" . route('rekenings.destroy', $row->id) . "'" . ', ' . "'#rekening-table'" . ')" class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"></i> </button> ';
                $btnRestore = '';

                return $btnInfo . $btnEdit;
            })
            ->rawColumns(['recomendation', 'status', 'icon', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Rekening $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('rekening-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->selectStyleSingle()
            ->responsive(true)
            ->autoWidth(true)
            ->lengthMenu([50, 100, 250, 500])
            ->buttons([
                'pageLength',
                'reload',
            ])
            ->layout([
                'topStart' => 'buttons'
            ])
            ->ordering(true);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->addClass('text-center')->title('No')->searchable(false)->orderable(false),
            Column::make('name'),
            Column::make('bank')->title('Bank'),
            Column::make('number')->title('Number'),
            Column::make('token')->title('Token'),
            Column::make('group')->title('Group'),
            Column::make('icon')->title('icon'),
            Column::make('recomendation')->title('Recomendation'),
            Column::make('status')->title('Status'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Rekening_' . date('YmdHis');
    }
}
