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
    // The used repository.
    private $_userRepository;

    /**
     * Inject the repository.
     *
     */
    public function __construct(IUserRepository $user)
    {
        $this->_userRepository = $user;
    }

    /**
     * Authenticate the request and return a JWT token.
     *
     * @param Request - credentiald
     * @return json
     */
    public function authenticate(Request $request)
    {
        // Grab credentials from the request
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);

        try
        {
            // Attempt to verify the credentials and create a token for the user
            if (! $token)
            {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        }
        catch (JWTException $e)
        {
            // Something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = JWTAuth::toUser($token);

        // Return the token and userdetails in the response.
        $response = [
            "token" => $token,
            "user" => [
                "id" => $user->id,
                "name" => $user->name,
                "reminder_credits" => $user->reminder_credits
            ]
        ];

        return response()->json($response);
    }

    /**
     * Register using a POST request.
     *
     * @param Request - json
     * @return json
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        // Create a user from the request.
        $user = $this->_userRepository->createUser([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Create a token, and return it in the response, along with user details.
        $token = JWTAuth::fromUser($user);

        $response = [
            "token" => $token,
            "user" => [
                "id" => $user->id,
                "name" => $user->name,
                "reminder_credits" => $user->reminder_credits
            ]
        ];

        return response()->json($response);
    }
}
