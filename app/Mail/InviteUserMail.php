<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inviteeName;
    public $inviteLink;
    protected $fromEmail;
    protected $fromName;

    public function __construct($inviteeName, $inviteLink,  $fromEmail, $fromName)
    {
        $this->inviteeName = $inviteeName;
        $this->inviteLink = $inviteLink;
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
    }

    public function build()
    {
        return $this->from($this->fromEmail, $this->fromName)
            ->view('emails.invite')
            ->subject('You’re Invited!')
            ->with([
                'inviteeName' => $this->inviteeName,
                'inviteLink' => $this->inviteLink,
            ]);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    // public function envelope()
    // {
    //     return new Envelope(
    //         subject: 'Invite User Mail',
    //     );
    // }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    // public function content()
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    // public function attachments()
    // {
    //     return [];
    // }
}
