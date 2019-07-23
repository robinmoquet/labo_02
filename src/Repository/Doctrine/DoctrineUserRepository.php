<?php

namespace App\Repository\Doctrine;

use App\Entity\User;
use App\Repository\RepositoryInterface\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{

    private $manager;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
        $this->manager = $registry->getManager();
    }

    public function add(User $user): void
    {
        $this->manager->persist($user);
        $this->manager->flush();
    }
}
