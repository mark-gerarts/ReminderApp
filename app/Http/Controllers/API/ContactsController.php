<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Validate;

class ContactsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    // Has $id = NULL for now - can be removed (and in routes.php) if I end up
    // Not using it.
    public function get(Request $request, $id = NULL)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if(!$user) {
            return response()->json('Not logged in', 401);
        }

        return response()->json($user->contacts);
    }

    public function insert(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if(!$user) {
            return response()->json('Not logged in');
        }

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
        $user = JWTAuth::parseToken()->authenticate();

        if(!$user) {
            return response()->json('Not logged in');
        }

        //ToDo: check if contact is really one of authenticated user's contacts

        $result = Contact::destroy($id);
        return response()->json($result);
    }

    public function update(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if(!$user) {
            return response()->json('Not logged in');
        }

        $this->validate($request, [
                'name' => 'required|max:255',
                'number' => 'required|max:20|min:6'
            ]);

        //ToDo: check if contact is really one of authenticated user's contacts
        $contact = Contact::find($request->id);
        $contact->name = $request->name;
        $contact->number = $request->number;

        $result = $contact->save();

        return response()->json($result);
    }
}
