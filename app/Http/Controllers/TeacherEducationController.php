<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\TeacherEducation;
use Illuminate\Support\Facades\Auth;

class TeacherEducationController extends Controller
{
    /**
     * Editor Education lists
     */
    public function teacherEducationList()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        if (!$teacher) {
          return response()->json(['status'=>'error','message'=>'Teacher profile not found'], 404);
         }
        try{
            $educationLits = TeacherEducation::where('teacher_id',$teacher->id)->get();
            return response()->json(['status'=>'success','educationLists' => $educationLits], 200);
        }catch(Exception $e){
            return response()->json(['status'=>'fail','message' => $e->getMessage()], 500);
        }
    }

    /**
     * Teacher Education Create
     */

    public function teacherEducationCreate(Request $request)
    {
        try {
            // Validate the incoming request data
            $validated = $request->validate([
                'level' => 'required|in:SSC,HSC,Graduation,Masters',
                'roll_number' => 'nullable|string|max:255',
                'board_university' => 'required|string|max:255',
                'result' => 'required|string|max:50',
                'passing_year' => 'required',
                'course_duration' => 'nullable|string|max:50',
            ]);
            $user = Auth::user();
            $teacher = Teacher::where('user_id', $user->id)->first();
            if (!$teacher) {
                return response()->json(['status' => 'error', 'message' => 'Teacher not found'], 404);
            }

            // Check if level already exists for this user (via editor_id)
            $exists = TeacherEducation::where('teacher_id', $teacher->id)->where('level', $validated['level'])->exists();

            if ($exists) {
                return response()->json(['status' => 'error', 'message' => 'This education level already exists.'], 400);
            }

            // Create new education record
            TeacherEducation::create([
                'teacher_id' => $teacher->id,
                'level' => $validated['level'],
                'roll_number' => $validated['roll_number'],
                'board_university' => $validated['board_university'],
                'result' => $validated['result'],
                'passing_year' => $validated['passing_year'],
                'course_duration' => $validated['course_duration'],
            ]);

            // Return success response
            return response()->json(['status' => 'success', 'message' => 'Education information added successfully']);
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()], 500);
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
    public function show(TeacherEducation $teacherEducation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherEducation $teacherEducation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeacherEducation $teacherEducation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherEducation $teacherEducation)
    {
        //
    }
}
