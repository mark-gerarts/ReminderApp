<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Models\User_reminder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;

class RemindersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function getUpcomingReminders()
    {
        $user = Auth::user();

        $upcomingReminders = User_reminder::where([
                ['user_id', $user->id],
                ['send_datetime', '>', date("Y-m-d H:i:s")] //Only reminders with a datetime later than now
            ])->get();

        return response()->json($upcomingReminders);
    }

    public function insertReminder(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
                'recipient' => 'max:255',
                'contact_id' => 'numeric',
                'send_datetime' => 'required',
                'message' => 'required|max:255',
                'repeat_id' => 'required|numeric'
            ]);

        $reminder = new User_reminder;

        $reminder->recipient = $request->recipient;
        $reminder->contact_id = $request->contact_id;
        $reminder->send_datetime = $request->send_datetime;
        $reminder->message = $request->message;
        $reminder->repeat_id = $request->repeat_id;
        $reminder->user_id = $user->id;

        if($reminder->save())
        {
            return response()->json($reminder->id);
        }
        else
        {
            return response()->json(false);
        }

    }

}
