<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table      = 'invoice';
    protected $primaryKey = 'no_invoice';
    public    $incrementing = false;
    protected $keyType    = 'string';
    public    $timestamps = false;

    protected $fillable = [
        'no_invoice',
        'idpetugas_admin',
        'no_order',
        'tgl_invoice',
        'subtotal',
        'ppn',
        'dpp',
        'total',
    ];

    protected $casts = [
        'tgl_invoice' => 'date',
        'subtotal'    => 'decimal:0',
        'ppn'         => 'decimal:0',
        'dpp'         => 'decimal:0',
        'total'       => 'decimal:0',
    ];

    // ─── Relasi ────────────────────────────────────────────────────────────────

    /** Petugas yang membuat invoice */
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'idpetugas_admin', 'idpetugas');
    }

    /** Daftar no_order yang terhubung melalui tabel detail_invoice */
    public function detailInvoices()
    {
        return $this->hasMany(DetailInvoice::class, 'no_invoice', 'no_invoice');
    }

    /** Purchase Order utama (kolom no_order di tabel invoice) */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'no_order', 'no_order');
    }
}
