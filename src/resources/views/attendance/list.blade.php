@extends('layout')

@section('content')
@php
    $current = \Carbon\Carbon::createFromFormat('Y-m', $month);
@endphp

<div class="mx-auto w-full max-w-[640px]">
    <h1 class="mb-4 border-l-4 border-black pl-3 text-sm font-bold">勤怠一覧</h1>

    <div class="mb-3 flex items-center justify-between rounded bg-white px-4 py-2 text-[11px] font-semibold text-[#5f5f66]">
        <a href="?month={{ $current->copy()->subMonth()->format('Y-m') }}" class="hover:opacity-80">← 前月</a>
        <div>{{ $current->format('Y/m') }}</div>
        <a href="?month={{ $current->copy()->addMonth()->format('Y-m') }}" class="hover:opacity-80">翌月 →</a>
    </div>

    <div class="overflow-hidden rounded bg-white">
        <table class="w-full text-center text-[10px] sm:text-[11px]">
            <thead class="h-8 border-b border-[#ebebef] text-[#7a7a81]">
            <tr>
                <th>日付</th><th>出勤</th><th>退勤</th><th>休憩</th><th>合計</th><th>詳細</th>
            </tr>
            </thead>
            <tbody>
            @foreach($attendances as $attendance)
                @php
                    $breakMinutes = $attendance->breaks->sum(fn($break) => $break->started_at && $break->ended_at ? $break->started_at->diffInMinutes($break->ended_at) : 0);
                    $workMinutes = $attendance->clock_in_at && $attendance->clock_out_at ? max($attendance->clock_in_at->diffInMinutes($attendance->clock_out_at) - $breakMinutes, 0) : 0;
                @endphp
                <tr class="h-8 border-b border-[#f0f0f3] text-[#3e3e45]">
                    <td>{{ $attendance->work_date->format('m/d') }}</td>
                    <td>{{ optional($attendance->clock_in_at)->format('H:i') }}</td>
                    <td>{{ optional($attendance->clock_out_at)->format('H:i') }}</td>
                    <td>{{ sprintf('%d:%02d', intdiv($breakMinutes, 60), $breakMinutes % 60) }}</td>
                    <td>{{ sprintf('%d:%02d', intdiv($workMinutes, 60), $workMinutes % 60) }}</td>
                    <td><a href="{{ route('attendance.detail',$attendance) }}" class="font-bold">詳細</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
