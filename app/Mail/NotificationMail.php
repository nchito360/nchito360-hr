<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $messageBody;
    public $buttonText;
    public $buttonUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(string $subjectLine, string $messageBody, string $buttonText = null, string $buttonUrl = null)
    {
        $this->subjectLine = $subjectLine;
        $this->messageBody = $messageBody;
        $this->buttonText = $buttonText;
        $this->buttonUrl = $buttonUrl;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('emails.notification');
    }
}
