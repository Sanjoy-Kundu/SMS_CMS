<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\SendOtpMail;
use App\Models\PasswordOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
                return response()->json([
                    'status' => 'error',
                    'message' => 'This email is not registered.',
                ], 404);
            }

            $token = $user->createToken('token')->plainTextToken;

            // ২. Random 6 digit OTP তৈরি
            $otp = mt_rand(100000, 999999);

            // ৩. OTP টেবিলে সেভ করা (আগে যদি থাকে তাহলে আপডেট)
            $now = Carbon::now();
            $expiresAt = $now->copy()->addMinutes(10); // ১০ মিনিট মেয়াদ

            PasswordOtp::updateOrCreate(
                ['email' => $email],
                [
                    'otp' => $otp,
                    'created_at' => $now,
                    'expires_at' => $expiresAt,
                ]
            );

            // ৪. OTP ইমেইল পাঠানো
            Mail::to($email)->send(new SendOtpMail($otp));

            // ৫. সফল রেসপন্স
            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent to your email address.',
                'email' => $email,
                'token' => $token,
            ]);
        } catch (Exception $ex) {
            //Log::error('Send OTP Error: ' . $ex->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send OTP. Please try again later.',
            ], 500);
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

            $now = Carbon::now();

            // OTP মিলিয়ে নেওয়া মডেল দিয়ে
            $otpRecord = PasswordOtp::where('email', $email)
                ->where('otp', $otp)
                ->where('expires_at', '>', $now)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$otpRecord) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid or expired OTP.',
                ], 422);
            }

            // OTP ভেরিফাই হলে ডিলিট করে দাও
            $otpRecord->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'OTP verified successfully.',
            ]);
        } catch (Exception $ex) {
            //Log::error('Verify OTP Error: ' . $ex->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Server error: Please try again later.',
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found.',
                ], 404);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Password reset successfully.',
            ]);
        } catch (Exception $ex) {
            //Log::error('Reset Password Error: ' . $ex->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to reset password. Please try again later.',
            ], 500);
        }
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        try {
            $email = $request->email;

            $otp = rand(100000, 999999);

            PasswordOtp::updateOrCreate(
                ['email' => $email],
                [
                    'otp' => $otp,
                    'created_at' => now(),
                    'expires_at' => now()->addMinutes(10),
                ]
            );

            Mail::to($email)->send(new SendOtpMail($otp));

            return response()->json([
                'status' => 'success',
                'message' => 'OTP resent successfully. Please check your email.',
            ]);
        } catch (Exception $ex) {
            //Log::error('Resend OTP Error: ' . $ex->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to resend OTP. Please try again later.',
            ], 500);
        }
    }
}


