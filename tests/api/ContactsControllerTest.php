<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactsControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $_user;
    private $_token;
    private $_contacts;
    private $_csrf;

    protected function setUp()
    {
        parent::setUp();

        // Create user & save it.
        $this->_user = $this->_createUser();

        // Set token
        $this->_token = $this->_createToken($this->_user);

        // Generate a list of contacts
        $this->_contacts = $this->_generateContacts($this->_user);

        // Generate a csrf token
        $this->_csrf = csrf_token();
    }

    public function testGet()
    {
        $this->get('api/contacts', ['HTTP_Authorization' => 'Bearer '. $this->_token])
            ->seeJsonStructure([
                '*' => [
                    'id', 'user_id', 'name', 'number'
                ]
            ]);
    }

    private function _createUser()
    {
        $user = factory(App\Models\User::class)->make([
            "name" => "TestName",
            "email" => "test@email.com"
        ]);

        $user->save();

        return $user;
    }

    private function _generateContacts($user)
    {
        $contacts = factory(App\Models\Contact::class, 10)->make([
            "user_id" => $user->id
        ]);
        foreach ($contacts as $contact)
        {
            $contact->save();
        }

        return $contacts;
    }

    private function _createToken($user)
    {
        $token = JWTAuth::fromUser($user);
        JWTAuth::setToken($token);
        return $token;
    }
}
