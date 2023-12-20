<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function user()
    {
        $user = User::all();
        if ($user->count() > 0) {
            $data = [
                'status' => 200,
                'users' => $user,
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No record found',
            ];

            return response()->json($data, 200);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8',

        ]);

        if ($validator->fails()) {
            // Handle validation failure
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
            ], 400);
        } else {
            // Check if the email already exists
            if (User::where('email', $request->email)->exists()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Email already exists',
                ], 400);
            }

            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'User registered successfully',
                'user' => $user,
            ], 200);
        }

    }
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24); // 1 day

        return response([
            'message' => $token
        ])->withCookie($cookie);
    }

    public function userToken()
    {
        return Auth::user();
    }

   // AuthController.php

   public function logout(Request $request)
   {
       // Delete all tokens for the authenticated user
       $request->user()->tokens()->delete();

       // Return success message as JSON
       return response()->json(['message' => 'Logged out']);
   }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ], 404);
        }

        if ($user->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Error when deleting',
            ], 500);
        }
    }


    public function update($id, Request $request)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 404,

                'message' => 'no user',
            ], 404);
        } else {
            $user->update($request->all());
            return response()->json([
                'status' => 200,
                'message' => 'updated successfully',
                'user' => $user
            ], 200);
        }

    }



    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ], 404);
        } else {
            return response()->json([
                'status' => 200,
                'user' => $user,
            ], 200);
        }
    }


}
