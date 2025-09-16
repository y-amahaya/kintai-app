@extends('layouts.admin')

@section('content')
<div class="att-list">
    <h1 class="page-title">スタッフ一覧</h1>

    @if($users->count())
        <div class="att-table-wrap">
            <table class="att-table">
                <thead>
                    <tr>
                        <th>名前</th>
                        <th>メールアドレス</th>
                        <th class="col-action">月次勤怠</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="txt-center">{{ $user->name }}</td>
                        <td class="txt-center">{{ $user->email }}</td>
                        <td class="txt-center">
                            <a class="link" href="{{ route('admin.staff.attendance.show', ['id' => $user->id]) }}">詳細</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="att-list__empty">スタッフが登録されていません。</p>
    @endif
</div>
@endsection
