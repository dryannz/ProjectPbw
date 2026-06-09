<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPO extends Model
{
    use HasFactory;

    protected $table = 'detail_po';

    protected $fillable = [
        'no_order',
        'idbarang',
        'wrn',
        'pcs_krg',
        'jmlh_krg',
        'total_pcs',
        'kg_krg',
        'total_kg',
        'jumlah_harga'
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