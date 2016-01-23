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
    
}
