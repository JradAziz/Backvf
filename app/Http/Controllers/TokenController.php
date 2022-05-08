<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class TokenController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($request->only('email', 'password'))) {
            throw new AuthenticationException();
        }

        return [
            'token' => auth()->user()->createToken($request->deviceId)->plainTextToken
        ];
    }

    public function destroy(Request $request)
    {
        auth()->user()->tokens()->where('name', $request->deviceId)->delete();
    }
    
    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }
        
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }


    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
    public function reset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        $token = $request->token;
        $passwordRest = DB::table('password_resets')->where('token', $token)->first();

        // Verify
        if(!$passwordRest){
                        return response([
                'message' => 'Bad creds'
            ], 401);

        }

        // Validate exipire time
        if(!$passwordRest->created_at >= now()){
            return response(['message' => 'Token has expired.'], 200);
        }

        $user = User::where('email', $passwordRest->email)->first();

        if(!$user){
            return response(['message' => 'User does not exists.'], 200);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('token', $token)->delete();;

        return response(['message'=>'Password Successfully Updated.'], 200);
    }



    public function change(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'id' => 'required',

        ]);

        $id = $request->id;
        $h = DB::table('users')->where('id', $id)->first();

        // Verify
        if(!$h){
                        return response([
                'message' => 'Bad creds'
            ], 401);

        }

        $user = User::where('id', $h->id)->first();

        if(!$user){
            return response(['message' => 'User does not exists.'], 200);
        }

        $user->email = ($request->email);
        $user->save();


        return response(['message'=>'Email Successfully Updated.'], 200);
    }



   


}
