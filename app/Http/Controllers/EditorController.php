<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Editor;
use App\Mail\EditorTrashed;
use App\Mail\EditorUpdated;
use Illuminate\Support\Str;
use App\Mail\EditorRestored;
use Illuminate\Http\Request;
use App\Mail\EditorCreatedMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EditorPermanentlyDeleted;
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
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'This user is already an editor for this institution.',
                    ],
                    422,
                );
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
                'nationality' => null,
                'religion' => null,
                'marital_status' => null,
                'phone' => null,
                'address' => null,
                'image' => null,
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
     * Editor Lists Admin Dashobard
     */
    public function editorListAdminDashobard(Request $request)
    {
        try {
            $editors = Editor::with(['user:id,name,email', 'educations', 'addresses'])->get();
            $editorTrash = Editor::with([
                'user' => function ($q) {
                    $q->withTrashed(); // Soft deleted users ke include korbe
                },
                'educations',
                'addresses',
            ])
                ->onlyTrashed()
                ->get();
            return response()->json(['status' => 'success', 'editorLists' => $editors, 'editorTrashLists' => $editorTrash]);
        } catch (Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Editor Lists and trsh lists  Admin Dashobard
     */
    public function editorList(Request $request)
    {
        try {
            $editor = Editor::with(['user:id,name,email', 'institution:id,name', 'educations', 'addresses'])->get();

            return response()->json(['status' => 'success', 'message' => 'Editor List', 'data' => $editor]);
        } catch (Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Editor Trash Admin Dashboard
     */
    // public function editorTrashListAdminDashobard(Request $request){
    //     try{

    //     }catch(Exception $ex){
    //         return response()->json(['status' => 'error', 'message' => $ex->getMessage()]);
    //     }
    // }

    /**
     * Editor Trash Admin Dashboard
     */
    public function editorTrashAdminDashobard(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:editors,id',
        ]);

        try {
            $editorId = $request->id;

            // Editor record fetch
            $editor = Editor::with('user:id,name,email')->findOrFail($editorId);

            // Soft delete editor
            $editor->delete(); // Ei line ta deleted_at fill korbe
            $editor->user()->delete();
            Mail::to($editor->user->email)->send(new EditorTrashed($editor));
            return response()->json([
                'status' => 'success',
                'message' => 'Editor has been trashed successfully.',
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
            ]);
        }
    }
    /**
     * Editor Restore Admin Dashboard
     */
    public function editorRestoreAdminDashboard(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:editors,id',
        ]);

        try {
            $editorId = $request->id;

            // Soft deleted editor fetch
            //$editor = Editor::withTrashed()->with('user:id,name,email')->findOrFail($editorId);
            $editor = Editor::with([
                'user' => function ($q) {
                    $q->withTrashed();
                },
            ])
                ->withTrashed()
                ->findOrFail($editorId);

            // Restore the editor
            $editor->restore(); // Ei line deleted_at null kore active kore
            $editor->user()->restore();

            // Optional: mail notify kora
            Mail::to($editor->user->email)->send(new EditorRestored($editor));

            return response()->json([
                'status' => 'success',
                'message' => 'Editor has been restored successfully.',
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
            ]);
        }
    }
    /**
     * Editor Permanent Delete Admin Dashboard
     */
    public function editorPermanentDeleteAdminDashboard(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:editors,id',
        ]);

        try {
            $editorId = $request->id;

            // Fetch soft deleted editor with user (for email)
            $editor = Editor::with([
                'user' => function ($query) {
                    $query->withTrashed();
                },
            ])
                ->withTrashed()
                ->findOrFail($editorId);

            if (!$editor) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Editor not found.',
                ]);
            }

            if (!$editor) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Editor not found.',
                ]);
            }

            // Store user email and name for notification before deletion
            $editorEmail = $editor->user ? $editor->user->email : null;
            $editorName = $editor->user ? $editor->user->name : 'Editor';

            // Permanently delete editor
            $editor->forceDelete(); // Completely remove from DB
            $editor->user()->forceDelete(); // Completely remove from DB

            // Send mail notification if email exists
            if ($editorEmail) {
                Mail::to($editorEmail)->send(new EditorPermanentlyDeleted([
                        'name' => $editorName,
                        'email' => $editorEmail,
                        'institution' => 'AB School & College',
                    ]),
                );
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Editor has been permanently deleted successfully.',
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
            ]);
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

        $editor = Editor::with(['educations', 'addresses'])
            ->where('user_id', $user->id)
            ->first();
        if (!$editor) {
            return response()->json(['error' => 'Editor profile not found!'], 404);
        }

        return response()->json(['status' => 'success', 'user' => $user, 'editor' => $editor]);
    }

    /**
     * Editor Details By ID
     */
    public function editorDetailsById(Request $request)
    {
         $request->validate([
            'id' => 'required|integer',
        ]);
        try{
            $id = $request->id;
            $editorDetails = User::where('id', $id)->where('role', 'editor')->first();
            if(!$editorDetails){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Editor not found!'
                ]);
            }
            return response()->json(['status' => 'success', 'editorDetails' => $editorDetails]);
        }catch(Exception $ex){
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
            ]);
        }
    }


    /**
     * Editor Updae by id
     */
public function editorUpdateById(Request $request)
{
    $request->validate([
        'id' => 'required|integer',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ]);

    try {
        $id = $request->id;
        $editorDetails = User::where('id', $id)->where('role', 'editor')->first();

        if (!$editorDetails) {
            return response()->json([
                'status' => 'error',
                'message' => 'Editor not found!'
            ]);
        }

        if (
            $editorDetails->name === $request->name &&
            $editorDetails->email === $request->email
        ) {
            return response()->json([
                'status' => 'warning',
                'message' => 'No changes were applied since the provided details are identical to the existing information.'
            ]);
        }


        $editorDetails->name = $request->name;
        $editorDetails->email = $request->email;
        $editorDetails->save();

        // Mail 
        Mail::to($editorDetails->email)->send(new EditorUpdated($editorDetails));

        return response()->json([
            'status' => 'success',
            'message' => 'Editor updated successfully!'
        ]);

    } catch (Exception $ex) {
        return response()->json([
            'status' => 'error',
            'message' => $ex->getMessage(),
        ]);
    }
}






    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    //     }
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Editor $editor)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Editor $editor)
    // {
    //     //
    // }
}
