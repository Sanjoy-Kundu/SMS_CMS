<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Teacher;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TeacherDashboardController extends Controller
{
    //techer pfofile page
        public function teacherProfilePage()
    {
        try {
            return view('pages.dashboard.teacher.teacherProfilePage');
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }


    //Institution details
      public function institutionDetailsByTeacher()
    {
        try {
            $user = auth()->user();

            if($user->role === 'teacher' || $user->role === 'student' || $user->role === 'parent') {
            $institutions = Institution::all();
            return response()->json(['status'=>'success','data'=>$institutions,]);  
            }else{
                return response()->json(['status'=>'error','message'=>'Unauthorized']);
            }


        } catch (\Exception $e) {
            return response()->json(['status'=>'fail','message'=>$e->getMessage()]);
        }
    }


    
    /**
     * Updaate Teacher
     */

    public function teacherUpdateProfile(Request $request)
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

        // Find teacher record
        $teacher = Teacher::where('user_id', $user->id)->first();
        if (!$teacher) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Teacher profile not found',
                ],
                404,
            );
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20|unique:teachers,phone,' . $teacher->id,
            'address' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date',
            'nid' => 'required|string|max:50|unique:teachers,nid,' . $teacher->id,
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

        // Update teacher profile (keep old values if request empty)
        $teacher->father_name = $request->father_name ?? $teacher->father_name;
        $teacher->mother_name = $request->mother_name ?? $teacher->mother_name;
        $teacher->phone = $request->phone ?? $teacher->phone;
        $teacher->address = $request->address ?? $teacher->address;
        $teacher->birth_date = $request->birth_date ?? $teacher->birth_date;
        $teacher->nid = $request->nid ?? $teacher->nid;
        $teacher->gender = $request->gender ?? $teacher->gender;
        $teacher->religion = $request->religion ?? $teacher->religion;
        $teacher->marital_status = $request->marital_status ?? $teacher->marital_status;
        $teacher->nationality = $request->nationality ?? $teacher->nationality;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($teacher->image && file_exists(public_path($teacher->image))) {
                unlink(public_path($teacher->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $uploadPath = 'uploads/teacher/profile/';

            $image->move(public_path($uploadPath), $imageName);
            $teacher->image = $imageName;
        }

        $teacher->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => [
                'image' => $teacher->image ? asset($teacher->image) : asset('uploads/teacher/profile/default.png'), // default image
            ],
        ]);
    }
}
