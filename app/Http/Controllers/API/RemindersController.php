<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Models\User_reminder;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Validate;

class RemindersController extends Controller
{
    /**
     * Get upcoming user reminders.
     *
     * @return JSON response
     */

    public function getUpcomingReminders()
    {
        $user = JWTAuth::parseToken()->authenticate();

        if(!$user) {
            return response()->json('Not logged in', 401);
        }

        $upcomingReminders = User_reminder::where([
                ['user_id', $user->id],
                ['send_datetime', '>', date("Y-m-d H:i:s")] //Only reminders with a datetime later than now
            ])->get();

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
        $user = JWTAuth::parseToken()->authenticate();

        if(!$user)
        {
            return response()->json('Not logged in', 401);
        }
        else
        {
            $user->reminder_credits--;
            $user->save();
            return $this->_createUserReminder($user->id, $request);
        }
    }

    public function cancelReminder($id = NULL)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if(!$user)
        {
            return response()->json('Not logged in', 401);
        }
        else if($id == NULL)
        {
            return response()->json(false);
        }
        else
        {
            $reminder = User_reminder::find($id);
            if($reminder)
            {
                $reminder->forceDelete();
                $user->reminder_credits++;
                $user->save();
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

        $reminder = new User_reminder;

        // For now, needs some thought. This creates duplicate data in the db.
        // Might be better to check client side for soft deletes.
        if($request->contact_id)
        {
            $contact = Contact::find($request->contact_id)->first();
            $reminder->recipient = $contact->number;
        }
        else
        {
            $reminder->recipient = $request->recipient;
        }

        $reminder->contact_id = $request->contact_id;
        $reminder->send_datetime = $request->send_datetime;
        $reminder->message = $request->message;
        $reminder->repeat_id = $request->repeat_id;
        $reminder->user_id = $user_id;

        if($reminder->save())
        {
            return response()->json($reminder->id);
        }
        else
        {
            return response()->json(false); //ToDo: Maybe return something more meaningful? Like a http code
        }
    }
}
