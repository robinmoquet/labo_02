<?php


namespace App\Repository\Doctrine;


use App\Entity\StatsUser;
use App\Repository\RepositoryInterface\StatsUserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DoctrineStatsUserRepository extends ServiceEntityRepository implements StatsUserRepository
{
    private $manager;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StatsUser::class);
        $this->manager = $registry->getManager();
    }

    /**
     * {@inheritDoc}
     */
    public function add(StatsUser $statsUser): void
    {
        $this->manager->persist($statsUser);
        $this->manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function save(StatsUser $statsUser): void
    {
        $this->manager->flush();
    }
}