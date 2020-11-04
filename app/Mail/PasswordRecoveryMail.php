<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordRecoveryMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $email;
    public $site_name;
    public function __construct($data)
    {
        $this->site_name         = config('settings.site');
        $this->from_email        = config('settings.from_email');
        $this->from_name         = config('settings.from_name');
        $this->resetPasswordLink = $data['resetPasswordLink'];
    }
    public function build()
    {
        $data['name']             =$this->name;
        $data['email']            =$this->email;
        $data['resetPasswordLink']=$this->resetPasswordLink;
        return $this->view('emails.passwordRecovery')->with('data',$data);
    }
}
