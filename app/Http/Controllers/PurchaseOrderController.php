// app/Models/PurchaseOrder.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $table = 'purchase_orders';
    protected $primaryKey = 'no_order';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_order',
        'idcustomer',
        'tgl_order',
        'schedule_delivery',
        'total'
    ];

    protected $casts = [
        'tgl_order' => 'date',
        'schedule_delivery' => 'date',
        'total' => 'decimal:2'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'idcustomer', 'idcustomer');
    }

    public function details()
    {
        return $this->hasMany(DetailPO::class, 'no_order', 'no_order');
    }
}