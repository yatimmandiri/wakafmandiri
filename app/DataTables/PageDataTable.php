<?php

namespace App\DataTables;

use App\Models\Page;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PageDataTable extends DataTable
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
            ->addColumn('images', function ($row) {
                $featureimage = '';

                if ($row->images != 'images.png') {
                    $link = Storage::url($row->images);
                    $featureimage = '<img src="' . $link . '" class="img-responsive w-50 h-50" alt="icon" />';
                }

                return $featureimage;
            })
            ->addColumn('action', function ($row) {
                $btnEdit = '';
                $btnDelete = '';
                $btnRestore = '';

                if ($row->deleted_at != null) {
                    $btnRestore = '<button onClick="restoreConfirm(' . "'" . route('pages.restore', $row->id) . "'" . ', ' . "'#page-table'" . ')" class="btn btn-success btn-sm text-white"> <i class="fas fa-trash-arrow-up"></i> </button> ';
                } else {
                    $btnEdit = '<a href="' . route('pages.edit', $row->id) . '"> <button class="btn btn-warning btn-sm text-white"> <i class="fas fa-edit"></i> </button> </a> ';
                    $btnDelete = '<button onClick="deleteConfirm(' . "'" . route('pages.destroy', $row->id) . "'" . ', ' . "'#page-table'" . ')" class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"></i> </button> ';
                }

                return $btnEdit . $btnDelete;
            })
            ->rawColumns(['status', 'images', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Page $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('page-table')
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
            Column::make('title'),
            Column::make('slug'),
            Column::make('images')->title('Feature Image'),
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
        return 'Page_' . date('YmdHis');
    }
}
