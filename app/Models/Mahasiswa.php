<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    public $fillable = [
        'pin',
        'nik',
        'nim',
        'name',
        'email',
        'gpa',
        'alamat',
        'tanggal_lahir',
        'bank_id',
        'no_rekening_bank',
        'nama_rekening_bank',
        'jenis_kelamin',
        'perguruan_tinggi_id',
        'program_studi_id',
        'status_pengajuan',
        'status_pencairan',
        'status_mahasiswa',
        'status_pddikti',
        'no_pendaftaran',
        'no_kk',
        'nik_kepala_keluarga',
        'nisn',
        'status_dtks',
        'status_p3ke',
        'no_kip',
        'no_kks',
        'asal_sekolah',
        'kab_kota_sekolah',
        'provinsi_sekolah',
        'tempat_lahir',
        'no_handphone',
        'nama_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'status_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'status_ibu',
        'jumlah_tanggungan',
        'kepemilikan_rumah',
        'tahun_perolehan',
        'sumber_listrik',
        'luas_tanah',
        'luas_bangunan',
        'sumber_air',
        'mck',
        'jarak_pusat_kota_km',
        'seleksi_penetapan',
        'ukt_spp',
        'ranking_penetapan',
        'semester',
        'skema_bantuan_pembiayaan',
        'prestasi',
        'pendapatan_id',
        'jenis_bantuan_id',
        'tanggal_yudisium',
        'is_visible',
        'periode_id'
    ];
    

    protected $casts = [
    'tanggal_yudisium' => 'date',  // or 'datetime' if you need time
   ];
    


    public function isEvaluated($periode_id)
    {
        return $this->evaluasi()->where('periode_id', $periode_id)->exists();
    }

    public function getGpaForPeriod($periode_id)
    {
        return $this->evaluasi()->where('periode_id', $periode_id)->value('gpa');
    }

    public function getSemesterPeriod($periode_id)
    {
        return $this->evaluasi()->where('periode_id', $periode_id)->value('semester');
    }

    public function getPinLatestAttribute(){
        return $this->periodePenetapan()->limit(1)->lastest()->pivot->pin;
    }

    public function pendapatan(){
        return $this->belongsTo(PendapatanPerKapita::class, 'pendapatan_id', 'id');
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'mahasiswa_id', 'id');
    }

    public function bank (){
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }
    
    public function programstudi(){
        return $this->belongsTo(Programstudi::class, 'program_studi_id', 'id');
    }

    public function perguruantinggi(){
        return $this->belongsTo(Perguruantinggi::class, 'perguruan_tinggi_id','id');
    }

    public function evaluasi(){
        return $this->hasMany(EvalMahasiswa::class);
    }

    public function pencairan(){
        return $this->hasMany(Pencairan::class);
    }
}