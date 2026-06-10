<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailSuratJalan extends Model
{
    protected $table = 'detail_surat_jalan';
    public $timestamps  = false;

    protected $fillable = [
        'no_surat',
        'no_invoice',
    ];

    public function suratJalan(): BelongsTo
    {
        return $this->belongsTo(SuratJalan::class, 'no_surat', 'no_surat');
    }
}
