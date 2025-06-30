<?php

namespace App\Notifications;

use App\Models\Conge;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CongeStatusNotification extends Notification
{
    use Queueable;

    public $conge;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Conge $conge)
    {
        $this->conge = $conge;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $status = $this->conge->statut;
        $message = "Votre demande de congé du {$this->conge->date_debut} au {$this->conge->date_fin} a été {$status}.";

        return [
            'conge_id' => $this->conge->id,
            'message' => $message,
            'url' => route('employes.conge.index'),
        ];
    }
}
