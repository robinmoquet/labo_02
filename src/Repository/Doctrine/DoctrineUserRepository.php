<?php

namespace App\Repository\Doctrine;

use App\Entity\User;
use App\Repository\RepositoryInterface\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{

    private $manager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->manager = $registry->getManager();
    }

    /**
     * {@inheritDoc}
     */
    public function add(User $user): void
    {
        $this->manager->persist($user);
        $this->manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getBy(array $params): array
    {
        return $this->findBy($params);
    }

    /**
     * {@inheritDoc}
     */
    public function getByEmail(string $email): ?User
    {
        return $this->findOneBy(["email" => $email]);
    }
}
