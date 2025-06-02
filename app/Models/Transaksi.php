<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ObatModel as Obat;


class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_harga',
        'status_pembayaran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
        return $this->belongsTo(Obat::class);
    }
}
