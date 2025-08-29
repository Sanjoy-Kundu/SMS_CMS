<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Grade;
use App\Models\GradingScale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function ClassGradingListsByClass(Request $request)
    {
        try {
            $data = GradingScale::where('class_id', $request->class_id)->get();
            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function ClassGradingStore(Request $request)
    {
        try {
            // validation
            $validated = $request->validate([
                'class_id' => 'required|exists:class_models,id',
                'grade' => 'required|string|max:5',
                'gpa' => 'required|numeric|min:0|max:5',
                'min_range' => 'required|integer|min:0|max:100',
                'max_range' => 'required|integer|min:0|max:100|gte:min_range',
            ]);

            // current user id (admin/editor যেই login করেছে)
            $user_id = Auth::id();

            GradingScale::create([
                'user_id' => $user_id,
                'class_id' => $validated['class_id'],
                'grade' => $validated['grade'],
                'gpa' => $validated['gpa'],
                'min_range' => $validated['min_range'],
                'max_range' => $validated['max_range'],
            ]);

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Grading scale added successfully!',
                ],
                201,
            );
        } catch (QueryException $ex) {
            // Duplicate entry error (MySQL error code 23000)
            if ($ex->getCode() == '23000') {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'This grade already exists for this class!',
                    ],
                    422,
                );
            }

            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Database error: ' . $ex->getMessage(),
                ],
                500,
            );
        } catch (Exception $ex) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $ex->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function ClassGradingDeleteById(Request $request)
    {
        try {
            // check if id present
            if (!$request->has('id')) {
                return response()->json(
                    [
                        'status' => 'fail',
                        'message' => 'Grading Scale ID is missing!',
                    ],
                    400,
                );
            }

            $gradingScale = GradingScale::find($request->id);

            if (!$gradingScale) {
                return response()->json(
                    [
                        'status' => 'fail',
                        'message' => 'Grading Scale not found!',
                    ],
                    404,
                );
            }

            // Permanent delete
            $gradingScale->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Grading Scale deleted successfully!',
            ]);
        } catch (Exception $ex) {
            return response()->json(
                [
                    'status' => 'fail',
                    'message' => $ex->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Grade List by Id
     */
    public function getGradingById(Request $request)
    {
        $id = $request->id;
        if (!$id) {
            return response()->json(['status'=>'fail','message'=>'ID is required']);
        }

        try {
            $grading = GradingScale::find($id);
            if (!$grading) {
                return response()->json(['status'=>'fail','message'=>'Grading not found']);
            }
            return response()->json(['status'=>'success','data'=>$grading]);
        } catch (\Exception $ex) {
            return response()->json(['status'=>'fail','message'=>$ex->getMessage()]);
        }
    }

    /**
     * Grade Update
     */
    public function updateGradingById(Request $request)
    {
        $id = $request->id;
        if (!$id) {
            return response()->json(['status'=>'fail','message'=>'ID is required']);
        }

        $request->validate([
            'grade'=>'nullable|string',
            'gpa'=>'nullable|numeric',
            'min_range'=>'nullable|integer',
            'max_range'=>'nullable|integer',
        ]);

        try {
            $grading = GradingScale::find($id);
            if (!$grading) {
                return response()->json(['status'=>'fail','message'=>'Grading not found']);
            }

            $grading->grade = $request->grade;
            $grading->gpa = $request->gpa;
            $grading->min_range = $request->min_range;
            $grading->max_range = $request->max_range;
            $grading->save();

            return response()->json(['status'=>'success','message'=>'Grading updated successfully']);
        } catch (\Exception $ex) {
            return response()->json(['status'=>'fail','message'=>$ex->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($grade)
    {
        //
    }
}
