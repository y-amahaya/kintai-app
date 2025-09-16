@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endpush

@section('content')
<div class="att-detail">
    <h1 class="page-title">勤怠詳細</h1>

    <div class="att-card">
        <table class="att-detail-table">
            <tr>
                <th>名前</th>
                <td colspan="2" class="txt-center">{{ $vm['name'] }}</td>
            </tr>
            <tr>
                <th>日付</th>
                <td colspan="2">
                    <div class="att-tilde" style="justify-content:center;">
                        <span>{{ $vm['year'] }}</span>
                        <span>{{ $vm['month_day'] }}</span>
                    </div>
                </td>
            </tr>
            <tr>
                <th>出勤・退勤</th>
                <td colspan="2">
                    <div class="att-tilde">
                        <span class="att-read att-read--sm">{{ $vm['work_start'] }}</span>
                        <span>〜</span>
                        <span class="att-read att-read--sm">{{ $vm['work_end'] }}</span>
                    </div>
                </td>
            </tr>
            <tr>
                <th>休憩</th>
                <td colspan="2">
                    <div class="att-tilde">
                        <span class="att-read att-read--sm">{{ $vm['break1_start'] }}</span>
                        <span>〜</span>
                        <span class="att-read att-read--sm">{{ $vm['break1_end'] }}</span>
                    </div>
                </td>
            </tr>
            <tr>
                <th>休憩2</th>
                <td colspan="2">
                    <div class="att-tilde">
                        <span class="att-read att-read--sm">{{ $vm['break2_start'] }}</span>
                        <span>〜</span>
                        <span class="att-read att-read--sm">{{ $vm['break2_end'] }}</span>
                    </div>
                </td>
            </tr>
            <tr>
                <th>備考</th>
                <td colspan="2" class="txt-center">{{ $vm['note'] }}</td>
            </tr>
        </table>

        <div class="att-detail__actions">
            <button type="submit" class="btn btn-primary">承認</button>
        </div>
    </div>
</div>
@endsection
