<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceCorrectionController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\StaffAttendanceController as AdminStaffAttendanceController;
use App\Http\Controllers\Admin\CorrectionReviewController as AdminCorrectionReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// 管理者ログイン
Route::middleware('web')->group(function () {
    Route::view('/admin/login', 'admin.auth.login')->name('admin.login');

    Route::post('/admin/logout', function (\Illuminate\Http\Request $request) {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('admin.login');
    })->name('admin.logout');
});

// 一般ユーザー
Route::middleware('auth')->group(function () {
    // 勤怠登録
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.create');

    // 勤怠一覧
    Route::get('/attendance/list', [AttendanceController::class, 'listing'])->name('attendance.list.index');

    // 勤怠詳細
    Route::get('/attendance/detail/{id?}', [AttendanceController::class, 'show'])
        ->whereNumber('id')
        ->name('attendance.detail.show');

    // 申請一覧
    Route::get('/stamp_correction_request/list', [AttendanceCorrectionController::class, 'index'])
        ->name('corrections.index');
    // 申請詳細
    Route::get('/stamp_correction_request/{correction}', [AttendanceCorrectionController::class, 'show'])
        ->name('corrections.show');
});

// 管理者
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/attendance', [AdminAttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::get('/attendance/{id}', [AdminAttendanceController::class, 'show'])
        ->whereNumber('id')->name('admin.attendance.show');

    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{id}', [AdminUserController::class, 'show'])
        ->whereNumber('id')->name('admin.users.show');

    Route::get('/attendance/staff/{id}', [AdminStaffAttendanceController::class, 'show'])
        ->whereNumber('id')->name('admin.staff.attendance.show');

    // 申請一覧
    Route::get('/requests', [AdminCorrectionReviewController::class, 'index'])->name('admin.requests.index');

    // 申請詳細
    Route::get('/requests/{correction}', [AdminCorrectionReviewController::class, 'show'])
        ->whereNumber('correction')
        ->name('admin.requests.show');

    // 申請承認
    Route::post('/requests/{attendance_correct_request}', [AdminCorrectionReviewController::class, 'approve'])
        ->whereNumber('attendance_correct_request')
        ->name('admin.corrections.approve');
});

// ログアウト
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');
