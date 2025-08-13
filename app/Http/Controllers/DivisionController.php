<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Division;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DivisionController extends Controller
{
    /**
     * Display a listing of divisions.
     */
    public function divisionClassLists()
    {
        try {
            $admin = Admin::where('user_id', auth()->id())->first();
            if ($admin) {
                $divisions = Division::where('admin_id', $admin->id)->with('classModel')->get();
                
                return response()->json([
                    'status' => 'success', 
                    'data' => $divisions
                ]);
            } else {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'You are not authorized to access this resource'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail', 
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Create a new division.
     */
    public function divisionClassCreate(Request $request)
    {
        try {
            $validated = $request->validate([
                'class_id' => 'required|exists:class_models,id',
                'name' => 'required|string|max:255',
            ]);
            
            $admin = Admin::where('user_id', auth()->id())->first();
            
            // Check if the class belongs to this admin
            $classModel = ClassModel::where('id', $validated['class_id'])
                ->where('admin_id', $admin->id)
                ->first();
                
            if (!$classModel) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'You do not have permission to add division to this class!',
                ]);
            }
            
            // Check if a division with this name already exists in this class
            $existingDivision = Division::where('class_id', $validated['class_id'])
                ->where('name', $validated['name'])
                ->where('admin_id', $admin->id)
                ->first();
                
            if ($existingDivision) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Name Already Exists',
                ]);
            }
            
            Division::create([
                'class_id' => $validated['class_id'],
                'admin_id' => $admin->id,
                'name' => $validated['name'],
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Division created successfully!',
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
     * Move division to trash.
     */
    public function divisionClassTrash(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:divisions,id',
            ]);
            
            $division = Division::find($request->id);
            if (!$division) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Division not found.',
                ], 404);
            }
            
            // Check if this division belongs to the current admin
            $admin = Admin::where('user_id', auth()->id())->first();
            if ($division->admin_id != $admin->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to trash this division.',
                ], 403);
            }
            
            // Soft delete the division
            $division->delete();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Division trashed successfully.',
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get trashed divisions.
     */
    public function divisionClassTrashedList()
    {
        try {
            $admin = Admin::where('user_id', auth()->id())->first();
            
            if ($admin) {
                $trashedDivisions = Division::onlyTrashed()
                    ->where('admin_id', $admin->id)
                    ->with('classModel')
                    ->get();
                    
                return response()->json([
                    'status' => 'success',
                    'data' => $trashedDivisions
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not authorized to access this resource'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Restore division from trash.
     */
    public function divisionClassRestore(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:divisions,id',
            ]);
            
            $division = Division::onlyTrashed()->find($request->id);
            if (!$division) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Division not found in trash.',
                ], 404);
            }
            
            // Check if this division belongs to the current admin
            $admin = Admin::where('user_id', auth()->id())->first();
            if ($division->admin_id != $admin->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to restore this division.',
                ], 403);
            }
            
            // Restore the division
            $division->restore();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Division restored successfully.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Permanently delete division.
     */
    public function divisionClassDelete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:divisions,id',
            ]);
            
            $division = Division::onlyTrashed()->find($request->id);
            if (!$division) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Division not found in trash.',
                ], 404);
            }
            
            // Check if this division belongs to the current admin
            $admin = Admin::where('user_id', auth()->id())->first();
            if ($division->admin_id != $admin->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to delete this division.',
                ], 403);
            }
            
            // Permanently delete the division
            $division->forceDelete();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Division permanently deleted.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get division by ID for editing.
     */
    public function divisionClassEditById(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:divisions,id',
            ]);
            
            $admin = Admin::where('user_id', auth()->id())->first();
            $division = Division::with('classModel')
                ->where('id', $request->id)
                ->where('admin_id', $admin->id)
                ->first();
                
            if (!$division) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Division not found or you do not have permission to access it.'
                ]);
            }
            
            return response()->json([
                'status' => 'success',
                'division' => $division
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update division.
     */
    public function divisionClassUpdate(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:divisions,id',
                'class_id' => 'required|exists:class_models,id',
                'name' => 'required|string|max:255',
            ]);
            
            $admin = Admin::where('user_id', auth()->id())->first();
            $division = Division::where('id', $request->id)
                ->where('admin_id', $admin->id)
                ->first();
                
            if (!$division) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Division not found or you do not have permission to update it.'
                ]);
            }
            
            // Check if the class belongs to this admin
            $classModel = ClassModel::where('id', $request->class_id)
                ->where('admin_id', $admin->id)
                ->first();
                
            if (!$classModel) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'You do not have permission to add division to this class!',
                ]);
            }
            
            // Check if a division with this name already exists in this class (excluding current one)
            $existingDivision = Division::where('class_id', $request->class_id)
                ->where('name', $request->name)
                ->where('admin_id', $admin->id)
                ->where('id', '!=', $request->id)
                ->first();
                
            if ($existingDivision) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'A division with this name already exists in this class!',
                ]);
            }
            
            // Update division
            $division->update([
                'class_id' => $request->class_id,
                'name' => $request->name,
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Division updated successfully'
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

    /**
     * Search divisions.
     */
    public function divisionClassSearch(Request $request)
    {
        try {
            $request->validate([
                'search_term' => 'nullable|string|max:255',
            ]);
            
            $admin = Admin::where('user_id', auth()->id())->first();
            
            if (!$admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not authorized to access this resource'
                ]);
            }
            
            $searchTerm = $request->input('search_term');
            
            $query = Division::where('admin_id', $admin->id)
                ->with('classModel');
                
            if ($searchTerm) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhereHas('classModel', function($query) use ($searchTerm) {
                          $query->where('name', 'like', '%' . $searchTerm . '%');
                      })
                      ->orWhereHas('classModel', function($query) use ($searchTerm) {
                          $query->where('section_type', 'like', '%' . $searchTerm . '%');
                      });
                });
            }
            
            $divisions = $query->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $divisions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Search trashed divisions.
     */
    public function divisionClassTrashedSearch(Request $request)
    {
        try {
            $request->validate([
                'search_term' => 'nullable|string|max:255',
            ]);
            
            $admin = Admin::where('user_id', auth()->id())->first();
            
            if (!$admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not authorized to access this resource'
                ]);
            }
            
            $searchTerm = $request->input('search_term');
            
            $query = Division::onlyTrashed()
                ->where('admin_id', $admin->id)
                ->with('classModel');
                
            if ($searchTerm) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhereHas('classModel', function($query) use ($searchTerm) {
                          $query->where('name', 'like', '%' . $searchTerm . '%');
                      })
                      ->orWhereHas('classModel', function($query) use ($searchTerm) {
                          $query->where('section_type', 'like', '%' . $searchTerm . '%');
                      });
                });
            }
            
            $divisions = $query->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $divisions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ]);
        }
    }
}
