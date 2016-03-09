<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Repositories\Quick_reminder\IQuick_reminderRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validate;

class QuickRemindersController extends Controller
{
    // The used repositories.
    $this->_quickReminderRepository;

    /**
     * Inject the repositories.
     *
     */
    public function __construct(IQuick_reminderRepository $quickReminder)
    {
        $this->_quickReminderRepository = $quickReminder;
    }

    /**
     * Insert a quick reminder.
     *
     * @return JSON response
     */
    public function insertQuickReminder(Request $request)
    {
        $this->validate($request, [
                'recipient' => 'max:255',
                'send_datetime' => 'required',
                'message' => 'required|max:255'
            ]);

        // Set the values of the new reminder.
        $reminder = [
            "recipient" => $request->recipient,
            "send_datetime" => $request->send_datetime,
            "message" => $request->message
        ];

        // Insert via the repository.
        $result = $this->_quickReminderRepository->insertQuickReminder($reminder);

        // Return true if the insert succeeded, and false otherwise.
        if($result)
        {
            return response()->json(true);
        }
        else
        {
            return response()->json(false);
        }
    }
}
