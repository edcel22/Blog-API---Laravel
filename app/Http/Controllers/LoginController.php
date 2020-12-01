<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginController extends Controller
{
    //
    public function login (Request $r) 
    {
    	/*
		** Best way specially if you want the errors displayed separately
    	*/
    	$validator = \Validator::make($r->all(), [
            'email' => 'required | email',
            'password' => 'required',
        ]);

    	//check request data if passed the validator
        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all()
            ], 403);
        }
        //query users where existing email in db is equal to the request->email
    	$user = User::where('email', $r->email)->first();

    	//if return yes - check password, if not return user not found.
        if ($user) {
        	// if  request password is equal to user password then create and return access token
        	if (Hash::check($r->password, $user->password)) {
                $token = $user->createToken('Auth Token')->accessToken;

                return response([
                	'token' => $token
                ], 200);
        	} else {
        		return response([
        			'errors' => [
        				'Wrong Password. Please try Again!'
        			]
        		], 403);
        	}

        } else {	
        	return response([
        		'errors' => [
        			'User not found. Please try again!'
        		]
        	], 404);
        }

        /*
		** Second way around it
        */
        // $request->validate([
    	// 	'email' => ['required', 'email'],
    	// 	'password' => ['required']
    	// ]);

    	// $user = User::where('email', $request->email)->first();

    	// if (!$user || !Hash::check($request->password, $user->password)) {
    	// 	throw ValidationException::withMessages([
    	// 		'email' => ['the provided credentials are incorrect']
    	// 	]);
    	// }

    	// return $user->createToken('Auth Token')->accessToken;

    }

    public function logout (Request $request)
    {
    	if ($request->user()) {
    	 	$token = $request->user()->token();
    	 	$token->revoke();
    	}
    	/*
    		short code for deleting the token
    		$request->user()->tokens()->delete();
    	*/

    	return response("You've successfully logged out", 200);
    }
}
