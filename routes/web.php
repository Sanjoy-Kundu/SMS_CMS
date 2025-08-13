<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordReset;
use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\UserController;

//admin registration and login  page route
Route::get('/admin/login', [AdminController::class, 'admin_login_page']);
Route::get('/admin/registration', [AdminController::class, 'admin_registration_page']);

//admin registration and login store route
Route::post('/admin/registration/store', [AdminController::class, 'admin_registration_store']);
Route::post('/admin/login/store', [AdminController::class, 'admin_login_store']);

//forget passwordn and otp for common page route
Route::get('/forgot-password', [UserController::class, 'showForgotPasswordForm']);
Route::get('/verify-otp', [UserController::class, 'showVerifyOtpForm']);
Route::get('/reset-password', [UserController::class, 'showResetPasswordForm']);
//page route end


//forget passwordn and otp for common store route
Route::post('/forgot-password/send-otp', [PasswordReset::class, 'sendOtp']);
Route::post('/forgot-password/verify-otp', [PasswordReset::class, 'verifyOtp'])->middleware(['auth:sanctum']);
Route::post('/forgot-password/resend-otp', [PasswordReset::class, 'resendOtp'])->middleware(['auth:sanctum']);
Route::post('/otp-details-users', [UserController::class, 'otp_details_users'])->middleware(['auth:sanctum']);
Route::post('/forgot-password/reset-password', [PasswordReset::class, 'resetPassword']);
//Forget Password post route for backend










//admin dashboard page route 
Route::get('/admin/dashboard', [AdminDashboard::class, 'adminDashboardPage']);
Route::get('/admin/profile', [AdminDashboard::class, 'adminProfilePage']);

//admin dashboard institutation page route
Route::get('/institution', [AdminDashboard::class, 'adminInstitutionPage']);



// admin protected route
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/auth/admin/details', [AdminDashboard::class, 'adminDetails']);
    Route::post('admin/logout', [AdminDashboard::class, 'logout']);
    Route::post('/admin/update-profile', [AdminDashboard::class, 'adminUpdateProfile']);
    Route::post('/admin/password/update', [AdminDashboard::class, 'adminUpdatePassword']);
    
    // Institution routes
    Route::post('/institution/details', [InstitutionController::class, 'institutionDetails']);
    Route::post('/institution/create', [InstitutionController::class, 'institutionCreate']);
    
    Route::post('/institution/trash', [InstitutionController::class, 'institutionTrash']);
    Route::post('/institution/restore', [InstitutionController::class, 'institutionRestore']);
    Route::post('/institution/delete', [InstitutionController::class, 'institutionDelete']);

    Route::post('/institution/edit-by-id', [InstitutionController::class, 'institutionEditById']);
    Route::post('/institution/update', [InstitutionController::class, 'institutionUpdate']);
});