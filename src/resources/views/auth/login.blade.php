@extends('layouts.guest')

@section('content')
<div class="auth-container">
    <h2 class="auth-title">ログイン</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf

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

        <button type="submit">ログインする</button>
    </form>

    <div class="auth-footer">
        <a href="{{ route('register') }}">会員登録はこちら</a>
    </div>
</div>
@endsection
