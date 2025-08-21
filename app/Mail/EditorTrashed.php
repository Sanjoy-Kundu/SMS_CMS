<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EditorTrashed extends Mailable
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
            subject: 'Editor Trashed',
        );
    }

    /**
     * Get the message content definition.
     */
        public function build()
        {
            return $this->subject('Account Suspended - AB School & College')
                        ->view('emails.editor.editor_trashed')
                        ->with([
                            'editorName' => $this->editor->user->name,
                            'editorEmail' => $this->editor->user->email,
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
