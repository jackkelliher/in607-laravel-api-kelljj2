<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    //Registering users
    public function register(Request $request) {
        //Validating request data

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        //Checking if email already exsists in database
        if(User::where('email', '=', $request->get('email'))->count() > 0){
            return $validator->messages()->get('*');
        }

        if($validator->fails()) {
            return $validator->messages()->get('*');
        } else {
            //Creating user if validated 
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password'))
            ]);

            //Response
            $response = [
                'message' => 'User created successfully',
                'status' => 201 //Successful status
            ];

            return response($response, 201);
        }
    }

    public function login(Request $request) {
        //Validating login details (Making sure a email and password have been entered)
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        //Finding user
        $user = User::where('email', $fields['email'])->first();

        //Checking if passwords match
        if(!$user || !Hash::check($fields['password'], $user->password)) { //If passwords do not match
            return response([
                'message' => 'Bad credentials'
            ], 401);
        } else { //If passwords match
            $token = $user->createToken('P@ssw0rd')->plainTextToken;
        }

        //Creating repsponce
        $response = [
            'user' => $user,
            'token' => $token,
            'message' => 'User logged in successfully',
            'status' => 201 //Successful status
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Successfully logged out.'
        ];
    }
}
