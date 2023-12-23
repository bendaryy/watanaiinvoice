<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Details;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            return DB::transaction(function () use ($request) {
                // Validated
                $validateUser = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'phone' => 'required|unique:users,phone',
                    'password' => 'required',
                ]);

                if ($validateUser->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Validation error',
                        'errors' => $validateUser->errors(),
                    ], 401);
                }

                // Create user
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone' => $request->phone,
                    'preferred_lang' => $request->preferred_lang,
                ]);

                // Create details record for the user
                $user->details()->create([
                    'id' => $user->id,
                    "company_name" => $request->company_name,
                    'industry' => $request->industry,
                    "client_id" => $request->client_id,
                    "client_secret" => $request->client_secret,
                    "company_id" => $request->company_id,
                    "governate" => $request->governate,
                    "regionCity" => $request->regionCity,
                    "buildingNumber" => $request->buildingNumber,
                    "street" => $request->street,
                    // Add other details fields here
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'User Created Successfully',
                    'token' => $user->createToken("API_TOKEN")->plainTextToken,
                ], 200);
            });
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
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required',
                ]
            );

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
        return DB::transaction(function () use ($request, $id) {
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

            // Update the user
            $user->update($request->all());

            if ($request->filled('password')) {
                // Hash the new password
                $user->password = Hash::make($request->input('password'));
                $user->save();
            }

            // Update or create details
            $detailsData = $request->input('details', []);
            $details = $user->details ?? new Details();
            $details->fill($detailsData);
            $user->details()->save($details);

            // You can access the updated details using $user->details

            return response()->json(['message' => 'User updated successfully', 'user' => $user->load('details')]);
        });
    }
    public function destroy($userId)
    {
        $user = User::find($userId);
        $user->delete();
        return ['message' => "User Deleted"];
    }
}
