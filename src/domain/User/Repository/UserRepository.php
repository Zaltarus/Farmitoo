<?php

namespace App\domain\User\Repository;

use App\domain\User\Entity\User;

class UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array
    {
        return [
            1 => new User(1, 'test@mail.com'),
        ];
    }

    public function find(int $id): ?User
    {
        $user = $this->findAll();

        if (isset($user[$id])) {
            return $user[$id];
        }

        return null;
    }
}
