<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Models\User_reminder;
use App\Models\Contact;
use App\Repositories\User_reminder\IUser_reminderRepository;
use App\Repositories\User\IUserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Validate;

class RemindersController extends Controller
{
    private $_userRepository;

    private $_userReminderRepository;

    public function __construct(IUserRepository $userRepository, IUser_reminderRepository $userReminderRepository)
    {
        $this->_userRepository = $userRepository;
        $this->_userReminderRepository = $userReminderRepository;
    }

    /**
     * Get upcoming user reminders.
     *
     * @return JSON response
     */

    public function getUpcomingReminders()
    {
        $user = $this->_authenticate();
        if(!$user)
        {
            return $this->_invalidLoginResponse();
        }

        $upcomingReminders = $this->_userReminderRepository->getUserRemindersWhere([
                ['user_id', $user->id],
                ['send_datetime', '>', date("Y-m-d H:i:s")] //Only reminders with a datetime later than now
            ]);

        return response()->json($upcomingReminders);
    }

    /**
     * Insert a user reminder.
     *
     * @param Request - Reminder JSON
     * @return JSON response
     */

    public function insertReminder(Request $request)
    {
        $user = $this->_authenticate();
        if(!$user)
        {
            return $this->_invalidLoginResponse();
        }
        else
        {
            $newCredits = $user->reminder_credits - 1;
            $this->_userRepository->updateUser($user->id, ["reminder_credits" => $newCredits]);
            return $this->_createUserReminder($user->id, $request);
        }
    }

    public function cancelReminder($id = NULL)
    {
        $user = $this->_authenticate();
        if(!$user)
        {
            return $this->_invalidLoginResponse();
        }
        else if($id == NULL)
        {
            return response()->json(false);
        }
        else
        {
            $reminder = $this->_userReminderRepository->getUserReminderById($id);
            if($reminder)
            {
                $this->_userReminderRepository->forceDeleteUserReminder($reminder->id);
                $newCredits = $user->reminder_credits + 1;
                $this->_userRepository->updateUser($user->id, ["reminder_credits" => $newCredits]);
            }
            return response()->json(true);
        }
    }

    /**
     * Insert a user reminder.
     *
     * @param User ID
     * @param Request - Reminder JSON
     * @return JSON response
     */

    private function _createUserReminder($user_id, $request)
    {
        $this->validate($request, [
                'recipient' => 'max:255',
                'contact_id' => 'numeric',
                'send_datetime' => 'required',
                'message' => 'required|max:255',
                'repeat_id' => 'required|numeric'
            ]);

        $values = [
            "message" => $request->message,
            "repeat_id" => $request->repeat_id,
            "user_id" => $user_id,
            "send_datetime" => $request->send_datetime
        ];

        if(isset($request->contact_id))
        {
            $values["contact_id"] = $request->contact_id;
        }
        else if(isset($request->recipient))
        {
            $values["recipient"] = $request->recipient;
        }
        else
        {
            return response()->json(false);
        }

        $identity = $this->_userReminderRepository->insertUserReminder($values);

        if($identity)
        {
            return response()->json($identity);
        }
        else
        {
            return response()->json(false); //ToDo: Maybe return something more meaningful? Like a http code
        }
    }

    private function _authenticate()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    private function _invalidLoginResponse()
    {
        return response()->json('Not logged in', 401);
    }
}
