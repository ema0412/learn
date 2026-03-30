@extends('layout')

@section('content')
<div class="mx-auto w-full max-w-[640px]">
    <h1 class="mb-4 border-l-4 border-black pl-3 text-sm font-bold">勤怠詳細</h1>

    <form method="POST" action="{{ route('attendance.update',$attendance) }}" class="space-y-4">
        @csrf

        <div class="overflow-hidden rounded bg-white">
            <table class="w-full text-[11px]">
                <tr class="border-b border-[#ececf1]">
                    <th class="w-[32%] px-5 py-3 text-left text-[#7c7c84]">名前</th>
                    <td class="px-5 py-3 font-semibold">{{ $attendance->user->name }}</td>
                </tr>
                <tr class="border-b border-[#ececf1]">
                    <th class="px-5 py-3 text-left text-[#7c7c84]">日付</th>
                    <td class="px-5 py-3 font-semibold">{{ $attendance->work_date->format('Y年') }}&nbsp;&nbsp;{{ $attendance->work_date->format('n月j日') }}</td>
                </tr>
                <tr class="border-b border-[#ececf1]">
                    <th class="px-5 py-3 text-left text-[#7c7c84]">出勤・退勤</th>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <input type="datetime-local" name="clock_in_at" value="{{ old('clock_in_at', optional($attendance->clock_in_at)->format('Y-m-d\\TH:i')) }}" @if($pendingRequest) disabled @endif class="h-7 rounded border border-[#d6d6dc] px-2 text-[10px] font-semibold">
                            <span>〜</span>
                            <input type="datetime-local" name="clock_out_at" value="{{ old('clock_out_at', optional($attendance->clock_out_at)->format('Y-m-d\\TH:i')) }}" @if($pendingRequest) disabled @endif class="h-7 rounded border border-[#d6d6dc] px-2 text-[10px] font-semibold">
                        </div>
                    </td>
                </tr>
                @foreach($attendance->breaks as $i => $break)
                    <tr class="border-b border-[#ececf1]">
                        <th class="px-5 py-3 text-left text-[#7c7c84]">休憩{{ $i > 0 ? $i + 1 : '' }}</th>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                <input type="datetime-local" name="breaks[{{ $i }}][started_at]" value="{{ optional($break->started_at)->format('Y-m-d\\TH:i') }}" @if($pendingRequest) disabled @endif class="h-7 rounded border border-[#d6d6dc] px-2 text-[10px]">
                                <span>〜</span>
                                <input type="datetime-local" name="breaks[{{ $i }}][ended_at]" value="{{ optional($break->ended_at)->format('Y-m-d\\TH:i') }}" @if($pendingRequest) disabled @endif class="h-7 rounded border border-[#d6d6dc] px-2 text-[10px]">
                            </div>
                        </td>
                    </tr>
                @endforeach
                <tr class="border-b border-[#ececf1]">
                    <th class="px-5 py-3 text-left text-[#7c7c84]">休憩{{ max(count($attendance->breaks) + 1, 2) }}</th>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <input type="datetime-local" name="breaks[{{ count($attendance->breaks) }}][started_at]" @if($pendingRequest) disabled @endif class="h-7 rounded border border-[#d6d6dc] px-2 text-[10px]">
                            <span>〜</span>
                            <input type="datetime-local" name="breaks[{{ count($attendance->breaks) }}][ended_at]" @if($pendingRequest) disabled @endif class="h-7 rounded border border-[#d6d6dc] px-2 text-[10px]">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="px-5 py-3 text-left text-[#7c7c84]">備考</th>
                    <td class="px-5 py-3">
                        <textarea name="note" @if($pendingRequest) disabled @endif class="h-16 w-full max-w-[340px] rounded border border-[#d6d6dc] p-2 text-[10px]">{{ old('note', $attendance->note) }}</textarea>
                    </td>
                </tr>
            </table>
        </div>

        @if($pendingRequest)
            <p class="text-right text-[10px] font-semibold text-[#ff6f6f]">*承認待ちのため修正はできません。</p>
        @else
            <div class="text-right">
                <button class="h-7 rounded bg-black px-5 text-[10px] font-bold text-white">修正</button>
            </div>
        @endif
    </form>
</div>
@endsection
