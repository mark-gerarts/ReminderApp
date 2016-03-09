<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers;
use Illuminate\Http\Request;
use App\Repositories\User_order\IUser_orderRepository;
use App\Repositories\User\IUserRepository;
use App\Repositories\Quick_reminder\IQuick_reminderRepository;
use Mail;
use Auth;
use Mollie_API_Client;

class PaymentController extends Controller
{
    // An instance of the Mollie_API_Client.
    private $_mollie;

    // The used repositories;
    private $_userOrderRepository;
    private $_userRepository;
    private $_quickReminderRepository;

    public function __construct(IUser_orderRepository $userOrderRepository, IUserRepository $userRepository, IQuick_reminderRepository $quickReminderRepository)
    {
        // Instantiate the mollie client & set the keys.
        $this->_mollie = new Mollie_API_Client;
        $key = env('MOLLIE_API_KEY');
        $this->_mollie->setApiKey($key);

        // Inject the needed repositories.
        $this->_userOrderRepository = $userOrderRepository;
        $this->_userRepository = $userRepository;
        $this->_quickReminderRepository = $quickReminderRepository;
    }

    /**
     * Create a new user order & redirect to the Mollie payment page.
     *
     * @return Response
     */
    public function createUserOrder(Request $request)
    {
        // Authenticate the user.
        $this->middleware('auth');
        $user = Auth::user();

        // Check the payment type in the request.
        $this->validate($request, ['payment_type' => 'numeric|required']);

        // The avaiable payment types. This could be fetched from a DB?
        // However, this is the only place where it is used, so it's a won't-have-now.
        $payment_types = [
            1 => ["amount" => 5, "reminder_credits" => 20],
            2 => ["amount" => 10, "reminder_credits" => 50],
            3 => ["amount" => 15, "reminder_credits" => 150],
        ];

        // Set the order values.
        $values = [
            "user_id" => $user->id,
            "amount" => $payment_types[$request->payment_type]["amount"],
            "reminder_credits" => $payment_types[$request->payment_type]["reminder_credits"]
        ];

        // Create the order and save the ID.
        $identity = $this->_userOrderRepository->insertUserOrder($values);

        // Create the Mollie payment, with the needed details.
        $payment = $this->_mollie->payments->create(array(
            "amount"      => $values["amount"],
            "description" => $values["reminder_credits"] . " reminders.",
            // Note: currently this just redirects to the dashboard homepage, after some processing.
            "redirectUrl" => url('/dashboard/thankyou/' . $identity)
        ));

        // Update the user order with the Mollie payment ID.
        $this->_userOrderRepository->updateUserOrder($identity, ["payment_id" => $payment->id]);

        // Redirect the user to the payment site.
        header("Location: " . $payment->getPaymentUrl());
        exit;
    }

    /**
     * Process the payment.
     *
     * @param int orderID
     * @return Response
     */
    public function userOrderRedirect($id = false)
    {
        // Check if an ID is given.
        if($id)
        {
            // Fetch the requested order.
            $order = $this->_userOrderRepository->getUserOrderById($id);
            if($order)
            {
                // Get the payment associated with the order.
                $payment = $this->_mollie->payments->get($order->payment_id);

                // If the payment is successful, give the user his/her credits.
                if ($payment->isPaid())
                {
                    $user = $this->_userRepository->getUserById($order->user_id);
                    $newCredits = $user->reminder_credits += $order->reminder_credits;
                    $this->_userRepository->updateUser($user->id, ["reminder_credits" => $newCredits]);

                    // The order is (soft) deleted when the credits are received.
                    $this->_userOrderRepository->deleteUserOrder($order->id);
                }
            }
        }

        // Redirect to the dashboard homepage.
        header("Location: " . url('/dashboard'));
        exit;
    }

    /**
     * Create a new quick reminder order & redirect to the Mollie payment page.
     *
     * @return Response
     */
    public function createQuickReminderOrder(Request $request)
    {
        $this->validate($request, [
                'recipient' => 'max:255|required',
                'send_datetime' => 'required',
                'message' => 'required|max:255'
            ]);

        // Set up the new reminder.
        $values = [
            "recipient" => $request->recipient,
            "send_datetime" => $request->send_datetime,
            "message" => $request->message,
            "is_payed" => false
        ];

        // Insert the reminder & get the new ID.
        $identity = $this->_quickReminderRepository->insertQuickReminder($values);

        // Create the Mollie payment.
        $payment = $this->_mollie->payments->create(array(
            // Again, the amount could come from the DB, but is only used once.
            "amount"      => 0.50,
            "description" => "Your quick reminder.",
            "redirectUrl" => url('/thankyou/'.$identity)
        ));

        // Update the reminder with the payment ID.
        $this->_quickReminderRepository->updateQuickReminder($identity, ["payment_id" => $payment->id]);

        // Redirect the user to the Mollie payment page.
        header("Location: " . $payment->getPaymentUrl());
        exit;
    }

    /**
     * Process the quick reminder order.
     *
     * @param sdf
     * @return Response
     */
    public function quickReminderOrderRedirect($id = false)
    {
        if($id)
        {
            // The data variable to be passed to the view.
            $data = [];

            // Get the reminder from the ID.
            $reminder = $this->_quickReminderRepository->getQuickReminderById($id);

            if($reminder)
            {
                $payment = $this->_mollie->payments->get($reminder->payment_id);

                // Check if the payment is successful.
                if ($payment->isPaid())
                {
                    // Update the reminder & set the message.
                    $this->_quickReminderRepository->updateQuickReminder($reminder->id, ["is_payed" => true]);
                    $data["message"] = "We received your payment successfully!";
                }
                else
                {
                    $data["message"] = "There were some problems with your payment.";
                }

                return view('home.paymentcomplete', $data);
            }
        }

        // Redirect if there is no ID given OR if the reminder isn't found (deleted/sent/invalid).
        return view('home.index');
    }
}
