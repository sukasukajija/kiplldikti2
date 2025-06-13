<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaHistory extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa_history';
    protected $fillable = ['mahasiswa_id', 'status', 'alasan', 'changed_at'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function periode()
    {
        return $this->belongsTo(PeriodePenetapan::class);
    }
}
