@extends('layout')
@section('content')
<h1>申請詳細</h1>
<p>対象ユーザー: {{ $requestData->attendance->user->name }}</p>
<p>出勤: {{ optional($requestData->requested_clock_in_at)->format('Y-m-d H:i') }}</p>
<p>退勤: {{ optional($requestData->requested_clock_out_at)->format('Y-m-d H:i') }}</p>
<p>備考: {{ $requestData->note }}</p>
@if(auth()->user()->is_admin && $requestData->status === 'pending')
<form method="POST" action="{{ route('request.approve',$requestData) }}">@csrf<button>承認</button></form>
@endif
@endsection
