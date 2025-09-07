<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceCorrectionController;
use App\Http\Controllers\Admin\CorrectionReviewController;

// 一般ユーザー（認証必須）
Route::middleware('auth')->group(function () {
    Route::view('/attendance', 'attendance.create')->name('attendance.create');
    Route::view('/attendance/list', 'attendance.list.index')->name('attendance.list.index');
    Route::view('/attendance/detail/{id}', 'attendance.detail.show')
        ->whereNumber('id')->name('attendance.detail.show');
});

// 管理者（認証 + 権限）
Route::prefix('admin')->middleware(['auth','role:90'])->group(function () {
    Route::view('/login', 'admin.auth.login')->name('admin.auth.login');

    Route::view('/attendance', 'admin.attendance.index')->name('admin.attendance.index');
    Route::view('/attendance/{id}', 'admin.attendance.show')->whereNumber('id')->name('admin.attendance.show');

    Route::view('/staff/list', 'admin.staff.index')->name('admin.staff.index');
    Route::view('/attendance/staff/{id}', 'admin.staff.attendance.show')
        ->whereNumber('id')->name('admin.staff.attendance.show');
});

// 修正申請（管理）— 一覧はビュー、承認はPOSTアクション
Route::middleware(['auth','role:90'])->group(function () {
    Route::view('/stamp_correction_request/list', 'stamp_correction_request.list.index')
        ->name('stamp_correction_request.list.index');

    // 承認処理は副作用があるためPOSTでControllerへ
    Route::post('/stamp_correction_request/approve/{attendance_correct_request}',
        [CorrectionReviewController::class, 'approve'])
        ->whereNumber('attendance_correct_request')
        ->name('stamp_correction_request.approve');
});
