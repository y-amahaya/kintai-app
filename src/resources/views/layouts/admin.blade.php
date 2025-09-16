<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理アプリ</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/corrections.css') }}">
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
</head>
<body>
    <header class="header">
        <img src="{{ asset('images/logo.svg') }}" alt="COACHTECH" class="site-logo">

        <nav class="nav-links">
            @auth
                <a href="{{ route('admin.attendance.index') }}">勤怠一覧</a>
                <a href="{{ route('admin.users.index') }}">スタッフ一覧</a>
                <a href="{{ route('admin.requests.index') }}">申請一覧</a>
                <a href="{{ route('admin.login') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    ログアウト
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endauth
        </nav>
    </header>

    @yield('content')
</body>
</html>
