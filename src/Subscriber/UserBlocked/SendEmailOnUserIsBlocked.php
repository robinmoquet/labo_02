<?php


namespace App\Subscriber\UserBlocked;


use App\Event\UserBlockedEvent;
use App\Service\Mailer\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SendEmailOnUserIsBlocked implements EventSubscriberInterface
{

    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            UserBlockedEvent::NAME => "onUserBlocked"
        ];
    }

    public function onUserBlocked(UserBlockedEvent $event)
    {
        $user = $event->getUser();

        $email = $this->mailer->createEmail();
        try {
            $email
                ->subject("Compte bloqué")
                ->to($user->getEmail())
                ->renderView("emails/compte-blocked.mjml.twig", ["user" => $user]);

            $this->mailer->send($email);
        } catch (\Error $e) {  }

    }
}