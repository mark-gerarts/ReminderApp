<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $_user;
    private $_token;

    protected function setUp()
    {
        parent::setUp();

        // Create user & save it.
        $this->_user = $this->_createUser();

        // Set token
        $this->_token = $this->_createToken($this->_user);
    }

    public function testGetUserDetails()
    {
        $this->get('api/user', $this->_headers())
            ->seeJsonStructure(["id", "name", "reminder_credits"]);
    }

    private function _createUser()
    {
        $user = factory(App\Models\User::class)->create([
            "name" => "TestName",
            "email" => "test@email.com",
            "reminder_credits" => 10
        ]);

        return $user;
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
