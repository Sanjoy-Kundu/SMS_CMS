<?php

use App\Models\AcademicSection;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordReset;
use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\ClassModelController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\EditorAddressController;
use App\Http\Controllers\AcademicSectionController;
use App\Http\Controllers\EditorDashboardController;
use App\Http\Controllers\EditorEducationController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\TeacherEducationController;

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
Route::get('/academic', [AdminDashboard::class, 'adminAcademicPage']);
Route::get('/classes', [AdminDashboard::class, 'adminClassPage']);
Route::get('/class/division', [AdminDashboard::class, 'adminDivisionPage']);
Route::get('/class/subject', [AdminDashboard::class, 'adminSubjectPage']);
Route::get('/class/overview', [AdminDashboard::class, 'classOverview']);
Route::get('/subject/paper', [AdminDashboard::class, 'adminSubjectPaperPage']);

//admin dashboard editor Creation page route
Route::get('/editor/create', [AdminDashboard::class, 'adminEditorCreatePage']);
Route::get('/teacher/create', [AdminDashboard::class, 'adminTeacherCreatePage']);




// admin protected route
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/auth/admin/details', [AdminDashboard::class, 'adminDetails']);
    Route::post('admin/logout', [AdminDashboard::class, 'logout']);
    Route::post('/admin/update-profile', [AdminDashboard::class, 'adminUpdateProfile']);
    Route::post('/admin/password/update', [AdminDashboard::class, 'adminUpdatePassword']);
    
    // ::::::::::::::::::Institution routes::::::::::::::::::::::
    Route::post('/institution/details', [InstitutionController::class, 'institutionDetails']);
    Route::post('/institution/create', [InstitutionController::class, 'institutionCreate']);

    Route::post('/institution/trash', [InstitutionController::class, 'institutionTrash']);
    Route::post('/institution/restore', [InstitutionController::class, 'institutionRestore']);
    Route::post('/institution/delete', [InstitutionController::class, 'institutionDelete']);

    Route::post('/institution/edit-by-id', [InstitutionController::class, 'institutionEditById']);
    Route::post('/institution/update', [InstitutionController::class, 'institutionUpdate']);
    //:::::::::::::::::::::Institution routes end:::::::::::::::::::::::

    // ::::::::::::::::::::Academic routes:::::::::::::::::::::::::::::::
    Route::post('/institution/lists', [AcademicSectionController::class, 'academicSectionInstitutionLists']);
    Route::post('/academic/section/lists', [AcademicSectionController::class, 'academicSectionLists']);
    Route::post('/academic/section/trash', [AcademicSectionController::class, 'academicSectionTrash']);
    Route::post('/academic/section/trashed-lists', [AcademicSectionController::class, 'academicSectionTrashedLists']);

    Route::post('/academic/section/create', [AcademicSectionController::class, 'academicSectionCreate']);
    Route::post('/academic/section/restore', [AcademicSectionController::class, 'academicSectionRestore']);
    Route::post('/academic/section/delete', [AcademicSectionController::class, 'academicSectionDelete']);
    Route::post('/academic/section/edit-by-id', [AcademicSectionController::class, 'academicSectionEditById']);
    Route::post('/academic/section/update', [AcademicSectionController::class, 'academicSectionUpdate']);
    //::::::::::::::::::::::Academic routes end:::::::::::::::::::::::::

    //::::::::::::::::::::::Academic Class routes start:::::::::::::::::::::::::
    Route::post('/class-model/lists', [ClassModelController::class, 'classModelLists']);
    Route::post('/class-model/create', [ClassModelController::class, 'classModelCreate']);
    Route::post('/class-model/trash', [ClassModelController::class, 'classModelTrash']);
    Route::post('/class-model/trashed-list', [ClassModelController::class, 'classModelTrashedList']);
    Route::post('/class-model/restore', [ClassModelController::class, 'classModelRestore']);
    Route::post('/class-model/delete', [ClassModelController::class, 'classModelDelete']);
    Route::post('/class-model/edit-by-id', [ClassModelController::class, 'classModelEditById']);
    Route::post('/class-model/update', [ClassModelController::class, 'classModelUpdate']);

    Route::post('/class-model/search', [ClassModelController::class, 'classModelSearch']);
    Route::post('/class-model/trashed-search', [ClassModelController::class, 'classModelTrashedSearch']);
    //::::::::::::::::::::::Academic Class routes end:::::::::::::::::::::::::

    //:::::::::::::::::::::Division Class routes start:::::::::::::::::::::
    Route::post('/division-class/lists', [DivisionController::class, 'divisionClassLists']);
    Route::post('/division-class/create', [DivisionController::class, 'divisionClassCreate']);
    Route::post('/division-class/trash', [DivisionController::class, 'divisionClassTrash']);
    Route::post('/division-class/trashed-list', [DivisionController::class, 'divisionClassTrashedList']);
    Route::post('/division-class/restore', [DivisionController::class, 'divisionClassRestore']);
    Route::post('/division-class/delete', [DivisionController::class, 'divisionClassDelete']);
    Route::post('/division-class/edit-by-id', [DivisionController::class, 'divisionClassEditById']);
    Route::post('/division-class/update', [DivisionController::class, 'divisionClassUpdate']);
    Route::post('/division-class/search', [DivisionController::class, 'divisionClassSearch']);
    Route::post('/division-class/trashed-search', [DivisionController::class, 'divisionClassTrashedSearch']);
    //:::::::::::::::::::::Division Class routes end:::::::::::::::::::::
   

    //::::::::::::::: Subject Class routes Start :::::::::::::::::::::::
    Route::post('/subject/lists', [SubjectController::class, 'subjectLists']);
    Route::post('/subject/get-divisions-by-class', [SubjectController::class, 'getDivisionsByClass']);
    Route::post('/subject/create', [SubjectController::class, 'subjectCreate']);
    Route::post('/subject/trash', [SubjectController::class, 'subjectTrash']);
    Route::post('/subject/trashed-list', [SubjectController::class, 'subjectTrashedList']);
    Route::post('/subject/restore', [SubjectController::class, 'subjectRestore']);
    Route::post('/subject/delete', [SubjectController::class, 'subjectDelete']);
    Route::post('/subject/edit-by-id', [SubjectController::class, 'subjectEditById']);
    Route::post('/subject/update', [SubjectController::class, 'subjectUpdate']);
    Route::post('/subject/search', [SubjectController::class, 'subjectSearch']);
    Route::post('/subject/trashed-search', [SubjectController::class, 'subjectTrashedSearch']);

    Route::post('/subject/overview-data', [SubjectController::class, 'subjectOverviewData']);
    // Add these routes to your routes file
    Route::post('/subject/get-academic-sections', [SubjectController::class, 'getAcademicSections']);
    Route::post('/subject/get-classes-by-section', [SubjectController::class, 'getClassesBySection']);
    Route::post('/subject/get-subject-details', [SubjectController::class, 'getSubjectDetailsByClass']);
    //::::::::::::::: Subject Class routes End :::::::::::::::::::::::



    //::::::::::::::: Paper Class Route Start :::::::::::::::::::::
    Route::post('/paper/list', [PaperController::class, 'list']);
    Route::post('/paper/create', [PaperController::class, 'create']);
    Route::post('/paper/edit-by-id', [PaperController::class, 'editById']);
    Route::post('/paper/update', [PaperController::class, 'update']);
    Route::post('/paper/trash', [PaperController::class, 'trash']);
    Route::post('/paper/trashed-list', [PaperController::class, 'trashedList']);
    Route::post('/paper/restore', [PaperController::class, 'restore']);
    Route::post('/paper/delete', [PaperController::class, 'delete']);
    Route::post('/paper/search', [PaperController::class, 'search']);
    Route::post('/paper/trashed-search', [PaperController::class, 'trashedSearch']);
    Route::post('/paper/get-divisions-by-class', [PaperController::class, 'getDivisionsByClass']);
    Route::post('/paper/get-subjects-by-class-and-division', [PaperController::class, 'getSubjectsByClassAndDivision']);
    Route::post('/paper/check-code-exists', [PaperController::class, 'checkCodeExists']);

    //::::::::::::::: Editor Create By Admin :::::::::::::::::::::::
    Route::post('/editor/store', [EditorController::class, 'editorStore']);
    Route::post('/admin_db/editor/list', [EditorController::class, 'editorListAdminDashobard']);
    Route::post('/admin_db/editor/trash/list', [EditorController::class, 'editorTrashListAdminDashobard']);
    Route::post('/admin/editor/trash-by-id', [EditorController::class, 'editorTrashAdminDashobard']);
    Route::post('/admin/editor/restore-by-id', [EditorController::class, 'editorRestoreAdminDashboard']);
    Route::post('/admin/editor/delete-by-id', [EditorController::class, 'editorPermanentDeleteAdminDashboard']);
});




