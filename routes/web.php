<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordReset;
use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

//page route start
Route::get('admin/login', [AdminController::class, 'admin_login_page']);
Route::get('admin/registration', [AdminController::class, 'admin_registration_page']);

Route::get('/forgot-password', [UserController::class, 'showForgotPasswordForm']);
Route::get('/verify-otp', [UserController::class, 'showVerifyOtpForm']);
Route::get('/forgot-password/reset-password', [UserController::class, 'showResetPasswordForm']);

//page route end
//Forget Password 
Route::post('/forgot-password/send-otp', [PasswordReset::class, 'sendOtp']);
Route::post('/forgot-password/verify-otp', [PasswordReset::class, 'verifyOtp'])->middleware(['auth:sanctum']);
Route::post('/forgot-password/reset-password', [PasswordReset::class, 'resetPassword']);


Route::post('/otp-details-users', [UserController::class, 'otp_details_users'])->middleware(['auth:sanctum']);







Route::post('/admin/registration/store', [AdminController::class, 'admin_registration_store']);
Route::post('/admin/login/store', [AdminController::class, 'admin_login_store']);


//admin dashboard page route 
Route::get('/admin/dashboard', [AdminDashboard::class, 'adminDashboardPage']);
Route::get('/admin/profile', [AdminDashboard::class, 'adminProfilePage']);


//admin protected route
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/auth/admin/details', [AdminDashboard::class, 'adminDetails']);
    Route::post('admin/logout', [AdminDashboard::class, 'logout']);
    Route::post('/admin/update-profile',[AdminDashboard::class, 'adminUpdateProfile']);
    Route::post('/admin/password/update',[AdminDashboard::class, 'adminUpdatePassword']);

});