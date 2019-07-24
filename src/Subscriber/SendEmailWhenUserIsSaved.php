<?php


namespace App\Subscriber;


use App\Event\UserSavedEvent;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SendEmailWhenUserIsSaved implements EventSubscriberInterface
{
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
        $fp = fopen(__DIR__ . '/log.txt', 'w');
        fwrite($fp, $event->getUser()->getEmail());
        fclose($fp);
    }
}