<?php

namespace App\Http\Controllers\APIAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user_id = str_replace("ediag", "", $request->shop_id);

        $credentials = [
            'id' => $user_id,
            'password' => $request['password'],
        ];

        if (Auth::attempt($credentials)) {
            $user = User::find($user_id);

            $token = $user->createToken('auth_token')->plainTextToken;


            return response()->json([
                                        'access_token' => $token,
                                        'token_type' => 'Bearer',
                                    ]);
        } else {
            return response()->json([
                                        'message' => 'Invalid login details'
                                    ], 401);
        }
    }
}