//editor Dashboard page Route
Route::get('/editor/login', [EditorController::class, 'editorLoginPage']);
Route::post('/editor/login/store', [EditorController::class, 'editor_login_store']);

//editor dashboard page
Route::get('/editor/dashboard', [EditorDashboardController::class, 'editorDashboardPage']);
Route::get('/editor/profile', [EditorDashboardController::class, 'editorProfilePage']);
Route::get('/editor/teacher/create', [EditorDashboardController::class, 'editorTeacherCreatePage']);


Route::middleware(['auth:sanctum', 'editor'])->group(function () {
    Route::post('/auth/editor/details', [EditorDashboardController::class, 'editorDetails']);
    Route::post('/editor/update-profile', [EditorDashboardController::class, 'editorUpdateProfile']);
    Route::post('/editor/password/update', [EditorDashboardController::class, 'editorUpdatePassword']);
    Route::post('/editor/logout', [EditorDashboardController::class, 'logout']);

    //edutation Route
    Route::post('/editor/education/list', [EditorEducationController::class, 'editorEducationList']);
    Route::post('/editor/education/by-id', [EditorEducationController::class, 'editorEducationById']);
    Route::post('/editor/education/update', [EditorEducationController::class, 'editorEducationUpdate']);

    Route::post('/editor/education', [EditorEducationController::class, 'editorEducationCreate']);
    Route::post('/editor/education/delete', [EditorEducationController::class, 'editorEducationDelete']);

    //Address Route
    Route::post('/editor/address', [EditorAddressController::class, 'editorAddressCreate']);
    Route::post('/editor/address/list', [EditorAddressController::class, 'editorAddressLists']);
    Route::post('/editor/address/by-id', [EditorAddressController::class,'getAddressById']); //adress details by id
    Route::post('/editor/address/update', [EditorAddressController::class,'updateAddress']);
    Route::post('/editor/address/delete', [EditorAddressController::class,'deleteAddress']);


});




