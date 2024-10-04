<?php

namespace App\DataTables;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class CampaignDataTable extends DataTable
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
            ->editColumn('excerpt', function ($row) {
                return Str::limit($row->excerpt, 50);
            })
            ->editColumn('status', function ($row) {
                $status = 'Not Active';
                $color = 'bg-secondary';

                if ($row->status == 'Y') {
                    $status = 'Active';
                    $color = 'bg-success';
                }

                return '<span class="badge rounded-pill ' . $color . '" onClick="activeConfirmation({
                    active: ' . "'" . $row->status . "'"  . ',
                    tableId: ' . "'#campaign-table'" . ',
                    methods: ' . "'PUT'" . ',
                    url: ' . "'/master/campaigns/status/" . $row->id . "'" . ',
                })">' . $status . '</span>';
            })
            ->addColumn('feature_image', function ($row) {
                $featureimage = '';

                if ($row->feature_image != 'images.png') {
                    $link = Storage::url($row->feature_image);
                    $featureimage = '<img src="' . $link . '" class="img-responsive w-50 h-50" alt="icon" />';
                }

                return $featureimage;
            })
            ->addColumn('action', function ($row) {
                $btnInfo = '';
                $btnEdit = '';
                $btnDelete = '';
                $btnRestore = '';

                if ($row->deleted_at != null) {
                    $btnRestore = '<button onClick="restoreConfirm(' . "'" . route('campaigns.restore', $row->id) . "'" . ', ' . "'#campaign-table'" . ')" class="btn btn-success btn-sm text-white"> <i class="fas fa-trash-arrow-up"></i> </button> ';
                } else {
                    $btnInfo = '<a href="' . route('campaigns.show', $row->id) . '"> <button class="btn btn-info btn-sm text-white"> <i class="fas fa-info-circle"></i> </button> </a> ';
                    $btnEdit = '<a href="' . route('campaigns.edit', $row->id) . '"> <button class="btn btn-warning btn-sm text-white"> <i class="fas fa-edit"></i> </button> </a> ';
                    $btnDelete = '<button onClick="deleteConfirm(' . "'" . route('campaigns.destroy', $row->id) . "'" . ', ' . "'#campaign-table'" . ')" class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"></i> </button> ';
                }

                return $btnInfo . $btnEdit;
            })
            ->rawColumns(['status', 'feature_image', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Campaign $model): QueryBuilder
    {
        $status = $this->request->get('status');
        $categories = $this->request->get('categories');

        return $model->newQuery()
            ->withTrashed()
            ->with(['categories'])
            ->when($status, function ($query) use ($status) {
                if ($status != 'all') {
                    $query->where('status', $status);
                }
            })
            ->when($categories, function ($query) use ($categories) {
                if ($categories != 'all') {
                    $query->where('categories_id', $categories);
                }
            });
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('campaign-table')
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
            Column::make('slug')->title('Slug'),
            Column::make('excerpt')->title('Excerpt'),
            Column::make('feature_image')->title('Feature Image'),
            Column::computed('status')->title('Status'),
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
        return 'Campaign_' . date('YmdHis');
    }
}
