<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|string|confirmed|max:16'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors(), 422);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole('reader');
        $token = $user->createToken('nerdy-spot')->plainTextToken;
        return response()->json([
            'data' => ['user' => $user, 'token' => $token],
            'errors' => [],
            'condition' => true,
            'message' => "အောင်မြင်စွာ စာရင်းပေးသွင်းပြီးပါပြီ။"
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return $this->fail($validator->errors(), 403);
        }
        $user = User::where('email', $request->email)->first();
        if($user){
            if(Hash::check($request->password, $user->password))
            {
                $token = $user->createToken('nerdy-spot')->plainTextToken;
                return response()->json([
                    'data' => ['user' => $user, 'token' => $token],
                    'errors' => [],
                    'condition' => true,
                    'message' => "အောင်မြင်စွာ လော့ဂ်အင်ဝင်ပြီးပါပြီ။"
                ]);
            }else
            {
                return $this->fail(["message" => "စကားဝှက်မှားနေပါသည်။"] , 401);
            }
        }else {
            return $this->fail(['message' => "ယခု အီးမေးလ်ဖြင့် အသုံးပြုထားသူမရှိပါ။"], 404);
        }
    }
}
