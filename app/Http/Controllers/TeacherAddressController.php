<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\TeacherAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TeacherAddressController extends Controller
{
    /**
     * Teacher Address lists
     */
    public function teacherAddressLists()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        if (!$teacher) {
            return response()->json(['status' => 'error', 'message' => 'Teacher profile not found'], 404);
        }
        try {
            $addressLits = TeacherAddress::where('teacher_id', $teacher->id)->get();
            return response()->json(['status' => 'success', 'addressLists' => $addressLits], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * teacher Address Create
     */

    public function teacherAddressCreate(Request $request)
    {
        try {
            // Validate incoming request
            $validated = $request->validate([
            'type' => 'required|in:present,permanent',
            'village' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'upazila' => 'nullable|string|max:255',
            'post_office' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            ]);

            $user = Auth::user();
            $teacher = Teacher::where('user_id', $user->id)->first();
            // Optional: prevent duplicate address type for same teacher
            $exists = TeacherAddress::where('teacher_id', $teacher->id)->where('type', $validated['type'])->exists();

            if ($exists) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'This address type already exists for this teacher.',
                    ],
                    400,
                );
            }


            // Create new address record
            TeacherAddress::create([
                'teacher_id' => $teacher->id,
                'type' => $validated['type'],
                'village' => $validated['village'] ?? null,
                'district' => $validated['district'] ?? null,
                'upazila' => $validated['upazila'] ?? null,
                'post_office' => $validated['post_office'] ?? null,
                'postal_code' => $validated['postal_code'] ?? null,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Address added successfully',
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




    //delete address
    public function deleteAddress(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'id' => 'required|integer',
            ]);

            $user = Auth::user();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
            }

            $teacherDetails = Teacher::where('user_id', $user->id)->first();
            if (!$teacherDetails) {
                return response()->json(['status' => 'error', 'message' => 'Teacher profile not found'], 404);
            }

            $teacherAddressDetails = TeacherAddress::where('id', $request->id)
                ->where('teacher_id', $teacherDetails->id)
                ->first();

            if (!$teacherAddressDetails) {
                return response()->json(['status' => 'error', 'message' => 'Address not found'], 404);
            }

            // ⚡ Permanent delete
            $teacherAddressDetails->forceDelete();

            return response()->json([
                'status' => 'success',
                'message' => 'Address permanently deleted'
            ], 200);

        } catch (Exception $ex) {
            return response()->json([
                'status' => 'fail',
                'message' => $ex->getMessage()
            ], 500);
        }
    }





    // Get address by ID details by id
    public function getAddressById(Request $request)
    {
        try {
            $id = $request->id;
            $address = TeacherAddress::where('id', $id)->first();

            if ($address) {
                return response()->json(['status' => 'success', 'data' => $address]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Address not found']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }

   // Update address
    public function updateAddress(Request $request)
    {
            try {
                $validator = Validator::make($request->all(), [
                    'id' => 'required|exists:teacher_addresses,id',
                    'type' => 'required|in:present,permanent',
                    'village' => 'nullable|string|max:255',
                    'district' => 'nullable|string|max:255',
                    'upazila' => 'nullable|string|max:255',
                    'post_office' => 'nullable|string|max:255',
                    'postal_code' => 'nullable|string|max:20',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()
                    ], 422);
                }
                $user = Auth::user();
                $teacher = Teacher::where('user_id', $user->id)->first();

                // Update or create
                $address = TeacherAddress::updateOrCreate(
                    ['id' => $request->id],
                    [
                        'teacher_id' => $teacher->id,
                        'type' => $request->type,
                        'village' => $request->village ?? null,
                        'district' => $request->district ?? null,
                        'upazila' => $request->upazila ?? null,
                        'post_office' => $request->post_office ?? null,
                        'postal_code' => $request->postal_code ?? null,
                    ]
                );

                return response()->json([
                    'status' => 'success',
                    'message' => 'Address updated successfully',
                    'data' => $address
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'status' => 'fail',
                    'message' => $ex->getMessage()
                ], 500);
            }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeacherAddress $teacherAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherAddress $teacherAddress)
    {
        //
    }
}
