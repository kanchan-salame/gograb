<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use App\Http\Requests\UpdateProfileApiRequest;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string',
        //     'email'=>'required|string|unique:users',
        //     'password'=>'required|string',
        //     'c_password' => 'required|same:password'
        // ]);

        $user = new User([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user',
        ]);

        if ($user->save()) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'message' => 'Successfully created user!',
                'accessToken' => $token,
                'status' => 200,
                'message' => 'Register Successfully! Welcome to Our Community'
            ], 201);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }


    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'token_type' => 'Bearer',
            'status' => 200,
            'user' => $user,
            'message' => 'Successfully Login! Welcome Back'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out',
            'status' => 200,
        ]);
    }

    /**
     * Update user profile (Revoke the token)
     *
     * @return [string] message
     */
    public function updateProfile(UpdateProfileApiRequest $request)
    {
        $user = $request->user();
        $user->name = $request['name'];
        $user->last_name = $request['last_name'];
        $user->gender = $request['gender'];
        $user->phone = $request['phone'];

        if ($request->hasFile('image')) {
            $profile_photo_path = $request->file('image')->store('profile-photos/');
        } else {
            $profile_photo_path = null;
        }
        $user->profile_photo_path = $profile_photo_path;

        $user->update();

        return response()->json([
            'message' => 'Successfully updated profile.',
            'status' => 200,
        ]);
    }
}
