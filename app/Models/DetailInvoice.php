<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailInvoice extends Model
{
    protected $table    = 'detail_invoice';
    public $timestamps  = false;
    public $incrementing = false;

    protected $fillable = ['no_invoice', 'no_order'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'no_invoice', 'no_invoice');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'no_order', 'no_order');
    }
}
