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
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view('dashboard.home');
    }
}
