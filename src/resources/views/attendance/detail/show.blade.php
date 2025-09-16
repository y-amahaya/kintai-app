@extends('layouts.app')

@section('content')
<div class="att-detail">
  <h1 class="page-title">勤怠詳細</h1>

  <div class="att-card">
    <table class="att-detail-table">
      <tbody>
        <tr>
          <th>名前</th>
          <td>{{ optional(Auth::user())->name ?? '' }}</td>
        </tr>

        <tr>
          <th>日付</th>
          <td>
            <div class="att-split">
              <span class="att-read att-read--md">
                {{ \Carbon\Carbon::parse($workDate)->isoFormat('YYYY年') }}
              </span>
              <span class="att-read att-read--md">
                {{ \Carbon\Carbon::parse($workDate)->locale('ja')->isoFormat('M月D日') }}
              </span>
            </div>
          </td>
        </tr>

        <tr>
          <th>出勤・退勤</th>
          <td>
            <div class="att-split">
              <span class="att-read att-read--sm">
                {{ optional(optional($attendance)->started_at)->format('H:i') ?? '' }}
              </span>
              <span class="att-tilde">〜</span>
              <span class="att-read att-read--sm">
                {{ optional(optional($attendance)->ended_at)->format('H:i') ?? '' }}
              </span>
            </div>
          </td>
        </tr>

        <tr>
          <th>休憩</th>
          <td>
            <div class="att-split">
              <span class="att-read att-read--sm">
                {{ optional(data_get($attendance,'break_started_at'))->format('H:i') ?? '' }}
              </span>
              <span class="att-tilde">〜</span>
              <span class="att-read att-read--sm">
                {{ optional(data_get($attendance,'break_ended_at'))->format('H:i') ?? '' }}
              </span>
            </div>
          </td>
        </tr>

        <tr>
          <th>休憩2</th>
          <td>
            <div class="att-split">
              <span class="att-read att-read--sm">
                {{ optional(data_get($attendance,'break2_started_at'))->format('H:i') ?? '' }}
              </span>
              <span class="att-tilde">〜</span>
              <span class="att-read att-read--sm">
                {{ optional(data_get($attendance,'break2_ended_at'))->format('H:i') ?? '' }}
              </span>
            </div>
          </td>
        </tr>

        <tr>
          <th>備考</th>
          <td>
            <span class="att-read att-read--lg">
              {{ optional($attendance)->note ?? '' }}
            </span>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="att-detail__actions">
      <button type="button" class="btn btn-primary">修正</button>
    </div>
  </div>
</div>
@endsection
