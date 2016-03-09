<?php

namespace App\Repositories\User_reminder;

interface IUser_reminderRepository
{
    public function getUserReminderById($id);

    public function getUserRemindersWhere($where);

    public function insertUserReminder($newReminder);

    public function updateUserReminder($id, $values);

    public function forceDeleteUserReminder($id);
}
