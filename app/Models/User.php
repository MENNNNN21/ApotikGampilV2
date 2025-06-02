<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'email',
        'no_hp',
        'password',
        'alamat',
        'gambar',
    ];

    public function cart(){
        return $this->hasMany(Cart::class, 'user_id', 'id');
    }

}