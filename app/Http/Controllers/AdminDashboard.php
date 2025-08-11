<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class AdminDashboard extends Controller
{
    public function adminDashboard(){
        try{
            return view('pages.dashboard.indexPage');
        }catch(Exception $ex){
            return response()->json(['status' => 'fail','message' => $ex->getMessage()]);
        }
    }
}
