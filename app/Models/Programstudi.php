<?php

namespace App\Models;

use App\Models\peserta;
use App\Models\Perguruantinggi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Programstudi extends Model
{
    use HasFactory;
    protected $table = 'program_studi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_prodi',
        'akreditasi',
        'created_at',
        'updated_at'
    ];

    public function perguruantinggi()
    {
        return $this->belongsTo(Perguruantinggi::class, 'kode_pt', 'kode_pt');
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'program_studi_id', 'id');
    }
}