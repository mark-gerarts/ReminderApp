<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use JWTAuth;
use Validate;

class ContactsController extends Controller
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

    public function get(Request $request, $id = NULL)
    {
        $user = Auth::user();

        // if(!$this->_authenticate()) {
        //     echo "Not authenticated ...";
        // }

        if(isset($id))
        {
            $contact = $user->contacts->where('id', $id);
        }
        else
        {
            $contacts = $user->contacts;
            return response()->json($contacts);
        }
    }

    public function insert(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
                'name' => 'required|max:255',
                'number' => 'required|max:20|min:6'
            ]);

        $contact = new Contact;

        $contact->name = $request->name;
        $contact->number = $request->number;
        $contact->user_id = $user->id;

        if($contact->save())
        {
            return response()->json($contact->id);
        }
        else
        {
            return response()->json(false);
        }
    }

    public function delete(Request $request, $id)
    {
        $result = Contact::destroy($id);
        return response()->json($result);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
                'name' => 'required|max:255',
                'number' => 'required|max:20|min:6'
            ]);

        $contact = Contact::find($request->id);
        $contact->name = $request->name;
        $contact->number = $request->number;

        $result = $contact->save();

        return response()->json($result);
    }

    private function _authenticate()
    {
        return JWTAuth::parseToken()->authenticate();
    }
}
