<?php

namespace App\Repositories\Quick_reminder;

interface IQuick_reminderRepository
{
    public function getQuickReminderById($id);

    public function insertQuickReminder($newReminder);

    public function getQuickRemindersWhere($arguments);

    public function updateQuickReminder($id, $values);

    public function deleteQuickReminder($id);
}
