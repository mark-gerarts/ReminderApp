<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Quick_reminder;
use App\Models\User_order;
use App\Models\User;
use Mail;
use Twilio;
use Auth;
use Mollie_API_Client;

class PaymentController extends Controller
{
    private $_mollie;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_mollie = new Mollie_API_Client;
        $key = env('MOLLIE_API_KEY');
        $this->_mollie->setApiKey($key);
    }

    public function createUserOrder(Request $request)
    {
        $this->middleware('auth');
        $user = Auth::user();

        $this->validate($request, ['payment_type' => 'numeric|required']);

        $payment_types = [
            1 => ["amount" => 5, "reminder_credits" => 10],
            2 => ["amount" => 18, "reminder_credits" => 40],
            3 => ["amount" => 40, "reminder_credits" => 100],
        ];

        $order = new User_order;
        $order->user_id = $user->id;
        $order->amount = $payment_types[$request->payment_type]["amount"];
        $order->reminder_credits = $payment_types[$request->payment_type]["reminder_credits"];
        $order->save();

        $payment = $this->_mollie->payments->create(array(
            "amount"      => $order->amount,
            "description" => "Your RemindMe payment for " . $order->amount ." reminder credits.",
            "redirectUrl" => url('/dashboard/thankyou/'.$order->id)
        ));

        $order->payment_id = $payment->id;
        $order->save();

        header("Location: " . $payment->getPaymentUrl());
        exit;
    }

    public function userOrderRedirect($id = false)
    {
        if($id)
        {
            $order = User_order::find($id);
            if($order)
            {
                $payment = $this->_mollie->payments->get($order->payment_id);

                if ($payment->isPaid())
                {
                    $user = User::find($order->user_id);
                    $user->reminder_credits += $order->reminder_credits;
                    $user->save();

                    $order->delete();
                }
            }
        }
        header("Location: " . url('/dashboard'));
        exit;
    }

    public function createQuickReminderOrder(Request $request)
    {
        //Create quick reminder
        $this->validate($request, [
                'recipient' => 'max:255|required',
                'send_datetime' => 'required',
                'message' => 'required|max:255'
            ]);

        $reminder = new Quick_reminder;
        $reminder->recipient = $request->recipient;
        $reminder->send_datetime = $request->send_datetime;
        $reminder->message = $request->message;
        $reminder->is_payed = false;
        $reminder->save();

        $payment = $this->_mollie->payments->create(array(
            "amount"      => 0.55,
            "description" => "Your quick reminder.",
            "redirectUrl" => url('/thankyou/'.$reminder->id)
        ));

        $reminder->payment_id = $payment->id;
        $reminder->save();

        header("Location: " . $payment->getPaymentUrl());
        exit;
    }

    public function quickReminderOrderRedirect($id = false)
    {
        if(!$id)
        {
            header("Location: " . url('/'));
            exit;
        }
        else
        {
            $data = [];
            $reminder = Quick_reminder::find($id);
            if($reminder)
            {
                $payment = $this->_mollie->payments->get($reminder->payment_id);

                if ($payment->isPaid())
                {
                    $reminder->is_payed = true;
                    $reminder->save();

                    $data["message"] = "We received your payment successfully!";
                }
                else
                {
                    $data["message"] = "There were some problems with your payment.";
                }

                return view('home.paymentcomplete', $data);
            }
            else
            {
                return view('home.index');
            }


        }
    }
}
