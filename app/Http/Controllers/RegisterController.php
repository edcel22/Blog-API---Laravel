<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    //
    public function register (Request $r) {
    	//setup the validation
        $validator = \Validator::make($r->all(), [
    		'name' => 'required',
    		'email' => 'required|email|unique:users',
    		'password' => 'required|min:8',
    		// 'password' => 'required|min:8|confirmed',
        ]);

        //validate the request
    	if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all()
            ], 403);
        }

    	//save user to db
    	$user = User::create([
    		'name' => $r->name,
    		'email' => $r->email,
    		'password' => Hash::make($r->password)
    	]);

    	//generate token 
        $token = $user->createToken('Auth Token')->accessToken;

        //return token
    	return response([
    		'success' => 'successfully registered',
    		'token' => $token,
    	],200);

    }
}
