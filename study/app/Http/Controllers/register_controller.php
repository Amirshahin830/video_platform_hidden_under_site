<?php

namespace App\Http\Controllers;


use App\Models\User;
use http\Env\Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class register_controller extends Controller
{
    public function authenticate_manually(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if($validate->fails()){
            return response()->json($validate->errors(),422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        $token = $user->createToken('auth_token');

        return $token->plainTextToken;
    }

}
