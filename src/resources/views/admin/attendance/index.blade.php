@extends('layouts.admin')

@section('content')
<div class="att-list">
    <h1 class="page-title">{{ $dateLabelJp }} の勤怠</h1>

    <div class="att-monthbar">
        <a class="att-monthbar__nav" href="{{ url()->current() }}?date={{ $prevDay }}">‹ 前日</a>
        <div class="att-monthbar__label">
            <span class="att-monthbar__icon">📅</span>
            <span>{{ $dateLabelEn }}</span>
        </div>
        <a class="att-monthbar__nav" href="{{ url()->current() }}?date={{ $nextDay }}">翌日 ›</a>
    </div>

    @if($attendances->count())
        <div class="att-table-wrap">
            <table class="att-table">
                <thead>
                    <tr>
                        <th class="txt-center">名前</th>
                        <th class="col-time">出勤</th>
                        <th class="col-time">退勤</th>
                        <th class="col-time">休憩</th>
                        <th class="col-time">合計</th>
                        <th class="col-action">詳細</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $i => $att)
                        <tr>
                            <td class="txt-center">{{ $att['name'] }}</td>
                            <td class="txt-center">{{ $att['clock_in'] }}</td>
                            <td class="txt-center">{{ $att['clock_out'] }}</td>
                            <td class="txt-center">{{ $att['break'] }}</td>
                            <td class="txt-center">{{ $att['total'] }}</td>
                            <td>
                                <a class="link" href="{{ route('admin.attendance.show', ['id' => $att['id']]) }}">詳細</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @else
        <p class="att-list__empty">この日の勤怠はありません。</p>
    @endif
</div>
@endsection
