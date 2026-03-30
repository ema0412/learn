@extends('layout')

@section('content')
<div class="mx-auto w-full max-w-[760px]">
    <h1 class="mb-8 border-l-8 border-black pl-4 text-4xl font-bold">{{ auth()->user()->is_admin ? '修正申請承認' : '申請詳細' }}</h1>

    <div class="overflow-hidden rounded-lg bg-white">
        <table class="w-full text-base">
            <tr class="border-b border-gray-200"><th class="w-1/3 px-8 py-4 text-left text-gray-500">名前</th><td class="px-8 py-4 font-bold">{{ $requestData->attendance->user->name }}</td></tr>
            <tr class="border-b border-gray-200"><th class="px-8 py-4 text-left text-gray-500">対象日</th><td class="px-8 py-4 font-bold">{{ $requestData->attendance->work_date->format('Y年n月j日') }}</td></tr>
            <tr class="border-b border-gray-200"><th class="px-8 py-4 text-left text-gray-500">出勤・退勤</th><td class="px-8 py-4">{{ optional($requestData->requested_clock_in_at)->format('H:i') }} 〜 {{ optional($requestData->requested_clock_out_at)->format('H:i') }}</td></tr>
            <tr><th class="px-8 py-4 text-left text-gray-500">備考</th><td class="px-8 py-4">{{ $requestData->note }}</td></tr>
        </table>
    </div>

    <div class="mt-6 text-right">
        @if(auth()->user()->is_admin)
            @if($requestData->status === 'pending')
                <form method="POST" action="{{ route('request.approve',$requestData) }}" class="inline">@csrf
                    <button class="inline-flex h-10 items-center rounded bg-black px-6 text-sm font-bold text-white">承認</button>
                </form>
            @else
                <button class="inline-flex h-10 cursor-not-allowed items-center rounded bg-gray-500 px-6 text-sm font-bold text-white" disabled>承認済み</button>
            @endif
        @endif
    </div>
</div>
@endsection
