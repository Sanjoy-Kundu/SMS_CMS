<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Editor;
use Illuminate\Http\Request;
use App\Models\EditorEducation;
use Illuminate\Support\Facades\Auth;

class EditorEducationController extends Controller
{
    /**
     * Editor Education lists
     */
    public function editorEducationList()
    {
        $user = Auth::user();
        $editor = Editor::where('user_id', $user->id)->first();
        if (!$editor) {
          return response()->json(['status'=>'error','message'=>'Editor profile not found'], 404);
         }
        try{
            $educationLits = EditorEducation::where('editor_id',$editor->id)->get();
            return response()->json(['status'=>'success','educationLists' => $educationLits], 200);
        }catch(Exception $e){
            return response()->json(['status'=>'fail','message' => $e->getMessage()], 500);
        }
    }



   /***
    *Editor Education lists by id 
    */ 
    public function editorEducationById(Request $request){
        try{
        $user = Auth::user();
        $editor = Editor::where('user_id', $user->id)->first();
        if (!$editor) {
          return response()->json(['status'=>'error','message'=>'Editor profile not found'], 404);
         }

         $data = EditorEducation::where('id',$request->id)->where('editor_id',$editor->id)->first();
         if(!$data){
            return response()->json(['status'=>'error','message'=>'Education not found'], 404);
         }
         return response()->json(['status'=>'success','data' => $data], 200);
        }catch(Exception $e){
            return response()->json(['status'=>'fail','message' => $e->getMessage()], 500);
        }
    }



    /***
     * Editor Education Update
     */
     public function editorEducationUpdate(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'id' => 'required|exists:editor_educations,id', // editor_educations table
                'level' => 'required|in:SSC,HSC,Graduation,Masters',
                'roll_number' => 'nullable|string|max:255',
                'board_university' => 'required|string|max:255',
                'result' => 'required|string|max:50',
                'passing_year' => 'required|digits:4|integer|min:1950|max:' . date('Y'),
                'course_duration' => 'nullable|string|max:50',
            ]);

            // Get logged-in editor
            $user = Auth::user();
            $editor = Editor::where('user_id', $user->id)->first();

            if (!$editor) {
                return response()->json(['status' => 'error', 'message' => 'Editor profile not found'], 404);
            }

            // Find education record for this editor
            $education = EditorEducation::where('id', $validated['id'])
                                        ->where('editor_id', $editor->id)
                                        ->first();

            if (!$education) {
                return response()->json(['status' => 'error', 'message' => 'Education record not found'], 404);
            }

            // Update fields
            $education->update([
                'level' => $validated['level'],
                'roll_number' => $validated['roll_number'],
                'board_university' => $validated['board_university'],
                'result' => $validated['result'],
                'passing_year' => (int) $validated['passing_year'],
                'course_duration' => $validated['course_duration'],
            ]);

            return response()->json(['status' => 'success', 'message' => 'Education updated successfully']);

        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json(['status' => 'fail', 'errors' => $ve->errors()], 422);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()], 500);
        }
    }






    /**
     * Editor Education Create
     */

public function editorEducationCreate(Request $request)
{   
    try{
            // Validate the incoming request data
    $validated = $request->validate([
        'editor_id' => 'required|exists:editors,id',// editor_id from form
        'level' => 'required|in:SSC,HSC,Graduation,Masters',
        'roll_number' => 'nullable|string|max:255',
        'board_university' => 'required|string|max:255',
        'result' => 'required|string|max:50',
        'passing_year' => 'required',
        'course_duration' => 'nullable|string|max:50'
    ]);
       
    $exists = EditorEducation::where('level','SSC')->orWhere('level','HSC')->orWhere('level','Graduation')->orWhere('level','Masters')->exists();
    if ($exists) {
        return response()->json(['status' => 'error', 'message' => 'Level  already exists.'], 400);
    }
    // Create new education record
    EditorEducation::create([
        'editor_id' => $validated['editor_id'],
        'level' => $validated['level'],
        'roll_number' => $validated['roll_number'],
        'board_university' => $validated['board_university'],
        'result' => $validated['result'],
        'passing_year' => $validated['passing_year'],
        'course_duration' => $validated['course_duration']
    ]);

    // Return success response
    return response()->json(['status' => 'success', 'message' => 'Education information added successfully']);

    }catch(Exception $ex){
        return response()->json(['status' => 'fail','message' => $ex->getMessage()], 500);
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
    public function show(EditorEducation $editorEducation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditorEducation $editorEducation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EditorEducation $editorEducation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EditorEducation $editorEducation)
    {
        //
    }
}
