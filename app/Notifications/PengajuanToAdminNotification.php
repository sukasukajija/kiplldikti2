<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PengajuanToAdminNotification extends Notification
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
        $perguruantinggi = $this->pengajuan->mahasiswa->perguruantinggi->nama_pt;

        return [
            'title' => 'Pengajuan Baru!',
            'message' => "Pengajuan mahasiswa '{$namaMahasiswa}' untuk perguruan tinggi '{$perguruantinggi}' telah {$status}.",
        ];
    }
}