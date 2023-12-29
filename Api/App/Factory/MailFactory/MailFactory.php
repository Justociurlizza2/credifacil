<?php
namespace App\Factory\MailFactory;
use App\public\Template\Template;

abstract Class MailFactory {
    abstract public function getOriginMailer(): Mailer;
    static public function send (Template $template, MailFactory $mailFactory) : string {
        // Call the factory method to create a Mailer object...
        $mailFactory = $mailFactory ->getOriginMailer();
        $mailFactory -> getBody($template);
        $r = $mailFactory->sendMessage();
        return $r;
    }   
}