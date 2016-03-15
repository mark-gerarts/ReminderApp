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
        $reminders = factory(App\Models\User_reminder::class, 5)->create([
            "user_id" => $this->_user->id
        ]);

        $this->get('api/reminders/upcoming', $this->_headers())
            ->seeJsonStructure([
                '*' => ["id", "user_id", "recipient", "contact_id", "send_datetime", "repeat_id"]
            ]);
    }

    public function testInsertReminderGoodData()
    {
        $reminder = factory(App\Models\User_reminder::class)->make();

        $request = [
            "recipient" => $reminder->recipient,
            "send_datetime" => $reminder->send_datetime,
            "message" => $reminder->message,
            "repeat_id" => $reminder->repeat_id
        ];

        $creditsBefore = $this->_user->reminder_credits;

        $this->json('POST', 'api/reminders', $request, $this->_headers())
            ->assertResponseOk();

        $this->seeInDatabase('user_reminders', [
            "recipient" => $request["recipient"],
            "send_datetime" => $request["send_datetime"],
            "message" => $request["message"],
            "repeat_id" => $request["repeat_id"]
        ]);

        $this->seeInDatabase("users", [
            "id" => $this->_user->id,
            "reminder_credits" => ($creditsBefore - 1)
        ]);
    }

    public function testInsertReminderBadData()
    {
        $reminder = factory(App\Models\User_reminder::class)->make();

        //No recipient
        $request = [
            "send_datetime" => $reminder->send_datetime,
            "message" => $reminder->message,
            "repeat_id" => $reminder->repeat_id
        ];

        $this->json('POST', 'api/reminders', $request, $this->_headers())
            ->assertResponseStatus(422);

        //No datetime
        $request = [
            "recipient" => $reminder->recipient,
            "message" => $reminder->message,
            "repeat_id" => $reminder->repeat_id
        ];

        $this->json('POST', 'api/reminders', $request, $this->_headers())
            ->assertResponseStatus(422);

        //No message
        $request = [
            "recipient" => $reminder->recipient,
            "send_datetime" => $reminder->send_datetime,
            "repeat_id" => $reminder->repeat_id
        ];

        $this->json('POST', 'api/reminders', $request, $this->_headers())
            ->assertResponseStatus(422);

        //No repeat_id
        $request = [
            "recipient" => $reminder->recipient,
            "send_datetime" => $reminder->send_datetime,
            "message" => $reminder->message
        ];

        $this->json('POST', 'api/reminders', $request, $this->_headers())
            ->assertResponseStatus(422);

        //User with no credits
        $this->_user->reminder_credits = 0;
        $this->_user->save();

        $reminder = factory(App\Models\User_reminder::class)->make();

        $request = [
            "recipient" => $reminder->recipient,
            "send_datetime" => $reminder->send_datetime,
            "message" => $reminder->message,
            "repeat_id" => $reminder->repeat_id
        ];

        $this->json('POST', 'api/reminders', $request, $this->_headers())
            ->assertResponseStatus(402);

        $this->_user->reminder_credits = 10;
        $this->_user->save();
    }

    public function testCancelReminderGoodData()
    {
        $reminder = factory(App\Models\User_reminder::class)->create([
            "user_id" => $this->_user->id
        ]);

        $creditsBefore = $this->_user->reminder_credits;

        $this->get('api/reminders/cancel/' . $reminder->id, $this->_headers())
            ->assertResponseOk();

        $this->dontSeeInDatabase("user_reminders", [
            "id" => $reminder->id
        ]);

        //See if credit is refunded
        $this->seeInDatabase("users", [
            "id" => $this->_user->id,
            "reminder_credits" => ($creditsBefore + 1)
        ]);
    }

    public function testCancelReminderBadData()
    {
        $reminder = factory(App\Models\User_reminder::class)->create([
            "user_id" => $this->_user->id
        ]);

        // No id given
        $this->get('api/reminders/cancel/', $this->_headers())
            ->assertResponseStatus(422);

        // Reminder that doesnt belong to the user
        $altUser = factory(App\Models\User::class)->create();
        $altReminder  =factory(App\Models\User_reminder::class)->create([
            "user_id" => $altUser->id
        ]);

        $this->get('api/reminders/cancel/' . $altReminder->id , $this->_headers())
            ->assertResponseStatus(403);

        // Reminder that doesn't exist
        $reminder = factory(App\Models\User_reminder::class)->create([
            "user_id" => $this->_user->id
        ]);
        $id = $reminder->id;
        $reminder->forceDelete();

        $this->get('api/reminders/cancel/' . $id , $this->_headers())
            ->assertResponseStatus(404);
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
