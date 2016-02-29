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
        $data['token'] = JWTAuth::fromUser($user);

        return view('dashboard.home', $data);
    }

    public function contacts()
    {
        return view('dashboard.contacts');
    }

    public function history()
    {
        return view('dashboard.history');
    }
}
