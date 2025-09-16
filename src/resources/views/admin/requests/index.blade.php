@extends('layouts.admin')

@push('styles')
    {{-- 一般ユーザと同じCSSを共用 --}}
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endpush

@section('content')
<div class="cor-list">
    <h1 class="page-title">申請一覧</h1>

    {{-- タブ（statusクエリで切替） --}}
    <div class="cor-tabs">
        <a class="cor-tab {{ $activeTab === 'pending' ? 'is-active' : '' }}"
            href="{{ route('admin.requests.index', ['status' => 'pending']) }}">承認待ち</a>
        <a class="cor-tab {{ $activeTab === 'approved' ? 'is-active' : '' }}"
            href="{{ route('admin.requests.index', ['status' => 'approved']) }}">承認済み</a>
    </div>

    <div class="cor-table-wrap">
        <table class="cor-table">
            <thead>
            <tr>
                <th>状態</th>
                <th>名前</th>
                <th>対象日時</th>
                <th>申請理由</th>
                <th>申請日時</th>
                <th>詳細</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($requests as $row)
                <tr>
                    <td><span class="badge">{{ $row['status_label'] }}</span></td>
                    <td>{{ $row['user_name'] }}</td>
                    <td>{{ $row['target_date'] }}</td>
                    <td class="reason">{{ $row['reason'] }}</td>
                    <td>{{ $row['applied_at'] }}</td>
                    <td>
                        <a class="link-detail"
                            href="{{ route('admin.requests.show', ['correction' => $row['id']]) }}">詳細</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="is-empty" colspan="6">該当する申請はありません。</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
