<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Contact;
use Illuminate\Http\Request;
use Auth;
use Validate;
use JWTAuth;

class DashboardController extends Controller
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
    public function index()
    {
        $user = Auth::user();

        // Create a new JWT token from the authenticated user.
        $data['token'] = JWTAuth::fromUser($user);

        // Pass select userdata to the view.
        $uservm = [
            "name" => $user->name,
            "email" => $user->email,
            "created_at" => $user->created_at,
            "reminder_credits" => $user->reminder_credits
        ];
        $data['uservm'] = json_encode($uservm);

        return view('dashboard.home', $data);
    }
}
