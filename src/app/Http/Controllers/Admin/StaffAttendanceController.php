<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class StaffAttendanceController extends Controller
{
    public function show(int $id, Request $request)
    {
        $user = User::findOrFail($id);

        $month = (string) $request->query('month', Carbon::now('Asia/Tokyo')->format('Y-m'));
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = Carbon::now('Asia/Tokyo')->format('Y-m');
        }
        $start = Carbon::createFromFormat('Y-m', $month, 'Asia/Tokyo')->startOfMonth();
        $end   = (clone $start)->endOfMonth();

        $dateCol  = $this->pickCol('attendances', ['date', 'work_date', 'attended_on', 'worked_on']);
        $inCol    = $this->pickCol('attendances', ['clock_in', 'clock_in_at', 'start_at', 'started_at']);
        $outCol   = $this->pickCol('attendances', ['clock_out', 'clock_out_at', 'end_at', 'ended_at']);
        $breakCol = $this->pickCol('attendances', ['break_minutes', 'break_total_minutes', 'rest_minutes']);

        $baseCol = $dateCol ?: ($inCol ?: ($outCol ?: 'created_at'));

        $list = Attendance::query()
            ->where('user_id', $user->id)
            ->when($baseCol, function ($q) use ($baseCol, $start, $end) {
                $q->whereBetween($baseCol, [
                    $start->copy()->startOfDay()->toDateTimeString(),
                    $end->copy()->endOfDay()->toDateTimeString(),
                ])->orderBy($baseCol, 'asc');
            }, fn ($q) => $q->orderBy('id', 'asc'))
            ->get();

        $rows = $list->map(function (Attendance $a) use ($dateCol, $inCol, $outCol, $breakCol) {
            $dateValue = $dateCol
                ? $a->getAttribute($dateCol)
                : ($inCol ? $a->getAttribute($inCol)
                        : ($outCol ? $a->getAttribute($outCol)
                                    : $a->created_at));
            $dateLabel = $dateValue
                ? Carbon::parse($dateValue)->locale('ja')->isoFormat('MM/DD(ddd)')
                : '—';

            $inLabel   = $this->fmtTime($inCol  ? $a->getAttribute($inCol)  : null);
            $outLabel  = $this->fmtTime($outCol ? $a->getAttribute($outCol) : null);

            $breakMin   = $breakCol ? $a->getAttribute($breakCol) : null;
            $breakLabel = $this->fmtMinutes($breakMin);

            $totalLabel = '—';
            $in  = $inCol  ? $a->getAttribute($inCol)  : null;
            $out = $outCol ? $a->getAttribute($outCol) : null;
            if ($in && $out) {
                $totalMin = Carbon::parse($out)->diffInMinutes(Carbon::parse($in), false)
                        - (int)($breakMin ?? 0);
                if ($totalMin >= 0) {
                    $totalLabel = $this->fmtMinutes($totalMin);
                }
            }

            return [
                'id'          => $a->id,
                'date_label'  => $dateLabel,
                'in_label'    => $inLabel,
                'out_label'   => $outLabel,
                'break_label' => $breakLabel,
                'total_label' => $totalLabel,
            ];
        })->all();

        $prevMonth  = $start->copy()->subMonth()->format('Y-m');
        $nextMonth  = $start->copy()->addMonth()->format('Y-m');
        $monthLabel = $start->format('Y/m');

        return view('admin.users.attendance', compact(
            'user', 'rows', 'prevMonth', 'nextMonth', 'monthLabel'
        ));
    }

    private function pickCol(string $table, array $candidates): ?string
    {
        foreach ($candidates as $col) {
            if (Schema::hasColumn($table, $col)) {
                return $col;
            }
        }
        return null;
    }

    private function fmtTime(?string $ts): string
    {
        return $ts ? Carbon::parse($ts)->format('H:i') : '—';
    }

    private function fmtMinutes($minutes): string
    {
        if ($minutes === null) return '—';
        $m = (int) $minutes;
        return sprintf('%d:%02d', intdiv($m, 60), $m % 60);
    }
}
