<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable implements ShouldQueue
{

    public $view;
    public $data;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($view, $data, $subject)
    {
        $this->view = $view;
        $this->data = $data;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->view)
                    ->subject($this->subject)
                    ->with([
                        'data' => $this->data,
                        'subject' => $this->subject,
                    ]);
    }
}
