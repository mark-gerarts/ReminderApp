<?php

namespace App\Repositories\User_order;

use App\Models\User_order;

class User_orderRepository implements IUser_orderRepository
{
    private $_userOrder;

    public function __construct(User_order $userOrder)
    {
        $this->_userOrder = $userOrder;
    }

    public function insertUserOrder($newUserOrder)
    {
        $order = new $this->_userOrder;
        $order->user_id = $newUserOrder["user_id"];
        $order->amount = $newUserOrder["amount"];
        $order->reminder_credits = $newUserOrder["reminder_credits"];
        $order->payment_id = (isset($newUserOrder["payment_id"])) ? $newUserOrder["payment_id"] : '';
        $order->save();
        return $order->id;
    }

    public function getUserOrderById($id)
    {
        return $this->_userOrder->find($id);
    }

    public function deleteUserOrder($id)
    {
        return $this->_userOrder->destroy($id);
    }

    public function updateUserOrder($id, $newValues)
    {
        return $this->_userOrder->where('id', $id)->update($newValues);
    }
}
