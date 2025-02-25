<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:admins',
                'password' => 'required|min:6',
            ]);

            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['message' => 'Admin registered successfully', 'admin' => $admin], 201);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Admin registration failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            $token = $admin->createToken('admin-token')->plainTextToken;

            return response()->json([
                'message' => 'Logged in as admin',
                'admin' => $admin,
                'token' => $token,
            ], 200);
        }

        return response()->json(['message' => 'Invalid email or password.'], 422); // Changed status code to 422 for consistency
    }


    public function logout(Request $request)
    {
        Auth::guard('admin')->user()->tokens()->delete();

        return response()->json(['message' => 'Admin Logout successful'], 200);
    }

    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        return response()->json(['message' => 'Admin Dashboard', 'admin' => $admin], 200);
    }

    public function getUser()
    {
        $admin = Auth::guard('admin')->user();
        if ($admin) {
            return response()->json(['admin' => $admin], 200);
        } else {
            return response()->json(['message' => 'Admin user not found'], 404); // Or 404 if user not found
        }
    }
}