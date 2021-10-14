<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('name', $fields['name'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Please try again'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'username' => $user->name,
            'token' => $token
        ];
        return response($response, 201);
    }

    public function logout(Request $request) {
        $user = User::where('name', $request->username)->first();

        $user->tokens->each(function($token, $key) {
            $token->delete();
        });
    
        return response()->json('Successfully logged out');
    }


    /*------ Register -------*/
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

}
