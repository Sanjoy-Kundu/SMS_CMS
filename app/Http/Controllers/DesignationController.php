<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function designationList()
    {
        try {
            $designations = Designation::all();
            return response()->json(['status' => 'success', 'data' => $designations]);
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }

    public function designationTrashList()
    {
        try {
            $designationsTrash = Designation::onlyTrashed()->get();
            return response()->json(['status' => 'success', 'data' => $designationsTrash]);
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }

    /**
     * designationStore
     */
    public function designationStore(Request $request)
    {
        try {
            // Validation
            $validated = $request->validate([
                'institution_id' => 'required|exists:institutions,id',
                'title' => ['required', 'string', Rule::unique('designations')->where(fn($q) => $q->where('institution_id', $request->institution_id))],
            ]);

            // Create
            $designation = Designation::create($validated);

            // Success Response
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Designation created successfully!',
                ],
                201,
            );
        } catch (ValidationException $e) {
            // Validation Error
            return response()->json(
                [
                    'status' => 'fail',
                    'errors' => $e->errors(),
                ],
                422,
            );
        } catch (Exception $ex) {
            // Other Error
            return response()->json(
                [
                    'status' => 'fail',
                    'error' => $ex->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function designationTrash(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:designations,id',
        ]);

        try {
            $designation = Designation::findOrFail($request->id);

            // Soft delete
            $designation->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Designation deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }

    // Restore Designation
    public function designationRestore(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:designations,id',
        ]);

        try {
            $designation = Designation::withTrashed()->findOrFail($request->id);
            $designation->restore();

            return response()->json([
                'status' => 'success',
                'message' => 'Designation restored successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }

    // Permanent Delete Designation
    public function designationPermanentDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:designations,id',
        ]);

        try {
            $designation = Designation::withTrashed()->findOrFail($request->id);
            $designation->forceDelete();

            return response()->json([
                'status' => 'success',
                'message' => 'Designation permanently deleted',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }

    // details
    public function designationDetails(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:designations,id',
        ]);

        try {
            $designation = Designation::findOrFail($request->id);
            return response()->json(['status' => 'success', 'data' => $designation]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    // update
    public function designationUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:designations,id',
            'title' => 'required|string|max:255',
        ]);

        try {
            $designation = Designation::findOrFail($request->id);
            $designation->title = $request->title;
            $designation->save();

            return response()->json(['status' => 'success', 'message' => 'Designation updated successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function teacherControlPanelCVDetails(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        // Get user with role teacher
        $user = User::where('email', $email)->where('role', 'teacher')->first();
        if (!$user) {
            return response()->json(['error' => 'Teacher not found!'], 404);
        }

        $teacher = Teacher::with(['educations', 'addresses'])
            ->where('user_id', $user->id)
            ->first();
        if (!$teacher) {
            return response()->json(['error' => 'Teacher profile not found!'], 404);
        }

        return response()->json(['status' => 'success', 'user' => $user, 'teacher' => $teacher]);
    }

    //update teacher designation
    public function updateTeacherDesignation(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:teachers,id',
            'designation_id' => 'required|exists:designations,id',
        ]);

        try {
            $teacher = Teacher::find($request->id);

            if (!$teacher) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Teacher not found',
                ]);
            }

            $teacher->designation_id = $request->designation_id;
            $teacher->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Designation updated successfully',
                'data' => $teacher,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
