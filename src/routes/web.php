<?php

use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\CorrectionApprovalController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceListController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CorrectionRequestController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/admin/login', [LoginController::class, 'create'])->name('admin.login');
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/mailhog', function () {
        return redirect()->away(config('services.mailhog.url'));
    })->name('verification.mailhog');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('attendance.index');
    })->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', '認証メールを再送しました。');
    })->middleware('throttle:6,1')->name('verification.send');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clock-in');
    Route::post('/attendance/break-start', [AttendanceController::class, 'breakStart'])->name('attendance.break-start');
    Route::post('/attendance/break-end', [AttendanceController::class, 'breakEnd'])->name('attendance.break-end');
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clock-out');

    Route::get('/attendance/list', [AttendanceListController::class, 'index'])->name('attendance.list');
    Route::get('/attendance/detail/{attendance}', [AttendanceListController::class, 'show'])->name('attendance.detail');
    Route::post('/attendance/detail/{attendance}', [AttendanceListController::class, 'update'])->name('attendance.update');

    Route::get('/stamp_correction_request/list', [CorrectionRequestController::class, 'index'])->name('request.list');
    Route::get('/stamp_correction_request/approve/{attendance_correct_request}', [CorrectionRequestController::class, 'show'])->name('request.detail');

    Route::middleware('admin')->group(function () {
        Route::get('/admin/attendance/list', [AdminAttendanceController::class, 'daily'])->name('admin.attendance.list');
        Route::get('/admin/attendance/{attendance}', [AdminAttendanceController::class, 'detail'])->name('admin.attendance.detail');
        Route::post('/admin/attendance/{attendance}', [AdminAttendanceController::class, 'update'])->name('admin.attendance.update');
        Route::get('/admin/staff/list', [AdminAttendanceController::class, 'staffList'])->name('admin.staff.list');
        Route::get('/admin/attendance/staff/{user}', [AdminAttendanceController::class, 'staffMonthly'])->name('admin.staff.attendance');

        Route::post('/stamp_correction_request/approve/{attendance_correct_request}', [CorrectionApprovalController::class, 'approve'])->name('request.approve');
    });
});
