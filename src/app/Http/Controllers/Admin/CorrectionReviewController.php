<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CorrectionReviewController extends Controller
{
    /**
     * なぜ: 承認待ち一覧。状態タブ（pending/approved/rejected）は将来拡張。
     */
    public function index()
    {
        return view('stamp_correction_request.list.index');
    }

    /**
     * なぜ: 状態遷移（承認）は副作用を伴うためPOST専用。監査ログは後でServiceに。
     */
    public function approve(int $attendance_correct_request)
    {
        //
    }
}
