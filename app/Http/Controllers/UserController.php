<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Register Function

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json([
            'code' => 200,
            'result' => [
                'succes' => true,
                'message' => 'Register success',
                'data' => $user
            ]
        ], 200);
    }

    // Login Function

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json([
                'code' => 200,
                'result' => [
                    'succes' => true,
                    'message' => 'Login success',
                    'data' => $data,
                ],
                'token' => $token,
            ], 200);
        } else {
            return response()->json([
                'code' => 401,
                'result' => [
                    'error' => true,
                    'message' => 'Unauthorised',
                    'data' => $data,
                ]
            ], 401);
        }
    }
}
