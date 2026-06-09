<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_order';
    protected $primaryKey = 'no_order';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'no_order',
        'idcustomer',
        'tgl_order',
        'schedule_delivery',
    ];

    protected $casts = [
        'tgl_order'         => 'date',
        'schedule_delivery' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'idcustomer', 'idcustomer');
    }

    public function details()
    {
        return $this->hasMany(DetailPo::class, 'no_order', 'no_order');
    }
}
