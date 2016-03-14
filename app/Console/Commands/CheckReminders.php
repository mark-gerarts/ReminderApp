<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\User\IUserRepository;
use App\Repositories\User_reminder\IUser_reminderRepository;
use App\Repositories\Quick_reminder\IQuick_reminderRepository;
use App\Repositories\Contact\IContactRepository;
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

    // The used repositories.
    private $_quickReminderRepository;
    private $_userReminderRepository;
    private $_userRepository;
    private $_contactRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        IQuick_reminderRepository $quickReminder,
        IUser_reminderRepository $userReminder,
        IUserRepository $user,
        IContactRepository $contact)
    {
        parent::__construct();

        // Inject the needed repositories.
        $this->_quickReminderRepository = $quickReminder;
        $this->_userReminderRepository = $userReminder;
        $this->_userRepository = $user;
        $this->_contactRepository = $contact;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Checking reminders...');

        // The current time.
        $now = date('Y-m-d H:i:s');

        // Get quick + user reminders that need to be sent.
        $user_reminders = $this->_userReminderRepository->getUserRemindersWhere([['send_datetime', '<=', $now]]);
        $quick_reminders = $this->_quickReminderRepository->getQuickRemindersWhere([
                ['send_datetime', '<=', $now],
                // Check if it is payed.
                ['is_payed', 1]
            ]);

        // Iterate both user & quick reminders and send each reminder.
        foreach($user_reminders as $user_reminder)
        {
            // If there is a repeat_id set (1 = never), schedule a new reminder.
            if($user_reminder->repeat_id != 1) {
                $this->_handleRepeatedReminder($user_reminder);
            }

            // Send the reminder & delete it from the DB.
            $this->_sendReminder($user_reminder);
            $this->_userReminderRepository->forceDeleteUserReminder($user_reminder->id);
        }

        foreach($quick_reminders as $quick_reminder)
        {
            // Send the reminder & (soft) delete it from the DB.
            // It's a soft delete because the quick_reminder table also has the payment_id.
            $this->_sendReminder($quick_reminder);
            $this->_quickReminderRepository->deleteQuickReminder($quick_reminder->id);
        }

        // Console output.
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
        // For now: jsut log the message
        $recipient = $this->_getRecipient($reminder);
        Log::info("Sent a message to {$recipient}, with the message: <<{$reminder->message}>>");

        // Replace this code with the following to actually send a message
        // Don't forget to check if the number is valid before sending it to the Twilio API
        // Preferably upon making a reminder instead of upon sendig.

        //Twilio::message($recipient, $reminder->message);
    }

    /**
    * Set up a new reminder if it has a repeat_id.
    *
    * @param Reminder object
    * @return void
    */
    private function _handleRepeatedReminder($reminder)
    {
        // Get the user by user_id.
        $user = $this->_userRepository->getUserById($reminder->user_id);
        // If the user doesn't have enough credits, don't continue.
        // The current reminder will be sent, but no new one will be made.
        // Could make it so that the user gets an email about this, or something.
        if($user->reminder_credits == 0)
        {
            return;
        }
        else
        {
            // Remove a credit from the user.
            $newCredits = $user->reminder_credits - 1;
            $this->_userRepository->updateUser($user->id, ["reminder_credits" => $newCredits]);
        }

        // Get the new date from the repeat_id.
        $newDate = new \DateTime($reminder->send_datetime);
        switch($reminder->repeat_id)
        {
            case 2: // Daily.
                $newDate->add(new \DateInterval("P1D"));
                break;
            case 3: // Weekly.
                $newDate->add(new \DateInterval("P7D"));
                break;
            case 4: // Monthly.
                $newDate->add(new \DateInterval("P1M"));
                break;
            case 5: // Yearly.
                $newDate->add(new \DateInterval("P1Y"));
                break;
        }

        // Set up the new reminder.
        $newReminder = [
            "recipient" => $reminder->recipient,
            "contact_id" => $reminder->contact_id,
            "user_id" => $reminder->user_id,
            "message" => $reminder->message,
            "repeat_id" => $reminder->repeat_id,
            "send_datetime" => $newDate
        ];

        // Insert into the DB.
        $this->_userReminderRepository->insertUserReminder($newReminder);
    }

    /**
    * Gets the recipient from a reminder
    *
    * @param Reminder object
    * @return string
    */
    private function _getRecipient($reminder)
    {
        //If a recipient is set, return that; otherwise return the contact's number.
        if($reminder->recipient)
        {
            return $reminder->recipient;
        }
        else
        {
            // Fetch the contact and return its number.
            $contact = $this->_contactRepository->getContactById($reminder->contact_id);
            return $contact->number;
        }
    }

    /**
    * Send a number to the Twilio lookup API.
    * This checks if the number is valid.
    * This method isn't currently used, but I put it here in case I need it in the future.
    *
    * @param Reminder object
    * @return void
    */
    public function lookupNumber($number)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://lookups.twilio.com/v1/PhoneNumbers/" . $number);
        curl_setopt($ch, CURLOPT_USERPWD, env('TWILIO_SID') . ':' . env('TWILIO_TOKEN'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output);
    }
}
