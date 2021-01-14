<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mailer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The data object instance.
     *
     * @var Data
     */
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->from('sender@example.com')
        //             ->view('mails.demo')
        //             ->text('mails.demo_plain')
        //             ->with(
        //               [
        //                     'testVarOne' => '1',
        //                     'testVarTwo' => '2',
        //               ])
        //               ->attach(public_path('/images').'/demo.jpg', [
        //                       'as' => 'demo.jpg',
        //                       'mime' => 'image/jpeg',
        //               ]);
    }
}
