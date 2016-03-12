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
        $this->middleware('jwt.auth');
        $this->_user = JWTAuth::parseToken()->toUser();
    }

    public function getUserDetails()
    {
        return response()->json($this->_user);
    }
}
