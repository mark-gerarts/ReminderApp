<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Mail;
use Validate;
use Log;

class HomeController extends Controller
{
    /**
     * Show the website homepage.
     *
     * @return Response
     */
    public function index()
    {
        return view('home.index');
    }

    /**
     * Show the pricing page.
     *
     * @return Response
     */
    public function pricing()
    {
        return view('home.pricing');
    }

    /**
     * Show the contact page.
     *
     * @return Response
     */
    public function contact()
    {
        return view('home.contact');
    }

    /**
     * Handle the contact form submit.
     *
     * @param POST request
     * @return Response
     */
    public function handleContactSubmit(Request $request)
    {
        $this->validate($request, [
                'email' => 'email',
                'subject' => 'required|max:255',
                'message' => 'required'
            ]);

        $emailData = [
            "email" => $request->email,
            "subject" => $request->subject,
            "msg" => $request->message
        ];

        // ToDo:
        //
        // Mail::send('emails.contact', $emailData, function($m) use($request) {
        //     $m->from('localhost@mail.com', 'localhost');
        //     $m->to(env('CONTACT_EMAIL'))->subject($request->subject);
        // });
        //
        // Log::info(Mail::failures());

        $data["message"] = "Message sent.";

        return view ('home.contact', $data);
    }
}
