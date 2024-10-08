<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Jobs\NotificationTransaction;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Rekening;
use App\Models\User;
use Illuminate\Http\Request;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function notifications()
    {
        $this->initMidtrans();

        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $donations = Donation::where('no_transaksi', $notif->order_id)->first();

        if (!$donations) {
            return $this->sendError('ID Not Found', 'Data Not Found');
        }

        $cekRekening = Rekening::where('id', $donations->rekening_id)->first();
        $cekUsers = User::where('id', $donations->user_id)->first();
        $cekCampaign = Campaign::where('id', $donations->campaign_id)->first();

        dispatch(new NotificationTransaction($cekUsers->email, [
            'name' => $cekUsers->name,
            'handphone' => $cekUsers->handphone,
            'invoice' =>  $donations->no_transaksi,
            'campaigns' =>  $cekCampaign->name,
            'nominal' => $donations->nominal_donasi * $donations->quantity,
            'payments' => $cekRekening->bank,
            'virtualaccount' => $donations->va_number,
            'status' => $donations->status,
        ]));

        return $this->sendResponse($donations, 'Send Notification Successfully');
    }
}
