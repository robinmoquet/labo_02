<?php


namespace App\Service\Mailer;

use NotFloran\MjmlBundle\Renderer\BinaryRenderer;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\NamedAddress;
use Twig\Environment;

class Mailer
{
    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var BinaryRenderer
     */
    private $mjmlRender;
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(MailerInterface $mailer, BinaryRenderer $mjmlRender, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->mjmlRender = $mjmlRender;
        $this->twig = $twig;
    }

    /**
     * Initialize un object de type Email, et set les valeurs globals
     * La class Email, permet de gerer le rendu de la vue avec une compilation mjml
     * et des params twig
     *
     * @return Email
     */
    public function createEmail (): Email
    {
        $email = (new Email($this->mjmlRender, $this->twig))
            ->from(new NamedAddress('robin.moquet@gmail.com', 'Labo_02'));

        return $email;
    }

    /**
     * Envoi l'email
     * @param Email $email
     */
    public function send(Email $email): void
    {
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $exception) { /* Logging de l'erreur */ }
    }
}