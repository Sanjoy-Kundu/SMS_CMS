<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Editor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\EditorCreatedMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EditorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Editor Create By Admin Dashboard Form
     */
    public function editorStore(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'institution_id' => 'required|exists:institutions,id',
            ]);

            // Start transaction to ensure data integrity
            DB::beginTransaction();
            $password = Str::random(8);
            // Create a new user with the editor role
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($password), // Generate a random password
                'role' => 'editor',
                'email_verified_at' => now(), // Auto verify the email
            ]);

            $exists = Editor::withTrashed()->where('user_id', $user->id)->where('institution_id', $validatedData['institution_id'])->first();
            if ($exists) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'This user is already an editor for this institution.'
            ], 422);
        }





            // Create the editor record
            $editor = Editor::create([
                'user_id' => $user->id,
                'institution_id' => $request->institution_id,
                'designation' => null, // Can be updated later
                'joined_at' => now(),
                'is_active' => true,
            ]);

            // Commit the transaction
            DB::commit();

            //edior mail 
             Mail::to($user->email)->send(new EditorCreatedMail($user, $password));
            // Return success response
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Editor created successfully. A random password has been generated.',
                    'editor' => $editor,
                    'user' => $user,
                ],
                201,
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ],
                422,
            );
        } catch (\Exception $e) {
            // Rollback the transaction in case of any error
            DB::rollBack();

            // Return general error
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to create editor: ' . $e->getMessage(),
                ],
                500,
            );
        }
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
    public function show(Editor $editor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Editor $editor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Editor $editor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Editor $editor)
    {
        //
    }
}
