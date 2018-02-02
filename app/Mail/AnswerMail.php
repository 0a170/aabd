<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AnswerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title, $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($body)
    {
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('askaboredguy@gmail.com')
        ->view('email.sendanswer')
        ->subject("A bored guy has answered your question!");
    }
}
