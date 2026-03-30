<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#e5e5e8] text-[#1f1f1f]">
<header class="h-16 bg-black">
    <div class="mx-auto flex h-full w-full max-w-[1200px] items-center justify-between px-4 sm:px-8">
        <div class="text-4xl font-black italic tracking-tight text-white leading-none">COACHTECH</div>
        @auth
            <nav class="hidden items-center gap-8 text-lg font-bold text-white md:flex">
                @if(auth()->user()->is_admin)
                    <a class="hover:opacity-80" href="{{ route('admin.attendance.list') }}">勤怠一覧</a>
                    <a class="hover:opacity-80" href="{{ route('admin.staff.list') }}">スタッフ一覧</a>
                    <a class="hover:opacity-80" href="{{ route('request.list') }}">申請一覧</a>
                @else
                    <a class="hover:opacity-80" href="{{ route('attendance.index') }}">勤怠</a>
                    <a class="hover:opacity-80" href="{{ route('attendance.list') }}">勤怠一覧</a>
                    <a class="hover:opacity-80" href="{{ route('request.list') }}">申請一覧</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="inline">@csrf<button class="hover:opacity-80">ログアウト</button></form>
            </nav>
        @endauth
    </div>
</header>

<main class="mx-auto w-full max-w-[1200px] px-4 py-10 sm:px-8">
    @if(session('message'))
        <p class="mb-4 rounded bg-emerald-100 px-4 py-2 text-sm text-emerald-800">{{ session('message') }}</p>
    @endif

    @if($errors->any())
        <div class="mb-4 rounded bg-rose-100 px-4 py-2 text-sm text-rose-700">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>
