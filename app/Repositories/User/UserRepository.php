<?php

namespace App\Repositories\User;

use App\Models\User;
use Tymon\JWTAuth\Providers\User\UserInterface;

class UserRepository implements IUserRepository, UserInterface
{
    private $_user;

    public function __construct(User $user)
    {
        $this->_user = $user;
    }

    public function getUserById($userid)
    {
        return $this->_user->find($userid);
    }

    public function updateUser($id, $values)
    {
        return $this->_user->where('id', $id)->update($values);
    }

    public function getBy($key, $value)
    {
        return $this->_user->where($key, $value)->first();
    }

    public function createUser($values)
    {
        return $this->_user->create($values);
    }
}
