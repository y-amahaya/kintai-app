@extends('layouts.admin')

@section('content')
<div class="att-list">
    <h1 class="page-title">{{ $user->name }}さんの勤怠</h1>

    <div class="att-monthbar">
        <a class="att-monthbar__nav" href="{{ url()->current() }}?month={{ $prevMonth }}">‹ 前月</a>
        <div class="att-monthbar__label">
            <span class="att-monthbar__icon">📅</span>
            <span>{{ $monthLabel }}</span>
        </div>
        <a class="att-monthbar__nav" href="{{ url()->current() }}?month={{ $nextMonth }}">翌月 ›</a>
    </div>

    @if(count($rows))
        <div class="att-table-wrap">
            <table class="att-table">
                <thead>
                    <tr>
                        <th class="col-date">日付</th>
                        <th class="col-time">出勤</th>
                        <th class="col-time">退勤</th>
                        <th class="col-time">休憩</th>
                        <th class="col-time">合計</th>
                        <th class="col-action">詳細</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($rows as $r)
                    <tr>
                        <td class="txt-center">{{ $r['date_label'] }}</td>
                        <td class="txt-center">{{ $r['in_label'] }}</td>
                        <td class="txt-center">{{ $r['out_label'] }}</td>
                        <td class="txt-center">{{ $r['break_label'] }}</td>
                        <td class="txt-center">{{ $r['total_label'] }}</td>
                        <td class="txt-center">
                            <a class="link" href="{{ route('admin.attendance.show', ['id' => $r['id']]) }}">詳細</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-right" style="margin-top: 12px; text-align: right;">
            <a href="#" class="btn btn--outline">CSV出力</a>
        </div>
    @else
        <p class="att-list__empty">勤怠データがありません。</p>
    @endif
</div>
@endsection
