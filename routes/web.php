<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;



//page route start
Route::get('admin/login', [AdminController::class, 'admin_login_page']);
Route::get('admin/registration', [AdminController::class, 'admin_registration_page']);
//page route end








Route::post('/admin/registration/store', [AdminController::class, 'admin_registration_store']);