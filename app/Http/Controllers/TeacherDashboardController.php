<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    //techer pfofile page
        public function teacherProfilePage()
    {
        try {
            return view('pages.dashboard.teacher.teacherProfilePage');
        } catch (Exception $ex) {
            return response()->json(['status' => 'fail', 'message' => $ex->getMessage()]);
        }
    }
}
