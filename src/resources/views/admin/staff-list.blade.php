@extends('layout')

@section('content')
<div class="mx-auto w-full max-w-[760px]">
    <h1 class="mb-8 border-l-8 border-black pl-4 text-4xl font-bold">スタッフ一覧</h1>

    <div class="overflow-hidden rounded-lg bg-white">
        <table class="w-full table-fixed text-center text-base">
            <thead class="border-b border-gray-300 text-gray-500">
                <tr class="h-11"><th>氏名</th><th>メールアドレス</th><th>月次勤怠</th></tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="h-11 border-b border-gray-200 text-gray-700">
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><a href="{{ route('admin.staff.attendance',$user) }}" class="font-bold text-black">詳細</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
