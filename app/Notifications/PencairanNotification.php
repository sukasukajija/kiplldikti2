<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PencairanNotification extends Notification
{
    use Queueable;

    public function __construct(public $pencairan)
    {
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $namaMahasiswa = $this->pencairan->mahasiswa->name;
        $status = $this->pencairan->status;
        $tipePencairan = $this->pencairan->tipe_pencairan;
        $tipePengajuanId = $this->pencairan->tipe_pengajuan_id;

        $periode = $this->pencairan->periode;

        if($tipePencairan == 'ajukan') {
            $str = 'Pencairan Baru';
        } elseif($tipePencairan == 'penetapan_kembali') {
            $str = 'Pencairan Kembali';
        } else if ($tipePencairan == 'kelulusan') {
            $str = 'Pencairan Kelulusan Ongoing';
        } else {
            $str = $tipePengajuanId == 1 ? 'Pencairan Pembatalan Awal' : 'Pencairan Pembatalan Ongoing';
        }

        return [
            'title' => 'Status Pencairan Mahasiswa',
            'message' => "'{$str}' mahasiswa '{$namaMahasiswa}' telah $status pada  periode {$periode->tahun} {$periode->semester}.",
        ];
    }
}
