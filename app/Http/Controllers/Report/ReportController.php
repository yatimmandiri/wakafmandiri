<?php

namespace App\Http\Controllers\Report;

use App\DataTables\DonaturDataTable;
use App\DataTables\TransactionDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function donaturs(DonaturDataTable $datatables)
    {
        $data['pageTitle'] = 'Donatur List';
        return $datatables->render('reports.donatur', $data);
    }

    public function donations(TransactionDataTable $datatables)
    {
        $data['pageTitle'] = 'Donation Report';
        return $datatables->render('reports.donation', $data);
    }
}
