<?php


namespace App\Subscriber\UserSaved;


use App\Event\UserSavedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UpdateEmailFileWhenUserIsSaved implements EventSubscriberInterface
{

    /**
     * S'enregistre au près de l'event
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            UserSavedEvent::NAME => "onUserSaved"
        ];
    }

    /**
     * On suppose que l'on stocké tous les email des nouveaux utilisateurs dans
     * un fichiers text, pour faire du mailling par exemple
     *
     * @param UserSavedEvent $event
     */
    public function onUserSaved(UserSavedEvent $event)
    {
        $f = fopen(__DIR__ . "../../../../email.txt", "a");
        fwrite($f, $event->getUser()->getEmail() . ">>>");
        fclose($f);
    }
}