<?php

namespace App\DataTables;

use App\Models\Donation;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DonationDataTable extends DataTable
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
            ->addColumn('total', function ($row) {
                return number_format($row->quantity * $row->nominal_donasi + $row->unik_nominal, 0, ',', '.');
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 'Success') {
                    return '<span class="badge rounded-pill bg-success">Settlement</span>';
                } else if ($row->status == 'Expired') {
                    return '<span class="badge rounded-pill bg-danger">Expired</span>';
                } else {
                    return '<span class="badge rounded-pill bg-warning">Pending</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $btnInfo = '<button class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#modalInfoDonation" data-id="' . $row->id . '"> <i class="fas fa-info-circle"></i> </button> ';
                $btnEdit = '';
                $btnDelete = '<button onClick="deleteConfirm(' . "'" . route('donations.destroy', $row->id) . "'" . ', ' . "'#donation-table'" . ')" class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"></i> </button> ';
                $btnRestore = '';

                return $btnInfo;
            })
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Donation $model): QueryBuilder
    {
        $status = $this->request->get('status');
        $campaigns = $this->request->get('campaigns');

        return $model->newQuery()
            ->withTrashed()
            ->with(['users', 'campaigns', 'rekenings'])
            ->when($campaigns, function ($query) use ($campaigns) {
                if ($campaigns != 'all') {
                    $query->where('campaign_id', $campaigns);
                }
            })
            ->when($status, function ($query) use ($status) {
                if ($status != 'all') {
                    $query->where('status', $status);
                }
            });
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('donation-table')
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
            Column::make('no_transaksi'),
            Column::make('users.name')->title('Nama Donatur'),
            Column::make('campaigns.name')->title('Campaign'),
            Column::make('rekenings.bank')->title('Rekening'),
            Column::computed('total')->title('Total'),
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
        return 'Donation_' . date('YmdHis');
    }
}
