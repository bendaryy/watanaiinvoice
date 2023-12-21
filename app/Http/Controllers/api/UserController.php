<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function allUsersForAdmin()
    {
        $users = User::latest()->get();
        return $users->load('details');
    }
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'phone' => 'required|unique:users,phone',
                    'password' => 'required',
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                "phone" => $request->phone,
                "preferred_lang" => $request->preferred_lang,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API_TOKEN")->plainTextToken,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required',
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API_TOKEN")->plainTextToken,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }

    }
    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();

        return [
            'message' => 'you are logged out',
        ];
    }

    public function getUserByPhoneNumber(Request $request)
    {
        // $users=DB::table('users')->select('name','phone_no')->get();
        $userPhone = $request->phone;
        $user = User::where('phone', $userPhone)->get();
        return $user->load('details');
    }
    public function editUserData(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the request data
        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'phone' => 'unique:users,phone,' . $user->id,
            // Add more validation rules as needed
        ];
        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            // If validation fails, return a custom error message
            return response()->json(['error' => $e->validator->errors()->first()], 422);
        }
        $user->update($request->all());

        if ($request->filled('password')) {
            // Hash the new password
            $user->password = Hash::make($request->input('password'));
            $user->save();
        }

// Update the user

        return response()->json(['message' => 'User updated successfully', 'user' => $user->load('details')]);

    }
    public function destroy($userId)
    {
        $user = User::find($userId);
        $user->delete();
        return ['message' => "User Deleted"];

    }
}
