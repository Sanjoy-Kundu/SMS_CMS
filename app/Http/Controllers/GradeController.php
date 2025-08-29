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
    public function show($grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($grade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $grade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($grade)
    {
        //
    }
}
