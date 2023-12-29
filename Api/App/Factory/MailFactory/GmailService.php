<?php
namespace App\Factory\MailFactory;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use App\public\Template\Template;

class GmailService implements Mailer {
    private String $message;
    private String $name;
    private String $subject;
    private Array $emails;
    public function __construct ($name, $subject, $emails) 
    {
        $this->name    = $name;
        $this->subject = $subject;
        $this->emails  = $emails;
    }
    public function sendMessage() : string
    {
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail ->IsHTML(true);
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'justociurlizza2@gmail.com';
        $mail->Password = 'qhcaoquoqlgbkmbu';
        $mail->Port = 465;
        $mail->AddEmbeddedImage(dirname(dirname(dirname(__FILE__)))."/public/img/goolem.jpeg", "goolem");
        $mail->setFrom("justociurlizza2@gmail.com", "Golem, Wiedens Factory");
    
        $mail->Subject = "Hi ".$this->name." - ".$this->subject;
        $mail->msgHTML($this->message);
        foreach ($this->emails as $key => $email) $mail->addAddress($email);
        $send = $mail->Send();
        
        if(!$send) return $mail->ErrorInfo;
        else       return "ok";
    }
    public function getBody ($body) : void
    {
        $this-> message = $body->getBody();
    }
}