@extends('layouts.app')

@section('content')
@php
    $statusLabel = match ($status) {
        'before' => '勤務外',
        'after'  => '出勤中',
        'break'  => '休憩中',
        'leave'  => '退勤済',
        default  => '',
    };
@endphp

<div class="attendance-page">
  <div class="att-main">
    @if ($statusLabel !== '')
      <div class="att-status">{{ $statusLabel }}</div>
    @endif

    <div class="att-date">{{ now()->isoFormat('YYYY年M月D日(ddd)') }}</div>

    <div class="att-clock">
      <div class="att-clock-time">{{ now()->format('H:i') }}</div>
    </div>

    @if ($status === 'before')
      <div class="att-actions">
        <a class="btn btn-primary" href="{{ route('attendance.create', ['s' => 'after']) }}">出勤</a>
      </div>

    @elseif ($status === 'after')
      <div class="att-actions att-actions-row">
        <a class="btn btn-primary" href="{{ route('attendance.create', ['s' => 'leave']) }}">退勤</a>
        <a class="btn btn-ghost"   href="{{ route('attendance.create', ['s' => 'break']) }}">休憩入</a>
      </div>

    @elseif ($status === 'break')
      <div class="att-actions">
        <a class="btn btn-primary" href="{{ route('attendance.create', ['s' => 'after']) }}">休憩戻</a>
      </div>

    @elseif ($status === 'leave')
      <div class="att-finished">お疲れ様でした。</div>
    @endif
  </div>
</div>
@endsection
