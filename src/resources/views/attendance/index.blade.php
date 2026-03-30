@extends('layout')
@section('content')
<h1>勤怠登録画面</h1>
<p>{{ $now->format('Y-m-d H:i') }}</p>
<p>ステータス: {{ ['off'=>'勤務外','working'=>'出勤中','on_break'=>'休憩中','done'=>'退勤済'][$attendance->status] ?? $attendance->status }}</p>
@if($attendance->status === 'off')
<form method="POST" action="{{ route('attendance.clock-in') }}">@csrf<button>出勤</button></form>
@endif
@if($attendance->status === 'working')
<form method="POST" action="{{ route('attendance.break-start') }}">@csrf<button>休憩入</button></form>
<form method="POST" action="{{ route('attendance.clock-out') }}">@csrf<button>退勤</button></form>
@endif
@if($attendance->status === 'on_break')
<form method="POST" action="{{ route('attendance.break-end') }}">@csrf<button>休憩戻</button></form>
@endif
@endsection
