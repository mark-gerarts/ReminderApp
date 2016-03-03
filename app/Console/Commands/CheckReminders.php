<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User_reminder;
use App\Models\Quick_reminder;
use App\Models\Contact;
use Log;
use Twilio;

class CheckReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks if there are reminders that need to be sent & sends them';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //ToDo: check reminders to be sent
        $this->info('Checking reminders...');
        $now = date('Y-m-d h:m:s');

        $user_reminders = User_reminder::where('send_datetime', '<', $now)->get();
        $quick_reminders = Quick_reminder::where('send_datetime', '<', $now)->where('is_payed', 1)->get();

        foreach($user_reminders as $user_reminder)
        {
            $this->_sendReminder($user_reminder);
        }

        foreach($quick_reminders as $quick_reminder)
        {
            $this->_sendReminder($quick_reminder);
        }

        $this->info('Done. Sent ' . (count($user_reminders) + count($quick_reminders)) . ' reminders.');
    }

    /**
    * Gets the recipient from a reminder
    *
    * @param Reminder object
    * @return void
    */
    private function _sendReminder($reminder)
    {
        $recipient = $this->_getRecipient($reminder);
        Log::info("Sent a message to {$recipient}, with the message: <<{$reminder->message}>>");
        // ToDo: schedule a cleanup task as well, which permanently deletes stuff.
        $reminder->delete();

        // Replace this code with the following to actually send a message
        // Don't forget to check if the number is valid before sending it to the Twilio API
        // Preferably upon making a reminder instead of upon sendig.
        // Twilio::message($recipient, $reminder->message);
    }

    /**
    * Gets the recipient from a reminder
    *
    * @param Reminder object
    * @return string
    */
    private function _getRecipient($reminder)
    {
        if($reminder->recipient)
        {
            return $reminder->recipient;
        }
        else
        {
            $contact = Contact::find($reminder->contact_id);
            return $contact->number;
        }
    }
}
