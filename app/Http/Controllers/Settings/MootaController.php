<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MootaController extends Controller
{
    public function rekening()
    {
        $cekRekening = Http::withToken(env('MOOTA_TOKEN'))
            ->get(env('MOOTA_URL') . '/api/v2/bank')->json();

        return $cekRekening;
    }
}
