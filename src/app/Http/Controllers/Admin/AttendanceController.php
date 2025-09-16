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

        $attendances = Attendance::with('user:id,name')
            ->whereDate('clock_in_at', $day)
            ->orderBy('id')
            ->paginate(10);

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

    public function show(int $id)
    {
        $att = \App\Models\Attendance::with('user:id,name')->findOrFail($id);

        $fmtTime = static function ($v) {
            return empty($v) ? '' : \Carbon\Carbon::parse($v)->format('H:i');
        };

        $baseDate = $att->clock_in_at ?: $att->clock_out_at ?: now();
        $yearLabel     = \Carbon\Carbon::parse($baseDate)->isoFormat('YYYY年');
        $monthDayLabel = \Carbon\Carbon::parse($baseDate)->locale('ja')->isoFormat('M月D日');

        return view('admin.attendance.show', [
            'attendance' => $att,
            'name'       => optional($att->user)->name ?? '',
            'yearLabel'  => $yearLabel,
            'monthDay'   => $monthDayLabel,
            'inTime'     => $fmtTime($att->clock_in_at ?? null),
            'outTime'    => $fmtTime($att->clock_out_at ?? null),

            'break1Start'=> $fmtTime(data_get($att, 'break_started_at')),
            'break1End'  => $fmtTime(data_get($att, 'break_ended_at')),
            'break2Start'=> $fmtTime(data_get($att, 'break2_started_at')),
            'break2End'  => $fmtTime(data_get($att, 'break2_ended_at')),

            'note'       => $att->note ?? '',
        ]);
    }
}
