<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencairan extends Model
{
    use HasFactory;

    protected $table = 'pencairans';

    protected $fillable = [
        'mahasiswa_id',
        'operator_id',
        'periode_id',
        'status',
        'tipe_pengajuan_id',
        'keterangan',
        'no_sk',
        'tanggal_sk',
        'tipe_pencairan',
        'file_sptjm',
        'file_sk',
        'file_ba',
        'file_lampiran',
        'dokumen_penolakan',
        'dokumen_pendukung',
        'keterangan_penolakan',
        'alasan_pembatalan_id',
    ];


    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function periode()
    {
        return $this->belongsTo(PeriodePenetapan::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class);
    }

    public function tipe_pengajuan()
    {
        return $this->belongsTo(TipePengajuan::class);
    }

    public function alasanPembatalan(){
        return $this->belongsTo(AlasanPembatalan::class);
    }
}