<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPo extends Model
{
    protected $table = 'detail_po';

    // Composite primary key — Laravel tidak native support,
    // kita nonaktifkan auto-increment dan handle manual
    public $incrementing = false;
    protected $primaryKey = null; // composite key
    public $timestamps = false;

    protected $fillable = [
        'no_order',
        'idbarang',
        'wrn',
        'pcs_krg',
        'jmlh_krg',
        'total_pcs',
        'kg_krg',
        'total_kg',
        'jumlah_harga',
    ];

    protected $casts = [
        'pcs_krg'      => 'integer',
        'jmlh_krg'     => 'integer',
        'total_pcs'    => 'integer',
        'kg_krg'       => 'integer',
        'total_kg'     => 'integer',
        'jumlah_harga' => 'decimal:0',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'no_order', 'no_order');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'idbarang', 'idbarang');
    }
}
