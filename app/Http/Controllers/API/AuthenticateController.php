<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validate;
use App\Repositories\User\IUserRepository;

class AuthenticateController extends Controller
{
    private $_userRepository;

    public function __construct(IUserRepository $user)
    {
        $this->_userRepository = $user;
    }

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);

        try
        {
            // attempt to verify the credentials and create a token for the user
            if (! $token)
            {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        }
        catch (JWTException $e)
        {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = JWTAuth::toUser($token);

        $response = [
            "token" => $token,
            "user" => [
                "name" => $user->name,
                "reminder_credits" => $user->reminder_credits
            ]
        ];

        // all good so return the token
        return response()->json($response);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = $this->_userRepository->createUser([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = [
            "token" => $token,
            "user" => [
                "name" => $user->name,
                "reminder_credits" => $user->reminder_credits
            ]
        ];

        return response()->json($response);
    }
}
