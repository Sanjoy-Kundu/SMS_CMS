<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function AnnouncementLists(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:class_models,id',
        ]);

        try {
            $announcements = Announcement::where('class_id', $validated['class_id'])
                                ->latest()
                                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Announcements retrieved successfully',
                'data' => $announcements
            ]);

        } catch (\Exception $ex) {
            // Error return + console friendly
            return response()->json([
                'status' => 'fail',
                'message' => 'Something went wrong on server!',
                'error' => $ex->getMessage()
            ], 500);
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
    public function AnnouncementStore(Request $request)
    {
        // ✅ Validation
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:High,Medium,Low',
            'audience' => 'required|in:Students,Teachers,All',
            'category' => 'required|in:Exam,Event,Homework,General',
            'recurring' => 'required|in:None,Daily,Weekly,Monthly',
            'is_active' => 'required|boolean',
            'valid_until' => 'nullable|date',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:4096',
            'link' => 'nullable|url',
            'class_id' => 'required|exists:class_models,id',
        ]);

        // ✅ File Upload (public/uploads/attachments এ save হবে)
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Ensure folder exists
            $destinationPath = public_path('uploads/attachments');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Move file
            $file->move($destinationPath, $fileName);

            // Save relative path
            $attachmentPath = 'uploads/attachments/' . $fileName;
        }

        // ✅ Save Announcement
        $announcement = Announcement::create([
            'user_id' => Auth::id(),
            'class_id' => $validated['class_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'audience' => $validated['audience'],
            'category' => $validated['category'],
            'recurring' => $validated['recurring'],
            'is_active' => $validated['is_active'],
            'valid_until' => $validated['valid_until'] ?? null,
            'link' => $validated['link'] ?? null,
            'attachment' => $attachmentPath, // ✅ public/uploads/attachments/fileName
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Announcement created successfully!',
            'data' => $announcement,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        //
    }
}
