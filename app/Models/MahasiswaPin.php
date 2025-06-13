<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaPin extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa_pins';

    protected $fillable = [
        'mahasiswa_id',
        'periode_penetapan_id',
        'pin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function periodePenetapan()
    {
        return $this->belongsTo(PeriodePenetapan::class);
    }
}
