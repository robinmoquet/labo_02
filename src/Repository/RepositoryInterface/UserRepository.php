<?php


namespace App\Repository\RepositoryInterface;


use App\Entity\User;

interface UserRepository
{
    /**
     * Insert dans la base de donnee les information de l'entite User
     *
     * @param User $user
     */
    public function add(User $user): void;

    /**
     * Recupere une liste de User par rapport au params passer en
     * parametre.
     *
     * Ex : $repository->getBy(["lastname" => "Demo", "email" => "demo-nemo@email.com"])
     * Cela retournera un tableau avec tous les utilisateurs qui on pour nom "Demo"
     * et pour email "demo-nemo@email.com"
     *
     * @param array $params
     * @return array
     */
    public function getBy(array $params): array;

    /**
     * Recupere un User par rapport a son email
     *
     * @param string $email
     * @return User|null
     */
    public function getByEmail(string $email): ?User;

}