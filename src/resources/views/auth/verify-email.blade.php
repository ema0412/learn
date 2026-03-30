@extends('layout')

@section('content')
<div class="mx-auto flex min-h-[300px] w-full max-w-[520px] flex-col items-center justify-center">
    <p class="mb-6 text-center text-[10px] font-semibold leading-6 sm:text-xs">登録していただいたメールアドレスに認証メールを送付しました。<br>メール認証を完了してください。</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="h-7 rounded border border-[#cfcfd4] bg-white px-4 text-[10px] font-semibold">認証メールを再送する</button>
    </form>

    <a href="{{ route('verification.notice') }}" class="mt-4 text-[9px] text-[#2a57d6] underline">メールが届かない場合はこちら</a>
</div>
@endsection
