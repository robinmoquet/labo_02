<?php


namespace App\Security;


use App\Entity\User;
use App\Repository\RepositoryInterface\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{

    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Charge l'utilisateur par rapport au username
     * @param string $username
     * @return UserInterface
     */
    public function loadUserByUsername($username): UserInterface
    {
        return $this->findUserByUsername($username);
    }


    /**
     * Recharge l'utilisateur pour recup les derniere modifs
     * @param UserInterface $user
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if(!$user instanceof User) {
            throw new UnsupportedUserException("Class non supporter");
        }

        $username = $user->getUsername();
        return $this->findUserByUsername($username);
    }

    /**
     * Retourne l'utilisateur via le repo avec le username
     * @param string $username
     * @return User|null
     */
    private function findUserByUsername(string $username)
    {
        $user = $this->repository->getByEmail($username);
        if($user !== null) {
            return $user;
        }

        throw new UsernameNotFoundException("Votre email est invalide");
    }

    /**
     * Control que la class est supportee
     * @param string $class
     * @return bool
     */
    public function supportsClass($class): bool
    {
        return User::class === $class;
    }
}