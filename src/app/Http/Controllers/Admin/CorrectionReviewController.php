<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceCorrection;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CorrectionReviewController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->string('status')->toString() ?: 'pending';
        $status    = $activeTab === 'approved' ? 'approved' : 'pending';

        $paginator = AttendanceCorrection::query()
            ->with(['attendance', 'attendance.user:id,name'])
            ->where('status', $status)
            ->latest('id')
            ->paginate(10);

        $requests = $paginator->through(function ($c) {
            $att = $c->attendance;

            $rawDate = $att->work_date
                ?? $att->date
                ?? ($att->work_start ? Carbon::parse($att->work_start)->toDateString() : null)
                ?? $c->created_at;

            return [
                'id'           => $c->id,
                'status'       => $c->status,
                'status_label' => $c->status === 'approved' ? '承認済'
                                : ($c->status === 'rejected' ? '却下' : '承認待ち'),
                'user_name'    => optional(optional($att)->user)->name ?? '—',
                'target_date'  => $rawDate ? Carbon::parse($rawDate)->format('Y/m/d') : '—',
                'reason'       => $c->reason ?? $c->note ?? '—',
                'applied_at'   => optional($c->created_at)->format('Y/m/d') ?: '—',
            ];
        });

        return view('admin.requests.index', [
            'activeTab' => $activeTab,
            'requests'  => $requests,
        ]);
    }

    public function show(AttendanceCorrection $correction)
    {
        $correction->load(['attendance', 'attendance.user:id,name']);

        $att = $correction->attendance;

        $dateSrc = $att->work_date
            ?? $att->date
            ?? ($att->work_start ?: $correction->created_at);

        $fmtTime = function ($v) {
            return $v ? \Carbon\Carbon::parse($v)->format('H:i') : '—';
        };

        $b1sRaw = $att->break_start  ?? $att->break1_start ?? $att->rest_start ?? null;
        $b1eRaw = $att->break_end    ?? $att->break1_end   ?? $att->rest_end   ?? null;
        $b2sRaw = $att->break2_start ?? null;
        $b2eRaw = $att->break2_end   ?? null;

        $date      = $dateSrc ? \Carbon\Carbon::parse($dateSrc) : null;
        $viewModel = [
            'name'         => optional(optional($att)->user)->name ?? '—',
            'year'         => $date ? $date->format('Y年')   : '—',
            'month_day'    => $date ? $date->format('n月j日') : '',
            'work_start'   => $fmtTime($att->work_start ?? null),
            'work_end'     => $fmtTime($att->work_end   ?? null),
            'break1_start' => $fmtTime($b1sRaw),
            'break1_end'   => $fmtTime($b1eRaw),
            'break2_start' => $fmtTime($b2sRaw),
            'break2_end'   => $fmtTime($b2eRaw),
            'note'         => $correction->reason ?? $correction->note ?? '—',
        ];

        return view('admin.requests.show', [
            'correction' => $correction,
            'vm'         => $viewModel,
        ]);
    }
}
