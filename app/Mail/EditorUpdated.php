<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EditorUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
     public $editor;
    public function __construct($editor)
    {
        $this->editor = $editor;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Editor Updated',
        );
    }

    /**
     * Get the message content definition.
     */
public function build()
{
    return $this->subject('Profile Updated Notification')
                ->view('emails.editor.editor_updated') 
                ->with([
                    'editorName' => $this->editor->name,
                    'editorEmail' => $this->editor->email,
                    'institutionName' => 'AB School & College',
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
