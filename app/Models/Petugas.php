<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model Petugas
 *
 * Kolom tabel native: idpetugas, namapetugas, jabatan, ttdpetugas
 *
 * Model ini sekaligus digunakan sebagai User untuk autentikasi Laravel.
 * Daftarkan di config/auth.php:
 *   'providers' => ['users' => ['driver' => 'eloquent', 'model' => App\Models\Petugas::class]]
 */
class Petugas extends Authenticatable
{
    use Notifiable;

    protected $table      = 'petugas';
    protected $primaryKey = 'idpetugas';

    // PK bertipe string (format: P-XXX), bukan auto-increment
    public    $incrementing = false;
    protected $keyType      = 'string';

    protected $fillable = [
        'idpetugas',
        'namapetugas',
        'jabatan',
        'ttdpetugas',  // nama file tanda tangan (disimpan di storage)
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ── Accessor: path lengkap file TTD ──────────────────────────────
    /**
     * Kembalikan URL publik tanda tangan, atau null jika tidak ada.
     * Gunakan di Blade: {{ $petugas->ttd_url }}
     */
    public function getTtdUrlAttribute(): ?string
    {
        return $this->ttdpetugas
            ? asset('storage/ttd/' . $this->ttdpetugas)
            : null;
    }

    // ── Accessor: inisial nama (maks 2 karakter) ─────────────────────
    /**
     * Gunakan di Blade: {{ $petugas->inisial }}
     */
    public function getInisialAttribute(): string
    {
        $gabung = collect(explode(' ', trim($this->namapetugas)))
            ->map(fn($k) => strtoupper(substr($k, 0, 1)))
            ->implode('');

        return substr($gabung, 0, 2);
    }

    // ── Relasi ────────────────────────────────────────────────────────
    // Uncomment jika model PurchaseOrder sudah ada
    // public function purchaseOrders()
    // {
    //     return $this->hasMany(PurchaseOrder::class, 'idpetugas', 'idpetugas');
    // }
}
