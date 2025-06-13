<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodePenetapan extends Model
{
    use HasFactory;
    protected $fillable = [
        'is_active',
        'tahun',
        'semester',
        'tanggal_dibuka',
        'tanggal_ditutup',
    ];

    protected $table = 'periode_penetapan';
}