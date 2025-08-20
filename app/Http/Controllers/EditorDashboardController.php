<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Editor;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EditorDashboardController extends Controller
{
    //editor dashboard page
    public function editorDashboardPage()
    {
        try {
            return view('pages.dashboard.editor.indexPage');
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }

    //editor profile page
    /**
     * Admin Profile page
     */

    public function editorProfilePage()
    {
        try {
            return view('pages.dashboard.editor.editorProfilePage');
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }



    /**
     * Editor Teacher Page
     */
    public function editorTeacherCreatePage()
    {
        try {
            return view('pages.dashboard.editor.teacher.teacherCreatePage');
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }








    //editor details
    public function editorDetails()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not authenticated']);
            }

            $editorDetails = User::with('editors')->find($user->id);

            if (!$editorDetails) {
                return response()->json(['status' => 'error', 'message' => 'Editor Details Not Found']);
            }

            return response()->json(['status' => 'success', 'data' => $editorDetails]);
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Updaate Editor
     */

    public function editorUpdateProfile(Request $request)
    {
        // Get authenticated user
        $user = Auth::user();
        if (!$user) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Authentication failed',
                ],
                401,
            );
        }

        // Find editor record
        $editor = Editor::where('user_id', $user->id)->first();
        if (!$editor) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Editor profile not found',
                ],
                404,
            );
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20|unique:editors,phone,' . $editor->id,
            'address' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date',
            'nid' => 'required|string|max:50|unique:editors,nid,' . $editor->id,
            'gender' => 'nullable|in:male,female,other',
            'religion' => 'nullable|in:Hindu,Muslim,Buddhist,Christian,Other',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'nationality' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ],
                422,
            );
        }

        // Update editor profile (keep old values if request empty)
        $editor->father_name = $request->father_name ?? $editor->father_name;
        $editor->mother_name = $request->mother_name ?? $editor->mother_name;
        $editor->phone = $request->phone ?? $editor->phone;
        $editor->address = $request->address ?? $editor->address;
        $editor->birth_date = $request->birth_date ?? $editor->birth_date;
        $editor->nid = $request->nid ?? $editor->nid;
        $editor->gender = $request->gender ?? $editor->gender;
        $editor->religion = $request->religion ?? $editor->religion;
        $editor->marital_status = $request->marital_status ?? $editor->marital_status;
        $editor->nationality = $request->nationality ?? $editor->nationality;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($editor->image && file_exists(public_path($editor->image))) {
                unlink(public_path($editor->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $uploadPath = 'uploads/editor/profile/';

            $image->move(public_path($uploadPath), $imageName);
            $editor->image = $imageName;
        }

        $editor->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => [
                'image' => $editor->image ? asset($editor->image) : asset('uploads/editor/profile/default.png'), // default image
            ],
        ]);
    }




        /**
     * Editor Password Update
     */
public function editorUpdatePassword(Request $request)
{
    try {
        // Validate input
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed', // expects new_password_confirmation field
        ], [
            'email.exists' => 'The provided email does not exist in our records.',
            'current_password.required' => 'Current password is required.',
            'current_password.min' => 'Current password must be at least 8 characters.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'New password must be at least 8 characters.',
            'new_password.confirmed' => 'New password and confirmation do not match.',
        ]);

        // Find user by email and role admin
        $user = User::where('email', $request->email)->where('role', 'editor')->first();

        if (!$user) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Email does not match any admin account.'
            ], 404);
        }

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            // Throw validation exception with proper error message
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.']
            ]);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully.'
        ]);
    } catch (ValidationException $ex) {
        // Return validation errors with status 422
        return response()->json([
            'status' => 'fail',
            'errors' => $ex->errors()
        ], 422);
    } catch (\Exception $ex) {
        // Return generic error with status 500
        return response()->json([
            'status' => 'fail',
            'message' => $ex->getMessage()
        ], 500);
    }
}




    //editor logout
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['status' => 'success', 'message' => 'Logged out successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }
}
