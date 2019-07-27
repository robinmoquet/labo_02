<?php


namespace App\Subscriber\Authentication;


use App\Entity\User;
use App\Service\Mailer\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class SendEmailOnAuthentication implements EventSubscriberInterface
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
    public static function getSubscribedEvents(): array
    {
        return [
            AuthenticationEvents::AUTHENTICATION_SUCCESS => "onAuthenticate"
        ];
    }

    /**
     * Envoi un email pour specifier qu'une connection a eu lieu
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticate(AuthenticationSuccessEvent $event): void
    {
        /** @var User $user */
        $user = $event->getAuthenticationToken()->getUser();

        if($user instanceof User) {
            if($user->getStatsUser()->getBlocked()) return;

            $email = $this->mailer->createEmail();
            try {
                $email
                    ->subject("Une connection à eu lieu")
                    ->to($user->getEmail())
                    ->renderView("emails/connection.mjml.twig", ['user' => $user]);

                $this->mailer->send($email);
            } catch (\Error $e) {  }

        }
    }
}