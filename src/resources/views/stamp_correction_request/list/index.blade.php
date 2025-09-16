@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endpush

@section('content')
<div class="cor-list">
    <h1 class="page-title">申請一覧</h1>

    <div class="cor-tabs">
        <a class="cor-tab {{ $activeTab === 'pending'  ? 'is-active' : '' }}"
            href="{{ route('corrections.index', ['status' => 'pending']) }}">承認待ち</a>
        <a class="cor-tab {{ $activeTab === 'approved' ? 'is-active' : '' }}"
            href="{{ route('corrections.index', ['status' => 'approved']) }}">承認済み</a>
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
            @forelse ($requests as $req)
                <tr>
                    <td>
                        <span class="badge">
                            {{ $req->status === 'approved' ? '承認済'
                                : ($req->status === 'rejected' ? '却下' : '承認待ち') }}
                        </span>
                    </td>

                    <td>{{ $req->applicant->name ?? '—' }}</td>

                    <td>
                        {{ optional($req->target_date ?: $req->target_at)->format('Y/m/d') }}
                    </td>

                    <td class="reason">{{ $req->reason }}</td>

                    <td>
                        {{ optional($req->applied_at ?: $req->created_at)->format('Y/m/d') }}
                    </td>

                    <td>
                        <a class="link-detail"
                            href="{{ route('corrections.show', ['correction' => $req->id]) }}">詳細</a>
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

    <div class="pagination">
        {{ $requests->appends(['status' => $activeTab])->links() }}
    </div>
</div>
@endsection
