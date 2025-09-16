@extends('layouts.app')

@section('content')
<div class="att-list">
    <h1 class="page-title">勤怠一覧</h1>

    <div class="att-monthbar">
        <a class="att-monthbar__nav" href="{{ url()->current() }}?month={{ $prevMonth }}">‹ 前月</a>
        <div class="att-monthbar__label">
            <span class="att-monthbar__icon">📅</span>
            <span>{{ $monthLabel }}</span>
        </div>
        <a class="att-monthbar__nav" href="{{ url()->current() }}?month={{ $nextMonth }}">翌月 ›</a>
    </div>

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
                @foreach ($rows as $r)
                    <tr>
                        <td>{{ $r['date_label'] }}</td>
                        <td class="txt-center">{{ $r['start'] }}</td>
                        <td class="txt-center">{{ $r['end'] }}</td>
                        <td class="txt-center">{{ $r['break'] }}</td>
                        <td class="txt-center">{{ $r['total'] }}</td>
                        <td><a class="link" href="{{ $r['detail_url'] }}">詳細</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
