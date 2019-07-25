<?php


namespace App\Repository\RepositoryInterface;


use App\Entity\StatsUser;

interface StatsUserRepository
{
    /**
     * Insert dans la base de donnée le données de
     * l'entite StatsUser
     *
     * @param StatsUser $statsUser
     */
    public function add(StatsUser $statsUser): void;


    /**
     * Mais a jour les donnees de la base de donnee par
     * rapport au donnees de l'entite StatsUser
     *
     * @param StatsUser $statsUser
     */
    public function save(StatsUser $statsUser): void;
}