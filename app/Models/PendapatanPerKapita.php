<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendapatanPerKapita extends Model
{
    use HasFactory;


    protected $fillable = [
        'keterangan',
        'max_pendapatan',
        'min_pendapatan',
    ];
}