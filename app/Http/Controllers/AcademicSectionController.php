<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Institution;
use Illuminate\Http\Request;
use App\Models\AcademicSection;
use Exception;
use Illuminate\Validation\ValidationException;

class AcademicSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function academicSectionLists()
    {
        try {
            $admin = Admin::where('user_id', auth()->id())->first();
            if ($admin) {
                $academicSections = AcademicSection::where('admin_id', $admin->id)->with('institution')->get();

                return response()->json([
                    'status' => 'success',
                    'data' => $academicSections,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not authorized to access this resource',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function academicSectionInstitutionLists()
    {
        try {
            $institutions = Institution::all();
            if (!$institutions) {
                return response()->json(['status' => 'fail', 'message' => 'No institution found']);
            }
            return response()->json(['status' => 'success', 'data' => $institutions]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Academic Section Create
     */
    public function academicSectionCreate(Request $request)
    {
        try {
            $validated = $request->validate([
                'institution_id' => 'required|exists:institutions,id',
                'section_type' => 'required|in:school,college',
                'approval_letter_no' => 'nullable|string|max:255',
                'approval_date' => 'nullable|date',
                'approval_stage' => 'nullable|string|max:255',
                'level' => 'nullable|string|max:255',
            ]);

            $admin = Admin::where('user_id', auth()->id())->first();

            // চেক করো institution টি এই admin এর কিনা
            $institution = Institution::where('id', $validated['institution_id'])->where('admin_id', $admin->id)->first();

            if (!$institution) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'You do not have permission to add section to this institution!',
                ]);
            }

            AcademicSection::create([
                'institution_id' => $validated['institution_id'],
                'admin_id' => $admin->id,
                'section_type' => $validated['section_type'],
                'approval_letter_no' => $validated['approval_letter_no'],
                'approval_date' => $validated['approval_date'],
                'approval_stage' => $validated['approval_stage'],
                'level' => $validated['level'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Academic Section created successfully!',
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
     * Get academic sections trash
     */
    public function academicSectionTrash(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'id' => 'required|integer|exists:academic_sections,id',
            ]);

            // Find the academic section
            $academicSection = AcademicSection::find($request->id);

            if (!$academicSection) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Academic Section not found.',
                    ],
                    404,
                );
            }

            // Check if the current admin owns this section
            $admin = Admin::where('user_id', auth()->id())->first();
            if (!$admin || $academicSection->admin_id != $admin->id) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'You do not have permission to trash this section.',
                    ],
                    403,
                );
            }

            // Soft delete the section
            $academicSection->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Academic Section trashed successfully.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ],
                422,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'fail',
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Move academic section to trash
     */

    /**
     * Get trashed academic sections
     */
    public function academicSectionTrashedLists()
    {
        try {
            $admin = Admin::where('user_id', auth()->id())->first();

            if ($admin) {
                $trashedSections = AcademicSection::onlyTrashed()->where('admin_id', $admin->id)->with('institution')->get();

                return response()->json([
                    'status' => 'success',
                    'data' => $trashedSections,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not authorized to access this resource',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Restore academic section from trash
     */
    public function academicSectionRestore(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:academic_sections,id',
        ]);

        $academicSection = AcademicSection::onlyTrashed()->find($request->id);
        if (!$academicSection) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Academic Section not found in trash.',
                ],
                404,
            );
        }

        // চেক করো এই সেকশনটি এই admin এর কিনা
        $admin = Admin::where('user_id', auth()->id())->first();
        if ($academicSection->admin_id != $admin->id) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'You do not have permission to restore this section.',
                ],
                403,
            );
        }

        try {
            $academicSection->restore();
            return response()->json([
                'status' => 'success',
                'message' => 'Academic Section restored successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to restore academic section.',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Permanently delete academic section
     */
    public function academicSectionDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:academic_sections,id',
        ]);

        $academicSection = AcademicSection::onlyTrashed()->find($request->id);
        if (!$academicSection) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Academic Section not found in trash.',
                ],
                404,
            );
        }

        // চেক করো এই সেকশনটি এই admin এর কিনা
        $admin = Admin::where('user_id', auth()->id())->first();
        if ($academicSection->admin_id != $admin->id) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'You do not have permission to delete this section.',
                ],
                403,
            );
        }

        try {
            $academicSection->forceDelete();
            return response()->json([
                'status' => 'success',
                'message' => 'Academic Section permanently deleted.',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to delete academic section permanently.',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Get academic section by ID for editing
     */
    public function academicSectionEditById(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:academic_sections,id',
            ]);

            $admin = Admin::where('user_id', auth()->id())->first();
            $academicSection = AcademicSection::with('institution')->where('id', $request->id)->where('admin_id', $admin->id)->first();

            if (!$academicSection) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Academic Section not found or you do not have permission to access it.',
                ]);
            }

            return response()->json([
                'status' => 'success',
                'section' => $academicSection,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Update academic section
     */
    public function academicSectionUpdate(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:academic_sections,id',
                'institution_id' => 'required|exists:institutions,id',
                'section_type' => 'required|in:school,college',
                'approval_letter_no' => 'nullable|string|max:255',
                'approval_date' => 'nullable|date',
                'approval_stage' => 'nullable|string|max:255',
                'level' => 'nullable|string|max:255',
            ]);

            $admin = Admin::where('user_id', auth()->id())->first();
            $academicSection = AcademicSection::where('id', $request->id)->where('admin_id', $admin->id)->first();

            if (!$academicSection) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Academic Section not found or you do not have permission to update it.',
                ]);
            }

            // চেক করো institution টি এই admin এর কিনা
            $institution = Institution::where('id', $request->institution_id)->where('admin_id', $admin->id)->first();

            if (!$institution) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'You do not have permission to add section to this institution!',
                ]);
            }

            // Update academic section
            $academicSection->update([
                'institution_id' => $request->institution_id,
                'section_type' => $request->section_type,
                'approval_letter_no' => $request->approval_letter_no,
                'approval_date' => $request->approval_date,
                'approval_stage' => $request->approval_stage,
                'level' => $request->level,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Academic Section updated successfully',
            ]);
        } catch (ValidationException $e) {
            return response()->json(
                [
                    'status' => 'fail',
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
}
