<?php


namespace App\Repository\RepositoryInterface;


use App\Entity\User;

interface UserRepository
{

    public function add(User $user): void;

}