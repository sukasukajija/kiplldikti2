<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengajuanDiprosesNotification extends Notification
{
    use Queueable;

    public function __construct(public $pengajuan)
    {
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $namaMahasiswa = $this->pengajuan->mahasiswa->name;
        $status = $this->pengajuan->status;

        return [
            'title' => 'Status Pengajuan Mahasiswa',
            'message' => "Pengajuan mahasiswa '{$namaMahasiswa}' telah $status.",
        ];
    }
}
