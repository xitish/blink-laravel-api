<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\User;

class UserController extends Controller
{
    public function updateToken(Request $request)
    {
        $this->validate($request, [
            'firebase_token' => 'required'
        ]);

        if(! $user = JWTAuth::parseToken()->authenticate()){
            return response()->json(['msg' => 'User Not Found'], 200);
        }

        User::where('id', $user->id)->update(['firebase_token' => $request->input('firebase_token')]);
        return response()->json(['msg' => 'Token Updated'], 200);
    }
}
