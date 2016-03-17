<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Repositories\User\IUserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Validate;

class UserController extends Controller
{
    private $_user;

    public function __construct()
    {
        $this->_user = JWTAuth::parseToken()->toUser();
    }

    /**
     * Get a viewmodel of the authenticated user.
     *
     * @return JSON response
     */
    public function getUserDetails()
    {
        // Only a few of the user details are returned.
        $response = [
            "id" => $this->_user->id,
            "name" => $this->_user->name,
            "reminder_credits" => $this->_user->reminder_credits
        ];

        return response()->json($response);
    }
}
