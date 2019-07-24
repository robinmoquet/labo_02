<?php


namespace App\Service;


use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\NamedAddress;

class Mailer
{
    public function createEmail (): Email
    {
        $email = (new Email())
            ->from(new NamedAddress('robin.moquet@gmail.com', 'Labo_02'));
    }
}