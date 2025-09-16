<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class StaffAttendanceController extends Controller
{
    /**
     * なぜ: 特定ユーザーの勤怠一覧。画面設計の「スタッフ勤怠一覧」に対応。
     * ルートは現在 `/admin/attendance/staff/{id}` で show を使っているため、署名は show に合わせる。
     */
    public function show(int $id)
    {
        // $id はユーザーIDを想定
        return view('admin.staff.attendance.show', compact('id'));
    }

    // 将来、URIを `/admin/users/{user}/attendances` に変更するなら index に改名すると読みやすい。
}
