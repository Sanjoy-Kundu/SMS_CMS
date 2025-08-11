<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PasswordReset extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $email = $request->email;

            // ১. ইউজার আছে কিনা চেক করা
            $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'This email is not registered.',
                    ],
                    404,
                );
            }

            $token = $user->createToken('token')->plainTextToken;
            // ২. Random 6 digit OTP তৈরি
            $otp = mt_rand(100000, 999999);

            // ৩. OTP টেবিলে সেভ করা (আগে যদি থাকে তাহলে আপডেট)
            $now = Carbon::now();
            $expiresAt = $now->copy()->addMinutes(10); // ১০ মিনিট মেয়াদ

            DB::table('password_otps')->updateOrInsert(
                ['email' => $email],
                [
                    'otp' => $otp,
                    'created_at' => $now,
                    'expires_at' => $expiresAt,
                ],
            );

            // ৪. OTP ইমেইল পাঠানো (Mail সেটাপ দরকার)
            Mail::to($email)->send(new SendOtpMail($otp));

            // উদাহরণ হিসেবে শুধুমাত্র লগে লিখে দিলাম
            //\Log::info("Password reset OTP sent to $email: $otp");

            // ৫. সফল রেসপন্স
            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent to your email address.',
                'email' => $email,
                'token' => $token, // যদি টোকেন দরকার হয়
            ]);
        } catch (\Exception $ex) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $ex->getMessage(),
                ],
                500,
            );
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        try {
            $email = $request->input('email');
            $otp = $request->input('otp');

            // বর্তমান সময় নাও
            $now = Carbon::now();

            // OTP টেবিল থেকে মিল খোঁজো
            $otpRecord = DB::table('password_otps')->where('email', $email)->where('otp', $otp)->where('expires_at', '>', $now)->orderBy('created_at', 'desc')->first();

            if (!$otpRecord) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Invalid or expired OTP.',
                    ],
                    422,
                );
            }
            DB::table('password_otps')->where('id', $otpRecord->id)->delete();
            // OTP সঠিক হলে response
            return response()->json([
                'status' => 'success',
                'message' => 'OTP verified successfully.',
            ]);
        } catch (\Exception $ex) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Server error: ' . $ex->getMessage(),
                ],
                500,
            );
        }
    }
}
