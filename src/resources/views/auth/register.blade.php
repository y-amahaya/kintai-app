@extends('layouts.guest')

@section('content')
<div class="auth-container">
    <h2 class="auth-title">会員登録</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label for="name">ユーザー名</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}">
        @error('name')<div class="error">{{ $message }}</div>@enderror

        <label for="email">メールアドレス</label>
        <input id="email" type="text" name="email" value="{{ old('email') }}">
        @error('email')<div class="error">{{ $message }}</div>@enderror

        <label for="password">パスワード</label>
        <input id="password" type="password" name="password">
        @error('password')<div class="error">{{ $message }}</div>@enderror

        <label for="password_confirmation">パスワード確認</label>
        <input id="password_confirmation" type="password" name="password_confirmation">
        @error('password_confirmation')<div class="error">{{ $message }}</div>@enderror

        <button type="submit">登録する</button>

        <div class="auth-footer">
            <a href="{{ route('login') }}">ログインはこちら</a>
        </div>
    </form>
</div>
@endsection
