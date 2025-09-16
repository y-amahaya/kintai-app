<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    /**
     * なぜ: 管理者の全体一覧。検索/絞り込みは将来FormRequest/Queryに移譲。
     */
    public function index()
    {
        return view('admin.attendance.index');
    }

    /**
     * なぜ: 管理者の個別勤怠詳細。将来はユーザー情報等をeager load予定。
     */
    public function show(int $id)
    {
        return view('admin.attendance.show', compact('id'));
    }
}
