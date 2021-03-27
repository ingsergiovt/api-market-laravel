<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register (Request $request){
        // return $request;

        // $rules = ['name'      => 'required|string|max:255'];
        // $validator = Validator::make($request->all(), $rules);

        // if($validator->fails()){
        //     return $validator->errors();
        // }

        $validateData = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8'
        ]);

        $user = User::create([
            'name'      => $validateData['name'],
            'email'     => $validateData['email'],
            'password'  => Hash::make($validateData['password'])
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'acces_token' => $token,
            'token_type' => 'Bearer'
        ],200);
    }

    public function login(Request $request) {

        if(!Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'message' => 'Invalid login details',

            ],401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'acces_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ],200);
    }

    public function user(Request $request){
        return $request->user();
    }
}
