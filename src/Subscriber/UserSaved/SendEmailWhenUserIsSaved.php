<?php


namespace App\Subscriber\UserSaved;


use App\Event\UserSavedEvent;
use App\Service\Mailer\Mailer;
use NotFloran\MjmlBundle\Renderer\BinaryRenderer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;

class SendEmailWhenUserIsSaved implements EventSubscriberInterface
{

    /**
     * @var Mailer
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

    public function __construct(Mailer $mailer, BinaryRenderer $mjmlRender, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->mjmlRender = $mjmlRender;
        $this->twig = $twig;
    }

    /**
     * @return array Representant la liste des event ecoute, associe au nom d'une function
     */
    public static function getSubscribedEvents()
    {
        return [
            UserSavedEvent::NAME => 'onUserSaved'
        ];
    }

    /**
     * Envoi un email de bienvenue a l'utilisateur lors de son inscription
     * @param UserSavedEvent $event
     */
    public function onUserSaved(UserSavedEvent $event)
    {
        $user = $event->getUser();

        $email = $this->mailer->createEmail();
        $email
            ->subject('Merci pour votre inscription au Labo_02 !')
            ->to($user->getEmail())
            ->renderView("emails/welcome.mjml.twig", ['user' => $user]);

        $this->mailer->send($email);
    }
}