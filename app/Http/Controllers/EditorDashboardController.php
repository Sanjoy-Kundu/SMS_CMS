<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class EditorDashboardController extends Controller
{
    public function editorDashboardPage(){
        try{
           return view('pages.dashboard.editor.indexPage');
        }catch(Exception $ex){
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }
}

