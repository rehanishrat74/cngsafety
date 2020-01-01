<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;
public $user,$msg;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$msg)
    {
        //
        $this->user=$user;
        $this->msg=$msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->view('email.welcome',['user'=>$this->user,'msg'=>$this->msg] );
    }
}
