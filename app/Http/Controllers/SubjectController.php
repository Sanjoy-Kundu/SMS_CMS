<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Division;
use App\Models\ClassModel;
use App\Models\Institution;
use Illuminate\Http\Request;
use App\Models\AcademicSection;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
     // List all subjects
    public function subjectLists(Request $request)
    {
        try {
            $subjects = Subject::with(['classModel', 'division', 'admin'])
                ->latest()
                ->get();
            return response()->json([
                'status' => 'success',
                'data' => $subjects,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to load subjects: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
    
    // Get divisions by class ID - NEW METHOD
    public function getDivisionsByClass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:class_models,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $divisions = Division::where('class_id', $request->class_id)->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $divisions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to load divisions: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // Create a new subject
    public function subjectCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:class_models,id',
            'division_id' => 'nullable|exists:divisions,id', // Make nullable
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'type' => 'required|in:compulsory,optional,additional',
            'is_active' => 'boolean',
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
        
        try {
            $subject = new Subject();
            $subject->class_id = $request->class_id;
            $subject->division_id = $request->division_id; // Can be null
            $subject->admin_id = auth()->user()->admin->id;
            $subject->name = $request->name;
            $subject->code = $request->code;
            $subject->type = $request->type;
            $subject->is_active = $request->has('is_active') ? $request->is_active : true;
            $subject->save();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Subject created successfully',
                'data' => $subject,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to create subject: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
    
    // Move subject to trash
    public function subjectTrash(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:subjects,id',
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
        
        try {
            $subject = Subject::findOrFail($request->id);
            $subject->delete();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Subject moved to trash successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to trash subject: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
    
    // List trashed subjects
    public function subjectTrashedList(Request $request)
    {
        try {
            $subjects = Subject::onlyTrashed()
                ->with(['classModel', 'division'])->latest()->get();
            return response()->json([
                'status' => 'success',
                'data' => $subjects,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to load trashed subjects: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
    
    // Restore trashed subject
    public function subjectRestore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:subjects,id',
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
        
        try {
            $subject = Subject::onlyTrashed()->findOrFail($request->id);
            $subject->restore();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Subject restored successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to restore subject: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
    
    // Permanently delete subject
    public function subjectDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:subjects,id',
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
        
        try {
            $subject = Subject::onlyTrashed()->findOrFail($request->id);
            $subject->forceDelete();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Subject deleted permanently',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to delete subject: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
    
    // Get subject by ID for editing
    public function subjectEditById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:subjects,id',
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
        
        try {
            $subject = Subject::findOrFail($request->id);
            return response()->json([
                'status' => 'success',
                'subject' => $subject,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to load subject: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
    
    // Update subject
    public function subjectUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:class_models,id',
            'division_id' => 'nullable|exists:divisions,id', // Make nullable
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'type' => 'required|in:compulsory,optional,additional',
            'is_active' => 'boolean',
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
        
        try {
            $subject = Subject::findOrFail($request->id);
            $subject->class_id = $request->class_id;
            $subject->division_id = $request->division_id; // Can be null
            $subject->name = $request->name;
            $subject->code = $request->code;
            $subject->type = $request->type;
            $subject->is_active = $request->has('is_active') ? $request->is_active : $subject->is_active;
            $subject->save();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Subject updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to update subject: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
    
    // Search subjects
    public function subjectSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search_term' => 'required|string|min:1',
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
        
        try {
            $searchTerm = $request->search_term;
            $subjects = Subject::with(['classModel', 'division', 'admin'])
                ->where(function ($query) use ($searchTerm) {
                    $query
                        ->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('code', 'like', '%' . $searchTerm . '%')
                        ->orWhereHas('classModel', function ($q) use ($searchTerm) {
                            $q->where('name', 'like', '%' . $searchTerm . '%');
                        })
                        ->orWhereHas('division', function ($q) use ($searchTerm) {
                            $q->where('name', 'like', '%' . $searchTerm . '%');
                        });
                })
                ->latest()
                ->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $subjects,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to search subjects: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
    
    // Search trashed subjects
    public function subjectTrashedSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search_term' => 'required|string|min:1',
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
        
        try {
            $searchTerm = $request->search_term;
            $subjects = Subject::onlyTrashed()
                ->where(function ($query) use ($searchTerm) {
                    $query
                        ->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('code', 'like', '%' . $searchTerm . '%')
                        ->orWhereHas('classModel', function ($q) use ($searchTerm) {
                            $q->where('name', 'like', '%' . $searchTerm . '%');
                        })
                        ->orWhereHas('division', function ($q) use ($searchTerm) {
                            $q->where('name', 'like', '%' . $searchTerm . '%');
                        });
                })
                ->latest()
                ->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $subjects,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to search trashed subjects: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }


   /**
     * Subject OverView
     */


// Add these methods to your SubjectController

 public function getAcademicSections(Request $request){
        try {
            $adminId = auth()->user()->admin->id;
            $institution = Institution::where('admin_id', $adminId)->first();
            
            $sections = AcademicSection::where('admin_id', $adminId)
                ->select('id', 'section_type')
                ->distinct()
                ->get();
                
            return response()->json([
                'status' => 'success',
                'data' => $sections,
                'institution' => $institution
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to load academic sections: ' . $e->getMessage()
            ], 500);
        }
}


public function getClassesBySection(Request $request)
    {
        try {
            $adminId = auth()->user()->admin->id;
            $academicSectionId = $request->academic_section_id;
            
            $classes = ClassModel::where('academic_section_id', $academicSectionId)
                ->where('admin_id', $adminId)
                ->orderBy('name')
                ->get();
                
            return response()->json([
                'status' => 'success',
                'data' => $classes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to load classes: ' . $e->getMessage()
            ], 500);
        }
    }


public function getSubjectDetailsByClass(Request $request)
{
    try {
        $adminId = auth()->user()->admin->id;
        $classId = $request->class_id;
        
        $subjects = Subject::with(['classModel', 'division', 'admin.user'])
            ->where('class_id', $classId)
            ->where('admin_id', $adminId)
            ->orderBy('name')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $subjects
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to load subject details: ' . $e->getMessage()
        ], 500);
    }
}


    // Get data for subject overview
public function subjectOverviewData(Request $request)
    {
        try {
            $query = Subject::with(['classModel', 'division', 'admin.user']);
            
            // Apply class filter if provided
            if ($request->class_id) {
                $query->where('class_id', $request->class_id);
            }
            
            $subjects = $query->orderBy('class_id')->orderBy('division_id')->get();
            
            // Group subjects by class and division
            $groupedSubjects = [];
            
            foreach ($subjects as $subject) {
                $className = $subject->classModel->name;
                $divisionName = $subject->division ? $subject->division->name : 'General';
                
                if (!isset($groupedSubjects[$className])) {
                    $groupedSubjects[$className] = [
                        'class_id' => $subject->class_id,
                        'divisions' => []
                    ];
                }
                
                if (!isset($groupedSubjects[$className]['divisions'][$divisionName])) {
                    $groupedSubjects[$className]['divisions'][$divisionName] = [
                        'division_id' => $subject->division_id,
                        'subjects' => []
                    ];
                }
                
                $groupedSubjects[$className]['divisions'][$divisionName]['subjects'][] = [
                    'id' => $subject->id,
                    'name' => $subject->name,
                    'code' => $subject->code,
                    'type' => $subject->type,
                    'is_active' => $subject->is_active
                ];
            }
            
            // Get all classes for the filter dropdown
            $classes = ClassModel::orderBy('name')->get();
            
            // Get institution info
            $institution = Institution::with('admin.user')->first();
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    'grouped_subjects' => $groupedSubjects,
                    'classes' => $classes,
                    'institution' => $institution
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to load overview data: ' . $e->getMessage()
            ], 500);
        }
    }
}