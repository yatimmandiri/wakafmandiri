<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'no_transaksi',
        'quantity',
        'nominal_donasi',
        'unik_nominal',
        'keterangan',
        'bill_code',
        'va_number',
        'qr_code',
        'deep_links',
        'response_donasi',
        'referals',
        'shohibul',
        'status',
        'hamba_allah',
        'sync',
        'expired',
        'user_id',
        'campaign_id',
        'rekening_id',
    ];

    public function campaigns()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function rekenings()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id');
    }

    
}
