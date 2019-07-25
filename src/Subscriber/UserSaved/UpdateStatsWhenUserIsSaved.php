<?php

namespace App\Subscriber\UserSaved;


use App\Entity\StatsUser;
use App\Event\UserSavedEvent;
use App\Repository\RepositoryInterface\StatsUserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UpdateStatsWhenUserIsSaved implements EventSubscriberInterface
{

    /**
     * @var StatsUserRepository
     */
    private $statsUserRepository;

    public function __construct(StatsUserRepository $statsUserRepository)
    {
        $this->statsUserRepository = $statsUserRepository;
    }

    /**
     * La liste de event ecoutes
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            UserSavedEvent::NAME => "onUserSaved"
        ];
    }

    /**
     * On suppose vouloir stocke des stats sur l'utilisation de la
     * platform par l'utilisateur
     *
     * @param UserSavedEvent $event
     * @throws \Exception
     */
    public function onUserSaved(UserSavedEvent $event)
    {
        $statsUser = (new StatsUser())
            ->setUser($event->getUser())
            ->setCreateAt(new \DateTime());

        $this->statsUserRepository->add($statsUser);
    }
}