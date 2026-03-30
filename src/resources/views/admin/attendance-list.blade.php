@extends('layout')

@section('content')
<div class="mx-auto w-full max-w-[760px]">
    <h1 class="mb-8 border-l-8 border-black pl-4 text-4xl font-bold">{{ \Carbon\Carbon::parse($date)->format('Y年n月j日') }}の勤怠</h1>

    <div class="mb-8 flex items-center justify-between rounded-lg bg-white px-6 py-4 text-xl font-bold text-gray-700">
        <a href="?date={{ \Carbon\Carbon::parse($date)->subDay()->toDateString() }}" class="hover:opacity-70">← 前日</a>
        <div>{{ \Carbon\Carbon::parse($date)->format('Y/m/d') }}</div>
        <a href="?date={{ \Carbon\Carbon::parse($date)->addDay()->toDateString() }}" class="hover:opacity-70">翌日 →</a>
    </div>

    <div class="overflow-hidden rounded-lg bg-white">
        <table class="w-full table-fixed text-center text-lg">
            <thead class="border-b border-gray-300 text-gray-500">
            <tr class="h-12">
                <th>名前</th><th>出勤</th><th>退勤</th><th>休憩</th><th>合計</th><th>詳細</th>
            </tr>
            </thead>
            <tbody>
            @foreach($attendances as $attendance)
                @php
                    $breakMinutes = $attendance->breaks->sum(fn($break) => $break->started_at && $break->ended_at ? $break->started_at->diffInMinutes($break->ended_at) : 0);
                    $workMinutes = $attendance->clock_in_at && $attendance->clock_out_at ? $attendance->clock_in_at->diffInMinutes($attendance->clock_out_at) - $breakMinutes : 0;
                @endphp
                <tr class="h-12 border-b border-gray-200 text-gray-700">
                    <td>{{ $attendance->user->name }}</td>
                    <td>{{ optional($attendance->clock_in_at)->format('H:i') }}</td>
                    <td>{{ optional($attendance->clock_out_at)->format('H:i') }}</td>
                    <td>{{ sprintf('%d:%02d', intdiv($breakMinutes, 60), $breakMinutes % 60) }}</td>
                    <td>{{ sprintf('%d:%02d', intdiv(max($workMinutes, 0), 60), max($workMinutes, 0) % 60) }}</td>
                    <td><a href="{{ route('admin.attendance.detail',$attendance) }}" class="font-bold text-black">詳細</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
