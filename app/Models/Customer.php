<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table      = 'customer';
    protected $primaryKey = 'idcustomer';
    public    $keyType    = 'string';
    public    $incrementing = false;

    public $timestamps = false;

    protected $fillable = ['idcustomer', 'kepada_yth', 'alamat'];
}
