<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

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
     * Announcement Trash
     */
    public function AnnouncementTrash(Request $request)
        {
            $request->validate([
                'id' => 'required|exists:announcements,id',
            ]);

            try {
                $announcement = Announcement::findOrFail($request->id);
                
                // Optional: Only admin or owner can delete Auth::user()->role !== 'editor'
                if(Auth::user()->role !== 'admin' && $announcement->user_id !== Auth::id()){
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'Unauthorized action.'
                    ], 403);
                }

                $announcement->delete();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Announcement trashed successfully.'
                ]);
            } catch (Exception $ex) {
                return response()->json([
                    'status' => 'fail',
                    'message' => $ex->getMessage()
                ], 500);
            }
    }

    // Announcement Trash Lists
    public function trashedLists(Request $request){
        try{
        $announcements = Announcement::onlyTrashed()->where('class_id', $request->class_id)->get();
          return response()->json(['status'=>'success','data'=>$announcements]);
        }catch(Exception $ex){
            return response()->json(['status' => 'fail','message' => $ex->getMessage()]);

        }
    }

    //Announcyhment Resote
    public function restore(Request $request){
        try{
        $announcement = Announcement::onlyTrashed()->findOrFail($request->id);
        $announcement->restore();
        return response()->json(['status'=>'success','message'=>'Announcement restored successfully']);
        }catch(Exception $ex){
            return response()->json(['status' => 'fail','message' => $ex->getMessage()]);
        }
    }

    public function deletePermanent(Request $request){
        try {
            // শুধু trashed announcement
            $announcement = Announcement::onlyTrashed()->findOrFail($request->id);

            // যদি attachment delete করো
            if($announcement->attachment){
                $filePath = public_path($announcement->attachment); // public/uploads/attachments/filename.pdf
                if(File::exists($filePath)){
                    File::delete($filePath);
                }
            }

            // permanently delete
            $announcement->forceDelete();

            return response()->json([
                'status' => 'success',
                'message' => 'Announcement permanently deleted along with attachment'
            ]);
            
        } catch(Exception $ex) {
            return response()->json([
                'status' => 'fail',
                'message' => $ex->getMessage()
            ]);
        }
    }


       //Announcement View
     public function view(Request $request)
     {
        try{
         $id = $request->id;
        $announcement = Announcement::find($id);
        if(!$announcement){
            return response()->json([
                'status' => 'error',
                'message' => 'Announcement not found'
            ], 404);
        }
        // $attachmentType = null;
        // $attachmentUrl = null;
        return response()->json([
            'status' => 'success',
            'data' => $announcement
        ]);

        }catch(Exception $ex){
            return response()->json(['status' => 'fail','message' => $ex->getMessage()]);
        }
     }

     //Announcement Update
    public function AnnouncementUpdate(Request $request)
        {
            try {
                // Custom validation messages
                $messages = [
                    'id.required' => 'Announcement ID is required.',
                    'id.exists' => 'No announcement found with the provided ID.',
                    'title.required' => 'The title field is required.',
                    'title.max' => 'The title cannot exceed 255 characters.',
                    'priority.required' => 'Please select a priority.',
                    'priority.in' => 'Priority must be High, Medium, or Low.',
                    'description.required' => 'The description field is required.',
                    'audience.required' => 'Please select an audience.',
                    'audience.in' => 'Audience must be Students, Teachers, or All.',
                    'category.required' => 'Please select a category.',
                    'category.in' => 'Category must be Exam, Event, Homework, or General.',
                    'recurring.required' => 'Please select a recurring option.',
                    'recurring.in' => 'Recurring must be None, Daily, Weekly, or Monthly.',
                    'attachment.file' => 'The attachment must be a file.',
                    'attachment.mimes' => 'The attachment must be a JPG, PNG, PDF, or Word file.',
                    'attachment.max' => 'The attachment size cannot exceed 5 megabytes.',
                    'link.url' => 'Please enter a valid URL (e.g., https://example.com).',
                    'valid_until.required' => 'Please select a validity deadline.',
                    'valid_until.date' => 'The validity deadline must be a valid date.',
                    'valid_until.after_or_equal' => 'The validity deadline must be today or a future date.',
                    'is_active.required' => 'Please select a status.',
                    'is_active.in' => 'Status must be Active (1) or Inactive (0).'
                ];

                // Validate request data
                $validator = Validator::make($request->all(), [
                    'id' => 'required|exists:announcements,id',
                    'title' => 'required|string|max:255',
                    'priority' => 'required|in:High,Medium,Low',
                    'description' => 'required|string',
                    'audience' => 'required|in:Students,Teachers,All',
                    'category' => 'required|in:Exam,Event,Homework,General',
                    'recurring' => 'required|in:None,Daily,Weekly,Monthly',
                    'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
                    'link' => 'nullable|url',
                    'valid_until' => 'required|date|after_or_equal:today',
                    'is_active' => 'required|in:0,1'
                ], $messages);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'validation failed',
                        'errors' => $validator->errors()
                    ], 422);
                }

                // Find the announcement
                $announcement = Announcement::find($request->id);
                if (!$announcement) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Announcement not found'
                    ], 404);
                }

                // Handle file upload
                $attachmentPath = $announcement->attachment;
                if ($request->hasFile('attachment')) {
                    // Delete old file if it exists
                    if ($attachmentPath && File::exists(public_path($attachmentPath))) {
                        File::delete(public_path($attachmentPath));
                    }

                    // Upload new file
                    $file = $request->file('attachment');
                    $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                    $destinationPath = public_path('uploads/attachments');
                    
                    if (!File::exists($destinationPath)) {
                        File::makeDirectory($destinationPath, 0755, true);
                    }

                    $file->move($destinationPath, $filename);
                    $attachmentPath = 'uploads/attachments/' . $filename;
                }

                // Update announcement
                $announcement->update([
                    'title' => $request->title,
                    'priority' => $request->priority,
                    'description' => $request->description,
                    'audience' => $request->audience,
                    'category' => $request->category,
                    'recurring' => $request->recurring,
                    'attachment' => $attachmentPath,
                    'link' => $request->link,
                    'valid_until' => $request->valid_until,
                    'is_active' => $request->is_active
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Announchment Updated Successfully',
                    'data' => $announcement
                ]);
            } catch (Exception $ex) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'An error occurred while updating the announcement. Error: ' . $ex->getMessage()
                ], 500);
            }
        }

}
