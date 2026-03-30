@extends('layout')

@section('content')
<div class="mx-auto w-full max-w-[760px]">
    <h1 class="mb-8 border-l-8 border-black pl-4 text-4xl font-bold">勤怠詳細</h1>

    <form method="POST" action="{{ route('admin.attendance.update',$attendance) }}" class="space-y-8">
        @csrf
        <div class="overflow-hidden rounded-lg bg-white">
            <table class="w-full text-lg">
                <tr class="border-b border-gray-200"><th class="w-1/3 px-8 py-4 text-left text-gray-500">名前</th><td class="px-8 py-4 font-bold">{{ $attendance->user->name }}</td></tr>
                <tr class="border-b border-gray-200"><th class="px-8 py-4 text-left text-gray-500">日付</th><td class="px-8 py-4 font-bold">{{ $attendance->work_date->format('Y年') }}　　 {{ $attendance->work_date->format('n月j日') }}</td></tr>
                <tr class="border-b border-gray-200">
                    <th class="px-8 py-4 text-left text-gray-500">出勤・退勤</th>
                    <td class="px-8 py-4">
                        <div class="flex items-center gap-4">
                            <input type="datetime-local" name="clock_in_at" value="{{ optional($attendance->clock_in_at)->format('Y-m-d\TH:i') }}" class="h-10 w-28 rounded border border-gray-300 px-2 font-semibold">
                            <span>〜</span>
                            <input type="datetime-local" name="clock_out_at" value="{{ optional($attendance->clock_out_at)->format('Y-m-d\TH:i') }}" class="h-10 w-28 rounded border border-gray-300 px-2 font-semibold">
                        </div>
                    </td>
                </tr>
                @for($i = 0; $i < 2; $i++)
                    @php $break = $attendance->breaks[$i] ?? null; @endphp
                    <tr class="border-b border-gray-200">
                        <th class="px-8 py-4 text-left text-gray-500">休憩{{ $i === 0 ? '' : '2' }}</th>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <input type="datetime-local" name="breaks[{{ $i }}][started_at]" value="{{ optional(optional($break)->started_at)->format('Y-m-d\TH:i') }}" class="h-10 w-28 rounded border border-gray-300 px-2">
                                <span>〜</span>
                                <input type="datetime-local" name="breaks[{{ $i }}][ended_at]" value="{{ optional(optional($break)->ended_at)->format('Y-m-d\TH:i') }}" class="h-10 w-28 rounded border border-gray-300 px-2">
                            </div>
                        </td>
                    </tr>
                @endfor
                <tr>
                    <th class="px-8 py-4 text-left text-gray-500">備考</th>
                    <td class="px-8 py-4"><textarea name="note" class="h-16 w-full max-w-[360px] rounded border border-gray-300 p-2">{{ $attendance->note }}</textarea></td>
                </tr>
            </table>
        </div>

        <div class="text-right">
            <button class="h-10 rounded bg-black px-8 text-lg font-bold text-white">修正</button>
        </div>
    </form>
</div>
@endsection
