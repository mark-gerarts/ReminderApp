<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Quick_reminder;
use Mail;
use Twilio;
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
        $reminder->save();

        $payment = $this->_mollie->payments->create(array(
            "amount"      => 0.50,
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
            app('App\Http\Controllers\HomeContoller')->index();
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
