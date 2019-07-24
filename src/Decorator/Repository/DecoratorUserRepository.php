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

    public function add(User $user): void
    {
        $this->repository->add($user);
        $this->dispatcher->dispatch(new UserSavedEvent($user), UserSavedEvent::NAME);
    }

}