<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    /**
     * Tabel yang digunakan model ini.
     * Sesuai tabel native: barang
     */
    protected $table = 'barang';

    /**
     * Primary key kustom (bukan 'id' default Laravel).
     * Tipe string karena format: BR-XXX
     */
    protected $primaryKey = 'idbarang';
    public    $incrementing = false;
    protected $keyType      = 'string';

    /**
     * Kolom yang boleh diisi massal (mass assignment).
     * Sesuai kolom tabel: idbarang, ukuran, ukuran_tamu, harga
     */
    protected $fillable = [
        'idbarang',
        'ukuran',
        'ukuran_tamu',
        'harga',
    ];

    /**
     * Cast otomatis tipe data.
     */
    protected $casts = [
        'harga' => 'decimal:2',
    ];

    // ── Relasi ────────────────────────────────────────────────────
    // Uncomment jika model DetailPo sudah ada
    // public function detailPo()
    // {
    //     return $this->hasMany(DetailPo::class, 'idbarang', 'idbarang');
    // }
}
