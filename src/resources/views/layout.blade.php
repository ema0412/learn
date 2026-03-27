<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理</title>
    <style>body{font-family:sans-serif;max-width:1000px;margin:20px auto;padding:0 16px} nav a,nav form{display:inline-block;margin-right:10px} .error{color:#d00}</style>
</head>
<body>
<nav>
    @auth
        <a href="{{ route('attendance.index') }}">勤怠登録</a>
        <a href="{{ route('attendance.list') }}">勤怠一覧</a>
        <a href="{{ route('request.list') }}">申請一覧</a>
        @if(auth()->user()->is_admin)
            <a href="{{ route('admin.attendance.list') }}">管理者勤怠</a>
            <a href="{{ route('admin.staff.list') }}">スタッフ一覧</a>
        @endif
        <form action="{{ route('logout') }}" method="POST">@csrf<button>ログアウト</button></form>
    @endauth
</nav>
@if(session('message'))<p>{{ session('message') }}</p>@endif
@foreach($errors->all() as $error)
    <p class="error">{{ $error }}</p>
@endforeach
@yield('content')
</body>
</html>
