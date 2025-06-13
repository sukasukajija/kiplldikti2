<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PencairanToAdminNotification extends Notification
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
        $perguruantinggi = $this->pencairan->mahasiswa->perguruantinggi->nama_pt;
        $periode = $this->pencairan->periode;

        $str = '';

        if($this->pencairan->tipe_pencairan == 'ajukan') {
            $str = 'Pencairan Awal';
        } elseif($this->pencairan->tipe_pencairan == 'pembatalan' && $this->pencairan->tipe_pengajuan_id == 1) {
            $str = 'Pembatalan Pencairan Awal';
        } elseif($this->pencairan->tipe_pencairan == 'pembatalan' && $this->pencairan->tipe_pengajuan_id == 2) {
            $str = 'Pembatalan Ongoing';
        } elseif($this->pencairan->tipe_pencairan == 'kelulusan') {
            $str = 'Kelulusan Ongoing';
        } else {
            $str = 'Pencairan Ongoing';
        }


        return [
            'title' => "{$str}!",
            'message' => "'{$str}' mahasiswa '{$namaMahasiswa}' untuk perguruan tinggi '{$perguruantinggi}' telah {$status} pada periode {$periode->tahun} {$periode->semester}.",
        ];
    }
}