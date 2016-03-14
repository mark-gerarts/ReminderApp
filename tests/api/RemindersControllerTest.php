<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RemindersControllerTest extends TestCase
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
    }

    public function testGetUpcoming()
    {
        $reminders = factory(App\Models\User_reminder::class, 5)->make([
            "user_id" => $this->_user->id
        ]);
        foreach($reminders as $reminder)
        {
            $reminder->save();
        }

        $this->get('api/reminders/upcoming', $this->_headers())
            ->seeJsonStructure([
                '*' => ["id", "user_id", "recipient", "contact_id", "send_datetime", "repeat_id"]
            ]);
    }

    public function testInsertReminder()
    {
        $reminder = factory(App\Models\User_reminder::class)->make();

        $request = [
            "recipient" => $reminder->recipient,
            "send_datetime" => $reminder->send_datetime,
            "message" => $reminder->message,

        ];

        //Continue here
    }

    private function _createUser()
    {
        $user = factory(App\Models\User::class)->make([
            "name" => "TestName",
            "email" => "test@email.com",
            "reminder_credits" => 10
        ]);

        $user->save();

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
