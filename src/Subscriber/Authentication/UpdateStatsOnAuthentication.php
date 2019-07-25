<?php


namespace App\Subscriber\Authentication;


use App\Entity\User;
use App\Repository\RepositoryInterface\StatsUserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class UpdateStatsOnAuthentication implements EventSubscriberInterface
{

    /**
     * @var StatsUserRepository
     */
    private $repository;

    public function __construct(StatsUserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            AuthenticationEvents::AUTHENTICATION_SUCCESS => "onAuthenticateSuccess"
        ];
    }

    /**
     * Met a jours des stats utilisateur apres une connection reussi
     * @param AuthenticationSuccessEvent $event
     * @throws \Exception
     */
    public function onAuthenticateSuccess(AuthenticationSuccessEvent $event): void
    {
        /** @var User $user */
        $user = $event->getAuthenticationToken()->getUser();

        if($user instanceof User) {
            $stats = $user->getStatsUser();

            $nbConnection = $stats->getNbConnection();
            if($nbConnection === null) $nbConnection = 1;

            $stats
                ->setLastConnectionAt(new \DateTime("now"))
                ->setNbConnection($nbConnection);

            $this->repository->save();
        }
    }
}