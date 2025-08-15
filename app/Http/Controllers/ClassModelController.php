<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Admin;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Models\AcademicSection;
use Illuminate\Validation\ValidationException;

class ClassModelController extends Controller
{
public function classModelLists()
{
    try {
        $admin = Admin::where('user_id', auth()->id())->first();

        if (!$admin) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to access this resource',
            ], 403);
        }

        $classModels = ClassModel::where('admin_id', $admin->id)
            ->with('academicSection')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $classModels,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'fail',
            'message' => config('app.debug') ? $e->getMessage() : 'Something went wrong.',
        ], 500);
    }
}


    /**
     * Class Model Create
     */
    public function classModelCreate(Request $request)
    {
        try {
            $validated = $request->validate([
                'academic_section_id' => 'required|exists:academic_sections,id',
                'name' => 'required|string|max:255',
            ]);

            $admin = Admin::where('user_id', auth()->id())->first();

            // চেক করো academic section টি এই admin এর কিনা
            $academicSection = AcademicSection::where('id', $validated['academic_section_id'])->where('admin_id', $admin->id)->first();

            if (!$academicSection) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'You do not have permission to add class model to this academic section!',
                ]);
            }

            
            $existingClassModel = ClassModel::where('academic_section_id', $validated['academic_section_id'])->where('name', $validated['name'])->where('admin_id', $admin->id)->first();

            if ($existingClassModel) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Class Name Already Exists!',
                ]);
            }

            ClassModel::create([
                'academic_section_id' => $validated['academic_section_id'],
                'admin_id' => $admin->id,
                'name' => $validated['name'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Class Model created successfully!',
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
     * Move class model to trash
     */
    public function classModelTrash(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:class_models,id',
            ]);

            $classModel = ClassModel::find($request->id);
            if (!$classModel) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Class Model not found.',
                    ],
                    404,
                );
            }

            // চেক করো এই ক্লাস মডেলটি এই admin এর কিনা
            $admin = Admin::where('user_id', auth()->id())->first();
            if ($classModel->admin_id != $admin->id) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'You do not have permission to trash this class model.',
                    ],
                    403,
                );
            }

            // Soft delete the class model
            $classModel->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Class Model trashed successfully.',
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
     * Get trashed class models
     */
    public function classModelTrashedList()
    {
        try {
            $admin = Admin::where('user_id', auth()->id())->first();

            if ($admin) {
                $trashedClassModels = ClassModel::onlyTrashed()->where('admin_id', $admin->id)->with('academicSection')->get();

                return response()->json([
                    'status' => 'success',
                    'data' => $trashedClassModels,
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
     * Restore class model from trash
     */
    public function classModelRestore(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:class_models,id',
            ]);

            $classModel = ClassModel::onlyTrashed()->find($request->id);
            if (!$classModel) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Class Model not found in trash.',
                    ],
                    404,
                );
            }

            // চেক করো এই ক্লাস মডেলটি এই admin এর কিনা
            $admin = Admin::where('user_id', auth()->id())->first();
            if ($classModel->admin_id != $admin->id) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'You do not have permission to restore this class model.',
                    ],
                    403,
                );
            }

            // Restore the class model
            $classModel->restore();

            return response()->json([
                'status' => 'success',
                'message' => 'Class Model restored successfully.',
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
     * Permanently delete class model
     */
    public function classModelDelete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:class_models,id',
            ]);

            $classModel = ClassModel::onlyTrashed()->find($request->id);
            if (!$classModel) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Class Model not found in trash.',
                    ],
                    404,
                );
            }

            // চেক করো এই ক্লাস মডেলটি এই admin এর কিনা
            $admin = Admin::where('user_id', auth()->id())->first();
            if ($classModel->admin_id != $admin->id) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'You do not have permission to delete this class model.',
                    ],
                    403,
                );
            }

            // Permanently delete the class model
            $classModel->forceDelete();

            return response()->json([
                'status' => 'success',
                'message' => 'Class Model permanently deleted.',
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
     * Get class model by ID for editing
     */
    public function classModelEditById(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:class_models,id',
            ]);

            $admin = Admin::where('user_id', auth()->id())->first();
            $classModel = ClassModel::with('academicSection')->where('id', $request->id)->where('admin_id', $admin->id)->first();

            if (!$classModel) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Class Model not found or you do not have permission to access it.',
                ]);
            }

            return response()->json([
                'status' => 'success',
                'class_model' => $classModel,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Update class model
     */
    public function classModelUpdate(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:class_models,id',
                'academic_section_id' => 'required|exists:academic_sections,id',
                'name' => 'required|string|max:255',
            ]);

            $admin = Admin::where('user_id', auth()->id())->first();
            $classModel = ClassModel::where('id', $request->id)->where('admin_id', $admin->id)->first();

            if (!$classModel) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Class Model not found or you do not have permission to update it.',
                ]);
            }

            $academicSection = AcademicSection::where('id', $request->academic_section_id)->where('admin_id', $admin->id)->first();

            if (!$academicSection) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'You do not have permission to add class model to this academic section!',
                ]);
            }

            $existingClassModel = ClassModel::where('academic_section_id', $request->academic_section_id)->where('name', $request->name)->where('admin_id', $admin->id)->where('id', '!=', $request->id)->first();

            if ($existingClassModel) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Class Model with the same name already exists in this academic section!',
                ]);
            }

            // Update class model
            $classModel->update([
                'academic_section_id' => $request->academic_section_id,
                'name' => $request->name,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Class Model updated successfully',
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

    /**
     * Search class models
     */
    public function classModelSearch(Request $request)
    {
        try {
            $request->validate([
                'search_term' => 'nullable|string|max:255',
            ]);

            $admin = Admin::where('user_id', auth()->id())->first();

            if (!$admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not authorized to access this resource',
                ]);
            }

            $searchTerm = $request->input('search_term');

            $query = ClassModel::where('admin_id', $admin->id)->with('academic_section');

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%')->orWhereHas('academic_section', function ($query) use ($searchTerm) {
                        $query->where('section_type', 'like', '%' . $searchTerm . '%');
                    });
                });
            }

            $classModels = $query->get();

            return response()->json([
                'status' => 'success',
                'data' => $classModels,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Search trashed class models
     */
    public function classModelTrashedSearch(Request $request)
    {
        try {
            $request->validate([
                'search_term' => 'nullable|string|max:255',
            ]);

            $admin = Admin::where('user_id', auth()->id())->first();

            if (!$admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not authorized to access this resource',
                ]);
            }

            $searchTerm = $request->input('search_term');

            $query = ClassModel::onlyTrashed()->where('admin_id', $admin->id)->with('academic_section');

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%')->orWhereHas('academic_section', function ($query) use ($searchTerm) {
                        $query->where('section_type', 'like', '%' . $searchTerm . '%');
                    });
                });
            }

            $classModels = $query->get();

            return response()->json([
                'status' => 'success',
                'data' => $classModels,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
