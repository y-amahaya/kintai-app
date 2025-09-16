@extends('layouts.admin')

@section('content')
  <div class="att-detail">
    <h1 class="page-title">勤怠詳細</h1>

    <div class="att-card">
      <table class="att-detail-table">
        <tbody>
          <tr>
            <th>名前</th>
            <td>{{ $name }}</td>
          </tr>

          <tr>
            <th>日付</th>
            <td>
              <div class="att-split">
                <span class="att-read att-read--md">{{ $yearLabel }}</span>
                <span class="att-read att-read--md">{{ $monthDay }}</span>
              </div>
            </td>
          </tr>

          <tr>
            <th>出勤・退勤</th>
            <td>
              <div class="att-split">
                <span class="att-read att-read--sm">{{ $inTime }}</span>
                <span class="att-tilde">〜</span>
                <span class="att-read att-read--sm">{{ $outTime }}</span>
              </div>
            </td>
          </tr>

          <tr>
            <th>休憩</th>
            <td>
              <div class="att-split">
                <span class="att-read att-read--sm">{{ $break1Start }}</span>
                <span class="att-tilde">〜</span>
                <span class="att-read att-read--sm">{{ $break1End }}</span>
              </div>
            </td>
          </tr>

          <tr>
            <th>休憩2</th>
            <td>
              <div class="att-split">
                <span class="att-read att-read--sm">{{ $break2Start }}</span>
                <span class="att-tilde">〜</span>
                <span class="att-read att-read--sm">{{ $break2End }}</span>
              </div>
            </td>
          </tr>

          <tr>
            <th>備考</th>
            <td>
              <span class="att-read att-read--lg">{{ $note }}</span>
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
