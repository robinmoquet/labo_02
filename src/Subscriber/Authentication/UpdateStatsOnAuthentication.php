<?php


namespace App\Subscriber\Authentication;


use App\Entity\User;
use App\Event\UserBlockedEvent;
use App\Repository\RepositoryInterface\StatsUserRepository;
use App\Repository\RepositoryInterface\UserRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;
use Symfony\Component\Validator\Constraints\Date;

class UpdateStatsOnAuthentication implements EventSubscriberInterface
{

    /**
     * @var StatsUserRepository
     */
    private $repository;
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        StatsUserRepository $repository,
        EventDispatcherInterface $dispatcher,
        UserRepository $userRepository
    )
    {
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            AuthenticationEvents::AUTHENTICATION_SUCCESS => "onAuthenticateSuccess",
            AuthenticationEvents::AUTHENTICATION_FAILURE => "onAuthenticateFailure"
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

            $nbConnection = $stats->getNbConnection() ? ($stats->getNbConnection() + 1) : 1;

            $stats
                ->setLastConnectionAt(new \DateTime("now"))
                ->setNbConnection($nbConnection)
                ->setAttempt(null)
                ->setBlocked(false);

            $this->repository->save($stats);
        }
    }

    /**
     * En cas d'erreur de connexion, on increment le nombre de tentative
     * si le nombre de tentative et supperieur au max on bloque le compte
     * et on dispatch l'evenement UserBlockedEvent
     *
     * @param AuthenticationFailureEvent $event
     */
    public function onAuthenticateFailure(AuthenticationFailureEvent $event)
    {
        /** @var string $userToken */
        $userToken = $event->getAuthenticationToken()->getUser();

        if($userToken !== null) {
            $user = $this->userRepository->getByEmail($userToken);
            if(!$user instanceof User) return;

            $stats = $user->getStatsUser();

            $attempt = $stats->getAttempt() ? ($stats->getAttempt() + 1) : 1;
            $stats->setAttempt($attempt);

            if($attempt >= $stats::NB_ATTEMPT_AUTH) {
                try {
                    $stats
                        ->setBlockedAt(new \DateTime("now"))
                        ->setBlocked(true);
                } catch (\Exception $e) {  }

                $this->dispatcher->dispatch(new UserBlockedEvent($user), UserBlockedEvent::NAME);
            }

            $this->repository->save($stats);
        }
    }
}