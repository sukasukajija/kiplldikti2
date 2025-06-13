<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodePenetapanPerguruanTinggi extends Model
{
    use HasFactory;

    
    protected $table = 'periode_penetapan_perguruan_tinggis';

    protected $fillable = [
        'perguruan_tinggi_id',
        'periode_penetapan_id',
        'file_ba',
        'file_sptjm',
        'file_sk',
    ];

    public function perguruantinggi()
    {
        return $this->belongsTo(Perguruantinggi::class, 'perguruan_tinggi_id');
    }

    public function periodePenetapan()
    {
        return $this->belongsTo(PeriodePenetapan::class, 'periode_penetapan_id');
    }
}