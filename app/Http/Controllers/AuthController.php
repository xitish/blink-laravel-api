<?php

namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required|unique:users',
            'password' => 'required|min:8',
        ]);

        $fname = $request->input('first_name');
        $lname = $request->input('last_name');
        $username = $request->input('user_name');
        $password = $request->input('password');

        $user = User::create([
            'first_name' => $fname,
            'last_name' => $lname,
            'user_name' => $username,
            'password' => Hash::make($password),
            'credit' => 0,
        ]);

        $reponse = [
            'message' => 'New User Created',
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
        ];

        return response()->json($reponse, 200);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'user_name' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('user_name', 'password');
        
        try {
            if(! $token = JWTAuth::attempt($credentials)){
                return response()->json(['msg' => 'Login Failed, Ivalid Credentials', 'success' => false], 200);
            }

        }   catch (JWTException $e){
                return response()->json(['msg' => 'Token Creation Failed', 'success' => false], 500);
        }
        return response()->json(['token' => $token, 'success' => true]);
    }
}
