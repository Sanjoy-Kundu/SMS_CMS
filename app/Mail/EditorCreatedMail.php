<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EditorCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $password;
    public function __construct($user, $password)
    {
         $this->user = $user;
         $this->password = $password;
    }

    /**
     * Get the message envelope.
     */
        public function build()
    {
        return $this->subject('Your Editor Account Created')
                    ->view('emails.editor_created') // Blade view
                    ->with([
                        'name' => $this->user->name,
                        'email' => $this->user->email,
                        'password' => $this->password,
                        'role'     => $this->user->role,
                    ]);
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
