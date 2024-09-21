<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 401,
                'success' => false,
                'message' => 'Validation Error.',
                'errors' => $validator->errors()
            ], 401);
        }

        // Retrieve the validated input...
        $validated = $validator->validated();
        $validated['password'] = bcrypt($validated['password']);
        // Simpan data pengguna ke database
        $user = User::create($validated);

        $token =  $user->createToken('auth_token')->plainTextToken;
        $name =  $user->name;

        return response()->json([
            'code' => 200,
            'message' => 'User created successfully.',
            'data' => [
                'token' => $token,
                'name' => $name
            ]
        ], 201);
    }
    
    public function login(Request $request) {

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'code' => 401,
                'success' => false,
                'message' => 'Authentication Gagal!',
                'data' => null
              ]);
        } 

        $auth = Auth::user();
        $token = $auth->createToken('auth_token')->plainTextToken;
    
        $name = $auth->name;
    
        return response()->json([
            'success' => true,
            'message' => 'Login sukses',
            'data' => [
                'token' => $token,
                'name' => $name
            ]
        ]);
      }
}
