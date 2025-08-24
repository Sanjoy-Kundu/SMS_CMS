<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Editor;
use Illuminate\Http\Request;
use App\Models\EditorAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EditorAddressController extends Controller
{
    /**
     * Editor Address lists
     */
    public function editorAddressLists()
    {
        $user = Auth::user();
        $editor = Editor::where('user_id', $user->id)->first();
        if (!$editor) {
            return response()->json(['status' => 'error', 'message' => 'Editor profile not found'], 404);
        }
        try {
            $addressLits = EditorAddress::where('editor_id', $editor->id)->get();
            return response()->json(['status' => 'success', 'addressLists' => $addressLits], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }

    // Get address by ID details by id
    public function getAddressById(Request $request)
    {
        try {
            $id = $request->id;
            $address = EditorAddress::where('id', $id)->first();

            if ($address) {
                return response()->json(['status' => 'success', 'data' => $address]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Address not found']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }

    //delete address by id
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

            $editorDetails = Editor::where('user_id', $user->id)->first();
            if (!$editorDetails) {
                return response()->json(['status' => 'error', 'message' => 'Editor profile not found'], 404);
            }

            $editorAddressDetails = EditorAddress::where('id', $request->id)
                ->where('editor_id', $editorDetails->id)
                ->first();

            if (!$editorAddressDetails) {
                return response()->json(['status' => 'error', 'message' => 'Address not found'], 404);
            }

            // ⚡ Permanent delete
            $editorAddressDetails->forceDelete();

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






    // Update address
    public function updateAddress(Request $request)
    {
            try {
                $validator = Validator::make($request->all(), [
                    'id' => 'required|exists:editor_addresses,id',
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
            $editor = Editor::where('user_id', $user->id)->first();

                // Update or create
                $address = EditorAddress::updateOrCreate(
                    ['id' => $request->id],
                    [
                        'editor_id' => $editor->id,
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
     * Editor Address Create
     */

    public function editorAddressCreate(Request $request)
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
            $editor = Editor::where('user_id', $user->id)->first();
            // Optional: prevent duplicate address type for same editor
            $exists = EditorAddress::where('editor_id', $editor->id)->where('type', $validated['type'])->exists();

            if ($exists) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'This address type already exists for this editor.',
                    ],
                    400,
                );
            }


            // Create new address record
            EditorAddress::create([
                'editor_id' => $editor->id,
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
    public function show(EditorAddress $editorAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditorAddress $editorAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EditorAddress $editorAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EditorAddress $editorAddress)
    {
        //
    }
}
