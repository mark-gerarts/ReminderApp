<?php

namespace App\Repositories\Quick_reminder;

use App\Models\Quick_reminder;

class Quick_reminderRepository implements IQuick_reminderRepository
{
    private $_quickReminder;

    public function __construct(Quick_reminder $quickReminder)
    {
        $this->_quickReminder = $quickReminder;
    }

    public function getQuickReminderById($id)
    {
        return $this->_quickReminder->find($id);
    }

    public function insertQuickReminder($newReminder)
    {
        $reminder = new $this->_quickReminder;

        $reminder->recipient = $newReminder["recipient"];
        $reminder->send_datetime = $newReminder["send_datetime"];
        $reminder->message = $newReminder["message"];
        $reminder->save();

        return $reminder->id;
    }

    public function getQuickRemindersWhere($arguments)
    {
        return $this->_quickReminder->where($arguments)->get();
    }

    public function updateQuickReminder($id, $values)
    {
        return $this->_quickReminder->where('id', $id)->update($values);
    }

    public function deleteQuickReminder($id)
    {
        return $this->_quickReminder->destroy($id);
    }
}
