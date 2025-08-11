<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboard;

//page route start
Route::get('admin/login', [AdminController::class, 'admin_login_page']);
Route::get('admin/registration', [AdminController::class, 'admin_registration_page']);
//page route end








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
});