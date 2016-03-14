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

    protected function setUp()
    {
        parent::setUp();

        // Create user & save it.
        $this->_user = $this->_createUser();

        // Set token
        $this->_token = $this->_createToken($this->_user);

        // Generate a list of contacts
        $this->_contacts = $this->_generateContacts($this->_user);
    }

    public function testGet()
    {
        $this->get('api/contacts', $this->_headers())
            ->seeJsonStructure([
                '*' => [
                    'id', 'user_id', 'name', 'number'
                ]
            ]);
    }

    public function testInsertGoodData()
    {
        $contact = [
            "name" => str_random(10),
            "number" => str_random(10)
        ];

        $this->json('POST', 'api/contacts', $contact, $this->_headers())
            ->assertResponseOk();

        $this->seeInDatabase('contacts', [
            "user_id" => $this->_user->id,
            "name" => $contact["name"],
            "number" => $contact["number"]
        ]);
    }

    public function testInsertBadData()
    {
        //No name
        $contact = [
            "number" => str_random(10)
        ];

        $this->json('POST', 'api/contacts', $contact, $this->_headers())
            ->seeJsonEquals([
                "name" => ["The name field is required."]
            ])
            ->assertResponseStatus(422);

        //No number
        $contact = [
            "name" => str_random(10)
        ];

        $this->json('POST', 'api/contacts', $contact, $this->_headers())
            ->seeJsonEquals([
                "number" => ["The number field is required."]
            ])
            ->assertResponseStatus(422);

        //Short number
        $contact = [
            "name" => str_random(10),
            "number" => str_random(2)
        ];

        $this->json('POST', 'api/contacts', $contact, $this->_headers())
            ->seeJsonEquals([
                "number" => ["The number must be at least 6 characters."]
            ])
            ->assertResponseStatus(422);
    }

    public function testDeleteGoodRequest()
    {
        $contact = factory(App\Models\Contact::class)->make([
            "user_id" => $this->_user->id
        ]);
        $contact->save();

        $token = $this->_createToken($this->_user);

        $this->json('delete', 'api/contacts/' . $contact->id, [], $this->_headers($token))
            ->assertResponseOk();
    }

    public function testDeleteBadRequest()
    {
        //Test trying to delete a contact that does not belong to the user
        $fakeUser = $this->_createUser();
        $contact = factory(App\Models\Contact::class)->make([
            "user_id" => $fakeUser->id
        ]);
        $contact->save();

        $token = $this->_createToken($this->_user);

        $r = $this->json('delete', 'api/contacts/' . $contact->id, [], $this->_headers($token))
            ->assertResponseStatus(403);
    }

    public function testUpdateGoodData()
    {
        $contact = factory(App\Models\Contact::class)->make([
            "user_id" => $this->_user->id
        ]);
        $contact->save();

        $updated = [
            "id" => $contact->id,
            "name" => str_random(10),
            "number" => str_random(10)
        ];

        $this->json('PUT', 'api/contacts', $updated, $this->_headers())
            ->assertResponseOk();

        $this->seeInDatabase('contacts', [
            "id" => $contact->id,
            "name" => $updated["name"],
            "number" => $updated["number"]
        ]);
    }

    public function testUpdateBadData()
    {
        $contact = factory(App\Models\Contact::class)->make([
            "user_id" => $this->_user->id
        ]);
        $contact->save();

        //Number too short.
        $updated = [
            "id" => $contact->id,
            "name" => str_random(10),
            "number" => str_random(5)
        ];

        $this->json('PUT', 'api/contacts', $updated, $this->_headers())
            ->assertResponseStatus(422);

        //No name.
        $updated = [
            "id" => $contact->id,
            "name" => ""
        ];

        $this->json('PUT', 'api/contacts', $updated, $this->_headers())
            ->assertResponseStatus(422);

        //No number.
        $updated = [
            "id" => $contact->id,
            "name" => str_random(10)
        ];

        $this->json('PUT', 'api/contacts', $updated, $this->_headers())
            ->assertResponseStatus(422);
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

    private function _headers($token = false)
    {
        if(!$token) {
            $token = $this->_token;
        }
        return ['HTTP_Authorization' => 'Bearer ' . $token];
    }
}
