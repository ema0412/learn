@extends('layout')

@section('content')
@php
    $isAdminLogin = request()->routeIs('admin.login');
@endphp

<div class="mx-auto w-full max-w-[460px] pt-10">
    <h1 class="mb-8 text-center text-base font-bold">{{ $isAdminLogin ? '管理者ログイン' : 'ログイン' }}</h1>

    <form method="POST" action="/login" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="mb-1 block text-[10px] font-semibold">メールアドレス</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" class="h-7 w-full border border-[#cfcfd4] bg-white px-2 text-xs">
        </div>

        <div>
            <label for="password" class="mb-1 block text-[10px] font-semibold">パスワード</label>
            <input id="password" type="password" name="password" class="h-7 w-full border border-[#cfcfd4] bg-white px-2 text-xs">
        </div>

        <button class="h-7 w-full bg-black text-[10px] font-bold text-white">
            {{ $isAdminLogin ? '管理者ログインする' : 'ログインする' }}
        </button>
    </form>

    @unless($isAdminLogin)
        <a href="/register" class="mt-4 block text-center text-[9px] text-[#2a57d6] underline">会員登録はこちら</a>
    @endunless
</div>
@endsection
