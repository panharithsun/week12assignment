<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
    //
    public function index() {
        return response(User::all());
    }

    public function register(Request $request) {
        $field = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $field['name'],
            'email' => $field['email'],
            'password' => bcrypt($field['password'])
        ]);

        $token = $user->createToken('usertoken')->accessToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request) {
        $field = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($field)) {
            $token = auth()->user()->createToken('usertoken')->accessToken;

            return response([
                'user' => $field,
                'token' => $token
            ]);
        } else {
            return response([
                'message' => 'wrong credentials'
            ]);
        }
    }

    public function logout(Request $request) {
        Auth::guard()->logout();

        return response([
            'message' => 'logged out successfully'
        ]);
    }
}