//admin and editor same route
Route::middleware(['auth:sanctum', 'editor_or_admin'])->group(function () {

    //editor cv
    Route::post('/editor/details-by-id', [EditorController::class, 'editorDetailsById']);
    Route::post('/editor/update-by-id', [EditorController::class, 'editorUpdateById']);
    Route::post('/editor/cv-details', [EditorController::class, 'editorCVDetails']);




    //Route::post('/auth/admin/details', [AdminDashboard::class, 'adminDetails']);
    Route::post('/institution/details/for/admin/editor', [InstitutionController::class, 'institutionDetailsAdminEditor']);
    Route::post('/all/teacher/lists', [TeacherController::class, 'allTeacherLists']);
    Route::post('/teacher/store', [TeacherController::class, 'teacherStore']);
    Route::post('/admin-teacher/details-by-id', [TeacherController::class, 'teacherDetailsById']);
    Route::post('/update-teacher-by-admin', [TeacherController::class, 'teacherUpdateByAdmin']);
    Route::post('/admin/teacher/trash-by-id', [TeacherController::class, 'teacherTrashByAdmin']);
    Route::post('/all/teacher/trash/lists', [TeacherController::class, 'allteacherTrashListsByAdmin']);
    Route::post('/admin/teacher/delete-by-id', [TeacherController::class, 'teacherDeleteByAdmin']);
    Route::post('/admin/teacher/restore-by-id', [TeacherController::class, 'teacherRestoreByAdmin']);
    

//     Route::post('/teacher/trashed-list', [TeacherController::class, 'teacherTrashedList']);
//     Route::post('/teacher/restore', [TeacherController::class, 'teacherRestore']);
//     Route::post('/teacher/delete', [TeacherController::class, 'teacherDelete']);
//     Route::post('/teacher/search', [TeacherController::class, 'teacherSearch']);
//     Route::post('/teacher/trashed-search', [TeacherController::class, 'teacherTrashedSearch']);
});




//only teacher routes 
//editor Dashboard page Route
Route::get('/teacher/login', [TeacherController::class, 'teacherLoginPage']);
Route::post('/teacher/login/store', [TeacherController::class, 'teacher_login_store']);
Route::get('/teacher/dashboard', [TeacherController::class, 'teacherDashboardPage']);
Route::get('/teacher/profile', [TeacherDashboardController::class, 'teacherProfilePage']);

Route::middleware(['auth:sanctum', 'teacher'])->group(function () {
    Route::post('/teacher/institution/details', [TeacherDashboardController::class, 'institutionDetailsByTeacher']);
    Route::post('/auth/teacher/details', [TeacherController::class, 'authTeacherDetails']);
    Route::post('/auth/teacher/logout', [TeacherController::class, 'teacherLogout']);
    Route::post('/teacher/update-profile', [TeacherDashboardController::class, 'teacherUpdateProfile']);

    //education
    Route::post('/teacher/education', [TeacherEducationController::class, 'teacherEducationCreate']);
    Route::post('/teacher/education/lists', [TeacherEducationController::class, 'teacherEducationList']);

});                      