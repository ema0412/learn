@extends('layout')
@section('content')
<h1>勤怠詳細</h1>
@if($pendingRequest)<p>承認待ちのため修正はできません。</p>@endif
<form method="POST" action="{{ route('attendance.update',$attendance) }}">@csrf
<label>出勤<input type="datetime-local" name="clock_in_at" value="{{ old('clock_in_at', optional($attendance->clock_in_at)->format('Y-m-d\\TH:i')) }}" @if($pendingRequest) disabled @endif></label><br>
<label>退勤<input type="datetime-local" name="clock_out_at" value="{{ old('clock_out_at', optional($attendance->clock_out_at)->format('Y-m-d\\TH:i')) }}" @if($pendingRequest) disabled @endif></label><br>
@foreach($attendance->breaks as $i => $break)
<div>
<input type="datetime-local" name="breaks[{{ $i }}][started_at]" value="{{ optional($break->started_at)->format('Y-m-d\\TH:i') }}" @if($pendingRequest) disabled @endif>
<input type="datetime-local" name="breaks[{{ $i }}][ended_at]" value="{{ optional($break->ended_at)->format('Y-m-d\\TH:i') }}" @if($pendingRequest) disabled @endif>
</div>
@endforeach
<div>
<input type="datetime-local" name="breaks[{{ count($attendance->breaks) }}][started_at]" @if($pendingRequest) disabled @endif>
<input type="datetime-local" name="breaks[{{ count($attendance->breaks) }}][ended_at]" @if($pendingRequest) disabled @endif>
</div>
<textarea name="note" @if($pendingRequest) disabled @endif>{{ old('note', $attendance->note) }}</textarea><br>
<button @if($pendingRequest) disabled @endif>修正</button>
</form>
@endsection
