<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;


    protected $fillable = [
        'mahasiswa_id',
        'operator_id',
        'periode_id',
        'tipe_pengajuan_id',
        'status',
        'remarks',
        'file_sk',
        'file_sptjm'
    ];
   

    protected $table = 'pengajuan';
    protected $guarded =  '';

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    public function periode(){
        return $this->belongsTo(PeriodePenetapan::class, 'periode_id', 'id');
    }

    public function tipePengajuan(){
        return $this->belongsTo(TipePengajuan::class, 'tipe_pengajuan_id','id');
    }

    public function operator()
   {
      return $this->belongsTo(User::class, 'operator_id');
   }

   public function pencairan()
   {
      return $this->hasMany(Pencairan::class);
   }

}