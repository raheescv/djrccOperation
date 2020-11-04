<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Mail\PasswordRecoveryMail;
use App\Mail\SendMail;
use Mail;
class MailController extends Controller
{
  public function basic_email() {
    $data = array('name'=>"Virat Gandhi");
    Mail::send(['text'=>'emails.email'], $data, function($message) {
      $message->to('raheescv1992@yahoo.com', 'Tutorials Point')->subject
      ('Laravel Basic Testing Mail');
      $message->from('raheescv1992@gmail.com','Virat Gandhi');
    });
    echo "Basic Email Sent. Check your inbox.";
  }
  public function SendMail($data) {
    Mail::to($data['to'])->send(new SendMail($data));
    return ['result' => 'success'];
  }
  public function html_email() {
    $data = array('name'=>"Virat Gandhi");
    Mail::send('mail', $data, function($message) {
      $message->to('abc@gmail.com', 'Tutorials Point')->subject
      ('Laravel HTML Testing Mail');
      $message->from('xyz@gmail.com','Virat Gandhi');
    });
    echo "HTML Email Sent. Check your inbox.";
  }
  public function attachment_email() {
    $data = array('name'=>"Virat Gandhi");
    Mail::send('mail', $data, function($message) {
      $message->to('abc@gmail.com', 'Tutorials Point')->subject
      ('Laravel Testing Mail with Attachment');
      $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
      $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
      $message->from('xyz@gmail.com','Virat Gandhi');
    });
    echo "Email Sent with attachment. Check your inbox.";
  }
  public function passwordRecoveryMail($User)
  {
    $data['email']  = $User->email;
    $data['name']   = $User->name;
    $data['user_id']= $User->id;
    $data['mobile'] = '+'.$User->country_code.$User->mobile;
    $data['resetPasswordLink'] = url('PasswordChange',$data['user_id']);
    Mail::to('raheescv1992@gmail.com')->send(new PasswordRecoveryMail($data));
    return ['result' => 'success'];
  }
}
