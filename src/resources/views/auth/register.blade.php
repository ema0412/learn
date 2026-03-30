@extends('layout')

@section('content')
<div class="mx-auto w-full max-w-[460px] pt-4">
    <h1 class="mb-8 text-center text-base font-bold">会員登録</h1>

    <form method="POST" action="/register" class="space-y-4">
        @csrf
        <div>
            <label for="name" class="mb-1 block text-[10px] font-semibold">名前</label>
            <input id="name" name="name" value="{{ old('name') }}" class="h-7 w-full border border-[#cfcfd4] bg-white px-2 text-xs">
        </div>

        <div>
            <label for="email" class="mb-1 block text-[10px] font-semibold">メールアドレス</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" class="h-7 w-full border border-[#cfcfd4] bg-white px-2 text-xs">
        </div>

        <div>
            <label for="password" class="mb-1 block text-[10px] font-semibold">パスワード</label>
            <input id="password" type="password" name="password" class="h-7 w-full border border-[#cfcfd4] bg-white px-2 text-xs">
        </div>

        <div>
            <label for="password_confirmation" class="mb-1 block text-[10px] font-semibold">パスワード確認</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="h-7 w-full border border-[#cfcfd4] bg-white px-2 text-xs">
        </div>

        <button class="mt-2 h-7 w-full bg-black text-[10px] font-bold text-white">登録する</button>
    </form>

    <a href="/login" class="mt-3 block text-center text-[9px] text-[#2a57d6] underline">ログインはこちら</a>
</div>
@endsection
