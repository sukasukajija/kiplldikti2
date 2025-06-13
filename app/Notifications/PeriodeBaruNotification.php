<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PeriodeBaruNotification extends Notification
{
    use Queueable;

    public function __construct(public $periode)
    {
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Periode Baru Dibuka',
            'message' => "Periode {$this->periode->semester} {$this->periode->tahun} telah dibuka.",
        ];
    }
}

