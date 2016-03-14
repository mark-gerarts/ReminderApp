<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Repositories\User_reminder\IUser_reminderRepository;
use App\Repositories\User\IUserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Validate;

class RemindersController extends Controller
{
    // The used repositories.
    private $_userRepository;
    private $_userReminderRepository;

    private $_user;

    /**
     * Inject the repositories.
     *
     */
    public function __construct(IUserRepository $userRepository, IUser_reminderRepository $userReminderRepository)
    {
        $this->_user = JWTAuth::parseToken()->toUser();

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
        // Get the upcoming reminders belonging to the authenticated user.
        $upcomingReminders = $this->_userReminderRepository->getUserRemindersWhere([
                ['user_id', $this->_user->id],
                ['send_datetime', '>', date("Y-m-d H:i:s")] // Only reminders with a datetime later than now.
            ]);

        // Return as JSON.
        return response()->json($upcomingReminders);
    }

    /**
     * Insert a user reminder.
     *
     * @return JSON response
     */
    public function insertReminder(Request $request)
    {
        if($this->_user->reminder_credits == 0)
        {
            return response("Not enough credits");
        }
        // Remove a credit from the user.
        $newCredits = $this->_user->reminder_credits - 1;
        $this->_userRepository->updateUser($this->_user->id, ["reminder_credits" => $newCredits]);

        // Create the new reminder & return the result.
        // ToDo: what if the insert failed?;
        return $this->_createUserReminder($this->_user->id, $request);
    }

    /**
     * Cancel (delete) a reminder.
     *
     * @param Int $id
     * @return json
     */
    public function cancelReminder($id = NULL)
    {
        if($id == NULL)
        {
            return response()->json(false);
        }

        // Get the reminder by id.
        $reminder = $this->_userReminderRepository->getUserReminderById($id);
        if($reminder)
        {
            // Delete the reminder, and refund a credit for the user.
            $this->_userReminderRepository->forceDeleteUserReminder($reminder->id);
            $newCredits = $this->_user->reminder_credits + 1;
            $this->_userRepository->updateUser($this->_user->id, ["reminder_credits" => $newCredits]);
            return response()->json(true);
        }
        // If the reminder isn't found; return false.
        return response()->json(false);
    }

    /**
     * Insert a user reminder.
     *
     * @param User ID
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

        // Set up the new reminder.
        $values = [
            "message" => $request->message,
            "repeat_id" => $request->repeat_id,
            "user_id" => $user_id,
            "send_datetime" => $request->send_datetime
        ];

        // Check if the reminder is associated with a contact or a random recipient.
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
            // At least one of both is required, so return false when the request contains neither.
            return response()->json(false);
        }

        // Insert the new reminder and get the result (ID or false).
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
}
