<?php


namespace App\Decorator\Repository;


use App\Entity\User;
use App\Event\UserSaved;
use App\Repository\RepositoryInterface\UserRepository;
use Symfony\Component\EventDispatcher\EventDispatcher;

class DecoratorUserRepository implements UserRepository
{

    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->dispatcher = new EventDispatcher();
    }

    public function add(User $user): void
    {
        $this->repository->add($user);
        $this->dispatcher->dispatch(new UserSaved($user), UserSaved::NAME);
    }

}