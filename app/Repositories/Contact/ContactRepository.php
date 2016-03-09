<?php

namespace App\Repositories\Contact;

use App\Models\Contact;

class ContactRepository implements IContactRepository
{
    private $_contact;

    public function __construct(Contact $contact)
    {
        $this->_contact = $contact;
    }

    public function getContactById($contactid)
    {
        return $this->_contact->find($contactid);
    }

    public function getContactsByUserId($userid)
    {
        return $this->_contact->where('user_id', $userid)->get();
    }

    public function insertContact($contact)
    {
        $newContact = new $this->_contact;
        $newContact->name = $contact["name"];
        $newContact->number = $contact["number"];
        $newContact->user_id = $contact["user_id"];
        $newContact->save();

        return $newContact->id;
    }

    public function deleteContact($contactid)
    {
        return $this->_contact->destroy($contactid);
    }

    public function updateContact($id, $newValues)
    {
        return $this->_contact->where('id', $id)->update($newValues);
    }
}
