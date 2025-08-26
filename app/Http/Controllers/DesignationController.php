<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        //
    }
}
