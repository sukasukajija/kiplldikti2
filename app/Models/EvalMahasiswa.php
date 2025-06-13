<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvalMahasiswa extends Model
{
    use HasFactory;


    protected $fillable = [
        'gpa', 
        'semester',
        'mahasiswa_id',
        'periode_id',
        'file_transkrip',
        'file_ba',
        'pendapatan_id',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function pendapatan()
    {
        return $this->belongsTo(PendapatanPerKapita::class);
    }
}