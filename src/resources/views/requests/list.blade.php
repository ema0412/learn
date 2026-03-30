@extends('layout')

@section('content')
<div class="mx-auto w-full max-w-[760px]">
    <h1 class="mb-6 border-l-8 border-black pl-4 text-4xl font-bold">申請一覧</h1>

    <div class="mb-4 border-b border-gray-300">
        <a href="?status=pending" class="inline-block px-4 py-2 text-lg font-bold {{ $status === 'pending' ? 'border-b-2 border-black text-black' : 'text-gray-500' }}">承認待ち</a>
        <a href="?status=approved" class="ml-4 inline-block px-4 py-2 text-lg font-bold {{ $status === 'approved' ? 'border-b-2 border-black text-black' : 'text-gray-500' }}">承認済み</a>
    </div>

    <div class="overflow-hidden rounded-lg bg-white">
        <table class="w-full table-fixed text-center text-sm">
            <thead class="border-b border-gray-300 text-gray-500">
                <tr class="h-11"><th>状態</th><th>名前</th><th>対象日時</th><th>申請理由</th><th>申請日時</th><th>詳細</th></tr>
            </thead>
            <tbody>
            @foreach($requests as $requestItem)
                <tr class="h-11 border-b border-gray-200 text-gray-700">
                    <td>{{ $requestItem->status === 'pending' ? '承認待ち' : '承認済み' }}</td>
                    <td>{{ $requestItem->attendance->user->name }}</td>
                    <td>{{ $requestItem->attendance->work_date->format('Y/m/d') }}</td>
                    <td class="truncate px-2 text-left">{{ $requestItem->note }}</td>
                    <td>{{ $requestItem->created_at->format('Y/m/d') }}</td>
                    <td><a href="{{ route('request.detail',$requestItem) }}" class="font-bold text-black">詳細</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
