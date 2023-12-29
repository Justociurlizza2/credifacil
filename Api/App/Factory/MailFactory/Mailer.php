<?php
namespace App\Factory\MailFactory;

interface Mailer
{
    public function sendMessage(): string;
    public function getBody($body): void;
}