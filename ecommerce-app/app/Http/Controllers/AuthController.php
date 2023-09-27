<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $req) {
        try {
            $validation = Validator::make($req -> all() ,[
                'userName' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6'
            ]);

            if($validation->fails()){
                return response()->json([
                    'status' => 401,
                    'message' => 'validation error',
                    'errors' => $validation->errors()
                ], 401);
            }

            if(User::where('email',$req->input('email'))->exists()){
                return response()->json([
                    'status' => 400,
                    'message' => 'Email đã tồn tại !',
                ], 400);
            }

            $user = User::create([
                'name' => $req->input('userName'),
                'email' => $req->input('email'),
                'password' => Hash::make($req->input('password'))
            ]);
            $token = $user->createToken("token-name")->plainTextToken;
            $cookie = cookie('jwt', $token, 60 * 24);
            return response()->json([
                'status' => 200,
                'message' => 'đăng ký thành công !',
                'token' => $token
            ],200)->withCookie($cookie);
           
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    public function login(Request $req) {
        try {
            $validation = Validator::make($req -> all() ,[
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if($validation->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validation->errors()
                ], 401);
            }
            if(!Auth::attempt($req->only(['email', 'password']))){
                return response()->json([
                    'status' => 400,
                    'message' => 'Tài khoản không đúng',
                ], 400);
            }

            $user = User::where('email', $req->email)->first();
            $token = $user->createToken("token-name")->plainTextToken;
            $cookie = cookie('jwt', $token, 60 * 24);
            return response()->json([
                'status' => 200,
                'message' => 'Đăng nhập thành công !',
                'token' => $token
            ], 200)->withCookie($cookie);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function user() {
        return Auth::user();
    }
}
