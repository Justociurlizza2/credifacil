<?php
namespace App\Factory\MailFactory;
use App\Factory\MailFactory\GmailService;

class GmailFactory extends MailFactory
{
    private String $name;
    private String $subject;
    private Array $emails;
    public function __construct(string $name, string $subject, Array $emails)
    {
        $this->name    = $name;
        $this->subject = $subject;
        $this->emails  = $emails;
    }

    public function getOriginMailer(): Mailer
    {
        return new GmailService($this->name, $this->subject, $this->emails);
    }
}