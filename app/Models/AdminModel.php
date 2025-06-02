<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; // Baik untuk dimiliki jika berencana menggunakan notifikasi

class AdminModel extends Authenticatable
{
    use HasFactory, Notifiable; // Menggunakan trait yang diperlukan

    /**
     * Guard yang diasosiasikan dengan model ini.
     * @var string
     */
    protected $guard = 'admin';

    public $rememberTokenName = false;


    /**
     * Nama tabel yang diasosiasikan dengan model.
     * @var string
     */
    protected $table = 'admin'; // Pastikan nama tabel ini sesuai dengan di database Anda

    /**
     * Kunci utama tabel.
     * @var string
     */
    protected $primaryKey = 'id'; // Default Eloquent

    /**
     * Atribut yang bisa diisi secara massal.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username', // Atau 'email' jika login menggunakan email
        'password',
    ];

    /**
     * Atribut yang seharusnya disembunyikan saat serialisasi.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token', // Jika Anda menggunakan fitur "remember me"
    ];

    /**
     * Atribut yang seharusnya di-cast.
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime', // Contoh jika ada
    ];

    /**
     * Mengambil password untuk pengguna (untuk autentikasi).
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    // Jika Anda tidak menggunakan timestamps (created_at, updated_at)
    // public $timestamps = false;
}