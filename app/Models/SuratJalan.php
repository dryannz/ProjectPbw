<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratJalan extends Model
{
    protected $table = 'surat_jalan';
    protected $primaryKey = 'no_surat';
    public $incrementing = false;
    protected $keyType = 'string';
    public    $timestamps = false;

    protected $fillable = [
        'no_surat',
        'no_invoice',
        'idpetugas_admin',
        'idpetugas_warehouse',
        'idpetugas_driver',
        'tgl_surat',
        'subtotal',
    ];

    protected $casts = [
        'tgl_surat' => 'date',
        'subtotal'  => 'decimal:2',
    ];

    // Relasi ke petugas
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'idpetugas_admin', 'idpetugas');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'idpetugas_warehouse', 'idpetugas');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'idpetugas_driver', 'idpetugas');
    }

    // Detail surat jalan (pivot ke invoice)
    public function details(): HasMany
    {
        return $this->hasMany(DetailSuratJalan::class, 'no_surat', 'no_surat');
    }
}
