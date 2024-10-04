<?php

namespace App\Http\Controllers\Transaction;

use App\DataTables\DonationDataTable;
use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Http\Requests\StoreDonationRequest;
use App\Http\Requests\UpdateDonationRequest;
use App\Http\Resources\Resource\DonationResource;
use App\Models\Campaign;
use App\Models\Rekening;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Midtrans\CoreApi;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DonationDataTable $datatables)
    {
        $data['pageTitle'] = 'Donation List';
        return $datatables->render('transaction.donations.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDonationRequest $request)
    {
        $cekRekening = Rekening::where('id', $request->rekening_id)->first();
        $cekCampaign = Campaign::where('id', $request->campaign_id)->first();

        $cekUsers = User::where('email', 'LIKE', '%' . $request->email . '%')
            ->first();


        if (!$cekUsers) {
            $cekUsers = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(8)), // password
            ])->assignRole('Users');
        }

        $notransaksi = hexdec(uniqid());
        $paymentGateway = [];
        $vaNumber = '';
        $billcode = '';
        $qrcode = '';
        $deeplinks = '';
        $expired = Carbon::now()
            ->timezone('Asia/Jakarta')
            ->addDays(1)
            ->format('Y-m-d H:i:s');

        switch ($cekRekening->provider) {
            case 'Moota':
                $dataArray = [
                    'va_number' => $cekRekening->number,
                    'unik_nominal' => rand(100, 999),
                    'expired' => $expired,
                ];
                break;
            default:
                switch ($cekRekening->group) {
                    case 'e_money':
                        switch ($cekRekening->token) {
                            case 'shopeepay':
                                $paymentMethod = [
                                    'payment_type' => $cekRekening->token,
                                    'shopeepay' => [
                                        'callback_url' => 'https://midtrans.com/'
                                    ]
                                ];
                                break;
                            default:
                                $paymentMethod = [
                                    'payment_type' => $cekRekening->token,
                                ];
                                break;
                        }
                        break;
                    default:
                        switch ($cekRekening->token) {
                            case 'echannel':
                                $paymentMethod = [
                                    'payment_type' => $cekRekening->token,
                                    'echannel' => [
                                        'bill_info1' => 'Payment',
                                        'bill_info2' => $cekCampaign->name
                                    ],
                                ];
                                break;
                            case 'permata':
                                $paymentMethod = [
                                    'payment_type' => $cekRekening->group,
                                ];
                                break;
                            default:
                                $paymentMethod = [
                                    'payment_type' => $cekRekening->group,
                                    'bank_transfer' => [
                                        'bank' => $cekRekening->token
                                    ],
                                ];
                                break;
                        }
                        break;
                }

                $paramMidtrans = array_merge($paymentMethod, [
                    'transaction_details' => [
                        'order_id' => $notransaksi,
                        'gross_amount' => intval(str_replace(',', '', $request->amount)) * $request->quantity,
                    ],
                    'item_details' => [
                        [
                            'id' => $cekCampaign->id,
                            'price' => intval(str_replace(',', '', $request->amount)),
                            'quantity' => $request->quantity,
                            'name' => $cekCampaign->name,
                        ],
                    ],
                    'customer_details' => [
                        'first_name' => $cekUsers->name,
                        'last_name' => '',
                        'email' => $cekUsers->email,
                        'phone' => $cekUsers->handphone,
                    ],
                    'shipping_address' => [
                        'first_name' => $cekUsers->name,
                        'last_name' => '',
                        'email' => $cekUsers->email,
                        'phone' => $cekUsers->handphone,
                    ],
                ]);

                $this->initMidtrans();
                $paymentGateway = CoreApi::charge($paramMidtrans);

                $expired = $paymentGateway->expiry_time;

                switch ($cekRekening->group) {
                    case 'e_money':
                        switch ($cekRekening->token) {
                            case 'shopeepay':
                                $qrcode = $paymentGateway->actions[0]->url;
                                $deeplinks = $paymentGateway->actions[0]->url;
                                break;
                            default:
                                $qrcode = $paymentGateway->actions[0]->url;
                                $deeplinks = $paymentGateway->actions[1]->url;
                                break;
                        }
                        break;
                    default:
                        switch ($cekRekening->token) {
                            case 'echannel':
                                $billcode = $paymentGateway->biller_code;
                                $vaNumber = $paymentGateway->bill_key;
                                break;
                            case 'permata':
                                $vaNumber = $paymentGateway->permata_va_number;
                                break;
                            default:
                                $vaNumber = $paymentGateway->va_numbers[0]->va_number;
                                break;
                        }
                        break;
                }

                $dataArray = [
                    'bill_code' => $billcode,
                    'va_number' => $vaNumber,
                    'qr_code' => $qrcode,
                    'deep_links' => $deeplinks,
                    'expired' => $expired,
                    'response_donasi' => json_encode($paymentGateway),
                ];
                break;
        }

        $data = array_merge($request->all(), $dataArray, [
            'no_transaksi' => $notransaksi,
            'hamba_allah' => $request->hambaallah ? 'Y' : 'N',
            'keterangan' => $request->keterangan_donasi,
            'user_id' => $cekUsers->id,
        ]);

        $donations = Donation::create($data);
        $donationsResource = DonationResource::make($donations);

        return $this->sendResponse($donationsResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        $donationsResource = DonationResource::make($donation);
        return $this->sendResponse($donationsResource, 'Get Data Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDonationRequest $request, Donation $donation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        //
    }

    public function payments(string $notransaksi)
    {
        return $notransaksi;
    }
}
