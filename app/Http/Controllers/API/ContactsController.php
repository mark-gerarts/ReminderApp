<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Contact\IContactRepository;
use App\Repositories\User_reminder\IUser_reminderRepository;
use App\Repositories\User\IUserRepository;
use Illuminate\Http\Request;
use JWTAuth;
use Validate;

class ContactsController extends Controller
{
    private $_contactRepository;
    private $_userRepository;
    private $_userReminderRepository;

    public function __construct(IContactRepository $contact, IUserRepository $user, IUser_reminderRepository $userReminder)
    {
        $this->_contactRepository = $contact;
        $this->_userRepository = $user;
        $this->_userReminderRepository = $userReminder;
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

        // Get contact.
        $contact = $this->_contactRepository->getContactById($id);

        // Check if the contact really belongs to the user.
        if($contact->user_id != $user->id)
        {
            return resposne()->json(false);
        }

        // Remove the contact id from all associated reminders, and
        // set the recipient to the contact's number.
        $reminders = $this->_userReminderRepository->getUserRemindersWhere([["contact_id", $id]]);
        foreach($reminders as $reminder)
        {
            $this->_userReminderRepository->updateUserReminder($reminder->id, [
                "recipient" => $contact->number,
                "contact_id" => NULL
            ]);
        }

        // Delete the contact
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
