<?php

namespace App\Repositories\User_reminder;

use App\Models\User_reminder;

class User_reminderRepository implements IUser_reminderRepository
{
    private $_userReminder;

    public function __construct(User_reminder $userReminder)
    {
        $this->_userReminder = $userReminder;
    }

    public function getUserReminderById($id)
    {
        return $this->_userReminder->find($id);
    }

    public function getUserRemindersWhere($where)
    {
        return $this->_userReminder->where($where)->get();
    }

    public function insertUserReminder($newReminder)
    {
        $reminder = new $this->_userReminder;

        $reminder->recipient = (isset($newReminder["recipient"])) ? $newReminder["recipient"] : NULL;
        $reminder->contact_id = (isset($newReminder["contact_id"])) ? $newReminder["contact_id"] : NULL ;
        $reminder->send_datetime = $newReminder["send_datetime"];
        $reminder->message = $newReminder["message"];
        $reminder->user_id = $newReminder["user_id"];
        $reminder->repeat_id = $newReminder["repeat_id"];
        $reminder->save();

        return $reminder->id;
    }

    public function updateUserReminder($id, $values)
    {
        return $this->_userReminder->where('id', $id)->update($values);
    }

    public function forceDeleteUserReminder($id)
    {
        return $this->_userReminder->find($id)->forceDelete();
    }
}
