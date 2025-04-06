<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouvelleCommandeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $commande;
    public function __construct($commande)
    {
        $this->commande = $commande;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('📦 Nouvelle commande reçue')
        ->greeting('Bonjour Gestionnaire,')
        ->line('Une nouvelle commande a été passée.')
        ->line('Commande #'.$this->commande->id.' - Montant total : '.number_format($this->commande->prixTotal, 0, ',', ' ').' FCFA')
        ->action('Voir les commandes', url('/gestion/commandes'))
        ->line('Merci de gérer cette commande rapidement.');

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
