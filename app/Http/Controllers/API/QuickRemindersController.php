<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Models\Quick_reminder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validate;

class QuickRemindersController extends Controller
{
    /**
     * Insert a quick reminder.
     *
     * @param Request - JSON reminder
     * @return JSON response
     */

    public function insertQuickReminder(Request $request)
    {
        $this->validate($request, [
                'recipient' => 'max:255',
                'send_datetime' => 'required',
                'message' => 'required|max:255'
            ]);

        $reminder = new Quick_reminder;

        $reminder->recipient = $request->recipient;
        $reminder->send_datetime = $request->send_datetime;
        $reminder->message = $request->message;

        if($reminder->save())
        {
            return response()->json(true);
        }
        else
        {
            return response()->json(false);
        }
    }
}
