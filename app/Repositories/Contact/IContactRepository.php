<?php

namespace App\Repositories\Contact;

interface IContactRepository
{
    public function getContactById($contactid);

    public function getContactsByUserId($userid);

    public function insertContact($contact);

    public function deleteContact($contactid);

    public function updateContact($id, $newValues);
}
