<?php


namespace App\Listener;


use App\Event\UserSaved;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SendEmailWhenUserIsSaved implements EventSubscriberInterface
{

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            UserSaved::NAME => 'onUserSaved'
        ];
    }

    public function onUserSaved(UserSaved $event)
    {
        $fp = fopen('lgo.txt', 'w');
        fwrite($fp, $event->getUser()->getEmail());
        fclose($fp);
    }
}