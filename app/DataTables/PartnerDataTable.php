<?php

namespace App\DataTables;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PartnerDataTable extends DataTable
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
            ->editColumn('logo', function ($row) {
                $images = '';

                if ($row->logo != 'logo.png') {
                    $link =  Storage::url($row->logo);
                    $images = '<img src="' . $link . '" class="img-responsive" width="100" alt="images" />';
                }

                return $images;
            })
            ->addColumn('action', function ($row) {
                $btnInfo = '<button class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#modalInfoPartner" data-id="' . $row->id . '"> <i class="fas fa-info-circle"></i> </button> ';
                $btnEdit = '<button class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#modalUpdatePartner" data-id="' . $row->id . '"> <i class="fas fa-edit"></i> </button> ';
                $btnDelete = '<button onClick="deleteConfirm(' . "'" . route('partners.destroy', $row->id) . "'" . ', ' . "'#partner-table'" . ')" class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"></i> </button> ';
                $btnRestore = '';

                return $btnInfo . $btnEdit . $btnDelete . $btnRestore;
            })
            ->rawColumns(['action', 'logo'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Partner $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('partner-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->selectStyleSingle()
            ->responsive(true)
            ->autoWidth(true)
            ->rowReorder(true)
            ->lengthMenu([50, 100, 250, 500])
            ->buttons(['pageLength', 'reload'])
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
            Column::computed('logo'),
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
        return 'Partner_' . date('YmdHis');
    }
}
