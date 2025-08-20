<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TeacherTrashedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $teacherName;
    public $teacherEmail;
    public function __construct($teacherName, $teacherEmail)
    {
        $this->teacherName = $teacherName;
        $this->teacherEmail = $teacherEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Teacher Trashed Mail',
        );
    }

    public function build()
    {
        return $this->subject('Your Profile has been Trashed')
                    ->view('emails.teacher_trashed')
                    ->with([
                        'teacherName' => $this->teacherName,
                        'teacherEmail' => $this->teacherEmail,
                    ]);; 
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
