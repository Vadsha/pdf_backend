<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|string|confirmed|max:16'
        ]);
        if($validator->fails()){
            return $validator->errors();
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole('customer');
        $token = $user->createToken('pdf-collection')->plainTextToken;
        return response()->json([
            'data' => ['user' => $user, 'token' => $token],
            'errors' => [],
            'condition' => true
        ]);
    }
}
