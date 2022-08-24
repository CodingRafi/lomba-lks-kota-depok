<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($validatedData, $request->remember)) {
            $user = User::where('email', $request->email)->get()->first();

            $token = $user->createToken('auth_token')->plainTextToken;

            $user->api_token = $token;
            $user->save();

            return response()->json([
                'message' => 'Berhasil Login',
                'token' => $token,
            ], 200);
        }

        return response()->json([
            'message' => 'Gagal Login',
        ], 401);
    }

    public function reset(Request $request)
    {
        $token = $request->header('Authorization');
        $token = explode(' ', $token)[1];

        $user = User::where('api_token', $token)->first();
        
        if ($request->new_password == $request->confirm_new_password) {
            if (\Hash::check($request->old_password, $user->password)) {
                $user->password = \Hash::make($request->new_password);
                $user->save();
                
                return response()->json([
                    'code' => 200,
                    'message' => 'reset success, user logged out',
                ], 200);
            } else {
                return response()->json([
                    'code' => 500,
                    'message' => 'reset password was fails',
                ], 500);
            }
        } else {
            return response()->json([
                'code' => 422,
                'message' => 'old password did not match',
            ], 422);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        $token = explode(' ', $token)[1];

        $user = User::where('api_token', $token)->first();
        $user->api_token = null;
        $user->save();

        return response()->json([
            'message' => 'Berhasil Logout',
        ], 200);
    }

    public function profil(Request $request){
        $token = $request->header('Authorization');
        $token = explode(' ', $token)[1];

        $user = User::where('api_token', $token)->first();

        return response()->json($user, 200);
    }
}
