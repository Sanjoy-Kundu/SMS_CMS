<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Subject;
use App\Models\Division;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Models\AcademicSection;
use Illuminate\Support\Facades\Validator;

class PaperController extends Controller
{
    // List all papers with filters
    public function list(Request $request)
    {
        try {
            $query = Paper::with(['subject.classModel', 'subject.division', 'admin']);
            
            // Apply filters
            if ($request->class_id) {
                $query->whereHas('subject', function($q) use ($request) {
                    $q->where('class_id', $request->class_id);
                });
            }
            
            if ($request->division_id) {
                $query->whereHas('subject', function($q) use ($request) {
                    $q->where('division_id', $request->division_id);
                });
            }
            
            if ($request->subject_id) {
                $query->where('subject_id', $request->subject_id);
            }
            
            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('code', 'like', '%' . $request->search . '%')
                      ->orWhereHas('subject', function($q) use ($request) {
                          $q->where('name', 'like', '%' . $request->search . '%');
                      })
                      ->orWhereHas('subject.classModel', function($q) use ($request) {
                          $q->where('name', 'like', '%' . $request->search . '%');
                      })
                      ->orWhereHas('subject.division', function($q) use ($request) {
                          $q->where('name', 'like', '%' . $request->search . '%');
                      });
                });
            }
            
            $papers = $query->latest()->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Papers retrieved successfully',
                'data' => $papers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve papers: ' . $e->getMessage()
            ], 500);
        }
    }

    // Create a new paper
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $paper = new Paper();
            $paper->subject_id = $request->subject_id;
            $paper->name = $request->name;
            $paper->code = $request->code;
            $paper->is_active = $request->is_active ?? true;
            $paper->admin_id = auth()->user()->admin->id;
            $paper->save();

            return response()->json([
                'success' => true,
                'message' => 'Paper created successfully',
                'data' => $paper
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create paper: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get paper by ID for editing
    public function editById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:papers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $paper = Paper::with(['subject.classModel', 'subject.division'])->find($request->id);
            
            if (!$paper) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paper not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Paper retrieved successfully',
                'data' => $paper
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve paper: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update paper
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:papers,id',
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:papers,code,' . $request->id,
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $paper = Paper::find($request->id);
            
            if (!$paper) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paper not found'
                ], 404);
            }
            
            $paper->subject_id = $request->subject_id;
            $paper->name = $request->name;
            $paper->code = $request->code;
            $paper->is_active = $request->is_active ?? true;
            $paper->save();

            return response()->json([
                'success' => true,
                'message' => 'Paper updated successfully',
                'data' => $paper
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update paper: ' . $e->getMessage()
            ], 500);
        }
    }

    // Soft delete paper
    public function trash(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:papers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $paper = Paper::find($request->id);
            
            if (!$paper) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paper not found'
                ], 404);
            }
            
            $paper->delete();

            return response()->json([
                'success' => true,
                'message' => 'Paper moved to trash successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to trash paper: ' . $e->getMessage()
            ], 500);
        }
    }

    // List trashed papers
    public function trashedList(Request $request)
    {
        try {
            $query = Paper::onlyTrashed()->with(['subject.classModel', 'subject.division', 'admin']);
            
            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('code', 'like', '%' . $request->search . '%')
                      ->orWhereHas('subject', function($q) use ($request) {
                          $q->where('name', 'like', '%' . $request->search . '%');
                      });
                });
            }
            
            $papers = $query->latest('deleted_at')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Trashed papers retrieved successfully',
                'data' => $papers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve trashed papers: ' . $e->getMessage()
            ], 500);
        }
    }

    // Restore trashed paper
    public function restore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:papers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $paper = Paper::onlyTrashed()->find($request->id);
            
            if (!$paper) {
                return response()->json([
                    'success' => false,
                    'message' => 'Trashed paper not found'
                ], 404);
            }
            
            $paper->restore();

            return response()->json([
                'success' => true,
                'message' => 'Paper restored successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore paper: ' . $e->getMessage()
            ], 500);
        }
    }

    // Permanently delete paper
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:papers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $paper = Paper::onlyTrashed()->find($request->id);
            
            if (!$paper) {
                return response()->json([
                    'success' => false,
                    'message' => 'Trashed paper not found'
                ], 404);
            }
            
            $paper->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Paper deleted permanently'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete paper: ' . $e->getMessage()
            ], 500);
        }
    }

    // Search papers
    public function search(Request $request)
    {
        return $this->list($request);
    }

    // Search trashed papers
    public function trashedSearch(Request $request)
    {
        return $this->trashedList($request);
    }

    // Get divisions by class
    public function getDivisionsByClass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:class_models,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $divisions = Division::where('class_id', $request->class_id)->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Divisions retrieved successfully',
                'data' => $divisions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve divisions: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get subjects by class and division
    public function getSubjectsByClassAndDivision(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:class_models,id',
            'division_id' => 'nullable|exists:divisions,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $query = Subject::where('class_id', $request->class_id);
            
            if ($request->division_id) {
                $query->where('division_id', $request->division_id);
            }
            
            $subjects = $query->get();
            
            return response()->json([
                'success' => true,  // Fixed: changed from 'status' => 'success'
                'message' => 'Subjects retrieved successfully',
                'data' => $subjects
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve subjects: ' . $e->getMessage()
            ], 500);
        }
    }

    // Check if paper code exists
    public function checkCodeExists(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'id' => 'nullable|exists:papers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $query = Paper::where('code', $request->code);
            
            if ($request->id) {
                $query->where('id', '!=', $request->id);
            }
            
            $exists = $query->exists();
            
            return response()->json([
                'success' => true,
                'message' => 'Code check completed',
                'data' => [
                    'exists' => $exists
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to check code: ' . $e->getMessage()
            ], 500);
        }
    }
}



