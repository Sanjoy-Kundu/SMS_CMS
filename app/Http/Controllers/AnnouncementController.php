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
                'id.required' => 'অ্যানাউন্সমেন্ট আইডি প্রয়োজন।',
                'id.exists' => 'প্রদত্ত আইডি দিয়ে কোনো অ্যানাউন্সমেন্ট পাওয়া যায়নি।',
                'title.required' => 'টাইটেল ফিল্ডটি পূরণ করুন।',
                'title.max' => 'টাইটেল ২৫৫ অক্ষরের বেশি হতে পারবে না।',
                'priority.required' => 'প্রায়োরিটি নির্বাচন করুন।',
                'priority.in' => 'প্রায়োরিটি অবশ্যই High, Medium, বা Low হতে হবে।',
                'description.required' => 'বর্ণনা ফিল্ডটি পূরণ করুন।',
                'audience.required' => 'অডিয়েন্স নির্বাচন করুন।',
                'audience.in' => 'অডিয়েন্স অবশ্যই Students, Teachers, বা All হতে হবে।',
                'category.required' => 'ক্যাটাগরি নির্বাচন করুন।',
                'category.in' => 'ক্যাটাগরি অবশ্যই Exam, Event, Homework, বা General হতে হবে।',
                'recurring.required' => 'রিকারিং নির্বাচন করুন।',
                'recurring.in' => 'রিকারিং অবশ্যই None, Daily, Weekly, বা Monthly হতে হবে।',
                'attachment.file' => 'অ্যাটাচমেন্ট অবশ্যই একটি ফাইল হতে হবে।',
                'attachment.mimes' => 'অ্যাটাচমেন্ট শুধুমাত্র JPG, PNG, PDF, বা Word ফাইল হতে পারবে।',
                'attachment.max' => 'অ্যাটাচমেন্টের সাইজ ৫ মেগাবাইটের বেশি হতে পারবে না।',
                'link.url' => 'দয়া করে একটি বৈধ URL লিখুন (যেমন, https://example.com)।',
                'valid_until.required' => 'বৈধতার সময়সীমা নির্বাচন করুন।',
                'valid_until.date' => 'বৈধতার সময়সীমা একটি বৈধ তারিখ হতে হবে।',
                'valid_until.after_or_equal' => 'বৈধতার সময়সীমা আজকের বা ভবিষ্যতের তারিখ হতে হবে।',
                'is_active.required' => 'স্ট্যাটাস নির্বাচন করুন।',
                'is_active.in' => 'স্ট্যাটাস অবশ্যই Active (1) বা Inactive (0) হতে হবে।'
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
                    'message' => 'ভ্যালিডেশন ফেইলড।',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find the announcement
            $announcement = Announcement::find($request->id);
            if (!$announcement) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'অ্যানাউন্সমেন্ট পাওয়া যায়নি।'
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
                'message' => 'অ্যানাউন্সমেন্ট সফলভাবে আপডেট হয়েছে।',
                'data' => $announcement
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'fail',
                'message' => 'অ্যানাউন্সমেন্ট আপডেট করার সময় সমস্যা হয়েছে: ' . $ex->getMessage()
            ], 500);
        }
    }

}
