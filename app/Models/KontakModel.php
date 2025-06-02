<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KontakModel extends Model
{
    use HasFactory;
    protected $table = 'saran';
    protected $fillable = [
        'nama',
        'email',
        'pesan',
    ];
}
