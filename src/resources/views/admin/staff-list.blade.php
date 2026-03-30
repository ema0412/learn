@extends('layout')
@section('content')
<h1>スタッフ一覧</h1>
<ul>
@foreach($users as $user)
<li>{{ $user->name }} ({{ $user->email }}) <a href="{{ route('admin.staff.attendance',$user) }}">詳細</a></li>
@endforeach
</ul>
@endsection
