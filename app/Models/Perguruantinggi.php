<?php

namespace App\Models;

use App\Models\User;
use App\Models\peserta;
use App\Models\Programstudi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perguruantinggi extends Model
{
    use HasFactory;
    protected $table = 'perguruan_tinggi';

    protected $primaryKey = 'id';
    protected $fillable = [
        'kode_pt',
        'nama_pt',
        'klaster_id',
        'no_rekening_bri',
        'created_at',
        'updated_at'
    ];

    public function programstudi()
    {
        return $this->hasMany(Programstudi::class, 'kode_pt', 'kode_pt');
    }

    

   public function file()
   {
      return $this->hasMany(PeriodePenetapanPerguruanTinggi::class, 'perguruan_tinggi_id', 'id');
   }
    public function klaster()
    {
        return $this->belongsTo(KlasterWilayah::class, 'klaster_id', 'id');
    }
    public function user()
    {
        return $this->hasMany(User::class, 'pt_id', 'id');
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'perguruan_tinggi_id', 'id');
    }
}