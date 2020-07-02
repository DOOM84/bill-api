<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPass extends Mailable
{
    protected $pass;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pass)
    {
        $this->pass = $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        return $this->markdown('SendMail.pass', [
            'pass' => $this->pass,
            'email' => $request->email,
        ])->subject('Password reset')
            ->to($request->email)->from(env('MAIL_ADMIN'), env('APP_NAME'));
    }
}
