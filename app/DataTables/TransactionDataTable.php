<?php

namespace App\DataTables;

use App\Models\Donation;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TransactionDataTable extends DataTable
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
                return $row->created_at->format('d-m-Y H:i:s');
            })
            ->editColumn('updated_at', function ($row) {
                return $row->created_at->format('d-m-Y H:i:s');
            })
            ->editColumn('total', function ($row) {
                return number_format($row->quantity * $row->nominal_donasi + $row->unik_nominal, 0, ',', '.');
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'Success') {
                    return '<span class="badge rounded-pill bg-success">Settlement</span>';
                } else if ($row->status == 'Expired') {
                    return '<span class="badge rounded-pill bg-danger">Expired</span>';
                } else {
                    return '<span class="badge rounded-pill bg-warning">Pending</span>';
                }
            })
            ->rawColumns(['status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Donation $model): QueryBuilder
    {
        $startDate = $this->request->get('startDate');
        $endDate = $this->request->get('endDate');
        $status = $this->request->get('status');
        $zisco = $this->request->get('zisco');

        return $model->newQuery()
            ->withTrashed()
            ->with(['users', 'campaigns', 'rekenings'])
            ->when($status, function ($query) use ($status) {
                if ($status != 'all') {
                    $query->where('status', $status);
                }
            })
            ->when($zisco, function ($query) use ($zisco) {
                if ($zisco != '') {
                    $query->where('referals', $zisco);
                }
            })
            ->when([$startDate, $endDate], function ($query) use ($startDate, $endDate) {
                $query->whereRaw(DB::raw('DATE(created_at) BETWEEN ? AND ?'), [$startDate, $endDate]);
            });
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('transaction-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->selectStyleSingle()
            ->responsive(true)
            ->autoWidth(true)
            ->rowReorder(true)
            ->lengthMenu([50, 100, 250, 500])
            ->buttons(['pageLength', 'reload', 'export'])
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
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('no_transaksi')->title('No Transaksi'),
            Column::make('users.name')->title('Nama'),
            Column::make('users.email')->title('Email'),
            Column::make('campaigns.name')->title('Campaign'),
            Column::make('rekenings.bank')->title('Rekening'),
            Column::computed('total')->title('Total'),
            Column::make('status')->title('Status'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Transaction_' . date('YmdHis');
    }
}
