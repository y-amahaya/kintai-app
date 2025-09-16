<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $day  = Carbon::parse($date);

        $prevDay = $day->copy()->subDay()->toDateString();
        $nextDay = $day->copy()->addDay()->toDateString();

        // ★ 出勤日時で当日分を絞る（専用日付列が無い前提）
        $attendances = Attendance::with('user:id,name')
            ->whereDate('clock_in_at', $day)   // ← ここを clock_in_at に変更
            ->orderBy('id')
            ->paginate(10);

        // 表示変換（そのまま）
        $attendances->setCollection(
            $attendances->getCollection()->map(function ($att) {
                $fmtTime = function ($v) {
                    if (empty($v)) return '—';
                    try { return Carbon::parse($v)->format('H:i'); } catch (\Throwable $e) { return '—'; }
                };
                $fmtMin = function ($m) {
                    $m = (int) $m; if ($m <= 0) return '0:00';
                    $h = intdiv($m, 60); $r = $m % 60; return sprintf('%d:%02d', $h, $r);
                };
                return [
                    'id'        => $att->id,
                    'name'      => $att->user->name ?? '—',
                    'clock_in'  => $fmtTime($att->clock_in_at ?? null),
                    'clock_out' => $fmtTime($att->clock_out_at ?? null),
                    'break'     => $fmtMin($att->break_minutes ?? 0),
                    'total'     => isset($att->total_work_minutes) ? $fmtMin($att->total_work_minutes) : '—',
                ];
            })
        );

        return view('admin.attendance.index', [
            'dateLabelJp' => $day->isoFormat('YYYY年M月D日'),
            'dateLabelEn' => $day->format('Y/m/d'),
            'prevDay'     => $prevDay,
            'nextDay'     => $nextDay,
            'attendances' => $attendances,
        ]);
    }
}
