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

Route::get('/admin/dashboard', [AdminController::class, 'admin_dashboard']);

// Route::get('admin/dashboard', [AdminDashboard::class, 'adminDashboard']);
// Route::middleware(['auth:sanctum', 'second'])->group(function () {
    
// });