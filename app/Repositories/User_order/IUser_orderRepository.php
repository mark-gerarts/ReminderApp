<?php

namespace App\Repositories\User_order;

interface IUser_orderRepository
{
    public function insertUserOrder($newUserOrder);

    public function getUserOrderById($id);

    public function deleteUserOrder($id);

    public function updateUserOrder($id, $newValues);
}
