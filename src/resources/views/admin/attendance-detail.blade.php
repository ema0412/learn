@extends('layout')
@section('content')
<h1>管理者 勤怠詳細</h1>
<form method="POST" action="{{ route('admin.attendance.update',$attendance) }}">@csrf
<input type="datetime-local" name="clock_in_at" value="{{ optional($attendance->clock_in_at)->format('Y-m-d\\TH:i') }}"><br>
<input type="datetime-local" name="clock_out_at" value="{{ optional($attendance->clock_out_at)->format('Y-m-d\\TH:i') }}"><br>
<textarea name="note">{{ $attendance->note }}</textarea><br>
<button>修正</button>
</form>
@endsection
