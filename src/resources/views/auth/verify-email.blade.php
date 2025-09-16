@extends('layouts.guest')

@section('content')
<div class="auth-container">

    <p style="text-align: center; margin-bottom: 30px;">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </p>

    <a href="http://localhost:8025"target="_blank"class="verify-button">
        認証はこちらから
    </a>

    <div style="text-align: center; margin-top: 15px;">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="resend-link">
                認証メールを再送する
            </button>
        </form>
    </div>
</div>
@endsection
