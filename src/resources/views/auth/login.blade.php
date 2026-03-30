@extends('layout')

@section('content')
@php
    $isAdminLogin = request()->routeIs('admin.login');
@endphp

<div class="mx-auto mt-10 w-full max-w-[640px]">
    <h1 class="mb-12 text-center text-4xl font-bold">{{ $isAdminLogin ? '管理者ログイン' : 'ログイン' }}</h1>

    <form method="POST" action="/login" class="space-y-10">@csrf
        <div>
            <label for="email" class="mb-2 block text-3xl font-bold">メールアドレス</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" class="h-14 w-full rounded border border-gray-400 bg-white px-4 text-xl">
        </div>

        <div>
            <label for="password" class="mb-2 block text-3xl font-bold">パスワード</label>
            <input id="password" type="password" name="password" class="h-14 w-full rounded border border-gray-400 bg-white px-4 text-xl">
        </div>

        <button class="mt-4 h-14 w-full rounded bg-black text-3xl font-bold text-white hover:opacity-90">
            {{ $isAdminLogin ? '管理者ログインする' : 'ログインする' }}
        </button>
    </form>

    @unless($isAdminLogin)
        <a href="/register" class="mt-6 block text-right text-blue-600 underline">会員登録画面へ</a>
    @endunless
</div>
@endsection
