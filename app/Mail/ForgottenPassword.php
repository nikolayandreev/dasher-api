<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ForgottenPassword extends Mailable
{
    use Queueable, SerializesModels;


    protected $user;
    protected $token;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->token = $this->fetchToken();
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Възстанови паролата си в Dasher')
            ->view('emails.auth.forgot-password')
            ->text('emails.auth.forgot-password-text')->with([
                'name' => $this->user->first_name,
                'link' => env('SITE_URL') . '/reset-password/' . $this->token
            ]);
    }

    private function fetchToken()
    {
        return DB::table('password_resets')
            ->where('email', $this->user->email)
            ->first()->token;
    }
}
