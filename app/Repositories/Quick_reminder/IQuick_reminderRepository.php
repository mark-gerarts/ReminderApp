<?php

namespace App\Repositories\Quick_reminder;

interface IQuick_reminderRepository
{
    public function insertQuickReminder($newReminder);

    public function getQuickRemindersWhere($arguments);
}
