<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminDashboard extends Controller
{
    /**
     * Admin Dashboard Page
     */
    public function adminDashboardPage()
    {
        try {
            return view('pages.dashboard.admin.indexPage');
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Admin Profile page
     */

    public function adminProfilePage()
    {
        try {
            return view('pages.dashboard.admin.adminProfilePage');
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Institution Page
     */
    public function adminInstitutionPage(){
        try{
            return view('pages.dashboard.admin.institution.institutioinPage');
        }catch(Exception $ex){
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Institution Page
     */
    public function adminAcademicPage(){
        try{
            return view('pages.dashboard.admin.academic.academicPage');
        }catch(Exception $ex){
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }
    /**
     * Classes Page
     */
    public function adminClassPage(){
        try{
            return view('pages.dashboard.admin.classes.classesPage');
        }catch(Exception $ex){
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }

    /***
     * Admin Details
     */
    public function adminDetails()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not authenticated']);
            }

            $adminDetails = User::with('admin')->find($user->id);

            if (!$adminDetails) {
                return response()->json(['status' => 'error', 'message' => 'Admin Details Not Found']);
            }

            return response()->json(['status' => 'success', 'data' => $adminDetails]);
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }

    /***
     * Admin Logout
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['status' => 'success', 'message' => 'Logged out successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Admin Profile Update
     */
    public function adminUpdateProfile(Request $request)
    {
        try {
            $admin = Admin::where('user_id', Auth::id())->firstOrFail();

            // Validation
            $request->validate([
                'phone' => 'required|string|max:20|unique:admins,phone,' . $admin->id,
                'address' => 'required|string|max:255',
                'birth_date' => 'required|date',
                'nid' => 'required|string|max:50|unique:admins,nid,' . $admin->id,
                'gender' => 'required|in:male,female,other',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

        


            $oldImage = $admin->image;

     
            $admin->phone = $request->phone;
            $admin->address = $request->address;
            $admin->birth_date = $request->birth_date;
            $admin->nid = $request->nid;
            $admin->gender = $request->gender;

            // Image upload handling
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $newImagePath = '/uploads/admin/profile/' . $filename;

  
                if ($oldImage !== $newImagePath) {
                    if ($oldImage && $oldImage != '/uploads/admin/profile/default.png') {
                        $oldPath = public_path($oldImage);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }

                    $file->move(public_path('uploads/admin/profile'), $filename);
                    $admin->image = $newImagePath;
                }
            }

            // Save only if changed
            if ($admin->isDirty()) {
                $admin->save();
                $message = 'Profile updated successfully';
            } else {
                $message = 'No changes detected';
            }

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $admin,
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'fail',
                'message' => $ex->getMessage(),
            ]);
        }
    }


    /**
     * Admin Password Update
     */
public function adminUpdatePassword(Request $request)
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
        $user = User::where('email', $request->email)->where('role', 'admin')->first();

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

}
