<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\TeacherCreatedMail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TeacherController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function teacherLists()
    {
        try{
            $teachers = Teacher::all();
            return response()->json(['status' => 'success', 'allTeachers' => $teachers]);
        }catch(Exception $ex){
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Teacher Create by admin or editor
     */
    public function teacherCreate(Request $request)
    {
        try{
        }catch(Exception $ex){
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Teacher Store
     */
public function teacherStore(Request $request)
{
    try {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'institution_id' => 'required|exists:institutions,id',
        ]);

        DB::beginTransaction();

        $password = Str::random(8);

        // Create a new user with teacher role
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($password),
            'role' => 'teacher',
            'email_verified_at' => now(),
        ]);

        // Check if teacher already exists for this institution
        $exists = Teacher::withTrashed()
            ->where('user_id', $user->id)
            ->where('institution_id', $validatedData['institution_id'])
            ->first();

        if ($exists) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'This user is already a teacher for this institution.'
            ], 422);
        }

        // Create the teacher record
        $teacher = Teacher::create([
            'user_id' => $user->id,
            'institution_id' => $validatedData['institution_id'],
            'joined_at' => now(),
            'is_active' => true,
        ]);

        DB::commit();

        // Send email to teacher
        Mail::to($user->email)->send(new TeacherCreatedMail($user, $password));

        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Teacher created successfully. A random password has been generated.',
            'teacher' => $teacher,
            'user' => $user,
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to create teacher: ' . $e->getMessage(),
        ], 500);
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
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        //
    }
}
