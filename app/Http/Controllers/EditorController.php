<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Editor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\EditorCreatedMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class EditorController extends Controller
{
    /**
     * Display a Editor LoginFrom
     */
        public function editorLoginPage()
    {
        try {
            return view('form.editor.editor_login_form');
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }


        /**
     * Editor Login Store
     */
    public function editor_login_store(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:8',
                'role' => 'required|in:editor',
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

            if ($user->role !== 'editor') {
                return response()->json(
                    [
                        'status' => 'fail',
                        'message' => 'Access denied! Only Editor can login.',
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
                'designation' => null, 
                'joined_at' => now(),
                'is_active' => true,
                'father_name' => null, 
                'mother_name' => null, 
                'nationality'=>null,
                'religion'=>null,
                'marital_status'=>null,
                'phone' => null,
                'address' => null, 
                'image'=>null,
                'date_of_birth' => null,
                'nid' => null, 
                'gender' => null, 
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
     * Editor CV
     */
 public function editorCVDetails(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        // Get user with role editor
        $user = User::where('email', $email)->where('role', 'editor')->first();
        if (!$user) {
            return response()->json(['error' => 'Editor not found!'], 404);
        }

        $editor = Editor::with(['educations', 'addresses'])->where('user_id', $user->id)->first();
        if (!$editor) {
            return response()->json(['error' => 'Editor profile not found!'], 404);
        }

        return response()->json(['status'=>'success','user' => $user,'editor' => $editor,
        ]);
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
