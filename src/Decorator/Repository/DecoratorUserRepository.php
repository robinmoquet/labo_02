<?php


namespace App\Decorator\Repository;


use App\Entity\User;
use App\Event\UserSavedEvent;
use App\Repository\RepositoryInterface\UserRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DecoratorUserRepository implements UserRepository
{

    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(UserRepository $repository, EventDispatcherInterface $eventDispatcher)
    {
        $this->repository = $repository;
        $this->dispatcher = $eventDispatcher;
    }

    /**
     * {@inheritDoc}
     *
     * Appel la fonction add du repository pour ajouter l'utilisateur en base
     * de donnée puis dispatch un evenement UserSavedEvent pour notifier les Subscriber
     * que l'ajout d'un utilisateur a eu lieu
     */
    public function add(User $user): void
    {
        $this->repository->add($user);
        $this->dispatcher->dispatch(new UserSavedEvent($user), UserSavedEvent::NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function getBy(array $params): array
    {
        return $this->repository->getBy($params);
    }

    /**
     * {@inheritDoc}
     */
    public function getByEmail(string $email): ?User
    {
        return $this->repository->getByEmail($email);
    }
}