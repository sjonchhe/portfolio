<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class newProject extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('backend.email.newProject')
                     ->from('sandeshjon@gmail.com','sjonchhe.com.np')
                    ->to('sandeshjon@gmail.com')
                    ->subject('New project added')
                    ->with('content',$this->content);
    }
    }

