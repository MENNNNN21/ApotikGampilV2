<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Pastikan ini ada jika Anda menggunakan factories

class ObatModel extends Model
{
    use HasFactory; // Tambahkan ini jika Anda menggunakan factories untuk model ini

    protected $table = 'obats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 'id', // Umumnya, primary key (id) tidak perlu dibuat fillable jika auto-increment.
                 // Laravel akan menanganinya secara otomatis.
        'nama',
        'kategori',
        'stok',
        'harga',
        'deskripsi',
        'gambar',
        'expired_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expired_at' => 'date', // Mengubah 'expired_at' menjadi objek Carbon (tanggal)
        // Anda bisa menambahkan cast lain di sini jika perlu, contoh:
        // 'harga' => 'decimal:2', // Jika harga perlu presisi desimal
        // 'stok' => 'integer',
    ];

    // Jika primary key Anda bukan 'id', Anda bisa mendefinisikannya di sini:
    // protected $primaryKey = 'nama_kolom_primary_key_anda';

    // Jika primary key Anda bukan auto-incrementing:
    // public $incrementing = false;

    // Jika tipe data primary key Anda bukan integer:
    // protected $keyType = 'string';
    public function scopeStokHampirHabis($query)
    {
        return $query->where('stok', '<=', 5); // Misalnya, jika stok <= 5
    }
}