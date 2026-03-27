@extends('layout')
@section('content')
<h1>管理者勤怠一覧 {{ $date }}</h1>
<a href="?date={{ \Carbon\Carbon::parse($date)->subDay()->toDateString() }}">前日</a>
<a href="?date={{ \Carbon\Carbon::parse($date)->addDay()->toDateString() }}">翌日</a>
<table border="1"><tr><th>氏名</th><th>出勤</th><th>退勤</th><th>詳細</th></tr>
@foreach($attendances as $attendance)
<tr><td>{{ $attendance->user->name }}</td><td>{{ optional($attendance->clock_in_at)->format('H:i') }}</td><td>{{ optional($attendance->clock_out_at)->format('H:i') }}</td><td><a href="{{ route('admin.attendance.detail',$attendance) }}">詳細</a></td></tr>
@endforeach
</table>
@endsection
