<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showForgotPasswordForm(){
        try{
            return view('form.admin.forgot_password_form');
        }catch(Exception $ex){
            return response()->json(['status' => 'errro', 'message' => $ex->getMessage()]);
        }
    }


    public function showVerifyOtpForm(){
        try{
            return view('form.admin.verify-otp_form');
        }catch(Exception $ex){
            return response()->json(['status' => 'errro', 'message' => $ex->getMessage()]);
        }
    }

    public function showResetPasswordForm(){
        try{
            return view('form.reset_password_form');
        }catch(Exception $ex){
            return response()->json(['status' => 'errro', 'message' => $ex->getMessage()]);
        }
    }


    public function otp_details_users(Request $request){
        try{
            $email = $request->email;
            $user = User::with('admin')->where('email', $email)->first();
            if(!$user){
                return response()->json(['status' => 'error', 'message' => 'Email not found']);
            }
            return response()->json(['status' => 'success', 'user' => $user]);
        }catch(Exception $ex){
            return response()->json(['status' => 'errro', 'message' => $ex->getMessage()]);
        }
    }
}
    

