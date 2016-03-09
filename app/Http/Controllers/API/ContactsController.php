<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Contact\IContactRepository;
use App\Repositories\User\IUserRepository;
use Illuminate\Http\Request;
use JWTAuth;
use Validate;

class ContactsController extends Controller
{
    private $_contactRepository;
    private $_userRepository;

    public function __construct(IContactRepository $contact, IUserRepository $user)
    {
        $this->_contactRepository = $contact;
        $this->_userRepository = $user;
    }

    // Has $id = NULL for now - can be removed (and in routes.php) if I end up
    // Not using it.
    public function get(Request $request, $id = NULL)
    {
        $user = $this->_authenticate();
        if(!$user)
        {
            return $this->_invalidLoginResponse();
        }

        $userContacts = $this->_contactRepository->getContactsByUserId($user->id);
        return response()->json($userContacts);
    }

    public function insert(Request $request)
    {
        $user = $this->_authenticate();
        if(!$user)
        {
            return $this->_invalidLoginResponse();
        }

        $this->validate($request, [
                'name' => 'required|max:255',
                'number' => 'required|max:20|min:6'
            ]);

        $contact = [
            "name" => $request->name,
            "number" => $request->number,
            "user_id" => $user->id
        ];

        $identity = $this->_contactRepository->insertContact($contact);
        return response()->json($identity);
    }

    public function delete(Request $request, $id)
    {
        $user = $this->_authenticate();
        if(!$user)
        {
            return $this->_invalidLoginResponse();
        }

        //ToDo: check if contact is really one of authenticated user's contacts

        $result = $this->_contactRepository->deleteContact($id);
        return response()->json($result);
    }

    public function update(Request $request)
    {
        $user = $this->_authenticate();
        if(!$user)
        {
            return $this->_invalidLoginResponse();
        }

        $this->validate($request, [
                'name' => 'required|max:255',
                'number' => 'required|max:20|min:6'
            ]);

        $contact = $this->_contactRepository->getContactById($request->id);
        if($contact->user_id != $user->id)
        {
            return response()->json(false);
        }

        $newValues["name"] = $request->name;
        $newValues["number"] = $request->number;

        $result = $this->_contactRepository->updateContact($request->id, $newValues);
        return response()->json($result);
    }

    private function _authenticate()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    private function _invalidLoginResponse()
    {
        return response()->json('Not logged in', 401);
    }
}
