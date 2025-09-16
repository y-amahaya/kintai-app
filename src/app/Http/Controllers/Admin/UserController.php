<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * なぜ: スタッフ一覧の表示に専念。部署/在籍状態のフィルタは後で追加。
     */
    public function index()
    {
        return view('admin.staff.index');
    }

    /**
     * なぜ: スタッフ詳細。編集や権限変更は別アクションに分離して意図を明確化。
     */
    public function show(int $id)
    {
        return view('admin.staff.show', compact('id'));
    }
}
