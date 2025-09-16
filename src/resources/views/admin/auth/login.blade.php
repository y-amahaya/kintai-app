@extends('layouts.guest')

@section('content')
<div class="auth-container">
    <h2 class="auth-title">管理者ログイン</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input type="hidden" name="is_admin_login" value="1">

        <label for="email">メールアドレス</label>
        <input id="email" type="text" name="email" value="{{ old('email') }}">
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password">パスワード</label>
        <input id="password" type="password" name="password">
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">管理者ログインする</button>
    </form>

</div>
@endsection
