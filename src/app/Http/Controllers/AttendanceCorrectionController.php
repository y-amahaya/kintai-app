<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceCorrection;
use Illuminate\Support\Facades\Auth;

class AttendanceCorrectionController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('status', 'pending');

        $query = AttendanceCorrection::query()
            // ▼ 申請者リレーションに修正（テーブル仕様：applicant_id）
            ->with('applicant:id,name')
            // ▼ 自分の申請だけに限定
            ->where('applicant_id', Auth::id());

        switch ($activeTab) {
            case 'approved':
                $query->where('status', 'approved');
                break;
            case 'rejected':
                $query->where('status', 'rejected');
                break;
            default:
                $query->where('status', 'pending');
        }

        $requests = $query->orderByDesc('created_at')->paginate(10);

        return view('stamp_correction_request.list.index', [
            'requests'  => $requests,
            'activeTab' => $activeTab,
        ]);
    }

    public function show(AttendanceCorrection $correction)
    {
        // ▼ 所有者チェックも applicant_id に合わせる
        abort_unless($correction->applicant_id === Auth::id(), 404);

        return view('stamp_correction_request.detail.show', [
            'correction' => $correction,
        ]);
    }
}
