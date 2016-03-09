<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User_reminder;
use App\Repositories\Quick_reminder\IQuick_reminderRepository;
use App\Models\Contact;
use App\Models\User;
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

    private $_quickReminderRepository;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(IQuick_reminderRepository $quickReminder)
    {
        parent::__construct();
        $this->_quickReminderRepository = $quickReminder;
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
        $quick_reminders = $this->_quickReminderRepository->getQuickRemindersWhere([
                ['send_datetime', '<', $now],
                ['is_payed', 1]
            ]);

        foreach($user_reminders as $user_reminder)
        {
            if($user_reminder->repeat_id != 1) {
                $this->_handleRepeatedReminder($user_reminder);
            }
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

    private function _handleRepeatedReminder($reminder)
    {
        $user = User::find($reminder->user_id);
        if($user->reminder_credits == 0)
        {
            return;
        }
        else
        {
            $user->reminder_credits--;
            $user->save();
        }

        $newReminder = new User_reminder;
        $newReminder->recipient = $reminder->recipient;
        $newReminder->contact_id = $reminder->contact_id;
        $newReminder->user_id = $reminder->user_id;
        $newReminder->message = $reminder->message;
        $newReminder->repeat_id = $reminder->repeat_id;

        $newDate = new \DateTime($reminder->send_datetime);

        switch($reminder->repeat_id)
        {
            case 2:
                $newDate->add(new \DateInterval("P1D"));
                break;
            case 3:
                $newDate->add(new \DateInterval("P7D"));
                break;
            case 4:
                $newDate->add(new \DateInterval("P1M"));
                break;
            case 5:
                $newDate->add(new \DateInterval("P1Y"));
                break;
        }

        $newReminder->send_datetime = $newDate;
        $newReminder->save();
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
