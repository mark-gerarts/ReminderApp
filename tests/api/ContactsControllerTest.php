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
        $user = factory(App\Models\User::class)->make([
            "name" => "TestName",
            "email" => "test@email.com"
        ]);

        $user->save();
        $token = JWTAuth::fromUser($user);

        $this->refreshApplication();
        JWTAuth::refreshToken();
        //Log::info($user);


    $response = $this->get('api/contacts', ['HTTP_Authorization' => 'Bearer '. $token]);
            Log::info($response->response);
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
        $output = [];

        for($i=0; $i<10; $i++)
        {
            $output[] = factory(App\Models\Contact::class)->make([
                "user_id" => $user->id
            ]);
        }

        return $output;
    }

    private function _createToken($user)
    {
        $token = JWTAuth::fromUser($user);
        JWTAuth::setToken($token);
        return $token;
    }
}
