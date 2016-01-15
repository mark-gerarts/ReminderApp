<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Contact;
use Illuminate\Http\Request;
use Auth;
use Validate;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view('dashboard.home');
    }
    
    public function contacts(Request $request)
    {
        //ToDo: move to separate controller ---> eventually api
        $user = Auth::user();
        
        if($request->isMethod('post'))
        {
            $this->validate($request, [
                'name' => 'required|max:255',
                'number' => 'required|max:20|min:6'
            ]);
            
            $contact = new Contact;
            
            $contact->name = $request->name;
            $contact->number = $request->number;
            $contact->user_id = $user->id;
            
            $contact->save();
        }
        
        $data['contacts'] = $user->contacts;
        
        return view('dashboard.contacts', $data);
        
    }
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'number' => 'required|max:20|min:6'
        ]);
    }
}
