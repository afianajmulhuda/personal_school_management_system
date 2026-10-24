<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\AttendanceProcessingEngine;
use App\Http\Controllers\Auth\PortalAuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamMarksController;
use App\Http\Controllers\ExamTermController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentEnrollmentController;
use App\Http\Controllers\SubjectController;

// Guest Authentication Stack Engine Routing Controls
Route::middleware('guest')->group(function () {
    // Login Controller Hooks
    Route::get('/login', [PortalAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [PortalAuthController::class, 'login']);

    // Registration Profile Provisioning Hooks
    Route::get('/register', [PortalAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [PortalAuthController::class, 'register']);
});

// Terminate Session Active Node Hook
Route::post('/logout', [PortalAuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/regenerate-roll', [ReportController::class, 'regenerateRoll'])->name('reports.regenerate-roll');
    Route::get('/marksheet/class', [ReportController::class, 'classMarksheet'])->name('reports.marksheet-class');
});
Route::prefix('billing')->group(function () {
   Route::get('exam-fees', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('exam-fees/generate', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('exam-fees/generate', [AccountController::class, 'store'])->name('accounts.store');
    Route::get('exam-fees/{invoice}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::put('exam-fees/{invoice}', [AccountController::class, 'update'])->name('accounts.update');
    Route::post('exam-fees/pay/{invoice}', [AccountController::class, 'recordPayment'])->name('accounts.pay');
});

Route::prefix('academics')->group(function () {
    // Other existing academic tracks...
    
    // Bind Resource Action Pipeline for Subjects Architecture
    Route::resource('subjects', SubjectController::class);
    Route::resource('guardians', GuardianController::class);
    Route::resource('enrollments', StudentEnrollmentController::class);
    Route::resource('marks', MarkController::class);
    Route::resource('exams', ExamController::class);
    Route::resource('exam-terms', ExamTermController::class);
});
Route::prefix('infrastructure')->group(function () {
    // Replaces the placeholder reference setup previously established for year mapping control
    Route::get('system/rollover', [AcademicYearController::class, 'index'])->name('system.rolloverView');
    Route::resource('academic_years', AcademicYearController::class)->except(['index']);
    Route::resource('sections', SectionController::class);
    // 1. Campus Endpoint Resources
    Route::resource('campuses', CampusController::class);
    Route::resource('classes', SchoolClassController::class);
});
Route::prefix('academics')->group(function () {
Route::get('students/registry', [StudentController::class, 'index'])->name('students.index');
    Route::get('students/register', [StudentController::class, 'create'])->name('students.register');
    Route::post('students/register', [StudentController::class, 'store'])->name('students.store');
    Route::get('students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
});


// 3. Attendance Processing Matrix Sheet Matrix
Route::get('attendance/sheet', [AttendanceProcessingEngine::class, 'loadAttendanceSheet'])->name('attendance.sheet');
Route::post('attendance/batch', [AttendanceProcessingEngine::class, 'batchStoreAttendance'])->name('attendance.batchStore');

// 4. Performance Marks Recording Vault
Route::get('exams/{exam}/capture', [ExamMarksController::class, 'captureMarksGrid'])->name('exams.captureMarks');
Route::post('exams/{exam}/capture', [ExamMarksController::class, 'pushMarksRegistry'])->name('exams.pushMarks');

Route::get('/', function () {
    return view('dashboard');
});
