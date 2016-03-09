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

    public function insertQuickReminder($newReminder)
    {
        $reminder = new $this->_quickReminder;

        $reminder->recipient = $newReminder["recipient"];
        $reminder->send_datetime = $newReminder["send_datetime"];
        $reminder->message = $newReminder["message"];

        return $reminder->save();
    }

    public function getQuickRemindersWhere($arguments)
    {
        return $this->_quickReminder->where($arguments)->get();
    }
}
