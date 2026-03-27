@extends('layout')
@section('content')
<h1>勤怠一覧 {{ $month }}</h1>
<a href="?month={{ \Carbon\Carbon::createFromFormat('Y-m',$month)->subMonth()->format('Y-m') }}">前月</a>
<a href="?month={{ \Carbon\Carbon::createFromFormat('Y-m',$month)->addMonth()->format('Y-m') }}">翌月</a>
<table border="1"><tr><th>日付</th><th>出勤</th><th>退勤</th><th>詳細</th></tr>
@foreach($attendances as $attendance)
<tr>
<td>{{ $attendance->work_date->format('Y-m-d') }}</td>
<td>{{ optional($attendance->clock_in_at)->format('H:i') }}</td>
<td>{{ optional($attendance->clock_out_at)->format('H:i') }}</td>
<td><a href="{{ route('attendance.detail',$attendance) }}">詳細</a></td>
</tr>
@endforeach
</table>
@endsection
