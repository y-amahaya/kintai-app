<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('s', 'before');

        if (! in_array($status, ['before', 'after', 'break', 'leave'], true)) {
            $status = 'before';
        }

        return view('attendance.create', compact('status'));
    }

    public function listing(Request $request)
    {
        $monthParam   = $request->query('month', now()->format('Y-m'));
        $startOfMonth = Carbon::createFromFormat('Y-m', $monthParam)->startOfMonth();
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

        $userId = Auth::id();

        $query = Attendance::query()->where('user_id', $userId);

        $hasWorkDate = \Schema::hasColumn((new Attendance)->getTable(), 'work_date');
        if ($hasWorkDate) {
            $query->whereBetween('work_date', [$startOfMonth, $endOfMonth])
                ->orderBy('work_date');
        } else {
            $query->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->orderBy('created_at');
        }
        $attendances = $query->get();

        $byDate = $attendances->keyBy(function ($a) {
            return Carbon::parse($a->work_date ?? $a->created_at)->toDateString();
        });

        $toHm = function ($min) {
            if (!is_numeric($min)) return '';
            $h = intdiv($min, 60); $m = $min % 60;
            return sprintf('%d:%02d', $h, $m);
        };

        $rows = [];
        $cur = $startOfMonth->copy();
        while ($cur->lte($endOfMonth)) {
            $key = $cur->toDateString();
            $row = $byDate->get($key);

            $rows[] = [
                'date_label' => $cur->locale('ja')->isoFormat('MM/DD(ddd)'),
                'start'      => $row ? (optional($row->started_at)->format('H:i') ?? '') : '',
                'end'        => $row ? (optional($row->ended_at)->format('H:i') ?? '')   : '',
                'break'      => $row ? $toHm($row->break_minutes ?? null) : '',
                'total'      => $row ? $toHm($row->total_minutes ?? null) : '',
                'detail_url' => $row
                    ? route('attendance.detail.show', ['id' => $row->id])
                    : route('attendance.detail.show', ['date' => $key]),
            ];

            $cur->addDay();
        }

        $monthLabel = $startOfMonth->isoFormat('YYYY/MM');
        $prevMonth  = $startOfMonth->copy()->subMonth()->format('Y-m');
        $nextMonth  = $startOfMonth->copy()->addMonth()->format('Y-m');

        return view('attendance.list.index', [
            'rows'       => $rows,
            'monthLabel' => $monthLabel,
            'prevMonth'  => $prevMonth,
            'nextMonth'  => $nextMonth,
        ]);
    }

    public function show(Request $request, int $id = null)
    {
        $userId = Auth::id();

        if (!is_null($id)) {
            $attendance = Attendance::where('id', $id)
                ->where('user_id', $userId)
                ->firstOrFail();

            $workDate = Carbon::parse($attendance->work_date ?? $attendance->created_at)->toDateString();

            return view('attendance.detail.show', compact('attendance', 'workDate'));
        }

        $dateParam = $request->query('date');
        if (empty($dateParam)) {
            abort(404);
        }

        $workDate = Carbon::parse($dateParam)->toDateString();

        $hasWorkDate = \Schema::hasColumn((new Attendance)->getTable(), 'work_date');

        $attendance = Attendance::query()
            ->where('user_id', $userId)
            ->when($hasWorkDate, function ($q) use ($workDate) {
                $q->whereDate('work_date', $workDate);
            }, function ($q) use ($workDate) {
                $q->whereDate('created_at', $workDate);
            })
            ->first();

        return view('attendance.detail.show', compact('attendance', 'workDate'));
    }
}
