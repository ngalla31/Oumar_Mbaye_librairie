<?php

namespace App\Mail;
use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatutCommandeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $commande;
    /**
     * Create a new message instance.
     */
    public function __construct(Commande $commande)
    {
        //
        $this->commande = $commande;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Statut Commande Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'statut_commande',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
    public function build()
    {
        $statut = $this->commande->status === 'payée' ? 'validée' : 'refusée';

        return $this->subject("Commande {$statut}")
                    ->view('statut_commande')
                    ->with([
                        'nom' => $this->commande->user->nom,
                        'prenom' => $this->commande->user->prenom,
                        'status' => $statut,
                        'commande' => $this->commande
                    ]);
    }
}
