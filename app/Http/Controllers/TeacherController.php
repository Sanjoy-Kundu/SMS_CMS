<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\TeacherCreatedMail;
use App\Mail\TeacherDeletedMail;
use App\Mail\TeacherTrashedMail;
use App\Mail\TeacherUpdatedMail;
use App\Mail\TeacherRestoredMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class TeacherController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function allTeacherLists(Request $request)
    {
   try{
            $teachers = Teacher::with('user','addedBy')->get();
            $editorTeachers = Teacher::with('user','addedBy')->where('added_by',Auth::user()->id)->get();
            return response()->json(['status' => 'success', 'allTeachers' => $teachers, 'editorTeachers' => $editorTeachers]);
        }catch(Exception $ex){
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }



    /**
     * Admin Edit By all Teachers both admin or editor
     */
    public function teacherDetailsById(Request $request){
        try{
            $id = $request->id;
            $searchingTeacherDetails = Teacher::with('user','addedBy')->where('id',$id)->first();
            if(!$searchingTeacherDetails){
                return response()->json(['status' => 'error', 'message' => 'Teacher not found']);
            }
            return response()->json(['status' => 'success', 'teacherDetails' => $searchingTeacherDetails]);
        }catch(Exception $ex){
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }


    /***
     * Teacher Update By admin Only
     */
    public function teacherUpdateByAdmin(Request $request){
        try{
            $id = $request->id;
            $searchingTeacherDetails = Teacher::with('user','addedBy')->where('id',$id)->first(); //teacher table id = 2  User table id = 16
            if(!$searchingTeacherDetails){
                return response()->json(['status' => 'error', 'message' => 'Teacher not found']);
            }
                 $user = $searchingTeacherDetails->user;
                $user->name = $request->name;
                $user->email = $request->email;
                
                //if update then just send a email to teacher mail 
            Mail::to($user->email)->send(new TeacherUpdatedMail(
                  $user->name,
                  $user->email
            ));
            $user->save();

            return response()->json(['status' => 'success', 'message' => 'Teacher updated successfully']);
        }catch(Exception $ex){
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
      }







      /**
       * Both teacher trash admin or Edior
       */
    
    
    
    
      public function teacherTrashByAdmin(Request $request){
        try {
            $id = $request->id;
            $searchingTeacherDetails = Teacher::with('user','addedBy')->where('id', $id)->first();

            if (!$searchingTeacherDetails) {
                return response()->json(['status' => 'fail', 'message' => 'Teacher Details not found']);
            }

            $userTableTeacher = User::where('id', $searchingTeacherDetails->user_id)
                                    ->where('role', 'teacher')
                                    ->first();

            if (!$userTableTeacher) {
                return response()->json(['status' => 'fail', 'message' => 'User Teacher not found']);
            }

            // Send email to teacher before soft delete
            Mail::to($userTableTeacher->email)->send(new TeacherTrashedMail(
                $userTableTeacher->name,
                $userTableTeacher->email
            ));

            // Soft delete both tables
            $searchingTeacherDetails->delete();
            $userTableTeacher->delete();

            return response()->json(['status' => 'success', 'message' => 'Teacher trashed successfully']);

        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }


    /**
     * Teacher Restore By admin or  Editor
     */
    public function allteacherTrashListsByAdmin(Request $request){
        try{
            $authUser = Auth::user();
           $trashedTeachersDetailsData = Teacher::onlyTrashed()->with(['user' => function($q) { $q->withTrashed();}, 'addedBy'])->get();
           
        $EditortrashedTeachers = Teacher::onlyTrashed()->with([
                'user' => function ($q) {$q->withTrashed(); },'addedBy'
            ])
            ->where('added_by', $authUser->id)
            ->get();
       
            return response()->json([
                'status' => 'success',
                'trashTeachers' => $trashedTeachersDetailsData,
                'EditortrashedTeachers' =>$EditortrashedTeachers
            ]);
        }catch(Exception $ex){
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }




    /**
     * Teacher Permanent Delete By admin or  Editor
     */
    public function teacherDeleteByAdmin(Request $request){
        try{
            $id = $request->id;

            // Teacher খুঁজে বের করা
             $teacher = Teacher::withTrashed()->where('id', $id)->first();
            if(!$teacher){
                return response()->json(['status' => 'fail', 'message' => 'Teacher not found']);
            }

            // Teacher এর related user
             $user = User::withTrashed()->where('id', $teacher->user_id)->first();
            if(!$user){
                return response()->json(['status' => 'fail', 'message' => 'User not found']);
            }

            Mail::to($user->email)->send(new TeacherDeletedMail($user->name, $user->email));
            // Permanently delete
            $teacher->forceDelete(); // teacher table
            $user->forceDelete();    // user table

            return response()->json(['status' => 'success', 'message' => 'Teacher permanently deleted Successfully!']);

        }catch(Exception $ex){
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }


    /**
     * Teacher Resore By admin or  Editor
     */
    public function teacherRestoreByAdmin(Request $request){
    try{
        $id = $request->id;

        $teacher = Teacher::withTrashed()->where('id', $id)->first();
        if(!$teacher){
            return response()->json(['status' => 'fail', 'message' => 'Teacher not found']);
        }

        $user = User::withTrashed()->where('id', $teacher->user_id)->first();

        // Restore
        $teacher->restore();
        if($user){
            $user->restore();

            // Send Restore Email
            Mail::to($user->email)->send(new TeacherRestoredMail(
                $user->name,
                $user->email
            ));
        }

        return response()->json(['status' => 'success', 'message' => 'Teacher restored successfully']);
    }catch(Exception $ex){
        return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
    }
}







    /**
     * Teacher Created By admin or  Store
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
            'added_by' => Auth::id(),
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
            'message' => 'Teacher created successfully.',
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
 * ==================================================
 * Teacher Dahboard Start 
 * ===================================================
 */

    public function teacherLoginPage()
    {
        try {
            return view('form.teacher.teacher_login_form');
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }



 //Teacher Dashboard Page
     public function teacherDashboardPage()
    {
        try {
            return view('pages.dashboard.teacher.indexPage');
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }



     //teacher login store
    public function teacher_login_store(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:8',
                'role' => 'required|in:teacher',
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

            if ($user->role !== 'teacher') {
                return response()->json(
                    [
                        'status' => 'fail',
                        'message' => 'Access denied! Only teacher can login.',
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
    
    
    //auth techer details
    public function authTeacherDetails()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not authenticated']);
            }

            $teacherDetails = User::where('role', 'teacher')->find($user->id);

            if (!$teacherDetails) {
                return response()->json(['status' => 'error', 'message' => 'Teacher Details Not Found']);
            }

            return response()->json(['status' => 'success', 'data' => $teacherDetails]);
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }

    //auth teacher logout
        public function teacherLogout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['status' => 'success', 'message' => 'Logged out successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }


/**
 * ==================================================
 * Teacher Dahboard End 
 * ===================================================
 */
}
