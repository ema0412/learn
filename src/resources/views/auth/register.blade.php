@extends('layout')
@section('content')
<h1>会員登録</h1>
<form method="POST" action="/register">@csrf
<input name="name" placeholder="名前" value="{{ old('name') }}"><br>
<input name="email" placeholder="メール" value="{{ old('email') }}"><br>
<input type="password" name="password" placeholder="パスワード"><br>
<input type="password" name="password_confirmation" placeholder="確認用パスワード"><br>
<button>登録</button>
</form>
<a href="/login">ログイン画面へ</a>
@endsection
