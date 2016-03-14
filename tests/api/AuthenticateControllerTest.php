<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthenticateControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $_user;

    protected function setUp()
    {
        parent::setUp();

        $this->_user = $this->_createUser();
    }

    public function testAuthenticateGoodData()
    {
        $credentials = [
            "email" => $this->_user->email,
            "password" => "hunter2"
        ];

        $this->json('POST', 'api/login', $credentials)
            ->seeJsonStructure([
                "token",
                "user" => [
                    "id",
                    "name",
                    "reminder_credits"
                ]
            ])
            ->assertResponseOk();
    }

    public function testAuthenticateBadData()
    {
        //Wrong password
        $credentials = [
            "email" => $this->_user->email,
            "password" => "hunter3"
        ];

        $this->json('POST', 'api/login', $credentials)
            ->seeJsonEquals([
                "error" => "invalid_credentials"
            ])
            ->assertResponseStatus(401);

        //No email
        $credentials = [
            "password" => "hunter3"
        ];

        $this->json('POST', 'api/login', $credentials)
            ->seeJsonEquals([
                "error" => "invalid_credentials"
            ])
            ->assertResponseStatus(401);

        //No password
        $credentials = [
            "email" => $this->_user->email
        ];

        $this->json('POST', 'api/login', $credentials)
            ->seeJsonEquals([
                "error" => "invalid_credentials"
            ])
            ->assertResponseStatus(401);
    }

    public function testRegisterGoodData()
    {
        $user = factory(App\Models\User::class)->make([
            "password" => bcrypt("hunter2")
        ]);

        $request = [
            "name" => $user->name,
            "email" => $user->email,
            "password" => "hunter2",
            "password_confirmation" => "hunter2"
        ];

        $this->json('POST', 'api/register', $request)
            ->seeJsonStructure([
                "token",
                "user" => [
                    "id",
                    "name",
                    "reminder_credits"
                ]
            ])
            ->assertResponseOk();

        $this->seeInDatabase('users', [
            "name" => $request["name"],
            "email" => $request["email"]
        ]);
    }

    public function testRegisterBadData()
    {
        $user = factory(App\Models\User::class)->make([
            "password" => bcrypt("hunter2")
        ]);

        //No name
        $request = [
            "email" => $user->email,
            "password" => "hunter2",
            "password_confirmation" => "hunter2"
        ];

        $this->json('POST', 'api/register', $request)
            ->assertResponseStatus(422);

        //No email
        $request = [
            "name" => $user->name,
            "password" => "hunter2",
            "password_confirmation" => "hunter2"
        ];

        $this->json('POST', 'api/register', $request)
            ->assertResponseStatus(422);

        //No password
        $request = [
            "name" => $user->name,
            "email" => $user->email,
            "password_confirmation" => "hunter2"
        ];

        $this->json('POST', 'api/register', $request)
            ->assertResponseStatus(422);

        //No password confirm
        $request = [
            "name" => $user->name,
            "email" => $user->email,
            "password" => "hunter2"
        ];

        $this->json('POST', 'api/register', $request)
            ->assertResponseStatus(422);

        //Wrong password confirm
        $request = [
            "name" => $user->name,
            "email" => $user->email,
            "password" => "hunter2",
            "password_confirmation" => "hunter3"
        ];

        $this->json('POST', 'api/register', $request)
            ->assertResponseStatus(422);
    }

    private function _createUser()
    {
        $user = factory(App\Models\User::class)->make([
            "password" => bcrypt("hunter2")
        ]);

        $user->save();

        return $user;
    }
}
