@extends('layout')

@section('content')
<div class="mx-auto flex min-h-[360px] w-full max-w-[720px] flex-col items-center justify-center">
    <p class="mb-8 text-center text-base font-semibold leading-8 text-[#222]">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </p>

    <a href="{{ route('verification.mailhog') }}" target="_blank" rel="noopener noreferrer" class="rounded border border-[#8e8e8e] bg-[#d9d9d9] px-10 py-3 text-xl font-bold text-[#222] shadow-sm transition hover:opacity-90">
        認証はこちらから
    </a>

    <form method="POST" action="{{ route('verification.send') }}" class="mt-10">
        @csrf
        <button class="text-base font-medium text-[#2b63d9] hover:underline">認証メールを再送する</button>
    </form>
</div>
@endsection
