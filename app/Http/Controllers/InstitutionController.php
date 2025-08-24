<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Admin;
use App\Models\Editor;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function institutionDetails()
    {
        try {
            $admin = Admin::where('user_id', auth()->id())->first();
            if ($admin) {
                $institutions = Institution::where('admin_id', $admin->id)->first();
                $trashInstitutions = Institution::onlyTrashed()->where('admin_id', $admin->id)->get();
                return response()->json(['status' => 'success', 'data' => $institutions, 'trashData' => $trashInstitutions]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'You are not authorized to access this resource']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    
    /**
     * Instituion Details for Admin Editor
     */
    public function institutionDetailsAdminEditor()
    {
        try {
            $user = auth()->user();

            if ($user->role === 'admin') {
                $admin = Admin::where('user_id', $user->id)->first();
                if (!$admin) {
                    return response()->json(['status'=>'error','message'=>'Admin not found']);
                }
                $institutions = Institution::where('admin_id', $admin->id)->get();
                $trashInstitutions = Institution::onlyTrashed()->where('admin_id', $admin->id)->get();

            } elseif ($user->role === 'editor') {
                $editor = Editor::where('user_id', $user->id)->first();
                if (!$editor) {
                    return response()->json(['status'=>'error','message'=>'Editor not found']);
                }
                $institutions = Institution::where('id', $editor->institution_id)->get();
                $trashInstitutions = Institution::onlyTrashed()->where('id', $editor->institution_id)->get();
            } elseif($user->role === 'teacher' || $user->role === 'student' || $user->role === 'parent') {
                    $institutions = Institution::all();
            }else{
                return response()->json(['status'=>'error','message'=>'Unauthorized']);
            }

            return response()->json([
                'status'=>'success',
                'data'=>$institutions,
                'trashData'=>$trashInstitutions
            ]);

        } catch (\Exception $e) {
            return response()->json(['status'=>'fail','message'=>$e->getMessage()]);
        }
    }















    /**
     * Institution Create
     */
    public function institutionCreate(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|in:school,college,combined',
                'eiin' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:500',
            ]);

            $admin = Admin::where('user_id', auth()->id())->first();

            // এখানে চেক করো ওই admin_id এর জন্য আগেই institution আছে কিনা
            $exists = Institution::where('admin_id', $admin->id)->first();

            if ($exists) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'You can only add one institution!',
                ]);
            }

            Institution::create([
                'admin_id' => $admin->id,
                'name' => $validated['name'],
                'type' => $validated['type'],
                'eiin' => $validated['eiin'],
                'address' => $validated['address'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Institution created successfully!',
            ]);
        } catch (ValidationException $e) {
            return response()->json(
                [
                    'errors' => $e->errors(),
                ],
                422,
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Move institution to trash
     */
    public function institutionTrash(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:institutions,id',
        ]);

        $institution = Institution::find($request->id);
        if (!$institution) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Institution not found.',
                ],
                404,
            );
        }

        try {
            $institution->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Institution trashed successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to trash institution.',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Restore institution from trash
     */
    public function institutionRestore(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:institutions,id',
        ]);

        $institution = Institution::onlyTrashed()->find($request->id);
        if (!$institution) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Institution not found in trash.',
                ],
                404,
            );
        }

        try {
            $institution->restore();
            return response()->json([
                'status' => 'success',
                'message' => 'Institution restored successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to restore institution.',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Permanently delete institution
     */
    public function institutionDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:institutions,id',
        ]);

        $institution = Institution::onlyTrashed()->find($request->id);
        if (!$institution) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Institution not found in trash.',
                ],
                404,
            );
        }

        try {
            $institution->forceDelete();
            return response()->json([
                'status' => 'success',
                'message' => 'Institution permanently deleted.',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to delete institution permanently.',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    // Other methods (show, edit, update, destroy) remain empty as per original code
public function institutionEditById(Request $request)
{
    try {
        $request->validate([
            'id' => 'required|integer|exists:institutions,id',
        ]);

        $admin = Admin::where('user_id', auth()->id())->first();
        $institution = Institution::where('id', $request->id)
            ->where('admin_id', $admin->id)
            ->first();

        if (!$institution) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Institution not found or you do not have permission to access it.'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'institution' => $institution
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'fail',
            'message' => $e->getMessage()
        ]);
    }
}

public function institutionUpdate(Request $request)
{
    try {
        $request->validate([
            'id' => 'required|integer|exists:institutions,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:school,college,combined',
            'eiin' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $admin = Admin::where('user_id', auth()->id())->first();
        $institution = Institution::where('id', $request->id)
            ->where('admin_id', $admin->id)
            ->first();

        if (!$institution) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Institution not found or you do not have permission to update it.'
            ]);
        }

        // Check if another institution with the same details already exists
        $exists = Institution::where('name', $request->name)
            ->where('type', $request->type)
            ->where('eiin', $request->eiin)
            ->where('id', '!=', $request->id)
            ->first();

        if ($exists) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Another institution with the same details already exists!'
            ]);
        }

        // Update institution
        $institution->update([
            'name' => $request->name,
            'type' => $request->type,
            'eiin' => $request->eiin,
            'address' => $request->address,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Institution updated successfully'
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'status' => 'fail',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'fail',
            'message' => $e->getMessage()
        ]);
    }
}
}
