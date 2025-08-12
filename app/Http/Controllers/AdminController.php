<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function admin_login_page()
    {
        try {
            return view('form.admin.admin_login_form');
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }

    public function admin_registration_page()
    {
        try {
            return view('form.admin.admin_registration_form');
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }

    public function admin_registration_store(Request $request)
    {
        try {
            // Validate data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed', // password_confirmation ফিল্ড দরকার
                'role' => 'required|in:admin,teacher,staff,editor,student,parent',
            ]);

            DB::beginTransaction();

            // Create user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            // Create admin with only user_id (other fields nullable)
            Admin::create([
                'user_id' => $user->id,
            ]);

            DB::commit();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Admin registered successfully',
                ],
                201,
            );
        } catch (ValidationException $ex) {
            // Validation error response (frontend এ দেখতে পারবে কোন ফিল্ডে সমস্যা)
            return response()->json(
                [
                    'status' => 'fail',
                    'errors' => $ex->errors(), // array of validation errors keyed by input field
                ],
                422,
            );
        } catch (\Exception $ex) {
            DB::rollBack();
            // General error response
            return response()->json(
                [
                    'status' => 'fail',
                    'message' => $ex->getMessage(),
                ],
                500,
            );
        }
    }

    public function admin_login_store(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:8',
                'role' => 'required|in:admin',
            ]);

            $user = User::where('email', $validated['email'])->first();

            if (!$user) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Email not found',
                    ],
                    404,
                );
            }

            if (!Hash::check($validated['password'], $user->password)) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Invalid password',
                    ],
                    401,
                );
            }

            if ($user->role !== 'admin') {
                return response()->json(
                    [
                        'status' => 'fail',
                        'message' => 'Access denied! Only admin can login.',
                    ],
                    403,
                );
            }

            // Clear old tokens and create new token
            //$user->tokens()->delete();
            $token = $user->createToken('token')->plainTextToken;

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Login successful',
                    'token' => $token,
                    'email' => $user->email,
                ],
                200,
            );
        } catch (ValidationException $ex) {
            return response()->json(
                [
                    'status' => 'fail',
                    'errors' => $ex->errors(),
                ],
                422,
            );
        } catch (\Exception $ex) {
            return response()->json(
                [
                    'status' => 'fail',
                    'message' => $ex->getMessage(),
                ],
                500,
            );
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
