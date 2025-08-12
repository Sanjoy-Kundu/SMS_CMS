<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Admin;
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

                return response()->json(['status' => 'success', 'data' => $institutions]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'You are not authorized to access this resource']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
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

            $exists = Institution::where('name', $validated['name'])->where('type', $validated['type'])->where('eiin', $validated['eiin'])->first();

            if ($exists) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'This institution already exists!',
                ]);
            }

            $admin = Admin::where('user_id', auth()->id())->first();

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
     * Store a newly created resource in storage.
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
            // ধরলাম তোমার ইনস্টিটিউশন soft delete করতে চাও:
            $institution->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Institution trashed successfully.',
            ]);
        } catch (\Exception $e) {
            // কোনো error হলে catch করবে
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
     * Display the specified resource.
     */
    public function show(Institution $institution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institution $institution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Institution $institution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institution $institution)
    {
        //
    }
}
