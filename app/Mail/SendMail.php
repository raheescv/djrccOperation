<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $email;
    public $from;
    public $address;
    public $site_name;
    public function __construct($data)
    {
        $this->site_name= config('settings.site');
        $this->from_email  = $data['from'];
        $this->email    = $data['from'];
        $this->name     = $data['name'];
        $this->message  = $data['message'];
        $this->subject  = $data['subject'];
        $this->address  = $data['from'];
    }
    public function build()
    {
        $data['site_name']        =$this->site_name;
        $data['name']             =$this->name;
        $data['from']             =$this->from_email;
        $data['message']          =$this->message;
        $data['address']          =$this->from;
        $data['subject']          =$this->subject;
        return $this->view('emails.SendMail')->with('data',$data);
    }
}
