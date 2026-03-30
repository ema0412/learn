@extends('layout')
@section('content')
<h1>ログイン</h1>
<form method="POST" action="/login">@csrf
<input name="email" placeholder="メール" value="{{ old('email') }}"><br>
<input type="password" name="password" placeholder="パスワード"><br>
<button>ログイン</button>
</form>
<a href="/register">会員登録画面へ</a>
@endsection
