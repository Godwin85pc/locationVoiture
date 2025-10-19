<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VehiculeValideMail extends Mailable
{
    use Queueable, SerializesModels;
 public $vehicule;
    /**
     * Create a new message instance.
     */
    public function __construct(Vehicule $vehicule)
    {
         $this->vehicule = $vehicule;
    }
    public function build()
    {
        return $this->subject('Votre véhicule est validé !')
                    ->view('emails.vehicule_valide');
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vehicule Valide Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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

   



   
}
