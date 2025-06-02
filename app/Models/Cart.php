<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ObatModel as Obat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Cart extends Model

{
use HasFactory;
protected $table = 'carts';
protected $fillable = [
    'user_id', 'produk_id', 'jumlah'
];
   public function obat()
{
    return $this->belongsTo(Obat::class, 'produk_id');
}

}
