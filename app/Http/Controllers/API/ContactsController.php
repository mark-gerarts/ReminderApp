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
    // The used repositories.
    private $_contactRepository;
    private $_userRepository;
    private $_userReminderRepository;

    private $_user;

    /**
     * Inject the repositories.
     *
     */
    public function __construct(IContactRepository $contact, IUserRepository $user, IUser_reminderRepository $userReminder)
    {
        $this->_user = JWTAuth::parseToken()->toUser();

        $this->_contactRepository = $contact;
        $this->_userRepository = $user;
        $this->_userReminderRepository = $userReminder;
    }

    /**
     * Get all contacts of a user, or one contact.
     *
     * @param Int $id
     * @return json
     */
    public function get(Request $request, $id = NULL)
    {
        // Fetch all the contacts associated with the user & return as JSON.
        $userContacts = $this->_contactRepository->getContactsByUserId($this->_user->id);
        return response()->json($userContacts);
    }

    /**
     * Insert a new user.
     *
     * @return json
     */
    public function insert(Request $request)
    {
        $this->validate($request, [
                'name' => 'required|max:255',
                'number' => 'required|max:20|min:6'
            ]);

        // Set up the values for the new contact.
        $contact = [
            "name" => $request->name,
            "number" => $request->number,
            "user_id" => $this->_user->id
        ];

        // Insert via the repository.
        $identity = $this->_contactRepository->insertContact($contact);

        // The new ID is returned in the response.
        return response()->json($identity);
    }

    /**
     * Delete a contact.
     *
     * @param Int $id
     * @return json
     */
    public function delete(Request $request, $id)
    {
        // Get the contact.
        $contact = $this->_contactRepository->getContactById($id);

        if(!$contact)
        {
            return response()->json("Not found", 404);
        }
        // Check if the contact really belongs to the user.
        if($contact->user_id != $this->_user->id)
        {
            return response()->json("Not authorized", 403);
        }

        // Remove the contact id from all associated reminders, and
        // set the recipient to the contact's number.
        // This is so the set reminders can still be sent.
        $reminders = $this->_userReminderRepository->getUserRemindersWhere([["contact_id", $id]]);
        foreach($reminders as $reminder)
        {
            $this->_userReminderRepository->updateUserReminder($reminder->id, [
                "recipient" => $contact->number,
                "contact_id" => NULL
            ]);
        }

        // Finally, delete the contact & return the result.
        $result = $this->_contactRepository->deleteContact($id);
        return response()->json($result);
    }

    /**
     * Update a contact.
     *
     * @return json
     */
    public function update(Request $request)
    {
        $this->validate($request, [
                'name' => 'required|max:255',
                'number' => 'required|max:20|min:6'
            ]);

        // Check if the contact exists.
        $contact = $this->_contactRepository->getContactById($request->id);
        if(!$contact)
        {
            return response()->json("Not found.", 404);
        }
        // Check if the contact really belongs to the user.
        if($contact->user_id != $this->_user->id)
        {
            return response()->json("Not authorized", 403);
        }

        // Set the new values.
        $newValues["name"] = $request->name;
        $newValues["number"] = $request->number;

        // Perform the update.
        $result = $this->_contactRepository->updateContact($request->id, $newValues);
        return response()->json($result);
    }
}
