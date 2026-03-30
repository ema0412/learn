@extends('layout')

@section('content')
@php
    $weekday = ['日', '月', '火', '水', '木', '金', '土'][$now->dayOfWeek];
    $statusLabel = [
        'off' => '勤務外',
        'working' => '出勤中',
        'on_break' => '休憩中',
        'done' => '退勤済',
    ][$attendance->status] ?? $attendance->status;
@endphp

<div class="mx-auto flex min-h-[360px] w-full max-w-[520px] flex-col items-center justify-center">
    <p class="mb-4 rounded-full border border-[#d7d7dd] bg-[#ececf1] px-4 py-1 text-[10px] font-semibold text-[#6f6f75]">{{ $statusLabel }}</p>
    <p class="text-xs">{{ $now->format('Y年n月j日') }}({{ $weekday }})</p>
    <p class="mt-1 text-[42px] font-bold leading-none tracking-wide">{{ $now->format('H:i') }}</p>

    <div class="mt-6 flex items-center gap-3">
        @if($attendance->status === 'off')
            <form method="POST" action="{{ route('attendance.clock-in') }}">@csrf<button class="h-7 min-w-[76px] rounded bg-black px-4 text-[10px] font-bold text-white">出勤</button></form>
        @endif

        @if($attendance->status === 'working')
            <form method="POST" action="{{ route('attendance.clock-out') }}">@csrf<button class="h-7 min-w-[76px] rounded bg-black px-4 text-[10px] font-bold text-white">退勤</button></form>
            <form method="POST" action="{{ route('attendance.break-start') }}">@csrf<button class="h-7 min-w-[76px] rounded bg-white px-4 text-[10px] font-bold text-[#2f2f34]">休憩入</button></form>
        @endif

        @if($attendance->status === 'on_break')
            <form method="POST" action="{{ route('attendance.break-end') }}">@csrf<button class="h-7 min-w-[76px] rounded bg-white px-4 text-[10px] font-bold text-[#2f2f34]">休憩戻</button></form>
        @endif
    </div>

    @if($attendance->status === 'done')
        <p class="mt-6 text-[10px] font-semibold">お疲れ様でした。</p>
    @endif
</div>
@endsection
