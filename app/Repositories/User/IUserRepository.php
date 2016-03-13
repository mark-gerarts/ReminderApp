<?php

namespace App\Repositories\User;

interface IUserRepository
{
    public function getUserById($userid);

    public function updateUser($id, $values);

    public function createUser($values);
}
